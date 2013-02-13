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
class WebfrapKnowhowNode_Controller
  extends Controller
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/
  
  /**
   * @var array
   */
  protected $options           = array
  (
    'open' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'maintab' )
    ),
    'show' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'maintab' )
    ),
    'opendialog' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'modal' )
    ),
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
  public function service_open( $request, $response )
  {

    $idContainer  = $request->param( 'container', Validator::EID );
    $nodeKey      = $request->param( 'node', Validator::TEXT );
    $objid        = $request->param( 'objid', Validator::EID );
    
    /* @var $view WebfrapKnowhowNode_Maintab_View  */
    $view = $response->loadView
    ( 
    	'know_how-node-form', 
    	'WebfrapKnowhowNode', 
    	'displayForm'
    );
    
    /* @var $model WebfrapKnowhowNode_Model */
    $model = $this->loadModel( 'WebfrapKnowhowNode' );
    
    if( $objid )
    {
      $model->loadNodeById( $objid );
    }
    elseif( $nodeKey )
    {
      $model->loadNodeByKey( $nodeKey, $idContainer );
    }
    
    $view->setModel( $model );
    $view->displayForm( $nodeKey, $idContainer );
    

  }//end public function service_open */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_show( $request, $response )
  {

    $idContainer  = $request->param( 'container', Validator::EID );
    $nodeKey      = $request->param( 'node', Validator::TEXT );
    $objid        = $request->param( 'objid', Validator::EID );
    
    /* @var $view WebfrapKnowhowNode_Show_Maintab_View  */
    $view = $response->loadView
    ( 
    	'know_how-node-show', 
    	'WebfrapKnowhowNode_Show', 
    	'displayShow'
    );
    
    /* @var $model WebfrapKnowhowNode_Model */
    $model = $this->loadModel( 'WebfrapKnowhowNode' );
    
    if( $objid )
    {
      $model->loadNodeById( $objid );
    }
    elseif( $nodeKey )
    {
      $model->loadNodeByKey( $nodeKey, $idContainer );
    }
    
    $view->setModel( $model );
    $view->displayShow( $nodeKey, $idContainer );
    

  }//end public function service_show */
  
  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_openDialog( $request, $response )
  {

    $refId   = $request->param( 'refid', Validator::EID );
    $element = $request->param( 'element', Validator::CKEY );
    
    /* @var $view WebfrapKnowhowNode_Modal_View  */
    $view = $response->loadView
    ( 
    	'know_how-diaglog', 
    	'WebfrapKnowhowNode', 
    	'displayDialog',
      View::MODAL
    );
    
    $view->displayDialog( $refId, $element );
    

  }//end public function service_openDialog */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_save( $request, $response )
  {
    
    /* @var $model WebfrapKnowhowNode_Model */
    $model = $this->loadModel( 'WebfrapKnowhowNode' );
    
    // params
    $elId    = $request->param( 'element', Validator::CKEY );
    
    // data
    $title     = $request->data( 'title', Validator::TEXT );
    $accessKey = $request->data( 'access_key', Validator::TEXT );
    $content   = $request->data( 'content', Validator::TEXT );
    $container = $request->data( 'id_container', Validator::EID );
    $rowid     = $request->data( 'rowid', Validator::EID );
   
    $context   = $response->createContext();
    
    $context->assertNotNull( 'Missing the Title', $title );
    $context->assertNotNull( 'Missing the Key', $accessKey );
    $context->assertNotNull( 'Missing the Comment', $content );
    //$context->assertNotNull( 'Missing the RefId', $refId );
    
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
      $khNode = $model->updateNode( $rowid, $title, $accessKey, $content, $container );
    }
    else 
    {
      $khNode = $model->addNode( $title, $accessKey, $content, $container );
    }

    /* @var $view WebfrapKnowhowNode_Ajax_View */
    $view = $response->loadView
    (
      'webfrap-knowhow-node', 
      'WebfrapKnowhowNode', 
      'displayAdd'
    );
    $view->setModel( $model );
    
    if( !$rowid )
    {
      $view->displayAdd( $elId, $khNode );
    }

  }//end public function service_save */
  
  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_autocomplete( $request, $response )
  {
    
    /* @var $model WebfrapKnowhowNode_Model */
    $model = $this->loadModel( 'WebfrapKnowhowNode' );
    
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
   * Service zum löschen eines Content Nodes
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_delete( $request, $response )
  {

    $id   = $request->param( 'objid', Validator::EID );
    $node = $request->param( 'node', Validator::TEXT );
    
    /* @var $model WebfrapKnowhowNode_Model */
    $model = $this->loadModel( 'WebfrapKnowhowNode' );
    
    if( $id )
    {
      $model->delete( $id );
    }
    elseif( $node )
    {
      $model->deleteByKey( $node, null );
    }
    else 
    {
      throw new InvalidRequest_Exception
      ( 
        Error::INVALID_REQUEST,
        Error::INVALID_REQUEST_MSG
      );
    }
    
  }//end public function service_delete */


} // end class WebfrapKnowhowNode_Controller


