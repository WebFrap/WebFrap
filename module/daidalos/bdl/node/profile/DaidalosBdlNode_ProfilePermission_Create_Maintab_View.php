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
 * @subpackage Daidalos
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class DaidalosBdlNode_ProfilePermission_Create_Maintab_View extends WgtMaintabCustom
{

  /**
   * @var DaidalosBdlNode_ProfilePermission_Model
   */
  public $model = null;

/*//////////////////////////////////////////////////////////////////////////////
// Methoden
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param TFlag $params
   * @return void
   */
  public function displayCreate( $params)
  {

    $this->setLabel('Create Permission');
    $this->setTitle('Create Permission');

    $this->addVar('key', $this->model->modeller->key);
    $this->addVar('bdlFile', $this->model->modeller->bdlFileName);
    $this->addVar('params', $params);

    $this->setTabId('wgt-tab-daidalos-bdl_profile-create-permission');

    $this->setTemplate('daidalos/bdl/node/profile/permission/maintab/create');

    $params = new TArray();
    $this->addMenu($params);

  }//end public function displayCreate */

  /**
   * add a drop menu to the create window
   *
   * @param TFlowFlag $params the named parameter object that was created in
   *   the controller
   * {
   *   string formId: the id of the form;
   * }
   */
  public function addMenu($params)
  {

    $menu     = $this->newMenu
    (
      $this->id.'_dropmenu',
      'DaidalosBdlNode_ProfilePermission_Create'
    );

    $menu->id = $this->id.'_dropmenu';
    $menu->buildMenu( $params);

    $menu->injectActions($this, $params);

  }//end public function addMenu */

}//end class DaidalosBdlNode_ProfilePermission_Maintab_View

