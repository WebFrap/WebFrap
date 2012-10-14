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
    
    /* @var $model WebfrapComment_Model */
    $model = $this->loadModel( 'WebfrapComment' );
    
    // params
    $elId    = $request->param( 'element', Validator::CKEY );
    
    // data
    $title   = $request->data( 'title', Validator::TEXT );
    $comment = $request->data( 'content', Validator::TEXT );
    $refId   = $request->data( 'refid', Validator::EID );
    $parent  = $request->data( 'parent', Validator::EID );
    $rowid   = $request->data( 'rowid', Validator::EID );
   
    $context = $response->createContext();
    
    $context->assertNotNull( 'Missing the Title', $title );
    $context->assertNotNull( 'Missing the Comment', $comment );
    $context->assertNotNull( 'Missing the RefId', $refId );
    
    if( $context->hasError )
    {
      throw new InvalidRequest_Exception
      ( 
        Error::INVALID_REQUEST_MSG, 
        Error::INVALID_REQUEST 
      );
    }
    
    if( $rowid )
    {
      $commentNode = $model->saveComment( $rowid, $title, $comment );
    }
    else 
    {
      $commentNode = $model->addComment( $title, $comment, $refId, $parent );
    }

    /* @var $view WebfrapComment_View_Ajax */
    $view = $response->loadView
    (
      'base-comment-add', 
      'WebfrapComment'
    );
    $view->setModel( $model );
    
    if( $rowid )
    {
      $view->displayUpdate( $elId, $refId, $model->getCommentEntry( $rowid ) );
    }
    else 
    {
      $view->displayAdd( $elId, $refId, $parent, $model->getCommentEntry( $commentNode->getId() ) );
    }

  }//end public function service_save */
  
  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_autocomplete( $request, $response )
  {
    
    /* @var $model WebfrapComment_Model */
    $model = $this->loadModel( 'WebfrapComment' );
    
    $key   = $request->param( 'key', Validator::TEXT );
    
    // die sollte entweder per autocomplete kommen oder statisch im widget
    // vorhanden sein
    $refId  = $request->param( 'refid', Validator::EID );
    
      // sicher stellen, dass alle benötigten Informationen vorhanden sind
    if( !$key || !$refId )
    {
      throw new InvalidRequest_Exception
      ( 
        Error::INVALID_REQUEST_MSG, 
        Error::INVALID_REQUEST 
      );
    }

    $view = $this->getTplEngine();
    $view->setRawJsonData( $model->autocompleteByName( $key, $refId ) );

  }//end public function service_autocomplete */
  
  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_disconnect( $request, $response )
  {

    $id   = $request->param( 'objid', Validator::EID );
    
    /* @var $model WebfrapComment_Model */
    $model = $this->loadModel( 'WebfrapComment' );
    
    $model->delete( $id );

  }//end public function service_disconnect */


} // end class WebfrapComment_Controller


