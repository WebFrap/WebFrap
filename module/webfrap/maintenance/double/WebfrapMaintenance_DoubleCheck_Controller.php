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
 * @subpackage Maintenance
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class WebfrapMaintenance_DoubleCheck_Controller
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
    'form' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'maintab' )
    ),
    'list' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'maintab' )
    ),
    'subtree' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'ajax' )
    ),
  );

////////////////////////////////////////////////////////////////////////////////
// Methoden
////////////////////////////////////////////////////////////////////////////////

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_form( $request, $response )
  {

    ///@trows InvalidRequest_Exception
    $view = $response->loadView
    (
      'webfrap-maintenance-entity-form',
      'WebfrapMaintenance_DoubleCheck_Form' ,
      'displayform'
    );

    $view->displayform( );

  }//end public function service_form */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_showDoubles( $request, $response )
  {

    ///@trows InvalidRequest_Exception
    $view = $response->loadView
    (
      'webfrap-maintenance-entity-form',
      'WebfrapMaintenance_DoubleCheck_Show' ,
      'displayform'
    );

    $view->displayform( );

  }//end public function service_showDoubles */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_list( $request, $response )
  {

    ///@trows InvalidRequest_Exception
    $view = $response->loadView
    (
      'webfrap-maintenance-entity-list',
      'WebfrapMaintenance_DataIndex_Stats' ,
      'displayStats',
      null,
      true
    );

    $params = $this->getFlags( $request );

    $model = $this->loadModel( 'WebfrapMaintenance_DataIndex' );

    $view->setModel( $model );
    $view->displayStats( $params );

  }//end public function service_list */

}//end class WebfrapMaintenance_DataIndex_Controller
