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
class DaidalosBdlNode_Process_Maintab_View
  extends WgtMaintab
{
  
  /**
   * @var DaidalosBdlNode_Management_Model
   */
  public $model = null;
  
/*//////////////////////////////////////////////////////////////////////////////
// Methoden
//////////////////////////////////////////////////////////////////////////////*/

  
  /**
   * @param TFlag $params
   * @return void
   */
  public function displayEditor(  $params )
  {
    
    $managementName = $this->model->node->getName();

    $this->setLabel( 'Management: '.$managementName );
    $this->setTitle( 'Management: '.$managementName );

    $this->addVar( 'node', $this->model->node );
    $this->addVar( 'key', $this->model->modeller->key );
    $this->addVar( 'bdlFile', $this->model->modeller->bdlFileName );
    
    $this->setTabId( 'wgt-tab-daidalos-bdl_management-edit-'.$this->model->modeller->key );
    
    $this->setTemplate( 'daidalos/bdl/node/management/maintab/form' );

    $params = new TArray();
    $this->addMenu( $params );

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
  public function addMenu( $params )
  {

    $menu     = $this->newMenu
    (
      $this->id.'_dropmenu',
      'DaidalosBdlNode_Management'
    );
    
    $menu->id = $this->id.'_dropmenu';
    $menu->buildMenu(  $params );
    
    $menu->injectActions( $this, $params );

  }//end public function addMenu */

}//end class DaidalosBdlNodeManagement_Maintab_View

