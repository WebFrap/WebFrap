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
class WebfrapSettings_Search_Controller extends Controller
{
/*//////////////////////////////////////////////////////////////////////////////
// methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var array
   */
  protected $options           = array(

    'refresh' => array(
      'method'    => array('GET'),
      'views'      => array('ajax')
    ),
    'insert' => array(
      'method'    => array('POST'),
      'views'      => array('ajax')
    ),
    'update' => array(
      'method'    => array('PUT'),
      'views'      => array('ajax')
    ),
    'delete' => array(
      'method'    => array('DELETE'),
      'views'      => array('ajax')
    ),

  );

/*//////////////////////////////////////////////////////////////////////////////
// methodes
//////////////////////////////////////////////////////////////////////////////*/


  /**
   *
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_insert($request, $response)
  {

    // resource laden
    $user     = $this->getUser();
    $acl      = $this->getAcl();


    // load request parameters an interpret as flags
    $rqtData = new WebfrapSettings_Search_Save_Request($request);



    /* @var $model WebfrapSettings_Search_Model */
    $model = $this->loadModel('WebfrapSettings_Search');
    $model->loadUserAccess($rqtData);

    if (!$model->access->access) {
      throw new InvalidRequest_Exception(
          'Access denied',
          Response::FORBIDDEN
      );
    }

    $model->saveMessage($msgId, $rqtData);

  }//end public function service_saveMessage */



 /**
  * create an new window with an edit form for the enterprise_company entity
  * @param LibRequestHttp $request
  * @param LibResponseHttp $response
  * @return boolean
  */
  public function service_refresh($request, $response)
  {


    /* @var $model WebfrapMessage_Model  */
    $model = $this->loadModel('WebfrapMessage');

    $userSettings = $model->loadSettings();

    // prüfen ob irgendwelche steuerflags übergeben wurde
    $params  = new WebfrapMessage_Table_Search_Request($request, $userSettings);

    if ($userSettings->changed)
      $model->saveSettings($userSettings);

    $model->loadTableAccess($params);

    if (!$model->access->listing) {
      throw new InvalidRequest_Exception(
        Response::FORBIDDEN_MSG,
        Response::FORBIDDEN
      );
    }

    // load the view object
    /* @var $view WebfrapMessage_List_Ajax_View */
    $view = $response->loadView(
      'list-message_list',
      'WebfrapMessage_List',
      'displaySearch',
      View::AJAX
    );

    $view->setModel($model);

    $model->params = $params;

    $view->displaySearch($params);

  }//end public function service_refresh */


  /**
   * Standard Service für Autoloadelemente wie zb. Window Inputfelder
   * Über diesen Service kann analog zu dem Selection / Search Service
   * Eine gefilterte Liste angefragt werden um Zuweisungen zu vereinfachen
   *
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_loadUser($request, $response)
  {

    // resource laden
    $user     = $this->getUser();
    $acl      = $this->getAcl();


    // load request parameters an interpret as flags
    $params = $this->getFlags($request);

    // der contextKey wird benötigt um potentielle Konflikte in der UI
    // bei der Anzeige von mehreren Windows oder Tabs zu vermeiden
    $params->contextKey = 'message-user-autocomplete';

    $view  = $response->loadView(
      'message-user-ajax',
      'WebfrapMessage',
      'displayUserAutocomplete',
      View::AJAX
    );
    /* @var $model Example_Model */
    $model  = $this->loadModel('WebfrapMessage');
    //$model->setAccess($access);
    $view->setModel($model);

    $searchKey  = $this->request->param('key', Validator::TEXT);

    $view->displayUserAutocomplete($searchKey, $params);


  }//end public function service_loadUser */




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

  	/* @var $model WebfrapMessage_Model */
    $model = $this->loadModel('WebfrapMessage');
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

    /* @var $model WebfrapMessage_Model */
    $model  = $this->loadModel('WebfrapMessage');

    $model->deleteMessage($messageId);

    //wgt-table-webfrap-groupware_message_row_
    $tpl->addJsCode(<<<JS
    \$S('#wgt-table-webfrap-groupware_message_row_{$messageId}').remove();
JS
    );

  }//end public function service_deleteMessage */


} // end class WebfrapMessage_Controller
