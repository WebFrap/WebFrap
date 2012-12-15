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
 * @subpackage maintenance/process
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class WebfrapMaintenance_Process_Model
  extends Model
{
////////////////////////////////////////////////////////////////////////////////
// Methoden
////////////////////////////////////////////////////////////////////////////////

  /**
   * @return void
   */
  public function getProcesses(  )
  {
    
    $db = $this->getDb();
    
    $query = <<<SQL
SELECT
  process.rowid as id,
  process.name,
  process.access_key,
  process.id_entity,
  ent.access_key as entity_name,
  process.description
  
FROM

  wbfsys_process process
JOIN
	wbfsys_entity ent
		ON ent.rowid = process.id_entity
  
  ;

SQL;

    return $db->select( $query );
    
  }//end public function getProcesses */
  
  /**
   * @return WbfsysProcess_Entity
   */
  public function getProcessById( $idProcess )
  {
    
    $orm = $this->getOrm();
    
    return $orm->get( 'WbfsysProcess', $idProcess );
    
  }//end public function getProcessNodes */
  
  /**
   * @return void
   */
  public function getProcessNodes( $idProcess )
  {
    
    $db = $this->getDb();
    
    $query = <<<SQL
SELECT
  node.label,
  node.rowid
  
FROM
  wbfsys_process process node
WHERE 
	node.id_process = {$idProcess}
ORDER BY 
	node.m_order;

SQL;

    return $db->select( $query );
    
  }//end public function getProcessNodes */
  
  

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
  
  

  
}//end class WebfrapMaintenance_Process_Model */

