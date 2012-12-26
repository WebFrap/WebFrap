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
class WebfrapTaskPlanner_Plan_Validator
  extends ValidStructure
{
////////////////////////////////////////////////////////////////////////////////
// Methoden
////////////////////////////////////////////////////////////////////////////////

  /**
   * @param LibRequestHttp $request
   */
  public function check( $request )
  {
    
    // default values
    
    $jsonRule = new stdClass();
    $jsonRule->flags = new stdClass();
    $jsonRule->trigger_time = null;   
    $jsonRule->flags->advanced = false;
    $jsonRule->flags->by_day = false;
    $jsonRule->flags->is_list = false;
    $jsonRule->months = array(); 
    $jsonRule->days = array(); 
    $jsonRule->hours = array(); 
    $jsonRule->minutes = array(); 
    $jsonRule->monthWeek = array(); 
    $jsonRule->weekDay = array(); 
    $jsonRule->taskList = array(); 
    $jsonRule->type = 0;
    
    $this->data['wbfsys_task_plan']['timestamp_start'] = null;
    $this->data['wbfsys_task_plan']['timestamp_end'] = null;

    $this->data['wbfsys_task_plan']['flag_series'] = $request->data( 'plan', Validator::BOOLEAN, 'flag-series' );
    
    if( $this->data['wbfsys_task_plan']['flag_series'] )
    {
      $this->data['wbfsys_task_plan']['timestamp_start'] = $request->data( 'plan', Validator::TIMESTAMP, 'timestamp_start' )
        ?: $this->addError('Missing Start');
        
      $this->data['wbfsys_task_plan']['timestamp_end'] = $request->data( 'plan', Validator::TIMESTAMP, 'timestamp_end' )
        ?: $this->addError('Missing End');

      $jsonRule->flags->advanced = $request->data( 'plan', Validator::BOOLEAN, 'flag-advanced' );
      
      if( $jsonRule->flags->advanced )
      {
        $this->check_advanced( $request, $jsonRule );
      }
      else 
      {
        $jsonRule->type = $request->data( 'plan', Validator::BOOLEAN, 'series_rule-id_type' );
      }

    }
    else 
    {

      $jsonRule->trigger_time = $request->data( 'plan', Validator::HTML, 'series_rule-trigger_time' );   

    }
    
    $this->data['wbfsys_task_plan']['title'] = $request->data( 'plan', Validator::TEXT, 'title' )
      ?: $this->addError('Missing Title');
      
    $this->data['wbfsys_task_plan']['description'] = $request->data( 'plan', Validator::HTML, 'desciption' );
    $this->data['wbfsys_task_plan']['actions'] = $request->data( 'plan', Validator::JSON, 'actions' );
    $this->data['wbfsys_task_plan']['series_rule'] = json_encode($jsonRule);
    
  }//end public function check */
  
  /**
   * @param LibRequestHttp $request
   * @param TJsonObject $jsonRule
   */
  public function check_advanced( $request, $jsonRule )
  {
    
    $jsonRule->flags->is_list = $request->data( 'plan', Validator::BOOLEAN, 'flag-is_list' );
      
    if( $jsonRule->flags->is_list )
    {
      $jsonRule->taskList = $request->data( 'plan', Validator::TIMESTAMP, 'series_rule-taskp_list' );
    }
    else
    {
      $jsonRule->flags->by_day = $request->data( 'plan', Validator::BOOLEAN, 'flag-by_day' );
      
      $jsonRule->months = $request->data( 'plan', Validator::CNAME, 'series_rule-months' ) ;
      $jsonRule->hours = $request->data( 'plan', Validator::BOOLEAN, 'series_rule-hours' );
      $jsonRule->minutes = $request->data( 'plan', Validator::BOOLEAN, 'series_rule-minutes' );
      
      if( $jsonRule->flags->by_day )
      {
        $jsonRule->monthWeek = $request->data( 'plan', Validator::INT, 'series_rule-month_weeks' );
        $jsonRule->weekDay = $request->data( 'plan', Validator::CNAME, 'series_rule-week_days' );
      }
      else 
      {
        $jsonRule->days = $request->data( 'plan', Validator::INT, 'series_rule-days' );
      }
      
    }
    
  }//end public function check_advanced */
  
}//end class WebfrapTaskPlanner_Plan_Validator */

