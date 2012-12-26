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


/**
 * @package WebFrap
 * @subpackage Taskplanner
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class WebfrapTaskPlanner_Model
  extends Model
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @var stdClass
   */
  public $schedule = null;
  
  /**
   * @var array
   */
  public $monthMap = array
  (
    'jan' => 1,
    'feb' => 2,
    'mar' => 3,
    'apr' => 4,
    'may' => 5,
    'jun' => 6,
    'jul' => 7,
    'aug' => 8,
    'sep' => 9,
    'oct' => 10,
    'nov' => 11,
    'dec' => 12,
  );
  
  /**
   * @var array
   */
  public $dayMap = array
  (
    'mo' => 1,
    'tu' => 2,
    'we' => 3,
    'th' => 4,
    'fr' => 5,
    'sa' => 6,
    'su' => 7,
  );
  
////////////////////////////////////////////////////////////////////////////////
// Methoden
////////////////////////////////////////////////////////////////////////////////

  /**
   * @return LibDbPostgresqlResult
   */
  public function getPlans( $where = null )
  {
    
    $db = $this->getDb();
    
    $sqlWhere = '';
    if( $where )
    {
      $sqlWhere = <<<SQL
	WHERE {$where}
SQL;
    }

    $sql = <<<SQL
    
	SELECT
		rowid as id,
		title,
		flag_series,
		timestamp_start,
		timestamp_end,
		series_rule,
		actions,
		description
	FROM
		wbfsys_task_plan
{$sqlWhere}
	ORDER BY
		timestamp_start;
		
SQL;
    
    return $db->select( $sql );
    
  }//end public function getPlans */
  
  /**
   * @param int $objid
   * @return WbfsysTaskPlan_Entity
   */
  public function getPlan( $objid )
  {

    $orm = $this->getOrm();
    return $orm->get( 'WbfsysTaskPlan', $objid );
    
  }//end public function getPlan */
  
  /**
   * @param WebfrapTaskPlanner_Plan_Validator $data 
   * @return WbfsysTaskPlan_Entity 
   */
  public function insertPlan( $data )
  {
    
    $orm = $this->getOrm();
    return $orm->insert( 'WbfsysTaskPlan', $data->getData('wbfsys_task_plan')  );
    
  }//end public function insertPlan */
  
  /**
   * @param WebfrapTaskPlanner_Plan_Validator $data 
   * @return WbfsysTaskPlan_Entity 
   */
  public function updatePlan( $id, $data )
  {
    
    $orm = $this->getOrm();
    
    $sucess = $orm->update( 'WbfsysTaskPlan', $id, $data->getData('wbfsys_task_plan')  );
    
    $this->cleanTasks( $id );
    
    $this->schedule = json_decode( $data->series_rule  );
    
    if( $this->schedule->flag->is_list )
    {
      $this->createTaskList(  $id, $data, $this->schedule );
    }
    elseif( $this->schedule->flag->by_day )
    {
      $this->createTasksByNamedDays(  $id, $data, $this->schedule );
    }
    elseif( $this->schedule->flag->advanced )
    {
      if( $this->schedule->type !== ETaskType::CUSTOM )
      {
        $this->createTasksByType( $id, $data, $this->schedule );
      }
      else 
      {
        $this->createTasksByDayNumber(  $id, $data, $this->schedule );
      }
    }
    else 
    {
      $this->createSingleTask(  $id, $data, $this->schedule  );
    }
    
    return $sucess;
    
  }//end public function updatePlan */
  
  /**
   * @param int $id
   */
  protected function cleanTasks( $id )
  {
    
    // nur tasks löschen die nicht schon ausgeführt wurden
    $orm = $this->getOrm();
    $orm->deleteWhere('WbfsysPlannedTask', "vid=".$id." AND task_time > now() AND status < 1" );
    
  }//end protected function cleanTasks */
  
  /**
   * @param int $planId 
   * @param WebfrapTaskPlanner_Plan_Validator $data 
   * @param json:stdClass $schedule
   */
  protected function createTaskList( $planId, $data, $schedule )
  {
    
  }//end protected function createTaskList */
  
  /**
   * @param int $planId 
   * @param WebfrapTaskPlanner_Plan_Validator $data 
   * @param json:stdClass $schedule
   */
  protected function createTasksByNamedDays( $planId, $data, $schedule )
  {
    
    $endTime = strtotime($data->timestamp_end);
    $tmp = explode( ',', date('Y,m,d,H,i') );
    $now['y'] = $tmp[0];
    $now['m'] = $tmp[1];
    $now['d'] = $tmp[2];
    $now['h'] = $tmp[3];
    $now['i'] = $tmp[4];
    $tmp = explode( ',', date( 'Y,m,d,H,i', $endTime ) );
    $end['y'] = $tmp[0];
    $end['m'] = $tmp[1];
    $end['d'] = $tmp[2];
    $end['h'] = $tmp[3];
    $end['i'] = $tmp[4];
    
    // calc years
    if( $now['y'] !== $end['y'] )
      $years = range( $now['y'], $end['y'] ,1 );
    else 
      $years = array( $now['y'] );
      
    // calc years
    $months = array();
    
    foreach( $schedule->months as $month => $active )
    {
      if( $active )
        $months[] = $this->monthMap[$month];
    }
    if( !$months )
      $months = range(1,12,1);
      
    // days
    $days = array();
    foreach( $schedule->weekDay as $day => $active )
    {
      if( $active )
        $days[] = $this->dayMap[$day];
    }
    if( !$days )
      $days = range(1,7,1);
    
    // hours
    $hours = array();
    foreach( $schedule->hours as $hour => $active )
    {
      if( $active )
        $hours[] = $hour;
    }
    if( !$hours )
      $hours = array(23);
      
    // hours
    $minutes = array();
    foreach( $schedule->minutes as $minute => $active )
    {
      if( $active )
        $minutes[] = $minute;
    }
    if( !$minutes )
      $minutes = array(59);

      
    foreach( $years as $year )
    {
      foreach( $months as $month )
      {
        foreach( $hours as $hour )
        {
          foreach( $minutes as $minute )
          {
            $this->createSingleTask
            ( 
              $planId, 
              mktime( 0, $minute, $hour, day, $month, $year ), 
              $data, 
              $schedule 
            );
          }
        }
      }
    }
    
  }//end protected function createTasksByNamedDays */
  
  /**
   * @param int $planId 
   * @param WebfrapTaskPlanner_Plan_Validator $data 
   * @param json:stdClass $schedule
   */
  protected function createTasksByDayNumber( $planId, $data, $schedule )
  {
    
  }//end protected function createTasksByDayNumber */
  
  /**
   * @param int $planId 
   * @param WebfrapTaskPlanner_Plan_Validator $data 
   * @param json:stdClass $schedule
   */
  protected function createTasksByType( $planId, $data, $schedule )
  {
    
    if( 60 >= $schedule->type )
    {
      
    }
    
  }//end protected function createTasksByType */
  
  /**
   * @param int $planId 
   * @param WebfrapTaskPlanner_Plan_Validator $data 
   * @param json:stdClass $schedule
   */
  protected function createSingleTask( $planId, $time, $data, $schedule )
  {
    
    $orm = $this->getOrm();
    
    $task = $orm->newEntity( 'WbfsysPlannedTask' );
    $task->vid = $planId;
    $task->task_time = $time;
    $task->actions = $schedule->actions;
    $task->status = ETaskStatus::ACTIVE;
    
    $orm->insert( $task );
    
    
  }//end protected function createSingleTask */
  

  
  /**
   * @param WebfrapTaskPlanner_Plan_Validator $data 
   * @return WbfsysTaskPlan_Entity 
   */
  public function deletePlan( $id )
  {
    
    $orm = $this->getOrm();
    $orm->delete( 'WbfsysTaskPlan', $id );
    $orm->deleteWhere('WbfsysPlannedTask', "vid=".$id );
    
  }//end public function delete */
  
////////////////////////////////////////////////////////////////////////////////
// Plan Type
////////////////////////////////////////////////////////////////////////////////

  public function getPlanType()
  {
    
    return array(
      array(
        "id"    => "minuten",
        "value" => "Every Minute",
      )
    );
    
  }
  
}//end class Webfrap_TaskPlanner_Model */

