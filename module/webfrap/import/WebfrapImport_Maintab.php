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
class WebfrapImport_Maintab extends WgtMaintab
{
/*//////////////////////////////////////////////////////////////////////////////
// Methoden
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $menuName
   * @return void
   */
  public function displayMenu($menuName, $params)
  {

    $this->setLabel('Import');
    $this->setTitle('Import');

    $this->setTemplate('webfrap/navigation/maintab/modmenu');

    $modMenu = $this->newItem('modMenu', 'MenuFolder');
    $modMenu->setData
    (
      DaoFoldermenu::get('webfrap/import/'.$menuName, true),
      'maintab.php'
    );

    $params = new TArray();
    $this->addMenuMenu($modMenu, $params);

  }//end public function displayMenu */

  /**
   * add a drop menu to the create window
   *
   * @param TFlowFlag $params the named parameter object that was created in
   *   the controller
   * {
   *   string formId: the id of the form;
   * }
   */
  public function addMenuMenu($modMenu, $params)
  {

    $menu     = $this->newMenu
    (
      $this->id.'_dropmenu',
      'WebfrapImport'
    );
    $menu->id = $this->id.'_dropmenu';
    $menu->crumbs = $modMenu->buildCrumbs();
    $menu->buildMenu($params);

  }//end public function addMenuMenu */

}//end class AdminBase_Maintab

