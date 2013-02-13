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
 * class ControllerAdmintoolsPostgres
 * Extention zum anzeigen dieverser Systemdaten
 */
class DaidalosSystem_Controller
  extends Controller
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  
  /**
   * @var array
   */
  protected $options           = array
  (
    'statuseditior' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'maintab' )
    ),
    'autocompleteusers' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'ajax'  )
    ),
    'changeuser' => array
    (
      'method'    => array( 'POST', 'PUT' ),
      'views'      => array( 'ajax','maintab' )
    ),
  );


/*//////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_statusEditior( $request, $response )
  {
    
    $user = $this->getUser();
    
    if( !$user->hasRole( 'developer' ) && !$user->checkLevel( User::LEVEL_ADMIN ) )
      throw new PermissionDenied_Exception();

    $params = $this->getFlags( $request );
    $response = $this->getResponse();

    $view = $response->loadView
    ( 
      'daidalos-status-editor', 
      'DaidalosSystem',
      'displayEditor',
      View::MAINTAB
    );
    
    $view->displayEditor( $params );

  }//end public function service_statusEditior */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_autocompleteUsers( $request, $response )
  {
    
    $user = $this->getUser();
    
    if( !$user->hasRole( 'developer' ) && !$user->checkLevel( User::LEVEL_ADMIN ) )
      throw new PermissionDenied_Exception();

    // load request parameters an interpret as flags
    $params = $this->getFlags( $request );

    $view   = $this->tplEngine->loadView('DaidalosSystem_Ajax');
    $view->setModel( $this->loadModel('DaidalosSystem') );

    $searchKey  = $this->request->param('key',Validator::TEXT);

    return $view->displayAutocomplete( $searchKey, $params );

  }//end public function service_autocompleteUsers */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_changeUser( $request, $response )
  {
    
    $user = $this->getUser();
    
    if( !$user->hasRole( 'developer' ) && !$user->checkLevel( User::LEVEL_ADMIN ) )
      throw new PermissionDenied_Exception();

    $params = $this->getFlags( $request );
    
    $username = $request->data( 'username', Validator::TEXT );
    
    if( !$username )
      throw new InvalidRequest_Exception( 'Missing the Username parameter' );

    $user->clean();
    $user->login( $request->data( 'username', Validator::TEXT ) );

    $view = $response->loadView( 'daidalos-status-editor', 'DaidalosSystem', 'displayEditor' );
    $view->displayEditor( $params );
    
  }//end public function service_changeUser */


} // end class DaidalosDb_Controller

