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
 * @subpackage ModSync
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class DaidalosAcl_Maintab_View extends WgtMaintab
{
/*//////////////////////////////////////////////////////////////////////////////
// Methoden
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $params
   * @return void
   */
  public function displayForm($params)
  {

    $this->setLabel('Daidalos ACL');
    $this->setTitle('Daidalos ACL');

    $this->setTemplate('daidalos/acl/form');

    $this->addMenuMenu($params);

  }//end public function displayForm */

  /**
   * add a drop menu to the create window
   *
   * @param TFlowFlag $params the named parameter object that was created in
   *   the controller
   * {
   *   string formId: the id of the form;
   * }
   */
  public function addMenuMenu($params)
  {

    $menu     = $this->newMenu
    (
      $this->id.'_dropmenu',
      'DaidalosAcl'
    );

    $menu->id = $this->id.'_dropmenu';
    $menu->buildMenu($params);

  }//end public function addMenuMenu */

}//end class DaidalosAcl_Maintab_View

