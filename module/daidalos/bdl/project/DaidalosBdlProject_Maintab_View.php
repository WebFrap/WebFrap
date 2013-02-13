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
class DaidalosBdlProject_Maintab_View
  extends WgtMaintab
{
/*//////////////////////////////////////////////////////////////////////////////
// Methoden
//////////////////////////////////////////////////////////////////////////////*/

  
  /**
   * @param TFlag $params
   * @return void
   */
  public function displayFormCreate( $key, $params )
  {

    $this->setLabel( 'BDL Projects '.$key );
    $this->setTitle( 'BDL Projects '.$key );

    $this->addVar( 'projects', $this->model->getProjects( ) );

    $this->setTemplate( 'daidalos/bdl/project/maintab/form_create' );
    
    //$this->tabId = 'daidalos_db_form_backup-'.$key;

    $params = new TArray();
    $this->addMenu( $params, $key );

  }//end public function displayFormCreate */
  
  /**
   * @param TFlag $params
   * @return void
   */
  public function displayFormEdit(  $params )
  {

    $this->setLabel( 'BDL Projects '.$this->model->key );
    $this->setTitle( 'BDL Projects '.$this->model->key );
  
    $this->addVar( 'key', $this->model->key );
    $this->addVar( 'project', $this->model->getActiveProject() );

    $this->setTemplate( 'daidalos/bdl/project/maintab/form_edit' );
    
    //$this->tabId = 'daidalos_db_form_backup-'.$key;

    $params = new TArray();
    $this->addMenu( $params, $this->model->key );

  }//end public function displayFormCreate */

  /**
   * add a drop menu to the create window
   *
   * @param TFlowFlag $params the named parameter object that was created in
   *   the controller
   * {
   *   string formId: the id of the form;
   * }
   */
  public function addMenu( $params, $key )
  {

    $menu     = $this->newMenu
    (
      $this->id.'_dropmenu',
      'DaidalosBdlProject'
    );
    
    $menu->id = $this->id.'_dropmenu';
    $menu->buildMenu( $key, $params );
    
    $menu->injectActions( $this, $key, $params );

  }//end public function addMenu */

}//end class DaidalosBdlProject_Maintab_View

