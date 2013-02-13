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
class DaidalosDbSchema_Backup_Modal_View
  extends WgtModal
{
/*//////////////////////////////////////////////////////////////////////////////
// Methoden
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $dbKey
   * @param string $schemaKey
   * @param TFlag $params
   * @return void
   */
  public function displayBackups( $dbName, $schemaName, $params )
  {

    $this->setTitle( 'Tables for Db: '.$dbName.' Schema: '.$schemaName );

    $this->addVar( 'dbName', $dbName );
    $this->addVar( 'schemaName', $schemaName );
    
    $this->addVar( 'dumps', $this->model->getSchemaBackups( $dbName, $schemaName ) );
    
    $this->setTemplate( 'daidalos/db/schema/modal/list_backups' );

  }//end public function displayBackups */

 

}//end class DaidalosDbSchema_Backup_Modal_View

