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
class WebfrapTag_Model extends Model
{

  /**
   * @param int $tagId
   * @return WbfsysTag_Entity
   */
  public function getTag($tagId )
  {

    $orm = $this->getOrm();
    return $orm->get( "WbfsysTag",  $tagId );

  }//end public function getTag */

  /**
   * @param string $tagName
   * @return WbfsysTag_Entity
   */
  public function addTag($tagName )
  {

    $orm     = $this->getOrm();
    $tagNode = $orm->getWhere( "WbfsysTag",  "name ilike '".$orm->escape($tagName)."' " );

    if ($tagNode )
    {
      return $tagNode;
    } else {
      $tagNode = $orm->newEntity( "WbfsysTag" );
      $tagNode->name = $tagName;
      $tagNode->access_key  = SFormatStrings::nameToAccessKey($tagName);
      $tagNode = $orm->insertIfNotExists($tagNode, array( 'name' ) );
      return $tagNode;
    }

  }//end public function addTag */

  /**
   * @param WbfsysTag_Entity|int $tagId
   * @param int $objid
   * 
   * @return WbfsysTagReference_Entity | null gibt null zurück wenn die Verbindung bereits existiert
   */
  public function addConnection($tagId, $objid )
  {
    
    $orm    = $this->getOrm(  );
    $tagRef = $orm->newEntity( 'WbfsysTagReference' );
    
    $tagRef->id_tag  = (string)$tagId;
    $tagRef->vid     = $objid;
    
    if (!$tagRef->id_tag )
    {
      throw new LibDb_Exception( "FUUU" );
    }
    
    return $orm->insertIfNotExists($tagRef, array( 'id_tag', 'vid' ) );

  }//end public function addConnection */
  
  
  /**
   * @param int $objid
   * @return int
   */
  public function cleanDsetTags($objid )
  {
    
    $orm    = $this->getOrm(  );
    $orm->deleteWhere( 'WbfsysTagReference', "vid=".$objid );

  }//end public function cleanDsetTags */
  
  /**
   * @param int $objid
   * @return int
   */
  public function disconnect($objid )
  {
    
    $orm    = $this->getOrm(  );
    $orm->delete( 'WbfsysTagReference', $objid );

  }//end public function disconnect */
  
  
  /**
   * @param string $key
   * @param int $refId
   * 
   * @return LibDbPostgresqlResult
   */
  public function autocompleteByName($key, $refId  )
  {
    
    $db = $this->getDb();
    
    $sql = <<<SQL
SELECT 
  tag.name as label,
  tag.name as value,
  tag.rowid as id
FROM 
  wbfsys_tag tag
WHERE 
  NOT tag.rowid IN( select ref.id_tag from wbfsys_tag_reference ref where ref.vid = {$refId} )
  AND upper( tag.name ) like upper( '{$db->addSlashes($key)}%' )
ORDER BY 
  tag.name
LIMIT 10;
SQL;
    
    return $db->select($sql )->getAll();
    
  }//end public function autocompleteByName */
  
  /**
   * @param string $key
   * @param int $refId
   * 
   * @return LibDbPostgresqlResult
   */
  public function getDatasetTaglist($refId  )
  {
    
    $db = $this->getDb();

    $sql = <<<SQL
SELECT 
  tag.name as label,
  tag.rowid as tag_id,
  ref.rowid as ref_id
FROM 
  wbfsys_tag tag
JOIN
  wbfsys_tag_reference ref
    ON tag.rowid = ref.id_tag
WHERE 
  ref.vid = {$refId}
ORDER BY 
  tag.name;
SQL;
    
    return $db->select($sql )->getAll();
    
  }//end public function getDatasetTaglist */
  
} // end class WebfrapTag_Model


