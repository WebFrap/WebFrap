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
class CmsBlogFront_Controller extends Controller
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
    'page' => array
    (
      'method'    => array('GET'),
      'views'      => array('html')
    ),
    'preview' => array
    (
      'method'    => array('GET'),
      'views'      => array('html', 'maintab')
    ),
  );

  /**
   * @var boolean
   */
  protected $fullAccess         = true;

/*//////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////*/

 /**
  *
  * @param LibRequestHttp $request
  * @param LibResponseHttp $response
  * @return boolean
  */
  public function service_page($request, $response)
  {

    $request = $this->getRequest();

    // load the flow flags
    $params   = $this->getPageFlags($request);

    $model    = $this->loadModel('CmsFront');

    /* @var $view CmsFront_Html_View */
    $view     = $response->loadView
    (
      'cms-page',
      'CmsFront',
      'displayPage'
    );

    $view->setModel($model);
    $view->setRequest($request);

    $key    = $request->param('p', Validator::CKEY)?:'default';
    $rowid  = $request->param('objid', Validator::EID);

    if ($rowid)
      $key = $rowid;

    // call the create form on the view
    $view->displayPage($key, $params);

  }//end public function service_page */

 /**
  *
  * @param TFlag $params named parameters
  * @return boolean
  */
  public function service_preview($request, $response)
  {

    $request = $this->getRequest();

    // load the flow flags
    $params   = $this->getPageFlags($request);

    $key    = $request->param('p', Validator::CKEY)?:'default';
    $rowid  = $request->param('objid', Validator::EID);

    $view     = $response->loadView
    (
      'cms-preview',
      'CmsFront',
      'displayPreview'
    );

    $model = $this->loadModel('CmsFront');
    $view->setModel($model);

    if ($rowid)
      $key = $rowid;

    // call the create form on the view
    if (!$view->displayPreview($key, $params)) {
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

  }//end public function service_preview */

  /**
   * get the form flags for this management
   * @param LibHttpRequest $request
   * @return TFlag
   */
  protected function getPageFlags($request)
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

