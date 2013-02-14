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
class DaidalosBdl_Mvcbase_BackpathNode_Edit_Maintab_View extends WgtMaintab
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Der domainkey
   * eg: role
   * @var string
   */
  public $domainKey = null;
  
  /**
   * Domain Class Part
   * eg: Role
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
  public function displayEdit($path, $params )
  {
    
    $pathId = str_replace('.', '-', $path);

    $this->setLabel( 'Edit Backpath Node '.$path );
    $this->setTitle( 'Edit Backpath Node '.$path );

    $this->addVar( 'node', $this->model->pathNode );
    $this->addVar( 'parentNode', $this->model->parentNode );
    
    $this->addVar( 'key', $this->model->modeller->key );
    $this->addVar( 'bdlFile', $this->model->modeller->bdlFileName );
    
    $this->addVar( 'domainKey', $this->domainKey );
    $this->addVar( 'domainClass', $this->domainClass );
    
    $this->addVar( 'path', $path );
    $this->addVar( 'pathId', $pathId );
    
    $this->setTabId( 'wgt-tab-daidalos-bdl_'.$this->domainKey.'-edit-backpath_node-'.$pathId );
    
    $this->setTemplate( 'daidalos/bdl/node/'.$this->domainKey.'/backpath_node/maintab/edit' );

    $params = new TArray();
    $this->addMenu($path, $params );

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
  public function addMenu($path, $params )
  {

    $menu     = $this->newMenu
    (
      $this->id.'_dropmenu',
      'DaidalosBdlNode_'.$this->domainClass.'BackpathNode_Edit'
    );
    /* @var $menu DaidalosBdl_Mvcbase_BackpathNode_Edit_Maintab_Menu */
    
    $menu->id = $this->id.'_dropmenu';
    $menu->buildMenu(  $params );
    
    $menu->injectActions($path, $this, $params );

  }//end public function addMenu */

}//end class DaidalosBdl_Mvcbase_BackpathNode_Edit_Maintab_View

