<?php
/*******************************************************************************
*
* @author      : Dominik Bonsch <dominik.bonsch@webfrap.net>
* @date        :
* @copyright   : Webfrap Developer Network <contact@webfrap.net>
* @project     : Webfrap Web Frame Application
* @projectUrl  : http://webfrap.net
*
* @licence     : BSD License see: LICENCE/BSD Licence.txt
*
* @version: @package_version@  Revision: @package_revision@
*
* Changes:
*
*******************************************************************************/

// Sicher stellen, dass nur Cms Controller aufgerufen werden können
if (! defined('WBF_CONTROLLER_PREFIX'))
  define('WBF_CONTROLLER_PREFIX', '');

/**
 * @lang de:
 *
 * Der Supercontroller der alle anderen Controller verwaltet, den Status den
 * Kompletten Systems speichert und die Benutzereingaben verarbeite.
 * Weiter liest der Supercontroller bei Systemstart die Systemkonfiguration aus.
 *
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @package WebFrap
 * @subpackage mvc
 */
class LibFlowTaskplanner extends LibFlow
{

  /**
   * Enthält alle gelaufenen Actions und ihren Rückgabewert
   *
   * @var array
   */
  public $index = array();

  /**
   * Wird von jeder gelaufenen Action überschrieben mit dem letzten Ergebnis.
   * Entweder ETaskStatus::COMPLETED oder ETaskStatus::FAILED
   *
   * @var ETaskStatus
  */
  public $softStatus = null;

  /**
   * Wird gesetzt, wenn ein bestimmter Status des Tasks erzwungen wird.
   * Entweder ETaskStatus::COMPLETED oder ETaskStatus::FAILED
   *
   * @var ETaskStatus
   */
  public $hardStatus = null;

  /**
   * Genau dann <code>true</code>, wenn eine einzelne Action gelaufen ist.
   *
   * @var boolean
   */
  public $isActionRun = false;
  
  /*//////////////////////////////////////////////////////////////////////////////
// Logic
//////////////////////////////////////////////////////////////////////////////*/
  
  /**
  *
  * @return void
  */
  public function init ()
  {

    $request = $this->getRequest();
    $response = $this->getResponse();
    $this->getSession();
    $this->getUser();
    
    $response->tpl = $this->getTplEngine();
    
    //make shure the system has language information
    /*
    if ($lang = $request->param('lang', Validator::CNAME)) {
      Conf::setStatus('lang',$lang);
      I18n::changeLang($lang  );
    }
    */
    
    ///TODO was machen wir hier?
    if (defined('MODE_MAINTENANCE')) {
      $map = array(
          Request::MOD => 'Maintenance', 
          Request::CON => 'Base', 
          Request::RUN => 'message'
      );
      $request->addParam($map);
      
      return;
    }
  } //end  public function init */

  
  /**
  * Hier gibts nur init
  * @return void
  */
  public function wakeup ()
  {

  } //end  public function wakeup */

  
  /**
  * the main method
  * @param LibRequestPhp $httpRequest
  * @param LibSessionPhp $session
  * @param Transaction $transaction
  * @param LibTaskplanner $taskPlanner
  * @return void
  */
  public function main ($httpRequest = null, $session = null, $transaction = null, $taskPlanner = null)
  {

    if (! isset($taskPlanner)) {
      $taskPlanner = new LibTaskplanner(Webfrap::$env, 1395846000);
      //$taskPlanner = new LibTaskplanner(Webfrap::$env);
    }
    
    $actionResponse = new LibResponseCollector();
    
    $tasks = $taskPlanner->tasks;
    
    if (isset($tasks)) {
      foreach ($tasks as $task) {
        
        // JSON Object
        $actions = json_decode($task['plan_actions']);
        
        // JSON für jeweils eine einzelne Aktion
        foreach ($actions as $action) {
          if (isset($action->constraint)) {
            $this->runActionConstraint($action, $actionResponse);
          } else {
            $this->runAction($action, $actionResponse);
          }
          
          // Falls 'after' Aktionen vorhanden sind, werden diese jetzt ausgeführt
          if ($this->isActionRun && isset($action->after)) {
            if (! $this->runActionAfter($action, $actionResponse)) {
              break;
            }
          }
          
          // Neues Spiel, neues Glück
          $this->isActionRun = false;
        }
        
        $this->updateStatus($task, $taskPlanner, $actionResponse);
      }
    }
  } // end public function main */

  
  /**
   * Einhaltung der im 'Constraint' angegebenen Bedingungen.
   * Sind die Bedingungen nicht erfüllt, wird der Task übersprungen.
   *
   * @param Object $action Daten einer einzelnen Action (JSON)
   * @param LibResponseCollector $response
   */
  public function runActionConstraint ($action, $response)
  {
    // Auf welchem Schlüsselliegt der Constraint?
    $parentKey = $action->constraint->parent->key;
    
    // Wichtig, wenn ein Task nicht lief, gibt es auch keinen Eintrag im 'index' Array
    if (array_key_exists($parentKey, $this->index)) {
      
      // Welchen Wert erwarten wir?
      $parentResult = $action->constraint->parent->on;
      
      if ($parentResult == "fail") {
        $parentResult = false;
      } elseif ($parentResult == "success") {
        $parentResult = true;
      }
      
      // Entspricht das Ergebnis des Tasks der Annahme?
      if ($this->index[$parentKey] == $parentResult) {
        $this->runAction($action, $response);
      }
    }
  }

