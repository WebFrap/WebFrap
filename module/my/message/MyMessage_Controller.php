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
 * @subpackage ModMessage
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright webfrap.net <contact@webfrap.net>
 */
class MyMessage_Controller
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
      'views'      => array( 'window', 'maintab' )
    ),
    'respond' => array
    (
      'method'    => array( 'GET', 'POST' ),
      'views'      => array( 'window', 'maintab' )
    ),
    'forward' => array
    (
      'method'    => array( 'GET', 'POST' ),
      'views'      => array( 'window', 'maintab' )
    ),
    'edit' => array
    (
      'method'    => array( 'GET', 'PUT' ),
      'views'      => array( 'window', 'maintab' )
    ),
    'show' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'window', 'maintab' )
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
      'views'      => array( 'window', 'maintab' )
    ),
    'search' => array
    (
      'method'    => array( 'GET', 'POST' ),
      'views'      => array( 'ajax' )
    ),
    'selection' => array
    (
      'method'    => array( 'GET', 'POST' ),
      'views'      => array( 'window', 'maintab' )
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
    $params->contextKey = 'wbfsys_message-create';

    $access = new WbfsysMessage_Crud_Access_Create( null, null, $this );
    $access->load( $user->getProfileName(), $params );

    // der Access Container des Users für die Resource wird als flag übergeben
    $params->access = $access;

    // wirft eine exeption wenn die view nicht existiert
    $view = $response->loadView
    (
      'form-wbfsys_message-create',
      'WbfsysMessage_Crud_Create',
      'displayForm',
      null,
      true
    );

    // laden des models und direkt übergabe in die view
    $model = $this->loadModel( 'WbfsysMessage_Crud' );
    $view->setModel( $model );

    // die view zum baue des formulars veranlassen
    $view->displayForm( $params );


  }//end public function service_create */
  
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
  public function service_respond( $request, $response )
  {

    // resource laden
    $user      = $this->getUser();
    
    // prüfen ob irgendwelche steuerflags übergeben wurde
    $params  = $this->getFormFlags( $request );

    // der contextKey wird benötigt um potentielle Konflikte in der UI
    // bei der Anzeige von mehreren Windows oder Tabs zu vermeiden
    $params->contextKey = 'wbfsys_message-create';

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
      'form-wbfsys_message-create',
      'WbfsysMessage_Crud_Create',
      'displayForm',
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


    // laden des models und direkt übergabe in die view
    $model = $this->loadModel( 'WbfsysMessage_Crud' );
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


  }//end public function service_respond */

 /**
  *
  * de:
  * {
  *   Diese Methode erstellt das Markup für ein Formular zum edititieren eines
  *   Datensatzes des types: wbfsys_message
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
  *   @access maintab.php?c=Wbfsys.Message.edit&amp;objid=123
  *
  *   @type UI Service
  *   @param LibRequestHttp $request
  *   @param LibResponseHttp $response
  *   @return boolean
  * }
  */
  public function service_edit( $request, $response )
  {

    // resource laden
    $user      = $this->getUser();

    // prüfen ob die verwendete HTTP Methode für diesen service
    // überhaupt erlaub ist
    if( !( $request->method( Request::GET ) || $request->method(Request::PUT ) ) )
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
            'use'    => 'GET or PUT'
          )
        ),
        Error::METHOD_NOT_ALLOWED
      );

    }



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
    $model = $this->loadModel( 'WbfsysMessage_Crud' );

    // dann das passende entitiy objekt für den datensatz
    $entityMyMessage = $model->getEntityWbfsysMessage( $objid );

    // wenn null zurückgegeben wurde existiert der datensatz nicht
    // daher muss das System eine 404 Meldung zurückgeben
    if( !$entityMyMessage )
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
            'resource'  => $response->i18n->l( 'Message', 'wbfsys.message.label' ),
            'id'        => $objid
          )
        ),
        Response::NOT_FOUND
      );
    }

    // prüfen ob irgendwelche steuerflags übergeben wurde
    $params  = $this->getFormFlags( $request );
    
    // entity mit übergeben
    $params->entity = $entityMyMessage;

    // der contextKey wird benötigt um potentielle Konflikte in der UI
    // bei der Anzeige von mehreren Windows oder Tabs zu vermeiden
    $params->contextKey = 'wbfsys_message-edit-'.$objid;

    $access = new WbfsysMessage_Crud_Access_Edit( null, null, $this );
    $access->load( $user->getProfileName(), $params, $entityMyMessage );

    // ok wenn er nichtmal lesen darf, dann ist hier direkt schluss
    if( !$access->access )
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
            'resource'  => $response->i18n->l( 'Message', 'wbfsys.message.label' ),
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
      'form-wbfsys_message-edit-'.$objid,
      'WbfsysMessage_Crud_Edit',
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

  }//end public function service_edit */

 /**
  *
  * de:
  * {
  *   Diese Methode erstellt das Markup für ein Formular zum edititieren eines
  *   Datensatzes des types: wbfsys_message
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
  *   @access maintab.php?c=Wbfsys.Message.edit&amp;objid=123
  *
  *   @type UI Service
  *   @param LibRequestHttp $request
  *   @param LibResponseHttp $response
  *   @return boolean
  * }
  */
  public function service_show( $request, $response )
  {

    // resource laden
    $user      = $this->getUser();

    // prüfen ob die verwendete HTTP Methode für diesen service
    // überhaupt erlaub ist
    if( !( $request->method( Request::GET ) ) )
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
            'use'    => 'GET'
          )
        ),
        Error::METHOD_NOT_ALLOWED
      );

    }



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
            'service' => 'show'
          )
        ),
        Response::BAD_REQUEST
      );
    }


    // erst mal brauchen wir das passende model
    $model = $this->loadModel( 'WbfsysMessage_Crud' );

    // dann das passende entitiy objekt für den datensatz
    $entityMyMessage = $model->getEntityWbfsysMessage( $objid );

    // wenn null zurückgegeben wurde existiert der datensatz nicht
    // daher muss das System eine 404 Meldung zurückgeben
    if( !$entityMyMessage )
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
            'resource'  => $response->i18n->l( 'Message', 'wbfsys.message.label' ),
            'id'        => $objid
          )
        ),
        Response::NOT_FOUND
      );
    }

    // prüfen ob irgendwelche steuerflags übergeben wurde
    $params  = $this->getFormFlags( $request );

    // der contextKey wird benötigt um potentielle Konflikte in der UI
    // bei der Anzeige von mehreren Windows oder Tabs zu vermeiden
    $params->contextKey = 'wbfsys_message-show-'.$objid;

    // wenn keine root übergeben wird oder wir in level 1 sind
    // dann befinden wir uns im root und brauchen keine pfadafrage
    // um potentielle fehler abzufangen wird auch direkt der richtige Root gesetzt
    // nicht das hier einer einen falschen pfad injected
    if( is_null($params->aclRoot) || 1 == $params->aclLevel  )
    {
      $params->isAclRoot     = true;
      $params->aclRoot       = 'mgmt-wbfsys_message';
      $params->aclRootId     = $objid;
      $params->aclKey        = 'mgmt-wbfsys_message';
      $params->aclNode       = 'mgmt-wbfsys_message';
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
      $access = $acl->getFormPermission
      (
        'mod-wbfsys>mgmt-wbfsys_message',
        $entityMyMessage
      );
    }
    else
    {
      // da wir die zugriffsrechte mehr als nur einmal brauchen holen wir uns
      // direkt das zugriffslevel
      $access = $acl->getPathPermission
      (
        $params->aclRoot,
        $params->aclRootId,
        $params->aclLevel,
        $params->aclKey,
        $params->refId,
        $params->aclNode,
        $entityMyMessage
      );
    }


    // der Access Container des Users für die Resource wird als flag übergeben
    $params->access = $access;


    // show ist per definition immer readonly
    $params->readOnly = true;

    // laden der passenden subview
    $view = $response->loadView
    (
      'form-wbfsys_message-edit-'.$objid,
      'WbfsysMessage_Crud_Edit',
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

  }//end public function service_show */


