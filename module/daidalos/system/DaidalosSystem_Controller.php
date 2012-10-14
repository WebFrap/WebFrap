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
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   *
   * @var string
   */
  protected $callAble = array
  (
    'statuseditior',
    'autocompleteusers',
    'changeuser',
  );

////////////////////////////////////////////////////////////////////////////////
// Methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @return void
   */
  public function statusEditior( $params = null )
  {

    $params = $this->getFlags( $this->getRequest() );
    $response = $this->getResponse();

    $view = $response->loadView
    ( 
      'daidalos-status-editor', 
      'DaidalosSystem',
      'displayEditor',
      View::MAINTAB
    );
    
    $view->displayEditor( $params );

  }//end public function statusEditior */



  /**
   * the default table for the management ProjectProject
   * @param TFlag $params named parameters
   * @return boolean
   */
  public function autocompleteUsers( $params = null )
  {

    $response = $this->getResponse();
    // load request parameters an interpret as flags
    $params = $this->getFlags( $this->getRequest() );

    $view   = $this->tplEngine->loadView('DaidalosSystem_Ajax');
    $view->setModel( $this->loadModel('DaidalosSystem') );

    $searchKey  = $this->request->param('key',Validator::TEXT);

    return $view->displayAutocomplete( $searchKey, $params );

  }//end public function autocompleteUsers */


  /**
   * the default table for the management ProjectProject
   * @param TFlag $params named parameters
   * @return boolean
   */
  public function changeUser( $params = null )
  {
    
    $response = $this->getResponse();
    $request  = $this->getRequest();
    $user     = $this->getUser();

    $params = $this->getFlags( $this->getRequest() );

    $user->clean();
    $user->login( $request->data( 'username', Validator::TEXT ) );


    $view = $response->loadView( 'daidalos-status-editor', 'DaidalosSystem' );
    $view->displayEditor( $params );
    
  }//end public function changeUser */


} // end class DaidalosDb_Controller

