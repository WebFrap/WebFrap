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
 * @subpackage Groupware
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright webfrap.net <contact@webfrap.net>
 */
class WebfrapMessage_Controller extends Controller
{
/*//////////////////////////////////////////////////////////////////////////////
// methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var array
   */
  protected $options           = array
  (
    'openarea' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'modal' )
    ),
    'messagelist' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'maintab' )
    ),
    'searchlist' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'ajax' )
    ),

    // message logic
    'formnew' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'modal', 'maintab' )
    ),
    'formshow' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'modal', 'maintab' )
    ),
    'showmailcontent' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'html' )
    ),
    'sendusermessage' => array
    (
      'method'    => array( 'POST' ),
      'views'      => array( 'ajax' )
    ),

    'loaduser' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'ajax' )
    ),

    // form forward
    'formforward' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'modal', 'maintab' )
    ),

    'sendforward' => array
    (
      'method'    => array( 'POST' ),
      'views'      => array( 'ajax' )
    ),

    // form reply
    'formreply' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'modal', 'maintab' )
    ),

    'sendreply' => array
    (
      'method'    => array( 'POST' ),
      'views'      => array( 'ajax' )
    ),

    // delete

    'deletemessage' => array
    (
      'method'    => array( 'DELETE' ),
      'views'      => array( 'ajax' )
    ),
    'deleteall' => array
    (
      'method'    => array( 'DELETE' ),
      'views'      => array( 'ajax' )
    ),
    'deleteselection' => array
    (
      'method'    => array( 'DELETE' ),
      'views'      => array( 'ajax' )
    ),

  );

