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
class WebfrapNavigation_Controller extends ControllerCrud
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var array
   */
  protected $options           = array
  (
    'explorer' => array(
      'method'  => array('GET'),
      'views'   => array('maintab', 'modal')
    ),
    'search' => array(
      'method'  => array('GET'),
      'views'   => array('ajax')
    ),
    'searchlist' => array(
      'method'  => array('GET'),
      'views'   => array('ajax')
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
  public function service_explorer($request, $response)
  {

    $view = $response->loadView(
      'WebfrapMainMenu',
      'WebfrapNavigation',
      'display'
    );

    $params   = new TArray();
    $menuType = $request->param('mtype', Validator::CNAME);

    if ($menuType)
      $params->menuType = $menuType;
    else
      $params->menuType = 'explorer';

    $view->display('root', $params);

  } // end public function service_explorer */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_search($request, $response)
  {

    // benötigte resourcen laden
    $user      = $this->getUser();

    // load request parameters an interpret as flags
    $params = $this->getListingFlags($request);

    /*
    $access = new WbfsysBan_Acl_Access_Container();
    $access->load($user->getProfileName(),  $params);

    // ok wenn er nichtmal lesen darf, dann ist hier direkt schluss
    if (!$access->admin) {
      // ausgabe einer fehlerseite und adieu
      $this->errorPage
      (
        $response->i18n->l
        (
          'You have no permission for administration in {@resource@}',
          'wbf.message',
          array
          (
            'resource'  => $response->i18n->l('Ban','wbfsys.ban.label')
          )
        ),
        Response::FORBIDDEN
      );

      return false;
    }

    // der Access Container des Users für die Resource wird als flag übergeben
    $params->access = $access;
    */

    $searchKey  = $this->request->param('key', Validator::TEXT);

    $model = $this->loadModel('WebfrapNavigation');

    $view   = $this->tplEngine->loadView('WebfrapNavigation_Ajax');
    $view->setModel($model);

    $error = $view->displayAutocomplete($searchKey, $params);

    // Die Views geben eine Fehlerobjekt zurück, wenn ein Fehler aufgetreten
    // ist der so schwer war, dass die View den Job abbrechen musste
    // alle nötigen Informationen für den Enduser befinden sich in dem
    // Objekt
    // Standardmäßig entscheiden wir uns mal dafür diese dem User auch Zugänglich
    // zu machen und übergeben den Fehler der ErrorPage welche sich um die
    // korrekte Ausgabe kümmert
    if ($error) {

      $this->errorPage($error);
      return false;
    }

    // wunderbar, kein fehler also melden wir einen Erfolg zurück
    return true;

  } // end public function search */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_searchList($request, $response)
  {

    // benötigte resourcen laden
    $user      = $this->getUser();

    // load request parameters an interpret as flags
    $params = $this->getListingFlags($request);

    /*
    $access = new WbfsysBan_Acl_Access_Container();
    $access->load($user->getProfileName(),  $params);

    // ok wenn er nichtmal lesen darf, dann ist hier direkt schluss
    if (!$access->admin) {
      // ausgabe einer fehlerseite und adieu
      $this->errorPage
      (
        $response->i18n->l
        (
          'You have no permission for administration in {@resource@}',
          'wbf.message',
          array
          (
            'resource'  => $response->i18n->l('Ban','wbfsys.ban.label')
          )
        ),
        Response::FORBIDDEN
      );

      return false;
    }

    // der Access Container des Users für die Resource wird als flag übergeben
    $params->access = $access;
    */

    $searchKey  = $this->request->param('key', Validator::TEXT);

    $model = $this->loadModel('WebfrapNavigation');

    $view   = $this->tplEngine->loadView('WebfrapNavigation_Ajax');
    $view->setModel($model);

    $error = $view->displayNavlist($searchKey, $params);

    // Die Views geben eine Fehlerobjekt zurück, wenn ein Fehler aufgetreten
    // ist der so schwer war, dass die View den Job abbrechen musste
    // alle nötigen Informationen für den Enduser befinden sich in dem
    // Objekt
    // Standardmäßig entscheiden wir uns mal dafür diese dem User auch Zugänglich
    // zu machen und übergeben den Fehler der ErrorPage welche sich um die
    // korrekte Ausgabe kümmert
    if ($error) {
      $this->errorPage($error);

      return false;
    }

    // wunderbar, kein fehler also melden wir einen Erfolg zurück
    return true;

  } // end public function searchList */

}//end class ControllerWebfrapBase

