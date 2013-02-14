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
class DaidalosBdlProject_Controller extends Controller
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
  public function service_edit( $request, $response )
  {

    $params = $this->getFlags( $request );
    
    $key = $request->param( 'key', Validator::CKEY );
    
    $view   = $response->loadView
    (
      'daidalos_bld_project-edit-'.$key, 
      'DaidalosBdlProject',
      'displayFormEdit',
      View::MAINTAB
    );

    $model  = $this->loadModel( 'DaidalosBdlProject' );
    $model->setKey( $key );
    $view->setModel( $model );

    $view->displayFormEdit( $params );

  }//end public function service_formBackup */
  

  
} // end class DaidalosBdlProject_Controller

