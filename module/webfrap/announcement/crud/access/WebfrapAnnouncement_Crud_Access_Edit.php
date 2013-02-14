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
class WebfrapAnnouncement_Crud_Access_Edit extends LibAclPermission
{
  /**
   * @param TFlag $params
   * @param WbfsysAnnouncement_Entity $entity
   */
  public function loadDefault($params, $entity = null )
  {

    // laden der benötigten Resource Objekte
    $acl = $this->getAcl();

    // wenn keine root übergeben wird oder wir in level 1 sind
    // dann befinden wir uns im root und brauchen keine pfadafrage
    // um potentielle fehler abzufangen wird auch direkt der richtige Root gesetzt
    // nicht das hier einer einen falschen pfad injected
    if (is_null($params->aclRoot) || 1 == $params->aclLevel )
    {
      $params->isAclRoot     = true;
      $params->aclRoot       = 'mgmt-wbfsys_announcement';
      $params->aclRootId     = $entity->getid(); // die aktive entity ist der root
      $params->aclKey        = 'mgmt-wbfsys_announcement';
      $params->aclNode       = 'mgmt-wbfsys_announcement';
      $params->aclLevel      = 1;
    }

    // wenn wir in keinem pfad sind nehmen wir einfach die normalen
    // berechtigungen
    if ($params->isAclRoot )
    {
      // da wir die zugriffsrechte mehr als nur einmal brauchen holen wir uns
      // direkt einen acl container
      $acl->getFormPermission
      (
        'mod-wbfsys>mgmt-wbfsys_announcement',
        $entity,
        true,     // Rollen laden
        $this    // dieses objekt soll als container verwendet werden
      );
    } else {
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
        true,     // rechte der referenzen mit laden
        $this    // sich selbst als container mit übergeben
      );
    }
    


  }//end public function loadDefault */

}//end class WbfsysAnnouncement_Crud_Access_Edit

