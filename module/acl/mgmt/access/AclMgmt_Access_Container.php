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
 * Acl Rechte Container über den alle Berechtigungen geladen werden
 *
 * @package WebFrap
 * @subpackage Core
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright webfrap.net <contact@webfrap.net>
 */
class AclMgmt_Access_Container
  extends LibAclPermission
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/
  
  /**
   * @var DomainNode
   */
  public $domainNode = null;
  
/*//////////////////////////////////////////////////////////////////////////////
// Constructor
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @lang:de
   * Einfacher Konstruktor,
   * Der Konstruktor stell sicher, dass die minimal notwendigen daten vorhanden sind.
   *
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
   * 
   * @param DomainNode $domainNode
   * 
   */
  public function __construct
  (
    $level = null,
    $refBaseLevel = null,
    $env = null,
    $domainNode = null
  )
  {

    if( !$env )
    {
      $env = Webfrap::$env;
    }
    
    $this->env = $env;
    
    $this->levels = Acl::$accessLevels;

    if( !is_null( $level ) )
      $this->setPermission( $level, $refBaseLevel );
      
    $this->domainNode = $domainNode;

  }//end public function __construct */
  
  /**
   * @param TFlag $params
   * @param Entity $entity
   */
  public function loadDefault( $params, $entity = null )
  {

    // laden der benötigten Resource Objekte
    $acl = $this->getAcl();

    // wenn keine acl root übergeben wird, da befinden wir uns an dem
    // startpunkt für einen potentiell vorhandenen rechte pfad
    if( is_null( $params->aclRoot )  )
    {
      $params->isAclRoot     = true;
      $params->aclRoot       = $this->domainNode->aclBaseKey;
      $params->aclRootId     = null;
      $params->aclKey        = $this->domainNode->aclBaseKey;
      $params->aclNode       = $this->domainNode->aclBaseKey;
      $params->aclLevel      = 1;
    }

    // wenn wir in keinem pfad sind nehmen wir einfach die normalen
    // berechtigungen
    if( $params->isAclRoot )
    {
      // da wir die zugriffsrechte mehr als nur einmal brauchen holen wir uns
      // direkt einen acl container
      $access = $acl->getPermission
      (
        $this->domainNode->aclKey,
        $entity,
        false,     // keine rechte der referenzen laden
        $this     // dieses objekt soll als container verwendet werden
      );
    }
    else
    {
      // da wir die zugriffsrechte mehr als nur einmal brauchen holen wir uns
      // direkt das zugriffslevel
      $acl->getPathPermission
      (
        $params->aclRoot,
        $params->aclRootId,
        $params->aclLevel,
        $params->aclKey,
        $params->refId,
        $params->aclNode,
        $entity,
        false,    // keine rechte der referenzen laden
        $this    // sich selbst als container mit übergeben
      );
    }

  }//end public function loadDefault */

}//end class AclMgmt_Access_Container

