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
 * @subpackage ModEnterprise
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright webfrap.net <contact@webfrap.net>
 */
class AclMgmt_Path_Controller
  extends ControllerCrud
{////////////////////////////////////////////////////////////////////////////////
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
    'showgraph' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'maintab' )
    ),
    'reload' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'maintab' )
    ),
    'savepath' => array
    (
      'method'    => array( 'POST' ),
      'views'      => array( 'ajax' )
    ),
    'savepath' => array
    (
      'method'    => array( 'DELETE' ),
      'views'      => array( 'ajax' )
    ),
  );

////////////////////////////////////////////////////////////////////////////////
// listing methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * display the graph to visualize the references on the management
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return boolean
   */
  public function service_showGraph( $request, $response )
  {

    // load request parameters an interpret as flags
    $params  = $this->getListingFlags( $request );

    
    $domainNode  = $this->getDomainNode( $request );


    $user = $this->getUser();

    $access = new AclMgmt_Access_Container( null, null, $this, $domainNode );
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
            'resource'  => $response->i18n->l( $domainNode->label, $domainNode->domainI18n )
          )
        ),
        Response::FORBIDDEN
      );
    }

    // der Access Container des Users für die Resource wird als flag übergeben
    $params->access = $access;


    if( !$groupId = $request->param( 'group_id', Validator::INT )  )
    {
      throw new InvalidRequest_Exception
      (
        'Missing the GROUP ID',
        Response::BAD_REQUEST
      );
    }

    $params->graphType = $request->param( 'graph_type', Validator::CNAME );

    $view = $this->loadView
    ( 
      $domainNode->domainName.'_acl_graph', 
      'AclMgmt_Path',
      'displayGraph',
      null,
      true
    );

    $model = $this->loadModel( 'AclMgmt_Path' );
    $model->domainNode = $domainNode;
    $view->setModel( $model );

    return $view->displayGraph( $groupId, $params );

  }//end public function service_showGraph */

  /**
   * display the graph to visualize the references on the management
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return boolean
   */
  public function service_reloadGraph( $request, $response )
  {

    // load request parameters an interpret as flags
    $params  = $this->getListingFlags( $request );

    $domainNode  = $this->getDomainNode( $request );

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
            'resource'  => $response->i18n->l( $domainNode->pLabel, $domainNode->domainI18n.'.plabel' )
          )
        ),
        Response::FORBIDDEN
      );
    }

    // der Access Container des Users für die Resource wird als flag übergeben
    $params->access = $access;


    if( !$groupId = $request->param( 'group_id', Validator::INT )  )
    {
      throw new InvalidRequest_Exception
      (
        'Missing the GROUP ID',
        Response::BAD_REQUEST
      );
    }


    $params->graphType = $request->param( 'graph_type', Validator::CNAME );

    $view = $response->loadView
    ( 
      'enterprise_employee_acl_graph', 
      'AclMgmt_Path',
      'displayGraph',
      null,
      true
     );

     /* @var $model AclMgmt_Path_Model  */
     $model = $this->loadModel( 'AclMgmt_Path' );
     $model->domainNode = $domainNode;
    $view->setModel( $model );

    return $view->displayGraph( $groupId, $params );

  }//end public function service_reloadGraph */

  /**
   * display the graph to visualize the references on the management
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return boolean
   */
  public function service_savePath( $request, $response )
  {

    $domainNode  = $this->getDomainNode( $request );


    // load request parameters an interpret as flags
    $params   = $this->getListingFlags( $request );
    $user     = $this->getUser();

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


    $params->graphType = $request->param( 'graph_type', Validator::CNAME );

    /* @var $model AclMgmt_Dset_Model  */
    $model = $this->loadModel( 'AclMgmt_Path' );
    $model->domainNode = $domainNode;

    $objid = $request->data( 'objid', Validator::INT );

    if( !$model->fetchPathInput( $objid ) )
    {
      throw new InvalidRequest_Exception
      (
        'Not found',
        Response::NOT_FOUND
      );
    }

    $model->savePath();

    $view = $response->loadView
    (
      $domainNode->domainName.'_acl_graph',
      'AclMgmt_Path',
      'displayGraph'
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


    
    $view->setModel( $model  );

    $error = $view->displayGraph( $model->getPathEntity()->id_group, $params );


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


  }//end public function service_savePath */

  /**
   * drop a path and it's subpaths
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   */
  public function service_dropPath( $request, $response  )
  {

    $domainNode  = $this->getDomainNode( $request );


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
            'resource'  => $response->i18n->l( $domainNode->pLabel, $domainNode->domainI18n.'.plabel' )
          )
        ),
        Response::FORBIDDEN
      );
    }

    // der Access Container des Users für die Resource wird als flag übergeben
    $params->access = $access;


    $params->graphType = $request->param( 'graph_type', Validator::CNAME );

    $objid    = $request->param( 'delid', Validator::EID );
    $groupId  = $request->param( 'group_id', Validator::EID );

    if( !$objid  )
    {
      throw new InvalidRequest_Exception
      (
        'Missing the GROUP ID',
        Response::BAD_REQUEST
      );
    }

    if( !$view = $this->tpl->loadView
    ( 
      $domainNode->domainName.'_acl_graph', 
      'AclMgmt_Path' 
    ) )
    {
      throw new InvalidRequest_Exception
      (
        'Sorry, an internal Error occured',
        Response::INTERNAL_ERROR
      );
    }

    /* @var $model AclMgmt_Model  */
    $model = $this->loadModel( 'AclMgmt_Path' );
    $model->domainNode = $domainNode;
    $view->setModel( $model );

    $model->dropPath( $objid );

    return $view->displayGraph( $groupId, $params );

  }//end public function service_dropPath */

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

} // end class AclMgmt_Path_Controller */

