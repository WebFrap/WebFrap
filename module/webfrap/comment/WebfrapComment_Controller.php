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
class WebfrapComment_Controller
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
    'save' => array
    (
      'method'    => array( 'POST','PUT' ),
      'views'      => array( 'ajax' )
    ),
    'autocomplete' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'ajax' )
    ),
    'disconnect' => array
    (
      'method'    => array( 'DELETE' ),
      'views'      => array( 'ajax' )
    ),
    'overlaydset' => array
    (
      'method'    => array( 'GET' ),
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
  public function service_save( $request, $response )
  {

    // params
    $context = new WebfrapComment_Context( $request );

    /* @var $model WebfrapComment_Model */
    $model = $this->loadModel( 'WebfrapComment' );
    $model->loadAccessContainer( $context );

    if (!$model->access->update) {
      throw new PermissionDenied_Exception();
    }

    $refId   = $context->refId;

    // data
    $title   = $request->data( 'title', Validator::TEXT );
    $comment = $request->data( 'content', Validator::TEXT );
    $parent  = $request->data( 'parent', Validator::EID );
    $rowid   = $request->data( 'rowid', Validator::EID );

    $respContext = $response->createContext();

    $respContext->assertNotNull( 'Missing the Title', $title );
    $respContext->assertNotNull( 'Missing the Comment', $comment );
    $respContext->assertNotNull( 'Missing the RefId', $refId );

    if ($respContext->hasError) {
      throw new InvalidRequest_Exception
      (
        Error::INVALID_REQUEST_MSG,
        Error::INVALID_REQUEST
      );
    }

    if ($rowid) {
      $commentNode = $model->saveComment( $rowid, $title, $comment );
    } else {
      $commentNode = $model->addComment( $title, $comment, $refId, $parent );
    }

    /* @var $view WebfrapComment_View_Ajax */
    $view = $response->loadView
    (
      'base-comment-add',
      'WebfrapComment'
    );
    $view->setModel( $model );

    if ($rowid) {
      $view->displayUpdate( $context, $model->getCommentEntry( $rowid ) );
    } else {
      $view->displayAdd( $context, $parent, $model->getCommentEntry( $commentNode->getId() ) );
    }

  }//end public function service_save */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_autocomplete( $request, $response )
  {

      // params
    $context = new WebfrapComment_Context( $request );

    /* @var $model WebfrapComment_Model */
    $model = $this->loadModel( 'WebfrapComment' );
    $model->loadAccessContainer( $context );

    if (!$model->access->update) {
      throw new PermissionDenied_Exception();
    }

    $key      = $request->param( 'key', Validator::TEXT );

      // sicher stellen, dass alle benötigten Informationen vorhanden sind
    if (!$key || !$context->refId) {
      throw new InvalidRequest_Exception
      (
        Error::INVALID_REQUEST_MSG,
        Error::INVALID_REQUEST
      );
    }

    $view = $this->getTplEngine();
    $view->setRawJsonData( $model->autocompleteByName( $key, $context->refId ) );

  }//end public function service_autocomplete */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_disconnect( $request, $response )
  {

    // params
    $context = new WebfrapComment_Context( $request );

    /* @var $model WebfrapComment_Model */
    $model = $this->loadModel( 'WebfrapComment' );
    $model->loadAccessContainer( $context );

    if (!$model->access->update) {
      throw new PermissionDenied_Exception();
    }

    $id       = $request->param( 'objid', Validator::EID );
    $model->delete( $id );

  }//end public function service_disconnect */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_overlayDset( $request, $response )
  {

    $element  = $request->param( 'element', Validator::EID );
    $dKey     = $request->param( 'dkey', Validator::TEXT );
    $objid    = $request->param( 'objid', Validator::EID );

    /* @var $view WebfrapHistory_Ajax_View  */
    $view = $response->loadView
    (
        'webfrap-comment-dset',
        'WebfrapComment',
        'displayOverlay'
    );

    /* @var $model WebfrapComment_Model */
    $model = $this->loadModel( 'WebfrapComment' );

    $view->setModel( $model );
    $view->displayOverlay( $element, $dKey, $objid );

  }//end public function service_overlayDset */

} // end class WebfrapComment_Controller
