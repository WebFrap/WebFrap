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

  /**
   * @var string
   */
  public $aclKey = null;

  /**
   * @var string
   */
  public $aclPath = null;

  /**
   * @lang:de
   * Einfacher Konstruktor,
   * Der Konstruktor stell sicher, dass die minimal notwendigen daten vorhanden sind.
   *
   * @param string $aclKey
   * @param string $aclPath
   * @param int   $level das zugriffslevel
   * @param array $level array as named parameter access_level,partial
   * {
   *    @see LibAclPermission::$level
   * }
   *
   * @param int $refLevel
   * {
   *   @see LibAclPermission::$refBaseLevel
   * }
   */
  public function __construct(
    $env,
    //$aclKey = null,
    //$aclPath = null,
    $level = null,
    $refBaseLevel = null
  ) {

    //$this->aclKey = $aclKey;
    //$this->aclPath = $aclPath;
    $this->env = $env;

    $this->levels = Acl::$accessLevels;

    if (!is_null($level))
      $this->setPermission($level, $refBaseLevel);

  }//end public function __construct */


  /**
   * @param TFlag $params
   * @param Entity $entity
   */
  public function loadDefault($params, $entity = null)
  {

    // laden der mvc/utils adapter Objekte
    /* @var $acl LibAclAdapter_Db */
    $acl = $this->getAcl();
    $orm = $this->getOrm();

    $entityId = null;
    if (is_object($entity))
      $entityId = $entity->getId();
    else
      $entityId = $entity;

    // wenn keine root übergeben wird oder wir in level 1 sind
    // dann befinden wir uns im root und brauchen keine pfadafrage
    // um potentielle fehler abzufangen wird auch direkt der richtige Root gesetzt
    // nicht das hier einer einen falschen pfad injected
    if (is_null($params->aclRoot) || 1 == $params->aclLevel) {
      $params->isAclRoot = true;
      $params->aclRoot = $this->aclKey;
      $params->aclRootId = $entityId; // die aktive entity ist der root
      $params->aclKey = $this->aclKey;
      $params->aclNode = $this->aclKey;
      $params->aclLevel = 1;
    }

    $areaId = $acl->resources->getAreaId($this->aclKey);

    // eventuellen check Code vorab laden, erweitert die rollen
      // eventuellen check Code vorab laden, erweitert die rollen
    $backPaths = $acl->getPathJoinLevels($areaId);

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
          $this->updatePermission($backPath['access_level'], $backPath['ref_access_level']);
          $this->addRoles(explode(',', $backPath['set_groups']));
        }

      }//end check
    }


    // wenn wir in keinem pfad sind nehmen wir einfach die normalen berechtigungen
    if ($params->isAclRoot) {

      // da wir die zugriffsrechte mehr als nur einmal brauchen holen wir uns
      // direkt einen acl container
      $acl->injectDsetRoles(
        $this,
        $this->aclPath,
        $entity
      );

      // da wir die zugriffsrechte mehr als nur einmal brauchen holen wir uns
      // direkt einen acl container
      $acl->injectDsetLevel(
        $this,
        $this->aclPath,
        $this->roles,
        $entity,
        $this->loadReferences // rechte für die referenzen mitladen
      );

    } else {

      $acl->injectDsetRootPermission(
        $this, // sich selbst als container mit übergeben
        $params->aclRoot,
        $params->aclRootId,
        $params->aclLevel,
        $params->aclNode,
        $entity
      );

      // da wir die zugriffsrechte mehr als nur einmal brauchen holen wir uns
      // direkt das zugriffslevel
      $acl->injectDsetPathPermission(
        $this, // sich selbst als container mit übergeben
        $params->aclRoot,
        $params->aclRootId,
        $params->aclLevel,
        $params->aclKey,
        $params->refId,
        $params->aclNode,
        $entity,
        $this->loadReferences // rechte für die referenzen mitladen
      );

    }
    
    $this->loadCustom($params, $entity);

  }//end public function loadDefault */
  
  public function loadCustom($params, $entity = null)
  {
    
  }  

  /**
   * @param Context $params
   * @param Entity $entity
   */
  public function loadDefReferences($params, $entity = null)
  {

    // laden der mvc/utils adapter Objekte
    /* @var $acl LibAclAdapter_Db */
    $acl = $this->getAcl();
    $orm = $this->getOrm();

    // wenn keine pfadinformationen übergeben werden oder wir in level 1 sind
    // dann befinden wir uns im root und brauchen keine pfadafrage
    if (is_null($params->aclRoot) || 1 == $params->aclLevel) {
      $params->isAclRoot = true;
    }

    // wenn keine root übergeben wird oder wir in level 1 sind
    // dann befinden wir uns im root und brauchen keine pfadafrage
    // um potentielle fehler abzufangen wird auch direkt der richtige Root gesetzt
    // nicht das hier einer einen falschen pfad injected
    if (is_null($params->aclRoot) || 1 == $params->aclLevel) {
      $params->isAclRoot = true;
      $params->aclRoot = $this->aclKey;
      $params->aclRootId = null;
      $params->aclKey = $this->aclKey;
      $params->aclNode = $this->aclKey;
      $params->aclLevel = 1;
    }

    // wenn wir in keinem pfad sind nehmen wir einfach die normalen
    // berechtigungen
    if ($params->isAclRoot) {
      // da wir die zugriffsrechte mehr als nur einmal brauchen holen wir uns
      // direkt einen acl container
      $acl->getDsetRefPermissions(
        $this->aclPath,
        $entity,
        $this     // dieses objekt soll als container verwendet werden
      );

    } else {

      // da wir die zugriffsrechte mehr als nur einmal brauchen holen wir uns
      // direkt das zugriffslevel
      $acl->getPathPermission(
        $params->aclRoot,
        $params->aclRootId,
        $params->aclLevel,
        $params->aclKey,
        $params->refId,
        $params->aclNode,
        $entity,
        true,     // Rollen laden
        $this    // sich selbst als container mit übergeben
      );

    }

  }//end public function loadDefReferences */

}//end class LibAclPermissionList

