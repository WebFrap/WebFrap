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
 * @subpackage Acl
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright webfrap.net <contact@webfrap.net>
 */
class AclMgmt_Qfdu_Controller
  extends MvcController_Domain
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
  
    'tabusers' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'ajax' )
    ),
    'searchusers' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'ajax' )
    ),
    
    'loadusers' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'ajax' )
    ),
    'loadentity' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'ajax' )
    ),
    'appenduser' => array
    (
      'method'    => array( 'PUT', 'POST' ),
      'views'      => array( 'ajax' )
    ),
    
    // dropping of assignments
    'dropallassignments' => array
    (
      'method'    => array( 'DELETE' ),
      'views'      => array( 'ajax' )
    ),
    
    
    'cleanroup' => array
    (
      'method'    => array( 'DELETE' ),
      'views'      => array( 'ajax' )
    ),
    'emptyusers' => array
    (
      'method'    => array( 'DELETE' ),
      'views'      => array( 'ajax' )
    ),
    
    // group by users
    'listbyusers' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'ajax' )
    ),
    
    'searchbyusers' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'ajax' )
    ),
    
    'loadlistuserdsets' => array
    (
      'method'    => array( 'GET' ),
      'views'     => array( 'ajax' )
    ),
    
    'loadlistusergroups' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'ajax' )
    ),
    
    // group by dsets
    'listbydsets' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'ajax' )
    ),
    'searchbydsets' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'ajax' )
    ),
    
    'loadlistdsetusers' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'ajax' )
    ),
    
    'loadlistdsetgroups' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'ajax' )
    ),
    
  );

////////////////////////////////////////////////////////////////////////////////
// Group By Group Logik
////////////////////////////////////////////////////////////////////////////////

  /**
   * the default table for the management EnterpriseEmployee
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return boolean
   */
  public function service_tabUsers( $request, $response )
  {

    // load request parameters an interpret as flags
    $params  = $this->getTabFlags( $request );
    $domainNode  = $this->getDomainNode( $request );

    /* @var $model AclMgmt_Qfdu_Model */
    $model = $this->loadModel( 'AclMgmt_Qfdu' );
    $model->domainNode = $domainNode;
    $model->checkAccess( $domainNode, $params );

    // target for some ui element
    $areaId = $model->getAreaId();

    // create a new area with the id of the target element, this area will replace
    // the HTML Node of the target UI Element
    $view    = $response->loadView
    (
      $params->tabId,
      'AclMgmt_Qfdu_Group',
      'displayTab',
      View::AREA
    );
    $view->domainNode = $domainNode;

    $view->setPosition( '#'.$params->tabId );
    $view->setModel( $model );

    $view->displayTab( $areaId, $params );

  }//end public function service_tabUsers */

  /**
   *
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return boolean
   */
  public function service_searchUsers( $request, $response )
  {

    // load the flow flags
    $params = $this->getListingFlags( $request );
    $domainNode  = $this->getDomainNode( $request );

    // load the default model
    /* @var $model AclMgmt_Qfdu_Model */
    $model  = $this->loadModel( 'AclMgmt_Qfdu' );
    $model->domainNode = $domainNode;
    $model->checkAccess( $domainNode, $params );
    
    $areaId = $model->getAreaId();

    // this can only be an ajax request, so we can directly load the ajax view
    $view   = $response->loadView
    (
      $domainNode->domainName.'-mgmt-acl',
      'AclMgmt_Qfdu',
      'displaySearch'
    );

    $view->domainNode = $domainNode;

    $view->setModel( $model );
    $view->displaySearch( $areaId, $params );

  }//end public function service_searchUsers */


  
