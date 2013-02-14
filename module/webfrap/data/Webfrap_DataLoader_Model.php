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
 * @subpackage Maintenance
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class Webfrap_DataLoader_Model extends Model
{
/*//////////////////////////////////////////////////////////////////////////////
// Methoden
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return void
   */
  public function getStructure(  )
  {
    
    $db = $this->getDb();
    
    $stats = array();
    
    $query = <<<SQL
SELECT
  ent.name ent_name,
  ent.access_key ent_key,
  mod.name as mod_name
  
FROM
  wbfsys_entity ent
  
LEFT JOIN
	wbfsys_module mod
		ON mod.rowid = ent.id_module;

SQL;

    return $db->select( $query )->getAll();
    
  }//end public function getStats */
  
  
  /**
   * @return void
   */
  public function getModules(  )
  {
    
    return array();
    
  }//end public function getModules */
  
}//end class WebfrapMaintenance_DataIndex_Model */

