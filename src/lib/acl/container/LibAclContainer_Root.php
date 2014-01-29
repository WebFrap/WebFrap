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
class LibAclContainer_Root extends LibAclRoot
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var string
   */
  protected $srcKey = null;

  /**
   * @var string
   */
  protected $aclKey = null;

  /**
   * @var string
   */
  protected $pathKey = null;

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
      Log::debug("getRefLevel $rootId, $level, $refKey ");

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

    $this->pathRoot($entity, $level, $refKey);

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
      Log::debug("getRefRoles $rootId, $level, $refKey ");

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

    $this->pathRoot($entity, $level, $refKey);

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
      Log::debug("getRefAccess $rootId, $level, $refKey ");

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

    $this->pathRoot($entity, $level, $refKey);
    
    if (isset($this->paths[$rootId][$level][$refKey]))
        return $this->paths[$rootId][$level][$refKey];
    else 
        return 0;

    //return $this->paths[$rootId][$level][$refKey];

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
    $level = 0;

    $pathKey = $this->pathKey;
    if (!$pathKey)
      $pathKey = $this->aclKey;

    $areaId = $acl->resources->getAreaId($pathKey);

    // eventuellen check Code vorab laden, erweitert die rollen
    // eventuellen check Code vorab laden, erweitert die rollen
    $backPaths = $acl->getPathJoinLevels($areaId);

    $roles = array();

    // impliziete Rechtevergabe
    foreach ($backPaths as $backPath) {

      if (is_object($entity) && $entity->{$backPath['ref_field']}) {

        $pathRoles = explode(',', $backPath['groups']);

        // prüfen ob der user die Rolle hat
        $hasRole = $acl->hasRole(
          $pathRoles,
          $backPath['target_area_key'],
          $entity->{$backPath['ref_field']}
        );

        // wenn der user gruppenmitglied ist die neuen level setzen
        if ($hasRole) {

          if ((int)$backPath['ref_access_level'] > $level ) {
            $level = (int)$backPath['ref_access_level'];
          }

          //$roles = array_merge($roles, explode(',', $backPath['set_ref_groups']));
        }

      }//end check
    }

    return array(
      'roles' => $roles,
      'level' => $level
    );

  }//end protected function loadRootPath */

}//end class LibAclPermissionList

