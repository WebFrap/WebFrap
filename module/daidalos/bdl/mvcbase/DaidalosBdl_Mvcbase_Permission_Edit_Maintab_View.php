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
class DaidalosBdl_Mvcbase_Permission_Edit_Maintab_View extends WgtMaintab
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
   * @var DaidalosBdl_Mvcbase__Model
   */
  public $model = null;

/*//////////////////////////////////////////////////////////////////////////////
// Methoden
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param TFlag $params
   * @return void
   */
  public function displayEdit($idx, $params )
  {

    $this->setLabel( 'Edit Permssion '.$idx );
    $this->setTitle( 'Edit Permssion '.$idx );

    $this->addVar( 'node', $this->model->node );
    $this->addVar( 'parentNode', $this->model->parentNode );

    $this->addVar( 'domainKey', $this->domainKey );
    $this->addVar( 'domainClass', $this->domainClass );

    $this->addVar( 'key', $this->model->modeller->key );
    $this->addVar( 'bdlFile', $this->model->modeller->bdlFileName );
    $this->addVar( 'idx', $idx );

    $this->setTabId( 'wgt-tab-daidalos-bdl_'.$this->domainKey.'-permission-edit-'.$idx );

    $this->setTemplate( 'daidalos/bdl/node/'.$this->domainKey.'/permission/maintab/edit' );

    $params = new TArray();
    $this->addMenu($idx, $params );

  }//end public function displayEdit */

  /**
   * add a drop menu to the create window
   *
   * @param TFlowFlag $params the named parameter object that was created in
   *   the controller
   * {
   *   string formId: the id of the form;
   * }
   */
  public function addMenu($idx, $params )
  {

    $menu     = $this->newMenu
    (
      $this->id.'_dropmenu',
      'DaidalosBdlNode_'.$this->domainClass.'Permission_Edit'
    );
    /* @var $menu DaidalosBdlNode_ProfilePermission_Edit_Maintab_Menu */

    $menu->id = $this->id.'_dropmenu';
    $menu->buildMenu(  $params );

    $menu->injectActions($idx, $this, $params );

  }//end public function addMenu */

}//end class DaidalosBdl_Mvcbase_Permission_Edit_Maintab_View

