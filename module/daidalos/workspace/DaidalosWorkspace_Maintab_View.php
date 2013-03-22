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
class DaidalosWorkspace_Maintab_View extends WgtMaintabCustom
{

  /**
   * @var DaidalosBdlModeller_Model
   */
  public $model = null;

/*//////////////////////////////////////////////////////////////////////////////
// Methoden
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param TFlag $params
   * @return void
   */
  public function displayList( $params)
  {

    $this->setLabel('BDL Modeller');
    $this->setTitle('BDL Modeller');

    $this->addVar('repos', $this->model->getRepos());
    $this->addVar('projects', $this->model->getProjects());

    $this->setTemplate('daidalos/bdl/modeller/maintab/list');

    $params = new TArray();
    $this->addMenu($params);

  }//end public function displayList */

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
      'DaidalosBdlModeller'
    );

    $menu->id = $this->id.'_dropmenu';
    $menu->buildMenu( $params);

    $menu->injectActions($this,$params);

  }//end public function addMenu */

}//end class DaidalosBdlModeller_Maintab_View

