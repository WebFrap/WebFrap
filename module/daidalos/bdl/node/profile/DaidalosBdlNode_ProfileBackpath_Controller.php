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
class DaidalosBdlNode_ProfileBackpath_Controller
  extends Controller
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
      'method'    => array( 'GET' ),
      'views'      => array( 'maintab' )
    ),
    'edit' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'maintab' )
    ),
    'insert' => array
    (
      'method'    => array( 'POST' ),
      'views'      => array( 'ajax' )
    ),
    'update' => array
    (
      'method'    => array( 'PUT' ),
      'views'      => array( 'ajax' )
    ),
    'delete' => array
    (
      'method'    => array( 'DELETE' ),
      'views'      => array( 'ajax' )
    ),
    

    'createnode' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'maintab' )
    ),
    'editnode' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'maintab' )
    ),
    'insertnode' => array
    (
      'method'    => array( 'POST' ),
      'views'      => array( 'ajax' )
    ),
    'updatenode' => array
    (
      'method'    => array( 'PUT' ),
      'views'      => array( 'ajax' )
    ),
    'deletenode' => array
    (
      'method'    => array( 'DELETE' ),
      'views'      => array( 'ajax' )
    ),
  );

/*//////////////////////////////////////////////////////////////////////////////
// Default Backpaths
//////////////////////////////////////////////////////////////////////////////*/

  
  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_create( $request, $response )
  {

    $params = $this->getFlags( $request );
    
    $key   = $request->param( 'key', Validator::CKEY );
    $file  = $request->param( 'bdl_file', Validator::TEXT );

    $model  = $this->loadModel( 'DaidalosBdlModeller' );
    $model->setKey( $key );
    $model->loadFile( $file );
    
    $nodeModel = $this->loadModel( 'DaidalosBdlNode_ProfileBackpath' );
    $nodeModel->modeller = $model;

    $view   = $response->loadView
    (
      'daidalos_bdl-profile-backpath-create-'.md5($file), 
      'DaidalosBdlNode_ProfileBackpath_Create',
      'displayCreate',
      View::MAINTAB
    );
    
    $view->setModel( $nodeModel );

    $view->displayCreate( $params );

  }//end public function service_create */
  
  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_edit( $request, $response )
  {

    $params = $this->getFlags( $request );
    
    $key   = $request->param( 'key', Validator::CKEY );
    $file  = $request->param( 'bdl_file', Validator::TEXT );
    $idx   = $request->param( 'idx', Validator::INT );

    $model  = $this->loadModel( 'DaidalosBdlModeller' );
    $model->setKey( $key );
    $model->loadFile( $file );
    
    $nodeModel = $this->loadModel( 'DaidalosBdlNode_ProfileBackpath' );
    /* @var $nodeModel DaidalosBdlNode_ProfileBackpath_Model */
    $nodeModel->loadBdlBackpath( $model, $idx );

    $view   = $response->loadView
    (
      'daidalos_bdl-profile-backpath-edit-'.md5($file).'-'.$idx, 
      'DaidalosBdlNode_ProfileBackpath_Edit',
      'displayEdit',
      View::MAINTAB
    );
    
    $view->setModel( $nodeModel );

    $view->displayEdit( $idx, $params );

  }//end public function service_edit */
  
  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_insert( $request, $response )
  {

    $params = $this->getFlags( $request );
    
    $key   = $request->param( 'key', Validator::CKEY );
    $file  = $request->param( 'bdl_file', Validator::TEXT );


    $model  = $this->loadModel( 'DaidalosBdlModeller' );
    $model->setKey( $key );
    $model->loadFile( $file );

    $nodeModel = $this->loadModel( 'DaidalosBdlNode_ProfileBackpath' );
    /* @var $nodeModel DaidalosBdlNode_ProfileBackpath_Model */
    $nodeModel->modeller = $model;
    
    $backpath = $nodeModel->insertByRequest( $request, $response );

    $view   = $response->loadView
    (
      'daidalos_bdl-profile-backpath-insert-'.md5($file), 
      'DaidalosBdlNode_ProfileBackpath',
      'displayInsert',
      View::AJAX
    );
    /* @var $view DaidalosBdlNode_ProfileBackpath_Ajax_View */
    
    $view->setModel( $nodeModel );
    
    $index = $nodeModel->getLastCreatedIndex();

    $view->displayInsert( $backpath, $index, $nodeModel->profile->getName() );
    
    $response->addMessage( "Successfully created new Backpath" );

  }//end public function service_insert */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_update( $request, $response )
  {

    $params = $this->getFlags( $request );
    
    $key   = $request->param( 'key', Validator::CKEY );
    $file  = $request->param( 'bdl_file', Validator::TEXT );
    $idx   = $request->param( 'idx', Validator::INT );

    $model  = $this->loadModel( 'DaidalosBdlModeller' );
    $model->setKey( $key );
    $model->loadFile( $file );

    $nodeModel = $this->loadModel( 'DaidalosBdlNode_ProfileBackpath' );
    /* @var $nodeModel DaidalosBdlNode_ProfileBackpath_Model */
    $nodeModel->loadBdlBackpath( $model, $idx );
    
    $backpath = $nodeModel->updateByRequest( $request, $response );

    $view   = $response->loadView
    (
      'daidalos_bdl-profile-backpath-update-'.md5($file), 
      'DaidalosBdlNode_ProfileBackpath',
      'displayUpdate',
      View::AJAX
    );
    /* @var $view DaidalosBdlNode_ProfileBackpath_Ajax_View */
    
    $view->setModel( $nodeModel );

    $view->displayUpdate( $backpath, $idx, $nodeModel->profile->getName() );
    
    $response->addMessage( "Successfully created new Backpath" );

  }//end public function service_update */
  
  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_delete( $request, $response )
  {

    $params = $this->getFlags( $request );
    
    $key   = $request->param( 'key', Validator::CKEY );
    $file  = $request->param( 'bdl_file', Validator::TEXT );
    $idx   = $request->param( 'idx', Validator::INT );

    $model  = $this->loadModel( 'DaidalosBdlModeller' );
    $model->setKey( $key );
    $model->loadFile( $file );

    $nodeModel = $this->loadModel( 'DaidalosBdlNode_ProfileBackpath' );
    /* @var $nodeModel DaidalosBdlNode_ProfileBackpath_Model */
    $nodeModel->modeller = $model;
    
    $nodeModel->deleteByIndex( $idx );

    $view   = $response->loadView
    (
      'daidalos_bdl-profile-backpath-delete-'.md5($file), 
      'DaidalosBdlNode_ProfileBackpath',
      'displayDelete',
      View::AJAX
    );
    /* @var $view DaidalosBdlNode_ProfileBackpath_Ajax_View */
    
    $view->setModel( $nodeModel );

    $view->displayDelete( $idx, $nodeModel->profile->getName() );
    
    $response->addMessage( "Successfully dropped backpath" );

  }//end public function service_delete */
  
