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
class WebfrapYggdrasil_Controller extends Controller
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
    'root' => array
    (
      'method'    => array('GET'),
      'views'      => array('maintab')
    ),
    'subtree' => array
    (
      'method'    => array('GET'),
      'views'      => array('ajax')
    ),
  );

/*//////////////////////////////////////////////////////////////////////////////
// Methoden
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return void
   */
  public function service_root($request, $response)
  {

    $params = $this->getFlags($request);

    $view = $response->loadView('root-webfrap_yggdrasil', 'WebfrapYggdrasil');

    if (!$view)
      throw new InvalidRequest_Exception("The requested Outputformat is not implemented");

    $model = $this->loadModel('WebfrapYggdrasil');

    $view->setModel($model);
    $view->displayRoot($params);

  }//end public function service_root */

 /**
  * open tab comments for management view  project_project_mask_planning
  * @param LibRequestHttp $request
  * @param LibResponseHttp $response
  */
  public function service_subTree($request, $response)
  {

    $params  = $this->getFlags($request);

    $nodeId  = $request->param('node', Validator::TEXT);

    $tmp      = explode('-', $nodeId);
    $moduleId = array_pop($tmp);
    $nodeType = ucfirst(array_pop($tmp));

    $model = $this->loadModel('WebfrapYggdrasil');

    // create a new area with the id of the target element, this area will replace
    // the HTML Node of the target UI Element
    $view      = $this->tpl->newSubView
    (
      $nodeId,
      'WebfrapYggdrasil_'.$nodeType.'_Ajax'
    );
    if (!$view)
      throw new InternalError_Exception("Failed to load a necessary system component");

    $view->setPosition('li#'.$nodeId.'>ul');
    $view->setModel($model);

    $view->displaySubnode($moduleId, $params);

    // everything is fine
    return State::OK;

  }//end public function service_subTree */

}//end class WebfrapYggdrasil_Controller

