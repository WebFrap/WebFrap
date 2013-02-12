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
class WebfrapAttachment_Audio_Controller
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
    'search' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'ajax' )
    ),
    'formadd' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'modal' )
    ),
    'insert' => array
    (
      'method'    => array( 'POST' ),
      'views'      => array( 'ajax' )
    ),
    'formedit' => array
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

////////////////////////////////////////////////////////////////////////////////
// Base Methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_search( $request, $response )
  {

    $mediathek = $request->param( 'mediathek', Validator::EID );
    $element   = $request->param( 'element', Validator::CKEY );
    $searchKey = $request->param( 'skey', Validator::SEARCH );

    /* @var $model WebfrapAttachment_Model */
    $model = $this->loadModel( 'WebfrapAttachment' );

    $searchData  = $model->getAttachmentList( $mediathek, null, $searchKey );

    /* @var $view WebfrapAttachment_Ajax_View */
    $view = $response->loadView
    (
        'search-form',
        'WebfrapAttachment',
        'renderSearch'
    );

    $view->renderSearch(  $mediathek, $element, $searchData );

  }//end public function service_search */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_formAdd( $request, $response )
  {

    $mediathek   = $request->param( 'mediathek', Validator::EID );
    $element     = $request->param( 'element', Validator::CKEY );

    $view = $response->loadView
    (
        'upload-form',
        'WebfrapAttachment_Audio',
        'displayAdd',
      View::MODAL
    );

    $view->displayForm( $mediathek, $element );

  }//end public function service_formUploadFiles */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_insert( $request, $response )
  {
    // refid
    $attachId  = $request->param( 'attachid', Validator::EID );
    $element   = $request->param( 'element', Validator::CKEY );

    $file = $request->file( 'file' );

    $objid = $request->data( 'objid', Validator::EID );
    $type = $request->data( 'type', Validator::EID );
    $versioning   = $request->data( 'version', Validator::BOOLEAN );
    $description  = $request->data( 'description', Validator::TEXT );
    $confidentiality   = $request->data( 'id_confidentiality', Validator::EID );

    /* @var $model WebfrapAttachment_Model */
    $model = $this->loadModel( 'WebfrapAttachment' );

    $model->saveFile( $objid, $file, $type, $versioning, $confidentiality, $description );
    $entryData  = $model->getAttachmentList( null, $attachId );

    $view = $response->loadView
    (
        'upload-form',
        'WebfrapAttachment',
        'renderUpdateEntry'
    );

    if( $entryData )
      $view->renderUpdateEntry( $objid, $element, $entryData );

  }//end public function service_insert */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_formEdit( $request, $response )
  {

    $objid     = $request->param( 'objid', Validator::EID );
    $element   = $request->param( 'element', Validator::CKEY );
    $mediathek = $request->param( 'mediathek', Validator::EID );

    /* @var $model WebfrapAttachment_Model */
    $model = $this->loadModel( 'WebfrapAttachment' );

    $fileNode = $model->loadFile( $objid );

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

    $view->displayEdit( $objid, $mediathek, $fileNode, $element );

  }//end public function service_edit */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_update( $request, $response )
  {
    // refid
    $attachId  = $request->param( 'attachid', Validator::EID );
    $element   = $request->param( 'element', Validator::CKEY );

    $file = $request->file( 'file' );

    $objid = $request->data( 'objid', Validator::EID );
    $type = $request->data( 'type', Validator::EID );
    $versioning   = $request->data( 'version', Validator::BOOLEAN );
    $description  = $request->data( 'description', Validator::TEXT );
    $confidentiality   = $request->data( 'id_confidentiality', Validator::EID );

    /* @var $model WebfrapAttachment_Model */
    $model = $this->loadModel( 'WebfrapAttachment' );

    $model->saveFile( $objid, $file, $type, $versioning, $confidentiality, $description );
    $entryData  = $model->getAttachmentList( null, $attachId );

    $view = $response->loadView
    (
        'upload-form',
        'WebfrapAttachment',
        'renderUpdateEntry'
    );

    if( $entryData )
      $view->renderUpdateEntry( $objid, $element, $entryData );

  }//end public function service_update */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_delete( $request, $response )
  {

    $id         = $request->param( 'objid', Validator::EID );
    $element    = $request->param( 'element', Validator::CKEY );
    $mediathek  = $request->param( 'mediathek', Validator::EID );

    /* @var $model WebfrapAttachment_Model */
    $model = $this->loadModel( 'WebfrapAttachment' );
    $model->delete( $id );

    /* @var $view WebfrapAttachment_Ajax_View  */
    $view = $response->loadView
    (
        'delete-audio',
        'WebfrapAttachment',
        'renderRemoveEntry'
    );

    $view->renderRemoveEntry(  $mediathek, $element, $id );

  }//end public function service_delete */

} // end class WebfrapAttachment_Controller
