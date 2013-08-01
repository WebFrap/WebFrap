<?php

/**
 * Führt alle im Task angegebenen Aktionen in der vorgegebenenen Reihenfolge aus. Die einzelnen
 * Ergebnisse werden gesammelt und als ein Ergebnis in der Datenbank abgespeichert.
 * 
 * @author Johannes Dillmann
 */
class LibTask extends BaseChild {
   
   /**
    * Das Environment Objekt.
    * @var LibFlowApachemod
    */
   public $env = null;
   
   /**
    * Task der die einzelnen Aktionen enthält.
    * @var array
    */
   public $task = null;
   
   /**
    * Zeit zu der der Task gestartet wurde.
    * @var int
    */
   public $taskStart = null;
   
   /**
    * Alle Aktionen als JSON Objekt.
    * @var object
    */
   public $actions = null;
   
   /**
    * Nimmt die Meldungen der einzelnen Actions entgegen.
    * @var LibResponseCollector
    */
   public $response = null;
   
   /**
    * Enthält die Rückgabewerte der Einzelnen Aktionen nach folgendem Schema:
    * "Name der Action" => (true|false|null)
    * Falls eine Aktion gelaufen ist, ist ihr Rückgabewert <code>true</code> oder <code>false</code>, 
    * in jedem anderen Fall <code>null</code>.
    * @var array
    */
   public $results = array ();

   /**
    * Wird gesetzt wenn ein Rückgabewert erzwungen wird (z.B. mit setFailed)
    * @var boolean
    */
   public $hardStatus = null;

   /**
    * Konstruktor.
    * @param object $task
    * @param LibFlowApachemod $env
    */
   public function __construct($task, $env = null) {

      if ($env) {
         $this->env = $env;
      } else {
         $this->env = Webfrap::$env;
      }
      
      $this->task = $task;

      $this->taskStart = time();
            
      $this->actions = json_decode ( $task ['plan_actions'] );
      
      $this->response = new LibResponseCollector ();
   }

   /**
    * Führt alle Abschnitte der Aktionen der Reihe nach durch.
    */
   public function run() {

      foreach ( $this->actions as $action ) {
         
         $this->results ["$action->key"] = null;
         
         if (isset ( $action->constraint )) {
            $this->runActionConstraint ( $action );
         } else {
            $this->runAction ( $action );
         }
         
         if (isset ( $action->after )) {
            $this->runActionAfter ( $action );
         }
      }
      
      $this->updateStatus ();
   }

   /**
    * Stellt sicher, dass eine Aktionen nur dann ausgeführt wird, wenn die Vorraussetungen gegeben
    * sind.
    * @param object $action
    */
   public function runActionConstraint($action) {
      
      $parent = $action->constraint->parent->key;
      
      if (array_key_exists ( $parent, $this->results )) {
         
         $parentResult = $action->constraint->parent->on;
         
         if ($parentResult == "fail") {
            $parentResult = false;
         } elseif ($parentResult == "success") {
            $parentResult = true;
         }
         
         if ($this->results [$parent] == $parentResult) {
            $this->runAction ( $action );
         }
      }
   }

   /**
    * Führt alle Teile einer Aktion aus, die im "After" Teil angegeben sind.
    * @param object $action
    */
   public function runActionAfter($action) {
      
      if (isset ( $action->after->do )) {
         switch ($action->after->do) {
            case "break" :
               $this->hardStatus = ETaskStatus::FAILED;
               break;
            case "complete" :
               $this->hardStatus = ETaskStatus::COMPLETED;
               break;
            case "setFailed" :
               $result = true;
               $this->hardStatus = ETaskStatus::FAILED;
               break;
            default :
               $result = true;
               break;
         }
      }
      
      if (isset ( $action->after->success )) {
         if ($this->results ["$action->key"] == true) {
            switch ($action->after->success) {
               case "break" :
                  $result = false;
                  $this->hardStatus = ETaskStatus::FAILED;
                  break;
               case "complete" :
                  $this->hardStatus = ETaskStatus::COMPLETED;
                  break;
               case "setFailed" :
                  $result = true;
                  $this->hardStatus = ETaskStatus::FAILED;
                  break;
               default :
                  $result = true;
                  break;
            }
         }
         
         if (isset ( $action->after->fail )) {
            if ($this->results ["$action->key"] == false) {
               switch ($action->after->fail) {
                  case "break" :
                     $this->hardStatus = ETaskStatus::FAILED;
                     break;
                  case "complete" :
                     $this->hardStatus = ETaskStatus::COMPLETED;
                     break;
                  case "setFailed" :
                     $result = true;
                     $this->hardStatus = ETaskStatus::FAILED;
                     break;
                  default :
                     $result = true;
                     break;
               }
            }
         }
      }
   }

   /**
    * Schreibt die Ergebnisse des Tasks und der einzelnen Aktionen in die Datenbank.
    */
   public function updateStatus() {

      if (isset ( $this->hardStatus )) {
         $status = $this->hardStatus;
      } else {
         
         while ( ! is_null ( array_pop ( $this->results ) ) );
         
         $last = end ( $this->results );
         
         if ($last) {
            $status = ETaskStatus::COMPLETED;
         } else {
            $status = ETaskStatus::FAILED;
         }
      }
      
      $orm = $this->getOrm ();
      
      $taskId = $this->task ['task_id'];
      $taskVid = $this->task ['plan_id'];
      
      $taskPlan = $orm->get ( 'WbfsysTaskPlan', $taskVid );
            
      $logMessage = array (
            'title' => $taskPlan->title,
            'task_start' => date ( 'Y-m-d H:i:s', $this->taskStart ),
            'task_end' => date ( 'Y-m-d H:i:s', time() ),
            'id_plan' => $taskId,
            'status' => $status,
            'response' => json_encode ( $this->response ) 
      );
      
      $orm->insert ( 'WbfsysTaskLog', $logMessage );
      
      $orm->update ( 'WbfsysPlannedTask', $taskId, array (
            'status' => $status 
      ) );
   }

   /**
    * Führt die eigentliche Aktion aus.
    * @param object $action
    * @throws LibTaskplanner_Exception
    */
   public function runAction($action) {

      $className = $action->class . "_Action";
      
      $actionMethod = 'trigger_' . $action->method;
      
      $result = false;
      
      if (! Webfrap::classExists ( $className )) {
         throw new LibTaskplanner_Exception ( "Missing Action " . $className );
      }
      
      $actionClass = new $className ( Webfrap::$env );
      
      if (! method_exists ( $actionClass, $actionMethod )) {
         throw new LibTaskplanner_Exception ( "Missing requested method " . $actionMethod );
      }
      
      if (! isset ( $action->inf )) {
         $action->inf = 'plain';
      }
      
      $actionClass->setResponse ( $this->response );
      
      switch ($action->inf) {
         case 'plain' :
            $result = $actionClass->{$actionMethod} ();
            break;
         case 'entity' :
            $result = $actionClass->{$actionMethod} ( $action->params->id );
            break;
         case 'table' :
            $result = $actionClass->{$actionMethod} ( $action->params->name );
            break;
         case 'mask' :
            $result = $actionClass->{$actionMethod} ( $action->params->mask, $action->params->id );
            break;
         default :
            throw new LibTaskplanner_Exception ( "Unknown Interface " . $action->inf );
            break;
      }
      
      $this->results ["$action->key"] = $result;
   }
}