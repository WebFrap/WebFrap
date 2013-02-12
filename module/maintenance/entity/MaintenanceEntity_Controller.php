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
class MaintenanceEntity_Controller
  extends Controller
{
////////////////////////////////////////////////////////////////////////////////
// methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @var array
   */
  protected $options           = array
  (
    'showmeta' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'modal' )
    ),
    'statsentity' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'modal' )
    ),
    'statsdataset' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'modal' )
    ),
    'protocolentity' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'modal' )
    ),
    'protocoldataset' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'modal' )
    ),
  );

////////////////////////////////////////////////////////////////////////////////
// methodes
////////////////////////////////////////////////////////////////////////////////

 /**
  * create an new window with an edit form for the enterprise_company entity
  * @param LibRequestHttp $request
  * @param LibResponseHttp $response
  * @return boolean
  */
  public function service_showMeta( $request, $response )
  {

    // prüfen ob irgendwelche steuerflags übergeben wurde
    $params  = $this->getFormFlags( $request );

    $domainKey   = $request->param( 'dkey', Validator::CKEY );
    if (!$domainKey) {
      throw new InvalidRequest_Exception
      (
        'Missing Domain Parameter',
        Response::BAD_REQUEST
      );
    }

    $domainNode  = DomainNode::getNode( $domainKey );

    if (!$domainNode) {
      throw new InvalidRequest_Exception
      (
        'The requestes Metadate not exists',
        Response::NOT_FOUND
      );
    }


    // check the acl permissions
    if ( !$this->acl->access( $domainNode->domainAcl.':access'  ) ) {
      throw new InvalidRequest_Exception
      (
        'You have no permission to access this service',
        Response::FORBIDDEN
      );
    }

    // check if we got a valid objid
    if ( !$objid = $this->getOID() ) {
      throw new InvalidRequest_Exception
      (
        'Missing the ID',
        Response::BAD_REQUEST
      );
    }

    // create a window
    $view   = $response->loadView
    (
      'form_meta-'.$domainNode->domainName,
      'EnterpriseCompany_Maintenance',
      'displayShowMeta'
    );
    $view->setModel( $this->loadModel( $domainNode->domainKey.'_Crud' ) );

    // load the flow flags
    $params  = $this->getFormFlags( $params );

    // show only the the fields in the meta category
    $params->categories = array('meta');

    $error = $view->displayShowMeta( $domainNode, $objid, $params );

    // im Fehlerfall jedoch bekommen wir eine Error Objekt das wird noch kurz
    // behandeln sollten
    if ($error) {
      return $error;
    }

    return null;

  }//end public function service_showMeta */


////////////////////////////////////////////////////////////////////////////////
// stats
////////////////////////////////////////////////////////////////////////////////

 /**
  *
  * @param LibRequestHttp $request
  * @param LibResponseHttp $response
  * @return boolean
  */
  public function service_statsEntity( $request, $response )
  {

    // prüfen ob irgendwelche steuerflags übergeben wurde
    $params  = $this->getFormFlags( $request );

    $domainKey   = $request->param( 'dkey', Validator::CKEY );
    if (!$domainKey) {
      throw new InvalidRequest_Exception
      (
        'Missing Domain Parameter',
        Response::BAD_REQUEST
      );
    }

    $domainNode  = DomainNode::getNode( $domainKey );

    if (!$domainNode) {
      throw new InvalidRequest_Exception
      (
        'The requestes Metadate not exists',
        Response::NOT_FOUND
      );
    }


    // check the acl permissions
    if ( !$this->acl->access( $domainNode->domainAcl.':access'  ) ) {
      throw new InvalidRequest_Exception
      (
        'You have no permission to access this service',
        Response::FORBIDDEN
      );
    }

    // create a window
    $view   = $response->loadView
    (
      'stats-'.$domainNode->domainName,
      'MaintenanceEntity_Stats',
      'displayEntity'
    );
    $view->setModel( $this->loadModel( $domainNode->domainKey.'_Crud' ) );

    $view->displayEntity( $domainNode, $params );


  }//end public function service_statsEntity */


 /**
  * @param LibRequestHttp $request
  * @param LibResponseHttp $response
  * @return boolean
  */
  public function service_statsDataset( $request, $response )
  {

    // prüfen ob irgendwelche steuerflags übergeben wurde
    $params  = $this->getFormFlags( $request );

    $domainKey   = $request->param( 'dkey', Validator::CKEY );
    if (!$domainKey) {
      throw new InvalidRequest_Exception
      (
        'Missing Domain Parameter',
        Response::BAD_REQUEST
      );
    }

    $domainNode  = DomainNode::getNode( $domainKey );

    if (!$domainNode) {
      throw new InvalidRequest_Exception
      (
        'The requestes Metadate not exists',
        Response::NOT_FOUND
      );
    }

    // check the acl permissions
    if ( !$this->acl->access( $domainNode->domainAcl.':access'  ) ) {
      throw new InvalidRequest_Exception
      (
        'You have no permission to access this service',
        Response::FORBIDDEN
      );
    }


    // check if we got a valid objid
    if ( !$objid = $this->getOID() ) {
      throw new InvalidRequest_Exception
      (
        'Missing the ID',
        Response::BAD_REQUEST
      );
    }

    // create a window
    $view   = $response->loadView
    (
      'stats-'.$domainNode->domainName.'-'.$objid,
      'MaintenanceEntity_Stats',
      'displayDataset'
     );
    $view->setModel( $this->loadModel( $domainNode->domainKey.'_Crud' ) );

    $error = $view->displayDataset( $domainNode, $objid, $params );

    // im Fehlerfall jedoch bekommen wir eine Error Objekt das wird noch kurz
    // behandeln sollten
    if ($error) {
      return $error;
    }

    return null;

  }//end public function service_statsDataset */


