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
class DaidalosDb_Model
  extends Model
{
  
  
  /**
   * @param string $dbName
   */
  public function loadDb( $dbName )
  {
    
    $conf = Conf::get('db','connection');
    
    if( isset($conf['admin']) )
      $dbConf = $conf['admin'];
    else 
      $dbConf = $conf['default'];
      
    $dbConf['dbname'] = $dbName;
    $dbConf['dbschema'] = 'public';

    $className = 'LibDb'.$dbConf['class'];

    if( WebFrap::loadable( $className ) )
    {
      $this->db = new $className($dbConf);
    }
    else
    {
      throw new LibDb_Exception
      (
        'Database: Unbekannte Datenbank Extention '.$className.' angefordert'
      );
    }
      
  }//end public function loadDb */
  
  /**
   * @return array
   */
  public function getDatabases()
  {
    
    $dbAdmin    = new LibDbAdminPostgresql( $this->getDb() );
    
    return $dbAdmin->getDatabases();
    
  }//end public function getDatabases */
  
  /**
   * @param string $dbName
   * @return array liste der 
   */
  public function getSchemas( $dbName = null )
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
   * @param string $dbName
   * @return array liste der 
   */
  public function createSchemaBackup( $dbName = null )
  {
    
    /*
/usr/bin/pg_dump 
 --host localhost 
 --port 5432 
 --username sono 
 --format custom 
 --verbose 
 --file "/home/sono/data.backup" 
 --schema 'stab' stab_gw_cms

     */
    
    $dbAdmin    = new LibDbAdminPostgresql( $this->getDb() );
    
    return $dbAdmin->getSchemas( $dbName );
    
  }//end public function getSchemas */
  
  /**
   * @param string $dbName
   * @param string $schemaKey
   * @return array liste der 
   */
  public function getSchemaTables( $dbName, $schemaKey )
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
  
  


}//end class DaidalosDb_Model

