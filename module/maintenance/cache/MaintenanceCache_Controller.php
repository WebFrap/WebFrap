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
class MaintenanceCache_Controller
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
    'stats' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'maintab' )
    ),
    'cleanall' => array
    (
      'method'    => array( 'GET' )
    ),
  );

////////////////////////////////////////////////////////////////////////////////
// Base Methodes
////////////////////////////////////////////////////////////////////////////////

  
  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_stats( $request, $response )
  {
    
    ///@trows InvalidRequest_Exception
    $view = $response->loadView
    (
      'webfrap-maintenance-cache-stats', 
      'MaintenanceCache' , 
      'displayStats',
      null,
      true
    );
    
    $params = $this->getFlags( $request );

    $model = $this->loadModel( 'MaintenanceCache' );
  
    $view->setModel( $model );
    $view->displayStats( $params );
    
  }//end public function service_stats */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_cleanAll( $request, $response )
  {

    // now we just to have to clean the code folder :-)
    $toClean = array
    (
      PATH_GW.'cache/'
    );

    foreach( $toClean as $folder )
    {
      if( SFilesystem::cleanFolder($folder) )
      {
        Message::addMessage(I18n::s
        (
          'Successfully cleaned the cache',
          'wbf.message'
        ));
      }
      else
      {
        Message::addError(I18n::s
        (
          'Failed to cleane the cache',
          'wbf.message'
        ));
      }
    }

  }//end public function service_cleanAll */
  
  

  /**
   *
   * @return void
   */
  public function cleanCache()
  {

    ///FIXME architecture

    $this->view->setTemplate('Plain','base');

    // now we just to have to clean the code folder :-)
    $toClean = array
    (
      PATH_GW.'cache/entity_cache/',
      PATH_GW.'cache/virtual_entity_cache/'
    );

    foreach( $toClean as $folder )
    {
      if(SFilesystem::cleanFolder($folder))
      {
        Message::addMessage(I18n::s
        (
          'Successfully cleaned cache {@folder@}',
          'wbf.message',
          array('folder' => $folder)
        ));
      }
      else
      {
        Message::addError(I18n::s
        (
          'Failed to cleane cache {@folder@}',
          'wbf.message',
          array( 'folder' => $folder)
        ));
      }
    }

  }//end public function cleanCache */
  

} // end class MaintenanceCache_Controller


