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
class DaidalosDb_Controller
  extends Controller
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////
  
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
      'views'      => array( 'maintab'  )
    ),
    'listschema' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'maintab' )
    ),
    'query' => array
    (
      'method'    => array( 'GET','POST' ),
      'views'      => array( 'ajax' )
    ),
    'listschematables' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'maintab' )
    ),
    'formbackup' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'maintab' )
    ),
    'backup' => array
    (
      'method'    => array( 'PUT' ),
      'views'      => array( 'maintab' )
    ),
    'listrestore' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'maintab' )
    ),
    'restore' => array
    (
      'method'    => array( 'PUT' ),
      'views'      => array( 'ajax' )
    ),
    'deletedump' => array
    (
      'method'    => array( 'DELETE' ),
      'views'      => array( 'ajax' )
    ),
  );
  
////////////////////////////////////////////////////////////////////////////////
// Methodes
////////////////////////////////////////////////////////////////////////////////

  
  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_listing( $request, $response )
  {

    $params = $this->getFlags( $request );
    
    $view   = $response->loadView
    (
      'daidalos_schema_list', 
      'DaidalosDb',
      'displayListing',
      View::MAINTAB
    );

    $model  = $this->loadModel( 'DaidalosDb' );
    $view->setModel( $model );

    $view->displayListing( $params );

  }//end public function listing */
  
  
  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_listSchema( $request, $response )
  {
    
    $params = $this->getFlags( $request );
    
    $view   = $response->loadView
    (
      'daidalos_schema_list-schema', 
      'DaidalosDbSchema',
      'display',
      View::MAINTAB
    );

    $model  = $this->loadModel( 'DaidalosDb' );
    $view->setModel( $model );


    $view->display( $request, $response, $params );

  }//end public function listSchema */
  
  /**
   * @param TFlag $params
   * @return void
   */
  public function service_query( $request, $response )
  {
    
    $db   = $this->getDb();

    $view = $response->loadView( 'daidalos_db_query', 'DaidalosDb' );

    $view->setTitle( 'Query Tester' );
    $view->setLabel( 'Query Tester' );
    $view->setTemplate( 'daidalos/db/display_query' );

    if( $query = $request->post( 'query', Validator::TEXT ) )
    {
      $view->addVar( 'result', $db->select( $query ) );
      $view->addVar( 'query', $query );
    }

  }//end public function query */


////////////////////////////////////////////////////////////////////////////////
// Schema Logic
////////////////////////////////////////////////////////////////////////////////

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_listSchemaTables( $request, $response )
  {
    
    $params = $this->getFlags( $request );
    
    $dbKey = $request->param( 'db', Validator::CKEY );
    $schemaKey = $request->param( 'schema', Validator::CKEY );  
    
    $view   = $response->loadView
    (
      'daidalos_db-'.$dbKey.'-schema-'.$schemaKey.'-tables', 
      'DaidalosDbSchemaTable',
      'display',
      View::MAINTAB
    );

    $model  = $this->loadModel( 'DaidalosDb' );
    $view->setModel( $model );

    $view->display( $dbKey, $schemaKey, $params );

  }//end public function listSchema */

////////////////////////////////////////////////////////////////////////////////
// Backup & Restore
////////////////////////////////////////////////////////////////////////////////

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_formBackup( $request, $response )
  {

    $params = $this->getFlags( $request );
    
    $key = $request->param( 'key', Validator::CKEY );
    
    $view   = $response->loadView
    (
      'daidalos_db_form_backup-'.$key, 
      'DaidalosDbBackup',
      'displayForm',
      View::MAINTAB
    );

    $model  = $this->loadModel( 'DaidalosDbBackup' );
    $view->setModel( $model );
    
    

    $view->displayForm( $key, $params );

  }//end public function service_formBackup */
  
  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_backup( $request, $response )
  {

    $params = $this->getFlags( $request );
    
    $key = $request->param( 'key', Validator::CKEY );
    
    $prefix = $request->data( 'prefix', Validator::TEXT );
    
    $view   = $response->loadView
    (
      'daidalos_schema_list_restore-'.$key, 
      'DaidalosDbBackup',
      'displayList',
      View::MAINTAB
    );

    $model  = $this->loadModel( 'DaidalosDbBackup' );

    $view->setModel( $model );
    
    $view->importMsg = $model->createDbBackup( $key, $prefix );    

    $view->displayList( $key, $params );

  }//end public function service_backup */
  
  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_listRestore( $request, $response )
  {

    $params = $this->getFlags( $request );
    
    $key    = $request->param( 'key', Validator::CKEY );
    
    $view   = $response->loadView
    (
      'daidalos_schema_list_restore-'.$key, 
      'DaidalosDbBackup',
      'displayList',
      View::MAINTAB
    );

    $model  = $this->loadModel( 'DaidalosDbBackup' );

    $view->setModel( $model );

    $view->displayList( $key, $params );

  }//end public function service_listRestore */
  
  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_restore( $request, $response )
  {

    $params = $this->getFlags( $request );
    
    $view   = $response->loadView
    (
      'daidalos_schema_list', 
      'DaidalosDb',
      'display',
      View::MAINTAB
    );

    $model  = $this->loadModel( 'DaidalosDb' );
    $view->setModel( $model );

    $view->display( $params );

  }//end public function service_restore */
  
  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_deleteDump( $request, $response )
  {

    $params = $this->getFlags( $request );


    $model  = $this->loadModel( 'DaidalosDb' );


  }//end public function service_restore */
  
} // end class DaidalosDb_Controller

