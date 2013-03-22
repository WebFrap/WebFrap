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
class AclMgmt_Tree_Controller extends ControllerCrud
{/*//////////////////////////////////////////////////////////////////////////////
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
    'showgraph' => array
    (
      'method'    => array('GET'),
      'views'      => array('maintab')
    ),
    'reload' => array
    (
      'method'    => array('GET'),
      'views'      => array('maintab')
    ),
    'savepath' => array
    (
      'method'    => array('POST'),
      'views'      => array('maintab')
    ),
    'droppath' => array
    (
      'method'    => array('DELETE'),
      'views'      => array('ajax','maintab')
    ),
  );

/*//////////////////////////////////////////////////////////////////////////////
// listing methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * display the graph to visualize the references on the management
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return boolean
   */
  public function service_showGraph($request, $response)
  {

    // load request parameters an interpret as flags
    $params      = $this->getListingFlags($request);
    $domainNode  = $this->getDomainNode($request);

    /* @var $model AclMgmt_Tree_Model */
    $model = $this->loadModel('AclMgmt_Tree');
    $model->domainNode = $domainNode;
    $model->checkAccess($domainNode, $params);


    if (!$groupId = $request->param('group_id', Validator::INT)  ) {
      throw new InvalidRequest_Exception
      (
        'Missing the GROUP ID',
        Response::BAD_REQUEST
      );
    }

    /* @var $view AclMgmt_Tree_Maintab_View */
    $view = $response->loadView
    (
      $domainNode->domainName.'_acl_graph',
      'AclMgmt_Tree',
      'displayGraph'
    );
    $view->setModel($model);

    return $view->displayGraph($groupId, $params);

  }//end public function service_showGraph */

  /**
   * display the graph to visualize the references on the management
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return boolean
   */
  public function service_reloadGraph($request, $response)
  {

    // load request parameters an interpret as flags
    $params      = $this->getListingFlags($request);
    $domainNode  = $this->getDomainNode($request);

    /* @var $model AclMgmt_Tree_Model  */
    $model = $this->loadModel('AclMgmt_Tree');
    $model->domainNode = $domainNode;
    $model->checkAccess($domainNode, $params);


    if (!$groupId = $request->param('group_id', Validator::INT)  ) {
      throw new InvalidRequest_Exception
      (
        'Missing the GROUP ID',
        Response::BAD_REQUEST
      );
    }

    $params->graphType = $request->param('graph_type', Validator::CNAME);

    /* @var $view AclMgmt_Tree_Ajax_View */
    $view = $response->loadView
    (
      $domainNode->domainName.'_acl_graph',
      'AclMgmt_Tree',
      'displayGraph'
    );
    $view->setModel($model);

    $view->displayGraph($groupId, $params);

  }//end public function service_reloadGraph */

  /**
   * display the graph to visualize the references on the management
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return boolean
   */
  public function service_savePath($request, $response)
  {

    $domainNode  = $this->getDomainNode($request);


    // load request parameters an interpret as flags
    $params   = $this->getListingFlags($request);
    $params->graphType = $request->param('graph_type', Validator::CNAME);

    $objid = $request->data('objid', Validator::INT);

    /* @var $model AclMgmt_Dset_Model  */
    $model = $this->loadModel('AclMgmt_Tree');
    $model->domainNode = $domainNode;
    $model->checkAccess($domainNode, $params);

    if (!$model->fetchPathInput($objid)) {
      throw new InvalidRequest_Exception
      (
        'Not found',
        Response::NOT_FOUND
      );
    }

    $model->savePath();

    /* @var $view AclMgmt_Tree_Ajax_View */
    $view = $response->loadView
    (
      $domainNode->domainName.'_acl_graph',
      'AclMgmt_Tree',
      'displayGraph'
    );
    $view->setModel($model  );

    $view->displayGraph($model->getPathEntity()->id_group, $params);


  }//end public function service_savePath */

  /**
   * drop a path and it's subpaths
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   */
  public function service_dropPath($request, $response  )
  {

    $domainNode  = $this->getDomainNode($request);

    // load request parameters an interpret as flags
    $params  = $this->getListingFlags($request);

    $params->graphType = $request->param('graph_type', Validator::CNAME);

    $objid    = $request->param('delid', Validator::EID);
    $groupId  = $request->param('group_id', Validator::EID);

    if (!$objid) {
      throw new InvalidRequest_Exception
      (
        'Missing the GROUP ID',
        Response::BAD_REQUEST
      );
    }

    /* @var $model AclMgmt_Model  */
    $model = $this->loadModel('AclMgmt_Tree');
    $model->domainNode = $domainNode;
    $model->checkAccess($domainNode, $params);

    $view = $response->loadView
    (
      $domainNode->domainName.'_acl_graph',
      'AclMgmt_Tree',
      'displayGraph',
      View::MAINTAB
    );
    $view->setModel($model);

    $model->dropPath($objid);
    $view->displayGraph($groupId, $params);

  }//end public function service_dropPath */

  /**
   * @param LibRequestHttp $request
   * @throws InvalidRequest_Exception
   * @return DomainNode
   */
  protected function getDomainNode($request)
  {

    $domainKey   = $request->param('dkey', Validator::CKEY);
    if (!$domainKey) {
      throw new InvalidRequest_Exception
      (
        'Missing Domain Parameter',
        Response::BAD_REQUEST
      );
    }

    $domainNode  = DomainNode::getNode($domainKey);

    if (!$domainNode) {
      throw new InvalidRequest_Exception
      (
        'The requestes Metadate not exists',
        Response::NOT_FOUND
      );
    }

    return $domainNode;

  }//end protected function getDomainNode */

 /**
  * @lang de:
  * Auslesen der Listingflags
  *
  *
  * @param ContextDomainListing $params
  * @return ContextDomainListing
  */
  protected function getListingFlags($request)
  {

    if (!$request)
      $request = Request::getActive();

    $params = new ContextDomainListing($request);
    $params->interpretRequest($request);

    return $params;

  }//end protected function getListingFlags */

} // end class AclMgmt_Tree_Controller */