/*//////////////////////////////////////////////////////////////////////////////
// methodes
//////////////////////////////////////////////////////////////////////////////*/

 /**
  * create an new window with an edit form for the enterprise_company entity
  * @param LibRequestHttp $request
  * @param LibResponseHttp $response
  * @return boolean
  */
  public function service_openArea($request, $response )
  {

    // prüfen ob irgendwelche steuerflags übergeben wurde
    $params  = $this->getFlags($request);

    // create a window
    $view   = $response->loadView
    (
      'list-messages',
      'WebfrapMessage',
      'displayOpen',
      View::AJAX
    );
    $view->setModel($this->loadModel( 'WebfrapMessage' ) );

   $view->displayOpen($domainNode, $params );

  }//end public function service_showMeta */

 /**
  * create an new window with an edit form for the enterprise_company entity
  * @param LibRequestHttp $request
  * @param LibResponseHttp $response
  * @return boolean
  */
  public function service_messageList($request, $response )
  {

    // prüfen ob irgendwelche steuerflags übergeben wurde
    $params  = $this->getFlags($request);

    $model = $this->loadModel( 'WebfrapMessage' );
    $model->loadTableAccess($params );

    if (!$model->access->listing) {
      throw new InvalidRequest_Exception
      (
        Response::FORBIDDEN_MSG,
        Response::FORBIDDEN
      );
    }

    // create a window
    $view   = $response->loadView
    (
      'list-message_list',
      'WebfrapMessage_List',
      'displayList',
      View::MAINTAB
    );
    $view->setModel($this->loadModel( 'WebfrapMessage' ) );

    $view->displayList($params );

  }//end public function service_messageList */

 /**
  * create an new window with an edit form for the enterprise_company entity
  * @param LibRequestHttp $request
  * @param LibResponseHttp $response
  * @return boolean
  */
  public function service_searchList($request, $response )
  {

    // prüfen ob irgendwelche steuerflags übergeben wurde
    $params  = $this->getFlags($request);

    $model = $this->loadModel( 'WebfrapMessage' );
    $model->loadTableAccess($params );

    if (!$model->access->listing) {
      throw new InvalidRequest_Exception
      (
        Response::FORBIDDEN_MSG,
        Response::FORBIDDEN
      );
    }

    // create a window
    $view = $response->loadView
    (
      'list-message_list',
      'WebfrapMessage_List',
      'displaySearch',
      View::AJAX
    );

    $model = $this->loadModel( 'WebfrapMessage' );
    $view->setModel($model );


    // request
    $model->conditions['free'] = $request->param('free_search', Validator::SEARCH );
    $model->conditions['filters']['mailbox'] = $request->param('mailbox', Validator::CKEY );
    $model->conditions['filters']['archive'] = $request->param('archive', Validator::BOOLEAN );


    $view->displaySearch($params );

  }//end public function service_searchList */

 /**
  * Form zum erstellen einer neuen Message
  * @param LibRequestHttp $request
  * @param LibResponseHttp $response
  * @return boolean
  */
  public function service_formNew($request, $response )
  {

    // prüfen ob irgendwelche steuerflags übergeben wurde
    $params  = $this->getFlags($request);

    $model = $this->loadModel( 'WebfrapMessage' );
    $model->loadTableAccess($params );

    if (!$model->access->listing) {
      throw new InvalidRequest_Exception
      (
        Response::FORBIDDEN_MSG,
        Response::FORBIDDEN
      );
    }

    // create a window
    $view   = $response->loadView
    (
      'form-messages-new',
      'WebfrapMessage_New',
      'displayNew'
    );

    // request bearbeiten
    /* @var $model WebfrapMessage_Model */
    $model = $this->loadModel( 'WebfrapMessage' );
    $view->setModel($model );

    $view->displayNew($params );

  }//end public function service_formNew */

 /**
  * Form zum anschauen einer Nachricht
  * @param LibRequestHttp $request
  * @param LibResponseHttp $response
  * @return boolean
  */
  public function service_formShow($request, $response )
  {

    // prüfen ob irgendwelche steuerflags übergeben wurde
    $params  = $this->getFlags($request);

    $msgId = $request->param('objid', Validator::EID );

    /* @var $model WebfrapMessage_Model */
    $model = $this->loadModel( 'WebfrapMessage' );
    $model->loadTableAccess($params );

    if (!$model->access->access) {
      throw new InvalidRequest_Exception
      (
        Response::FORBIDDEN_MSG,
        Response::FORBIDDEN
      );
    }

    $message = $model->loadMessage($msgId );

    $user = $this->getUser();

    if ($message->id_receiver == $user->getId() ) {
      if ($message->id_receiver_status == EMessageStatus::IS_NEW) {
        $orm = $this->getOrm();
        $orm->update( 'WbfsysMessage', $message->msg_id, array('id_receiver_status' => EMessageStatus::OPEN ));
      }
    }

    // create a window
    $view   = $response->loadView
    (
      'form-messages-show-'.$msgId,
      'WebfrapMessage_Show',
      'displayShow'
    );
    $view->setModel($this->loadModel( 'WebfrapMessage' ) );

    $view->displayShow($params );

  }//end public function service_formShow */

 /**
  * Form zum anschauen einer Nachricht
  * @param LibRequestHttp $request
  * @param LibResponseHttp $response
  * @return boolean
  */
  public function service_showMailContent($request, $response )
  {

    // prüfen ob irgendwelche steuerflags übergeben wurde
    $params  = $this->getFlags($request);

    $msgId = $request->param('objid', Validator::EID );

    /* @var $model WebfrapMessage_Model */
    $model = $this->loadModel( 'WebfrapMessage' );
    $model->loadTableAccess($params );

    if (!$model->access->access) {
      throw new InvalidRequest_Exception
      (
        Response::FORBIDDEN_MSG,
        Response::FORBIDDEN
      );
    }

    $model->loadMessage($msgId );

    // create a window
    $view   = $response->loadView
    (
      'form-messages-show-'.$msgId,
      'WebfrapMessage',
      'displayContent',
      View::HTML
    );
    $view->setModel($this->loadModel( 'WebfrapMessage' ) );

    $view->displayContent($params );

  }//end public function service_showMailContent */

  /**
   * Standard Service für Autoloadelemente wie zb. Window Inputfelder
   * Über diesen Service kann analog zu dem Selection / Search Service
   * Eine gefilterte Liste angefragt werden um Zuweisungen zu vereinfachen
   *
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_loadUser($request, $response )
  {

    // resource laden
    $user     = $this->getUser();
    $acl      = $this->getAcl();


    // load request parameters an interpret as flags
    $params = $this->getFlags($request);

    // der contextKey wird benötigt um potentielle Konflikte in der UI
    // bei der Anzeige von mehreren Windows oder Tabs zu vermeiden
    $params->contextKey = 'message-user-autocomplete';

    $view  = $response->loadView
    (
      'message-user-ajax',
      'WebfrapMessage',
      'displayUserAutocomplete',
      View::AJAX
    );
    /* @var $model Example_Model */
    $model  = $this->loadModel( 'WebfrapMessage' );
    //$model->setAccess($access );
    $view->setModel($model );

    $searchKey  = $this->request->param('key', Validator::TEXT );

    $view->displayUserAutocomplete($searchKey, $params );


  }//end public function service_loadUser */

  /**
   * Standard Service für Autoloadelemente wie zb. Window Inputfelder
   * Über diesen Service kann analog zu dem Selection / Search Service
   * Eine gefilterte Liste angefragt werden um Zuweisungen zu vereinfachen
   *
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_deleteMessage($request, $response )
  {

    // resource laden
    $user       = $this->getUser();
    $acl        = $this->getAcl();
    $tpl        = $this->getTpl();
    $resContext = $response->createContext();

    // load request parameters an interpret as flags
    $params = $this->getFlags($request);

    $messageId  = $request->param('objid', Validator::EID );

    $resContext->assertNotNull
    (
      'Missing the Message ID',
      $messageId
    );

    if ($resContext->hasError )
      throw new InvalidRequest_Exception();

    /* @var $model WebfrapMessage_Model */
    $model  = $this->loadModel( 'WebfrapMessage' );

    $model->deleteMessage($messageId );

    //wgt-table-my_message_row_
    $tpl->addJsCode( <<<JS

    \$S('#wgt-table-my_message_row_{$messageId}').remove();

JS
    );

  }//end public function service_deleteMessage */

  /**
   * Standard Service für Autoloadelemente wie zb. Window Inputfelder
   * Über diesen Service kann analog zu dem Selection / Search Service
   * Eine gefilterte Liste angefragt werden um Zuweisungen zu vereinfachen
   *
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_deleteAll($request, $response )
  {

    // resource laden
    $user       = $this->getUser();
    $acl        = $this->getAcl();
    $tpl        = $this->getTpl();

    if ($resContext->hasError )
      throw new InvalidRequest_Exception();

    /* @var $model WebfrapMessage_Model */
    $model  = $this->loadModel( 'WebfrapMessage' );

    $model->deleteAllMessage();

    //wgt-table-my_message_row_
    $tpl->addJsCode( <<<JS

    \$S('table#wgt-table-my_message-table tbody').html('');

JS
    );

  }//end public function service_deleteAll */

  /**
   * Standard Service für Autoloadelemente wie zb. Window Inputfelder
   * Über diesen Service kann analog zu dem Selection / Search Service
   * Eine gefilterte Liste angefragt werden um Zuweisungen zu vereinfachen
   *
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_deleteSelection($request, $response )
  {

    // resource laden
    $user       = $this->getUser();
    $acl        = $this->getAcl();
    $tpl        = $this->getTpl();

    // load request parameters an interpret as flags
    $params = $this->getFlags($request);

    $msgIds = $request->param( 'slct', Validator::EID );

    /* @var $model WebfrapMessage_Model */
    $model  = $this->loadModel( 'WebfrapMessage' );
    $model->deleteSelection( $msgIds );

    $entries = array();

    foreach( $msgIds as $msgId ){
      $entries[] = "#wgt-table-my_message_row_".$msgId;
    }

    $jsCode = "\$S('".implode(', ',$entries)."').remove();";

    $tpl->addJsCode( $jsCode );

  }//end public function service_deleteSelection */


  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_sendUserMessage($request, $response )
  {
    // refid
    $refId   = $request->param('ref_id', Validator::EID );
    $dataSrc = $request->param('d_src', Validator::CNAME );


    $userId  = $request->data( 'receiver', Validator::EID );

    /* @var $model WebfrapContactForm_Model */
    $model = $this->loadModel( 'WebfrapMessage' );

    $mgsData = new TDataObject();
    $mgsData->subject = $request->data( 'subject', Validator::TEXT );
    $tmpChannels = $request->data( 'channels', Validator::CKEY );
    $chanels = array();

    foreach( $tmpChannels as $tmpCh ){
      if($tmpCh)
        $chanels[] = $tmpCh;
    }

    $mgsData->channels = $chanels;

    $mgsData->confidentiality = $request->data( 'id_confidentiality', Validator::INT );
    $mgsData->importance = $request->data( 'importance', Validator::INT );
    $mgsData->message = $request->data( 'message', Validator::HTML );

    $model->sendUserMessage($userId, $dataSrc, $refId, $mgsData );

  }//end public function service_sendUserMessage */

 /**
  * Form zum anschauen einer Nachricht
  * @param LibRequestHttp $request
  * @param LibResponseHttp $response
  * @return boolean
  */
  public function service_formForward($request, $response )
  {

    // prüfen ob irgendwelche steuerflags übergeben wurde
    $params  = $this->getFlags($request);

    $msgId = $request->param('objid', Validator::EID );

    /* @var $model WebfrapMessage_Model */
    $model = $this->loadModel( 'WebfrapMessage' );
    $model->loadTableAccess($params );

    if (!$model->access->access) {
      throw new InvalidRequest_Exception
      (
        'Access denied',
        Response::FORBIDDEN
      );
    }

    $model->loadMessage($msgId );

    // create a window
    $view   = $response->loadView
    (
      'form-messages-forward-'.$msgId,
      'WebfrapMessage_Forward',
      'displayForm'
    );
    $view->setModel($this->loadModel( 'WebfrapMessage' ) );

    $view->displayForm($params );

  }//end public function service_formForward */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_sendForward($request, $response )
  {

    // prüfen ob irgendwelche steuerflags übergeben wurde
    $params  = $this->getFlags($request);

    $msgId = $request->param('objid', Validator::EID );

    /* @var $model WebfrapMessage_Model */
    $model = $this->loadModel( 'WebfrapMessage' );
    $model->loadTableAccess($params );

    if (!$model->access->access) {
      throw new InvalidRequest_Exception
      (
        'Access denied',
        Response::FORBIDDEN
      );
    }

    $msgNode = $model->loadMessage($msgId );


    $userId  = $request->data( 'receiver', Validator::EID );

    $mgsData = new TDataObject();
    $mgsData->subject = 'Fwd: '.$msgNode->subject;
    $mgsData->message = $msgNode->content;
    $mgsData->channels = $request->data( 'channels', Validator::CKEY );
    $mgsData->confidentiality = $request->data( 'id_confidentiality', Validator::INT );
    $mgsData->importance = $request->data( 'importance', Validator::INT );

    $model->sendUserMessage($userId, null, null, $mgsData );

  }//end public function service_sendForward */

 /**
  * Form zum anschauen einer Nachricht
  * @param LibRequestHttp $request
  * @param LibResponseHttp $response
  * @return boolean
  */
  public function service_formReply($request, $response )
  {

    // prüfen ob irgendwelche steuerflags übergeben wurde
    $params  = $this->getFlags($request);

    $msgId = $request->param('objid', Validator::EID );

    /* @var $model WebfrapMessage_Model */
    $model = $this->loadModel( 'WebfrapMessage' );
    $model->loadTableAccess($params );

    if (!$model->access->access) {
      throw new InvalidRequest_Exception
      (
        Response::FORBIDDEN_MSG,
        Response::FORBIDDEN
      );
    }

    $model->loadMessage($msgId );

    // create a window
    $view   = $response->loadView
    (
      'form-messages-reply-'.$msgId,
      'WebfrapMessage_Reply',
      'displayForm'
    );
    $view->setModel($this->loadModel( 'WebfrapMessage' ) );

    $view->displayForm($params );

  }//end public function service_formReply */


  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_sendReply($request, $response )
  {

    // prüfen ob irgendwelche steuerflags übergeben wurde
    $params  = $this->getFlags($request);

    $msgId = $request->param('objid', Validator::EID );

    /* @var $model WebfrapMessage_Model */
    $model = $this->loadModel( 'WebfrapMessage' );
    $model->loadTableAccess($params );

    if (!$model->access->access) {
      throw new InvalidRequest_Exception
      (
        'Access denied',
        Response::FORBIDDEN
      );
    }


    $receiverId  = $request->data( 'receiver', Validator::EID );

    /* @var $model WebfrapContactForm_Model */
    $model = $this->loadModel( 'WebfrapMessage' );

    $msgData = new TDataObject();
    $msgData->subject = $request->data( 'subject', Validator::TEXT );
    $msgData->channels = $request->data( 'channels', Validator::CKEY );
    $msgData->confidentiality = $request->data( 'id_confidentiality', Validator::INT );
    $msgData->importance = $request->data( 'importance', Validator::INT );
    $msgData->message = $request->data( 'message', Validator::HTML );
    $msgData->id_refer = $msgId;

    $model->sendUserMessage($receiverId, null, null, $msgData );

  }//end public function service_sendUserMessage */

} // end class MaintenanceEntity_Controller
