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
class WebfrapAnnouncement_Controller
  extends ControllerCrud
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////
    
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
    'create' => array
    (
      'method'    => array( 'GET', 'POST' ),
      'views'      => array( 'area' )
    ),
    'edit' => array
    (
      'method'    => array( 'GET', 'PUT' ),
      'views'      => array( 'area' )
    ),
    'data' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'ajax' )
    ),
    'append' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'ajax' )
    ),
    'listing' => array
    (
      'method'    => array( 'GET', 'POST' ),
      'views'      => array( 'maintab' )
    ),
    'search' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'ajax' )
    ),
    'selection' => array
    (
      'method'    => array( 'GET', 'POST' ),
      'views'      => array( 'maintab' )
    ),
    'filter' => array
    (
      'method'    => array( 'GET', 'POST' ),
      'views'      => array( 'ajax' )
    ),
    'autocomplete' => array
    (
      'method'    => array( 'GET', 'POST' ),
      'views'      => array( 'ajax' )
    ),
    'textbykey' => array
    (
      'method'    => array( 'GET', 'POST' ),
      'views'      => array( 'ajax' )
    ),
    'delete' => array
    (
      'method'    => array( 'DELETE' ),
      'views'      => array( 'ajax' )
    ),
    'insert' => array
    (
      'method'    => array( 'POST' ),
      'views'      => array( 'ajax' )
    ),
    'update' => array
    (
      'method'    => array( 'POST', 'PUT' ),
      'views'      => array( 'ajax' )
    ),
  );


////////////////////////////////////////////////////////////////////////////////
// Form Methodes
////////////////////////////////////////////////////////////////////////////////
    
 /**
  *
  * de:
  * {
  *   Diese Methode erstellt das Markup für ein Formular zum erstellen eines
  *   Datensatzes des types: wbfsys_announcement
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
  *   @url maintab.php?c=Wbfsys.Announcement.create
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
    $params->contextKey = 'webfrap_announcement-create';

    $access = new WebfrapAnnouncement_Crud_Access_Create( null, null, $this );
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
              'Announcement',
              'wbfsys.announcement.label'
            )
          )
        ),
        Response::FORBIDDEN
      );
    }

    $view = $response->loadView
    (
      'form-webfrap_announcement-create',
      'WebfrapAnnouncement_Crud_Create',
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
    $model = $this->loadModel( 'WebfrapAnnouncement_Crud' );
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

 /**
  *
  * de:
  * {
  *   Diese Methode erstellt das Markup für ein Formular zum edititieren eines
  *   Datensatzes des types: wbfsys_announcement
  *
  *   Neben den reinem formularelementen werden referenzen in form von tabs
  *   abgebildet.
  *
  *   Diese Methode kann im gegensatz zu create nicht mit POST sondern nur
  *   per GET Request angesprochen werden.
  *   Das ist wichtig, da sonst für den Benutzer intransparent Datensätze
  *   verändert werden könnten, wenn man mit den Daten aus POST die Input felder
  *   überschreibt
  *
  *   Unterstüzte Views:
  *   <ul>
  *     <li>Maintab (standard)</li>
  *     <li>Mainwindow</li>
  *     <li>Subwindow</li>
  *   </ul>
  *   @tutorial <a href="http://webfrap.net/doc/{{version}}/index.php?page=architecture.views.overview" >Tutorial Viewtypes</a>
  *
  *   @access maintab.php?c=Wbfsys.Announcement.edit&amp;objid=123
  *
  *   @type UI Service
  *   @param LibRequestHttp $request
  *   @param LibResponseHttp $response
  *   @throws InvalidRequest_Exception
  *   @return boolean
  * }
  */
  public function service_edit( $request, $response )
  {

    // resource laden
    $user      = $this->getUser();

    // Die ID ist Plicht.
    // Ohne diese können wir keinen Datensatz identifizieren und somit auch
    // auf Anfage logischerweise nicht bearbeiten
    if( !$objid = $this->getOID() )
    {
      // Ok wir haben keine id bekommen, also ist hier schluss
      throw new InvalidRequest_Exception
      (
        $response->i18n->l
        (
          'The Request for {@service@} was invalid. ID was missing!',
          'wbf.message',
          array
          (
            'service' => 'edit'
          )
        ),
        Response::BAD_REQUEST
      );
    }


    // erst mal brauchen wir das passende model
    $model = $this->loadModel( 'WebfrapAnnouncement_Crud' );

    // dann das passende entitiy objekt für den datensatz
    $entityWbfsysAnnouncement = $model->getEntityWebfrapAnnouncement( $objid );

    // wenn null zurückgegeben wurde existiert der datensatz nicht
    // daher muss das System eine 404 Meldung zurückgeben
    if( !$entityWbfsysAnnouncement )
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

    // prüfen ob irgendwelche steuerflags übergeben wurde
    $params  = $this->getFormFlags( $request );
    
    // entity mit übergeben
    $params->entity = $entityWbfsysAnnouncement;

    // der contextKey wird benötigt um potentielle Konflikte in der UI
    // bei der Anzeige von mehreren Windows oder Tabs zu vermeiden
    $params->contextKey = 'webfrap_announcement-edit-'.$objid;

    $access = new WebfrapAnnouncement_Crud_Access_Edit( null, null, $this );
    $access->load( $user->getProfileName(), $params, $entityWbfsysAnnouncement );

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

    // laden der passenden subview
    $view = $response->loadView
    (
      'form-webfrap_announcement-edit-'.$objid,
      'WebfrapAnnouncement_Crud_Edit',
      'displayForm',
      null,
      true
    );


    // model und request werden zwecks inversion of control an die view
    // übergeben
    $view->setModel( $model );
    $view->displayForm( $objid, $params );

  }//end public function service_edit */



