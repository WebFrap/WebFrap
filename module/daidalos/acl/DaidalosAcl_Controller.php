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
class DaidalosAcl_Controller extends Controller
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var array
   */
  protected $options           = array(

    'form' => array(
      'method'    => array('GET'),
      'views'      => array('maintab')
    ),

    'updateacl' => array(
      'method'    => array('POST','PUT'),
      'views'      => array('ajax')
    ),

    'deactivateallusers' => array(
      'method'    => array('POST','PUT'),
      'views'      => array('ajax')
    ),

  );

/*//////////////////////////////////////////////////////////////////////////////
//Logic: Meta Model
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   */
  public function service_form($request, $response)
  {

    $params = $this->getFlags($this->getRequest());

    $view   = $response->loadView('wgt-view-daidalos_acl-form', 'DaidalosAcl');

    $model  = $this->loadModel('DaidalosAcl');

    $view->setModel($model);
    $view->displayForm($params);

  }//end public function service_form */

  /**
   *
   */
  public function service_updateAcl($request, $response)
  {

    $params = $this->getFlags($this->getRequest());

    $model  = $this->loadModel('DaidalosAcl');
    $model->updateArea($this->getRequest());

  }//end public function updateAcl */

  /**
   *
   */
  public function service_deactivateAllUsers($request, $response)
  {

    $params   = $this->getFlags($this->getRequest());
    $model    = $this->loadModel('DaidalosAcl');

    $model->dissableAllUsers();

    $response->addMessage('Dissabled all Users');

  }//end public function deactivateAllUsers */

}//end class DaidalosAcl_Controller

