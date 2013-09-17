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
 *
 * @package WebFrap
 * @subpackage tech_core
 * @author dominik alexander bonsch <dominik.bonsch@webfrap.net>
 */
class LibAclContainer_Dataset extends LibAclPermission
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var string
   */
  protected $srcKey = null;
  
/*//////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////*/
  
  /**
   * @param int|Entity $rootNode
   * @param int $level
   * @param string $refKey
   */
  public function getRefLevel($rootNode, $level, $refKey)
  {
  
    if (is_object($rootNode)) {
      $rootId = (int)$rootNode->getId();
    } else {
      $rootId = (int)$rootNode;
    }
  
    $rootId = (int)$rootId;
  
    if (DEBUG)
      Debug::console("getRefLevel $rootId, $level, $refKey ".__METHOD__);
  
    if (isset($this->paths[$rootId][$level][$refKey]['level']))
      return $this->paths[$rootId][$level][$refKey]['level'];
  
    if (is_object($rootNode)) {
      /* @var $entity Entity */
      $entity = $rootNode;
    } else {
      $orm = $this->getOrm();
  
      /* @var $entity Entity */
      $entity = $orm->get($this->srcKey, $rootId);
    }
  
    $method = 'path_'.$level.'_'.SParserString::subToCamelCase($refKey);
  
    if (method_exists($this, $method)) {
      $this->$method($entity);
    } else {
      $this->pathRoot($entity, $level, $refKey);
    }
  
    return $this->paths[$rootId][$level][$refKey]['level'];
  
  }//end public function getRefLevel */
  
  /**
   * @param int|Entity $rootNode
   * @param int $level
   * @param string $refKey
   */
  public function getRefRoles($rootNode, $level, $refKey)
  {
  
    if (is_object($rootNode)) {
      $rootId = (int)$rootNode->getId();
    } else {
      $rootId = (int)$rootNode;
    }
  
    if (DEBUG)
      Debug::console("getRefRoles $rootId, $level, $refKey ".__METHOD__);
  
    if (isset($this->paths[$rootId][$level][$refKey]['roles']))
      return $this->paths[$rootId][$level][$refKey]['roles'];
  
    if (is_object($rootNode)) {
      /* @var $entity Entity */
      $entity = $rootNode;
    } else {
      $orm = $this->getOrm();
  
      /* @var $entity Entity */
      $entity = $orm->get($this->srcKey, $rootId);
    }
  
    $method = 'path_'.$level.'_'.SParserString::subToCamelCase($refKey);
  
    if (method_exists($this, $method)) {
      $this->$method($entity);
    } else {
      $this->pathRoot($entity, $level, $refKey);
    }
  
    return $this->paths[$rootId][$level][$refKey]['roles'];
  
  }//end public function getRefRoles */
  
  /**
   * @param int|Entity $rootNode
   * @param int $level
   * @param string $refKey
   */
  public function getRefAccess($rootNode, $level, $refKey)
  {
  
    if (is_object($rootNode)) {
      $rootId = (int)$rootNode->getId();
    } else {
      $rootId = (int)$rootNode;
    }
  
    if (DEBUG)
      Debug::console("getRefAccess $rootId, $level, $refKey ".__METHOD__);
  
    if (isset($this->paths[$rootId][$level][$refKey]))
      return $this->paths[$rootId][$level][$refKey];
  
    if (is_object($rootNode)) {
      /* @var $entity Entity */
      $entity = $rootNode;
    } else {
      $orm = $this->getOrm();
  
      /* @var $entity Entity */
      $entity = $orm->get($this->srcKey, $rootId);
    }
  
    $method = 'path_'.$level.'_'.SParserString::subToCamelCase($refKey);
  
    if (method_exists($this, $method)) {
      $this->$method($entity);
    } else {
      $this->pathRoot($entity, $level, $refKey);
    }
  
    return $this->paths[$rootId][$level][$refKey];
  
  }//end public function getRefAccess */
  
/*//////////////////////////////////////////////////////////////////////////////
// Root Path
//////////////////////////////////////////////////////////////////////////////*/
  
  /**
   * @param Entity $entity
   * @param int $level
   * @param string $refKey
   */
  protected function pathRoot($entity, $level, $refKey)
  {
  
    $rootData = $this->loadRootPath($entity, $level, $refKey);
  
    if ($entity)
      $rootId = (int)$entity->getId();
    else
      $rootId = 0;
  
    $this->paths[$rootId][$level][$refKey] = $rootData;
  
  }//end protected function pathRoot */
  
  /**
   * @param Entity $entity
   * @param int $level
   * @param string $refKey
   */
  protected function loadRootPath($entity, $level, $refKey)
  {
  
    /* @var $acl LibAclAdapter_Db */
    $acl = $this->getAcl();
  
    $roles = array();
    $levels = array(
      'acl-level' => 0,
      'ref-level' => 0
    );

  
    return array(
        'roles' => $roles,
        'levels' => $levels
    );
  
  }//end protected function loadRootPath */

}//end class LibAclPermissionList

