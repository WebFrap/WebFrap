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
class WebfrapAnnouncement_Crud_Controller
  extends ControllerCrud
{
  
 /**
  *
  * de:
  * {
  *   Diese Methode erstellt das Markup für ein Formular zum erstellen eines
  *   Datensatzes des types: wbfsys_message
  *
  *   Diese Methode kann sowohl mit GET als mit POST angesprochen werden.
  *   Mit POST können direkt Standardwerte in ein Formular übergeben weden
  *
  *   Unterstüzte Views:
  *   <ul>
  *     <li>Maintab (standard)</li>
  *     <li>Mainwindow</li>
  *     <li>Subwindow</li>
  *   </ul>
  *   @tutorial <a href="http://webfrap.net/doc/{{version}}/index.php?page=architecture.views.overview" >Tutorial Viewtypes</a>
  *
  *   @url maintab.php?c=Wbfsys.Message.create
  *
  *   @type UI Service
  *   @param LibRequestHttp $request
  *   @param LibResponseHttp $response
  *   @return boolean im fehler false
  * }
  */
  public function service_create( $request, $response )
  {

    // resource laden
    $user      = $this->getUser();
    
    // prüfen ob irgendwelche steuerflags übergeben wurde
    $params  = $this->getFormFlags( $request );

    // der contextKey wird benötigt um potentielle Konflikte in der UI
    // bei der Anzeige von mehreren Windows oder Tabs zu vermeiden
    $params->contextKey = 'my_message-create';

    $access = new WbfsysMessage_Crud_Access_Create( null, null, $this );
    $access->load( $user->getProfileName(), $params );

    // der Access Container des Users für die Resource wird als flag übergeben
    $params->access = $access;

    // wenn er keine neuen Datensätze erstellen darf können wir direkt aufhören
    if( !$access->insert )
    {
      // ausgabe einer fehlerseite und adieu
      throw new InvalidRequest_Exception
      (
        $response->i18n->l
        (
          'You have no permission to create new entries for {@resource@}!',
          'wbf.message',
          array
          (
            'resource' => $response->i18n->l
            (
              'Message',
              'wbfsys.message.label'
            )
          )
        ),
        Response::FORBIDDEN
      );
    }

    $view = $response->loadView
    (
      'form-my_message-create',
      'MyMessage_Crud_Create',
      'displayForm'
    );

    if( !$view )
    {
      // ok scheins wurde ein view type angefragt der nicht für dieses
      // action methode implementiert ist
      throw new InvalidRequest_Exception
      (
        $response->i18n->l
        (
          'The requested View is not implemented for this action!',
          'wbf.message'
        ),
        Response::NOT_IMPLEMENTED
      );
    }


    // laden des models und direkt übergabe in die view
    $model = $this->loadModel( 'MyMessage_Crud' );
    $view->setModel( $model );

    // die view zum baue des formulars veranlassen
    $error = $view->displayForm( $params );

    // Die Views geben eine Fehlerobjekt zurück, wenn ein Fehler aufgetreten
    // ist der so schwer war, dass die View den Job abbrechen musste
    // alle nötigen Informationen für den Enduser befinden sich in dem
    // Objekt
    // Standardmäßig entscheiden wir uns mal dafür diese dem User auch Zugänglich
    // zu machen und übergeben den Fehler der ErrorPage welche sich um die
    // korrekte Ausgabe kümmert
    if( $error )
    {

      return $error;
    }

    // wunderbar, kein fehler also melden wir einen Erfolg zurück
    return null;


  }//end public function service_create */
  
/*//////////////////////////////////////////////////////////////////////////////
// Crud Persistence Methodes
//////////////////////////////////////////////////////////////////////////////*/
    
 /**
  * de:
  * Service zum Erstellen neuer Datensätze des types: wbfsys_message
  *
  * Diese Methode kann nur mit POST angesprochen werden, da nur vorgesehen
  * is neue datensätze anzuhängen, jedoch keine mit einer vorgegebenen ID
  * zu erstellen.
  *
  * @call POST ajax.php?c=Wbfsys.Message.insert
  * {
  *   @get_param: cname ltype, der Type der des Listenelements. Sollte sinnigerweise
  *     der gleich type wie das Listenelement sein, für das die Suche angestoßen wurde
  *
  *   @get_param: cname view_type, der genaue View Type, zb. Maintab, Subwindow etc.,
  *     welcher verwendet wurde den eintrag zu erstellen.
  *     Wird benötigt um im client die maske ansprechen zu können
  *
  *   @get_param: cname mask, Mask ist ein key mit dem angegeben wird welche
  *     View genau verwendet werden soll. Dieser Parameter ist nötig, da es pro
  *     tabelle mehrere management sichten geben kann die jeweils eigenen
  *     listenformate haben
  *
  *   @get_param: cname refid, Wird benötigt wenn dieser Datensatz in Relation
  *     zu einem Hauptdatensatz als referenz in einem Tab, bzw ManyToX Element
  *     erstellt wurde.
  *
  *   @get_param: cname view_id, Die genaue ID der Maske. Wird benötigt um
  *     die Maske bei der Rückgabe adressieren zu können
  *
  * }
  * 
  * @param LibRequestHttp $request
  * @param LibResponseHttp $response
  *
  * @return boolean im fehler false
  */
  public function service_send( $request, $response )
  {

    // resource laden
    $user      = $this->getUser();

    // create named params object
    $params = $this->getCrudFlags( $request );

    // der contextKey wird benötigt um potentielle Konflikte in der UI
    // bei der Anzeige von mehreren Windows oder Tabs zu vermeiden
    $params->contextKey = 'wbfsys_message-send';

    $access = new WbfsysMessage_Crud_Access_Insert( null, null, $this );
    $access->load( $user->getProfileName(),  $params );

    // ok wenn er nichtmal lesen darf, dann ist hier direkt schluss
    if( !$access->insert )
    {
      // ausgabe einer fehlerseite und adieu
      throw new InvalidRequest_Exception
      (
        $response->i18n->l
        (
          'You have no permission to create {@resource@}',
          'wbf.message',
          array
          (
            'resource' => $response->i18n->l
            (
              'Message',
              'wbfsys.message.label'
            )
          )
        ),
        Response::FORBIDDEN
      );
    }

    // der Access Container des Users für die Resource wird als flag übergeben
    $params->access = $access;

    // das crud model wird zum validieren des requests und zum erstellen
    // des neuen datensatzes benötigt
    $model = $this->loadModel( 'MyMessage_Crud' );

    // die genauen fehlermeldungen werden direkt vom validator in die
    // message queue gepackt
    if( $error = $model->fetchInsertData( $params ) )
    {
      // wenn die daten nicht valide sind, dann war es eine ungültige anfrage
      throw new InvalidRequest_Exception
      (
        $response->i18n->l
        (
          'The Insert Request for {@resource@} was invalid.',
          'wbf.message',
          array
          (
            'resource' => $response->i18n->l( 'Message', 'wbfsys.message.label' )
          )
        ),
        Response::BAD_REQUEST
      );
    }


    // die daten in die datenbank persistieren
    // das modell hat die entity bereits in sich, daher müssen wir hier
    // nur noch die anweisung zum speichern geben
    if( $error = $model->send( $params ) )
    {

      // hm ok irgendwas ist gerade ziemlich schief gelaufen
      throw new InvalidRequest_Exception
      (
        $error->message,
        $error->errorKey
      );
    }
    else
    {
      
      /*
      
        if( !$params->ltype )
          $params->ltype = 'table';
  
        if( !$params->viewType )
          $params->viewType = 'maintab';
  
        $listType = ucfirst( $params->ltype );
  
        // die Maske über welche der neue Liste Eintrag gerendert werden soll
        if( !$params->mask )
          $params->mask = 'WbfsysMessage';
  
        // laden der angeforderten view
        $view = $response->loadView
        (
          'listing_wbfsys_message',
          $params->mask.'_'.$listType,
          'displayInsert'
        );
  
  
      if( !$view )
      {
        // ok scheins wurde ein view type angefragt der nicht für dieses
        // action methode implementiert ist
        throw new InvalidRequest_Exception
        (
          $response->i18n->l
          (
            'The requested View is not implemented for this action!',
            'wbf.message'
          ),
          Response::NOT_IMPLEMENTED
        );
      }



      // model wird benötigt
      $view->setModel( $this->loadModel( $params->mask.'_'.$listType ) );

      $error = $view->displayInsert( $params );

      // im Fehlerfall jedoch bekommen wir eine Error Objekt das wird noch kurz
      // behandeln sollten
      if( $error )
      {
        return $error;
      }
      
      */

    }


    // wenn wir hier ankommen, dann hat alles geklappt
    return true;

  }//end public function service_insert */
  
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
  public function service_delete( $request, $response )
  {

    // resource laden
    $user      = $this->getUser();


    // prüfen ob die verwendete HTTP Methode für diesen service
    // überhaupt erlaub ist
    if( !( $request->method( Request::DELETE ) ) )
    {

      // ausgabe einer fehlerseite und adieu
      throw new InvalidRequest_Exception
      (
        $response->i18n->l
        (
          'The request method {@method@} is not allowed for this action! Use {@use@}.',
          'wbf.message',
          array
          (
            'method' => $request->method(),
            'use'    => 'DELETE'
          )
        ),
        Error::METHOD_NOT_ALLOWED
      );

    }



    // prüfen ob eine valide id mit übergeben wurde
    if( !$objid = $this->getOID( ) )
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
    $model = $this->loadModel( 'WebfrapAnnouncement_Crud' );

    // dann das passende entitiy objekt für den datensatz
    $entityWebfrapAnnouncement = $model->getEntityWebfrapAnnouncement( $objid );

    // wenn null zurückgegeben wurde existiert der datensatz nicht
    // daher muss das System eine 404 Meldung zurückgeben
    if( !$entityWebfrapAnnouncement )
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
    $params->contextKey = 'wbfsys_announcement-delete-'.$objid;

    $access = new WebfrapAnnouncement_Crud_Access_Edit( null, null, $this );
    $access->load( $user->getProfileName(), $params, $entityWebfrapAnnouncement );

    // ok wenn er nichtmal lesen darf, dann ist hier direkt schluss
    if( !$access->update )
    {
      // ausgabe einer fehlerseite und adieu
      throw new InvalidRequest_Exception
      (
        $response->i18n->l
        (
          'You have no permission to access {@resource@}:{@id@}',
          'wbf.message',
          array
          (
            'resource'  => $response->i18n->l( 'Announcement', 'wbfsys.announcement.label' ),
            'id'        => $objid
          )
        ),
        Response::FORBIDDEN
      );
    }


    // der Access Container des Users für die Resource wird als flag übergeben
    $params->access = $access;

    if( !$params->ltype )
      $params->ltype = 'table';

    if( !$params->mask )
      $params->mask = 'WebfrapAnnouncement';

    $listType = ucfirst( $params->ltype );

    $error = $model->archive( $entityWebfrapAnnouncement, $params );

    // try to delete the dataset
    if( $error )
    {
      // hm ok irgendwas ist gerade ziemlich schief gelaufen
      return $error;
    }

    // laden der angeforderten view
    if( !$view = $response->loadView
    (
      'listing_webfrap_announcement',
      $params->mask.'_'.$listType,
      'displayArchive'
    ))
    {
      // ok scheins wurde ein view type angefragt der nicht für dieses
      // action methode implementiert ist
      throw new InvalidRequest_Exception
      (
        $response->i18n->l
        (
          'The requested Outputformat is not implemented for {@service@}.',
          'wbf.message',
          array( 'service' => 'delete' )
        ),
        Response::NOT_IMPLEMENTED
      );
    }

    // model wird benötigt
    $view->setModel( $this->loadModel( $params->mask.'_'.$listType ) );


    $error = $view->displayArchive( $entityWebfrapAnnouncement, $params );

    // Die Views geben eine Fehlerobjekt zurück, wenn ein Fehler aufgetreten
    // ist der so schwer war, dass die View den Job abbrechen musste
    // alle nötigen Informationen für den Enduser befinden sich in dem
    // Objekt
    // Standardmäßig entscheiden wir uns mal dafür diese dem User auch Zugänglich
    // zu machen und übergeben den Fehler der ErrorPage welche sich um die
    // korrekte Ausgabe kümmert
    if( $error )
    {

      return $error;
    }

    // wunderbar, kein fehler also melden wir einen Erfolg zurück
    return null;


  }//end public function service_delete */
  
}// end class MyMessage_Crud_Controller