////////////////////////////////////////////////////////////////////////////////
// Laden der Metadaten für das Append Menü
////////////////////////////////////////////////////////////////////////////////
  
  /**
   * the default table for the management EnterpriseEmployee
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return boolean
   */
  public function service_loadUsers( $request, $response )
  {

    // load request parameters an interpret as flags
    $params = $this->getListingFlags( $request );
    $domainNode  = $this->getDomainNode( $request );

    /* @var $model AclMgmt_Qfdu_Model */
    $model = $this->loadModel( 'AclMgmt_Qfdu' );
    $model->domainNode = $domainNode;
    $model->checkAccess( $domainNode, $params );
    
    // check user params
    $searchKey  = $request->param( 'key', Validator::TEXT );

    $view   = $response->loadView
    ( 
    	$domainNode->domainName.'-mgmt-acl',  
    	'AclMgmt_Qfdu',
      'displayAutocomplete'
    );
    $view->setModel( $model );
    $view->domainNode = $domainNode;

    $areaId     = $model->getAreaId( );

    $view->displayAutocomplete( $areaId, $searchKey, $params );

  }//end public function service_loadUsers */

  /**
   * the default table for the management EnterpriseEmployee
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return boolean
   */
  public function service_loadEntity( $request, $response )
  {

    // load request parameters an interpret as flags
    $params = $this->getListingFlags( $request );
    $domainNode  = $this->getDomainNode( $request );

    /* @var $model AclMgmt_Qfdu_Model */
    $model = $this->loadModel( 'AclMgmt_Qfdu' );
    $model->domainNode = $domainNode;
    $model->checkAccess( $domainNode, $params );

    $view   = $response->loadView
    ( 
      $domainNode->domainName.'-acl-mgmt',
    	'AclMgmt_Qfdu',
      'displayAutocompleteEntity'
    );
    $view->setModel( $model );
    $view->domainNode = $domainNode;

    $searchKey  = $request->param( 'key', Validator::TEXT );
    $areaId     = $model->getAreaId( );

    $view->displayAutocompleteEntity( $areaId, $searchKey, $params );


  }//end public function service_loadEntity */

  /**
   * the default table for the management EnterpriseEmployee
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return boolean
   */
  public function service_appendUser( $request, $response )
  {

    // load request parameters an interpret as flags
    $params = $this->getListingFlags( $request );
    $domainNode  = $this->getDomainNode( $request );

    /* @var $model AclMgmt_Qfdu_Model */
    $model  = $this->loadModel( 'AclMgmt_Qfdu' );
    $model->domainNode = $domainNode;
    $model->checkAccess( $domainNode, $params );

    $view   = $response->loadView
    ( 
      $domainNode->domainName.'-mgmt-acl',
    	'AclMgmt_Qfdu',
      'displayConnect'
    );
    $view->setModel( $model );
    $view->domainNode = $domainNode;

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

    $model->connect( $params );

    $entityAssign = $model->getEntityWbfsysGroupUsers();

    $view->displayConnect( $entityAssign->id_area, $params );

  }//end public function service_appendUser */

////////////////////////////////////////////////////////////////////////////////
// QDFU delete & clean methodes
////////////////////////////////////////////////////////////////////////////////
  
 /**
  * delete a single entity
  * @param LibRequestHttp $request
  * @param LibResponseHttp $response
  * @return boolean success flag
  */
  public function service_dropAllAssignments( $request, $response )
  {
    
    $domainNode  = $this->getDomainNode( $request );

    // did we receive an id of an object that should be deleted
    if( !$objid = $request->param( 'objid', Validator::EID ) )
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
            'resource' => 'deleteDset'
          )
        ),
        Response::BAD_REQUEST
      );
    }

    // interpret the given user parameters
    $context          = $this->getCrudFlags( $request );

    /* @var $model AclMgmt_Qfdu_Model */
    $model = $this->loadModel( 'AclMgmt_Qfdu' );
    $model->setView( $this->tpl );
    $model->domainNode = $domainNode;
    $model->checkAccess( $domainNode, $context );
    
    $areaId = $model->getAreaId();
    
    $aclManager = $this->acl->getManager();
    
    try 
    {
      
      $asgdData = $aclManager->deleteAreaAssignments( $areaId );
          
      /* @var $ui AclMgmt_Qfdu_Ui */
      $ui = $this->loadUi( 'AclMgmt_Qfdu' );
      $ui->domainNode = $domainNode;
      $ui->setView( $this->tpl );
      $ui->removeAllAssignments( $context );
    
    }
    catch( Webfrap_Exception $e )
    {
      throw new InternalError_Exception( null, $e->getMessage() );
    }
    
  }//end public function service_dropAllAssignments */

  
