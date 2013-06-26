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
class WebfrapCalendar_Controller extends Controller
{
/*//////////////////////////////////////////////////////////////////////////////
// methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var array
   */
  protected $options = array(

    'search' => array(
      'method'    => array('GET'),
      'views'      => array('ajax')
    ),

    'element' => array(
        'method'    => array('GET'),
        'views'      => array('modal', 'maintab')
    ),

    // message logic
    'formnew' => array(
      'method'    => array('GET'),
      'views'      => array('modal', 'maintab')
    ),

    'formshow' => array(
      'method'    => array('GET'),
      'views'      => array('modal', 'maintab')
    ),

    'showmailcontent' => array(
      'method'    => array('GET'),
      'views'      => array('html')
    ),

    'showpreview' => array(
      'method'    => array('GET'),
      'views'      => array('ajax')
    ),

    'sendusermessage' => array(
      'method'    => array('POST'),
      'views'      => array('ajax')
    ),

    'loaduser' => array(
      'method'    => array('GET'),
      'views'      => array('ajax')
    ),

    'savemessage' => array(
      'method'    => array('PUT'),
      'views'      => array('ajax')
    ),

    // form forward
    'formforward' => array(
      'method'    => array('GET'),
      'views'      => array('modal', 'maintab')
    ),

    'sendforward' => array(
      'method'    => array('POST'),
      'views'      => array('ajax')
    ),

    // form reply
    'formreply' => array(
      'method'    => array('GET'),
      'views'      => array('modal', 'maintab')
    ),

    'sendreply' => array(
      'method'    => array('POST'),
      'views'      => array('ajax')
    ),

    // delete
    'deletemessage' => array(
      'method'    => array('DELETE'),
      'views'      => array('ajax')
    ),
    'deleteall' => array(
      'method'    => array('DELETE'),
      'views'      => array('ajax')
    ),
    'deleteselection' => array(
      'method'    => array('DELETE'),
      'views'      => array('ajax')
    ),

    // archive
    'archivemessage' => array(
      'method'    => array('PUT'),
      'views'      => array('ajax')
    ),
    'archiveall' => array(
      'method'    => array('PUT'),
      'views'      => array('ajax')
    ),
    'archiveselection' => array(
      'method'    => array('PUT'),
      'views'      => array('ajax')
    ),

    // reopen einen archivierten Datensatz wieder öffnen
    'reopen' => array(
      'method'    => array('PUT'),
      'views'      => array('ajax')
    ),

    // spam / ham
    'setspam' => array(
      'method'    => array('PUT'),
      'views'      => array('ajax')
    ),

    // nachricht als gelesen markieren
    'markread' => array(
        'method'    => array('PUT'),
        'views'      => array('ajax')
    ),
    'markreadall' => array(
        'method'    => array('PUT'),
        'views'      => array('ajax')
    ),
    'markreadselection' => array(
        'method'    => array('PUT'),
        'views'      => array('ajax')
    ),

    // references
    'addref' => array(
      'method'    => array('PUT'),
      'views'      => array('ajax')
    ),
    'delref' => array(
      'method'    => array('DELETE'),
      'views'      => array('ajax')
    ),

  );

/*//////////////////////////////////////////////////////////////////////////////
// methodes
//////////////////////////////////////////////////////////////////////////////*/

 /**
  * @param LibRequestHttp $request
  * @param LibResponseHttp $response
  * @return boolean
  */
  public function service_search($request, $response)
  {


    /* @var $model WebfrapCalendar_Model  */
    $model = $this->loadModel('WebfrapCalendar');

    // prüfen ob irgendwelche steuerflags übergeben wurde
    $params  = new WebfrapCalendar_Search_Request($request );

    $model->loadTableAccess($params);

    if (!$model->access->listing) {
      throw new InvalidRequest_Exception(
        Response::FORBIDDEN_MSG,
        Response::FORBIDDEN
      );
    }

    // load the view object
    /* @var $view WebfrapCalendar_Ajax_View */
    $view = $response->loadView(
      'list-calendar_list',
      'WebfrapCalendar',
      'displaySearch',
      View::AJAX
    );

    $view->setModel($model);

    $model->params = $params;

    $view->displaySearch($params);

  }//end public function service_search */

