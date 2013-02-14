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
class DaidalosPackage_Controller extends Controller
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
    'workspace' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'maintab' )
    ),
    'syncpackagefiles' => array
    (
      'method'    => array( 'PUT' ),
      'views'      => array( 'ajax' )
    ),
    'edit' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'maintab' )
    ),
    'build' => array
    (
      'method'    => array( 'PUT' ),
      'views'      => array( 'ajax' )
    ),
    'listpackages' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'modal' )
    ),
    'deletepackage' => array
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
  public function service_workspace( $request, $response )
  {
    
    ///@throws InvalidRequest_Exception
    $view = $response->loadView
    (
      'maintenance-packages-list', 
      'DaidalosPackage_Workspace' , 
      'displayWorkspace',
      null,
      true
    );
    /* @var $view DaidalosPackage_Workspace_Maintab_View */
    
    $params = $this->getFlags( $request );

    $model = $this->loadModel( 'DaidalosPackage' );
  
    $view->setModel( $model );
    $view->displayWorkspace( $params );
    
  }//end public function service_workspace */
  
  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_syncPackageFiles( $request, $response )
  {
    
    $params = $this->getFlags( $request );
    
    $key   = $request->param( 'package', Validator::CKEY );
    $type  = $request->param( 'type', Validator::CKEY );
  
    if (!$key || !$type )
    {
      throw new InvalidParam_Exception('Missing required parameters');
    }

    $params->type = $type;
    
    ///@throws InvalidRequest_Exception
    $view = $response->loadView
    (
      'maintenance-packages-list', 
      'DaidalosPackage' , 
      'displayFileSync',
      null,
      true
    );
    /* @var $view DaidalosPackage_Workspace_Maintab_View */


    $model = $this->loadModel( 'DaidalosPackage' );
    /* @var $model DaidalosPackage_Model */

    $numFiles = $model->syncPackageFiles( $key );
  
    $view->setModel( $model );
    $view->displayFileSync( $numFiles, $params );
    
  }//end public function service_syncPackageFiles */
  
  
  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_edit( $request, $response )
  {
    
    $key   = $request->param( 'package', Validator::CKEY );
    $type  = $request->param( 'type', Validator::CKEY );
    
        
    if (!$key || !$type )
    {
      throw new InvalidParam_Exception('Missing required parameters');
    }
    
    ///@throws InvalidRequest_Exception
    $view = $response->loadView
    (
      'daidalos-package-editor-'.$key, 
      'DaidalosPackage_Editor' , 
      'displayEditor',
      null,
      true
    );
    /* @var $view DaidalosPackage_Editor_Maintab_View */
    
    $params = $this->getFlags( $request );
    $params->key  = $key;
    $params->type = $type;

    $model = $this->loadModel( 'DaidalosPackage' );
    /* @var $model DaidalosPackage_Model */
  
    $view->setModel( $model );
    $view->displayEditor( $key, $params );
    
  }//end public function service_edit */
  
  /**
   * Bauen eines neue packages
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_build( $request, $response )
  {
    
    $params = $this->getFlags( $request );
    
    $packageKey = $request->param( 'package', Validator::CKEY );
    $buildKey   = $request->data( 'key', Validator::CKEY );
    $type       = $request->param( 'type', Validator::CKEY );
      
    if (!$packageKey || !$buildKey || !$type )
    {
      throw new InvalidParam_Exception('Missing required parameters');
    }
    
    $params->type = $type;
    
    ///@throws InvalidRequest_Exception
    $view = $response->loadView
    (
      'daidalos-package-editor-'.$packageKey, 
      'DaidalosPackage_Builder' , 
      'displayBuild',
      View::AJAX,
      true
    );
    /* @var $view DaidalosPackage_Builder_Ajax_View */
    

    $model = $this->loadModel( 'DaidalosPackage' );
    /* @var $model DaidalosPackage_Model */
    
    $model->buildPackage( $packageKey, $buildKey, $type );
  
    $view->setModel( $model );
    $view->displayBuild( $packageKey, $packageKey.'-'.$buildKey.'.package',  $params );
    
  }//end public function service_build */
  
  
  /**
   * Aufliste der erstellten packages in einem modal window
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_listPackages( $request, $response )
  {
    
    $params = $this->getFlags( $request );
    
    $packageKey = $request->param( 'package', Validator::CKEY );
    $type       = $request->param( 'type', Validator::CKEY );
    
    if (!$packageKey || !$type )
    {
      throw new InvalidParam_Exception('Missing required parameters');
    }

    $params->type = $type;
    
    ///@throws InvalidRequest_Exception
    $view = $response->loadView
    (
      'daidalos-package-editor-'.$packageKey, 
      'DaidalosPackage_Builder' , 
      'displayPackageList',
      View::MODAL,
      true
    );
    /* @var $view DaidalosPackage_Builder_Modal_View */

    $model = $this->loadModel( 'DaidalosPackage' );
    /* @var $model DaidalosPackage_Model */
  
    $view->setModel( $model );
    $view->displayPackageList( $packageKey, $params );
    
  }//end public function service_listPackages */
  
  /**
   * Service zum löschen eines packages
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_deletePackage( $request, $response )
  {
    
    $params = $this->getFlags( $request );
    
    $packageKey = $request->param( 'package', Validator::CKEY );
    $toDelete   = $request->param( 'file', Validator::FILENAME );
    $type       = $request->param( 'type', Validator::CKEY );

    $params->type = $type;
    
    if (!$packageKey || !$toDelete || !$type )
    {
      throw new InvalidParam_Exception('Missing required parameters');
    }
    
    ///@throws InvalidRequest_Exception
    $view = $response->loadView
    (
      'daidalos-package-editor-delete-'.$packageKey, 
      'DaidalosPackage_Builder' , 
      'displayDelete',
      View::AJAX,
      true
    );
    /* @var $view DaidalosPackage_Builder_Ajax_View */

    $model = $this->loadModel( 'DaidalosPackage' );
    /* @var $model DaidalosPackage_Model */
    $model->deletePackage( $packageKey, $toDelete, $type );
  
    $view->setModel( $model );
    $view->displayDelete( $packageKey, $toDelete, $params );
    
  }//end public function service_deletePackage */

} // end class DaidalosPackage_Controller


