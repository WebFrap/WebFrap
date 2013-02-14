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
class AclMgmt_Controller extends MvcController_Domain
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
    'listing' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'maintab' )
    ),
    'search' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'ajax' )
    ),
    'loadgroups' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'ajax' )
    ),
    'appendgroup' => array
    (
      'method'    => array( 'PUT', 'POST' ),
      'views'      => array( 'ajax' )
    ),
    'deletegroup' => array
    (
      'method'    => array( 'DELETE' ),
      'views'      => array( 'ajax' )
    ),
    'updatearea' => array
    (
      'method'    => array( 'PUT', 'POST' ),
      'views'      => array( 'ajax' )
    ),
    'pushtoentity' => array
    (
      'method'    => array( 'PUT', 'POST' ),
      'views'      => array( 'ajax' )
    ),
    'pullfromentity' => array
    (
      'method'    => array( 'PUT', 'POST' ),
      'views'      => array( 'ajax' )
    ),
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

/*//////////////////////////////////////////////////////////////////////////////
// Listing Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return boolean
   */
  public function service_listing( $request, $response )
  {

    // load request parameters an interpret as flags
    $params      = $this->getListingFlags( $request );
    $domainNode  = $this->getDomainNode( $request );


    /* @var $model AclMgmt_Model  */
    $model = $this->loadModel( 'AclMgmt' );
    $model->domainNode = $domainNode;
    $model->checkAccess( $domainNode, $params );

    /* @var $view AclMgmt_Maintab_View */
    $view = $response->loadView
    (
      $domainNode->domainName.'_acl_listing',
      'AclMgmt',
      'displayListing'
    );
    $view->domainNode = $domainNode;

    $view->setModel( $model  );
    $view->displayListing( $params );

  }//end public function service_listing */

  /**
   * the search method for the main table
   * this method is called for paging and search requests
   * it's not recommended to use another method than this for paging, cause
   * this method makes shure that you can page between the search results
   * and do not loose your filters in paging
   *
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return boolean
   */
  public function service_search( $request, $response )
  {

    // load request parameters an interpret as flags
    $params  = $this->getListingFlags( $request );
    $domainNode  = $this->getDomainNode( $request );


    // load the default model
    /* @var $model AclMgmt_Model */
    $model   = $this->loadModel( 'AclMgmt' );
    $model->domainNode = $domainNode;
    $model->checkAccess( $domainNode, $params );

    $areaId  = $model->getAreaId();

    // this can only be an ajax request, so we can directly load the ajax view
    $view    = $response->loadView
    (
      $domainNode->domainName.'acl-mgmt',
    	'AclMgmt',
      'displaySearch'
    );
    $view->domainNode = $domainNode;

    $view->setModel( $model );

    $view->displaySearch( $areaId, $params );


  }//end public function service_search */

  /**
   * Service zum auflisten aller existierenden Masken
   *
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return boolean
   */
  public function service_listAllMasks( $request, $response )
  {

    // load request parameters an interpret as flags
    $params  = $this->getListingFlags( $request );
    $domainNode  = $this->getDomainNode( $request );


    /* @var $model AclMgmt_Model */
    $model   = $this->loadModel( 'AclMgmt' );
    $model->domainNode = $domainNode;
    $model->checkAccess( $domainNode, $params );

    /* @var $view AclMgmt_Masks_Modal_View */
    $view = $response->loadView
    (
      $domainNode->domainName.'_acl_masks_listing',
      'AclMgmt_Masks',
      'displayListing',
      View::MODAL
    );
    $view->domainNode = $domainNode;

    $view->setModel( $model );
    $view->displayListing( $params );


  }//end public function service_listAllMasks */