  /**
   * Form zum erstellen einer neuen Message
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return boolean
   */
  public function service_element($request, $response)
  {

    // prüfen ob irgendwelche steuerflags übergeben wurde
    $params  = $this->getFlags($request);

    $model = $this->loadModel('WebfrapCalendar');
    $model->loadTableAccess($params);

    if (!$model->access->listing) {
      throw new InvalidRequest_Exception(
          Response::FORBIDDEN_MSG,
          Response::FORBIDDEN
      );
    }

    // load the view object
    $view   = $response->loadView(
      'webfrap-groupware-list',
      'WebfrapCalendar_Element',
      'displayElement'
    );

    // request bearbeiten
    /* @var $model WebfrapCalendar_Model */
    $model = $this->loadModel('WebfrapCalendar');
    $view->setModel($model);

    $view->displayElement($params);

  }//end public function service_element */





 /**
  * Form zum erstellen einer neuen Message
  * @param LibRequestHttp $request
  * @param LibResponseHttp $response
  * @return boolean
  */
  public function service_formNew($request, $response)
  {

    // prüfen ob irgendwelche steuerflags übergeben wurde
    $params  = $this->getFlags($request);

    $model = $this->loadModel('WebfrapCalendar');
    $model->loadTableAccess($params);

    if (!$model->access->listing) {
      throw new InvalidRequest_Exception(
        Response::FORBIDDEN_MSG,
        Response::FORBIDDEN
      );
    }

    // load the view object
    $view   = $response->loadView(
      'form-messages-new',
      'WebfrapCalendar_New',
      'displayNew'
    );

    // request bearbeiten
    /* @var $model WebfrapCalendar_Model */
    $model = $this->loadModel('WebfrapCalendar');
    $view->setModel($model);

    $view->displayNew($params);

  }//end public function service_formNew */

 /**
  * Form zum anschauen einer Nachricht
  * @param LibRequestHttp $request
  * @param LibResponseHttp $response
  * @return boolean
  */
  public function service_formShow($request, $response)
  {

    // prüfen ob irgendwelche steuerflags übergeben wurde
    $params  = $this->getFlags($request);

    $msgId = $request->param('objid', Validator::EID);

    /* @var $model WebfrapCalendar_Model */
    $model = $this->loadModel('WebfrapCalendar');
    $model->loadTableAccess($params);

    if (!$model->access->access) {
      throw new InvalidRequest_Exception(
        Response::FORBIDDEN_MSG,
        Response::FORBIDDEN
      );
    }

    $message = $model->loadMessage($msgId);

    $user = $this->getUser();

    if ($message->id_receiver == $user->getId()) {
      if ($message->id_receiver_status == EMessageStatus::IS_NEW) {
        $orm = $this->getOrm();
        $orm->update('WbfsysMessage', $message->msg_id, array('id_receiver_status' => EMessageStatus::OPEN));
      }
    }

    // load the view object
    $view = $response->loadView(
      'form-messages-show-'.$msgId,
      'WebfrapCalendar_Show',
      'displayShow'
    );
    $view->setModel($model);

    $view->displayShow($params);

  }//end public function service_formShow */

 /**
  * Form zum anschauen einer Nachricht
  * @param LibRequestHttp $request
  * @param LibResponseHttp $response
  * @return boolean
  */
  public function service_showMailContent($request, $response)
  {

    // prüfen ob irgendwelche steuerflags übergeben wurde
    $params  = $this->getFlags($request);

    $msgId = $request->param('objid', Validator::EID);

    /* @var $model WebfrapCalendar_Model */
    $model = $this->loadModel('WebfrapCalendar');
    $model->loadTableAccess($params);

    if (!$model->access->access) {
      throw new InvalidRequest_Exception(
        Response::FORBIDDEN_MSG,
        Response::FORBIDDEN
      );
    }

    $model->loadMessage($msgId);

    // load the view object
    $view   = $response->loadView(
      'form-messages-show-'.$msgId,
      'WebfrapCalendar',
      'displayContent',
      View::HTML
    );
    $view->setModel($model);

    $view->displayContent($params);

  }//end public function service_showMailContent */


