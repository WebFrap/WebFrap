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
class LibAclContainer_Reference extends LibAclPermission
{

  /**
   * @var string
   */
  protected $refAclKey = null;

  /**
   * @var string
   */
  protected $srcName = null;

  /**
   * @var string
   */
  protected $aclKey = null;

  /**
   * @var string
   */
  protected $aclQuery = null;

  /**
   * @lang:de
   * Einfacher Konstruktor,
   * Der Konstruktor stell sicher, dass die minimal notwendigen daten vorhanden sind.
   *
   * @param Base $env
   * @param string $refDomainKey
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
    $level = null,
    $refBaseLevel = null
  ) {


    $this->env = $env;
    $this->levels = Acl::$accessLevels;

    if (!is_null($level))
      $this->setPermission($level, $refBaseLevel);

  }//end public function __construct */


  /**
   * @param TFlag $params
   * @param Entity: ProjectPartner_Entity $entity
   */
  public function loadDefault($params, $entity = null)
  {

    // laden der mvc/utils adapter Objekte
    /* @var $acl LibAclAdapter_Db */
    $acl = $this->getAcl();

    // erst mal root laden
    $acl->injectDsetRootPermission(
	    $this,
      $params->aclRoot,
      $params->aclRootId,
      $params->aclLevel,
      $this->refAclKey
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
      $this->refAclKey,
      $entity,
      false // keine rechte für die referenzen mitladen
    );

  }//end public function loadDefault */



}//end class LibAclPermissionList

