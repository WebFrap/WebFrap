<h1>Access Container</h1>

<p>
Über Access Container werden komplexe Zugriffsrechte verwaltet.
Diese enthalten die komplette Logik zum laden, sowie alle nötigen Berechtigungsdaten
welche im aktuellen Kontext benötigt werden.
</p>

<p>
Es empfieht sich einen Access Container für jeden Use Case anzulegen.
Der Container wird im Controller erstellt, wo er verwendet wird um die Basisrechte
zu prüfen.<br />
Für detailierte Prüfungen wird der Container dann über die Parameter an die
View und das Modell weiter gereicht.
</p>

<label></label>
<?php start_highlight(); ?>
/**
 * Acl Rechte Container über den alle Berechtigungen geladen werden
 *
 * @package WebFrap
 * @subpackage ModProject
 * @author Dominik Bonsch <dominik.bonsch@s-db.de>
 * @copyright Softwareentwicklung Dominik Bonsch <contact@webfrap.net>
 */
class ProjectMilestone_Crud_Access_Edit
  extends LibAclPermission
{

  /**
   * @param TFlag $rqtContext
   * @param ProjectMilestone_Entity $entity
   */
  public function loadDefault( $rqtContext, $entity = null )
  {

    // laden der benötigten Resource Objekte
    $acl = $this->getAcl();
    
    $entityId = null;
    if( is_object( $entity ) )
      $entityId = $entity->getId();
    else 
      $entityId = $entity;

    // wenn keine root übergeben wird oder wir in level 1 sind
    // dann befinden wir uns im root und brauchen keine pfadafrage
    // um potentielle fehler abzufangen wird auch direkt der richtige Root gesetzt
    // nicht das hier einer einen falschen pfad injected
    if( is_null($rqtContext->aclRoot) || 1 == $rqtContext->aclLevel )
    {
      $rqtContext->isAclRoot     = true;
      $rqtContext->aclRoot       = 'mgmt-project_milestone';
      $rqtContext->aclRootId     = $entityId; // die aktive entity ist der root
      $rqtContext->aclKey        = 'mgmt-project_milestone';
      $rqtContext->aclNode       = 'mgmt-project_milestone';
      $rqtContext->aclLevel      = 1;
    }

    // wenn wir in keinem pfad sind nehmen wir einfach die normalen
    // berechtigungen
    if( $rqtContext->isAclRoot )
    {
      // da wir die zugriffsrechte mehr als nur einmal brauchen holen wir uns
      // direkt einen acl container
      $acl->getFormPermission
      (
        'mod-project>mgmt-project_milestone',
        $entity, // Die aktive Entity / EntityID
        true,    // Rollen laden
        $this    // dieses objekt soll als container verwendet werden
      );
    }
    else
    {
      // da wir die zugriffsrechte mehr als nur einmal brauchen holen wir uns
      // direkt das zugriffslevel
      $acl->getPathPermission
      (
        $rqtContext->aclRoot,
        $rqtContext->aclRootId,
        $rqtContext->aclLevel,
        $rqtContext->aclKey,
        $rqtContext->refId,
        $rqtContext->aclNode,
        $entity,
        true,     // rechte der referenzen mit laden
        $this    // sich selbst als container mit übergeben
      );
    }

  }//end public function loadDefault */

}//end class ProjectMilestone_Crud_Access_Edit
<?php display_highlight( 'php' ); ?>