////////////////////////////////////////////////////////////////////////////////
// protocol
////////////////////////////////////////////////////////////////////////////////

 /**
  * @param LibRequestHttp $request
  * @param LibResponseHttp $response
  * @return boolean
  */
  public function service_protocolEntity( $request, $response )
  {

    $domainKey   = $request->param( 'dkey', Validator::CKEY );
    if (!$domainKey) {
      throw new InvalidRequest_Exception
      (
        'Missing Domain Parameter',
        Response::BAD_REQUEST
      );
    }

    $domainNode  = DomainNode::getNode( $domainKey );

    if (!$domainNode) {
      throw new InvalidRequest_Exception
      (
        'The requestes Metadate not exists',
        Response::NOT_FOUND
      );
    }

    // check the acl permissions
    if ( !$this->acl->access( $domainNode->domainAcl.':access'  ) ) {
      throw new InvalidRequest_Exception
      (
        'You have no permission to access this service',
        Response::FORBIDDEN
      );
    }

    // create a window
    $view   = $response->loadView
    (
      'protocol-'.$domainNode->domainName,
      'MaintenanceEntity_Protocol',
      'displayEntity'
    );
    $view->setModel( $this->model );

    // prüfen ob irgendwelche steuerflags übergeben wurde
    $params  = $this->getFormFlags( $request );

    $view->displayEntity( $domainNode, $params );

  }//end public function service_protocolEntity */


 /**
  * @param LibRequestHttp $request
  * @param LibResponseHttp $response
  * @return boolean
  */
  public function service_protocolDataset( $request, $response )
  {

    // prüfen ob irgendwelche steuerflags übergeben wurde
    $params  = $this->getFormFlags( $request );

      $domainKey   = $request->param( 'dkey', Validator::CKEY );
    if (!$domainKey) {
      throw new InvalidRequest_Exception
      (
        'Missing Domain Parameter',
        Response::BAD_REQUEST
      );
    }

    $domainNode  = DomainNode::getNode( $domainKey );

    if (!$domainNode) {
      throw new InvalidRequest_Exception
      (
        'The requestes Metadate not exists',
        Response::NOT_FOUND
      );
    }

      // check if we got a valid objid
    if ( !$objid = $this->getOID() ) {
      throw new InvalidRequest_Exception
      (
        'Missing the ID',
        Response::BAD_REQUEST
      );
    }

    // check the acl permissions
    if ( !$this->acl->access( $domainNode->domainAcl.':access', $objid  ) ) {
      throw new InvalidRequest_Exception
      (
        'You have no permission to access this service',
        Response::FORBIDDEN
      );
    }


    // create a window
    $view   = $response->loadView
    (
      'protocol-'.$domainNode->domainName,
      'MaintenanceEntity_Protocol',
      'displayDataset'
    );
    $view->setModel( $this->model );

    // load the flow flags
    $params  = $this->getFormFlags( $request );

    $error = $view->displayDataset( $domainNode, $objid,  $params );

    // im Fehlerfall jedoch bekommen wir eine Error Objekt das wird noch kurz
    // behandeln sollten
    if ($error) {
      return $error;
    }

    return null;

  }//end public function service_protocolDataset */


////////////////////////////////////////////////////////////////////////////////
// parse flags
////////////////////////////////////////////////////////////////////////////////

  /**
   * get the form flags for this management
   * @param LibRequestHttp $request
   * @return TFlag
   */
  protected function getFormFlags( $request )
  {

    $response  = $this->getResponse();

    $params = new TFlag();


    // target mask key
    if( $refId = $request->param( 'refid', Validator::INT ) )
      $params->refId  = $refId;

    // listing type
    if( $ltype   = $request->param( 'ltype', Validator::CNAME ) )
      $params->ltype    = $ltype;

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

  }//end protected function getFormFlags */

} // end class MaintenanceEntity_Controller