////////////////////////////////////////////////////////////////////////////////
// Crud Persistence Methodes
////////////////////////////////////////////////////////////////////////////////
    
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
  public function service_insert( $request, $response )
  {

    // resource laden
    $user      = $this->getUser();

    // create named params object
    $params = $this->getCrudFlags( $request );

    // der contextKey wird benötigt um potentielle Konflikte in der UI
    // bei der Anzeige von mehreren Windows oder Tabs zu vermeiden
    $params->contextKey = 'wbfsys_message-insert';

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

    // if there is no given window id we close the expected default window
    if( !$params->windowId )
      $params->windowId = 'form_create_wbfsys_message';

    // das crud model wird zum validieren des requests und zum erstellen
    // des neuen datensatzes benötigt
    $model = $this->loadModel( 'WbfsysMessage_Crud' );

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
            'resource' => $response->i18n->l( 'Message', 'wbfsys.message.label' )
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
        $params->mask = 'WbfsysMessage';

      // laden der angeforderten view
      $view = $response->loadView
      (
        'listing_wbfsys_message',
        $params->mask.'_'.$listType,
        'displayInsert',
        null,
        true
      );

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


    // wenn die reopen flag mitgeschickt wurde
    // soll der Datensatz direkt im Edit Window geöffnet werden
    if( $request->param( 'reopen', Validator::BOOLEAN ) )
    {
      $this->editForm( $model->getEntityWbfsysMessage(), $model, $params );
    }

    // wenn wir hier ankommen, dann hat alles geklappt
    return true;

  }//end public function service_insert */

 /**
  * de:
  * Service zum updaten eines Datensazes
  *
  * @call POST ajax.php?c=Wbfsys.Message.update
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
            'service' => 'update'
          )
        ),
        Response::BAD_REQUEST
      );
    }


    // erst mal brauchen wir das passende model
    $model = $this->loadModel( 'WbfsysMessage_Crud' );

    // dann das passende entitiy objekt für den datensatz
    $entityMyMessage = $model->getEntityWbfsysMessage( $objid );

    // wenn null zurückgegeben wurde existiert der datensatz nicht
    // daher muss das System eine 404 Meldung zurückgeben
    if( !$entityMyMessage )
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
            'resource'  => $response->i18n->l( 'Message', 'wbfsys.message.label' ),
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
    $params->contextKey = 'wbfsys_message-update-'.$objid;

    $access = new WbfsysMessage_Crud_Access_Update( null, null, $this );
    $access->load( $user->getProfileName(),  $params, $entityMyMessage );

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
            'resource'  => $response->i18n->l( 'Message', 'wbfsys.message.label' ),
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
      $params->windowId = 'form_edit_wbfsys_message_'.$entityMyMessage;


    // fetch the data from the http request and load it in the model registry
    // if fails stop here
    if( !$model->fetchUpdateData( $entityMyMessage, $params ) )
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
            'resource' => $response->i18n->l( 'Message', 'wbfsys.message.label' )
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
      $params->mask = 'WbfsysMessage';

    // laden der angeforderten view
    $view = $response->loadView
    (
      'listing_wbfsys_message',
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

    if( $params->closeMask )
    {
      ///@todo der teil sollte langsam mal in den client ausgelagert werden
      switch( $params->viewType )
      {
        case 'window':
        {
          // close the window
          $this->tpl->closeWindow( $params->windowId );
          break;
        }
        case 'subwindow':
        {
          // close the window
          $this->tpl->closeWindow( $params->windowId );
          break;
        }
        case 'maintab':
        {
          // close the window
          $this->tpl->closeTab( $params->viewId );
          break;
        }
      }
    }


    if( $params->reload )
    {
      $params->targetMask = $params->mask;
      $this->editForm( $objid, $model, $params );
    }

    // ok angekommen? dann ist ja alles klar
    return true;

  }//end public function service_update */

 /**
  *
  * @param int $objid container für benamte parameter
  * @param WbfsysMessage_Crud_Model $model the model
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
      'form-wbfsys_message-edit-'.$objid,
      'WbfsysMessage_Crud_Edit',
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
  * @access DELETE ajax.php?c=Wbfsys.Message.delete&amp;objid=123
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
            'resource' => $response->i18n->l( 'Message', 'wbfsys.message.label' )
          )
        ),
        Response::BAD_REQUEST
      );
    }

    // erst mal brauchen wir das passende model
    $model = $this->loadModel( 'WbfsysMessage_Crud' );

    // dann das passende entitiy objekt für den datensatz
    $entityMyMessage = $model->getEntityWbfsysMessage( $objid );

    // wenn null zurückgegeben wurde existiert der datensatz nicht
    // daher muss das System eine 404 Meldung zurückgeben
    if( !$entityMyMessage )
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
            'resource'  => $response->i18n->l( 'Message', 'wbfsys.message.label' ),
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
    $params->contextKey = 'wbfsys_message-delete-'.$objid;

    $access = new WbfsysMessage_Crud_Access_Delete( null, null, $this );
    $access->load( $user->getProfileName(), $params, $entityMyMessage );

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
            'resource'  => $response->i18n->l( 'Message', 'wbfsys.message.label' ),
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
      $params->mask = 'WbfsysMessage';

    $listType = ucfirst( $params->ltype );




    $error = $model->delete( $entityMyMessage, $params );

    // try to delete the dataset
    if( $error )
    {




      // hm ok irgendwas ist gerade ziemlich schief gelaufen
      return $error;
    }




    // laden der angeforderten view
    if( !$view = $response->loadView
    (
      'listing_wbfsys_message',
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




    $error = $view->displayDelete( $entityMyMessage, $params );

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
  * @url maintab.php?c=Wbfsys.Message.listing
  *
  * @param LibRequestHttp $request
  * @param LibResponseHttp $response
  * @return boolean
  */
  public function service_listing( $request, $response )
  {

    // resource laden
    $user      = $this->getUser();


    // prüfen ob die verwendete HTTP Methode für diesen service
    // überhaupt erlaub ist
    if( !( $request->method( Request::GET ) ) )
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
            'use'    => 'GET'
          )
        ),
        Error::METHOD_NOT_ALLOWED
      );

    }



    // load request parameters an interpret as flags
    $params  = $this->getListingFlags( $request );

    // der contextKey wird benötigt um potentielle Konflikte in der UI
    // bei der Anzeige von mehreren Windows oder Tabs zu vermeiden
    $params->contextKey = 'wbfsys_message-listing';


    // wenn kein listentype definiert wurde, wird table als standard type
    // verwendet. Über den ltype kann der user über den parameter bestimmen
    // welches listingelement er gerne hätte
    if( !$params->ltype )
      $params->ltype = 'table';

    $listType = ucfirst( $params->ltype );
    
    // ok nun kommen wir zu der zugriffskontrolle
    $acl = $this->getAcl();

    $containerClass = 'WbfsysMessage_'.$listType.'_Access';
    
    if( !Webfrap::classLoadable( $containerClass ) )
    {
      // ausgabe einer fehlerseite und adieu
      throw new InvalidRequest_Exception
      (
        $response->i18n->l
        (
          'Invalid Access Type',
          'wbf.message'
        ),
        Response::NOT_IMPLEMENTED
      );
    }
    
    // laden des containers zum prüfen der zugriffsrechte
    $access = new $containerClass( null, null, $this );
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
      'listing_wbfsys_message',
      'WbfsysMessage_'.$listType,
      'displayListing'
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
    $view->setModel( $this->loadModel( 'WbfsysMessage_'.$listType ) );

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


    // prüfen ob die verwendete HTTP Methode für diesen service
    // überhaupt erlaub ist
    if( !( $request->method( Request::GET ) || $request->method(Request::POST ) ) )
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
            'use'    => 'GET or POST'
          )
        ),
        Error::METHOD_NOT_ALLOWED
      );

    }



    // laden der steuerungs parameter
    $params  = $this->getListingFlags( $request );

    // der contextKey wird benötigt um potentielle Konflikte in der UI
    // bei der Anzeige von mehreren Windows oder Tabs zu vermeiden
    $params->contextKey = 'wbfsys_message-listing';

    // wenn kein listentype definiert wurde, wird table als standard type
    // verwendet. Über den ltype kann der user über den parameter bestimmen
    // welches listingelement er gerne hätte
    if( !$params->ltype )
      $params->ltype = 'table';

    $listType = ucfirst( $params->ltype );
    
    // ok nun kommen wir zu der zugriffskontrolle
    $acl = $this->getAcl();

    $containerClass = 'WbfsysMessage_'.$listType.'_Access';
    
    if( !Webfrap::classLoadable( $containerClass ) )
    {
      // ausgabe einer fehlerseite und adieu
      throw new InvalidRequest_Exception
      (
        $response->i18n->l
        (
          'Invalid Access Type',
          'wbf.message'
        ),
        Response::NOT_IMPLEMENTED
      );
    }
    
    $access = new $containerClass( null, null, $this );
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

    $model   = $this->loadModel( 'WbfsysMessage_'.$listType );

    $view = $response->loadView
    (
      'listing_wbfsys_message',
      'WbfsysMessage_'.$listType,
      'displaySearch'
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



    $view->setModel( $model );
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
    return null;


  }//end public function service_search */

  /**
   * the default selection for the management  WbfsysMessage
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return boolean
   */
  public function service_selection( $request, $response )
  {

    // resource laden
    $user      = $this->getUser();
    $acl       = $this->getAcl( );


    // prüfen ob die verwendete HTTP Methode für diesen service
    // überhaupt erlaub ist
    if( !( $request->method( Request::GET ) ) )
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
            'use'    => 'GET'
          )
        ),
        Error::METHOD_NOT_ALLOWED
      );

    }



    // laden der steuerungs parameter
    $params  = $this->getListingFlags( $request );

    // der contextKey wird benötigt um potentielle Konflikte in der UI
    // bei der Anzeige von mehreren Windows oder Tabs zu vermeiden
    $params->contextKey = 'wbfsys_message-selection';

    // ok nun kommen wir zu der zugriffskontrolle
    $access = new WbfsysMessage_Selection_Access( null, null, $this );
    $access->load( $user->getProfileName(), $params );

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


    // access direkt übergeben
    $params->access = $access;

    $view = $response->loadView
    (
      'selection_wbfsys_message',
      'WbfsysMessage_Selection',
      'displaySelection'
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




    $view->setModel( $this->loadModel( 'WbfsysMessage_Selection' ) );

    // set selection mode
    $params->publish = 'selection';
    $params->insert   = true;

    // the database should load the full size of the query
    $params->loadFullSize = true;

    $error = $view->displaySelection( $params );

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


  }//end public function service_selection */

 /**
  *
  * de:
  * Die Suchefunktion, für die selection
  *
  * Diese Methode wird sowohl für die Suche, als auch für einfach Paging oder Append
  * Operationen auf dem Selection Listelement verwendet
  *
  * @call GET/POST: maintab.php?c=Wbfsys.Message.filter
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
  public function service_filter( $request, $response )
  {

    // resource laden
    $user      = $this->getUser();


    // prüfen ob die verwendete HTTP Methode für diesen service
    // überhaupt erlaub ist
    if( !( $request->method( Request::GET ) || $request->method(Request::POST ) ) )
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
            'use'    => 'GET or POST'
          )
        ),
        Error::METHOD_NOT_ALLOWED
      );

    }



    // laden der steuerungs parameter
    $params  = $this->getListingFlags( $request );

    // der contextKey wird benötigt um potentielle Konflikte in der UI
    // bei der Anzeige von mehreren Windows oder Tabs zu vermeiden
    $params->contextKey = 'wbfsys_message-selection';

    // ok nun kommen wir zu der zugriffskontrolle
    $acl = $this->getAcl( );

    $access = new WbfsysMessage_Selection_Access( null, null, $this );
    $access->load( $user->getProfileName(), $params );

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

    // access direkt übergeben
    $params->access = $access;

    // definiere, dass dies ein ajax request ist
    // diese information ist später wichtig um entscheiden zu können in welcher
    // form das listenelement in den element index übergeben werden soll
    $params->ajax = true;

    // when we not append, then we need to load the full size for paging
    $params->loadFullSize = true;

    $model   = $this->loadModel( 'WbfsysMessage_Selection' );

    $view = $response->loadView
    (
      'selection_wbfsys_message',
      'WbfsysMessage_Selection',
      'displaySearch'
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



    $view->setModel( $model );
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
    return null;


  }//end public function service_filter */

