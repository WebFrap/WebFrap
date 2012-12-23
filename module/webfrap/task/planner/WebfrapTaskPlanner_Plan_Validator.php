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
    
    $this->data['wbfsys_task_plan']['title'] = $request->data( 'title', Validator::TEXT )
      ?: $this->addError('Missing Title');
    
    $this->data['wbfsys_task_plan']['flag_series'] = $request->data( 'flag_series', Validator::BOOLEAN );
    
    if( $this->data['wbfsys_task_plan']['flag_series'] )
    {
      $this->data['wbfsys_task_plan']['timestamp_start'] = $request->data( 'timestamp_start', Validator::TIMESTAMP )
        ?: $this->addError('Missing Start');
        
      $this->data['wbfsys_task_plan']['timestamp_end'] = $request->data( 'timestamp_end', Validator::TIMESTAMP )
        ?: $this->addError('Missing End');
    }
    
    $this->data['wbfsys_task_plan']['description'] = $request->data( 'desciption', Validator::HTML );
    
  }//end public function check */
  
}//end class WebfrapTaskPlanner_Plan_Validator */

