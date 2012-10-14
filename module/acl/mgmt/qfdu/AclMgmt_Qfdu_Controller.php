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
 * Read before change:
 * It's not recommended to change this file inside a Mod or App Project.
 * If you want to change it copy it to a custom project.

 *
 * @package WebFrap
 * @subpackage ModEmployee
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright webfrap.net <contact@webfrap.net>
 */
class AclMgmt_Qfdu_Controller
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
    'tabqualifiedusers' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'ajax' )
    ),
    'searchqfdusers' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'ajax' )
    ),
    'loadqfdusers' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'ajax' )
    ),
    'loadqfduentity' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'ajax' )
    ),
    'appendqfduser' => array
    (
      'method'    => array( 'PUT', 'POST' ),
      'views'      => array( 'ajax' )
    ),
    'cleanqfdugroup' => array
    (
      'method'    => array( 'DELETE' ),
      'views'      => array( 'ajax' )
    ),
    'deleteqfduser' => array
    (
      'method'    => array( 'DELETE' ),
      'views'      => array( 'ajax' )
    ),
    'cleanqfduser' => array
    (
      'method'    => array( 'DELETE' ),
      'views'      => array( 'ajax' )
    ),
    'deleteqfdudataset' => array
    (
      'method'    => array( 'DELETE' ),
      'views'      => array( 'ajax' )
    ),
    'emptyqfduusers' => array
    (
      'method'    => array( 'DELETE' ),
      'views'      => array( 'ajax' )
    )
    
  );

