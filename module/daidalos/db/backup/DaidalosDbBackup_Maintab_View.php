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
class DaidalosDbBackup_Maintab_View
  extends WgtMaintab
{
  
  /**
   * @var string
   */
  public $importMsg = null;
  
/*//////////////////////////////////////////////////////////////////////////////
// Methoden
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param TFlag $params
   * @return void
   */
  public function displayForm( $key, $params )
  {

    $this->setLabel( 'Backup Database' );
    $this->setTitle( 'Backup Database' );
    
    $this->addVar( 'dbKey', $key );

    $this->setTemplate( 'daidalos/db/backup/maintab/form' );
    //$table = $this->newItem( 'tableCompilation' , 'DaidalosDb_Table' );
    
    //$this->tabId = 'daidalos_db_form_backup-'.$key;

    $params = new TArray();
    $this->addMenu( $params, $key );

  }//end public function displayForm */
  
  /**
   * @param string $key
   * @param TFlag $params
   * @return void
   */
  public function displayList( $key, $params )
  {

    $this->setLabel( 'Restore Database '.$key );
    $this->setTitle( 'Restore Database '.$key );
    
    $this->addVar( 'dbKey', $key );
    
    if( $this->importMsg )
    {
      $this->addVar( 'importMsg', $this->importMsg );
    }
      
    $this->addVar( 'files', $this->model->getRestoreList( $key ) );

    $this->setTemplate( 'daidalos/db/restore/maintab/list' );
    //$table = $this->newItem( 'tableCompilation' , 'DaidalosDb_Table' );
    
    //$this->tabId = 'daidalos_db_form_backup-'.$key;

    $params = new TArray();
    $this->addMenu( $params, $key );

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
  public function addMenu( $params, $key )
  {

    $menu     = $this->newMenu
    (
      $this->id.'_dropmenu',
      'DaidalosDbBackup'
    );
    
    $menu->id = $this->id.'_dropmenu';
    $menu->buildMenu( $key, $params );
    
    $menu->injectActions( $this, $key, $params );

  }//end public function addMenu */

}//end class DaidalosProjects_Maintab

