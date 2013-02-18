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
class WebfrapContactForm_Controller extends Controller
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/
  
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
    'formdset' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'modal' )
    ),
    'sendusermessage' => array
    (
      'method'    => array( 'POST' ),
      'views'      => array( 'ajax' )
    ),
    'sendgroupmessage' => array
    (
      'method'    => array( 'POST' ),
      'views'      => array( 'ajax' )
    ),
    'senddsetmessage' => array
    (
      'method'    => array( 'POST' ),
      'views'      => array( 'ajax' )
    ),
  );

/*//////////////////////////////////////////////////////////////////////////////
// Base Methodes


  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_formUser($request, $response )
  {

    $refId   = $request->param('ref_id', Validator::EID );
    $userId  = $request->param('user_id', Validator::EID );
    $dataSrc = $request->param('d_src', Validator::CNAME );
    $element = $request->param('element', Validator::CKEY );
    
    if (!$element )
      $element = 'contact';
    
    $view = $response->loadView
    ( 
      'user-form-'.$element, 
      'WebfrapContactForm', 
      'displayUser',
      View::MODAL
    );
    
    $model = $this->loadModel( 'WebfrapMessage' );
    $view->setModel($model );
    
    $view->displayUser($refId, $userId, $dataSrc, $element );
    

  }//end public function service_formUser */
  

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_sendUserMessage($request, $response )
  {
    // refid
    $refId   = $request->param('ref_id', Validator::EID );
    $userId  = $request->param('user_id', Validator::EID );
    $dataSrc = $request->param('d_src', Validator::CNAME );

    /* @var $model WebfrapContactForm_Model */
    $model = $this->loadModel( 'WebfrapMessage' );
    
    $mgsData = new TDataObject();
    $mgsData->subject = $request->data( 'subject', Validator::TEXT );
    $channels = $request->data( 'channels', Validator::CKEY );
    
    $tmpChannels = array();
    
    foreach($channels as $channel )
    {
      if (!ctype_digit($channel )  )
        $tmpChannels[] = $channel;
    }
    $mgsData->channels = $tmpChannels;
    
    
    $mgsData->confidentiality = $request->data( 'id_confidentiality', Validator::INT );
    $mgsData->importance = $request->data( 'importance', Validator::INT );
    $mgsData->message = $request->data( 'message', Validator::HTML );

    $model->sendUserMessage($userId, $dataSrc, $refId, $mgsData );

  }//end public function service_sendUserMessage */

  
  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_formGroup($request, $response )
  {

    $refId     = $request->param('ref_id', Validator::EID );
    $groupKey  = $request->param('group', Validator::CNAME );
    $dataSrc   = $request->param('d_src', Validator::CNAME );
    $element   = $request->param('element', Validator::CKEY );
    
    if (!$element )
      $element = 'contact';
    
    /* @var $view WebfrapContactForm_Modal_View  */
    $view = $response->loadView
    ( 
      'group-form-'.$element, 
      'WebfrapContactForm', 
      'displayGroup',
      View::MODAL
    );
    
    /* @var $model WebfrapMessage_Model  */
    $model = $this->loadModel( 'WebfrapMessage' );
    $view->setModel($model );
    
    $view->displayGroup($refId, $groupKey, $dataSrc, $element );
    

  }//end public function service_formGroup */

  
  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_sendGroupMessage($request, $response )
  {
    // refid
    $refId   = $request->param('ref_id', Validator::EID );
    $dataSrc = $request->param('d_src', Validator::CNAME );
    
    
    $users   = $request->data( 'user', Validator::EID );

    /* @var $model WebfrapContactForm_Model */
    $model = $this->loadModel( 'WebfrapMessage' );
    
    $mgsData = new TDataObject();
    $mgsData->subject = $request->data( 'subject', Validator::TEXT );
    $channels = $request->data( 'channels', Validator::CKEY );
    
    $tmpChannels = array();
    
    foreach($channels as $channel )
    {
      if (!ctype_digit($channel )  )
        $tmpChannels[] = $channel;
    }
    $mgsData->channels = $tmpChannels;
    
    $mgsData->confidentiality = $request->data( 'id_confidentiality', Validator::INT );
    $mgsData->importance = $request->data( 'importance', Validator::INT );
    $mgsData->message = $request->data( 'message', Validator::HTML );

    if ($users )
    {
      foreach($users as $userId )
      {
        $model->sendUserMessage($userId, $dataSrc, $refId, $mgsData );
        
      }
    }
    
    $response->addMessage( 'Sucessfully sent the message' );
    
  }//end public function service_sendGroupMessage */
  
  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_formDset($request, $response )
  {

    $refId     = $request->param('ref_id', Validator::EID );
    $dataSrc   = $request->param('d_src', Validator::CNAME );
    $element   = $request->param('element', Validator::CKEY );
    
    if (!$element )
      $element = 'contact';
    
    /* @var $view WebfrapContactForm_Modal_View  */
    $view = $response->loadView
    ( 
      'group-form-'.$element, 
      'WebfrapContactForm', 
      'displayDset',
      View::MODAL
    );
    
    /* @var $model WebfrapMessage_Model  */
    $model = $this->loadModel( 'WebfrapMessage' );
    $view->setModel($model );
    
    $view->displayDset($refId, $dataSrc, $element );
    

  }//end public function service_formGroup */

  
  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_sendDsetMessage($request, $response )
  {
    // refid
    $refId   = $request->param('ref_id', Validator::EID );
    $dataSrc = $request->param('d_src', Validator::CNAME );
    
    
    $users   = $request->data( 'user', Validator::EID );

    /* @var $model WebfrapContactForm_Model */
    $model = $this->loadModel( 'WebfrapMessage' );
    
    $mgsData = new TDataObject();
    $mgsData->subject = $request->data( 'subject', Validator::TEXT );
    $channels = $request->data( 'channels', Validator::CKEY );
    
    $tmpChannels = array();
    
    foreach($channels as $channel )
    {
      if (!ctype_digit($channel )  )
        $tmpChannels[] = $channel;
    }
    $mgsData->channels = $tmpChannels;
    
    $mgsData->confidentiality = $request->data( 'id_confidentiality', Validator::INT );
    $mgsData->importance = $request->data( 'importance', Validator::INT );
    $mgsData->message = $request->data( 'message', Validator::HTML );

    if ($users )
    {
      foreach($users as $userId )
      {
        $model->sendUserMessage($userId, $dataSrc, $refId, $mgsData );
        
      }
    }
    
    $response->addMessage( 'Sucessfully sent the message' );
    
  }//end public function service_sendDsetMessage */
  
} // end class WebfrapContactForm_Controller


