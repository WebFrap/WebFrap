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
class DaidalosBdlModules_Controller
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
    'listing' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'maintab' )
    ),
    'loadchildren' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'ajax' )
    ),
    'createmodule' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'maintab' )
    ),
  );

/*//////////////////////////////////////////////////////////////////////////////
// Backup & Restore
//////////////////////////////////////////////////////////////////////////////*/


  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_listing( $request, $response )
  {

    $params  = $this->getFlags( $request );
    $key     = $request->param( 'key', Validator::CKEY );

    $view    = $response->loadView
    (
      'daidalos_repo_modules-listing-'.$key, 
      'DaidalosBdlModules',
      'displayList',
      View::MAINTAB
    );

    $model  = $this->loadModel( 'DaidalosBdlModules' );
    $view->setModel( $model );
    $model->key = $key;

    $view->displayList( $params );

  }//end public function service_listing */
  

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_loadChildren( $request, $response )
  {

    $params  = $this->getFlags( $request );
    
    $key     = $request->param( 'key', Validator::CKEY );
    $node    = $request->param( 'node', Validator::CKEY );

    $view    = $response->loadView
    (
      'daidalos_repo_modules-children-'.$key.'-'.$node, 
      'DaidalosBdlModules',
      'displayChildNode',
      View::AJAX
    );

    $model  = $this->loadModel( 'DaidalosBdlModules' );
    $view->setModel( $model );
    $model->key     = $key;
    $model->nodeKey = $node;

    $view->displayChildNode( $params );

  }//end public function service_loadChildren */
  
/*//////////////////////////////////////////////////////////////////////////////
// Module Logik
//////////////////////////////////////////////////////////////////////////////*/
  
  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_createModule( $request, $response )
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

  }//end public function service_createModule */
  
  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_insertModule( $request, $response )
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

  }//end public function service_insertModule */
  
  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_deleteModule( $request, $response )
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

  }//end public function service_deleteModule */
  
} // end class DaidalosBdlModules_Controller

