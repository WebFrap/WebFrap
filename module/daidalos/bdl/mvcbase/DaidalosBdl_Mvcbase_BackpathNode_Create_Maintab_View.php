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
class DaidalosBdl_Mvcbase_BackpathNode_Create_Maintab_View extends WgtMaintab
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
   * @var DaidalosBdl_Mvcbase_Backpath_Model
   */
  public $model = null;
  
/*//////////////////////////////////////////////////////////////////////////////
// Methoden
//////////////////////////////////////////////////////////////////////////////*/

  
  /**
   * @param TFlag $params
   * @return void
   */
  public function displayCreate( $path, $params )
  {

    $this->setLabel( 'Create Backpath Node' );
    $this->setTitle( 'Create Backpath Node' );

    $this->addVar( 'key', $this->model->modeller->key );
    $this->addVar( 'bdlFile', $this->model->modeller->bdlFileName );
    
    $this->addVar( 'domainKey', $this->domainKey );
    $this->addVar( 'domainClass', $this->domainClass );
    
    $this->addVar( 'path', $path );
    
    $this->setTabId( 'wgt-tab-daidalos-bdl_'.$this->domainKey.'-create-backpath-node' );
    
    $this->setTemplate( 'daidalos/bdl/node/'.$this->domainKey.'/backpath_node/maintab/create' );

    $params = new TArray();
    $this->addMenu( $params );

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
  public function addMenu( $params )
  {

    $menu     = $this->newMenu
    (
      $this->id.'_dropmenu',
      'DaidalosBdlNode_'.$this->domainClass.'BackpathNode_Create'
    );
    
    $menu->id = $this->id.'_dropmenu';
    $menu->buildMenu(  $params );
    
    $menu->injectActions( $this, $params );

  }//end public function addMenu */

}//end class DaidalosBdl_Mvcbase_BackpathNode_Create_Maintab_View

