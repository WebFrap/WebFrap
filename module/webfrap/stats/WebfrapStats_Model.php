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
 * @package  WebFrap
 * @subpackage  Core
 * @author  Dominik  Bonsch  <dominik.bonsch@webfrap.net>
 * @copyright  Webfrap  Developer  Network  <contact@webfrap.net>
 * @licence  BSD
 */
class WebfrapStats_Model  extends Model
{

/*//////////////////////////////////////////////////////////////////////////////
//  Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var  WbfsysKnowhowNode_Entity
   */
  public $activeNode = null;

/*//////////////////////////////////////////////////////////////////////////////
//  Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return  WbfsysKnowhowNode_Entity
   */
  public function getActiveNode()
  {
    return $this->activeNode;
  } //end  public  function  getActiveNode  */

  /**
   * Anlegen  eines  neuen  Nodes
   * @param  string  $title
   * @param  string  $accessKey
   * @param  string  $content
   * @param  int  $container
   * @return  WbfsysKnowHowNode_Entity
   */
  public function addNode($title, $accessKey, $content, $container )
  {

    $orm = $this->getOrm();

    $khNode = $orm->newEntity( "WbfsysKnowHowNode" );
    $khNode->title = $title;
    $khNode->access_key = $accessKey;
    $khNode->id_repository = $container;
    $khNode->raw_content = $content;
    $khNode->content = $content;
    $khNode = $orm->insert($khNode );

    $this->activeNode = $khNode;

    return $khNode;

  } //end  public  function  addNode  */

  /**
   * @param  int  $rowid
   * @param  string  $title
   * @param  string  $accessKey
   * @param  string  $content
   * @param  int  $container
   * @return  WbfsysKnowHowNode_Entity
   */
  public function updateNode($rowid, $title, $accessKey, $content, $container )
  {

    $orm = $this->getOrm();

    $khNode = $orm->get( "WbfsysKnowHowNode", $rowid );
    $khNode->title = $title;
    $khNode->access_key = $accessKey;
    $khNode->id_repository = $container;
    $khNode->raw_content = $content;
    $khNode->content  = $content;
    $khNode = $orm->update($khNode );

    $this->activeNode = $khNode;

    return $khNode;

  } //end  public  function  updateNode  */

  /**
   * @param  string  $nodeKey
   * @param  int  $containerId
   * @return  WbfsysKnowHowNode_Entity
   */
  public function preCreateNode($nodeKey, $containerId )
  {

    $orm = $this->getOrm();
    $activeNode = $orm->newEntity( 'WbfsysKnowHowNode' );

    $activeNode->id_container = $containerId;
    $activeNode->access_key = $nodeKey;

    return $activeNode;

  } //end  public  function  preCreateNode  */

  /**
   * @param  int  $objid
   * @return  WbfsysKnowHowNode_Entity
   */
  public function loadNodeById($objid )
  {

    $orm = $this->getOrm();
    $this->activeNode = $orm->get( 'WbfsysKnowHowNode', $objid );

    return $this->activeNode;

  } //end  public  function  loadNodeById  */

  /**
   * @param  string  $key
   * @return  WbfsysKnowHowNode_Entity
   */
  public function loadNodeByKey($key, $containerId )
  {

    $orm = $this->getOrm();
    $this->activeNode = $orm->getWhere( 'WbfsysKnowHowNode', "upper(access_key)  =  upper('{$orm->escape($key)}')  " );

    Debug::console( "load  by  key  " . $key, $this->activeNode );

    return $this->activeNode;

  } //end  public  function  loadNodeByKey  */

  /**
   * @param  int  $objid
   * @return  int
   */
  public function delete($objid )
  {

    $orm = $this->getOrm();
    $orm->delete( 'WbfsysKnowHowNode', $objid );

  }//end  public  function  delete  */

  /**
   * @param  int  $key
   * @param  int  $container
   * @return  int
   */
  public function deleteByKey($key, $container )
  {

    $orm = $this->getOrm();
    $orm->deleteWhere( 'WbfsysKnowHowNode', "UPPER(access_key)  =  UPPER('{$orm->escape($key)}')" );

  } //end  public  function  deleteByKey  */

}//end  class  WebfrapKnowhowNode_Model

