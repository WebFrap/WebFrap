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
class AclMgmt_Qfdu_Dset_Controller
  extends AclMgmt_Controller
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

    'search' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'ajax' )
    ),
    'loadusers' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'ajax' )
    ),
    'loaddsets' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'ajax' )
    ),
    'append' => array
    (
      'method'    => array( 'PUT', 'POST' ),
      'views'      => array( 'ajax' )
    ),
    'export' => array
    (
      'method'    => array( 'GET' ),
      //'views'      => array( 'document' )
    ),
  
    // dropping of assignments
    'dropgroupassignments' => array
    (
      'method'    => array( 'DELETE' ),
      'views'      => array( 'ajax' )
    ),
    'dropuserassignments' => array
    (
      'method'    => array( 'DELETE' ),
      'views'      => array( 'ajax' )
    ),
    'dropdsetassignments' => array
    (
      'method'    => array( 'DELETE' ),
      'views'      => array( 'ajax' )
    ),

  );

/*//////////////////////////////////////////////////////////////////////////////
// Search & Load
//////////////////////////////////////////////////////////////////////////////*/

  
  /**
   *
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return boolean
   */
  public function service_search( $request, $response )
  {

    // load the flow flags
    $context = $this->getListingFlags( $request );
    $domainNode  = $this->getDomainNode( $request );

    // load the default model
    /* @var $model AclMgmt_Qfdu_Model */
    $model  = $this->loadModel( 'AclMgmt_Qfdu' );
    $model->domainNode = $domainNode;
    $model->checkAccess( $domainNode, $context );
    
    $areaId = $model->getAreaId();
    $context->areaId = $areaId;
    
    // this can only be an ajax request, so we can directly load the ajax view
    $view   = $response->loadView
    (
      $domainNode->domainName.'-mgmt-acl',
      'AclMgmt_Qfdu_Dset',
      'displaySearch'
    );

    $view->domainNode = $domainNode;

    $view->setModel( $model );
    $view->displaySearch( $context );

  }//end public function service_search */
  
  /**
   * the default table for the management EnterpriseEmployee
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return boolean
   */
  public function service_append( $request, $response )
  {

    // load request parameters an interpret as flags
    $params = $this->getListingFlags( $request );
    $domainNode  = $this->getDomainNode( $request );

    /* @var $model AclMgmt_Qfdu_Model */
    $model  = $this->loadModel( 'AclMgmt_Qfdu' );
    $model->domainNode = $domainNode;
    $model->checkAccess( $domainNode, $params );

    
    $areaId = $model->getAreaId();
    $params->areaId = $areaId;
    
    $view   = $response->loadView
    ( 
      $domainNode->domainName.'-mgmt-acl',
    	'AclMgmt_Qfdu_Dset',
      'displayConnect'
    );
    $view->setModel( $model );
    $view->domainNode = $domainNode;

    // fetch the data from the http request and load it in the model registry
    // if fails stop here
    $model->fetchConnectData( $params ) ;

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

    $view->displayConnect( $entityAssign, $params );

  }//end public function service_append */
  
  /**
   *
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return boolean
   */
  public function service_loadUsers( $request, $response )
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
    
    $groupId         = $request->param( 'objid', Validator::EID );
    $context->pRowId = $request->param( 'p_row_id', Validator::CKEY );    
    $context->pRowPos = $request->param( 'p_row_pos', Validator::TEXT );    
    
    $respContext = $response->createContext();
    
    $respContext->assertNotNull( 'Invalid Area', $context->areaId );
    $respContext->assertInt( 'Missing Group', $groupId );
    
    if( $respContext->hasError )
      throw new InvalidRequest_Exception();
    
    // this can only be an ajax request, so we can directly load the ajax view
    /* @var $view AclMgmt_Qfdu_Ajax_View */
    $view   = $response->loadView
    (
      $domainNode->domainName.'-mgmt-acl',
      'AclMgmt_Qfdu',
      'displayLoadGridUsers'
    );

    $view->domainNode = $domainNode;

    $view->setModel( $model );
    $view->displayLoadGridUsers( $groupId, $context );

  }//end public function service_loadUsers */
  
  /**
   *
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return boolean
   */
  public function service_loadDsets( $request, $response )
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
    
    $userId          = $request->param( 'objid', Validator::EID );
    $groupId         = $request->param( 'group', Validator::EID );
    $context->pRowId = $request->param( 'p_row_id', Validator::CKEY );    
    $context->pRowPos = $request->param( 'p_row_pos', Validator::TEXT );    
    
    $respContext = $response->createContext();
    
    $respContext->assertNotNull( 'Invalid Area', $context->areaId );
    $respContext->assertInt( 'Missing Group', $groupId );
    $respContext->assertInt( 'Missing User', $userId );
    
    if( $respContext->hasError )
      throw new InvalidRequest_Exception();
    
    // this can only be an ajax request, so we can directly load the ajax view
    /* @var $view AclMgmt_Qfdu_Ajax_View */
    $view   = $response->loadView
    (
      $domainNode->domainName.'-mgmt-acl',
      'AclMgmt_Qfdu',
      'displayLoadGridDsets'
    );

    $view->domainNode = $domainNode;

    $view->setModel( $model );
    $view->displayLoadGridDsets( $groupId, $userId, $context );

  }//end public function service_loadDsets */
  
  /**
   *
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return boolean
   */
  public function service_export( $request, $response )
  {

    // load the flow flags
    $context = $this->getListingFlags( $request );
    $domainNode  = $this->getDomainNode( $request );

    // load the default model
    /* @var $model AclMgmt_Qfdu_Model */
    $model  = $this->loadModel( 'AclMgmt_Qfdu' );
    $model->domainNode = $domainNode;
    $model->checkAccess( $domainNode, $context );
    
    $user   = $this->getUser();
    $areaId = $model->getAreaId();

    $document = new AclMgmt_Qfdu_Dset_Export_Document( $this, 'Acl by '.$domainNode->pLabel );
    $document->fileName = 'Acl by '.$domainNode->pLabel.'.xlsx';
    $document->booktitle = 'Acl by '.$domainNode->pLabel;
    $document->title = 'Acl by '.$domainNode->pLabel;
    $document->subject = 'Acl by '.$domainNode->pLabel;
    $document->creator = $user->getFullName();
    $document->initDocument();
    
    $dataSheet = $document->getSheet( );
    $dataSheet->data = $model->loadExportByDset( $areaId, $context );

    $document->executeRenderer();
    $document->close();


  }//end public function service_search */
  
