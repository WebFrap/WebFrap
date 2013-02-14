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
class DaidalosDbSchema_Model extends Model
{

  /**
   * @param string $dbName
   * @return array liste der 
   */
  public function getSchemas($dbName = null )
  {
    
    $db = $this->getDb();
    
    $sql = <<<SQL
  SELECT   
    s.schema_name,
    s.catalog_name as db_name,
    s.schema_owner as owner
    
    FROM  
      information_schema.schemata  s

SQL;

    $sql .= ";";
    
    return $db->select($sql)->getAll();
    
  }//end public function getSchemas */
  
  
  /**
   * @param LibDbConnectionPostgresql $dbName
   * @param string $dbName
   * @return array liste der 
   */
  public function createSchemaBackup($dbName, $schemaKey )
  {


    $conf = Conf::get('db');
    
    $dbConf = $conf['connection']['default'];

    $fileName = $schemaKey.'-'.time().'.backup';
    $savePath = PATH_GW.'data/backups/db/'.$dbConf['dbname'].'/schemas/'.$schemaKey.'/';
    
    $command = '/usr/bin/pg_dump';
    
    $callParams = array();
    
    $callParams[] = '--host '.$dbConf['dbhost'];
    $callParams[] = '--port '.$dbConf['dbport'];
    $callParams[] = '--username '.$dbConf['dbuser'];
    $callParams[] = '--format custom';
    $callParams[] = '--verbose';
    $callParams[] = '--file "'.$savePath.$fileName.'"';
    $callParams[] = '--schema '.$dbConf['dbschema'];
    $callParams[] = $dbConf['dbname'];
    
    SFilesystem::mkdir($savePath);
    
    $callEnv = array();
    $callEnv['PGPASSWORD'] = $dbConf['dbpwd'];
    

    $dumpProcess = new LibSystemProcess();
    if (!$dumpProcess->open($command, $callParams, $callEnv ) )
    {
      return "Failed to Open command {$command}";
    }
    
    //$result = 'clear2';
    
    //$result = $dumpProcess->read();

    return $dumpProcess->close().' saved in '.$savePath.$fileName;

  }//end public function createSchemaBackup */
  
  /**
   * @param LibDbConnectionPostgresql $dbName
   * @param string $dbName
   * @param string $dumpKey
   * @return array liste der 
   */
  public function restoreSchemaBackup($dbName, $schemaKey, $dumpKey )
  {


    $conf = Conf::get('db');
    
    $dbConf = $conf['connection']['default'];

    $dumpPath = PATH_GW.'data/backups/db/'.$dbConf['dbname'].'/schemas/'.$schemaKey.'/'.$dumpKey;
    
    if (!file_exists($dumpPath) )
    {
      throw new Io_Exception( 'Missing dump '.$dumpPath );
    }
    
    $command = '/usr/bin/pg_restore';
    
    $callParams = array();
    
    $callParams[] = '--host '.$dbConf['dbhost'];
    $callParams[] = '--port '.$dbConf['dbport'];
    $callParams[] = '--username '.$dbConf['dbuser'];
    $callParams[] = '--format custom';
    $callParams[] = '--verbose';
    //$callParams[] = '--schema '.$dbConf['dbschema'];
    $callParams[] = $dbConf['dbname'];
    $callParams[] = '"'.$dumpPath.'"';

    $callEnv = array();
    $callEnv['PGPASSWORD'] = $dbConf['dbpwd'];
    
    
    Debug::console($command .' '. implode( ' ',$callParams  )  );

    $dumpProcess = new LibSystemProcess();
    if (!$dumpProcess->open($command, $callParams, $callEnv ) )
    {
      return "Failed to Open command {$command}";
    }
    
    //$result = 'clear2';
    
    //$result = $dumpProcess->read();

    return $dumpProcess->close().' restored dump '.$dumpPath;

  }//end public function restoreSchemaBackup */
  
  /**
   * @param string $dbName
   * @param string $schemaKey
   * @return [IoFile]
   */
  public function getSchemaBackups($dbName, $schemaKey )
  {
    
    $path     = PATH_GW.'data/backups/db/'.$dbName.'/schemas/'.$schemaKey;
    $iterator = new IoFolderIterator($path );
    
    return $iterator->getFilesByEnding( '.backup', true );

  }//end public function getSchemaBackups */
  
  /**
   * Einen Dump löschen
   * @param string $dbName
   * @param string $schemaKey
   * @param string $dumpKey
   * 
   * @throws Io_Exception
   */
  public function deleteDump($dbName, $schemaKey, $dumpKey )
  {
    
    $filename = PATH_GW.'data/backups/db/'.$dbName.'/schemas/'.$schemaKey.'/'.$dumpKey;
    
    if ( file_exists($filename) )
    {
      SFiles::delete($filename);
    } else {
      throw new Io_Exception( 'Requested dump '.$dumpKey.' not exists.' );
    }

  }//end public function deleteDump */
  
  /**
   * Einen Dump löschen
   * @param string $dbName
   * @param string $schemaKey
   * @param LibRequestHttp $request
   * 
   * @return 
   * 
   * @throws Io_Exception
   */
  public function uploadDump($dbName, $schemaKey, $request )
  {
    
    $folder = PATH_GW.'data/backups/db/'.$dbName.'/schemas/'.$schemaKey.'/';

    $uplDump = $request->file('dump');
    
    if (!$uplDump )
      return null;

    $uplDump->copy($uplDump->getOldname(), $folder );
    
    return $uplDump;

  }//end public function uploadDump */
  
  /**
   * @param string $dbName
   * @param string $schemaKey
   * @return array liste der 
   */
  public function getSchemaTables($dbName, $schemaKey )
  {
    
    $db = $this->getDb();
    
    $sql = <<<SQL
  SELECT
    table_name as table_name,
    '' as comment
    FROM  information_schema.tables
    WHERE
    table_catalog = '{$dbName}'
    AND table_schema = '{$schemaKey}'
    AND table_type  = 'BASE TABLE'
    ORDER BY table_name ;
SQL;

    return $this->db->select($sql)->getAll();
    
  }//end public function getSchemas */
  
  
  /**
   * @param string $dbName
   */
  public function loadDb($dbName )
  {
    
    $conf = Conf::get('db','connection');
    
    if ( isset($conf['admin']) )
      $dbConf = $conf['admin'];
    else 
      $dbConf = $conf['default'];
      
    $dbConf['dbname']   = $dbName;
    $dbConf['dbschema'] = 'public';

    $className = 'LibDb'.$dbConf['class'];

    if ( WebFrap::loadable($className ) )
    {
      $this->db = new $className($dbConf);
    } else {
      throw new LibDb_Exception
      (
        'Database: Unbekannte Datenbank Extention '.$className.' angefordert'
      );
    }
      
  }//end public function loadDb */

}//end class DaidalosDb_Model

