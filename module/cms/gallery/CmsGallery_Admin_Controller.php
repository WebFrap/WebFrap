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
 *
 * @package WebFrap
 * @subpackage Core
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class CmsGallery_Admin_Controller extends Controller
{

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
    'show' => array
    (
      'method'    => array('GET'),
      'views'      => array('modal', 'maintab')
    ),
  );

 /**
  * @param LibRequestHttp $request
  * @param LibResponseHttp $response
  * @return boolean
  */
  public function service_show($request, $response  )
  {

    // load the flow flags
    $params   = $this->getFlags($request);

    $model    = $this->loadModel('CmsGallery_Admin');

    $view     = $response->loadView(
      'cms_gallery-admin-show',
      'CmsGallery_Admin',
       'displayGallery',
      null,
      true
    );

    $view->setModel($model);

    // call the create form on the view
    if (!$view->displayGallery($key, $params)) {
      // if display fails show the error page
      $this->errorPage
      (
        $this->tplEngine->i18n->l
        (
          'Request Failed',
          'wbf.message'
        ),
        Response::INTERNAL_ERROR
      );

      return false;
    }

    return true;

  }//end public function service_show */

  /**
   * get the form flags for this management
   * @param TFlag $flowFlags
   * @return TFlag
   */
  protected function getFlags($request)
  {

      $flowFlags = new TFlag();

    // the publish type, like selectbox, tree, table..
    if ($publish  = $request->param('publish', Validator::CNAME))
      $flowFlags->publish   = $publish;

    // if of the target element, can be a table, a tree or whatever
    if ($targetId = $request->param('targetId', Validator::CNAME))
      $flowFlags->targetId  = $targetId;

    // callback for a target function in thr browser
    if ($target   = $request->param('target', Validator::CNAME))
      $flowFlags->target    = $target;

    return $flowFlags;

  }//end protected function getPageFlags */

} // end class CmsFront_Controller

