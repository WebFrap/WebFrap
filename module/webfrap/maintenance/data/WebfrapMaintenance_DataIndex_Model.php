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
class WebfrapMaintenance_DataIndex_Model
  extends Model
{
////////////////////////////////////////////////////////////////////////////////
// Methoden
////////////////////////////////////////////////////////////////////////////////

  /**
   * @return void
   */
  public function getStats(  )
  {
    
    $db = $this->getDb();
    
    $stats = array();
    
    $query = <<<SQL
SELECT
  count(vid) as num
FROM
  wbfsys_data_index
SQL;

    $stats['numer_entries'] =  $db->select( $query )->getField('num');
    
  }//end public function getStats */
  
  
  /**
   * @return void
   */
  public function getModules(  )
  {
    
    return array();
    
  }//end public function getModules */
  
}//end class WebfrapMaintenance_DataIndex_Model */

