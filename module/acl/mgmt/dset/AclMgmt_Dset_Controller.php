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
 * @subpackage Core
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright webfrap.net <contact@webfrap.net>
 */
class AclMgmt_Dset_Controller
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
  protected $options = array
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
    'appenduser' => array
    (
      'method'    => array( 'POST', 'PUT' ),
      'views'      => array( 'ajax' )
    ),
    'cleangroup' => array
    (
      'method'    => array( 'DELETE' ),
      'views'      => array( 'ajax' )
    ),
    'cleangroup' => array
    (
      'method'    => array( 'DELETE' ),
      'views'      => array( 'ajax' )
    ),
    'deleteuser' => array
    (
      'method'    => array( 'DELETE' ),
      'views'      => array( 'ajax' )
    ),
    'autocompleteusers' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'ajax' )
    ),
    
  );
    
////////////////////////////////////////////////////////////////////////////////
// Listing Methodes
////////////////////////////////////////////////////////////////////////////////
   
  /**
   * display the graph to visualize the references on the management
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return boolean
   */
  public function service_listing( $request, $response )
  {
    
    $domainNode  = $this->getDomainNode( $request );

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
            'service' => $response->i18n->l
            (
              $domainNode->domainName,
              $domainNode->domainI18n.'.label'
            )
          )
        ),
        Response::BAD_REQUEST
      );
    }


    // erst mal brauchen wir das passende model
    /* @var $model AclMgmt_Dset_Model  */
    $model = $this->loadModel( 'AclMgmt_Dset' );

    // dann das passende entitiy objekt für den datensatz
    $domainEntity = $model->getEntity( $objid );


    // wenn null zurückgegeben wurde existiert der datensatz nicht
    // daher muss das System eine 404 Meldung zurückgeben
    if( !$domainEntity )
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
            'resource'  => $response->i18n->l
            ( 
              $domainNode->domainName,
              $domainNode->domainI18n.'.label'
            ),
            'id'        => $objid
          )
        ),
        Response::NOT_FOUND
      );
    }


    // load request parameters an interpret as flags
    $params  = $this->getListingFlags( $request );


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
            'resource'  => $response->i18n->l
            ( 
              $domainNode->domainName,
              $domainNode->domainI18n.'.label'
            )
          )
        ),
        Response::FORBIDDEN
      );
    }

    // der Access Container des Users für die Resource wird als flag übergeben
    $params->access = $access;

    $view = $this->loadView
    (
      'enterprise_employee-acl-dset-listing-'.$objid,
      'AclMgmt_Dset',
      'displayListing',
      null,
      true
    );

    /* @var $model AclMgmt_Dset_Model  */
    $model = $this->loadModel( 'AclMgmt_Dset' );
    $model->domainNode = $domainNode;
    $view->setModel( $model );
    $view->domainNode = $domainNode;

    $areaId  = $model->getAreaId();
    $view->displayListing( $domainEntity, $areaId, $params );

  }//end public function service_listing */
       
  /**
   *
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return boolean
   */
  public function service_search( $request, $response )
  {
    
    $domainNode  = $this->getDomainNode( $request );

    if( !$objid = $request->param( 'objid', Validator::INT )  )
    {
      throw new InvalidRequest_Exception
      (
        $response->i18n->l( 'Missing the ID', 'wbf.message' ),
        Response::BAD_REQUEST
      );
    }

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
            'resource'  => $response->i18n->l
            ( 
              $domainNode->domainName,
              $domainNode->domainI18n.'.label'
            )
          )
        ),
        Response::FORBIDDEN
      );
    }

    // der Access Container des Users für die Resource wird als flag übergeben
    $params->access = $access;


    // load the default model
    /* @var $model AclMgmt_Dset_Model  */
    $model  = $this->loadModel( 'AclMgmt_Dset' );
    $model->domainNode = $domainNode;
    $areaId = $model->getAreaId();

    // this can only be an ajax request, so we can directly load the ajax view
    $view   = $this->tpl->loadView( 'AclMgmt_Dset_Ajax' );

    $view->setModel( $model );
    $view->domainNode = $domainNode;
    $view->displaySearch( $objid, $areaId, $params );

  }//end public function service_search */
    
