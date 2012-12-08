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
class WebfrapCache_Controller
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
    'stats' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'maintab' )
    ),
    'cleanall' => array
    (
      'method'    => array( 'GET', "CLI" ),
      'views'      => array( 'ajax', 'cli' )
    ),
    'rebuildcss' => array
    (
      'method'    => array( 'GET', "CLI" )
    ),
    'rebuildjs' => array
    (
      'method'    => array( 'GET', "CLI" )
    ),
    'rebuildtheme' => array
    (
      'method'    => array( 'GET', "CLI" )
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
  public function service_stats( $request, $response )
  {
    
    $acl = $this->getAcl();
    
    if( !$acl->hasRole( array( 'admin', 'maintenance', 'developer' ) ) )
      throw new PermissionDenied_Exception();
    
    ///@trows InvalidRequest_Exception
    $view = $response->loadView
    (
      'webfrap-cache-stats', 
      'WebfrapCache' , 
      'displayStats'
    );
    
    $params = $this->getFlags( $request );

    $model = $this->loadModel( 'WebfrapCache' );
  
    $view->setModel( $model );
    $view->displayStats( $params );
    
  }//end public function service_stats */

  /**
   * Clean the complete cache
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_cleanAll( $request, $response )
  {
    
    // access check wenn nicht per cli
    if( $this->tpl->type !== View::CLI )
    {
      $acl = $this->getAcl();
      
      if( !$acl->hasRole( array( 'admin', 'maintenance', 'developer' ) ) )
        throw new PermissionDenied_Exception();
    }

    /* @var $model WebfrapCache_Model  */
    $model = $this->loadModel( 'WebfrapCache' );
    $model->cleanCache( );
    
  }//end public function service_cleanAll */
  
  /**
   * Clean the complete cache
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_rebuildCss( $request, $response )
  {
    
    // access check wenn nicht per cli
    if( $this->tpl->type !== View::CLI )
    {
      $acl = $this->getAcl();
      
      if( !$acl->hasRole( array( 'admin', 'maintenance', 'developer' ) ) )
        throw new PermissionDenied_Exception();
    }

    $key = $request->param( 'key', Validator::CNAME );
    
    /* @var $model WebfrapCache_Model  */
    $model = $this->loadModel( 'WebfrapCache' );
    $model->rebuildCss( $key );
    
  }//end public function service_rebuildCss */
  
  /**
   * Clean the complete cache
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_rebuildJs( $request, $response )
  {
    
    // access check wenn nicht per cli
    /* */
    if( $this->tpl->type !== View::CLI )
    {
      $acl = $this->getAcl();
      
      if( !$acl->hasRole( array( 'admin', 'maintenance', 'developer' ) ) )
        throw new PermissionDenied_Exception();
    }
   
    $key = $request->param( 'key', Validator::CNAME );

    /* @var $model WebfrapCache_Model  */
    $model = $this->loadModel( 'WebfrapCache' );
    $model->rebuildJs( $key );
    
  }//end public function service_rebuildJs */
  
  /**
   * Clean the complete cache
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_rebuildTheme( $request, $response )
  {
    
    // access check wenn nicht per cli
    if( $this->tpl->type !== View::CLI )
    {
      $acl = $this->getAcl();
      
      if( !$acl->hasRole( array( 'admin', 'maintenance', 'developer' ) ) )
        throw new PermissionDenied_Exception();
    }
    
    $key = $request->param( 'key', Validator::CNAME );

    /* @var $model WebfrapCache_Model  */
    $model = $this->loadModel( 'WebfrapCache' );
    $model->rebuildTheme( $key );
    
  }//end public function service_rebuildJs */
  

} // end class WebfrapCache_Controller


