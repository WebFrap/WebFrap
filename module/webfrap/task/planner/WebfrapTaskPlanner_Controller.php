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
 * @subpackage Core
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class WebfrapTaskPlanner_Controller
  extends Controller
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
    'list' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'maintab' )
    ),
    'formnew' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'modal' )
    ),
    'formedit' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'modal' )
    ),
    'insert' => array
    (
      'method'    => array( 'POST' ),
      'views'      => array( 'ajax' )
    ),
    'update' => array
    (
      'method'    => array( 'POST','PUT' ),
      'views'      => array( 'ajax' )
    ),
    'delete' => array
    (
      'method'    => array( 'DELETE' ),
      'views'      => array( 'ajax' )
    ),

  );

////////////////////////////////////////////////////////////////////////////////
// Base Methodes
////////////////////////////////////////////////////////////////////////////////

  
  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_list( $request, $response )
  {
    
    $acl = $this->getAcl();
    
    if( !$acl->hasRole( array( 'admin', 'maintenance', 'developer' ) ) )
      throw new PermissionDenied_Exception();
    
    ///@trows InvalidRequest_Exception
    $view = $response->loadView
    (
      'webfrap-taskplanner-list', 
      'WebfrapTaskPlanner_List' , 
      'displayList'
    );
    
    $params = new ContextListing( $request );

    $model = $this->loadModel( 'WebfrapTaskPlanner' );
  
    $view->setModel( $model );
    $view->displayList( $params );
    
  }//end public function service_list */

   /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_formCreate( $request, $response )
  {
    
    $acl = $this->getAcl();
    
    if( !$acl->hasRole( array( 'admin', 'maintenance', 'developer' ) ) )
      throw new PermissionDenied_Exception();
    
    ///@throws InvalidRequest_Exception
    /* @var $response WebfrapTaskPlanner_New_Modal_View */
    $view = $response->loadView
    (
      'webfrap-taskplanner-new', 
      'WebfrapTaskPlanner_New' , 
      'displayForm'
    );
    
    $params = new ContextListing( $request );

    $model = $this->loadModel( 'WebfrapTaskPlanner' );
  
    $view->setModel( $model );
    $view->displayForm( $params );
    
  }//end public function service_formCreate */
  

} // end class Webfrap_TaskPlanner_Controller