////////////////////////////////////////////////////////////////////////////////
// Qualified User Handling
////////////////////////////////////////////////////////////////////////////////

  /**
   * the default table for the management EnterpriseEmployee
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return boolean
   */
  public function service_listByUsers( $request, $response )
  {

    // load request parameters an interpret as flags
    $params      = $this->getTabFlags( $request );
    $domainNode  = $this->getDomainNode( $request );

    /* @var $model AclMgmt_Qfdu_Model */
    $model = $this->loadModel( 'AclMgmt_Qfdu' );
    $model->domainNode = $domainNode;
    $model->checkAccess( $domainNode, $params );

    // target for some ui element
    $areaId = $model->getAreaId();
    $params->areaId = $areaId;
    
    $params->tabId = 'tab-box-'.$domainNode->domainName.'-acl-content-users';

    // create a new area with the id of the target element, this area will replace
    // the HTML Node of the target UI Element
    /* @var $view AclMgmt_Qfdu_User_Area_View */
    $view = $response->loadView
    (
      $params->tabId,
      'AclMgmt_Qfdu_User',
      'displayTab',
      View::AREA
    );
    $view->domainNode = $domainNode;

    $view->setPosition( '#'.$params->tabId );
    $view->setModel( $model );

    $view->displayTab( $areaId, $params );

  }//end public function service_listByUsers */
  
  /**
   *
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return boolean
   */
  public function service_searchByUsers( $request, $response )
  {

    // load the flow flags
    $params = $this->getListingFlags( $request );
    $domainNode  = $this->getDomainNode( $request );

    // load the default model
    /* @var $model AclMgmt_Qfdu_Model */
    $model  = $this->loadModel( 'AclMgmt_Qfdu' );
    $model->domainNode = $domainNode;
    $model->checkAccess( $domainNode, $params );
    
    $areaId = $model->getAreaId();

    // this can only be an ajax request, so we can directly load the ajax view
    $view   = $response->loadView
    (
      $domainNode->domainName.'-mgmt-acl',
      'AclMgmt_Qfdu_User',
      'displaySearch'
    );

    $view->domainNode = $domainNode;

    $view->setModel( $model );
    $view->displaySearch( $areaId, $params );

  }//end public function service_searchListUsers */
  
  /**
   *
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return boolean
   */
  public function service_loadListUserDsets( $request, $response )
  {

    // load the flow flags
    $context      = new ContextListing( $request );
    $domainNode  = $this->getDomainNode( $request );

    // load the default model
    /* @var $model AclMgmt_Qfdu_Model */
    $model  = $this->loadModel( 'AclMgmt_Qfdu' );
    $model->domainNode = $domainNode;
    $model->checkAccess( $domainNode, $context );
    
    $context->areaId  = $model->getAreaId();
    
    $userId           = $request->param( 'objid', Validator::EID );
    $context->pRowId  = $request->param( 'p_row_id', Validator::CKEY );    
    $context->pRowPos = $request->param( 'p_row_pos', Validator::TEXT );    
    
    $respContext      = $response->createContext();
    
    $respContext->assertNotNull( 'Invalid Area', $context->areaId );
    $respContext->assertInt( 'Missing Group', $userId );
    
    if( $respContext->hasError )
      throw new InvalidRequest_Exception();
    
    // this can only be an ajax request, so we can directly load the ajax view
    /* @var $view AclMgmt_Qfdu_User_Ajax_View */
    $view   = $response->loadView
    (
      $domainNode->domainName.'-mgmt-acl',
      'AclMgmt_Qfdu_User',
      'displayLoadGridDsets'
    );

    $view->domainNode = $domainNode;

    $view->setModel( $model );
    $view->displayLoadGridDsets( $userId, $context );

  }//end public function service_loadListUserDsets */
  
  /**
   *
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return boolean
   */
  public function service_loadListUserGroups( $request, $response )
  {

    // load the flow flags
    $context      = new ContextListing( $request );
    $domainNode  = $this->getDomainNode( $request );

    // load the default model
    /* @var $model AclMgmt_Qfdu_Model */
    $model  = $this->loadModel( 'AclMgmt_Qfdu' );
    $model->domainNode = $domainNode;
    $model->checkAccess( $domainNode, $context );
    
    $context->areaId = $model->getAreaId();
    
    $dsetId         = $request->param( 'objid', Validator::EID );
    $userId         = $request->param( 'user', Validator::EID );
    $context->pRowId = $request->param( 'p_row_id', Validator::CKEY );    
    $context->pRowPos = $request->param( 'p_row_pos', Validator::TEXT );    
    
    $respContext = $response->createContext();
    
    $respContext->assertNotNull( 'Invalid Area', $context->areaId );
    $respContext->assertInt( 'Missing User', $userId );
    $respContext->assertInt( 'Missing Dataset', $dsetId );
    
    if( $respContext->hasError )
      throw new InvalidRequest_Exception();
    
    // this can only be an ajax request, so we can directly load the ajax view
    /* @var $view AclMgmt_Qfdu_User_Ajax_View */
    $view   = $response->loadView
    (
      $domainNode->domainName.'-mgmt-acl',
      'AclMgmt_Qfdu_User',
      'displayLoadGridGroups'
    );

    $view->domainNode = $domainNode;

    $view->setModel( $model );
    $view->displayLoadGridGroups( $userId, $dsetId, $context );

  }//end public function service_loadListUserGroups */
  
