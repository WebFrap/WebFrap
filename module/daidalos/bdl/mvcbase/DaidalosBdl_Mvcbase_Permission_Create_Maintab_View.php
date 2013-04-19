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
class DaidalosBdl_Mvcbase_Permission_Create_Maintab_View extends WgtMaintabCustom
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Der domainkey
   * eg: profile
   * @var string
   */
  public $domainKey = null;

  /**
   * Domain Class Part
   * eg: Profile
   * @var string
   */
  public $domainClass = null;

  /**
   * @var DaidalosBdl_Mvcbase_Permission_Model
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
    $this->addVar('parentNode', $this->model->parentNode);

    $this->addVar('domainKey', $this->domainKey);
    $this->addVar('domainClass', $this->domainClass);

    $this->setTabId('wgt-tab-daidalos-bdl_'.$this->domainKey.'-create-permission');

    $this->setTemplate('daidalos/bdl/node/'.$this->domainKey.'/permission/maintab/create');

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
      'DaidalosBdlNode_'.$this->domainClass.'Permission_Create'
    );

    $menu->id = $this->id.'_dropmenu';
    $menu->buildMenu( $params);

    $menu->injectActions($this, $params);

  }//end public function addMenu */

}//end class DaidalosBdl_Mvcbase_Permission_Create_Maintab_View

