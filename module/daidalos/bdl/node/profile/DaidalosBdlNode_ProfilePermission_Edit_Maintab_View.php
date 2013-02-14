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
class DaidalosBdlNode_ProfilePermission_Edit_Maintab_View extends WgtMaintab
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
  public function displayEdit( $idx, $params )
  {

    $this->setLabel( 'Edit Permssion '.$idx );
    $this->setTitle( 'Edit Permssion '.$idx );

    $this->addVar( 'node', $this->model->node );
    $this->addVar( 'profile', $this->model->profile );
    $this->addVar( 'key', $this->model->modeller->key );
    $this->addVar( 'bdlFile', $this->model->modeller->bdlFileName );
    $this->addVar( 'idx', $idx );
    
    $this->setTabId( 'wgt-tab-daidalos-bdl_profile-edit-permission-'.$idx );
    
    $this->setTemplate( 'daidalos/bdl/node/profile/permission/maintab/edit' );

    $params = new TArray();
    $this->addMenu( $idx, $params );

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
  public function addMenu( $idx, $params )
  {

    $menu     = $this->newMenu
    (
      $this->id.'_dropmenu',
      'DaidalosBdlNode_ProfilePermission_Edit'
    );
    /* @var $menu DaidalosBdlNode_ProfilePermission_Edit_Maintab_Menu */
    
    $menu->id = $this->id.'_dropmenu';
    $menu->buildMenu(  $params );
    
    $menu->injectActions( $idx, $this, $params );

  }//end public function addMenu */

}//end class DaidalosBdlNode_ProfilePermission_Edit_Maintab_View