////////////////////////////////////////////////////////////////////////////////
// request methodes for data
////////////////////////////////////////////////////////////////////////////////
    
 /**
  * data is a call for request form data
  * if the param full_load is in the url data will send all entity data
  * in a form replacement ajax responce
  *
  * default is just to send the text value of the requested entity and
  * position it in a input field, normally used for window assignments
  *
  * @param LibRequestHttp $request
  * @param LibResponseHttp $response
  */
  public function service_data( $request, $response )
  {

    // resource laden
    $user      = $this->getUser();


    // prüfen ob die verwendete HTTP Methode für diesen service
    // überhaupt erlaub ist
    if( !( $request->method( Request::GET ) ) )
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
            'use'    => 'GET'
          )
        ),
        Error::METHOD_NOT_ALLOWED
      );

    }



    // prüfen ob die angeforderte rückgabe so überhaupt erlaubt ist
    if(!$this->checkAccessType( View::AJAX ) )
    {
      // ok, der angefragte type wurde von vorne herein ausgeschlossen
      // also kommunizieren wir das so auch zurück
      throw new InvalidRequest_Exception
      (
        $response->i18n->l
        (
          'The requested Access Type is not implemented for this action.',
          'wbf.message'
        ),
        Response::NOT_IMPLEMENTED
      );
    }


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
            'service' => 'data'
          )
        ),
        Response::BAD_REQUEST
      );
    }


    // erst mal brauchen wir das passende model
    $model = $this->loadModel( 'WbfsysMessage_Crud' );

    // dann das passende entitiy objekt für den datensatz
    $entityMyMessage = $model->getEntityWbfsysMessage( $objid );

    // wenn null zurückgegeben wurde existiert der datensatz nicht
    // daher muss das System eine 404 Meldung zurückgeben
    if( !$entityMyMessage )
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
            'resource'  => $response->i18n->l( 'Message', 'wbfsys.message.label' ),
            'id'        => $objid
          )
        ),
        Response::NOT_FOUND
      );
    }


    // ok nun kommen wir zu der zugriffskontrolle
    $acl = $this->getAcl();

    // da wir die zugriffsrechte mehr als nur einmal brauchen holen wir uns
    // direkt das zugriffslevel
    $access = $acl->getPermission
    (
      'mod-wbfsys>mgmt-wbfsys_message',
      $entityMyMessage
    );

    // ok wenn er nichtmal lesen darf, dann ist hier direkt schluss
    if( !$access->access )
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
            'resource' => $response->i18n->l
            (
              'Message',
              'wbfsys.message.label'
            ),
            'id' => $objid
          )
        ),
        Response::FORBIDDEN
      );
    }


    // if the params are empty create a params object
    $params = new TFlag();

    // fetch the user parameters and map them on the param object
    $params->input     = $request->param( 'input', Validator::CKEY );
    $params->fullLoad  = $request->param( 'full_load', Validator::CNAME );
    $params->keyName   = $request->param( 'key_name', Validator::CKEY );
    $params->suffix    = $request->param( 'suffix', Validator::CKEY );

    // der contextKey wird benötigt um potentielle Konflikte in der UI
    // bei der Anzeige von mehreren Windows oder Tabs zu vermeiden
    $params->contextKey = 'wbfsys_message-data-'.$objid;

    // laden der passenden subview
    $view = $response->loadView
    (
      'tmp-wbfsys_message',
      'WbfsysMessage',
      'displayData'
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
    $error = $view->displayData( $entityMyMessage, $params );


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


  }//end public function service_data */

 /**
  * data is a call for request form data
  * if the param full_load is in the url data will send all entity data
  * in a form replacement ajax responce
  *
  * default is just to send the text value of the requested entity and
  * position it in a input field, normally used for window assignments
  *
  * @param LibRequestHttp $request
  * @param LibResponseHttp $response
  */
  public function service_append( $request, $response )
  {

    // resource laden
    $user      = $this->getUser();


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



    // prüfen ob die angeforderte rückgabe so überhaupt erlaubt ist
    if(!$this->checkAccessType( View::AJAX ) )
    {
      // ok, der angefragte type wurde von vorne herein ausgeschlossen
      // also kommunizieren wir das so auch zurück
      throw new InvalidRequest_Exception
      (
        $response->i18n->l
        (
          'The requested Access Type is not implemented for this action.',
          'wbf.message'
        ),
        Response::NOT_IMPLEMENTED
      );
    }


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
            'service' => 'append'
          )
        ),
        Response::BAD_REQUEST
      );
    }


    // erst mal brauchen wir das passende model
    $model = $this->loadModel( 'WbfsysMessage_Crud' );

    // dann das passende entitiy objekt für den datensatz
    $entityMyMessage = $model->getEntityWbfsysMessage( $objid );

    // wenn null zurückgegeben wurde existiert der datensatz nicht
    // daher muss das System eine 404 Meldung zurückgeben
    if( !$entityMyMessage )
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
            'resource'  => $response->i18n->l( 'Message', 'wbfsys.message.label' ),
            'id'        => $objid
          )
        ),
        Response::NOT_FOUND
      );
    }


    // ok nun kommen wir zu der zugriffskontrolle
    $acl = $this->getAcl();

    // da wir die zugriffsrechte mehr als nur einmal brauchen holen wir uns
    // direkt das zugriffslevel
    $access = $acl->getPermission
    (
      'mod-wbfsys>mgmt-wbfsys_message',
      $entityMyMessage
    );

    // jo ändern können sollte er schon
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
            'resource'  => $response->i18n->l
            (
              'Message',
              'wbfsys.message.label'
            ),
            'id'        => $objid
          )
        ),
        Response::FORBIDDEN
      );
    }



    // interpret the parameters from the request
    $params = $this->getCrudFlags( $request );
    $params->access = $access;

    // der contextKey wird benötigt um potentielle Konflikte in der UI
    // bei der Anzeige von mehreren Windows oder Tabs zu vermeiden
    $params->contextKey = 'wbfsys_message-append-'.$objid;

    // fetch only id fields from the request
    $fields = $request->paramSearchIds();

    // fetch the data from the http request and load it in the model registry
    // if fails stop here
    if( !$model->fetchUpdateData( $entityMyMessage, $params ) )
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
            'resource' => $response->i18n->l
            (
              'Message',
              'wbfsys.message.label'
            )
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


    
    if(!$params->ltype)
      $params->ltype = 'table';

    $listType = ucfirst( $params->ltype );

    // send the table rows of the affected entries to the browser
    $ui = $this->loadUi( 'WbfsysMessage_'.$listType );
    $ui->setModel( $model );

    if( !$ui->listEntry( $params->accecss, $params, true ) )
      return false;

    // if this point is reached everything is fine
    return true;

  }//end public function service_append */

  /**
   * request the value of a specific field in the database by a given id
   * and a fieldname
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_textByKey( $request, $response )
  {

    // resource laden
    $user      = $this->getUser();


    // prüfen ob die angeforderte rückgabe so überhaupt erlaubt ist
    if(!$this->checkAccessType( View::AJAX ) )
    {
      // ok, der angefragte type wurde von vorne herein ausgeschlossen
      // also kommunizieren wir das so auch zurück
      throw new InvalidRequest_Exception
      (
        $response->i18n->l
        (
          'The requested Access Type is not implemented for this action.',
          'wbf.message'
        ),
        Response::NOT_IMPLEMENTED
      );
    }


    // prüfen ob die verwendete HTTP Methode für diesen service
    // überhaupt erlaub ist
    if( !( $request->method( Request::GET ) ) )
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
            'use'    => 'GET'
          )
        ),
        Error::METHOD_NOT_ALLOWED
      );

    }



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
            'service' => 'textByKey'
          )
        ),
        Response::BAD_REQUEST
      );
    }


    // erst mal brauchen wir das passende model
    $model = $this->loadModel( 'WbfsysMessage_Crud' );

    // dann das passende entitiy objekt für den datensatz
    $entityMyMessage = $model->getEntityWbfsysMessage( $objid );

    // wenn null zurückgegeben wurde existiert der datensatz nicht
    // daher muss das System eine 404 Meldung zurückgeben
    if( !$entityMyMessage )
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
            'resource'  => $response->i18n->l( 'Message', 'wbfsys.message.label' ),
            'id'        => $objid
          )
        ),
        Response::NOT_FOUND
      );
    }


    // ok nun kommen wir zu der zugriffskontrolle
    $acl = $this->getAcl();

    $access = new WbfsysMessage_Crud_Access_Listing( null, null, $this );
    $access->load( $user->getProfileName(), $params );

    // ok wenn er nichtmal lesen darf, dann ist hier direkt schluss
    if( !$access->access )
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
            'resource' => $response->i18n->l( 'Message', 'wbfsys.message.label' ),
            'id' => $objid
          )
        ),
        Response::FORBIDDEN
      );
    }


    // if the params are empty create a params object
    $params = new TFlag();
      

    // der contextKey wird benötigt um potentielle Konflikte in der UI
    // bei der Anzeige von mehreren Windows oder Tabs zu vermeiden
    $params->contextKey = 'wbfsys_message-text_by_key_'.$objid;

    $params->target = $request->param( 'target', Validator::CNAME );

    $ui = $this->loadUi( 'WbfsysMessage_Crud' );
    $ui->setModel( $model );


    $ui->textByKey( $entityMyMessage, $params );



  }//end public function service_textByKey */

////////////////////////////////////////////////////////////////////////////////
// Protected temporary methodes
////////////////////////////////////////////////////////////////////////////////
    
  /**
   * clean the post data after a sucess full request
   * @return boolean
   */
  public function cleanPost( )
  {

    $this->request->removeData( 'wbfsys_message' ); //def wbfsys_message


    // still running? fine :-)
    return true;

  }//end public function cleanPost */

} // end class WbfsysMessage_Controller */

