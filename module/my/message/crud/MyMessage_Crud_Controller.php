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
 * @subpackage Modprofiles
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright webfrap.net <contact@webfrap.net>
 */
class MyMessage_Crud_Controller extends ControllerCrud
{

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
    'edit' => array
    (
      'method'    => array( 'GET', 'PUT' ),
      'views'      => array( 'window', 'maintab' )
    ),
    'archive' => array
    (
      'method'    => array( 'PUT' ),
      'views'      => array( 'ajax' )
    ),
    'show' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'maintab' )
    ),
  );

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
  public function service_create($request, $response )
  {

    // resource laden
    $user      = $this->getUser();

    // prüfen ob irgendwelche steuerflags übergeben wurde
    $params  = $this->getFormFlags($request);

    // der contextKey wird benötigt um potentielle Konflikte in der UI
    // bei der Anzeige von mehreren Windows oder Tabs zu vermeiden
    $params->contextKey = 'my_message-create';

    $access = new WbfsysMessage_Crud_Access_Create( null, null, $this );
    $access->load($user->getProfileName(), $params );

    // der Access Container des Users für die Resource wird als flag übergeben
    $params->access = $access;

    // wenn er keine neuen Datensätze erstellen darf können wir direkt aufhören
    /*
    if (!$access->insert) {
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
    */

    $view = $response->loadView
    (
      'form-my_message-create',
      'MyMessage_Crud_Create',
      'displayForm'
    );

    if (!$view) {
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
    $view->setModel($model );

    // die view zum baue des formulars veranlassen
    $error = $view->displayForm($params );

    // Die Views geben eine Fehlerobjekt zurück, wenn ein Fehler aufgetreten
    // ist der so schwer war, dass die View den Job abbrechen musste
    // alle nötigen Informationen für den Enduser befinden sich in dem
    // Objekt
    // Standardmäßig entscheiden wir uns mal dafür diese dem User auch Zugänglich
    // zu machen und übergeben den Fehler der ErrorPage welche sich um die
    // korrekte Ausgabe kümmert
    if ($error) {
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
  public function service_send($request, $response )
  {

    // resource laden
    $user      = $this->getUser();

    // create named params object
    $params = $this->getCrudFlags($request);

    // der contextKey wird benötigt um potentielle Konflikte in der UI
    // bei der Anzeige von mehreren Windows oder Tabs zu vermeiden
    $params->contextKey = 'wbfsys_message-send';

    $access = new WbfsysMessage_Crud_Access_Insert( null, null, $this );
    $access->load($user->getProfileName(),  $params );

    // der Access Container des Users für die Resource wird als flag übergeben
    $params->access = $access;

    // das crud model wird zum validieren des requests und zum erstellen
    // des neuen datensatzes benötigt
    $model = $this->loadModel( 'MyMessage_Crud' );

    // die genauen fehlermeldungen werden direkt vom validator in die
    // message queue gepackt
    if ($error = $model->fetchInsertData($params ) ) {
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
    if ($error = $model->send($params ) ) {

      // hm ok irgendwas ist gerade ziemlich schief gelaufen
      throw new InvalidRequest_Exception
      (
        $error->message,
        $error->errorKey
      );
    } else {

      /*

        if (!$params->ltype )
          $params->ltype = 'table';

        if (!$params->viewType )
          $params->viewType = 'maintab';

        $listType = ucfirst($params->ltype );

        // die Maske über welche der neue Liste Eintrag gerendert werden soll
        if (!$params->mask )
          $params->mask = 'WbfsysMessage';

        // laden der angeforderten view
        $view = $response->loadView
        (
          'listing_wbfsys_message',
          $params->mask.'_'.$listType,
          'displayInsert'
        );

      if (!$view) {
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
      $view->setModel($this->loadModel($params->mask.'_'.$listType ) );

      $error = $view->displayInsert($params );

      // im Fehlerfall jedoch bekommen wir eine Error Objekt das wird noch kurz
      // behandeln sollten
      if ($error) {
        return $error;
      }

      */

    }

    // wenn wir hier ankommen, dann hat alles geklappt
    return true;

  }//end public function service_insert */

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
  public function service_show($request, $response )
  {

    // resource laden
    $user      = $this->getUser();

    // Die ID ist Plicht.
    // Ohne diese können wir keinen Datensatz identifizieren und somit auch
    // auf Anfage logischerweise nicht bearbeiten
    if (!$objid = $this->getOID() ) {
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
    $model = $this->loadModel( 'MyMessage_Crud' );

    // dann das passende entitiy objekt für den datensatz
    $entityMyMessage = $model->getEntityMyMessage($objid );

    // wenn null zurückgegeben wurde existiert der datensatz nicht
    // daher muss das System eine 404 Meldung zurückgeben
    if (!$entityMyMessage) {
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
    $params  = $this->getFormFlags($request);

    // der contextKey wird benötigt um potentielle Konflikte in der UI
    // bei der Anzeige von mehreren Windows oder Tabs zu vermeiden
    $params->contextKey = 'my_message-show-'.$objid;

    // wenn keine root übergeben wird oder wir in level 1 sind
    // dann befinden wir uns im root und brauchen keine pfadafrage
    // um potentielle fehler abzufangen wird auch direkt der richtige Root gesetzt
    // nicht das hier einer einen falschen pfad injected
    if (is_null($params->aclRoot) || 1 == $params->aclLevel  ) {
      $params->isAclRoot     = true;
      $params->aclRoot       = 'mgmt-wbfsys_message';
      $params->aclRootId     = $objid;
      $params->aclKey        = 'mgmt-wbfsys_message';
      $params->aclNode       = 'mgmt-wbfsys_message';
      $params->aclLevel      = 1;
    }

    // ok nun kommen wir zu der zugriffskontrolle
    $acl = $this->getAcl();

    // da wir die zugriffsrechte mehr als nur einmal brauchen holen wir uns
    // direkt einen acl container
    $access = $acl->getFormPermission
    (
      'mod-wbfsys>mgmt-wbfsys_message',
      $entityMyMessage
    );

    // der Access Container des Users für die Resource wird als flag übergeben
    $params->access = $access;

    // show ist per definition immer readonly
    $params->readOnly = true;

    // laden der passenden subview
    $view = $response->loadView
    (
      'form-my_message-edit-'.$objid,
      'MyMessage_Crud_Show',
      'displayForm'
    );

    if (!$view) {
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
    $view->setModel($model );

    // wenn alles glatt geht gibt die view null zurück und der keks ist gegessen
    $error = $view->displayForm($objid, $params );

    // im Fehlerfall jedoch bekommen wir eine Error Objekt das wird noch kurz
    // behandeln sollten
    if ($error) {
      return $error;
    }

    return true;

  }//end public function service_show */

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
  public function service_archive($request, $response )
  {

    // resource laden
    $user      = $this->getUser();

    // prüfen ob eine valide id mit übergeben wurde
    if (!$objid = $this->getOID( ) ) {
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
    $model = $this->loadModel( 'MyMessage_Crud' );

    // dann das passende entitiy objekt für den datensatz
    $entityMyMessage = $model->getEntityMyMessage($objid );

    // wenn null zurückgegeben wurde existiert der datensatz nicht
    // daher muss das System eine 404 Meldung zurückgeben
    if (!$entityMyMessage) {
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
    $params = $this->getCrudFlags($request);

    // der contextKey wird benötigt um potentielle Konflikte in der UI
    // bei der Anzeige von mehreren Windows oder Tabs zu vermeiden
    $params->contextKey = 'my_message-archive-'.$objid;

    $access = new MyMessage_Crud_Access_Update( null, null, $this );
    $access->load($user->getProfileName(), $params, $entityMyMessage );

    // der Access Container des Users für die Resource wird als flag übergeben
    $params->access = $access;

    if (!$params->ltype )
      $params->ltype = 'table';

    if (!$params->mask )
      $params->mask = 'MyMessage';

    $listType = ucfirst($params->ltype );

    $error = $model->archive($entityMyMessage, $params );

    // try to delete the dataset
    if ($error) {
      // hm ok irgendwas ist gerade ziemlich schief gelaufen
      return $error;
    }

    // laden der angeforderten view
    $view = $response->loadView
    (
      'listing_my_message',
      $params->mask.'_'.$listType,
      'displayArchive',
      null,
      true
    );

    // model wird benötigt
    $view->setModel($this->loadModel($params->mask.'_'.$listType ) );

    $view->displayArchive($entityMyMessage, $params );

  }//end public function service_archive */

}// end class MyMessage_Crud_Controller

