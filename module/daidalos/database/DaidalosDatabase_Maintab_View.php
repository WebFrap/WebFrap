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
class DaidalosDatabase_Maintab_View extends WgtMaintabCustom
{
/*//////////////////////////////////////////////////////////////////////////////
// Methoden
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param TFlowFlag $params
   * @return void
   */
  public function displayList($params )
  {

    $this->setLabel('Daidalos');
    $this->setTitle('Daidalos');

    $table = new DaidalosDatabase_Connection_Table_Element( 'connections', $this );
    $table->setData($this->model->getConnections() );

    $this->setTemplate( 'daidalos/database/list_connections' );

    $this->addMenuMenu($params );

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
  public function addMenuMenu($params )
  {

    $menu     = $this->newMenu
    (
      $this->id.'_dropmenu',
      'DaidalosDatabase'
    );

    $menu->id = $this->id.'_dropmenu';
    $menu->buildMenu($params );

  }//end public function addMenuMenu */

}//end class DaidalosDatabase_Maintab_View

