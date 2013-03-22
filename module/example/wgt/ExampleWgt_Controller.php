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
class ExampleWgt_Controller extends Controller
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
    'tree' => array
    (
      'method'    => array('GET'),
      'views'      => array('maintab')
    ),
    'area' => array
    (
      'method'    => array('GET'),
      'views'      => array('area')
    ),
    'dump' => array
    (
      'method'    => array('GET','POST','PUT'),
      'views'      => array('area')
    ),
  );

/*//////////////////////////////////////////////////////////////////////////////
// Methoden
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_tree($request, $response)
  {

    /* @var $view ExampleBase_Maintab_View  */
    $view = $response->loadView
    (
      'example-wgt-tree',
      'ExampleWgt',
      'displayTree'
    );

    $view->displayTree();

  }//end public function service_tree */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_area($request, $response)
  {

    $area = $request->param('area', Validator::TEXT);

    /* @var $view ExampleBase_Maintab_View  */
    $view = $response->loadView
    (
      'example-wgt-area-'.str_replace('.', '_', $area),
      'ExampleWgt',
      'displayArea'
    );

    $view->displayArea($area);

  }//end public function service_area */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_dump($request, $response)
  {

    /* @var $view ExampleBase_Maintab_View  */
    $view = $response->loadView(
      'example-wgt-area-console',
      'ExampleWgt',
      'displayConsole'
    );

    $view->displayConsole($request);

  }//end public function service_area */

}//end class ExampleBase_Controller

