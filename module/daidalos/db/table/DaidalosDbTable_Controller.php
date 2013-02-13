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
class DaidalosDbTable_Controller
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
      'views'      => array( 'maintab'  )
    ),
    'props' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'maintab'  )
    ),
    'rights' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'maintab'  )
    ),
    'delete' => array
    (
      'method'    => array( 'DELETE' ),
      'views'      => array( 'ajax' )
    ),
    'deletewbfviews' => array
    (
      'method'    => array( 'DELETE' ),
      'views'      => array( 'ajax' )
    ),
    'createwbfsviews' => array
    (
      'method'    => array( 'PUT' ),
      'views'      => array( 'ajax' )
    ),
    'recreatewbfviews' => array
    (
      'method'    => array( 'PUT' ),
      'views'      => array( 'ajax' )
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
  public function service_listing( $request, $response )
  {

    $params = $this->getFlags( $request );
    
    $dbName     = $request->param( "db", Validator::CNAME );
    $schemaName = $request->param( "schema", Validator::CNAME );
    
    $view   = $response->loadView
    (
      'daidalos_db-'.$dbName.'-s-'.$schemaName.'-listing', 
      'DaidalosDbView',
      'displayListing',
      View::MAINTAB,
      true
    );

    $model  = $this->loadModel( 'DaidalosDbView' );
    $model->dbName     = $dbName;
    $model->schemaName = $schemaName;
    $params->dbName     = $dbName;
    $params->schemaName = $schemaName;
    
    $view->setModel( $model );

    $view->displayListing( $params );

  }//end public function listing */
  
 
  
  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_delete( $request, $response )
  {

    $params = $this->getFlags( $request );


    $model  = $this->loadModel( 'DaidalosDb' );


  }//end public function service_restore */
  
/*//////////////////////////////////////////////////////////////////////////////
// WBF Logic
//////////////////////////////////////////////////////////////////////////////*/
  
  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_deleteWbfViews( $request, $response )
  {

    $params = $this->getFlags( $request );
    
    $dbName     = $request->param( "db", Validator::CNAME );
    $schemaName = $request->param( "schema", Validator::CNAME );

    $model  = $this->loadModel( 'DaidalosDbView' );
    
    $model->dropWbfViews( $schemaName );
    
    $response->addMessage( "Dropped WBF Views" );

  }//end public function service_deleteWbfViews */
  
  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_createWbfViews( $request, $response )
  {

    $params = $this->getFlags( $request );
    
    $dbName     = $request->param( "db", Validator::CNAME );
    $schemaName = $request->param( "schema", Validator::CNAME );

    $model  = $this->loadModel( 'DaidalosDbView' );
    
    $model->createWbfViews( $schemaName );

  }//end public function service_createWbfViews */
  
  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_reCreateWbfViews( $request, $response )
  {

    $params = $this->getFlags( $request );
    
    $dbName     = $request->param( "db", Validator::CNAME );
    $schemaName = $request->param( "schema", Validator::CNAME );

    $model  = $this->loadModel( 'DaidalosDbView' );
    
    $model->dropWbfViews( $schemaName );
    $model->createWbfViews( $schemaName );

  }//end public function service_reCreateWbfViews */
  
} // end class DaidalosDb_Controller

