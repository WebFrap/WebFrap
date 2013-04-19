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
 * @subpackage Daidalos
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class DaidalosBdl_Mvcbase_Permission_Controller extends Controller
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

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
    'create' => array
    (
      'method'    => array('GET'),
      'views'      => array('maintab')
    ),
    'edit' => array
    (
      'method'    => array('GET'),
      'views'      => array('maintab')
    ),
    'insert' => array
    (
      'method'    => array('POST'),
      'views'      => array('ajax')
    ),
    'update' => array
    (
      'method'    => array('PUT'),
      'views'      => array('ajax')
    ),
    'delete' => array
    (
      'method'    => array('DELETE'),
      'views'      => array('ajax')
    ),

    'createref' => array
    (
      'method'    => array('GET'),
      'views'      => array('maintab')
    ),
    'editref' => array
    (
      'method'    => array('GET'),
      'views'      => array('maintab')
    ),
    'insertref' => array
    (
      'method'    => array('POST'),
      'views'      => array('ajax')
    ),
    'updateref' => array
    (
      'method'    => array('PUT'),
      'views'      => array('ajax')
    ),
    'deleteref' => array
    (
      'method'    => array('DELETE'),
      'views'      => array('ajax')
    ),
  );

  /**
   * Der domainkey
   * eg: profile
   * @var string
   */
  public $domainKey = null;

  /**
   * Domain Class Part
   * eg: Profile
   * @var string
   */
  public $domainClass = null;

/*//////////////////////////////////////////////////////////////////////////////
// Default Permissions
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_create($request, $response)
  {

    $params = $this->getFlags($request);

    $key   = $request->param('key', Validator::CKEY);
    $file  = $request->param('bdl_file', Validator::TEXT);

    $model  = $this->loadModel('DaidalosBdlModeller');
    $model->setKey($key);
    $model->loadFile($file);

    $nodeModel = $this->loadModel('DaidalosBdlNode_'.$this->domainClass.'Permission');
    /* @var $nodeModel DaidalosBdl_Mvcbase_Permission_Model */
    $nodeModel->modeller = $model;
    $nodeModel->loadParentNode();

    $view   = $response->loadView
    (
      'daidalos_repo-'.$this->domainKey.'-permission-create-'.md5($file),
      'DaidalosBdlNode_'.$this->domainClass.'Permission_Create',
      'displayCreate',
      View::MAINTAB
    );

    $view->setModel($nodeModel);

    $view->displayCreate($params);

  }//end public function service_create */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_edit($request, $response)
  {

    $params = $this->getFlags($request);

    $key   = $request->param('key', Validator::CKEY);
    $file  = $request->param('bdl_file', Validator::TEXT);
    $idx   = $request->param('idx', Validator::INT);

    $model  = $this->loadModel('DaidalosBdlModeller');
    $model->setKey($key);
    $model->loadFile($file);

    $nodeModel = $this->loadModel('DaidalosBdlNode_'.$this->domainClass.'Permission');
    /* @var $nodeModel DaidalosBdl_Mvcbase_Permission_Model */
    $nodeModel->loadBdlPermission($model, $idx);

    $view   = $response->loadView
    (
      'daidalos_repo-'.$this->domainKey.'-permission-edit-'.md5($file).'-'.$idx,
      'DaidalosBdlNode_'.$this->domainClass.'Permission_Edit',
      'displayEdit',
      View::MAINTAB
    );

    $view->setModel($nodeModel);

    $view->displayEdit($idx, $params);

  }//end public function service_edit */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_insert($request, $response)
  {

    $params = $this->getFlags($request);

    $key   = $request->param('key', Validator::CKEY);
    $file  = $request->param('bdl_file', Validator::TEXT);

    $model  = $this->loadModel('DaidalosBdlModeller');
    $model->setKey($key);
    $model->loadFile($file);

    $nodeModel = $this->loadModel('DaidalosBdlNode_'.$this->domainClass.'Permission');
    /* @var $nodeModel DaidalosBdlNode_Mvcbase_Permission_Model */
    $nodeModel->modeller = $model;

    $permission = $nodeModel->insertByRequest($request, $response);

    $view   = $response->loadView
    (
      'daidalos_repo-'.$this->domainKey.'-permission-insert-'.md5($file),
      'DaidalosBdlNode_'.$this->domainClass.'Permission',
      'displayInsert',
      View::AJAX
    );
    /* @var $view DaidalosBdlNode_Mvcbase_Permission_Ajax_View */

    $view->setModel($nodeModel);

    $index = $nodeModel->getLastCreatedIndex();

    $view->displayInsert($permission, $index, $nodeModel->parentNode->getName());

    $response->addMessage("Successfully created new Permission");

  }//end public function service_insert */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_update($request, $response)
  {

    $params = $this->getFlags($request);

    $key   = $request->param('key', Validator::CKEY);
    $file  = $request->param('bdl_file', Validator::TEXT);
    $idx   = $request->param('idx', Validator::INT);

    $model  = $this->loadModel('DaidalosBdlModeller');
    $model->setKey($key);
    $model->loadFile($file);

    $nodeModel = $this->loadModel('DaidalosBdlNode_'.$this->domainClass.'Permission');
    /* @var $nodeModel DaidalosBdlNode_Mvcbase_Permission_Model */
    $nodeModel->loadBdlPermission($model, $idx);

    $permission = $nodeModel->updateByRequest($request, $response);

    $view   = $response->loadView
    (
      'daidalos_repo-'.$this->domainKey.'-permission-update-'.md5($file),
      'DaidalosBdlNode_'.$this->domainClass.'Permission',
      'displayUpdate',
      View::AJAX
    );
    /* @var $view DaidalosBdlNode_Mvcbase_Permission_Ajax_View */

    $view->setModel($nodeModel);

    $view->displayUpdate($permission, $idx, $nodeModel->parentNode->getName());

    $response->addMessage("Successfully updated Permission ".$idx);

  }//end public function service_update */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_delete($request, $response)
  {

    $params = $this->getFlags($request);

    $key   = $request->param('key', Validator::CKEY);
    $file  = $request->param('bdl_file', Validator::TEXT);
    $idx   = $request->param('idx', Validator::INT);

    $model  = $this->loadModel('DaidalosBdlModeller');
    $model->setKey($key);
    $model->loadFile($file);

    $nodeModel = $this->loadModel('DaidalosBdlNode_'.$this->domainClass.'Permission');
    /* @var $nodeModel DaidalosBdlNode_Mvcbase_Permission_Model */
    $nodeModel->modeller = $model;

    $nodeModel->deleteByIndex($idx);

    $view   = $response->loadView
    (
      'daidalos_repo-'.$this->domainKey.'-permission-delete-'.md5($file),
      'DaidalosBdlNode_'.$this->domainClass.'Permission',
      'displayDelete',
      View::AJAX
    );
    /* @var $view DaidalosBdlNode_Mvcbase_Permission_Ajax_View */

    $view->setModel($nodeModel);

    $view->displayDelete($idx, $nodeModel->parentNode->getName());

    $response->addMessage("Successfully dropped permission");

  }//end public function service_delete */

