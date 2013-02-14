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
class MyProfile_Controller extends Controller
{
  
  /**
   * Zugriffs optionen
   * 
   * @see Controller::$options
   * 
   * @var array
   */
  protected $options = array
  (
    'formforgotpassword' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'window', 'maintab' )
    ),
    'show' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'window', 'maintab' )
    ),
    'update' => array
    (
      'method'    => array( 'PUT' ),
      'views'      => array( 'ajax' )
    ),
    'delcontactitem' => array
    (
      'method'    => array( 'PUT' ),
      'views'      => array( 'ajax' )
    ),
  );
  
/*//////////////////////////////////////////////////////////////////////////////
// Methoden
//////////////////////////////////////////////////////////////////////////////*/


  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_formForgotPassword( $request, $response )
  {

    $view = $response->loadView
    ( 
      'form-forgot-passwd', 
      'MyProfile',
      'displayForgotPasswordForm'
    );

    $view->displayForgotPasswordForm();

  } // end public function service_formForgotPassword */
  
  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_show( $request, $response )
  {

    $flags = $this->getFlags( $request );
    
    $view = $response->loadView
    ( 
      'form-my-profile-show', 
      'MyProfile',
      'displayShow'
    );

    $view->displayShow( $flags );
    
  } // end public function service_show */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_delContactItem( $request, $response )
  {

    $flags = $this->getFlags( $request );

    $view = $response->loadView
    ( 
      'form-my-profile-show', 
      'MyProfile',
      'displayShow'
    );

    $view->displayShow( $flags );
    
  } // end public function service_delContactItem */
  
  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_addContactItem( $request, $response )
  {

    $flags = $this->getFlags( $request );

    $view = $response->loadView
    ( 
      'form-my-profile-show', 
      'MyProfile',
      'displayShow'
    );

    $view->displayShow( $flags );
    
  } // end public function service_delContactItem */
  
  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_updateContactItem( $request, $response )
  {

    $flags = $this->getFlags( $request );

    $view = $response->loadView
    ( 
      'form-my-profile-show', 
      'MyProfile',
      'displayShow'
    );

    $view->displayShow( $flags );
    
  } // end public function service_delContactItem */


}//end class MyProfile_Controller

