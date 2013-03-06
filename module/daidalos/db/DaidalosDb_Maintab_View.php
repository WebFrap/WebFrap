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
class DaidalosDb_Maintab_View extends WgtMaintabCustom
{
/*//////////////////////////////////////////////////////////////////////////////
// Methoden
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param TFlag $params
   * @return void
   */
  public function displayListing($params )
  {

    $this->setLabel( 'Overview databases' );
    $this->setTitle( 'Overview databases' );

    $this->addVar( 'databases', $this->model->getDatabases()  );

    $this->setTemplate( 'daidalos/db/maintab/list_db' );
    //$table = $this->newItem( 'tableCompilation' , 'DaidalosDb_Table' );

    //$this->tabId = 'daidalos_db_form_backup';

    $params = new TArray();
    $this->addMenu($params );

  }//end public function displayListing */

  /**
   * add a drop menu to the create window
   *
   * @param TFlowFlag $params the named parameter object that was created in
   *   the controller
   * {
   *   string formId: the id of the form;
   * }
   */
  public function addMenu($params )
  {

    $menu     = $this->newMenu
    (
      $this->id.'_dropmenu',
      'DaidalosDb'
    );

    $menu->id = $this->id.'_dropmenu';
    $menu->setAcl($this->getAcl() );
    $menu->setModel($this->model );

    $menu->buildMenu($params );

    $menu->injectActions($this, $params );

  }//end public function addMenu */

}//end class DaidalosProjects_Maintab

