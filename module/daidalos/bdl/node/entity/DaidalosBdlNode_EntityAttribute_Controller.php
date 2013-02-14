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
class DaidalosBdlNode_EntityAttribute_Controller extends Controller
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
  );

/*//////////////////////////////////////////////////////////////////////////////
// Backup & Restore
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_create($request, $response )
  {

    $params = $this->getFlags($request);
    
    $key   = $request->param('key', Validator::CKEY );
    $file  = $request->param('bdl_file', Validator::TEXT );

    $model  = $this->loadModel( 'DaidalosBdlModeller' );
    $model->setKey($key );
    $model->loadFile($file );
    
    $nodeModel = $this->loadModel( 'DaidalosBdlNode_EntityAttribute' );
    $nodeModel->modeller = $model;

    $view   = $response->loadView
    (
      'daidalos_bdl-entity-attribute-create-'.md5($file), 
      'DaidalosBdlNode_EntityAttribute_Create',
      'displayCreate',
      View::MAINTAB
    );
    
    $view->setModel($nodeModel );

    $view->displayCreate($params );

  }//end public function service_create */
  
  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_edit($request, $response )
  {

    $params = $this->getFlags($request);
    
    $key   = $request->param('key', Validator::CKEY );
    $file  = $request->param('bdl_file', Validator::TEXT );
    $idx   = $request->param('idx', Validator::INT );

    $model  = $this->loadModel( 'DaidalosBdlModeller' );
    $model->setKey($key );
    $model->loadFile($file );
    
    $nodeModel = $this->loadModel( 'DaidalosBdlNode_EntityAttribute' );
    /* @var $nodeModel DaidalosBdlNode_EntityAttribute_Model */
    $nodeModel->loadBdlAttribute($model, $idx );

    $view   = $response->loadView
    (
      'daidalos_bdl-entity-attribute-edit-'.md5($file).'-'.$idx, 
      'DaidalosBdlNode_EntityAttribute_Edit',
      'displayEdit',
      View::MAINTAB
    );
    
    $view->setModel($nodeModel );

    $view->displayEdit($idx, $params );

  }//end public function service_edit */
  
  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_insert($request, $response )
  {

    $params = $this->getFlags($request);
    
    $key   = $request->param('key', Validator::CKEY );
    $file  = $request->param('bdl_file', Validator::TEXT );


    $model  = $this->loadModel( 'DaidalosBdlModeller' );
    $model->setKey($key );
    $model->loadFile($file );

    $nodeModel = $this->loadModel( 'DaidalosBdlNode_EntityAttribute' );
    /* @var $nodeModel DaidalosBdlNode_EntityAttribute_Model */
    $nodeModel->modeller = $model;
    
    $backpath = $nodeModel->insertByRequest($request, $response );

    $view   = $response->loadView
    (
      'daidalos_bdl-entity-attribute-insert-'.md5($file), 
      'DaidalosBdlNode_EntityAttribute',
      'displayInsert',
      View::AJAX
    );
    /* @var $view DaidalosBdlNode_EntityAttribute_Ajax_View */
    
    $view->setModel($nodeModel );
    
    $index = $nodeModel->getLastCreatedIndex();

    $view->displayInsert($backpath, $index, $nodeModel->entityNode->getName() );
    
    $response->addMessage( "Successfully created new Attribute" );

  }//end public function service_insert */
  
  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_update($request, $response )
  {

    $params = $this->getFlags($request);
    
    $key   = $request->param('key', Validator::CKEY );
    $file  = $request->param('bdl_file', Validator::TEXT );
    $idx   = $request->param('idx', Validator::INT );


    $model  = $this->loadModel( 'DaidalosBdlModeller' );
    $model->setKey($key );
    $model->loadFile($file );

    $nodeModel = $this->loadModel( 'DaidalosBdlNode_EntityAttribute' );
    /* @var $nodeModel DaidalosBdlNode_EntityAttribute_Model */
    $nodeModel->loadBdlAttribute($model, $idx );
    
    $attr = $nodeModel->updateByRequest($request, $response );

    $view   = $response->loadView
    (
      'daidalos_bdl-entity-attribute-update-'.md5($file), 
      'DaidalosBdlNode_EntityAttribute',
      'displayUpdate',
      View::AJAX
    );
    /* @var $view DaidalosBdlNode_EntityAttribute_Ajax_View */
    
    $view->setModel($nodeModel );


    $view->displayUpdate($attr, $idx, $nodeModel->entityNode->getName() );
    
    $response->addMessage( "Successfully updated Attribute ".$idx );
    

  }//end public function service_update */
  
  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_delete($request, $response )
  {

    $params = $this->getFlags($request);
    
    $key   = $request->param('key', Validator::CKEY );
    $file  = $request->param('bdl_file', Validator::TEXT );
    $idx   = $request->param('idx', Validator::INT );

    $model  = $this->loadModel( 'DaidalosBdlModeller' );
    $model->setKey($key );
    $model->loadFile($file );

    $nodeModel = $this->loadModel( 'DaidalosBdlNode_EntityAttribute' );
    /* @var $nodeModel DaidalosBdlNode_EntityAttribute_Model */
    $nodeModel->loadEntity($model );
    
    $nodeModel->deleteByIndex($idx );

    $view   = $response->loadView
    (
      'daidalos_bdl-entity-attribute-delete-'.md5($file), 
      'DaidalosBdlNode_EntityAttribute',
      'displayDelete',
      View::AJAX
    );
    /* @var $view DaidalosBdlNode_EntityAttribute_Ajax_View */
    
    $view->setModel($nodeModel );

    $view->displayDelete($idx, $nodeModel->entityNode->getName() );
    
    $response->addMessage( "Successfully dropped Attribute" );

  }//end public function service_delete */

  
} // end class DaidalosBdlNode_EntityAttribute_Controller