/*//////////////////////////////////////////////////////////////////////////////
// Permission References
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_createRef($request, $response)
  {

    $params = $this->getFlags($request);

    $key   = $request->param('key', Validator::CKEY);
    $file  = $request->param('bdl_file', Validator::TEXT);
    $path  = $request->param('path', Validator::TEXT);

    $model  = $this->loadModel('DaidalosBdlModeller');
    $model->setKey($key);
    $model->loadFile($file);

    $nodeModel = $this->loadModel('DaidalosBdlNode_'.$this->domainClass.'Permission');
    $nodeModel->modeller = $model;

    $view   = $response->loadView
    (
      'daidalos_repo-'.$this->domainKey.'-permission-ref-create-'.md5($file),
      'DaidalosBdlNode_'.$this->domainClass.'PermissionRef_Create',
      'displayCreate',
      View::MAINTAB
    );

    $view->setModel($nodeModel);

    $view->displayCreate($path, $params);

  }//end public function service_createRef */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_editRef($request, $response)
  {

    $params = $this->getFlags($request);

    $key   = $request->param('key', Validator::CKEY);
    $file  = $request->param('bdl_file', Validator::TEXT);
    $path  = $request->param('path', Validator::TEXT);

    $pathId = str_replace('.', '-', $path);

    $model  = $this->loadModel('DaidalosBdlModeller');
    $model->setKey($key);
    $model->loadFile($file);

    $nodeModel = $this->loadModel('DaidalosBdlNode_'.$this->domainClass.'Permission');
    /* @var $nodeModel DaidalosBdlNode_Mvcbase_Permission_Model */
    $nodeModel->loadBdlPermissionRef($model, $path);

    $view   = $response->loadView
    (
      'daidalos_repo-'.$this->domainKey.'-perm-ref-edit-'.md5($file).'-'.$pathId,
      'DaidalosBdlNode_'.$this->domainClass.'PermissionRef_Edit',
      'displayEdit',
      View::MAINTAB
    );
    /* @var $view DaidalosBdlNode_Mvcbase_PermissionRef_Edit_Maintab_View */

    $view->setModel($nodeModel);

    $view->displayEdit($path, $params);

  }//end public function service_editRef */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_insertRef($request, $response)
  {

    $params = $this->getFlags($request);

    $key   = $request->param('key', Validator::CKEY);
    $file  = $request->param('bdl_file', Validator::TEXT);
    $path  = $request->param('path', Validator::TEXT);

    $model  = $this->loadModel('DaidalosBdlModeller');
    $model->setKey($key);
    $model->loadFile($file);

    $nodeModel = $this->loadModel('DaidalosBdlNode_'.$this->domainClass.'Permission');
    /* @var $nodeModel DaidalosBdlNode_Mvcbase_Permission_Model */
    $nodeModel->modeller = $model;

    $permission = $nodeModel->insertRefByRequest($path, $request, $response);

    $view   = $response->loadView
    (
      'daidalos_repo-'.$this->domainKey.'-permission-insert-'.md5($file),
      'DaidalosBdlNode_'.$this->domainClass.'PermissionRef',
      'displayInsert',
      View::AJAX
    );
    /* @var $view DaidalosBdlNode_Mvcbase_PermissionRef_Ajax_View */

    $view->setModel($nodeModel);

    $index = $nodeModel->getLastCreatedRefIndex($path);

    $view->displayInsert($permission, $path, $index, $nodeModel->parentNode->getName());

    $response->addMessage("Successfully created new Permission Reference");

  }//end public function service_insertRef */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_updateRef($request, $response)
  {

    $params = $this->getFlags($request);

    $key   = $request->param('key', Validator::CKEY);
    $file  = $request->param('bdl_file', Validator::TEXT);
    $path  = $request->param('path', Validator::TEXT);

    $pathId = str_replace('.', '-', $path);

    $model  = $this->loadModel('DaidalosBdlModeller');
    $model->setKey($key);
    $model->loadFile($file);

    $nodeModel = $this->loadModel('DaidalosBdlNode_'.$this->domainClass.'Permission');
    /* @var $nodeModel DaidalosBdlNode_Mvcbase_Permission_Model */
    $nodeModel->loadBdlPermissionRef($model, $path);

    $permission = $nodeModel->updateRefByRequest($path, $request, $response);

    $view   = $response->loadView
    (
      'daidalos_repo-'.$this->domainKey.'-permission-update-'.md5($file).'-ref-'.$pathId,
      'DaidalosBdlNode_'.$this->domainClass.'PermissionRef',
      'displayUpdate',
      View::AJAX
    );
    /* @var $view DaidalosBdlNode_Mvcbase_Permission_Ajax_View */

    $view->setModel($nodeModel);

    $view->displayUpdate($permission, $path, $nodeModel->parentNode->getName());

    $response->addMessage("Successfully created new Permission");

  }//end public function service_updateRef */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_deleteRef($request, $response)
  {

    $params = $this->getFlags($request);

    $key   = $request->param('key', Validator::CKEY);
    $file  = $request->param('bdl_file', Validator::TEXT);
    $path  = $request->param('path', Validator::TEXT);

    $model  = $this->loadModel('DaidalosBdlModeller');
    $model->setKey($key);
    $model->loadFile($file);

    $nodeModel = $this->loadModel('DaidalosBdlNode_'.$this->domainClass.'Permission');
    /* @var $nodeModel DaidalosBdlNode_Mvcbase_Permission_Model */
    $nodeModel->modeller = $model;

    $nodeModel->deleteRefByIndex($path);

    $view   = $response->loadView
    (
      'daidalos_repo-'.$this->domainKey.'-permission-delete-'.md5($file),
      'DaidalosBdlNode_'.$this->domainClass.'PermissionRef',
      'displayDelete',
      View::AJAX
    );
    /* @var $view DaidalosBdlNode_Mvcbase_PermissionRef_Ajax_View */

    $view->setModel($nodeModel);

    $view->displayDelete($path, $nodeModel->parentNode->getName());

    $response->addMessage("Successfully dropped permission");

  }//end public function service_deleteRef */

} // end class DaidalosBdlNode_Mvcbase_Controller