////////////////////////////////////////////////////////////////////////////////
// Crud Methodes
////////////////////////////////////////////////////////////////////////////////
    
  /**
   * the default table for the management EnterpriseEmployee
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return boolean
   */
  public function service_appendUser( $request, $response )
  {

    $domainNode  = $this->getDomainNode( $request );
    
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


    // force ajax view
    $view   = $this->tpl->loadView( 'AclMgmt_Dset_Ajax' );
    $view->domainNode = $domainNode;

    /* @var $model AclMgmt_Dset_Model  */
    $model = $this->loadModel( 'AclMgmt_Dset' );
    $model->domainNode = $domainNode;
    $view->setModel( $model );

    // fetch the data from the http request and load it in the model registry
    // if fails stop here
    if( !$model->fetchConnectData( $params ) )
    {
      return false;
    }

    // check that this reference not yet exists
    if( !$model->checkUnique() )
    {
      $response->addError
      ( 
        $view->i18n->l
        (
          'This Assignment allready exists',
          'wbf.message'
        )
      );
      return false;
    }

    $error = $model->connect( $params );

    if( $error )
    {
      return $error;
    }

    $entityAssign = $model->getEntityWbfsysGroupUsers();

    $error = $view->displayConnect( $params );


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

  }//end public function service_appendUser */

 /**
  * Relative Zuweisung von Usern zu einer Gruppe löschen
  * 
  * @param LibRequestHttp $request
  * @param LibResponseHttp $response
  *
  * @return boolean success flag
  */
  public function service_cleanGroup( $request, $response )
  {
    
    $domainNode  = $this->getDomainNode( $request );

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


    /* @var $model AclMgmt_Dset_Model  */
    $model = $this->loadModel( 'AclMgmt_Dset' );
    $model->domainNode = $domainNode;
    $model->setView( $this->tpl );

    $areaId = $model->getAreaId( );

    // try to delete the dataset
    if( $model->cleanQfduGroup( $objid, $areaId, $params ) )
    {
      // if we got a target id we remove the element from the client
      if( $params->targetId )
      {
        $ui = $this->loadUi( 'AclMgmt_Dset' );

        $ui->setModel( $model );
        $ui->setView( $this->tpl );
        $ui->removeGroupEntry( $objid, $params->targetId );
      }
    }

    return true;

  }//end public function service_cleanGroup */

 /**
  * Relative Benutzer / Gruppenzuweisung löschen
  *
  * @param LibRequestHttp $request
  * @param LibResponseHttp $response
  * @return boolean success flag
  */
  public function service_deleteUser( $request, $response )
  {

    $domainNode  = $this->getDomainNode( $request );
    
    $objid    = $this->request->param( 'objid', Validator::EID );

    // only used to remove the dataentry
    $userId   = $this->request->param( 'user_id' , Validator::EID );
    $groupId  = $this->request->param( 'group_id', Validator::EID );

    // did we receive an id of an object that should be deleted
    if( !$objid )
    {
      throw new InvalidRequest_Exception
      (
        'Missing the ID',
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


    /* @var $model AclMgmt_Dset_Model  */
    $model    = $this->loadModel( 'AclMgmt_Dset' );
    $model->domainNode = $domainNode;
    $model->setView( $this->tpl );

    $areaId   = $model->getAreaId();

    // try to delete the dataset
    $error    = $model->deleteUser( $objid, $params );
    if( !$error )
    {
      // if we got a target id we remove the element from the client
      if( $params->targetId )
      {
        $ui = $this->loadUi( 'AclMgmt_Dset' );

        $ui->setModel( $model );
        $ui->setView( $this->tpl );
        $ui->removeUserEntry( $groupId, $userId, $params->targetId );
      }
    }


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


  }//end public function service_deleteUser */

////////////////////////////////////////////////////////////////////////////////
// loader for autocomplete
////////////////////////////////////////////////////////////////////////////////

  /**
   * Autocomplete methode für Systembenutzer 
   *
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return boolean
   */
  public function service_autocompleteUsers( $request, $response )
  {

    $domainNode  = $this->getDomainNode( $request );
    
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



    $view   = $this->tpl->loadView( 'AclMgmt_Dset_Ajax' );
    $view->domainNode = $domainNode;
    /* @var $model AclMgmt_Dset_Model  */
    $model  = $this->loadModel( 'AclMgmt_Dset' );
    $model->domainNode = $domainNode;

    $view->setModel( $model );

    $searchKey  = $this->request->param( 'key', Validator::TEXT );
    $areaId     = $model->getAreaId();

    $error = $view->displayAutocompleteUsers( $areaId, $searchKey, $params );


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


  }//end public function service_autocompleteUsers */
  
////////////////////////////////////////////////////////////////////////////////
// protected getter
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

} // end class AclMgmt_Dset_Controller */

