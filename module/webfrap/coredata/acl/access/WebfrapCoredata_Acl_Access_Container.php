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
class WebfrapCoredata_Acl_Access_Container
  extends LibAclPermission
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @var string Der Acl Key
   * @example mod-project-cat-core_data
   */
  public $aclKey = null;
  
  /**
   * @var string Der Acl Key des Modules
   * @example mod-project>mod-project-cat-core_data
   */
  public $aclPath = null;
  
////////////////////////////////////////////////////////////////////////////////
// Getter & Setter
////////////////////////////////////////////////////////////////////////////////
  
  /**
   * @param string $key
   */
  public function setDomainKey( $key )
  {
    
    $this->aclKey = 'mod-'.$key.'-cat-core_data';
    $this->aclKey = 'mod-'.$key.'>mod-'.$key.'-cat-core_data';
    
  }//end public function setDomainKey */
  
////////////////////////////////////////////////////////////////////////////////
// Logic
////////////////////////////////////////////////////////////////////////////////
  
  /**
   * @param TFlag $params
   * @param ProjectIteration_Entity $entity
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
      $params->aclRoot       = $this->aclKey;
      $params->aclRootId     = null;
      $params->aclKey        = $this->aclKey;
      $params->aclNode       = $this->aclKey;
      $params->aclLevel      = 1;
    }

    // ok nun kommen wir zu der zugriffskontrolle
    $acl = $this->getAcl();

    // wenn wir in keinem pfad sind nehmen wir einfach die normalen
    // berechtigungen
    if( $params->isAclRoot )
    {
      // da wir die zugriffsrechte mehr als nur einmal brauchen holen wir uns
      // direkt einen acl container
      $access = $acl->getPermission
      (
        $this->aclPath,
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

}//end class ProjectIteration_Acl_Access_Container