////////////////////////////////////////////////////////////////////////////////
// Qualified User Handling
////////////////////////////////////////////////////////////////////////////////

  /**
   * the default table for the management EnterpriseEmployee
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return boolean
   */
  public function service_tabQualifiedUsers( $request, $response )
  {


    // load request parameters an interpret as flags
    $params  = $this->getTabFlags( $request );


    $user = $this->getUser();

    $access = new AclMgmt_Access_Container( null, null, $this );
    $access->load( $user->getProfileName(), $params );

    // ok wenn er nichtmal lesen darf, dann ist hier direkt schluss
    if( !$access->admin )
    {
      // ausgabe einer fehlerseite und adieu
      throw new InvalidRequest_Exception
      (
        $response->i18n->l
        (
          'You have no permission for administration in {@resource@}',
          'wbf.message',
          array
          (
            'resource'  => $response->i18n->l( 'Employee', 'enterprise.employee.label' )
          )
        ),
        Response::FORBIDDEN
      );
    }

    // der Access Container des Users für die Resource wird als flag übergeben
    $params->access = $access;


    /* @var $model AclMgmt_Qfdu_Model  */
    $model = $this->loadModel
    (
      'AclMgmt_Qfdu'
    );

    // target for some ui element
    $areaId = $model->getAreaId();

    // create a new area with the id of the target element, this area will replace
    // the HTML Node of the target UI Element
    $view    = $this->tpl->newSubView
    (
      $params->tabId,
      'AclMgmt_Qfdu_Area',
      'displayTab',
      null,
      true
    );

    $view->setPosition( '#'.$params->tabId );
    $view->setModel( $model );

    $error = $view->displayTab( $areaId, $params );


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


  }//end public function service_tabQualifiedUsers */

  /**
   *
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return boolean
   */
  public function service_searchQfdUsers( $request, $response )
  {

    // load the flow flags
    $params = $this->getListingFlags( $request );


    $user = $this->getUser();

    $access = new AclMgmt_Access_Container( null, null, $this );
    $access->load( $user->getProfileName(), $params );

    // ok wenn er nichtmal lesen darf, dann ist hier direkt schluss
    if( !$access->admin )
    {
      // ausgabe einer fehlerseite und adieu
      throw new InvalidRequest_Exception
      (
        $response->i18n->l
        (
          'You have no permission for administration in {@resource@}',
          'wbf.message',
          array
          (
            'resource'  => $response->i18n->l( 'Employee', 'enterprise.employee.label' )
          )
        ),
        Response::FORBIDDEN
      );
    }

    // der Access Container des Users für die Resource wird als flag übergeben
    $params->access = $access;


    // load the default model
    /* @var $model AclMgmt_Qfdu_Model  */
    $model  = $this->loadModel( 'AclMgmt_Qfdu' );
    $areaId = $model->getAreaId();

    // this can only be an ajax request, so we can directly load the ajax view
    $view   = $this->tpl->loadView
    (
      'AclMgmt_Qfdu_Ajax'
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
    $error = $view->displaySearch( $areaId, $params );


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


  }//end public function service_searchQfdUsers */

  /**
   * the default table for the management EnterpriseEmployee
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return boolean
   */
  public function service_loadQfdUsers( $request, $response )
  {

    // load request parameters an interpret as flags
    $params = $this->getListingFlags( $request );


    $user = $this->getUser();

    $access = new AclMgmt_Access_Container( null, null, $this );
    $access->load( $user->getProfileName(), $params );

    // ok wenn er nichtmal lesen darf, dann ist hier direkt schluss
    if( !$access->admin )
    {
      // ausgabe einer fehlerseite und adieu
      throw new InvalidRequest_Exception
      (
        $response->i18n->l
        (
          'You have no permission for administration in {@resource@}',
          'wbf.message',
          array
          (
            'resource'  => $response->i18n->l( 'Employee', 'enterprise.employee.label' )
          )
        ),
        Response::FORBIDDEN
      );
    }

    // der Access Container des Users für die Resource wird als flag übergeben
    $params->access = $access;


    /* @var $model AclMgmt_Qfdu_Model  */
    $model = $this->loadModel( 'AclMgmt_Qfdu' );

    $view   = $this->tpl->loadView( 'AclMgmt_Qfdu_Ajax' );
    $view->setModel( $model );

    $searchKey  = $this->request->param( 'key', Validator::TEXT );
    $areaId     = $model->getAreaId();

    $error = $view->displayAutocomplete( $areaId, $searchKey, $params );


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


  }//end public function service_loadQfdUsers */

  /**
   * the default table for the management EnterpriseEmployee
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return boolean
   */
  public function service_loadQfduEntity( $request, $response )
  {

    // load request parameters an interpret as flags
    $params = $this->getListingFlags( $request );


    $user = $this->getUser();

    $access = new AclMgmt_Access_Container( null, null, $this );
    $access->load( $user->getProfileName(), $params );

    // ok wenn er nichtmal lesen darf, dann ist hier direkt schluss
    if( !$access->admin )
    {
      // ausgabe einer fehlerseite und adieu
      throw new InvalidRequest_Exception
      (
        $response->i18n->l
        (
          'You have no permission for administration in {@resource@}',
          'wbf.message',
          array
          (
            'resource'  => $response->i18n->l( 'Employee', 'enterprise.employee.label' )
          )
        ),
        Response::FORBIDDEN
      );
    }

    // der Access Container des Users für die Resource wird als flag übergeben
    $params->access = $access;


    /* @var $model AclMgmt_Qfdu_Model  */
    $model = $this->loadModel( 'AclMgmt_Qfdu' );

    $view   = $this->tpl->loadView( 'AclMgmt_Qfdu_Ajax' );
    $view->setModel( $model );

    $searchKey  = $this->request->param( 'key', Validator::TEXT );
    $areaId     = $model->getAreaId();

    $error = $view->displayAutocompleteEntity( $areaId, $searchKey, $params );


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


  }//end public function service_loadQfduEntity */

  /**
   * the default table for the management EnterpriseEmployee
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return boolean
   */
  public function service_appendQfdUser( $request, $response )
  {

    // load request parameters an interpret as flags
    $params = $this->getListingFlags( $request );


    $user = $this->getUser();

    $access = new AclMgmt_Access_Container( null, null, $this );
    $access->load( $user->getProfileName(), $params );

    // ok wenn er nichtmal lesen darf, dann ist hier direkt schluss
    if( !$access->admin )
    {
      // ausgabe einer fehlerseite und adieu
      throw new InvalidRequest_Exception
      (
        $response->i18n->l
        (
          'You have no permission for administration in {@resource@}',
          'wbf.message',
          array
          (
            'resource'  => $response->i18n->l( 'Employee', 'enterprise.employee.label' )
          )
        ),
        Response::FORBIDDEN
      );
    }

    // der Access Container des Users für die Resource wird als flag übergeben
    $params->access = $access;


    /* @var $model AclMgmt_Qfdu_Model  */
    $model  = $this->loadModel( 'AclMgmt_Qfdu' );

    $view   = $this->tpl->loadView( 'AclMgmt_Qfdu_Ajax' );
    $view->setModel( $model );

    // fetch the data from the http request and load it in the model registry
    // if fails stop here
    if( $error = $model->fetchConnectData( $params ) )
    {
      // wenn wir einen fehler bekommen ist schluss
      return $error;
    }

    // prüfen ob die zuweisung unique ist
    ///TODO hier muss noch ein trigger in die datenbank um raceconditions zu vermeiden
    if( !$model->checkUnique() )
    {

      throw new InvalidRequest_Exception
      (
        $response->i18n->l
        (
          'This Assignment allready exists!',
          'wbf.message'
        ),
        Error::CONFLICT
      );

    }

    if( $error = $model->connect( $params ) )
    {
      // wenn wir einen fehler bekommen ist schluss
      return $error;
    }

    $entityAssign = $model->getEntityWbfsysGroupUsers( );

    $error = $view->displayConnect( $entityAssign->id_area, $params );


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


  }//end public function service_appendQfdUser */

////////////////////////////////////////////////////////////////////////////////
// QDFU delete & clean methodes
////////////////////////////////////////////////////////////////////////////////

 /**
  * delete a single entity
  * @param LibRequestHttp $request
  * @param LibResponseHttp $response
  * @return boolean success flag
  */
  public function service_cleanQfduGroup( $request, $response )
  {

    // check if the request method is DELETE
    if( !$request->method( Request::DELETE )  )
    {
      throw new InvalidRequest_Exception
      (
        $response->i18n->l
        (
          'Invalid request method for {@service@}, method must be {@method@}',
          'wbf.message',
          array
          (
            'service' => 'cleanQfduGroup',
            'method'  => 'DELETE'
          )
        ),
        Error::METHOD_NOT_ALLOWED
      );
    }

    // prüfen ob die view vom Type Ajax ist
    if(!$this->checkAccessType( View::AJAX ) )
    {
      // alles andere als ajax abfragen wird direkt abgelehnt
      throw new InvalidRequest_Exception
      (
        $response->i18n->l
        (
          'The requested Outputformat is not implemented for this action!',
          'wbf.message'
        ),
        Response::NOT_IMPLEMENTED
      );
    }

    $objid  = $this->request->param( 'objid', Validator::EID );

    // did we receive an id of an object that should be deleted
    if( !$objid  )
    {
      throw new InvalidRequest_Exception
      (
        'Missing the ID',
        Response::BAD_REQUEST
      );
    }

    // interpret the given user parameters
    $params = $this->getCrudFlags( $request );


    $user = $this->getUser();

    $access = new AclMgmt_Access_Container( null, null, $this );
    $access->load( $user->getProfileName(), $params );

    // ok wenn er nichtmal lesen darf, dann ist hier direkt schluss
    if( !$access->admin )
    {
      // ausgabe einer fehlerseite und adieu
      throw new InvalidRequest_Exception
      (
        $response->i18n->l
        (
          'You have no permission for administration in {@resource@}',
          'wbf.message',
          array
          (
            'resource'  => $response->i18n->l( 'Employee', 'enterprise.employee.label' )
          )
        ),
        Response::FORBIDDEN
      );
    }

    // der Access Container des Users für die Resource wird als flag übergeben
    $params->access = $access;


    /* @var $model AclMgmt_Qfdu_Model  */
    $model = $this->loadModel( 'AclMgmt_Qfdu' );
    $model->setView( $this->tpl );

    $areaId = $model->getAreaId();

    // try to delete the dataset
    if( $model->cleanQfduGroup( $objid, $areaId, $params ) )
    {
      // if we got a target id we remove the element from the client
      if( $params->targetId )
      {
        $ui = $this->loadUi( 'AclMgmt_Qfdu' );

        $ui->setModel( $model );
        $ui->setView( $this->tpl );
        $ui->removeGroupEntry( $objid, $params->targetId );
      }
    }

    return true;

  }//end public function service_cleanQfduGroup */

 /**
  * delete a single entity
  * @param LibRequestHttp $request
  * @param LibResponseHttp $response
  * @return boolean success flag
  */
  public function service_deleteQfdUser( $request, $response )
  {


    $groupId  = $this->request->param( 'group_id', Validator::EID );
    $userId   = $this->request->param( 'user_id', Validator::EID );

    // did we receive an id of an object that should be deleted
    if( !$groupId || !$userId )
    {
      // wenn die daten nicht valide sind, dann war es eine ungültige anfrage
      throw new InvalidRequest_Exception
      (
        $response->i18n->l
        (
          'The Request for {@resource@} was invalid.',
          'wbf.message',
          array
          (
            'resource' => 'appendGroup'
          )
        ),
        Response::BAD_REQUEST
      );
    }


    // interpret the given user parameters
    $params   = $this->getCrudFlags( $request );


    $user = $this->getUser();

    $access = new AclMgmt_Access_Container( null, null, $this );
    $access->load( $user->getProfileName(), $params );

    // ok wenn er nichtmal lesen darf, dann ist hier direkt schluss
    if( !$access->admin )
    {
      // ausgabe einer fehlerseite und adieu
      throw new InvalidRequest_Exception
      (
        $response->i18n->l
        (
          'You have no permission for administration in {@resource@}',
          'wbf.message',
          array
          (
            'resource'  => $response->i18n->l( 'Employee', 'enterprise.employee.label' )
          )
        ),
        Response::FORBIDDEN
      );
    }

    // der Access Container des Users für die Resource wird als flag übergeben
    $params->access = $access;


    /* @var $model AclMgmt_Qfdu_Model  */
    $model    = $this->loadModel( 'AclMgmt_Qfdu' );
    $model->setView( $this->tpl );

    $areaId   = $model->getAreaId();

    // try to delete the dataset
    if($model->deleteQfdUser(  $groupId, $userId, $areaId, $params ))
    {
      // if we got a target id we remove the element from the client
      if( $params->targetId )
      {
        $ui = $this->loadUi( 'AclMgmt_Qfdu' );

        $ui->setModel( $model );
        $ui->setView( $this->tpl );
        $ui->removeUserEntry( $groupId, $userId, $params->targetId );
      }
    }

    return true;

  }//end public function service_deleteQfdUser */

 /**
  * delete a single entity
  * @param LibRequestHttp $request
  * @param LibResponseHttp $response
  * @return boolean success flag
  */
  public function service_cleanQfdUser( $request, $response )
  {

    // check if the request method is DELETE
    if( !$request->method( Request::DELETE )  )
    {
      throw new InvalidRequest_Exception
      (
        $response->i18n->l
        (
          'Invalid request method for {@service@}, method must be {@method@}',
          'wbf.message',
          array
          (
            'service' => 'cleanQfdUser',
            'method'  => 'DELETE'
          )
        ),
        Error::METHOD_NOT_ALLOWED
      );
    }

    // prüfen ob die view vom Type Ajax ist
    if(!$this->checkAccessType( View::AJAX ) )
    {
      // alles andere als ajax abfragen wird direkt abgelehnt
      throw new InvalidRequest_Exception
      (
        $response->i18n->l
        (
          'The requested Outputformat is not implemented for this action!',
          'wbf.message'
        ),
        Response::NOT_IMPLEMENTED
      );
    }

    ///TODO genauere fehlermeldungen hier
    $groupId = $this->request->param( 'group_id', Validator::EID );
    $userId  = $this->request->param( 'user_id' , Validator::EID );
    $areaId  = $this->request->param( 'area_id' , Validator::EID );


    // did we receive an id of an object that should be deleted
    if( !$groupId || !$userId || !$areaId )
    {
      // wenn die daten nicht valide sind, dann war es eine ungültige anfrage
      throw new InvalidRequest_Exception
      (
        $response->i18n->l
        (
          'The Request for {@resource@} was invalid.',
          'wbf.message',
          array
          (
            'resource' => 'cleanQfdUser'
          )
        ),
        Response::BAD_REQUEST
      );
    }

    // interpret the given user parameters
    $params = $this->getCrudFlags( $request );


    $user = $this->getUser();

    $access = new AclMgmt_Access_Container( null, null, $this );
    $access->load( $user->getProfileName(), $params );

    // ok wenn er nichtmal lesen darf, dann ist hier direkt schluss
    if( !$access->admin )
    {
      // ausgabe einer fehlerseite und adieu
      throw new InvalidRequest_Exception
      (
        $response->i18n->l
        (
          'You have no permission for administration in {@resource@}',
          'wbf.message',
          array
          (
            'resource'  => $response->i18n->l( 'Employee', 'enterprise.employee.label' )
          )
        ),
        Response::FORBIDDEN
      );
    }

    // der Access Container des Users für die Resource wird als flag übergeben
    $params->access = $access;


    /* @var $model AclMgmt_Qfdu_Model  */
    $model = $this->loadModel('AclMgmt_Qfdu');
    $model->setView($this->tpl);

    // try to delete the dataset
    if($model->cleanQfdUser( $groupId, $userId, $areaId, $params ))
    {
      // if we got a target id we remove the element from the client
      if( $params->targetId )
      {
        $ui = $this->loadUi( 'AclMgmt_Qfdu' );

        $ui->setModel($model);
        $ui->setView($this->tpl);
        $ui->cleanUserEntry( $groupId, $userId, $params->targetId );
      }
    }

    return true;

  }//end public function service_cleanQfdUser */

 /**
  * delete a single entity
  * @param LibRequestHttp $request
  * @param LibResponseHttp $response
  * @return boolean success flag
  */
  public function service_deleteQfduDataset( $request, $response )
  {

    // check if the request method is DELETE
    if( !$request->method( Request::DELETE )  )
    {
      throw new InvalidRequest_Exception
      (
        $response->i18n->l
        (
          'Invalid request method for {@service@}, method must be {@method@}',
          'wbf.message',
          array
          (
            'service' => 'deleteQfduDataset',
            'method'  => 'DELETE'
          )
        ),
        Error::METHOD_NOT_ALLOWED
      );
    }

    // prüfen ob die view vom Type Ajax ist
    if(!$this->checkAccessType( View::AJAX ) )
    {
      // alles andere als ajax abfragen wird direkt abgelehnt
      throw new InvalidRequest_Exception
      (
        $response->i18n->l
        (
          'The requested Outputformat is not implemented for this action!',
          'wbf.message'
        ),
        Response::NOT_IMPLEMENTED
      );
    }

    // did we receive an id of an object that should be deleted
    if( !$objid = $this->request->param('objid',Validator::EID) )
    {
      // wenn nicht ist die anfrage per definition invalide
      throw new InvalidRequest_Exception
      (
        $response->i18n->l
        (
          'The Request for action {@resource@} was invalid. ID was missing!',
          'wbf.message',
          array
          (
            'resource' => 'deleteQfduDataset'
          )
        ),
        Response::BAD_REQUEST
      );
    }

    // interpret the given user parameters
    $params          = $this->getCrudFlags( $request );


    $user = $this->getUser();

    $access = new AclMgmt_Access_Container( null, null, $this );
    $access->load( $user->getProfileName(), $params );

    // ok wenn er nichtmal lesen darf, dann ist hier direkt schluss
    if( !$access->admin )
    {
      // ausgabe einer fehlerseite und adieu
      throw new InvalidRequest_Exception
      (
        $response->i18n->l
        (
          'You have no permission for administration in {@resource@}',
          'wbf.message',
          array
          (
            'resource'  => $response->i18n->l( 'Employee', 'enterprise.employee.label' )
          )
        ),
        Response::FORBIDDEN
      );
    }

    // der Access Container des Users für die Resource wird als flag übergeben
    $params->access = $access;


    /* @var $model AclMgmt_Qfdu_Model  */
    $model = $this->loadModel( 'AclMgmt_Qfdu' );
    $model->setView( $this->tpl );

    $error = $model->deleteQfduDataset( $objid, $params );

    if( $error )
    {
      return $error;
    }

    // if we got a target id we remove the element from the client
    if( $params->targetId )
    {
      $ui = $this->loadUi( 'AclMgmt_Qfdu' );

      $ui->setModel( $model );
      $ui->setView( $this->tpl );
      $ui->removeDatasetEntry( $objid, $params->targetId );
    }

    return null;

  }//end public function service_deleteQfduDataset */

////////////////////////////////////////////////////////////////////////////////
// parse flags
////////////////////////////////////////////////////////////////////////////////

  /**
   * @param LibRequestHttp $request
   * @throws InvalidRequest_Exception
   * @return DomainNode 
   */
  protected function getDomainNode( $request )
  {
    
    $domainKey   = $request->param( 'dkey', Validator::CKEY );
    if( !$domainKey )
    {
      throw new InvalidRequest_Exception
      (
        'Missing Domain Parameter',
        Response::BAD_REQUEST
      );
    }
    
    $domainNode  = DomainNode::getNode( $domainKey );
    
    if( !$domainNode )
    {
      throw new InvalidRequest_Exception
      (
        'The requestes Metadate not exists',
        Response::NOT_FOUND
      );
    }
    
    return $domainNode;
    
  }//end protected function getDomainNode */

  /**
   * @param TFlag $params
   * @return TFlag
   */
  protected function getListingFlags( $request )
  {

    $response  = $this->getResponse();
    
    $params = new TFlag();

    // the publish type, like selectbox, tree, table..
    if( $publish  = $request->param( 'publish', Validator::CNAME ) )
      $params->publish   = $publish;

    // listing type
    if( $ltype   = $request->param( 'ltype', Validator::CNAME ) )
      $params->ltype    = $ltype;

    // input type
    if( $input = $request->param( 'input', Validator::CKEY ) )
      $params->input    = $input;

    // input type
    if( $suffix = $request->param( 'suffix', Validator::CKEY ) )
      $params->suffix    = $suffix;

    // append entries
    if( $append = $request->param( 'append', Validator::BOOLEAN ) )
      $params->append    = $append;

    // startpunkt des pfades für die acls
    if( $aclRoot = $request->param( 'a_root', Validator::CKEY ) )
      $params->aclRoot    = $aclRoot;

    // die id des Datensatzes von dem aus der Pfad gestartet wurde
    if( $aclRootId = $request->param( 'a_root_id', Validator::INT ) )
      $params->aclRootId    = $aclRootId;

    // der key des knotens auf dem wir uns im pfad gerade befinden
    if( $aclKey = $request->param( 'a_key', Validator::CKEY ) )
      $params->aclKey    = $aclKey;

    // der name des knotens
    if( $aclNode = $request->param( 'a_node', Validator::CKEY ) )
      $params->aclNode    = $aclNode;

    // an welchem punkt des pfades befinden wir uns?
    if( $aclLevel = $request->param( 'a_level', Validator::INT ) )
      $params->aclLevel  = $aclLevel;


    // per default
    $params->categories = array();

    if( 'selectbox' === $params->publish )
    {

      // fieldname of the calling selectbox
      $params->field
        = $request->param( 'field', Validator::CNAME );

      // html id of the calling selectbox
      $params->inputId
        = $request->param( 'input_id', Validator::CKEY );

      // html id of the table
      $params->targetId
        = $request->param( 'target_id', Validator::CKEY );

      // html id of the calling selectbox
      $params->target
        = str_replace('_','.',$request->param('target',Validator::CKEY ));

    }
    else
    {

      // start position of the query and size of the table
      $params->start
        = $request->param('start', Validator::INT );

      // stepsite for query (limit) and the table
      if( !$params->qsize = $request->param('qsize', Validator::INT ) )
        $params->qsize = Wgt::$defListSize;

      // order for the multi display element
      $params->order
        = $request->param('order', Validator::CNAME );

      // target for a callback function
      $params->target
        = $request->param('target', Validator::CKEY  );

      // target for some ui element
      $params->targetId
        = $request->param('target_id', Validator::CKEY  );

      // flag for beginning seach filter
      if( $text = $request->param('begin', Validator::TEXT  ) )
      {
        // whatever is comming... take the first char
        $params->begin = $text[0];
      }

      // the model should add all inputs in the ajax request, not just the text
      // converts per default to false, thats ok here
      $params->fullLoad
        = $request->param('full_load', Validator::BOOLEAN );

      // exclude whatever
      $params->exclude
        = $request->param('exclude', Validator::CKEY  );

      // keyname to tageting ui elements
      $params->keyName
        = $request->param('key_name', Validator::CKEY  );

      // the activ id, mostly needed in exlude calls
      $params->objid
        = $request->param('objid', Validator::EID  );

    }

    return $params;

  }//end protected function getListingFlags */

  /**
   * @param TFlag $params
   * @return TFlag
   */
  protected function getCrudFlags( $request )
  {

    $response  = $this->getResponse();

    // create named parameters object
    $params = new TFlag();
      

    // the publish type, like selectbox, tree, table..
    if( $publish  = $request->param( 'publish', Validator::CNAME ) )
      $params->publish   = $publish;

    // listing type
    if( $ltype   = $request->param( 'ltype', Validator::CNAME ) )
      $params->ltype    = $ltype;

    // context
    if( $context   = $request->param( 'context', Validator::CNAME ) )
      $params->context    = $context;

    // if of the target element, can be a table, a tree or whatever
    if( $targetId = $request->param( 'target_id', Validator::CKEY ) )
      $params->targetId  = $targetId;


    // callback for a target function in thr browser
    if( $target   = $request->param( 'target', Validator::CNAME ) )
      $params->target    = $target;

    // mask key
    if( $mask = $request->param( 'mask', Validator::CNAME ) )
      $params->mask  = $mask;

    // mask key
    if( $viewType = $request->param( 'view', Validator::CNAME ) )
      $params->viewType  = $viewType;

    // mask key
    if( $viewId = $request->param( 'view_id', Validator::CKEY ) )
      $params->viewId  = $viewId;

    // refid
    if( $refid = $request->param( 'refid', Validator::INT ) )
      $params->refId  = $refid;

    // startpunkt des pfades für die acls
    if( $aclRoot = $request->param( 'a_root', Validator::CKEY ) )
      $params->aclRoot    = $aclRoot;

    // die id des Datensatzes von dem aus der Pfad gestartet wurde
    if( $aclRootId = $request->param( 'a_root_id', Validator::INT ) )
      $params->aclRootId    = $aclRootId;

    // der key des knotens auf dem wir uns im pfad gerade befinden
    if( $aclKey = $request->param( 'a_key', Validator::CKEY ) )
      $params->aclKey    = $aclKey;

    // der name des knotens
    if( $aclNode = $request->param( 'a_node', Validator::CKEY ) )
      $params->aclNode    = $aclNode;

    // an welchem punkt des pfades befinden wir uns?
    if( $aclLevel = $request->param( 'a_level', Validator::INT ) )
      $params->aclLevel  = $aclLevel;

    // per default
    $params->categories = array();

    return $params;

  }//end protected function getCrudFlags */

  /**
   * @param TFlag $params
   * @return TFlag
   */
  protected function getTabFlags( $request )
  {

    $response  = $this->getResponse();

    $params = new TFlagListing( $request );
      

    // per default
    $params->categories = array();

    // listing type
    if( $ltype   = $request->param( 'ltype', Validator::CNAME ) )
      $params->ltype    = $ltype;

    // context type
    if( $context = $request->param( 'context', Validator::CNAME ) )
      $params->context    = $context;

    // start position of the query and size of the table
    $params->start
      = $request->param('start', Validator::INT );

    // stepsite for query (limit) and the table
    if( !$params->qsize = $request->param('qsize', Validator::INT ) )
      $params->qsize = Wgt::$defListSize;

    // order for the multi display element
    $params->order
      = $request->param('order', Validator::CNAME );

    // target for a callback function
    $params->target
      = $request->param('target', Validator::CKEY  );

    // target for some ui element
    $params->targetId
      = $request->param('target_id', Validator::CKEY  );

    // target for some ui element
    $params->tabId
      = $request->param('tabid', Validator::CKEY  );

    // flag for beginning seach filter
    if( $text = $request->param('begin', Validator::TEXT  ) )
    {
      // whatever is comming... take the first char
      $params->begin = $text[0];
    }

    // exclude whatever
    $params->exclude
      = $request->param('exclude', Validator::CKEY  );

    // the activ id, mostly needed in exlude calls
    $params->objid
      = $request->param('objid', Validator::EID  );

    // startpunkt des pfades für die acls
    if( $aclRoot = $request->param( 'a_root', Validator::CKEY ) )
      $params->aclRoot    = $aclRoot;

    // die id des Datensatzes von dem aus der Pfad gestartet wurde
    if( $aclRootId = $request->param( 'a_root_id', Validator::INT ) )
      $params->aclRootId    = $aclRootId;

    // der key des knotens auf dem wir uns im pfad gerade befinden
    if( $aclKey = $request->param( 'a_key', Validator::CKEY ) )
      $params->aclKey    = $aclKey;

    // der name des knotens
    if( $aclNode = $request->param( 'a_node', Validator::CKEY ) )
      $params->aclNode    = $aclNode;

    // an welchem punkt des pfades befinden wir uns?
    if( $aclLevel = $request->param( 'a_level', Validator::INT ) )
      $params->aclLevel  = $aclLevel;


    return $params;

  }//end protected function getTabFlags */

} // end class AclMgmt_Qfdu_Controller */

