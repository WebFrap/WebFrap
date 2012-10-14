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
class WebfrapContactForm_Controller
  extends Controller
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////
  
  /**
   * @var array
   */
  protected $options           = array
  (
    'formuser' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'modal' )
    ),
    'formgroup' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'modal' )
    ),
    'formdataset' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'modal' )
    ),
    'sendusermessage' => array
    (
      'method'    => array( 'POST' ),
      'views'      => array( 'ajax' )
    ),
    'sendgroup' => array
    (
      'method'    => array( 'POST' ),
      'views'      => array( 'ajax' )
    ),
    'senddataset' => array
    (
      'method'    => array( 'POST' ),
      'views'      => array( 'ajax' )
    ),
  );

////////////////////////////////////////////////////////////////////////////////
// Base Methodes


  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_formUser( $request, $response )
  {

    $refId   = $request->param( 'ref_id', Validator::EID );
    $userId  = $request->param( 'user_id', Validator::EID );
    $dataSrc = $request->param( 'd_src', Validator::CNAME );
    $element = $request->param( 'element', Validator::CKEY );
    
    if( !$element )
      $element = 'contact';
    
    $view = $response->loadView
    ( 
    	'user-form-'.$element, 
    	'WebfrapContactForm', 
    	'displayUser',
      View::MODAL
    );
    
    $model = $this->loadModel( 'WebfrapMessage' );
    $view->setModel( $model );
    
    $view->displayUser( $refId, $userId, $dataSrc, $element );
    

  }//end public function service_formUser */
  

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_sendUserMessage( $request, $response )
  {
    // refid
    $refId   = $request->param( 'ref_id', Validator::EID );
    $userId  = $request->param( 'user_id', Validator::EID );
    $dataSrc = $request->param( 'd_src', Validator::CNAME );

    /* @var $model WebfrapContactForm_Model */
    $model = $this->loadModel( 'WebfrapMessage' );
    
    $mgsData = new TDataObject();
    $mgsData->subject = $request->data( 'subject', Validator::TEXT );
    $mgsData->channels = $request->data( 'channels', Validator::CKEY );
    $mgsData->confidentiality = $request->data( 'id_confidentiality', Validator::INT );
    $mgsData->importance = $request->data( 'importance', Validator::INT );
    $mgsData->message = $request->data( 'message', Validator::HTML );

    $model->sendUserMessage( $userId, $dataSrc, $refId, $mgsData );

  }//end public function service_sendUserMessage */


  
} // end class WebfrapContactForm_Controller


