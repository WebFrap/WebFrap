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
class AclMgmt_Tree_Model
  extends AclMgmt_Model
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

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

  public $accessLabel = array();

/*//////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////*/

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
    $query  = $db->newQuery( 'AclMgmt_Tree' );
    /* @var $query AclMgmt_Tree_Query  */

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
    $query      = $db->newQuery( 'AclMgmt_Tree' );
    /* @var $query AclMgmt_Tree_Query  */

    $query->fetchAccessTree
    (
      $areaId,
      $idGroup,
      $params
    );
    $result   = $query->getAll();

    $this->accessLabel = array_flip(Acl::$accessLevels);

    $index    = array();
    foreach( $result as $pos => $node )
    {

      $index[$node['m_parent'].'-'.((int)$node['depth']-1)][] = $node;

      if( $node['real_parent'] )
        $index[$node['real_parent'].'-'.((int)$node['depth']-1)][] = $node;

      Debug::console( 'node '.$pos.': '.$node['m_parent'].'-'.((int)$node['depth']-1), $node, null,true );
    }

    $rootList         = array();

    // the first node must be the root node
    $node       = $result[0];
    // start build the nodes
    $root        = new stdClass();
    $rootList[]  = $root;
    $root->key   = $node['rowid'].'-'.$node['depth'];
    $root->title = $node['label'];
    $root->children = array();

    $data         = new stdClass();
    $root->data   = $data;
    $data->key    = $node['access_key'];
    $data->depth  = $node['depth'];
    $data->label  = $node['label'];
    $data->id     = $node['rowid'];
    $data->assign = $node['assign_id'];
    $data->target = $node['target'];
    $data->real_parent = $node['real_parent'];
    $data->access_level     = $node['access_level'];
    $data->description      = $node['description'];
    $data->area_description = ' Access: <strong>'.
      (
        isset($this->accessLabel[$node['access_level']])
          ?$this->accessLabel[$node['access_level']]
          :'None'
      ).'</strong>'.NL.$node['area_description'];

    // build the tree recursive
    $this->buildReferenceTree( $index, $root, $node['id_parent'].'-'.$node['depth'], $node['rowid'] );

    if
    (
      $node['real_parent']
        && ( isset($this->accessLabel[$node['access_level']]) && $this->accessLabel[$node['access_level']]  )
    )
    {
      Debug::console( 'in realpath: '.$node['real_parent'].'-'.$node['depth'], $node, null,true );
      $this->buildReferenceTree
      (
        $index,
        $child,
        $node['real_parent'].'-'.$node['depth'],
        $node['rowid'].'-'.$pathId
      );
    }

    return json_encode($rootList);

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
        $child        = new stdClass();
        $parent->children[]     = $child;
        $child->key   = $node['rowid'].'-'.$pathId.'-'.$node['depth'];
        $child->title = $node['label'].$this->levelLabel( $node['access_level'] );

        if( $node['real_parent'] )
          Debug::console( 'children: '.$parentId.' '.$node['access_key'].' '.$node['real_parent'] );

        $data         = new stdClass();
        $child->data  = $data;
        $data->key    = $node['access_key'];
        $data->depth  = $node['depth'];
        $data->label  = $node['label'];
        $data->id     = $node['rowid'];
        $data->assign = $node['assign_id'];
        $data->target = $node['target'];
        $data->real_parent = $node['real_parent'];
        $data->access_level     = $node['access_level'];
        $data->description      = $node['description'];
        $data->area_description = ' Access: <strong>'.
          (
            isset($this->accessLabel[$node['access_level']])
              ?$this->accessLabel[$node['access_level']]
              :'None'
          ).'</strong>'.NL.$node['area_description'];


        $child->children  = array();

        $this->buildReferenceTree
        (
          $index,
          $child,
          $node['id_parent'].'-'.$node['depth'],
          $node['rowid'].'-'.$pathId
        );

        if
        (
          $node['real_parent']
            && ( isset($this->accessLabel[$node['access_level']]) && $this->accessLabel[$node['access_level']]  )
        )
        {
          Debug::console( 'in realpath: '.$node['real_parent'].'-'.$node['depth'], $node, null,true );
          $this->buildReferenceTree
          (
            $index,
            $child,
            $node['real_parent'].'-'.$node['depth'],
            $node['rowid'].'-'.$pathId
          );
        }

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
      'id_real_area',
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

  protected function levelLabel( $level )
  {
    return isset( $this->accessLabel[$level] )? ' <span class="access l_'.$this->accessLabel[$level].'" >'.$this->accessLabel[$level].'</span> ':'';
  }

  /**
   * @param int $pathId
   * @return boolean
   */
  public function dropPath( $pathId )
  {

    $db   = $this->getDb();
    $orm  = $db->getOrm();

    $dropQuery = $db->newQuery( 'AclMgmt_Tree' );
    /* @var $dropQuery AclMgmt_Tree_Query  */

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

} // end class AclMgmt_Tree_Model */

