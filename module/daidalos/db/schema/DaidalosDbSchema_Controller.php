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
 * class ControllerAdmintoolsPostgres
 * Extention zum anzeigen dieverser Systemdaten
 */
class DaidalosDbSchema_Controller extends Controller
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
    'listschema' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'maintab'  )
    ),
    'listviews' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'maintab'  )
    ),
    'listtables' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'maintab'  )
    ),
    'listsequences' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'maintab'  )
    ),
    'listbackups' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'modal'  )
    ),
    'dumpschema' => array
    (
      'method'    => array( 'POST' ),
      'views'      => array( 'modal'  )
    ),
    'restoredump' => array
    (
      'method'    => array( 'PUT' ),
      'views'      => array( 'ajax'  )
    ),
    'deletedump' => array
    (
      'method'    => array( 'DELETE' ),
      'views'      => array( 'ajax'  )
    ),
    'uploaddump' => array
    (
      'method'    => array( 'POST' ),
      'views'      => array( 'ajax'  )
    ),
    'drop' => array
    (
      'method'    => array( 'DELETE' ),
      'views'      => array( 'maintab'  )
    ),
  );
  
  
/*//////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////*/

  
  
  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_listSchema($request, $response )
  {
    
    $params = $this->getFlags($request);
    
    $view   = $response->loadView
    (
      'daidalos_schema_list-schema', 
      'DaidalosDbSchema',
      'display',
      View::MAINTAB
    );

    $model  = $this->loadModel( 'DaidalosDb' );
    $view->setModel($model );

    $view->display($request, $response, $params );

  }//end public function listSchema */
  


  
  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_listViews($request, $response )
  {
    
    $params = $this->getFlags($request);
    
    $dbKey     = $request->param('db', Validator::CKEY );
    $schemaKey = $request->param('schema', Validator::CKEY );  
    
    $view   = $response->loadView
    (
      'daidalos_db-'.$dbKey.'-views-'.$schemaKey, 
      'DaidalosDbSchema',
      'displayBackup',
      View::MAINTAB
    );

    $model  = $this->loadModel( 'DaidalosDbSchema' );
    $view->setModel($model );


    $view->displayBackup($dbKey, $schemaKey, $params );

  }//end public function service_listViews */
  
  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_listTables($request, $response )
  {
    
    $params = $this->getFlags($request);
    
    $dbKey     = $request->param('db', Validator::CKEY );
    $schemaKey = $request->param('schema', Validator::CKEY );  
    
    $view   = $response->loadView
    (
      'daidalos_db-'.$dbKey.'-tables-'.$schemaKey, 
      'DaidalosDbSchema',
      'displayBackup',
      View::MAINTAB
    );

    $model  = $this->loadModel( 'DaidalosDbSchema' );
    $view->setModel($model );


    $view->displayBackup($dbKey, $schemaKey, $params );

  }//end public function service_listTables */
  
  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_listSequences($request, $response )
  {
    
    $params = $this->getFlags($request);
    
    $dbKey     = $request->param('db', Validator::CKEY );
    $schemaKey = $request->param('schema', Validator::CKEY );  
    
    $view   = $response->loadView
    (
      'daidalos_db-'.$dbKey.'-schema-'.$schemaKey, 
      'DaidalosDbSchema',
      'displayBackup',
      View::MAINTAB
    );

    $model  = $this->loadModel( 'DaidalosDbSchema' );
    /* @var $model DaidalosDbSchema_Model */
    
    $view->setModel($model );
    $view->displayBackup($dbKey, $schemaKey, $params );

  }//end public function service_listSequences */
  
  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_dumpSchema($request, $response )
  {
    
    $params = $this->getFlags($request);
    
    $dbKey     = $request->param('db', Validator::CKEY );
    $schemaKey = $request->param('schema', Validator::CKEY );  
    
    $view   = $response->loadView
    (
      'daidalos_db-'.$dbKey.'-schema-'.$schemaKey, 
      'DaidalosDbSchema_Backup',
      'displayBackups',
      View::MODAL
    );

    $model  = $this->loadModel( 'DaidalosDbSchema' );
    /* @var $model DaidalosDbSchema_Model */
    $view->setModel($model );
    
    $model->createSchemaBackup($dbKey, $schemaKey );

    $view->displayBackups($dbKey, $schemaKey, $params );

  }//end public function service_dumpSchema */

  
  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_listBackups($request, $response )
  {
    
    $params = $this->getFlags($request);
    
    $dbKey     = $request->param('db', Validator::CKEY );
    $schemaKey = $request->param('schema', Validator::CKEY );  
    
    $view   = $response->loadView
    (
      'daidalos_db-'.$dbKey.'-schema-'.$schemaKey, 
      'DaidalosDbSchema_Backup',
      'displayBackups',
      View::MODAL
    );

    $model  = $this->loadModel( 'DaidalosDbSchema' );
    /* @var $model DaidalosDbSchema_Model */
    $view->setModel($model );


    $view->displayBackups($dbKey, $schemaKey, $params );

  }//end public function service_listBackups */
  
  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_restoreDump($request, $response )
  {
    
    $params = $this->getFlags($request);
    
    $dbKey     = $request->param('db', Validator::CKEY );
    $schemaKey = $request->param('schema', Validator::CKEY );  
    $dumpKey   = $request->param('dump', Validator::FILENAME );  
    
    $view   = $response->loadView
    (
      'daidalos_db-'.$dbKey.'-schema-'.$schemaKey, 
      'DaidalosDbSchema_Backup',
      'displayRestore',
      View::AJAX
    );

    $model  = $this->loadModel( 'DaidalosDbSchema' );
    /* @var $model DaidalosDbSchema_Model */
    
    $model->restoreSchemaBackup($dbKey, $schemaKey, $dumpKey );
    
    $view->setModel($model );
    $view->displayRestore($dbKey, $schemaKey, $params );

  }//end public function service_restoreDump */
  
  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_uploadDump($request, $response )
  {
    
    $params = $this->getFlags($request);
    
    $dbKey     = $request->param('db', Validator::CKEY );
    $schemaKey = $request->param('schema', Validator::CKEY );  
    
    $view   = $response->loadView
    (
      'daidalos_db-'.$dbKey.'-schema-'.$schemaKey, 
      'DaidalosDbSchema_Backup',
      'displayUpload',
      View::AJAX
    );
    /* @var $view DaidalosDbSchema_Backup_Ajax_View */

    $model  = $this->loadModel( 'DaidalosDbSchema' );
    /* @var $model DaidalosDbSchema_Model */
    
    $uplDump = $model->uploadDump($dbKey, $schemaKey, $request );
    
    if (!$uplDump )
      throw InvalidParam_Exception( 'Missing the dump to upload' );

    $view->setModel($model );
    $view->displayUpload($uplDump, $dbKey, $schemaKey, $params );

  }//end public function service_uploadDump */
  
  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_deleteDump($request, $response )
  {
    
    $params = $this->getFlags($request);
    
    $dbKey     = $request->param('db', Validator::CKEY );
    $schemaKey = $request->param('schema', Validator::CKEY );  
    $dumpKey   = $request->param('dump', Validator::FILENAME );  
    
    $view   = $response->loadView
    (
      'daidalos_db-'.$dbKey.'-schema-'.$schemaKey, 
      'DaidalosDbSchema_Backup',
      'displayDelete',
      View::AJAX
    );
    /* @var $view DaidalosDbSchema_Backup_Ajax_View */

    $model  = $this->loadModel( 'DaidalosDbSchema' );
    /* @var $model DaidalosDbSchema_Model */
    $model->deleteDump($dbKey, $schemaKey, $dumpKey );
    
    $view->setModel($model );
    $view->displayDelete($dbKey, $schemaKey, $dumpKey, $params );

  }//end public function service_deleteDump */

} // end class DaidalosDb_Controller