/*//////////////////////////////////////////////////////////////////////////////
// Dropping
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * delete a single entity
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return boolean success flag
   */
  public function service_dropGroupAssignments( $request, $response )
  {
    
    $domainNode  = $this->getDomainNode( $request );
 

    // interpret the given user parameters
    $params = $this->getCrudFlags( $request );


    /* @var $model AclMgmt_Qfdu_Model */
    $model = $this->loadModel( 'AclMgmt_Qfdu' );
    $model->setView( $this->tpl );
    $model->domainNode = $domainNode;
    $model->checkAccess( $domainNode, $params );

    $areaId = $model->getAreaId();

    // try to delete the dataset
    if( $model->cleanQfduGroup( $objid, $areaId, $params ) )
    {
      // if we got a target id we remove the element from the client
      if( $params->targetId )
      {
        $ui = $this->loadUi( 'AclMgmt_Qfdu' );

        $ui->setModel($model);
        $ui->setView($this->tpl);
        $ui->removeGroupEntry( $objid, $params->targetId );
      }
    }

  }//end public function service_dropGroupAssignments */

 /**
  * delete a single entity
  * @param LibRequestHttp $request
  * @param LibResponseHttp $response
  * @return boolean success flag
  */
  public function service_dropUserAssignments( $request, $response )
  {
    
    $domainNode  = $this->getDomainNode( $request );

    $rqCont = $response->createContext();
    $request->setResponse( $rqCont );
    
    $groupId = $request->param( 'group_id', Validator::EID );
    $userId  = $request->param( 'user_id',  Validator::EID );
    $request->resetResponse();

    // did we receive an id of an object that should be deleted
    if( $rqCont->hasError  )
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


    /* @var $model AclMgmt_Qfdu_Model */
    $model = $this->loadModel( 'AclMgmt_Qfdu' );
    $model->setView( $this->tpl );
    $model->domainNode = $domainNode;
    $model->checkAccess( $domainNode, $params );
    
    $areaId = $model->getAreaId();
    
    $aclManager = $this->acl->getManager();
      
    try 
    {
      // try to delete the dataset
      $aclManager->deleteUserRoleAssignments( $userId, $groupId, $areaId );
      
      // if we got a target id we remove the element from the client
      if( $params->targetId )
      {
        /* @var $ui AclMgmt_Qfdu_Group_Ui */
        $ui = $this->loadUi( 'AclMgmt_Qfdu_Group' );
  
        $ui->setModel( $model );
        $ui->setView( $this->tpl );
        $ui->removeUserEntry( new TDataObject(array(
          'groupId' => $groupId, 
          'userId' => $userId, 
          'areaId' => $areaId 
        )), $params->targetId );
      }
    }
    catch( Webfrap_Exception $e )
    {
      throw new InternalError_Exception(null,$e->getMessage());
    }

  }//end public function service_dropUserAssignments */

 /**
  * delete a single entity
  * @param LibRequestHttp $request
  * @param LibResponseHttp $response
  * @return boolean success flag
  */
  public function service_dropDsetAssignments( $request, $response )
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
    $params          = $this->getCrudFlags( $request );

    /* @var $model AclMgmt_Qfdu_Model */
    $model = $this->loadModel( 'AclMgmt_Qfdu' );
    $model->setView( $this->tpl );
    $model->domainNode = $domainNode;
    $model->checkAccess( $domainNode, $params );
    
    $aclManager = $this->acl->getManager();
    
    try 
    {
      
      $asgdData = $aclManager->deleteAssgignmentById( $objid );
      
      /* @var $ui AclMgmt_Qfdu_Group_Ui */
      $ui = $this->loadUi( 'AclMgmt_Qfdu_Group' );

      $ui->setModel( $model );
      $ui->setView( $this->tpl );
      $ui->removeDatasetEntry( $asgdData );
    
    }
    catch( Webfrap_Exception $e )
    {
      throw new InternalError_Exception( null, $e->getMessage() );
    }
    
  }//end public function service_dropDsetAssignments */
 


} // end class AclMgmt_Qfdu_Controller */