  /**
   * Führt die im 'After' Teil angebenen Aktionen der übergebenen Action durch. Folgende Aktionen
   * sind definiert:
   * setFailed: Der aktuelle Task läuft weiter, das Ergebnis ist fail (<code>false</code>)
   * break: Der aktuelle Task wird abgebrochen, das Ergebnis ist fail (<code>false</code>)
   * complete: Der aktuelle Task wird abgebrochen, das Ergebnis ist success (<code>true</code>)
   * In allen anderen Fällen läuft der Task normal weiter.
   *
   * @param Object $action Daten einer einzelnen Action (JSON)
   * @param LibResponseCollector $response
   * @return boolean Ergebnis der After Aktionen
   */
  public function runActionAfter ($action, $response)
  {

    $result = false;
    
    // Dieser Teil wird immer ausgeführt
    if (isset($action->after->do)) {
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
    
    // Wichtig, wenn ein Task nicht lief, gibt es auch keinen Eintrag im 'index' Array
    if ($this->isActionRun) {
      if (isset($action->after->success)) {
        if ($this->index["$action->key"] == true) {
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
      }
      
      if (isset($action->after->fail)) {
        if ($this->index["$action->key"] == false) {
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
    
    return $result;
  }

  /**
   * Setzt den Status eines gelaufenen Tasks und logt das Ergebnis.
   *
   * @param array $task
   *        	Daten eines einzelnen Tasks
   * @param LibTaskplanner $taskPlanner
   *        	Objekt des aktuellen Task
   * @param LibResponseCollector $response
   */
  public function updateStatus ($task, $taskPlanner, $response)
  {
    // Wenn hardStatus irgendwann gesetzt wurde, wird dieser Wert gekommen, ansonsten nicht
    if (isset($this->hardStatus)) {
      $status = $this->hardStatus;
    } else {
      $status = $this->softStatus;
    }
    
    $orm = $this->getOrm();
    
    $taskId = $task['task_id'];
    $taskVid = $task['plan_id'];
    
    $taskPlan = $orm->get('WbfsysTaskPlan', $taskVid);
    
    $now = time();
    
    $logMessage = array(
        'title' => $taskPlan->title, 
        'task_start' => date('Y-m-d H:i:s', $taskPlanner->currentTimestamp), 
        'task_end' => date('Y-m-d H:i:s', $now), 
        'id_plan' => $taskId, 
        'status' => $status, 
        'response' => json_encode($response)
    );
    
    $orm->update('WbfsysPlannedTask', $taskId, array(
        'status' => $status
    ));
    
    $orm->insert('WbfsysTaskLog', $logMessage);
  }

  /**
   * Ausführen einer einzelnen Action und persistieren des Ergebnis.
   * Der Rückgabewert der Action überschreibt dabei jedes mal <code>$softStatus</code>
   * mit dem entsprechenden Wert.
   *
   * @param Object $action
   *        	Daten einer einzelnen Action (JSON)
   * @param LibResponseCollector $response
   * @throws LibTaskplanner_Exception
   */
  public function runAction ($action, $response)
  {

    try {
      $this->isActionRun = true;
      
      // Jede Klasse heißt was mit *_Action
      $className = $action->class . "_Action";
      
      // Jede Methode heißt was mit trigger_*
      if (isset($action->method)) {
        $actionMethod = 'trigger_' . $action->method;
      } else {
        $actionMethod = 'trigger';
      }
      
      // Ist die Klasse vorhanden?
      if (! Webfrap::classLoadable($className)) {
        throw new LibTaskplanner_Exception("Missing Action " . $className);
      }
      
      // Neue Instanz der Klasse anlegen
      $actionClass = new $className(Webfrap::$env);
      
      // Ist die Methode vorhanden?
      if (! method_exists($actionClass, $actionMethod)) {
        throw new LibTaskplanner_Exception("Missing requested method " . $actionMethod);
      }
      
      // Ist ein Interface gesetzt?
      if (! isset($action->inf)) {
        $action->inf = 'plain';
      }
      
      // Der Rückgabewert der Methode muss true oder false sein
      switch ($action->inf) {
        case 'plain' :
          $result = $actionClass->{$actionMethod}();
          break;
        case 'entity' :
          $result = $actionClass->{$actionMethod}($action->params->id, $response);
          break;
        case 'table' :
          $result = $actionClass->{$actionMethod}($action->params->name);
          break;
        case 'mask' :
          $result = $actionClass->{$actionMethod}($action->params->mask, $action->params->id);
          break;
        default :
          throw new LibTaskplanner_Exception("Unknown Interface " . $action->inf);
          break;
      }
      
      // Ergebnis mit Knotennamen als Schlüssel und Rückgabewert als Wert speichern
      $this->index["$action->key"] = $result;
      
      if ($result) {
        $this->softStatus = ETaskStatus::COMPLETED;
      } else {
        $this->softStatus = ETaskStatus::FAILED;
      }
    } catch (LibTaskplanner_Exception $e) {
      // ...
    }
  }

  /**
  * the main method
  * @param LibRequestPhp $httpRequest
  * @param LibSessionPhp $session
  * @param Transaction $transaction
  * @return void
  */
  public function executeAction ($httpRequest = null, $session = null, $transaction = null)
  {
    
    // get the info from where main was called
    if (DEBUG)
      Debug::console('Called MAIN flow', null, true);
      
      // Startseiten Eintrag ins Navmenu
    $view = $this->getView();
    
    if (! $session)
      $session = $this->session;
    
    if (! $httpRequest)
      $httpRequest = $this->request;
    
    if (! $transaction)
      $transaction = $this->transaction;
    
    $user = $this->getUser();
    
    if (! $sysClass = $httpRequest->param(Request::MOD, Validator::CNAME)) {
      
      if (! $user->getLogedIn()) {
        $tmp = explode('.', $session->getStatus('tripple.annon'));
        $map = array(
            Request::MOD => $tmp[0], 
            Request::CON => $tmp[1], 
            Request::RUN => $tmp[2]
        );
        $httpRequest->addParam($map);
        
        $sysClass = $tmp[0];
      } else {
        $tmp = explode('.', $session->getStatus('tripple.user'));
        $map = array(
            Request::MOD => $tmp[0], 
            Request::CON => $tmp[1], 
            Request::RUN => $tmp[2]
        );
        $httpRequest->addParam($map);
        
        $sysClass = $tmp[0];
      }
    } //end if (!$sysClass = $httpRequest->param(Request::MOD,'Cname') )
    

    $modName = ucfirst($sysClass);
    $className = $modName . '_Module';
    
    $classNameOld = 'Module' . $modName;
    
    if (Webfrap::classLoadable($className)) {
      Debug::console('$module', $className);
      
      $this->module = new $className($this);
      $this->module->init();
      $this->module->main();
      
      // everythin fine
      return true;
    } else if (Webfrap::classLoadable($classNameOld)) {
      Debug::console('$module', $classNameOld);
      
      $this->module = new $classNameOld($this);
      $this->module->init();
      $this->module->main();
      
      // everythin fine
      return true;
    } else {
      $this->runController($modName, ucfirst($httpRequest->param(Request::CON, Validator::CNAME)));
    }
    
    return false;
  } // end public function executeAction */

  
  /**
   *
   * @param Module $module
   * @param Controller $controller
   */
  public function runController ($module, $controller)
  {

    $request = $this->getRequest();
    
    try {
      
      $classname = $module . $controller . WBF_CONTROLLER_PREFIX . '_Controller';
      $classnameOld = 'Controller' . $module . $controller;
      
      if (WebFrap::loadable($classname)) {
        $this->controller = new $classname($this);
        if (method_exists($this->controller, 'setDefaultModel'))
          $this->controller->setDefaultModel($module . $controller);
        $this->controllerName = $classname;
        
        $action = $request->param(Request::RUN, Validator::CNAME);
        
        // Initialisieren der Extention
        if (! $this->controller->initController())
          throw new WebfrapSys_Exception('Failed to initialize Controller');
          
          // Run the mainpart
        $this->controller->run($action);
        
        // shout down the extension iff the controller was not reset by a failed redirect
        if ($this->controller)
          $this->controller->shutdownController();
      } elseif (WebFrap::loadable($classnameOld)) {
        
        $classname = $classnameOld;
        
        $this->controller = new $classnameOld($this);
        if (method_exists($this->controller, 'setDefaultModel'))
          $this->controller->setDefaultModel($module . $controller);
        $this->controllerName = $classnameOld;
        
        $action = $request->param(Request::RUN, Validator::CNAME);
        
        // Initialisieren der Extention
        if (! $this->controller->initController())
          throw new WebfrapSys_Exception('Failed to initialize Controller');
          
          // Run the mainpart
        $this->controller->run($action);
        
        // shout down the extension
        $this->controller->shutdownController();
      } else {
        throw new WebfrapUser_Exception('Resource ' . $classname . ' not exists!');
      }
    } catch (Exception $exc) {
      
      Error::report(I18n::s('Module Error: {@message@}', 'wbf.message', array(
          'message' => $exc->getMessage()
      )), $exc);
      
      // if the controller ist not loadable set an error controller
      $this->controller = new Error_Controller($this);
      $this->controllerName = 'ControllerError';
      //\Reset The Extention
      

      if (Log::$levelDebug) {
        $this->controller->displayError('displayException', array(
            $exc
        ));
      } else {
        $this->controller->displayError('displayEnduserError', array(
            $exc
        ));
      } //end else
    } //end catch( Exception $exc )
  } //end public function runController */

  
  /**
   * Write the content in the output stream
   */
  public function out ()
  {

    if (View::$published)
      throw new Webfrap_Exception("Allready published!!");
    
    View::$published = true;
    
    $this->response->compile();
    
    if (BUFFER_OUTPUT) {
      $errors = ob_get_contents();
      
      ob_end_clean();
      $this->response->publish(); //tell the view to publish the data
      ob_start();
      
      return $errors;
    }
    
    $this->response->publish(); //tell the view to publish the data
    

    return null;
  } //end public function out */

  
  /**
   * @param string $errorKey
   * @param string $data
   */
  public function httpError ($errorKey, $data = null)
  {

    $tplEngine = $this->getView();
    
    $errorClass = 'LibHttpError' . $errorKey;
    
    if (! Webfrap::classLoadable($errorClass))
      $errorClass = 'LibHttpError500';
    
    $error = new $errorClass($data);
    $error->publish($tplEngine);
    
    $tplEngine->compile();
    
    if (BUFFER_OUTPUT) {
      $errors = ob_get_contents();
      
      ob_end_clean();
      $tplEngine->publish(); //tell the view to publish the data
      ob_start();
      
      return $errors;
    }
    
    $tplEngine->publish(); //tell the view to publish the data
  } //end public function out */

  
  /**
   * Sauberes beenden des Requests
   */
  public function shutdown ()
  {

    if (Log::$levelDebug)
      Debug::publishDebugdata();
    
    if (Session::$session->getStatus('logout')) {
      Log::info('User logged of from system');
      
      Session::destroy();
    }
    
    Session::close();
    Db::shutdown();
    Webfrap::saveClassIndex();
    I18n::writeCache();
  } //end public function shutdown */

  
  /**
  * Funktion zum beenden von Webfrap falls ein Fataler Fehler auftritt der das
  * Ausführen von Webfrap verhindert
  *
  * @param string $file
  * @param int $line
  * @param string $lastMessage
  * @return array
  */
  public function panikShutdown ($file, $line, $lastMessage)
  {

    Log::fatal('System got killed: ' . $file . ' Linie: ' . $line . ' reason: ' . $lastMessage);
    
    $messages = ob_get_contents();
    ob_end_clean();
    
    echo '<h1>Fatal Error, System died :-((</h1>';
    
    if (Log::$levelDebug)
      echo $messages;
    
    echo '<p>' . $lastMessage . '</p>';
    session_destroy();
    exit();
  } // end public function panikShutdown */

  
  /*//////////////////////////////////////////////////////////////////////////////
// System Status
//////////////////////////////////////////////////////////////////////////////*/
  
  /**
   * methode for an intern redirect throw chaching the states an recall the main
   * function
   *
   * @var array|string $target
   * @var LibRequestHttp $request
   * @var boolean $forceLogedin
   * @return void
   */
  public function redirect ($target, $request = null, $forceLogedin = true)
  {

    if ($request) {
      $this->request = $request;
      WebFrap::$env->setRequest($request);
    } else {
      $request = $this->getRequest();
    }
    
    if ($this->controller)
      $this->controller->shutdownController();
    
    $this->module = null;
    $this->moduleName = null;
    $this->controller = null;
    $this->controllerName = null;
    
    if (is_array($target)) {
      
      // wenn login benötigt, aber nicht vorhanden umleiten auf die loginseite
      if (! $forceLogedin || $this->user->getLogedin()) {
        $map = $target;
      } else {
        $tmp = explode('.', $this->session->getStatus('tripple.login'));
        
        $map = array(
            Request::MOD => $tmp[0], 
            Request::CON => $tmp[1], 
            Request::RUN => $tmp[2]
        );
      }
    } else {
      
      if (! $forceLogedin || $this->user->getLogedin())
        $tmp = explode('.', $target);
      else
        $tmp = explode('.', $this->session->getStatus('tripple.login'));
      
      $map = array(
          Request::MOD => $tmp[0], 
          Request::CON => $tmp[1], 
          Request::RUN => $tmp[2]
      );
    }
    
    $request->addParam($map);
    
    $this->main();
  } //end public function redirect */

  
  /**
   * methode for an intern redirect throw chaching the states an recall the main
   * function
   *
   * @var LibRequestHttp $request
   * @var boolean $forceLogedin
   * @return void
   */
  public function redirectByRequest ($request, $viewType, $forceLogedin = true)
  {
    
    // erneuern des environments
    $this->request = $request;
    Webfrap::$env->setRequest($request);
    
    // shutdown actual controller
    $this->controller->shutdownController();
    
    $this->module = null;
    $this->moduleName = null;
    $this->controller = null;
    $this->controllerName = null;
    
    View::rebase(SFormatStrings::subToCamelCase($viewType));
    
    if ($forceLogedin && ! $this->user->getLogedin()) {
      $loginTripple = $this->session->getStatus('tripple.login');
      $tmp = explode('.', $loginTripple);
      $map = array(
          'c' => $loginTripple, 
          Request::MOD => $tmp[0], 
          Request::CON => $tmp[1], 
          Request::RUN => $tmp[2]
      );
      $request->addParam($map);
    }
    
    $this->main();
  } //end public function redirectByRequest */

  
  /**
   * methode for an intern redirect to the start page
   *
   * @return void
   */
  public function redirectToDefault ($client = false)
  {

    $conf = $this->getConf();
    $user = $this->getUser();
    
    if ($user->getLogedin()) {
      
      $profile = $user->getProfileName();
      
      if ($status = $conf->getStatus('default.action.profile_' . $profile)) {
        $tmp = explode('.', $status);
      } elseif ($status = $conf->getStatus('tripple.user')) {
        $status = $conf->getStatus('tripple.user');
        $tmp = explode('.', $status);
      } else {
        $status = 'webfrap.netsktop.display';
        $tmp = explode('.', $status);
      }
    } else {
      if ($status = $conf->getStatus('tripple.annon')) {
        $tmp = explode('.', $conf->getStatus('tripple.annon'));
      } else {
        $status = 'Webfrap.Auth.form';
        $tmp = explode('.', $status);
      }
    }
    
    if (3 != count($tmp)) {
      Debug::console('tried to forward to an invalid status ' . $status);
      
      return;
    }
    
    $map = array(
        Request::MOD => $tmp[0], 
        Request::CON => $tmp[1], 
        Request::RUN => $tmp[2]
    );
    $this->redirect($map);
  } //end public function redirectToDefault */

  
  /**
   * methode for an intern redirect to the start page
   *
   * @return void
   */
  public function redirectByKey ($key, $forceLogedin = true)
  {

    if (! $forceLogedin || $this->user->getLogedin())
      $tmp = explode('.', $this->session->getStatus($key));
    else
      $tmp = explode('.', $this->session->getStatus('tripple.login'));
    
    $map = array(
        Request::MOD => $tmp[0], 
        Request::CON => $tmp[1], 
        Request::RUN => $tmp[2]
    );
    $this->redirect($map);
  } //end public function redirectByKey */

  
  /**
   * methode for an intern redirect to the start page
   *
   * @return void
   */
  public function redirectByTripple ($key, $forceLogedin = true)
  {

    if (! $forceLogedin || $this->user->getLogedin())
      $tmp = explode('.', $key);
    else
      $tmp = explode('.', $this->session->getStatus('tripple.login'));
    
    $map = array(
        Request::MOD => $tmp[0], 
        Request::CON => $tmp[1], 
        Request::RUN => $tmp[2]
    );
    $this->redirect($map);
  } //end public function redirectByTripple */

  
  /**
   * method for intern redirect to the loginpage
   * @return void
   */
  public function redirectToLogin ()
  {

    $tmp = explode('.', $this->session->getStatus('tripple.login'));
    $map = array(
        Request::MOD => $tmp[0], 
        Request::CON => $tmp[1], 
        Request::RUN => $tmp[2]
    );
    $this->request->addParam($map);
    
    if ('ajax' == $this->request->param('rqt', Validator::CNAME)) {
      $tmp = explode('.', $this->session->getStatus('tripple.login'));
      //$this->tplEngine->setStatus( 401 );
      $this->tpl->redirectUrl = 'index.php?mod=' . $tmp[0] . '&amp;mex=' . $tmp[1] . '&amp;do=' . $tmp[2];
    }
    
    $this->main();
  } //end public function redirectToLogin */

  
  /**
   * @lang de:
   * Das aktuive module objekt anfragen
   *
   * @return Module
   */
  public function getActivMod ()
  {

    return $this->module;
  } //end public function getActivMod */
}//end class LibFlowTaskplanner