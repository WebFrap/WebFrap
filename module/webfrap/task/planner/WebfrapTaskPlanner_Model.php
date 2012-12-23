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
 * @subpackage Core
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
  public function getPlans()
  {
    
    $db = $this->getDb();

    $sql = <<<SQL
    
	SELECT
		title,
		flag_series,
		timestamp_start,
		timestamp_end,
		series_rule,
		actions,
		description
	FROM
		wbfsys_task_plan
	ORDER BY
		timestamp_start;
		
SQL;
    
    return $db->select( $sql );
    
  }//end public function getPlans */
  
  
}//end class Webfrap_TaskPlanner_Model */
