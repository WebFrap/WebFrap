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
 * @subpackage ModAttachFile
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class DaidalosBackupDb_Maintab
  extends WgtMaintab
{

  /**
   *
   * Enter description here ...
   */
  public function displayListing( $params  )
  {

    $this->setTitle( $this->i18n->l( 'backup database', 'wbfsys.bookmark.label.table' ) );

    $this->setTemplate( 'daidalos/backup/db/table' );


    // create listing element
    $table = $this->createElement( 'tableDatabases' , 'DaidalosBackupDb_Table' );
    $table->setTitle('Backup Database');
    $table->setData(  $this->model->getConnections() );
    $table->setActions(array('form','backup','restore'));

    $table->buildHtml();

  }//end public function displayListing */


} // end class DaidalosBackupDb_Maintab