/*//////////////////////////////////////////////////////////////////////////////
// Backpath References
//////////////////////////////////////////////////////////////////////////////*/

  
  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_createNode( $request, $response )
  {

    $params = $this->getFlags( $request );
    
    $key   = $request->param( 'key', Validator::CKEY );
    $file  = $request->param( 'bdl_file', Validator::TEXT );
    $path  = $request->param( 'path', Validator::TEXT );

    $model  = $this->loadModel( 'DaidalosBdlModeller' );
    $model->setKey( $key );
    $model->loadFile( $file );
    
    $nodeModel = $this->loadModel( 'DaidalosBdlNode_ProfileBackpath' );
    $nodeModel->modeller = $model;

    $view   = $response->loadView
    (
      'daidalos_bdl-profile-backpath-node-create-'.md5($file), 
      'DaidalosBdlNode_ProfileBackpathNode_Create',
      'displayCreate',
      View::MAINTAB
    );
    
    $view->setModel( $nodeModel );

    $view->displayCreate( $path, $params );

  }//end public function service_createNode */
  
  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_editNode( $request, $response )
  {

    $params = $this->getFlags( $request );
    
    $key   = $request->param( 'key', Validator::CKEY );
    $file  = $request->param( 'bdl_file', Validator::TEXT );
    $path  = $request->param( 'path', Validator::TEXT );

    $pathId = str_replace('.', '-', $path);
    
    $model  = $this->loadModel( 'DaidalosBdlModeller' );
    $model->setKey( $key );
    $model->loadFile( $file );
    
    $nodeModel = $this->loadModel( 'DaidalosBdlNode_ProfileBackpath' );
    /* @var $nodeModel DaidalosBdlNode_ProfileBackpath_Model */
    $nodeModel->loadBdlBackpathNode( $model, $path );

    $view   = $response->loadView
    (
      'daidalos_bdl-profile-backpath-ref-edit-'.md5($file).'-'.$pathId, 
      'DaidalosBdlNode_ProfileBackpathNode_Edit',
      'displayEdit',
      View::MAINTAB
    );
    /* @var $view DaidalosBdlNode_ProfileBackpathNode_Edit_Maintab_View */
    
    $view->setModel( $nodeModel );

    $view->displayEdit( $path, $params );

  }//end public function service_editNode */
  
  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_insertNode( $request, $response )
  {

    $params = $this->getFlags( $request );
    
    $key   = $request->param( 'key', Validator::CKEY );
    $file  = $request->param( 'bdl_file', Validator::TEXT );
    $path  = $request->param( 'path', Validator::TEXT );


    $model  = $this->loadModel( 'DaidalosBdlModeller' );
    $model->setKey( $key );
    $model->loadFile( $file );

    $nodeModel = $this->loadModel( 'DaidalosBdlNode_ProfileBackpath' );
    /* @var $nodeModel DaidalosBdlNode_ProfileBackpath_Model */
    $nodeModel->modeller = $model;
    
    $backpath = $nodeModel->insertNodeByRequest( $path, $request, $response );

    $view   = $response->loadView
    (
      'daidalos_bdl-profile-backpath-insert-'.md5($file), 
      'DaidalosBdlNode_ProfileBackpathNode',
      'displayInsert',
      View::AJAX
    );
    /* @var $view DaidalosBdlNode_ProfileBackpathNode_Ajax_View */
    
    $view->setModel( $nodeModel );
    
    $index = $nodeModel->getLastCreatedNodeIndex( $path );

    $view->displayInsert( $backpath, $path, $index, $nodeModel->profile->getName() );
    
    $response->addMessage( "Successfully created new Backpath Reference" );

  }//end public function service_insertNode */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_updateNode( $request, $response )
  {

    $params = $this->getFlags( $request );
    
    $key   = $request->param( 'key', Validator::CKEY );
    $file  = $request->param( 'bdl_file', Validator::TEXT );
    $path  = $request->param( 'path', Validator::TEXT );

    $pathId = str_replace('.', '-', $path);


    $model  = $this->loadModel( 'DaidalosBdlModeller' );
    $model->setKey( $key );
    $model->loadFile( $file );

    $nodeModel = $this->loadModel( 'DaidalosBdlNode_ProfileBackpath' );
    /* @var $nodeModel DaidalosBdlNode_ProfileBackpath_Model */
    $nodeModel->loadBdlBackpathNode( $model, $path );
    
    $backpath = $nodeModel->updateNodeByRequest( $path, $request, $response );

    $view   = $response->loadView
    (
      'daidalos_bdl-profile-backpath-update-'.md5($file).'-ref-'.$pathId, 
      'DaidalosBdlNode_ProfileBackpathNode',
      'displayUpdate',
      View::AJAX
    );
    /* @var $view DaidalosBdlNode_ProfileBackpath_Ajax_View */
    
    $view->setModel( $nodeModel );

    $view->displayUpdate( $backpath, $path, $nodeModel->profile->getName() );
    
    $response->addMessage( "Successfully updated Backpath" );

  }//end public function service_updateNode */
  
  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_deleteNode( $request, $response )
  {

    $params = $this->getFlags( $request );
    
    $key   = $request->param( 'key', Validator::CKEY );
    $file  = $request->param( 'bdl_file', Validator::TEXT );
    $path  = $request->param( 'path', Validator::TEXT );

    $model  = $this->loadModel( 'DaidalosBdlModeller' );
    $model->setKey( $key );
    $model->loadFile( $file );

    $nodeModel = $this->loadModel( 'DaidalosBdlNode_ProfileBackpath' );
    /* @var $nodeModel DaidalosBdlNode_ProfileBackpath_Model */
    $nodeModel->modeller = $model;
    
    $nodeModel->deleteNodeByIndex( $path );

    $view   = $response->loadView
    (
      'daidalos_bdl-profile-backpath-delete-'.md5($file), 
      'DaidalosBdlNode_ProfileBackpathNode',
      'displayDelete',
      View::AJAX
    );
    /* @var $view DaidalosBdlNode_ProfileBackpathNode_Ajax_View */
    
    $view->setModel( $nodeModel );

    $view->displayDelete( $path, $nodeModel->profile->getName() );
    
    $response->addMessage( "Successfully dropped Backpath" );

  }//end public function service_deleteNode */
  
} // end class DaidalosBdlNode_ProfileBackpath_Controller

