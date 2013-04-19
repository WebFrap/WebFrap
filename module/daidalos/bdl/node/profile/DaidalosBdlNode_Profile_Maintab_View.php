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
class DaidalosBdlNode_Profile_Maintab_View extends WgtMaintabCustom
{

  /**
   * @var DaidalosBdlNode_Profile_Model
   */
  public $model = null;

/*//////////////////////////////////////////////////////////////////////////////
// Methoden
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param TFlag $params
   * @return void
   */
  public function displayEditor( $params)
  {

    $profileName = $this->model->node->getName();

    $this->setLabel('Profile: '.$profileName);
    $this->setTitle('Profile: '.$profileName);

    $this->addVar('node', $this->model->node);
    $this->addVar('key', $this->model->modeller->key);
    $this->addVar('bdlFile', $this->model->modeller->bdlFileName);

    $this->setTabId('wgt-tab-daidalos-bdl_profile-edit-'.$this->model->modeller->key);

    $this->setTemplate('daidalos/bdl/node/profile/maintab/form');

    $params = new TArray();
    $this->addMenu($params);

  }//end public function displayEditor */

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
      'DaidalosBdlNode_Profile'
    );

    $menu->id = $this->id.'_dropmenu';
    $menu->buildMenu( $params);

    $menu->injectActions($this, $params);

  }//end public function addMenu */

}//end class DaidalosBdlNodeProfile_Maintab_View

