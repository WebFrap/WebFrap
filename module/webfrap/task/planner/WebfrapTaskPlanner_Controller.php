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
 * @subpackage Taskplanner
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class WebfrapTaskPlanner_Controller extends Controller
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
    'list' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'maintab' )
    ),
    'newplan' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'modal' )
    ),
    'editplan' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'modal' )
    ),
    'insertplan' => array
    (
      'method'    => array( 'POST' ),
      'views'      => array( 'ajax' )
    ),
    'updateplan' => array
    (
      'method'    => array( 'POST','PUT' ),
      'views'      => array( 'ajax' )
    ),
    'deleteplan' => array
    (
      'method'    => array( 'DELETE' ),
      'views'      => array( 'ajax' )
    ),

  );

/*//////////////////////////////////////////////////////////////////////////////
// Base Methodes
//////////////////////////////////////////////////////////////////////////////*/

  
  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_list($request, $response )
  {
    
    $acl = $this->getAcl();
    
    if (!$acl->hasRole( array( 'admin', 'maintenance', 'developer' ) ) )
      throw new PermissionDenied_Exception();
    
    ///@trows InvalidRequest_Exception
    $view = $response->loadView
    (
      'webfrap-taskplanner-list', 
      'WebfrapTaskPlanner_List' , 
      'displayList'
    );
    
    $params = new ContextListing($request);

    $model = $this->loadModel( 'WebfrapTaskPlanner' );
  
    $view->setModel($model );
    $view->displayList($params );
    
  }//end public function service_list */

   /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_newPlan($request, $response )
  {
    
    $acl = $this->getAcl();
    
    if (!$acl->hasRole( array( 'admin', 'maintenance', 'developer' ) ) )
      throw new PermissionDenied_Exception();
    
    ///@throws InvalidRequest_Exception
    /* @var $response WebfrapTaskPlanner_New_Modal_View */
    $view = $response->loadView
    (
      'webfrap-taskplanner-new', 
      'WebfrapTaskPlanner_New' , 
      'displayForm'
    );
    
    $params = new ContextCrud($request);

    $model = $this->loadModel( 'WebfrapTaskPlanner' );
  
    $view->setModel($model );
    $view->displayForm($params );
    
  }//end public function service_newPlan */
  
   /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_insertPlan($request, $response )
  {
    
    $acl = $this->getAcl();
    
    if (!$acl->hasRole( array( 'admin', 'maintenance', 'developer' ) ) )
      throw new PermissionDenied_Exception();
      
    $data = new WebfrapTaskPlanner_Plan_Validator($response );
    $data->check($request);
    
    if ($data->hasError )
      throw new InvalidRequest_Exception();
    
    
    ///@throws InvalidRequest_Exception
    /* @var $response WebfrapTaskPlanner_List_Ajax_View */
    $view = $response->loadView
    (
      'webfrap-taskplanner-new', 
      'WebfrapTaskPlanner_List' , 
      'displayAdd'
    );
    
    $params = new ContextCrud($request);
    /* @var $model WebfrapTaskPlanner_Model */
    $model = $this->loadModel( 'WebfrapTaskPlanner' );
    
    $plan = $model->insertPlan($data );
  
    $view->setModel($model );
    $view->displayAdd($plan, $params );

    
  }//end public function service_insertPlan */
  
   /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_editPlan($request, $response )
  {
    
    $acl = $this->getAcl();
    
    if (!$acl->hasRole( array( 'admin', 'maintenance', 'developer' ) ) )
      throw new PermissionDenied_Exception();
    
    $objid = $request->param('objid', Validator::EID );
      
    ///@throws InvalidRequest_Exception
    /* @var $response WebfrapTaskPlanner_New_Modal_View */
    $view = $response->loadView
    (
      'webfrap-taskplanner-edit-'.$objid, 
      'WebfrapTaskPlanner_Edit' , 
      'displayForm'
    );
    
    $params = new ContextCrud($request);

    $model = $this->loadModel( 'WebfrapTaskPlanner' );
  
    $view->setModel($model );
    $view->displayForm($objid, $params );
    
  }//end public function service_editPlan */
  
   /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_updatePlan($request, $response )
  {
    
    $acl = $this->getAcl();
    
    if (!$acl->hasRole( array( 'admin', 'maintenance', 'developer' ) ) )
      throw new PermissionDenied_Exception();
      
    $data = new WebfrapTaskPlanner_Plan_Validator($response );
    $data->check($request);
    
    if ($data->hasError )
      throw new InvalidRequest_Exception();
    
    $objid = $request->param('objid', Validator::EID );
    
    ///@throws InvalidRequest_Exception
    /* @var $response WebfrapTaskPlanner_List_Ajax_View */
    $view = $response->loadView
    (
      'webfrap-taskplanner-edit-'.$objid, 
      'WebfrapTaskPlanner_List' , 
      'displayUpdate'
    );
    
    $params = new ContextCrud($request);
    /* @var $model WebfrapTaskPlanner_Model */
    $model = $this->loadModel( 'WebfrapTaskPlanner' );
    
    $plan = $model->updatePlan($objid, $data );
  
    $view->setModel($model );
    $view->displayUpdate($plan, $params );

    
  }//end public function service_updatePlan */
  
   /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_deletePlan($request, $response )
  {
    
    $acl = $this->getAcl();
    
    if (!$acl->hasRole( array( 'admin', 'maintenance', 'developer' ) ) )
      throw new PermissionDenied_Exception();

    
    $objid = $request->param('objid', Validator::EID );
    
    ///@throws InvalidRequest_Exception
    /* @var $response WebfrapTaskPlanner_List_Ajax_View */
    $view = $response->loadView
    (
      'webfrap-taskplanner-edit-'.$objid, 
      'WebfrapTaskPlanner_List' , 
      'displayDelete'
    );
    
    $params = new ContextCrud($request);
    /* @var $model WebfrapTaskPlanner_Model */
    $model = $this->loadModel( 'WebfrapTaskPlanner' );
    
    $model->deletePlan($objid );
  
    $view->setModel($model );
    $view->displayDelete($objid, $params );

    
  }//end public function service_deletePlan */
  

} // end class Webfrap_TaskPlanner_Controller


