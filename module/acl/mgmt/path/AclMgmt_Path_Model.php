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
 * Read before change:
 * It's not recommended to change this file inside a Mod or App Project.
 * If you want to change it copy it to a custom project.

 *
 * @package WebFrap
 * @subpackage Acl
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright webfrap.net <contact@webfrap.net>
 */
class AclMgmt_Path_Model
  extends AclMgmt_Model
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * the id of the active area
   * @var int
   */
  protected $areaId = null;

  /**
   *
   * @var WbfsysSecurityPath_Entity
   */
  protected $entityWbfsysSecurityPath = null;

  /**
   * Index um eine Rekursion zu verhindern
   * @var array
   */
  protected $preventRecursionIndex = array();
  
  /**
   * Der aktive Domain Node
   * @var DomainNode
   */
  public $domainNode = null;

////////////////////////////////////////////////////////////////////////////////
// Methodes
////////////////////////////////////////////////////////////////////////////////

 /**
  * returns the activ main entity with data, or creates a empty one
  * and returns it instead
  */
  public function getAssignId( )
  {

    return null;

  }//end public function getAssignId */

  /**
   * @return WbfsysSecurityPath_Entity
   */
  public function getPathEntity()
  {
    return $this->entityWbfsysSecurityPath;
  }//end public function getPathEntity */

  /**
   * request the id of the activ area
   * @param int $groupId
   * @return WbfsysRoleGroup_Entity
   */
  public function getGroup( $groupId )
  {

    $orm = $this->getOrm();
    return $orm->get( 'WbfsysRoleGroup', (int)$groupId );

  }//end public function getGroup */



  /**
   * @param int $areaId
   * @param int $idGroup
   * @param TArray $params
   */
  public function getAreaGroups( $areaId, $idGroup, $params )
  {

    $db     = $this->getDb();
    $query  = $db->newQuery( 'AclMgmt_Qfdu' );
    /* @var $query AclMgmt_Qfdu_Query  */

    $query->fetchAreaGroups
    (
      $areaId,
      $params
    );

    return $query->getAll();

  }//end public function getAreaGroups */

  /**
   * @param int $areaId
   * @param int $idGroup
   * @param TArray $params
   */
  public function getReferences( $areaId, $idGroup, $params )
  {
  

    $db         = $this->getDb();
    $query      = $db->newQuery( 'AclMgmt_Path' );
    /* @var $query AclMgmt_Path_Query  */

    $query->fetchAccessTree
    (
      $areaId,
      $idGroup,
      $params
    );
    $result   = $query->getAll();


    $index    = array();
    foreach( $result as $node )
    {
      $index[$node['m_parent']][] = $node;
    }

    // the first node must be the root node
    $node       = $result[0];
    // start build the nodes
    $root       = new TJsonObject();
    $root->id   = $node['rowid'];
    $root->name = $node['label'];

    $data         = new TJsonObject();
    $root->data   = $data;
    $data->key    = $node['access_key'];
    $data->depth  = $node['depth'];
    $data->label  = $node['label'];
    $data->id     = $node['rowid'];
    $data->assign = $node['assign_id'];
    $data->target = $node['target'];
    $data->access_level     = $node['access_level'];
    $data->description      = $node['description'];
    $data->area_description = ' Access: <strong>'.
      (
        isset(Acl::$accessLevels[$node['access_level']])
          ?Acl::$accessLevels[$node['access_level']]
          :'None'
      ).'</strong>'.NL.$node['area_description'];

    $children         = new TJsonArray();
    $root->children   = $children;

    // build the tree recursive
    $this->buildReferenceTree( $index, $children, $node['id_parent'], $node['rowid'] );

    return $root;

  }//end public function loadReferences */

  /**
   * @param array $index
   * @param TJsonArray $parent
   * @param int $parentId
   * @param int $pathId
   */
  protected function buildReferenceTree( $index, $parent, $parentId, $pathId )
  {
  
    if( !isset( $this->preventRecursionIndex[$parentId] ) )
    {
      $this->preventRecursionIndex[$parentId] = true;
    }
    else 
    {
      return null;
    }

    if( isset( $index[$parentId] ) )
    {
      foreach( $index[$parentId] as $node )
      {
        $child        = new TJsonObject();
        $parent[]     = $child;
        $child->id    = $node['rowid'].'-'.$pathId.'-'.$node['depth'];
        $child->name  = $node['label'];

        $data         = new TJsonObject();
        $child->data  = $data;
        $data->key    = $node['access_key'];
        $data->depth  = $node['depth'];
        $data->label  = $node['label'];
        $data->id     = $node['rowid'];
        $data->assign = $node['assign_id'];
        $data->target = $node['target'];
        $data->access_level     = $node['access_level'];
        $data->description      = $node['description'];
        $data->area_description = ' Access: <strong>'.
          (
            isset(Acl::$accessLevels[$node['access_level']])
              ?Acl::$accessLevels[$node['access_level']]
              :'None'
          ).'</strong>'.NL.$node['area_description'];


        $children         = new TJsonArray();
        $child->children  = $children;

        $this->buildReferenceTree( $index, $children, $node['id_parent'], $node['rowid'].'-'.$pathId );
      }
    }

  }//end protected function buildReferenceTree */

/*//////////////////////////////////////////////////////////////////////////////
// CRUD Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param int $objid
   * @return boolean
   */
  public function fetchPathInput( $objid )
  {

    $httpRequest = $this->getRequest();
    $orm         = $this->getOrm();

    if( $objid )
    {
      $entityWbfsysSecurityPath = $orm->get( 'WbfsysSecurityPath', (int)$objid );
    }
    else
    {
      $entityWbfsysSecurityPath = new WbfsysSecurityPath_Entity;
    }

    $fields = array
    (
      'access_level',
      'id_group',
      'id_reference',
      'id_area',
      'description',
    );

    $httpRequest->validateUpdate
    (
      $entityWbfsysSecurityPath,
      'security_path',
      $fields
    );

    $entityWbfsysSecurityPath->id_root = $this->getAreaId();

    $this->entityWbfsysSecurityPath = $entityWbfsysSecurityPath;

    // check if there where any errors if not fine
    return !$this->getResponse()->hasErrors();

  }//end public function fetchPathInput */

  /**
   * save the
   * @throws LibDb_Exception
   */
  public function savePath()
  {

    $orm         = $this->getOrm();
    $orm->save( $this->entityWbfsysSecurityPath );

  }//end public function savePath */

  /**
   * @param int $pathId
   * @return boolean
   */
  public function dropPath( $pathId )
  {

    $db   = $this->getDb();
    $orm  = $db->getOrm();

    $dropQuery = $db->newQuery( 'AclMgmt_Path' );
    /* @var $dropQuery AclMgmt_Path_Query  */

    try
    {
      $db->begin();
      $orm->delete( 'WbfsysSecurityPath', $pathId );
      $db->commit();
    }
    catch( LibDb_Exception $e )
    {
      $db->rollback();
      return false;
    }

    return true;

  }//end public function dropPath */

} // end class AclMgmt_Path_Model */