////////////////////////////////////////////////////////////////////////////////
// List by dsets
////////////////////////////////////////////////////////////////////////////////

  /**
   * the default table for the management EnterpriseEmployee
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return boolean
   */
  public function service_listByDsets( $request, $response )
  {

    // load request parameters an interpret as flags
    $params      = $this->getTabFlags( $request );
    $domainNode  = $this->getDomainNode( $request );

    /* @var $model AclMgmt_Qfdu_Model */
    $model = $this->loadModel( 'AclMgmt_Qfdu' );
    $model->domainNode = $domainNode;
    $model->checkAccess( $domainNode, $params );

    // target for some ui element
    $areaId = $model->getAreaId();
    $params->areaId = $areaId;
    
    $params->tabId = 'tab-box-'.$domainNode->domainName.'-acl-content-dsets';

    // create a new area with the id of the target element, this area will replace
    // the HTML Node of the target UI Element
    /* @var $view AclMgmt_Qfdu_User_Area_View */
    $view = $response->loadView
    (
      $params->tabId,
      'AclMgmt_Qfdu_Dset',
      'displayTab',
      View::AREA
    );
    $view->domainNode = $domainNode;

    $view->setPosition( '#'.$params->tabId );
    $view->setModel( $model );
    $view->displayTab( $areaId, $params );

  }//end public function service_listByDsets */
  
  /**
   *
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return boolean
   */
  public function service_loadListDsetUsers( $request, $response )
  {

    // load the flow flags
    $context      = new ContextListing( $request );
    $domainNode  = $this->getDomainNode( $request );

    // load the default model
    /* @var $model AclMgmt_Qfdu_Model */
    $model  = $this->loadModel( 'AclMgmt_Qfdu' );
    $model->domainNode = $domainNode;
    $model->checkAccess( $domainNode, $context );
    
    $context->areaId  = $model->getAreaId();
    
    $dsetId           = $request->param( 'objid', Validator::EID );
    $context->pRowId  = $request->param( 'p_row_id', Validator::CKEY );    
    $context->pRowPos = $request->param( 'p_row_pos', Validator::TEXT );    
    
    $respContext      = $response->createContext();
    
    $respContext->assertNotNull( 'Invalid Area', $context->areaId );
    $respContext->assertInt( 'Missing Dset id', $dsetId );
    
    if( $respContext->hasError )
      throw new InvalidRequest_Exception();
    
    // this can only be an ajax request, so we can directly load the ajax view
    /* @var $view AclMgmt_Qfdu_Dset_Ajax_View */
    $view   = $response->loadView
    (
      $domainNode->domainName.'-mgmt-acl',
      'AclMgmt_Qfdu_Dset',
      'displayLoadGridUsers'
    );

    $view->domainNode = $domainNode;

    $view->setModel( $model );
    $view->displayLoadGridUsers( $dsetId, $context );

  }//end public function service_loadListDsetUsers */
  
  /**
   *
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return boolean
   */
  public function service_loadListDsetGroups( $request, $response )
  {

    // load the flow flags
    $context      = new ContextListing( $request );
    $domainNode  = $this->getDomainNode( $request );

    // load the default model
    /* @var $model AclMgmt_Qfdu_Model */
    $model  = $this->loadModel( 'AclMgmt_Qfdu' );
    $model->domainNode = $domainNode;
    $model->checkAccess( $domainNode, $context );
    
    $context->areaId = $model->getAreaId();
    
    $userId           = $request->param( 'objid', Validator::EID );
    $dsetId           = $request->param( 'dset', Validator::EID );
    $context->pRowId  = $request->param( 'p_row_id', Validator::CKEY );    
    $context->pRowPos = $request->param( 'p_row_pos', Validator::TEXT );    
    
    $respContext = $response->createContext();
    
    $respContext->assertNotNull( 'Invalid Area', $context->areaId );
    $respContext->assertInt( 'Missing User', $userId );
    $respContext->assertInt( 'Missing Dataset', $dsetId );
    
    if( $respContext->hasError )
      throw new InvalidRequest_Exception();
    
    // this can only be an ajax request, so we can directly load the ajax view
    /* @var $view AclMgmt_Qfdu_Dset_Ajax_View */
    $view   = $response->loadView
    (
      $domainNode->domainName.'-mgmt-acl',
      'AclMgmt_Qfdu_Dset',
      'displayLoadGridGroups'
    );

    $view->domainNode = $domainNode;

    $view->setModel( $model );
    $view->displayLoadGridGroups( $userId, $dsetId, $context );

  }//end public function service_loadListDsetsGroups */

