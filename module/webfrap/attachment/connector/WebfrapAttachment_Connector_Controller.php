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
 * @subpackage core_item\attachment
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class WebfrapAttachment_Connector_Controller extends Controller
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var array
   */
  protected $options           = array
  (
    'create' => array(
      'method'    => array('GET'),
      'views'      => array('modal')
    ),
    'addlink' => array(
      'method'    => array('POST'),
      'views'      => array('ajax')
    ),
    'savelink' => array(
      'method'    => array('PUT'),
      'views'      => array('ajax')
    ),
    'edit' => array(
      'method'    => array('GET'),
      'views'      => array('modal')
    ),
    'formaddstorage' => array(
      'method'    => array('GET'),
      'views'      => array('modal')
    ),
    'addstorage' => array(
      'method'    => array('POST'),
      'views'      => array('ajax')
    ),
    'editstorage' => array(
      'method'    => array('GET'),
      'views'      => array('modal')
    ),
    'savestorage' => array(
      'method'    => array('PUT'),
      'views'      => array('ajax')
    ),
    'deletestorage' => array(
      'method'    => array('DELETE'),
      'views'      => array('ajax')
    ),
  );

/*//////////////////////////////////////////////////////////////////////////////
// Base Methodes
//////////////////////////////////////////////////////////////////////////////*/
  
  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_create($request, $response)
  {

    $context = new WebfrapAttachment_Request($request);

    /* @var $model WebfrapAttachment_Model */
    $model = $this->loadModel('WebfrapAttachment');
    $model->setProperties($context);
    
    /*
    $model->loadAccessContainer($context);

    if (!$model->access->update) {
      throw new PermissionDenied_Exception();
    }
    */

    $view = $response->loadView(
      'form-create-attachment',
      'WebfrapAttachment_Connector',
      'displayCreate',
      View::MODAL
    );
    $view->setModel($model);

    $view->displayCreate($context);

  }//end public function service_create */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_edit($request, $response)
  {

    $context = new WebfrapAttachment_Request($request);

    $objid   = $request->param('objid', Validator::EID);

    /* @var $model WebfrapAttachment_Model */
    $model = $this->loadModel('WebfrapAttachment');
    $model->setProperties($context);
    $model->loadAccessContainer($context);

    if (!$model->access->update) {
      throw new PermissionDenied_Exception();
    }

    $fileNode = $model->loadFile($objid);

    if ($fileNode->link) {
      $view = $response->loadView
      (
        'upload-edit-form',
        'WebfrapAttachment_Link',
        'displayEdit',
        View::MODAL
      );
    } else {
      $view = $response->loadView
      (
        'upload-edit-form',
        'WebfrapAttachment_File',
        'displayEdit',
        View::MODAL
      );
    }
    $view->setModel($model);

    $view->displayEdit($objid, $fileNode, $context);

  }//end public function service_edit */
  
  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_delete($request, $response)
  {

    $context = new WebfrapAttachment_Request($request);

    $id       = $request->param('objid', Validator::EID);

    /* @var $model WebfrapAttachment_Model */
    $model = $this->loadModel('WebfrapAttachment');
    $model->setProperties($context);
    $model->loadAccessContainer($context);

    if (!$model->access->update) {
      throw new PermissionDenied_Exception();
    }

    $model->deleteFile($id);

    /* @var $view WebfrapAttachment_Ajax_View  */
    $view = $response->loadView
    (
      'upload-form',
      'WebfrapAttachment',
      'renderRemoveEntry'
    );
    $view->setModel($model);

    $view->renderRemoveEntry($id, $context);

  }//end public function service_delete */


  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_formUploadFiles($request, $response)
  {

    $context = new WebfrapAttachment_Request($request);

    /* @var $model WebfrapAttachment_Model */
    $model = $this->loadModel('WebfrapAttachment');
    $model->setProperties($context);
    $model->loadAccessContainer($context);

    if (!$model->access->update) {
      throw new PermissionDenied_Exception();
    }

    /* @var $view WebfrapAttachment_File_Modal_View */
    $view = $response->loadView
    (
      'upload-form',
      'WebfrapAttachment_File',
      'displayForm',
      View::MODAL
    );
    $view->setModel($model);

    $view->displayForm($context);

  }//end public function service_formUploadFiles */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_uploadFile($request, $response)
  {

    $context = new WebfrapAttachment_Request($request);

    // refid

    $file = $request->file('file');

    if (!$file || !is_object($file)) {
      throw new InvalidRequest_Exception
      (
        Error::INVALID_REQUEST,
        Error::INVALID_REQUEST_MSG
      );
    }

    $type = $request->data('type', Validator::EID);
    $versioning   = $request->data('version', Validator::BOOLEAN);
    $description  = $request->data('description', Validator::TEXT);
    $confidentiality   = $request->data('id_confidentiality', Validator::EID);

    /* @var $model WebfrapAttachment_Model */
    $model = $this->loadModel('WebfrapAttachment');
    $model->setProperties($context);
    $model->loadAccessContainer($context);

    if (!$model->access->update) {
      throw new PermissionDenied_Exception();
    }

    $attachNode = $model->uploadFile($context->refId, $file, $type, $versioning, $confidentiality, $description);
    $entryData  = $model->getAttachmentList($context->refId, $attachNode->getId());

    /* @var $view WebfrapAttachment_Ajax_View  */
    $view = $response->loadView
    (
      'upload-form',
      'WebfrapAttachment',
      'renderAddEntry'
    );
    $view->setModel($model);

    $view->renderAddEntry($entryData, $context);

  }//end public function service_uploadFile */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_saveFile($request, $response)
  {

    $context = new WebfrapAttachment_Request($request);

    // refid
    $attachId  = $request->param('attachid', Validator::EID);

    $file = $request->file('file');

    $objid = $request->data('objid', Validator::EID);
    $type = $request->data('type', Validator::EID);
    $versioning   = $request->data('version', Validator::BOOLEAN);
    $description  = $request->data('description', Validator::TEXT);
    $confidentiality   = $request->data('id_confidentiality', Validator::EID);

    /* @var $model WebfrapAttachment_Model */
    $model = $this->loadModel('WebfrapAttachment');
    $model->setProperties($context);
    $model->loadAccessContainer($context);

    if (!$model->access->update) {
      throw new PermissionDenied_Exception();
    }

    $model->saveFile($objid, $file, $type, $versioning, $confidentiality, $description);
    $entryData  = $model->getAttachmentList(null, $attachId);

    $view = $response->loadView
    (
      'upload-form',
      'WebfrapAttachment',
      'renderUpdateEntry'
    );
    $view->setModel($model);

    if ($entryData)
      $view->renderUpdateEntry($objid, $entryData, $context);

  }//end public function service_saveFile */

  




 

} // end class WebfrapAttachment_Connector_Controller

