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
class MaintenanceDb_Index_Controller extends Controller
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
    'stats' => array
    (
      'method'    => array('GET'),
      'views'      => array('maintab')
    ),
    'recalcall' => array
    (
      'method'    => array('PUT'),
      'views'      => array('ajax')
    ),
    'recalcentity' => array
    (
      'method'    => array('PUT'),
      'views'      => array('ajax')
    ),
    'searchform' => array
    (
      'method'    => array('GET'),
      'views'      => array('maintab')
    ),
    'search' => array
    (
      'method'    => array('GET'),
      'views'      => array('ajax')
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
  public function service_stats($request, $response)
  {

    ///@trows InvalidRequest_Exception
    $view = $response->loadView
    (
      'webfrap-maintenance-data_index-stats',
      'MaintenanceDb_Index_Stats' ,
      'displayStats',
      null,
      true
    );

    $params = $this->getFlags($request);

    $model = $this->loadModel('MaintenanceDb_Index');

    $view->setModel($model);
    $view->displayStats($params);

  }//end public function service_stats */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_recalcAll($request, $response)
  {

    ///@trows InvalidRequest_Exception
    $view = $response->loadView
    (
      'maint-db-index-recalc_all',
      'MaintenanceDb_Index' ,
      'displayRecalc',
      null,
      true
    );

    $params = $this->getFlags($request);

    $model = $this->loadModel('MaintenanceDb_Index');
    $model->recalcFullIndex();

    $view->setModel($model);
    $view->displayRecalc($params);

  }//end public function service_recalcAll */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_recalcEntity($request, $response)
  {

    $params = $this->getFlags($request);

    $key = $request->param('key', Validator::CNAME);

    if (empty($key)) {
      throw new InvalidParam_Exception('A valid key param is required');
    }

    ///@trows InvalidRequest_Exception
    $view = $response->loadView
    (
      'maint-db-index-recalc_entity-'.$key,
      'MaintenanceDb_Index' ,
      'displayRecalcEntity',
      null,
      true
    );

    $model = $this->loadModel('MaintenanceDb_Index');
    $model->recalcEntityIndex($key);

    $view->setModel($model);
    $view->displayRecalc($params);

  }//end public function service_recalcEntity */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_searchForm($request, $response)
  {

    ///@trows InvalidRequest_Exception
    $view = $response->loadView
    (
      'maint-db-index-form_search',
      'MaintenanceDb_Index_Search' ,
      'displayForm',
      null,
      true
    );

    $params = $this->getFlags($request);

    $model = $this->loadModel('MaintenanceDb_Index');

    $view->setModel($model);
    $view->displayForm($params);

  }//end public function service_searchForm */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_search($request, $response)
  {

    ///@trows InvalidRequest_Exception
    $view = $response->loadView
    (
      'maint-db-index-search_result',
      'MaintenanceDb_Index_Search' ,
      'displaySearchResult',
      null,
      true
    );

    $params = $this->getFlags($request);

    $model = $this->loadModel('MaintenanceDb_Index');

    $searchKey = $request->param('key',Validator::SEARCH);

    $view->setModel($model);
    $view->displaySearchResult($model->search($searchKey), $params);

  }//end public function service_searchForm */

}//end class MaintenanceDb_Index_Controller

