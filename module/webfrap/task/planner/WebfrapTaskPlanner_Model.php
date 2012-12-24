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
    return $orm->update( 'WbfsysTaskPlan', $id, $data->getData('wbfsys_task_plan')  );
    
  }//end public function updatePlan */
  
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
  
}//end class Webfrap_TaskPlanner_Model */

