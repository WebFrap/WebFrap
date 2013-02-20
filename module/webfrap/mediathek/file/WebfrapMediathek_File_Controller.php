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
class WebfrapMediathek_File_Controller extends Controller
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
      'method'    => array( 'GET' ),
      'views'      => array( 'ajax' )
    ),
    'add' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'modal' )
    ),
    'insert' => array
    (
      'method'    => array( 'POST' ),
      'views'      => array( 'ajax' )
    ),
    'edit' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'modal' )
    ),
    'update' => array
    (
      'method'    => array( 'POST' ),
      'views'      => array( 'ajax' )
    ),
    'delete' => array
    (
      'method'    => array( 'DELETE' ),
      'views'      => array( 'ajax' )
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
  public function service_search($request, $response )
  {

    $mediaId   = $request->param('media', Validator::EID );
    $element   = $request->param('element', Validator::CKEY );
    $searchKey = $request->param('skey', Validator::SEARCH );

    /* @var $model WebfrapMediathek_Model */
    $model = $this->loadModel( 'WebfrapMediathek' );
    $model->loadMediathekById($mediaId );

    $searchData  = $model->getFileList($mediaId, null, $searchKey );

    /* @var $view WebfrapMediathek_File_Ajax_View */
    $view = $response->loadView
    (
      'search-block',
      'WebfrapMediathek_File',
      'renderSearch'
    );

    $view->renderSearch(  $mediaId, $element, $searchData );

  }//end public function service_search */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_add($request, $response )
  {

    $mediaId   = $request->param('media', Validator::EID );
    $element   = $request->param('element', Validator::CKEY );

    /* @var $view WebfrapMediathek_File_Modal_View */
    $view = $response->loadView
    (
      'mediathek-add-form',
      'WebfrapMediathek_File',
      'displayAdd',
      View::MODAL
    );

    $view->displayAdd($mediaId, $element );

  }//end public function service_add */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_insert($request, $response )
  {
    // mediaId
    $mediaId   = $request->param('media', Validator::EID );
    $element   = $request->param('element', Validator::CKEY );

    $file = $request->file( 'file' );

    $fileNode = new TDataObject();

    $fileNode->description  = $request->data( 'description', Validator::TEXT );
    $fileNode->versioning   = $request->data( 'version', Validator::BOOLEAN );
    $fileNode->id_licence   = $request->data( 'licence', Validator::EID );
    $fileNode->id_confidentiality = $request->data( 'confidential', Validator::EID );

    /* @var $model WebfrapMediathek_File_Model */
    $model = $this->loadModel( 'WebfrapMediathek_File' );

    $fileNode = $model->insert($mediaId, $file, $fileNode );

    /* @var $listModel WebfrapMediathek_Model */
    $listModel = $this->loadModel( 'WebfrapMediathek' );
    $listModel->loadMediathekById($mediaId );

    $entryData = $listModel->getFileList( null, $fileNode->getId() );

    $view = $response->loadView
    (
      'mediathek-insert-file',
      'WebfrapMediathek_File',
      'renderAddEntry'
    );
    $view->setModel($model );
    $view->setMediaModel($listModel );

    $view->renderAddEntry($mediaId, $element, $entryData );

  }//end public function service_insert */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_edit($request, $response )
  {

    $objid     = $request->param('objid', Validator::EID );
    $element   = $request->param('element', Validator::CKEY );
    $mediaId   = $request->param('media', Validator::EID );

    /* @var $model WebfrapMediathek_File_Model */
    $model = $this->loadModel( 'WebfrapMediathek_File' );

    $fileNode = $model->loadFile($objid );

    /* @var $view WebfrapMediathek_File_Modal_View */
    $view = $response->loadView
    (
      'mediathek-edit-form',
      'WebfrapMediathek_File',
      'displayEdit',
      View::MODAL
    );

    $view->displayEdit($objid, $mediaId, $element, $fileNode );

  }//end public function service_edit */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_update($request, $response )
  {
    // refid
    $mediaId   = $request->param('media', Validator::EID );
    $element   = $request->param('element', Validator::CKEY );

    $file  = $request->file( 'file' );

    $objid = $request->data( 'objid', Validator::EID );

    $fileNode = new TDataObject();
    $fileNode->description  = $request->data( 'description', Validator::TEXT );
    $fileNode->versioning   = $request->data( 'version', Validator::BOOLEAN );
    $fileNode->id_licence   = $request->data( 'licence', Validator::EID );
    $fileNode->id_confidentiality = $request->data( 'confidential', Validator::EID );

    /* @var $model WebfrapMediathek_File_Model */
    $model = $this->loadModel( 'WebfrapMediathek_File' );

    $model->update($objid, $mediaId, $file, $fileNode );

    /* @var $listModel WebfrapMediathek_Model */
    $listModel = $this->loadModel( 'WebfrapMediathek' );
    $listModel->loadMediathekById($mediaId );

    $entryData = $listModel->getFileList( null, $objid );

    $view = $response->loadView
    (
      'mediathek-update',
      'WebfrapMediathek_File',
      'renderUpdateEntry',
      View::AJAX
    );

   $view->renderUpdateEntry($objid, $mediaId, $element, $entryData );

  }//end public function service_update */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_delete($request, $response )
  {

    $id       = $request->param('objid', Validator::EID );
    $element  = $request->param('element', Validator::CKEY );
    $mediaId  = $request->param('media', Validator::EID );

    /* @var $model WebfrapMediathek_File_Model */
    $model = $this->loadModel( 'WebfrapMediathek_File' );
    $model->delete($id );

    /* @var $view WebfrapMediathek_File_Ajax_View  */
    $view = $response->loadView
    (
      'delete-image',
      'WebfrapMediathek_File',
      'renderRemoveEntry'
    );

    $view->renderRemoveEntry(  $mediaId, $element, $id );

  }//end public function service_delete */

} // end class WebfrapMediathek_File_Controller

