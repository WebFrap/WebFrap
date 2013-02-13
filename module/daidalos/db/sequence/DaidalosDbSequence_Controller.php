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
class DaidalosDbSequence_Controller
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
    'listuser' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'maintab'  )
    ),
    'createuser' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'maintab'  )
    ),
    'edituser' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'maintab'  )
    ),
    'insertuser' => array
    (
      'method'    => array( 'POST' ),
      'views'      => array( 'ajax'  )
    ),
    'updateuser' => array
    (
      'method'    => array( 'PUT' ),
      'views'      => array( 'ajax'  )
    ),
    'deleteuser' => array
    (
      'method'    => array( 'DELETE' ),
      'views'      => array( 'ajax'  )
    ),
    
    
    'listgroup' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'maintab'  )
    ),
    'creategroup' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'maintab'  )
    ),
    'editgroup' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'maintab'  )
    ),
    'insertgroup' => array
    (
      'method'    => array( 'POST' ),
      'views'      => array( 'ajax'  )
    ),
    'updategroup' => array
    (
      'method'    => array( 'PUT' ),
      'views'      => array( 'ajax'  )
    ),
    'deletegroup' => array
    (
      'method'    => array( 'DELETE' ),
      'views'      => array( 'ajax'  )
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
  public function service_listUsers( $request, $response )
  {

    $params = $this->getFlags( $request );

    $view   = $response->loadView
    (
      'daidalos_db-list-users', 
      'DaidalosDbRole_User_List',
      'displayList',
      View::MAINTAB,
      true
    );

    $model  = $this->loadModel( 'DaidalosDbRole' );

    $view->setModel( $model );

    $view->displayList( $params );

  }//end public function service_listUsers */
  
 
  
} // end class DaidalosDbRole_Controller

