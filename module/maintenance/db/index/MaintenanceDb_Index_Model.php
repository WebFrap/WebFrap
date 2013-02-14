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
class MaintenanceDb_Index_Model extends Model
{
/*//////////////////////////////////////////////////////////////////////////////
// Methoden
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return void
   */
  public function getStats(  )
  {
    
    $db = $this->getDb();
    
    $stats = array();
    
    $query = <<<SQL
SELECT
  count(idx.vid) as num,
  entity.access_key 
  
FROM
  wbfsys_data_index idx
JOIN 
  wbfsys_entity entity
    ON idx.id_vid_entity = entity.rowid
GROUP BY
  entity.access_key;
SQL;

    $result = $db->select( $query );
    
    foreach( $result as $row )
    {
      $stats[$row['access_key']] =  $row['num'];
    }
    
    return $stats;

  }//end public function getStats */
  
  
  /**
   * @return void
   */
  public function getModules(  )
  {
    
    $modules = array();
    
    $tmp = DaoAdapterLoader::get( 'conf', 'db_index' );
    
    foreach( $tmp as $tNode )
    {
      $modules[SParserString::camelCaseToSub($tNode)] = $tNode;
    }
    
    return $modules;
    
  }//end public function getModules */
  
  /**
   * Den kompletten Index neu erstellen
   */
  public function recalcFullIndex()
  {
    
    $modules = $this->getModules();
    $indexer = new LibSearchDb_Indexer( $this->getOrm() );
    
    foreach( $modules as $mod )
    {
      $indexer->rebuildEntityIndex($mod);
    }
    
    
  }//end public function recaclFullIndex */
  
  /**
   * @param string $searchKey
   */
  public function search( $searchKey )
  {
    
    $db = $this->getDb();
    
    $sql = <<<SQL
SELECT
  idx.rowid,
  idx.name,
  idx.title,
  idx.access_key as key,
  idx.description,
  ent.name as entity_name,
  ent.access_key as entity_key,
  ts_rank_cd( to_tsvector('english', idx.title), to_tsquery( 'english', '{$searchKey}') ) AS rank
FROM
  wbfsys_data_index idx
JOIN wbfsys_entity ent on ent.rowid = idx.id_vid_entity
  WHERE to_tsvector('english', idx.title) @@ to_tsquery( 'english', '{$searchKey}') 
ORDER BY
  ent.name
LIMIT 50;
    
SQL;

    return $this->db->select($sql);
    
  }//end public function search */
  
}//end class MaintenanceDb_Index_Model */

