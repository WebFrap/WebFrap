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
class DaidalosDatabase_Controller extends Controller
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var string
   */
  protected $callAble = array
  (
    'listconnections',
  );

/*//////////////////////////////////////////////////////////////////////////////
//Logic: Meta Model
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   */
  public function listConnections($params = null)
  {

    $params = $this->getFlags($this->getRequest());

    $view   = $response->loadView
    (
      'wgt-view-daidalos_projects-list',
      'DaidalosDatabase'
    );

    $model  = $this->loadModel('DaidalosDatabase');

    $view->setModel($model);
    $view->displayList($params);

  }//end public function listConnections */

}//end class DaidalosDatabase_Controller