////////////////////////////////////////////////////////////////////////////////
// Crud Persistence Methodes
////////////////////////////////////////////////////////////////////////////////
    
 /**
  * de:
  * Service zum Erstellen neuer Datensätze des types: wbfsys_announcement
  *
  * Diese Methode kann nur mit POST angesprochen werden, da nur vorgesehen
  * is neue datensätze anzuhängen, jedoch keine mit einer vorgegebenen ID
  * zu erstellen.
  *
  * @call POST ajax.php?c=Wbfsys.Announcement.insert
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
  public function service_insert( $request, $response )
  {

    // resource laden
    $user      = $this->getUser();

    // create named params object
    $params = $this->getCrudFlags( $request );

    // der contextKey wird benötigt um potentielle Konflikte in der UI
    // bei der Anzeige von mehreren Windows oder Tabs zu vermeiden
    $params->contextKey = 'webfrap_announcement-insert';

    $access = new WebfrapAnnouncement_Crud_Access_Insert( null, null, $this );
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
              'Announcement',
              'wbfsys.announcement.label'
            )
          )
        ),
        Response::FORBIDDEN
      );
    }


    // der Access Container des Users für die Resource wird als flag übergeben
    $params->access = $access;

    // if there is no given window id we close the expected default window
    if( !$params->windowId )
      $params->windowId = 'form_create_webfrap_announcement';

    // das crud model wird zum validieren des requests und zum erstellen
    // des neuen datensatzes benötigt
    $model = $this->loadModel( 'WebfrapAnnouncement_Crud' );

    // die genauen fehlermeldungen werden direkt vom validator in die
    // message queue gepackt
    if( !$model->fetchInsertData( $params ) )
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
            'resource' => $response->i18n->l( 'Announcement', 'wbfsys.announcement.label' )
          )
        ),
        Response::BAD_REQUEST
      );
    }



    // die daten in die datenbank persistieren
    // das modell hat die entity bereits in sich, daher müssen wir hier
    // nur noch die anweisung zum speichern geben
    if( $error = $model->insert( $params ) )
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

      if( !$params->ltype )
        $params->ltype = 'table';

      if( !$params->viewType )
        $params->viewType = 'maintab';

      $listType = ucfirst( $params->ltype );

      // die Maske über welche der neue Liste Eintrag gerendert werden soll
      if( !$params->mask )
        $params->mask = 'WebfrapAnnouncement';

      // laden der angeforderten view
      $view = $response->loadView
      (
        'listing_webfrap_announcement',
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

    }

    // wenn wir hier ankommen, dann hat alles geklappt
    return true;

  }//end public function service_insert */

 /**
  * de:
  * Service zum updaten eines Datensazes
  *
  * @call POST ajax.php?c=Wbfsys.Announcement.update
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
  * @return boolean im fehler false
  */
  public function service_update( $request, $response )
  {

    // resource laden
    $user      = $this->getUser( );


    // prüfen ob die verwendete HTTP Methode für diesen service
    // überhaupt erlaub ist
    if( !( $request->method( Request::PUT ) || $request->method(Request::POST ) ) )
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
            'use'    => 'PUT or POST'
          )
        ),
        Error::METHOD_NOT_ALLOWED
      );

    }



    // Die ID ist Plicht.
    // Ohne diese können wir keinen Datensatz identifizieren und somit auch
    // auf Anfage logischerweise nicht bearbeiten
    if( !$objid = $this->getOID('webfrap_announcement') )
    {
      // Ok wir haben keine id bekommen, also ist hier schluss
      throw new InvalidRequest_Exception
      (
        $response->i18n->l
        (
          'The Request for {@service@} was invalid. ID was missing!',
          'wbf.message',
          array
          (
            'service' => 'update'
          )
        ),
        Response::BAD_REQUEST
      );
    }


    // erst mal brauchen wir das passende model
    $model = $this->loadModel( 'WebfrapAnnouncement_Crud' );

    // dann das passende entitiy objekt für den datensatz
    $entityWbfsysAnnouncement = $model->getEntityWebfrapAnnouncement( $objid );

    // wenn null zurückgegeben wurde existiert der datensatz nicht
    // daher muss das System eine 404 Meldung zurückgeben
    if( !$entityWbfsysAnnouncement )
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


    // interpret the parameters from the request
    $params = $this->getCrudFlags( $request );

    // der contextKey wird benötigt um potentielle Konflikte in der UI
    // bei der Anzeige von mehreren Windows oder Tabs zu vermeiden
    $params->contextKey = 'webfrap_announcement-update-'.$objid;

    $access = new WebfrapAnnouncement_Crud_Access_Update( null, null, $this );
    $access->load( $user->getProfileName(),  $params, $entityWbfsysAnnouncement );

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


    // if there is no given window id we close the expected default window
    if( !$params->windowId )
      $params->windowId = 'form_edit_webfrap_announcement_'.$entityWbfsysAnnouncement;


    // fetch the data from the http request and load it in the model registry
    // if fails stop here
    if( !$model->fetchUpdateData( $entityWbfsysAnnouncement, $params ) )
    {
      // wenn die daten nicht valide sind, dann war es eine ungültige anfrage
      throw new InvalidRequest_Exception
      (
        $response->i18n->l
        (
          'The Update Request for {@resource@} was invalid.',
          'wbf.message',
          array
          (
            'resource' => $response->i18n->l( 'Announcement', 'wbfsys.announcement.label' )
          )
        ),
        Response::BAD_REQUEST
      );
    }



    // when we are here the data must be valid ( if not your meta model is broken! )
    // try to update
    if( $error = $model->update( $params ) )
    {

      // hm ok irgendwas ist gerade ziemlich schief gelaufen
      return $error;
    }


    if( !$params->ltype )
      $params->ltype = 'table';

    $listType = ucfirst( $params->ltype );
    
    // die Maske über welche der neue Liste Eintrag gerendert werden soll
    if( !$params->mask )
      $params->mask = 'WebfrapAnnouncement';

    // laden der angeforderten view
    $view = $response->loadView
    (
      'listing_webfrap_announcement',
      $params->mask.'_'.$listType,
      'displayUpdate'
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

    $error = $view->displayUpdate( $params );

    // im Fehlerfall jedoch bekommen wir eine Error Objekt das wird noch kurz
    // behandeln sollten
    if( $error )
    {
      return $error;
    }

    // ok angekommen? dann ist ja alles klar
    return true;

  }//end public function service_update */

 /**
  *
  * @param int $objid container für benamte parameter
  * @param WebfrapAnnouncement_Crud_Model $model the model
  * @param TFlag $params container für benamte parameter
  *
  * @return boolean
  *
  */
  protected function editForm( $objid, $model, $params )
  {

    // resource laden
    $request   = $this->getRequest();
    $response  = $this->getResponse();
    $user      = $this->getUser();

    // laden der passenden subview
    $view = $response->loadView
    (
      'form-wbfsys_announcement-edit-'.$objid,
      'WebfrapAnnouncement_Crud_Edit',
      'displayForm',
      View::MAINTAB
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


    // model und request werden zwecks inversion of control an die view
    // übergeben
    $view->setModel( $model );

    // wenn alles glatt geht gibt die view null zurück und der keks ist gegessen
    $error = $view->displayForm( $objid, $params );

    // im Fehlerfall jedoch bekommen wir eine Error Objekt das wird noch kurz
    // behandeln sollten
    if( $error )
    {
      return $error;
    }
    
    return true;

  }//end protected function editForm */


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
    $entityWbfsysAnnouncement = $model->getEntityWebfrapAnnouncement( $objid );

    // wenn null zurückgegeben wurde existiert der datensatz nicht
    // daher muss das System eine 404 Meldung zurückgeben
    if( !$entityWbfsysAnnouncement )
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

    $access = new WebfrapAnnouncement_Crud_Access_Delete( null, null, $this );
    $access->load( $user->getProfileName(), $params, $entityWbfsysAnnouncement );

    // ok wenn er nichtmal lesen darf, dann ist hier direkt schluss
    if( !$access->delete )
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
      $params->mask = 'WbfsysAnnouncement';

    $listType = ucfirst( $params->ltype );




    $error = $model->delete( $entityWbfsysAnnouncement, $params );

    // try to delete the dataset
    if( $error )
    {




      // hm ok irgendwas ist gerade ziemlich schief gelaufen
      return $error;
    }




    // laden der angeforderten view
    if( !$view = $response->loadView
    (
      'listing_wbfsys_announcement',
      $params->mask.'_'.$listType,
      'displayDelete'
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




    $error = $view->displayDelete( $entityWbfsysAnnouncement, $params );

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

////////////////////////////////////////////////////////////////////////////////
// Table & List methodes Methodes
////////////////////////////////////////////////////////////////////////////////
    
  /**
  * de:
  *
  * Die listing methode erstellt eine UI mit einer einem listenlement
  * das standardelement ist ein grid
  *
  * Diese Methode akzeptiert nur GET Requests
  *
  * Unterstüzte Views:
  * <ul>
  *   <li>Maintab (standard)</li>
  *   <li>Mainwindow</li>
  *   <li>Subwindow</li>
  * </ul>
  * @tutorial <a href="http://webfrap.net/doc/{{version}}/index.php?page=architecture.views.overview" >Tutorial Viewtypes</a>
  *
  * @url maintab.php?c=Wbfsys.Announcement.listing
  *
  * @param LibRequestHttp $request
  * @param LibResponseHttp $response
  * @return boolean
  */
  public function service_listing( $request, $response )
  {

    // resource laden
    $user      = $this->getUser();

    // load request parameters an interpret as flags
    $params  = $this->getListingFlags( $request );

    // der contextKey wird benötigt um potentielle Konflikte in der UI
    // bei der Anzeige von mehreren Windows oder Tabs zu vermeiden
    $params->contextKey = 'webfrap_announcement-listing';


    // wenn kein listentype definiert wurde, wird table als standard type
    // verwendet. Über den ltype kann der user über den parameter bestimmen
    // welches listingelement er gerne hätte
    if( !$params->ltype )
      $params->ltype = 'table';

    $listType = ucfirst( $params->ltype );
    
    // ok nun kommen wir zu der zugriffskontrolle
    $acl = $this->getAcl();

    // laden des containers zum prüfen der zugriffsrechte
    $access = new WebfrapAnnouncement_Table_Access( null, null, $this );
    $access->load( $user->getProfileName(), $params );

     // access direkt übergeben
    $params->access = $access;

    // ok wenn er nichtmal lesen darf, dann ist hier direkt schluss
    if( !$access->listing  )
    {
      // ausgabe einer fehlerseite und adieu
      throw new InvalidRequest_Exception
      (
        $response->i18n->l
        (
          'You have no permission to access this mask!',
          'wbf.message'
        ),
        Response::FORBIDDEN
      );
    }

    
    $view = $response->loadView
    (
      'listing_webfrap_announcement',
      'WebfrapAnnouncement_Table',
      'displayListing',
      null,
      true
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

    ///TODO prüfen warum hier insert war und ob das wirklich gebraucht wird
    $params->insert = false;

    // da wir ein paging implementieren wollen muss die query prüfen
    // wieviele datensätze sie ohne das limit hätte laden können
    // loadFullSize setzt das flag diese information zu laden
    $params->loadFullSize = true;

    // da wir das model hier nicht brauchen packen wir es direkt in die view
    $view->setModel( $this->loadModel( 'WebfrapAnnouncement_Table' ) );

    // ok zusammenbauen der ausgabe
    $error = $view->displayListing( $params );

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


  }//end public function service_listing */

 /**
  * en:
  * the search method for the main table
  * this method is called for paging and search requests
  * it's not recommended to use another method than this for paging, cause
  * this method makes shure that you can page between the search results
  * and do not loose your filters in paging
  *
  * de:
  * Die Suchefunktion, liefert Daten im Format passend zu Listmethode
  *
  * Diese Methode wird sowohl für die Suche, als auch für einfach Paging oder Append
  * Operationen auf dem Hauplistenelement verwendet
  *
  * @call GET/POST: maintab.php?c=Enterprise.Company.search
  * {
  *   @get_param: cname ltype, der Type der des Listenelements. Sollte sinnigerweise
  *     der gleich type wie das Listenelement sein, für das die Suche angestoßen wurde
  *
  *   @get_param: int start, Offset für die Listenelemente. Wird absolut übergeben und nicht
  *     mit multiplikator ( 50 anstelle von <strike>5 mal listengröße</strike> )
  *
  *   @get_param: int qsize, Die Anzahl der zu Ladenten Einträge. Momentan wird alles > 500 auf 500 gekappt
  *     alles kleiner 0 wird auf den standardwert von aktuell 25 gesetzt
  *
  *   @get_param: array(string fieldname => string [asc|desc] ) order, Die Daten für die Sortierung
  *
  *   @get_param: char begin, Mit Begin wird ein Buchstabe übergeben, der verwendet wird die Listeelemente
  *     nach dem Anfangsbuchstaben zu filtern. Kann im Prinzip jedes beliebige Zeichen, also auch eine Zahl sein
  *
  *   @get_param: ckey target_id, Die HTML Id, des Zielelements. Diese ID is wichtig, wenn das HTML Element
  *     in dem das Suchergebniss platziert werden soll, eine andere ID als die in der Methode hinterlegt
  *     Standard HTML ID hat
  *
  *
  *   @post_param: Die POST-Üparameter sind im Gegensaz zu den GET-Parametern dynamisch.
  *   Es werden lediglich suchfelder ausgewertet
  * }
  *
  * @param LibRequestHttp $request
  * @param LibResponseHttp $response
  * @return boolean
  */
  public function service_search( $request, $response )
  {

    // resource laden
    $user      = $this->getUser();


    // laden der steuerungs parameter
    $params  = $this->getListingFlags( $request );

    // der contextKey wird benötigt um potentielle Konflikte in der UI
    // bei der Anzeige von mehreren Windows oder Tabs zu vermeiden
    $params->contextKey = 'webfrap_announcement-listing';

    // wenn kein listentype definiert wurde, wird table als standard type
    // verwendet. Über den ltype kann der user über den parameter bestimmen
    // welches listingelement er gerne hätte
    if( !$params->ltype )
      $params->ltype = 'table';

    $listType = ucfirst( $params->ltype );
    
    // ok nun kommen wir zu der zugriffskontrolle
    $acl = $this->getAcl();

    
    //wgt_table-webfrap_announcement
    
    //wgt_table-wbfsys_announcement-table
    
    $access = new WebfrapAnnouncement_Table_Access( null, null, $this );
    $access->load( $user->getProfileName(), $params );

    // ok wenn er nichtmal lesen darf, dann ist hier direkt schluss
    if( !$access->listing )
    {
      // ausgabe einer fehlerseite und adieu
      throw new InvalidRequest_Exception
      (
        $response->i18n->l
        (
          'You have no permission to access this mask!',
          'wbf.message'
        ),
        Response::FORBIDDEN
      );
    }

    // access direkt übergeben
    $params->access = $access;

    // definiere, dass dies ein ajax request ist
    // diese information ist später wichtig um entscheiden zu können in welcher
    // form das listenelement in den element index übergeben werden soll
    $params->ajax = true;

    // when we not append, then we need to load the full size for paging
    $params->loadFullSize = true;


    $view = $response->loadView
    (
      'listing_webfrap_announcement',
      'WebfrapAnnouncement_Table',
      'displaySearch',
      null,
      true
    );


    // da wir das model hier nicht brauchen packen wir es direkt in die view
    $view->setModel( $this->loadModel( 'WebfrapAnnouncement_Table' ) );
    
    $error =  $view->displaySearch( $params );

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
    return State::OK;


  }//end public function service_search */

} // end class WbfsysAnnouncement_Controller */