  /**
   * Form zum anschauen einer Nachricht
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return boolean
   */
  public function service_showPreview($request, $response)
  {

    // prüfen ob irgendwelche steuerflags übergeben wurde
    $params  = $this->getFlags($request);

    $msgId = $request->param('objid', Validator::EID);

    /* @var $model WebfrapCalendar_Model */
    $model = $this->loadModel('WebfrapCalendar');
    $model->loadTableAccess($params);

    if (!$model->access->access) {
      throw new InvalidRequest_Exception(
          Response::FORBIDDEN_MSG,
          Response::FORBIDDEN
      );
    }

    $msgNode = $model->loadMessage($msgId);

    // load the view object
    /* @var $view WebfrapCalendar_Ajax_View */
    $view   = $response->loadView(
        'messages-preview-'.$msgId,
        'WebfrapCalendar',
        'displayMsgPreview'
    );
    $view->setModel($model);

    $view->displayMsgPreview($msgNode);

  }//end public function service_showPreview */




  /**
   *
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_saveMessage($request, $response)
  {

    // resource laden
    $user     = $this->getUser();
    $acl      = $this->getAcl();


    // load request parameters an interpret as flags
    $rqtData = new WebfrapCalendar_Save_Request($request);
    $msgId = $request->param('objid',Validator::EID);

  	/* @var $model WebfrapCalendar_Model */
    $model = $this->loadModel('WebfrapCalendar');
    $model->loadTableAccess($rqtData);

    if (!$model->access->access) {
      throw new InvalidRequest_Exception(
        'Access denied',
        Response::FORBIDDEN
      );
    }