/*//////////////////////////////////////////////////////////////////////////////
// Crud Interface
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return boolean
   */
  public function service_loadGroups( $request, $response )
  {

    // load request parameters an interpret as flags
    $params  = $this->getListingFlags( $request );
    $domainNode  = $this->getDomainNode( $request );


    /* @var $model AclMgmt_Model */
    $model =  $this->loadModel( 'AclMgmt' );
    $model->domainNode = $domainNode;
    $model->checkAccess( $domainNode, $params );

    // fetch the user parameters
    $searchKey = $request->param( 'key', Validator::TEXT );

    /* @var $view AclMgmt_Ajax_View */
    $view   = $response->loadView
    (
      $domainNode->domainName.'-acl-mgmt',
    	'AclMgmt',
      'displayAutocomplete'
    );
    $view->domainNode = $domainNode;

    $view->setModel( $model );
    $areaId = $model->getAreaId();

    $view->displayAutocomplete( $areaId, $searchKey, $params );

  }//end public function service_loadGroups */

  /**
   *
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return boolean
   */
  public function service_deleteGroup( $request, $response )
  {

    // load request parameters an interpret as flags
    $params  = $this->getListingFlags( $request );
    $domainNode  = $this->getDomainNode( $request );


    /* @var $model AclMgmt_Model */
    $model =  $this->loadModel( 'AclMgmt' );
    $model->domainNode = $domainNode;
    $model->checkAccess( $domainNode, $params );

    // fetch the user parameters
    $objid = $request->param( 'objid', Validator::EID );

    $model->deleteGroup( $objid );

    /* @var $view AclMgmt_Ajax_View */
    $view   = $response->loadView
    (
      $domainNode->domainName.'-acl-mgmt',
    	'AclMgmt',
      'displayDeleteGroup'
    );
    $view->domainNode = $domainNode;

    $view->setModel( $model );
    $view->displayDeleteGroup( $objid );

  }//end public function service_loadGroups */

  /**
   *
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return boolean
   */
  public function service_appendGroup( $request, $response )
  {

    // load request parameters an interpret as flags
    $params  = $this->getListingFlags( $request );
    $domainNode  = $this->getDomainNode( $request );

    /* @var $model AclMgmt_Model */
    $model = $this->loadModel( 'AclMgmt' );
    $model->domainNode = $domainNode;
    $model->checkAccess( $domainNode, $params );

    $view   = $response->loadView
    (
      $domainNode->domainName.'-acl-mgmt',
    	'AclMgmt',
      'displayConnect'
    );


    $view->setModel( $model );
    $view->domainNode = $domainNode;

    // fetch the data from the http request and load it in the model registry
    // if fails stop here
    if (!$model->fetchConnectData( $params ) )
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

    if (!$model->checkUnique() )
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
    $view->displayConnect( $params );

  }//end public function service_appendGroup */

 /**
  * update a single entity and all rerferencing datasets
  * @param LibRequestHttp $request
  * @param LibResponseHttp $response
  * @return boolean
  */
  public function service_updateArea( $request, $response )
  {

    $domainNode  = $this->getDomainNode( $request );

    // interpret the parameters from the request
    $params = $this->getCrudFlags( $request );

    // check if there is a valid id for update
    if (!$id = $this->getOID( 'security_area' ) )
    {
      // wenn nicht ist die anfrage per definition invalide
      throw new InvalidRequest_Exception
      (
        $response->i18n->l
        (
          'The Request for {@service@} was invalid. ID was missing!',
          'wbf.message',
          array
          (
            'service' => 'updateArea'
          )
        ),
        Response::BAD_REQUEST
      );
    }

    /* @var $model AclMgmt_Model */
    $model = $this->loadModel( 'AclMgmt' );
    $model->domainNode = $domainNode;
    $model->checkAccess( $domainNode, $params );

    $model->setView( $this->tpl );

    // fetch the data from the http request and load it in the model registry
    // if fails stop here
    $model->fetchUpdateData( $id, $params );

    // when we are here the data must be valid ( if not your meta model is broken! )
    // try to update
    $model->update( $params );

    if( $subRequestAccess = $request->getSubRequest( 'ar' ) )
    {
      /* @var $modelMultiAccess AclMgmt_Multi_Model */
      $modelMultiAccess = $this->loadModel( 'AclMgmt_Multi' );
      $modelMultiAccess->setRequest( $subRequestAccess );
      $modelMultiAccess->setView( $this->tpl );
      $modelMultiAccess->fetchUpdateData( $params );
      $modelMultiAccess->update( $params  );
    }

    if( $subRequestQfdu = $request->getSubRequest( 'qfdu' ) )
    {
      /* @var $modelMultiQfdu AclMgmt_Qfdu_Multi_Model */
      $modelMultiQfdu = $this->loadModel( 'AclMgmt_Qfdu_Multi' );
      $modelMultiQfdu->setRequest( $subRequestQfdu );
      $modelMultiQfdu->setView( $this->tpl );
      $modelMultiQfdu->fetchUpdateData( $params );
      $modelMultiQfdu->update( $params  );
    }

    // if this point is reached everything is fine
    return true;

  }//end public function service_updateArea */

 /**
  * Die Konfiguration der Management Rechte über die Rechte
  * der Entity schreiben.
  *
  * Wird genutzt wenn die Rechte nur auf einer Maske gepflegt wurden
  * jetzt jedoch auf Entitylevel übertragen werden sollen
  *
  * @param LibRequestHttp $request
  * @param LibResponseHttp $response
  * @return boolean
  */
  public function service_pushToEntity( $request, $response )
  {

    // interpret the parameters from the request
    $params = $this->getFlags( $request );
    $domainNode  = $this->getDomainNode( $request );

    /* @var $model AclMgmt_Model */
    $model = $this->loadModel( 'AclMgmt' );
    $model->domainNode = $domainNode;
    $model->checkAccess( $domainNode, $params );

    // Die Rechte Konfiguration der Management Maske auf die Entity
    // übertragen
    $model->pushMgmtConfigurationToEntity( $params );

  }//end public function service_pushToEntity */

 /**
  * Die Rechteconfiguration aus dem Entitylevel auslesen und in die
  * Mgmt Maske übertragen
  *
  * Die Rechte Konfiguration der Entity auf die Maske übertragen
  * Kann genutzt werden wenn Rechte für eine Maske übertragen
  * werden sollen, es jedoch kleine Abweichungen zu den Rechten
  * auf Entity Level gibt
  *
  * @param LibRequestHttp $request
  * @param LibResponseHttp $response
  * @return boolean
  */
  public function service_pullFromEntity( $request, $response )
  {

    // interpret the parameters from the request
    $params = $this->getFlags( $request );
    $domainNode  = $this->getDomainNode( $request );

    /* @var $model AclMgmt_Model */
    $model = $this->loadModel( 'AclMgmt' );
    $model->domainNode = $domainNode;
    $model->checkAccess( $domainNode, $params );

    // if this point is reached everything is fine
    $model->pullMgmtConfigurationFromEntity( $params );

  }//end public function service_pullFromEntity */

/*//////////////////////////////////////////////////////////////////////////////
// Parse Flags
//////////////////////////////////////////////////////////////////////////////*/


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
      if (!$params->qsize = $request->param('qsize', Validator::INT ) )
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
    if (!$params->qsize = $request->param('qsize', Validator::INT ) )
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

} // end class AclMgmt_Controller */

