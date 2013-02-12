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
 * @subpackage Core
 */
class DaidalosDbBackup_Model
  extends Model
{

  /**
   * @param string $dbName
   * @return array liste der
   */
  public function createDbBackup( $dbName, $prefix = null )
  {

    $db = $this->getDb();

    /*
    $dbName   = $db->databaseName;
    $userName = $db->dbUser;
    $dbPasswd = $db->dbPwd;
    */

    ///usr/bin/

    $command = 'pg_dump ';
    $command .= ' --host '.$db->dbUrl;
    $command .= ' --port '.$db->dbPort;
    $command .= ' --username '.$db->dbUser;
    $command .= ' --format custom ';
    $command .= ' --verbose ';
    $command .= ' --file "'.PATH_GW.'backup/db/'.$db->databaseName.'/full/'.$prefix.$db->databaseName.'.backup" ';
    //$command .= ' --file "/tmp/'.$db->databaseName.'.backup" ';
    $command .= $db->databaseName.' ';

    if( !file_exists( PATH_GW.'backup/db/'.$db->databaseName.'/full/' ) )
      SFilesystem::mkdir( PATH_GW.'backup/db/'.$db->databaseName.'/full/' );

    //--schema 'stab' stab_gw_cms

    putenv( "PGPASSWORD=$db->dbPwd" );

    return SSystem::call( $command );

  }//end public function createDbBackup */

  /**
   * @param string $dbName
   * @return DaoDatasource
   */
  public function getRestoreList( $dbName )
  {
    return DaoDatasource::get( 'db/'.$dbName.'/full/', false, 'backup' );

  }//end public function getRestoreList */

  /**
   * @param string $dumpFile
   */
  public function deleteDump( $dumpFile )
  {

    if ( '' == trim($dumpFile) ) {
      return;
    }

    SFilesystem::delete( PATH_GW.'backup/db/'.$db->databaseName.'/full/'.$dumpFile );

  }//end public function deleteDump */

  /**
   * @param Tflag $params
   */
  public function upload( )
  {

    $request    = $this->getRequest();
    $response   = $this->getResponse();
    $db         = $this->getDb();

    if ( !$dump = $request->file( 'db_dump' ) ) {
      $response->addError( 'Got no data to upload. Did you forget to choose a file?' );

      return false;
    }

    $dump->copy( null, PATH_GW.'backup/db/'.$db->databaseName.'/full/' );

  }//end public function upload */

}//end class DaidalosDbBackup_Model
