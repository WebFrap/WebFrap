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
 */
class DaidalosGen_Controller
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
    'custom' => array
    (
      //'views'      => array( View::CLI  )
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
  public function service_custom( $request, $response )
  {

    $params = $this->getFlags( $request );
    
    $view   = $response->loadView
    (
      'daidalos_generator', 
      'DaidalosGen',
      'displayGen',
      View::CLI
    );
    
    /* @var $model DaidalosGen_Model  */
    $model  = $this->loadModel( 'DaidalosGen' );
    
    // das Repository in welches generiert werden soll
    $target = $request->param( 'target', Validator::TEXT );
    
    // der Pfad in welchem sich die BDL Dateien befinden
    $bdlPath = $request->param( 'bdl_path', Validator::TEXT );
    
    // existierenden Code einfach überschreiben
    $forceOverwrite = 'true' === $request->param( 'force', Validator::TEXT )?true:false;
    
    // Die Project BDL welche verwendet werden soll
    $bdlProject = $request->param( 'project', Validator::TEXT );
    
    if( !$bdlProject )
      $bdlProject = PATH_GW.'data/daidalos/structure_project.bdl';
      
    $resContext = $response->createContext();
    
    $resContext->assertNotNull
    ( 
      'Missing the target="/path/tp/the/repo" parameter. ', 
      $target 
    );
    
    $resContext->assertNotNull
    ( 
      'Missing the bdl_path="/path/to/the/model/" parameter. ', 
      $bdlPath 
    );
    
    if( $resContext->hasError )
      return;
      
    $bdlPaths = explode( ';', $bdlPath  );
      
    $model->forceOverwrite = $forceOverwrite;
    $model->loadProject( $bdlProject, $bdlPaths, $target );
    $model->targetPath = $target;
    
    
    $model->buildSkeleton( $bdlPaths, $target );
    
    $view->setModel( $model );

    $view->displayGen( $params );

  }//end public function service_custom */
  
  
} // end class DaidalosGen_Controller