    $model->saveMessage($msgId, $rqtData);

  }//end public function service_saveMessage */

  /**
   *
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_setSpam($request, $response)
  {

    // resource laden
    $user     = $this->getUser();
    $acl      = $this->getAcl();

    // load request parameters an interpret as flags
    $rqtData = $this->getFlags($request);
    $msgId = $request->param('objid',Validator::EID);
    $flagSpam = $request->param('spam',Validator::INT);

  	/* @var $model WebfrapCalendar_Model */
    $model = $this->loadModel('WebfrapCalendar');
    $model->loadTableAccess($rqtData);

    if (!$model->access->access) {
      throw new InvalidRequest_Exception(
        'Access denied',
        Response::FORBIDDEN
      );
    }

    if( 100 == $flagSpam) {
      //wenn spam dann löschen
      $this->getTpl()->addJsCode(<<<JS

    \$S('#wgt-table-webfrap-groupware_message_row_{$msgId}').remove();

JS
      );
    }

    $model->setSpam($msgId, $flagSpam, $rqtData);

  }//end public function service_saveMessage */

  /**
   *
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_deleteMessage($request, $response)
  {

    // resource laden
    $user       = $this->getUser();
    $acl        = $this->getAcl();
    $tpl        = $this->getTpl();
    $resContext = $response->createContext();

    // load request parameters an interpret as flags
    $params = $this->getFlags($request);

    $messageId  = $request->param('objid', Validator::EID);

    $resContext->assertNotNull(
      'Missing the Message ID',
      $messageId
    );

    if ($resContext->hasError)
      throw new InvalidRequest_Exception();

    /* @var $model WebfrapCalendar_Model */
    $model  = $this->loadModel('WebfrapCalendar');

    $model->deleteMessage($messageId);

    //wgt-table-webfrap-groupware_message_row_
    $tpl->addJsCode(<<<JS
    \$S('#wgt-table-webfrap-groupware_message_row_{$messageId}').remove();
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
  public function service_deleteAll($request, $response)
  {

    // resource laden
    $user       = $this->getUser();
    $acl        = $this->getAcl();
    $tpl        = $this->getTpl();

    if ($resContext->hasError)
      throw new InvalidRequest_Exception();

    /* @var $model WebfrapCalendar_Model */
    $model  = $this->loadModel('WebfrapCalendar');

    $model->deleteAllMessage();

    //wgt-table-webfrap-groupware_message_row_
    $tpl->addJsCode(<<<JS

    \$S('table#wgt-table-webfrap-groupware_message-table tbody').html('');

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
  public function service_deleteSelection($request, $response)
  {

    // resource laden
    $user       = $this->getUser();
    $acl        = $this->getAcl();
    $tpl        = $this->getTpl();

    // load request parameters an interpret as flags
    $params = $this->getFlags($request);

    $msgIds = $request->param('slct', Validator::EID);

    /* @var $model WebfrapCalendar_Model */
    $model  = $this->loadModel('WebfrapCalendar');
    $model->deleteSelection($msgIds);

    $entries = array();

    foreach ($msgIds as $msgId) {
      $entries[] = "#wgt-table-webfrap-groupware_message_row_".$msgId;
    }

    $jsCode = "\$S('".implode(', ',$entries)."').remove();";

    $tpl->addJsCode($jsCode);

  }//end public function service_deleteSelection */


  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_sendUserMessage($request, $response)
  {
    // refid
    $refId   = $request->param('ref_id', Validator::EID);
    $dataSrc = $request->param('d_src', Validator::CNAME);


    $userId  = $request->data('receiver', Validator::EID);

    /* @var $model WebfrapContactForm_Model */
    $model = $this->loadModel('WebfrapCalendar');

    $mgsData = new TDataObject();
    $mgsData->subject = $request->data('subject', Validator::TEXT);
    $tmpChannels = $request->data('channels', Validator::CKEY);
    $chanels = array();

    foreach ($tmpChannels as $tmpCh) {
      if ($tmpCh)
        $chanels[] = $tmpCh;
    }

    $mgsData->channels = $chanels;

    $mgsData->confidential = $request->data('confidential', Validator::INT);
    $mgsData->importance = $request->data('importance', Validator::INT);
    $mgsData->message = $request->data('message', Validator::HTML);

    $model->sendUserMessage($userId, $dataSrc, $refId, $mgsData);

  }//end public function service_sendUserMessage */

 /**
  * Form zum anschauen einer Nachricht
  * @param LibRequestHttp $request
  * @param LibResponseHttp $response
  * @return boolean
  */
  public function service_formForward($request, $response)
  {

    // prüfen ob irgendwelche steuerflags übergeben wurde
    $params  = $this->getFlags($request);

    $msgId = $request->param('objid', Validator::EID);

    /* @var $model WebfrapCalendar_Model */
    $model = $this->loadModel('WebfrapCalendar');
    $model->loadTableAccess($params);

    if (!$model->access->access) {
      throw new InvalidRequest_Exception
      (
        'Access denied',
        Response::FORBIDDEN
      );
    }

    $model->loadMessage($msgId);

    // load the view object
    $view   = $response->loadView
    (
      'form-messages-forward-'.$msgId,
      'WebfrapCalendar_Forward',
      'displayForm'
    );
    $view->setModel($this->loadModel('WebfrapCalendar'));

    $view->displayForm($params);

  }//end public function service_formForward */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_sendForward($request, $response)
  {

    // prüfen ob irgendwelche steuerflags übergeben wurde
    $params  = $this->getFlags($request);

    $msgId = $request->param('objid', Validator::EID);

    /* @var $model WebfrapCalendar_Model */
    $model = $this->loadModel('WebfrapCalendar');
    $model->loadTableAccess($params);

    if (!$model->access->access) {
      throw new InvalidRequest_Exception(
        'Access denied',
        Response::FORBIDDEN
      );
    }

    $msgNode = $model->loadMessage($msgId);


    $userId  = $request->data('receiver', Validator::EID);

    $mgsData = new TDataObject();
    $mgsData->subject = 'Fwd: '.$msgNode->subject;
    $mgsData->message = $msgNode->content;
    $mgsData->channels = $request->data('channels', Validator::CKEY);
    $mgsData->confidentiality = $request->data('id_confidentiality', Validator::INT);
    $mgsData->importance = $request->data('importance', Validator::INT);

    $model->sendUserMessage($userId, null, null, $mgsData);

  }//end public function service_sendForward */

 /**
  * Form zum anschauen einer Nachricht
  * @param LibRequestHttp $request
  * @param LibResponseHttp $response
  * @return boolean
  */
  public function service_formReply($request, $response)
  {

    // prüfen ob irgendwelche steuerflags übergeben wurde
    $params  = $this->getFlags($request);

    $msgId = $request->param('objid', Validator::EID);

    /* @var $model WebfrapCalendar_Model */
    $model = $this->loadModel('WebfrapCalendar');
    $model->loadTableAccess($params);

    if (!$model->access->access) {
      throw new InvalidRequest_Exception(
        Response::FORBIDDEN_MSG,
        Response::FORBIDDEN
      );
    }

    $model->loadMessage($msgId);

    // load the view object
    $view   = $response->loadView(
      'form-messages-reply-'.$msgId,
      'WebfrapCalendar_Reply',
      'displayForm'
     );
    $view->setModel($this->loadModel('WebfrapCalendar'));

    $view->displayForm($params);

  }//end public function service_formReply */


  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_sendReply($request, $response)
  {

    // prüfen ob irgendwelche steuerflags übergeben wurde
    $params  = $this->getFlags($request);

    $msgId = $request->param('objid', Validator::EID);

    /* @var $model WebfrapCalendar_Model */
    $model = $this->loadModel('WebfrapCalendar');
    $model->loadTableAccess($params);

    if (!$model->access->access) {
      throw new InvalidRequest_Exception(
        'Access denied',
        Response::FORBIDDEN
      );
    }


    $receiverId  = $request->data('receiver', Validator::EID);

    /* @var $model WebfrapContactForm_Model */
    $model = $this->loadModel('WebfrapCalendar');

    $msgData = new TDataObject();
    $msgData->subject = $request->data('subject', Validator::TEXT);
    $msgData->channels = $request->data('channels', Validator::CKEY);
    $msgData->confidentiality = $request->data('id_confidentiality', Validator::INT);
    $msgData->importance = $request->data('importance', Validator::INT);
    $msgData->message = $request->data('message', Validator::HTML);
    $msgData->id_refer = $msgId;

    $model->sendUserMessage($receiverId, null, null, $msgData);

  }//end public function service_sendUserMessage */

////////////////////////////////////////////////////////////////////////////////
// Reference
////////////////////////////////////////////////////////////////////////////////


  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_addRef($request, $response)
  {

    // prüfen ob irgendwelche steuerflags übergeben wurde
    $params  = $this->getFlags($request);

    $msgId = $request->param('msg', Validator::EID);
    $refId = $request->param('ref', Validator::EID);

    /* @var $model WebfrapCalendar_Model */
    $model = $this->loadModel('WebfrapCalendar');
    $model->loadTableAccess($params);

    if (!$model->access->access) {
      throw new InvalidRequest_Exception(
        'Access denied',
        Response::FORBIDDEN
      );
    }

    $linkId = $model->addRef($msgId,$refId);

    /* @var $view WebfrapCalendar_Ajax_View */
    $view   = $response->loadView(
      'message-update-ref',
      'WebfrapCalendar',
      'displayAddRef'
     );
    $view->setModel($model);

    $view->displayAddRef($linkId,$msgId);

  }//end public function service_addRef */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_delRef($request, $response)
  {

    // prüfen ob irgendwelche steuerflags übergeben wurde
    $params  = $this->getFlags($request);

    $delId = $request->param('delid', Validator::EID);

    /* @var $model WebfrapCalendar_Model */
    $model = $this->loadModel('WebfrapCalendar');
    $model->loadTableAccess($params);

    if (!$model->access->access) {
      throw new InvalidRequest_Exception(
        'Access denied',
        Response::FORBIDDEN
      );
    }

    $model->delRef($delId);

    /* @var $view WebfrapCalendar_Ajax_View */
    $view   = $response->loadView(
      'message-del-ref',
      'WebfrapCalendar',
      'displayDelRef'
     );
    $view->setModel($model);

    $view->displayDelRef($delId);

  }//end public function service_addRef */



} // end class WebfrapCalendar_Controller
