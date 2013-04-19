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
 * @licence BSD
 */
class WebfrapMediathek_Image_Controller extends Controller
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var array
   */
  protected $options           = array
  (
    'search' => array
    (
      'method'    => array('GET'),
      'views'      => array('ajax')
    ),
    'add' => array
    (
      'method'    => array('GET'),
      'views'      => array('modal')
    ),
    'insert' => array
    (
      'method'    => array('POST'),
      'views'      => array('ajax')
    ),
    'edit' => array
    (
      'method'    => array('GET'),
      'views'      => array('modal')
    ),
    'update' => array
    (
      'method'    => array('POST'),
      'views'      => array('ajax')
    ),
    'delete' => array
    (
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
  public function service_search($request, $response)
  {

    $mediaId   = $request->param('media', Validator::EID);
    $element   = $request->param('element', Validator::CKEY);
    $searchKey = $request->param('skey', Validator::SEARCH);

    /* @var $model WebfrapMediathek_Model */
    $model = $this->loadModel('WebfrapMediathek');
    $model->loadMediathekById($mediaId);

    $searchData  = $model->getImageList($mediaId, null, $searchKey);

    /* @var $view WebfrapMediathek_Image_Ajax_View */
    $view = $response->loadView
    (
      'search-block',
      'WebfrapMediathek_Image',
      'renderSearch'
    );

    $view->renderSearch( $mediaId, $element, $searchData);

  }//end public function service_search */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_add($request, $response)
  {

    $mediaId   = $request->param('media', Validator::EID);
    $element   = $request->param('element', Validator::CKEY);

    /* @var $view WebfrapMediathek_Image_Modal_View */
    $view = $response->loadView
    (
      'mediathek-add-form',
      'WebfrapMediathek_Image',
      'displayAdd',
      View::MODAL
    );

    $view->displayAdd($mediaId, $element);

  }//end public function service_add */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_insert($request, $response)
  {
    // mediaId
    $mediaId   = $request->param('media', Validator::EID);
    $element   = $request->param('element', Validator::CKEY);

    $file = $request->file('file');

    $imageNode = new TDataObject();

    $imageNode->description  = $request->data('description', Validator::TEXT);
    $imageNode->title       = $request->data('title', Validator::TEXT);
    $imageNode->versioning   = $request->data('version', Validator::BOOLEAN);
    $imageNode->id_licence   = $request->data('licence', Validator::EID);
    $imageNode->id_confidentiality = $request->data('confidential', Validator::EID);

    /* @var $model WebfrapMediathek_Image_Model */
    $model = $this->loadModel('WebfrapMediathek_Image');

    $imageNode = $model->insert($mediaId, $file, $imageNode);

    /* @var $listModel WebfrapMediathek_Model */
    $listModel = $this->loadModel('WebfrapMediathek');
    $listModel->loadMediathekById($mediaId);

    $entryData = $listModel->getImageList(null, $imageNode->getId());

    $view = $response->loadView
    (
      'upload-form',
      'WebfrapMediathek_Image',
      'renderAddEntry'
    );
    $view->setModel($model);
    $view->setMediaModel($listModel);

    $view->renderAddEntry($mediaId, $element, $entryData);

  }//end public function service_insert */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_edit($request, $response)
  {

    $objid     = $request->param('objid', Validator::EID);
    $element   = $request->param('element', Validator::CKEY);
    $mediaId   = $request->param('media', Validator::EID);

    /* @var $model WebfrapMediathek_Image_Model */
    $model = $this->loadModel('WebfrapMediathek_Image');

    $imageNode = $model->loadImage($objid);

    /* @var $view WebfrapMediathek_Image_Modal_View */
    $view = $response->loadView
    (
      'mediathek-edit-form',
      'WebfrapMediathek_Image',
      'displayEdit',
      View::MODAL
    );

    $view->displayEdit($objid, $mediaId, $element, $imageNode);

  }//end public function service_edit */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_update($request, $response)
  {
    // refid
    $mediaId   = $request->param('media', Validator::EID);
    $element   = $request->param('element', Validator::CKEY);

    $file  = $request->file('file');

    $objid = $request->data('objid', Validator::EID);

    $imageNode = new TDataObject();
    $imageNode->description  = $request->data('description', Validator::TEXT);
    $imageNode->title       = $request->data('title', Validator::TEXT);
    $imageNode->versioning   = $request->data('version', Validator::BOOLEAN);
    $imageNode->id_licence   = $request->data('licence', Validator::EID);
    $imageNode->id_confidentiality = $request->data('confidential', Validator::EID);

    /* @var $model WebfrapMediathek_Image_Model */
    $model = $this->loadModel('WebfrapMediathek_Image');

    $model->update($objid, $mediaId, $file, $imageNode);

    /* @var $listModel WebfrapMediathek_Model */
    $listModel = $this->loadModel('WebfrapMediathek');
    $listModel->loadMediathekById($mediaId);

    $entryData = $listModel->getImageList(null, $objid);

    $view = $response->loadView
    (
      'mediathek-update',
      'WebfrapMediathek_Image',
      'renderUpdateEntry',
      View::AJAX
    );

   $view->renderUpdateEntry($objid, $mediaId, $element, $entryData);

  }//end public function service_update */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_delete($request, $response)
  {

    $id       = $request->param('objid', Validator::EID);
    $element  = $request->param('element', Validator::CKEY);
    $mediaId  = $request->param('media', Validator::EID);

    /* @var $model WebfrapMediathek_Image_Model */
    $model = $this->loadModel('WebfrapMediathek_Image');
    $model->delete($id);

    /* @var $view WebfrapMediathek_Image_Ajax_View  */
    $view = $response->loadView
    (
      'delete-image',
      'WebfrapMediathek_Image',
      'renderRemoveEntry'
    );

    $view->renderRemoveEntry( $mediaId, $element, $id);

  }//end public function service_delete */

} // end class WebfrapMediathek_Image_Controller

