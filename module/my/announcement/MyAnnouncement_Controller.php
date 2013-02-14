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
 * @subpackage ModAnnouncement
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright webfrap.net <contact@webfrap.net>
 */
class MyAnnouncement_Controller extends ControllerCrud
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/
    
  /**
   * Mit den Options wird der zugriff auf die Service Methoden konfiguriert
   * 
   * method: Der Service kann nur mit den im Array vorhandenen HTTP Methoden
   *   aufgerufen werden. Wenn eine falsche Methode verwendet wird, gibt das 
   *   System automatisch eine "Method not Allowed" Fehlermeldung zurück
   * 
   * views: Die Viewtypen die erlaubt sind. Wenn mit einem nicht definierten
   *   Viewtype auf einen Service zugegriffen wird, gibt das System automatisch
   *  eine "Invalid Request" Fehlerseite mit einer Detailierten Meldung, und der
   *  Information welche Services Viewtypen valide sind, zurück
   *  
   * public: boolean wert, ob der Service auch ohne Login aufgerufen werden darf
   *   wenn nicht vorhanden ist die Seite per default nur mit Login zu erreichen
   * 
   * @var array
   */
  protected $options           = array
  (
    'archive' => array
    (
      'method'    => array( 'PUT' ),
      'views'      => array( 'ajax' )
    ),
  );


/*//////////////////////////////////////////////////////////////////////////////
// Crud Methodes
//////////////////////////////////////////////////////////////////////////////*/



 /**
  * de:
  * service zum löschen eines eintrags aus der datenbank
  * der eintrag muss direkt mit der rowid adressiert werden
  *
  * @access DELETE ajax.php?c=Wbfsys.Announcement.delete&amp;objid=123
  *
  * @param LibRequestHttp $request
  * @param LibResponseHttp $response
  * @return boolean success flag
  */
  public function service_archive( $request, $response )
  {

    // resource laden
    $user      = $this->getUser();

    // prüfen ob eine valide id mit übergeben wurde
    if (!$objid = $this->getOID( ) )
    {
      // wenn nicht ist die anfrage per definition invalide
      throw new InvalidRequest_Exception
      (
        $response->i18n->l
        (
          'The Request for {@resource@} was invalid. ID was missing!',
          'wbf.message',
          array
          (
            'resource' => $response->i18n->l( 'Announcement', 'wbfsys.announcement.label' )
          )
        ),
        Response::BAD_REQUEST
      );
    }

    // erst mal brauchen wir das passende model
    $model = $this->loadModel( 'MyAnnouncement' );

    // dann das passende entitiy objekt für den datensatz
    $entityWebfrapAnnouncement = $model->getEntityWebfrapAnnouncement( $objid );

    // wenn null zurückgegeben wurde existiert der datensatz nicht
    // daher muss das System eine 404 Meldung zurückgeben
    if (!$entityWebfrapAnnouncement )
    {
      // if not this request is per definition invalid
      throw new InvalidRequest_Exception
      (
        $response->i18n->l
        (
          'The requested {@resource@} for ID {@id@} not exists!',
          'wbf.message',
          array
          (
            'resource'  => $response->i18n->l( 'Announcement', 'wbfsys.announcement.label' ),
            'id'        => $objid
          )
        ),
        Response::NOT_FOUND
      );
    }

    // interpret the given user parameters
    $params = $this->getCrudFlags( $request );

    // der contextKey wird benötigt um potentielle Konflikte in der UI
    // bei der Anzeige von mehreren Windows oder Tabs zu vermeiden
    $params->contextKey = 'wbfsys_announcement-archive-'.$objid;

    $access = new WebfrapAnnouncement_Crud_Access_Update( null, null, $this );
    $access->load( $user->getProfileName(), $params, $entityWebfrapAnnouncement );



    // der Access Container des Users für die Resource wird als flag übergeben
    $params->access = $access;

    $error = $model->archive( $entityWebfrapAnnouncement, $params );

    // try to delete the dataset
    if( $error )
    {
      // hm ok irgendwas ist gerade ziemlich schief gelaufen
      return $error;
    }

    // wunderbar, kein fehler also melden wir einen Erfolg zurück
    return null;

  }//end public function service_archive */



} // end class MyAnnouncement_Controller */