////////////////////////////////////////////////////////////////////////////////
// parse flags
////////////////////////////////////////////////////////////////////////////////

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

    return new ContextDomainCrud( $request );

  }//end protected function getCrudFlags */

  /**
   * @param TFlag $params
   * @return TFlag
   */
  protected function getTabFlags( $request )
  {

    $response  = $this->getResponse();

    $params    = new TFlagListing( $request );
      

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
      = $request->param( 'start', Validator::INT );

    // stepsite for query (limit) and the table
    if( !$params->qsize = $request->param( 'qsize', Validator::INT ) )
      $params->qsize = Wgt::$defListSize;

    // order for the multi display element
    $params->order
      = $request->param( 'order', Validator::CNAME );

    // target for a callback function
    $params->target
      = $request->param( 'target', Validator::CKEY  );

    // target for some ui element
    $params->targetId
      = $request->param( 'target_id', Validator::CKEY  );

    // target for some ui element
    $params->tabId
      = $request->param( 'tabid', Validator::CKEY  );

    // flag for beginning seach filter
    if( $text = $request->param( 'begin', Validator::TEXT  ) )
    {
      // whatever is comming... take the first char
      $params->begin = $text[0];
    }

    // exclude whatever
    $params->exclude
      = $request->param( 'exclude', Validator::CKEY  );

    // the activ id, mostly needed in exlude calls
    $params->objid
      = $request->param( 'objid', Validator::EID  );

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

