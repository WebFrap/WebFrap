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
 */
class DaidalosCodeRepository_Controller extends Controller
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
    'archive' => array
    (
      'method'    => array( 'PUT' ),
      'views'      => array( 'ajax' )
    ),
  );

/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return void
   */
  public function service_listing($request, $response )
  {

    if ($this->tplEngine->isType( View::WINDOW ) ) {
      $view = $this->tplEngine->newWindow( 'DaidalosCodeRepository', 'DaidalosCodeRepository' );
    } else {
      $view = $this->tplEngine;
    }

    $model = $this->loadModel( 'DaidalosCodeRepository' );
    $view->setModel($model );

    $params = $this->getFlags($this->getRequest() );

    $view->displayListing($params );

  } // end public function listing

  /**
   * @return void
   */
  public function service_syncAll( )
  {

    $model = $this->loadModel( 'DaidalosProjects' );
    $params = $this->getFlags($this->getRequest() );

  } // end public function sync

  /**
   * @return void
   */
  public function service_sync( )
  {

    $model = $this->loadModel( 'DaidalosProjects' );
    $params = $this->getFlags($this->getRequest() );

  } // end public function sync

}//end class DaidalosCodeRepository_Controller

