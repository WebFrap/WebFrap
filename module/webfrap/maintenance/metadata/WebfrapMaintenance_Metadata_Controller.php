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
 * @subpackage maintenance/process
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class WebfrapMaintenance_Metadata_Controller extends Controller
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
    'stats' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'modal' )
    ),
    'cleansource' => array
    (
      'method'    => array( 'DELETE' ),
      'views'      => array( 'modal' )
    ),
    'cleanall' => array
    (
      'method'    => array( 'DELETE' ),
      'views'      => array( 'modal' )
    )
  );

/*//////////////////////////////////////////////////////////////////////////////
// Methoden
//////////////////////////////////////////////////////////////////////////////*/


  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_stats($request, $response )
  {
    
    /* @var $view WebfrapMaintenance_Metadata_Modal_View  */
    $view = $response->loadView
    (
      'webfrap-maintenance-metadata-stats', 
      'WebfrapMaintenance_Metadata' , 
      'displayStats'
    );

    $model = $this->loadModel( 'WebfrapMaintenance_Metadata' );
  
    $view->setModel($model );
    $view->displayStats( );
    
  }//end public function service_stats */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_cleanAll($request, $response )
  {
    
    /* @var $model WebfrapMaintenance_Metadata_Model */
    $model = $this->loadModel( 'WebfrapMaintenance_Metadata' );
    $model->cleanAllMetadata();
    
    $response->addMessage( "Cleaned Metadata" );
    
    /* @var $view WebfrapMaintenance_Metadata_Log_Modal_View  */
    $view = $response->loadView
    (
      'webfrap-maintenance-metadata-cleanlog', 
      'WebfrapMaintenance_Metadata_Log' , 
      'displayLog'
    );

    $view->setModel($model );
    $view->displayLog( );
    
  }//end public function service_cleanAll */
  

}//end class WebfrapMaintenance_Metadata_Controller

