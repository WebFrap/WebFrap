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
    'su' => 0,
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
    
    $planObj = $orm->update( 'WbfsysTaskPlan', $id, $data->getData('wbfsys_task_plan')  );
    
    $this->cleanTasks( $id );
    
    $this->schedule = json_decode( $planObj->series_rule  );
    
    if( $this->schedule->flags->is_list )
    {
      $this->createTaskList(  $id, $planObj, $this->schedule );
    }
    elseif( $this->schedule->flags->by_day )
    {
      $this->createTasksByNamedDays(  $id, $planObj, $this->schedule );
    }
    elseif( $this->schedule->flags->advanced )
    {
      if( $this->schedule->type !== ETaskType::CUSTOM )
      {
        $this->createTasksByType( $id, $planObj, $this->schedule );
      }
      else 
      {
        $this->createTasksByDayNumber(  $id, $planObj, $this->schedule );
      }
    }
    else 
    {
      $this->createSingleTask(  $id, $this->schedule->trigger_time, $planObj, $this->schedule  );
    }
    
    return $planObj;
    
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
   * @param WbfsysPlannedTask_Entity $data 
   * @param json:stdClass $schedule
   */
  protected function createTasksByNamedDays( $planId, $data, $schedule )
  {
    
    $endTime = strtotime($data->timestamp_end);
    $startTime = strtotime($data->timestamp_start);
    
    $tmp = explode( ',', date( 'Y,m,d,H,i', $startTime ) );
    $start['y'] = $tmp[0];
    $start['m'] = $tmp[1];
    $start['d'] = $tmp[2];
    $start['h'] = $tmp[3];
    $start['i'] = $tmp[4];
    $tmp = explode( ',', date( 'Y,m,d,H,i', $endTime ) );
    $end['y'] = $tmp[0];
    $end['m'] = $tmp[1];
    $end['d'] = $tmp[2];
    $end['h'] = $tmp[3];
    $end['i'] = $tmp[4];
    
    // calc years
    if( $start['y'] !== $end['y'] )
      $years = range( $start['y'], $end['y'] ,1 );
    else 
      $years = array( $start['y'] );
      
    // calc years
    $months = array();
    
    foreach( $schedule->months as $month => $active )
    {
      if( $active )
        $months[] = (int)$this->monthMap[$month];
    }
    if( !$months )
      $months = range(1,12,1);
      
    // weeks
    $weeks = array();
    foreach( $schedule->monthWeeks as $week => $active )
    {
      if( $active )
        $weeks[] = (int)$week;
    }
    if( !$weeks )
      $weeks = range(1,4,1);
      
    // days
    $days = array();
    foreach( $schedule->weekDays as $day => $active )
    {
      if( $active )
        $days[] = (int)$this->dayMap[$day];
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
      
    // minutes
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
        
        $monthDays = SDate::getFilteredMonthDays( $year, $month, $days, $weeks );
        
        foreach( $monthDays as $day )
        {
          foreach( $hours as $hour )
          {
            foreach( $minutes as $minute )
            {
              
              $taskTime = mktime( $hour, $minute, 0, $month, $day, $year );
              
              // check the borders
              if( $taskTime < $startTime )
                continue;
                
              if( $taskTime > $endTime )
                continue;
              
              $this->createSingleTask
              ( 
                $planId, 
                date( 'Y-m-d H:i:s', mktime( $hour, $minute, 0, $month, $day, $year )), 
                $data, 
                $schedule 
              );
              
            }//min
          }//hour
        }//day
      }//month
    }//year
    
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
    $task->actions = $data->actions;
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

