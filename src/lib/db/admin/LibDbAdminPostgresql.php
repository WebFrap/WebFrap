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
 * @subpackage ModDeveloper
 */
class LibDbAdminPostgresql extends LibDbAdmin
{
/*//////////////////////////////////////////////////////////////////////////////
// Attribute
//////////////////////////////////////////////////////////////////////////////*/

  /**
  * @var int
  */
  const SEQ_START = 10000;

  /**
   * @var LibDbConnectionPostgresql
   */
  protected $db = null;

  /**
   * @var array
   */
  public $nameMapping = array
  (
    'boolean'     => 'boolean'    ,
    'boolean[]'   => '_boolean'   ,
    'bytea'       => 'bytea'      ,
    'char'        => 'bpchar'     ,
    'char[]'      => '_char'      ,
    'smallint'    => 'int2'       ,
    'smallint[]'  => '_int2'      ,
    'integer'     => 'int4'       ,
    'integer[]'   => '_int4'      ,
    'int'         => 'int4'       ,
    'int[]'       => '_int4'      ,
    'int'         => 'integer'    ,
    'bigint'      => 'int8'       ,
    'bigint[]'    => '_int8'      ,
    'numeric'     => 'numeric'    ,
    'numeric[]'   => '_numeric'   ,
    'money'       => 'money'    ,
    'money[]'      => '_money'   ,
    'text'        => 'text'       ,
    'text[]'      => '_text'      ,
    'date'        => 'date'       ,
    'date[]'      => '_date'      ,
    'time'        => 'time'       ,
    'time[]'      => '_time'      ,
    'timestamp'   => 'timestamp'  ,
    'timestamp[]' => '_timestamp' ,
    'varchar'     => 'varchar'    ,
    'varchar[]'   => '_varchar'   ,
    'uuid'        => 'uuid'       ,
    'uuid[]'      => '_uuid'      ,
    'inet'        => 'inet'       ,
    'macaddr'     => 'macaddr'    ,
    'cidr'        => 'cidr'       ,
    'interval'    => 'interval'   ,
    'tsvector'    => 'tsvector'   ,
  );

  /**
   * @var array
   */
  public $invertMapping = array();

  /**
   * @var array
   */
  public $multiple = array
  (
    'smallint[]'  ,
    'integer[]'   ,
    'bigint[]'    ,
    'varchar[]'   ,
    'text[]'      ,
    'char[]'      ,
    'numeric[]'   ,
    'date[]'      ,
    'time[]'      ,
    'timestamp[]' ,
    'uuid[]'      ,
    'money[]'     ,
    'boolean[]'   ,
    'bytea[]'   ,
    '_smallint'  ,
    '_integer'   ,
    '_bigint'    ,
    '_varchar'   ,
    '_text'      ,
    '_char'      ,
    '_numeric'   ,
    '_date'      ,
    '_time'      ,
    '_timestamp' ,
    '_uuid'      ,
    '_money'     ,
    '_boolean'   ,
    '_bytea'   ,
    '_tsvector'   ,
  );

  /**
   * @var array
   */
  public $quotesMap = array
  (
    'boolean'   =>  'false' ,
    'bytea'     =>  'true'  ,
    'bigint'    =>  'false' ,
    'cidr'      =>  'true'  ,
    'char'      =>  'true'  ,
    'date'      =>  'true'  ,
    'inet'      =>  'true'  ,
    'int'       =>  'false' ,
    'integer'   =>  'false' ,
    'interval'  =>  'true'  ,
    'macaddr'   =>  'true'  ,
    'money'     =>  'true'  ,
    'numeric'   =>  'false' ,
    'smallint'  =>  'false' ,
    'text'      =>  'true'  ,
    'time'      =>  'true'  ,
    'timestamp' =>  'true'  ,
    'varchar'   =>  'true'  ,
    'uuid'      =>  'true'  ,
    'tsvector'  =>  'true'  ,

    'boolean[]'   =>  'true',
    'bigint[]'    =>  'true',
    'char[]'      =>  'true',
    'date[]'      =>  'true',
    'int[]'       =>  'true',
    'integer[]'   =>  'true',
    'smallint[]'  =>  'true',
    'text[]'      =>  'true',
    'varchar[]'   =>  'true',
    'money[]'     =>  'true',
    'numeric[]'   =>  'true',
    'time[]'      =>  'true',
    'timestamp[]' =>  'true',
    'uuid[]'      =>  'true',
    'inet[]'      =>  'true',
    'cidr[]'      =>  'true',
    'macaddr[]'   =>  'true',
  );

/*//////////////////////////////////////////////////////////////////////////////
// Helper Logic
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $ddlQuery
   */
  public function ddl($ddlQuery)
  {
    return $this->db->exec($ddlQuery);

  }//end public function ddl */

/*//////////////////////////////////////////////////////////////////////////////
// Database Logic
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return array
   */
  public function getDatabases()
  {

    $sql = <<<SQL
  SELECT
    datname as name,
    encoding as charset,
    datcollate as collate
    FROM
    pg_database;
SQL;

    return $this->db->select($sql)->getAll();

  }//end public function getDatabases */


  /**
   * @param string $dbName
   * @test TestDbAdmin::test_dbExists
   */
  public function dbExists($dbName)
  {

    $sql = <<<SQL
  SELECT datname FROM  pg_database WHERE datname = '$dbName' ;
SQL;

    return $this->db->select($sql)->get() ? true:false;

  }//end public function dbExists */

  /**
   * @param string $dbName
   * @param string $owner
   * @test TestDbAdmin::test_dbExists
   */
  public function chownDb($dbName, $owner)
  {

    $sql = <<<SQL
ALTER DATABASE {$dbName} OWNER TO {$owner};

SQL;

    return $this->ddl($sql);

  }//end public function chownDb */

/*//////////////////////////////////////////////////////////////////////////////
// Schema Logic
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $dbName
   * @return array
   */
  public function getSchemas($dbName = null)
  {

    $sql = <<<SQL
  SELECT
    ns.nspname as schema_name,
    db.datname as db_name
    FROM
    pg_namespace as ns
    join
      pg_database db on ns.nspowner = db.datdba
SQL;

    if ($dbName) {
      $sql .= <<<SQL
    WHERE db.datname = '{$dbName}'
SQL;
    }

    $sql .= ";";

    return $this->db->select($sql)->getAll();

  }//end public function getSchemas */

  /**
   * @param string $schemaName
   * @param string def=null $dbName
   *
   * @test TestDbAdmin::test_schemaExists
   */
  public function schemaExists( $schemaName, $dbName = null)
  {

    if (!$dbName)
      $dbName = $this->dbName;

    $sql = <<<SQL
  SELECT schema_name
    FROM  information_schema.schemata
    WHERE
    catalog_name = '{$dbName}'
    AND schema_name = '{$schemaName}' ;
SQL;

    return $this->db->select($sql)->get() ? true:false;

  }//end public function schemaExists */

  /**
   * @param string $dbName
   * @param string $schemaName
   * @param string $owner
   */
  public function createSchema($dbName, $schemaName, $owner = null   )
  {

    if (!$owner)
      $owner = $this->owner;

    $sql = <<<SQL
CREATE SCHEMA {$schemaName}
SQL;

    if ($this->owner)
      $sql .= ' AUTHORIZATION '.$owner.'; ';


    if ($this->createPatch)
      $this->sqlPatch .= $sql.NL;

    if ($this->syncDb)
      return $this->db->exec($sql);
    else
      return true;

  }//end public function createSchema

  /**
   * Den Besitzer eines Schemas ändern
   * @param string $schema
   * @param string $owner
   */
  public function chownSchema($schema, $owner)
  {

    $sql = <<<SQL
ALTER SCHEMA {$schema} OWNER TO {$owner};

SQL;

    return $this->ddl($sql);

  }//end public function chownSchema */


/*//////////////////////////////////////////////////////////////////////////////
// Table Logic
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $dbName
   * @param string $schemaName
   * @return array
   */
  public function getDbTables($dbName = null, $schemaName = null  )
  {

    if (!$dbName)
      $dbName = $this->dbName;

    if (!$schemaName)
      $schemaName = $this->schemaName;

    $encoding = $this->getTableEncoding(null, $dbName, $schemaName);

    $sql = <<<SQL
  SELECT
    table_name as name,
    '{$encoding}' as encoding,
    '' as comment
    FROM  information_schema.tables
    WHERE
    table_catalog = '$dbName'
    AND table_schema = '$schemaName'
    AND table_type  = 'BASE TABLE'
    ORDER BY table_name ;
SQL;

    return $this->db->select($sql)->getAll();

  }//end public function getDbTables */

  /**
   * @param string $table
   * @param string $dbName
   * @param string $schemaName
   */
  public function getTableQuotes( $table, $dbName  = null, $schemaName = null)
  {


    $sql = <<<SQL
  SELECT
    column_name as name,
    data_type as type
    FROM  information_schema.columns
    where
    table_catalog = '$dbName'
    and table_schema = '$schemaName'
    and table_name = '$table' ;

SQL;

    $results = $this->db->select($sql)->getAll();

    $meta = array();

    foreach ($results as $row)
      $meta[$row['name']] = true;

    return $meta;

  }//end public function getTableQuotes */

  /**
   * @param string $tableName
   * @param string def=null $dbName
   * @param string def=null $schemaName
   *
   * @test TestDbAdmin::test_tableExists
   */
  public function tableExists( $tableName, $dbName = null, $schemaName = null  )
  {

    if (!$dbName)
      $dbName = $this->dbName;

    if (!$schemaName)
      $schemaName = $this->schemaName;

    $sql = <<<SQL
  SELECT
    table_name
    FROM  information_schema.tables
    WHERE
    table_catalog = '$dbName'
    AND table_schema = '$schemaName'
    AND table_name = '$tableName'
    AND table_type  = 'BASE TABLE'  ;
SQL;

    return $this->db->select($sql)->get() ? true:false;

  }//end public function tableExists */

  /**
   * @param string $table
   * @param string $dbName
   * @param string $schemaName
   */
  public function getTableEncoding($table, $dbName = null, $schemaName = null)
  {
    return 'utf-8';
  }//end public function getTableEncoding */

  /**
   * Den Besitzer einer Tabelle ändern
   * @param string $schema
   * @param string $table
   * @param string $owner
   */
  public function chownTable($schema, $table, $owner)
  {

    $sql = <<<SQL
ALTER TABLE {$schema}.{$table} OWNER TO {$owner};

SQL;

    return $this->ddl($sql);

  }//end public function chownTable */

  /**
   * @param string $tableName
   */
  public function setTableOwner($tableName)
  {
    $sql ='';

    if ( $this->owner)
      $sql .= "ALTER TABLE {$tableName} OWNER TO {$this->owner}; ";

    if ($this->createPatch)
      $this->sqlPatch .= $sql.NL.NL;

    if ($this->syncDb)
      return $this->db->exec($sql);
    else
      return true;

  }//end public function setTableOwner */


  /**
   * Umbenennen einer Column
   *
   * @param string $oldTableName
   * @param string $newTableName
   * @param string $dbName
   * @param string $schemaName
   *
   * @return boolean
   */
  public function renameTable($oldTableName, $newTableName, $dbName = null, $schemaName = null  )
  {

    if (!$dbName)
      $dbName = $this->dbName;

    if (!$schemaName)
      $schemaName = $this->schemaName;


    $alterSql = <<<SQL
ALTER TABLE {$oldTableName} RENAME TO {$newTableName};
SQL;

    if ($this->db->exec($alterSql)) {
      return true;
    } else {
      return false;
    }

  }//end public function renameTable */



  /**
   * @param string $tableName
   * @param [[key:value]] $data
   * @param string def=null $schemaName
   */
  public function createTable( $tableName, $data, $schemaName = null  )
  {

    if (!$this->invertMapping) {
      $this->invertMapping = array_flip($this->nameMapping);
    }

    if ($schemaName)
      $tableName = $schemaName.'.'.$tableName;

    if ($this->muliSeq)
      $this->createTableSequence($schemaName, $tableName);

    $hasRowid = false;


    $sql = <<<SQL
CREATE TABLE {$tableName}(

SQL;

    foreach ($data as $row) {

      if ('rowid' == (string) $row[LibDbAdmin::COL_NAME])
        $hasRowid = true;

      $type = (string) $row[LibDbAdmin::COL_TYPE];

      ///FIX fixed text / size bug
      if (trim($row[LibDbAdmin::COL_LENGTH]) != '' && $type == '_text')
        $type = '_varchar';

      if (trim($row[LibDbAdmin::COL_LENGTH]) != '' && $type == 'text')
        $type = 'varchar';

      if ($type == 'bool')
        $type = 'boolean';

      if (in_array($type, $this->multiple)) {

        $type = $this->invertMapping[$type];
        $type = str_replace(array('[', ']'), array('', ''), $type);

        $sql .= $row[LibDbAdmin::COL_NAME].' '.$type;

        ///FIX fixed text / size bug
        if (
          trim($row[LibDbAdmin::COL_LENGTH]) != ''
            && !in_array(
              $type,
              array(
                'integer', 'int4',
                'int2', 'int8',
                'boolean',
                'bytea'
              )
            )
        ) {
          $sql .= '('.str_replace('.',',',$row[LibDbAdmin::COL_LENGTH]).')';
        } else if (
          isset($row[LibDbAdmin::COL_PRECISION])
            && '' != trim(LibDbAdmin::COL_PRECISION)
            && (int) $row[LibDbAdmin::COL_PRECISION]
        ) {

          if(
            isset($row[LibDbAdmin::COL_SCALE])
              && '' != trim(LibDbAdmin::COL_SCALE)
              && (int) $row[LibDbAdmin::COL_SCALE]
              && in_array(
                $row[LibDbAdmin::COL_TYPE],
                array(
                  'numeric'
                )
              )
          ) {
            $sql .= '('.(int) $row[LibDbAdmin::COL_PRECISION].', '.(int) $row[LibDbAdmin::COL_SCALE].')';
          } else {
            $sql .= '('.(int) $row[LibDbAdmin::COL_PRECISION].')';
          }

        }

        $sql .= '[]';

      } else {

        $type = $row[LibDbAdmin::COL_TYPE];

        if ($type == 'bool')
          $type = 'boolean';

        ///FIX fixed text / size bug
        if (trim($row[LibDbAdmin::COL_LENGTH]) != '' && $type == 'text')
          $type = 'varchar';

        $sql .= $row[LibDbAdmin::COL_NAME].' '.$type;

        if
        (
          trim($row[LibDbAdmin::COL_LENGTH]) != ''
            && !in_array
            (
              $row[LibDbAdmin::COL_TYPE],
              array
              (
                'integer', 'int4',
                'int2', 'int8',
                'boolean',
                'bytea'
              )
            )
        )
        {
          $sql .= '('.str_replace('.',',',$row[LibDbAdmin::COL_LENGTH]).')';
        } else if
        (
          isset($row[LibDbAdmin::COL_PRECISION])
            && '' != trim(LibDbAdmin::COL_PRECISION)
            && (int) $row[LibDbAdmin::COL_PRECISION]
            && in_array
            (
              $row[LibDbAdmin::COL_TYPE],
              array
              (
                'numeric'
              )
            )
        )
        {
          if
          (
            isset($row[LibDbAdmin::COL_SCALE])
              && '' != trim(LibDbAdmin::COL_SCALE)
              && (int) $row[LibDbAdmin::COL_SCALE]
          )
          {
            $sql .= '('.(int) $row[LibDbAdmin::COL_PRECISION].', '.(int) $row[LibDbAdmin::COL_SCALE].')';
          } else {
            $sql .= '('.(int) $row[LibDbAdmin::COL_PRECISION].')';
          }
        }

      }

      if ((string) $row[LibDbAdmin::COL_NULL_ABLE] === 'true')
        $sql .= ' NOT NULL ';

      if (trim($row[LibDbAdmin::COL_DEFAULT]) != '')
        $sql .= ' DEFAULT '.(string) $row[LibDbAdmin::COL_DEFAULT].' ';

      $sql .= ', '.NL;
    }

    // check if the table has a rowid
    if ($hasRowid) {
    $sql .= <<<SQL
      PRIMARY KEY (rowid)
SQL;
    } else {
      $sql = substr($sql , 0 , -3);
    }

    $sql .= <<<SQL
);

SQL;

    if ($this->owner)
      $sql .= "ALTER TABLE {$tableName} OWNER TO {$this->owner}; ";

    if ($this->createPatch)
      $this->sqlPatch .= $sql.NL.NL;

    if ($this->syncDb)
      return $this->db->exec($sql);
    else
      return true;


  }//end public function createTable */

  /**
   * @param $tableName
   * @param string def=null $schemaName
   */
  public function dropTable( $tableName, $schemaName = null  )
  {

    if ($schemaName)
      $tableName = $schemaName.'.'.$tableName;

    // mit cascade sicher stellen, dass alle
    $sql = <<<SQL
DROP TABLE {$tableName} CASCADE;

SQL;

    if ($this->createPatch)
      $this->sqlPatch .= $sql.NL;

    if ($this->syncDb)
      return $this->db->exec($sql);
    else
      return true;

  }//end public function dropTable */

/*//////////////////////////////////////////////////////////////////////////////
// Table Indices
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $schemaName
   */
  public function getAllIndices($schemaName = null  )
  {

    $where = '';

    if ($schemaName) {
      $where = " where schemaname = '{$schemaName}' ";
    }

    $sql = <<<SQL
  SELECT * from pg_indexes {$where};

SQL;

    return $this->db->select($sql)->getAll();

  }//end public function getAllIndices */

  /**
   * @param string $tableName
   * @param string $schemaName
   */
  public function getTableIndices($tableName, $schemaName = null  )
  {
    /*
    $where = '';

    if ($schemaName) {
      $where = " and schemaname = '{$schemaName}'";
    }

    $sql = <<<SQL
  SELECT * from pg_indexes where tablename = '{$tableName}'{$where};

SQL;
    */

    $sql = <<<SQL
SELECT DISTINCT
ON(cls.relname) cls.oid,
cls.relname as idxname,
indrelid,
indkey,
indisclustered,
indisunique,
indisprimary,
n.nspname,
indnatts,
cls.reltablespace AS spcoid,
spcname,
tab.relname as tabname,
indclass,
con.oid AS conoid,
CASE contype
WHEN 'p' THEN desp.description
WHEN 'u' THEN desp.description
ELSE des.description
END AS description,
pg_get_expr(indpred, indrelid, true) as indconstraint,
contype,
condeferrable,
condeferred,
amname,
substring(array_to_string(cls.reloptions, ',') from 'fillfactor=([0-9]*)') AS fillfactor
  FROM pg_index idx
  JOIN pg_class cls ON cls.oid=indexrelid
  JOIN pg_class tab ON tab.oid=indrelid
  LEFT OUTER JOIN pg_tablespace ta on ta.oid=cls.reltablespace
  JOIN pg_namespace n ON n.oid=tab.relnamespace
  JOIN pg_am am ON am.oid=cls.relam
  LEFT JOIN pg_depend dep ON (dep.classid = cls.tableoid AND dep.objid = cls.oid AND dep.refobjsubid = '0')
  LEFT OUTER JOIN pg_constraint con ON (con.tableoid = dep.refclassid AND con.oid = dep.refobjid)
  LEFT OUTER JOIN pg_description des ON des.objoid=cls.oid
  LEFT OUTER JOIN pg_description desp ON (desp.objoid=con.oid AND desp.objsubid = 0)
 WHERE
    n.nspname = '{$schemaName}'
   AND tab.relname = '{$tableName}'

 ORDER BY cls.relname;
SQL;

    return $this->db->select($sql)->getAll();

  }//end public function getTableIndices */


  /**
   * @param string $indexName
   * @param string $schemaName
   */
  public function dropIndex($indexName, $schemaName = null  )
  {

    $schema = $schemaName?$schemaName.'.':'';

    return $this->db->exec('DROP INDEX '.$schema.$indexName.';');

  }//end public function dropIndex */


  /**
   * @param string $indexName
   * @param string $schemaName
   */
  public function createIndex($indexName, $schemaName = null  )
  {

    $schema = $schemaName?$schemaName.'.':'';

    return $this->db->exec('DROP INDEX '.$schema.$indexName.';');

  }//end public function createIndex */

/*//////////////////////////////////////////////////////////////////////////////
// Datenbank Views
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $viewName
   * @param string def=null $dbName
   * @param string def=null $schemaName
   *
   * @test TestDbAdmin::test_tableExists
   */
  public function viewExists( $viewName, $dbName = null, $schemaName = null  )
  {

    if (!$dbName)
      $dbName = $this->dbName;

    if (!$schemaName)
      $schemaName = $this->schemaName;

    $sql = <<<SQL
  SELECT
    table_name
    FROM  information_schema.tables
    WHERE
    table_catalog = '{$dbName}'
    AND table_schema = '{$schemaName}'
    AND table_name = '{$viewName}'
    AND table_type  = 'VIEW'  ;
SQL;

    return $this->db->select($sql)->get() ? true:false;

  }//end public function viewExists */

  /**
   * @param $tableName
   * @param string def=null $schemaName
   */
  public function dropView( $tableName, $schemaName = null  )
  {

    if ($schemaName)
      $tableName = $schemaName.'.'.$tableName;

    $sql = <<<SQL
DROP VIEW $tableName;

SQL;

    if ($this->createPatch)
      $this->sqlPatch .= $sql.NL;

    if ($this->syncDb)
      return $this->db->exec($sql);
    else
      return true;

  }//end public function dropView */

  /**
   * @param string $viewName
   */
  public function setViewOwner($viewName)
  {
    $sql ='';

    if ($this->owner)
      $sql .= "ALTER TABLE {$viewName} OWNER TO {$this->owner}; ";

    if ($this->createPatch)
      $this->sqlPatch .= $sql.NL.NL;

    if ($this->syncDb)
      return $this->db->exec($sql);
    else
      return true;

  }//end public function setTableOwner */

/*//////////////////////////////////////////////////////////////////////////////
// Table Columns
//////////////////////////////////////////////////////////////////////////////*/


  /**
   * @param string $colName
   * @param string def=null  $tableName
   * @param string def=null  $dbName
   * @param string def=null  $schemaName
   *
   * @test TestDbAdmin::test_tableExists
   */
  public function columnExists($colName, $tableName= null, $dbName = null, $schemaName = null  )
  {

    if (!$dbName)
      $dbName = $this->dbName;

    if (!$schemaName)
      $schemaName = $this->schemaName;

    if (!$tableName)
      $tableName = $this->tableName;

    $sql = <<<SQL

  SELECT
    column_name
    FROM  information_schema.columns
    WHERE
    table_catalog = '$dbName'
    AND table_schema = '$schemaName'
    AND table_name = '$tableName'
    AND column_name = '$colName' ;
SQL;

    return $this->db->select($sql)->get() ? true:false;

  }//end public function columnExists */

  /**
   * @param $dbName
   * @param $tableName
   * @param $schemaName
   *
   * @throws LibDb_Exception
   */
  public function alterColumn($colName, $newData , $diff = null, $tableName= null)
  {

    // rowid is inmutable!
    /*
    if ($colName == 'rowid')
      return true;
    */

    if (!$tableName)
      $tableName = $this->tableName;

    // throws LibDb_Exception if Col not exists
    $tableData = $this->getColumnData($colName, $tableName);

    if (!$diff)
      $diff = $this->diffCol($newData, $tableData);

    if (!$diff) {
      Log::warn('Tried to alter colum: '.$colName.' in table: '.$tableName.' but there was no diff');

      return true;
    }


    $sql = array();

    /*
    LibDbAdmin::COL_NAME
    LibDbAdmin::COL_DEFAULT
    LibDbAdmin::COL_NULL_ABLE
    LibDbAdmin::COL_TYPE
    LibDbAdmin::COL_LENGTH
    LibDbAdmin::COL_PRECISION
    LibDbAdmin::COL_SCALE
     */

    // mixed $needle  , array $haystack


    /*
ALTER TABLE -- change the definition of a table
Synopsis

ALTER TABLE [ ONLY ] name [ * ]
    action [, ... ]
ALTER TABLE [ ONLY ] name [ * ]
    RENAME [ COLUMN ] column TO new_column
ALTER TABLE name
    RENAME TO new_name
ALTER TABLE name
    SET SCHEMA new_schema

where action is one of:

    ADD [ COLUMN ] column type [ column_constraint [ ... ] ]
    DROP [ COLUMN ] column [ RESTRICT | CASCADE ]
    ALTER [ COLUMN ] column TYPE type [ USING expression ]
    ALTER [ COLUMN ] column SET DEFAULT expression
    ALTER [ COLUMN ] column DROP DEFAULT
    ALTER [ COLUMN ] column { SET | DROP } NOT NULL
    ALTER [ COLUMN ] column SET STATISTICS integer
    ALTER [ COLUMN ] column SET STORAGE { PLAIN | EXTERNAL | EXTENDED | MAIN }
    ADD table_constraint
    DROP CONSTRAINT constraint_name [ RESTRICT | CASCADE ]
    DISABLE TRIGGER [ trigger_name | ALL | USER ]
    ENABLE TRIGGER [ trigger_name | ALL | USER ]
    CLUSTER ON index_name
    SET WITHOUT CLUSTER
    SET WITHOUT OIDS
    OWNER TO new_owner
    SET TABLESPACE new_tablespace

     */

    if (!$this->invertMapping) {
      $this->invertMapping = array_flip($this->nameMapping);
    }

    $typeKey = $newData[LibDbAdmin::COL_TYPE];

    if ('bool' == $typeKey)
      $typeKey = 'boolean';

    if (!isset($this->invertMapping[$typeKey])  ) {
      Error::report(
        "type ".$newData[LibDbAdmin::COL_TYPE].' scheint nicht zu existieren ',
        $newData
      );

      return false;
    }

    $type = $this->invertMapping[$typeKey];

    if (in_array(LibDbAdmin::COL_TYPE,  $diff)) {


      if ($type == 'char' || $type == 'varchar'  || $type == 'char[]' || $type == 'varchar[]') {

        $size = trim($newData[LibDbAdmin::COL_LENGTH]);

        if ($size != '')
          $size = "($size)";

        if (in_array($type , $this->multiple)) {
          $type = str_replace(array('[',']') , array('','') , $type);

          $sql[] = <<<SQL
ALTER TABLE {$tableName} ALTER column {$colName} TYPE {$type}{$size}[];

SQL;

        } else {
          $sql[] = <<<SQL
ALTER TABLE {$tableName} ALTER column {$colName} TYPE {$type}{$size};

SQL;

        }

      } elseif (in_array($type, array('bytea','inet','macaddr','cidr','interval'))  ) {

          $sql[] = <<<SQL
ALTER TABLE {$tableName} DROP COLUMN {$colName};

SQL;

          $sql[] = <<<SQL
ALTER TABLE {$tableName} ADD COLUMN {$colName} {$type};

SQL;

      } elseif ($type == 'numeric' || $type == 'numeric[]') {


        $prec   = $newData[LibDbAdmin::COL_PRECISION];
        $scale  = $newData[LibDbAdmin::COL_SCALE];

        $size = '';

        if ($prec) {
          $size = "($prec";

          if ($scale)
             $size .= ",$scale";

          $size .= ")";
        }

        if (in_array($type , $this->multiple)) {
          $type = str_replace(array('[',']') , array('','') , $type);

          $sql[] = <<<SQL
ALTER TABLE {$tableName} ALTER column {$colName} TYPE {$type}{$size}[];

SQL;

        } else {
          $sql[] = <<<SQL
ALTER TABLE {$tableName} ALTER column {$colName} TYPE {$type}{$size};

SQL;

        }

      } else {
        $sql[] = <<<SQL
ALTER TABLE {$tableName} ALTER column {$colName} TYPE {$type};

SQL;

      }

    }//end if (in_array(LibDbAdmin::COL_TYPE,  $diff)  )
    else {

      if((
          $type == 'char'
            || $type == 'varchar'
            || $type == 'char[]'
            || $type == 'varchar[]'
        )
        && in_array(LibDbAdmin::COL_LENGTH , $diff)
      ) {

        $size = trim($newData[LibDbAdmin::COL_LENGTH]);

        if ($size != '')
          $size = "($size)";

        if (in_array($type , $this->multiple)) {
          $type = str_replace(array('[',']') , array('','') , $type);

          $sql[] = <<<SQL
ALTER TABLE {$tableName} ALTER column {$colName} TYPE {$type}{$size}[];

SQL;

        } else {
          $sql[] = <<<SQL
ALTER TABLE {$tableName} ALTER column {$colName} TYPE {$type}{$size};

SQL;

        }

      } else if
      (
        ($type == 'numeric' || $type == 'numeric[]')
          && in_array(array(LibDbAdmin::COL_SCALE,LibDbAdmin::COL_PRECISION) , $diff)
      )
      {


        $prec   = $newData[LibDbAdmin::COL_PRECISION];
        $scale  = $newData[LibDbAdmin::COL_SCALE];

        $size = '';

        if ($prec) {
          $size = "($prec";

          if ($scale)
             $size .= ",$scale";

          $size .= ")";
        }

        if (in_array($type, $this->multiple)) {
          $type = str_replace(array('[',']') , array('','') , $type);

          $sql[] = <<<SQL
ALTER TABLE {$tableName} ALTER column {$colName} TYPE {$type}{$size}[];

SQL;

        } else {
          $sql[] = <<<SQL
ALTER TABLE {$tableName} ALTER column {$colName} TYPE {$type}{$size};

SQL;

        }

      }

    }// alter the type


    if (in_array(LibDbAdmin::COL_DEFAULT , $diff)) {

      $default =  $newData[LibDbAdmin::COL_DEFAULT];

      if ($default) {

        if (in_array($type, array(
          'varchar', 'text', 'date',
          'time', 'timestamp', 'cidr', 'inet',
          'macaddr', 'interval'
        ))) {

          $def = ' DEFAULT \''.(string)$default.'\' ';

        } else {

          $def = ' DEFAULT '.(string)$default.' ';

        }


        $sql[] = <<<SQL
ALTER TABLE {$tableName} ALTER column {$colName} SET {$def};

SQL;

      } else {
        $sql[] = <<<SQL
ALTER TABLE {$tableName} ALTER column {$colName} DROP DEFAULT;

SQL;

      }

    }

    if (in_array(LibDbAdmin::COL_NULL_ABLE , $diff)) {

      $nullAble =  $newData[LibDbAdmin::COL_NULL_ABLE];
      $default =  $newData[LibDbAdmin::COL_DEFAULT];

      if ($nullAble == 'NO') {

        if ($type == 'char' || $type == 'varchar' || $type == 'text') {

          $default = $default?:' ';

          $sql[] = <<<SQL
UPDATE {$tableName} SET {$colName} = '{$default}' where {$colName} is null;

SQL;
        } elseif ($type == 'char[]'  || $type == 'varchar[]' || $type == 'text[]') {
          $sql[] = <<<SQL
UPDATE {$tableName} SET {$colName} = '{""}' where {$colName} is null;

SQL;
        } elseif ($type == 'bytea') {

          $default = $default?:'';

          $sql[] = <<<SQL
UPDATE {$tableName} SET {$colName} = '{$default}' where {$colName} is null;

SQL;
        } elseif (in_array($type , array('smallint', 'integer', 'int', 'bigint', 'numeric')  )  ) {

          $default = $default?:'0';

          $sql[] = <<<SQL
UPDATE {$tableName} SET {$colName} = {$default} where {$colName} is null;

SQL;
        } elseif (in_array($type , array('smallint[]', 'integer[]', 'int[]', 'bigint[]', 'numeric[]')  )   ) {

          $default = $default?:'{0}';

          $sql[] = <<<SQL
UPDATE {$tableName} SET {$colName} = '{$default}' where {$colName} is null;

SQL;
        } elseif ($type == 'boolean') {

          $default = $default?:'false';

          $sql[] = <<<SQL
UPDATE {$tableName} SET {$colName} = {$default} where {$colName} is null;

SQL;
        } elseif ($type == 'time') {

          $default = $default?:date('H:i:s');

          $sql[] = <<<SQL
UPDATE {$tableName} SET {$colName} = '{$default}' where {$colName} is null;

SQL;
        } elseif ($type == 'timestamp') {

          $default = $default?:date('Y-m-d H:i:s');

          $sql[] = <<<SQL
UPDATE {$tableName} SET {$colName} = '{$default}' where {$colName} is null;

SQL;
        } elseif ($type == 'date') {

          $default = $default?:date('Y-m-d');

          $sql[] = <<<SQL
UPDATE {$tableName} SET {$colName} = '{$default}' where {$colName} is null;

SQL;
        } elseif ($type == 'time[]' || $type == 'timestamp[]' || $type == 'date[]') {
          $sql[] = <<<SQL
UPDATE {$tableName} SET {$colName} = '{now()}' where {$colName} is null;

SQL;
        } elseif ($type == 'uuid') {


          $rows = $this->db->select('select rowid from '.$tableName.' where '.$colName.' is null;'.NL);

          foreach ($rows as $pos) {

            // jeder eintrag bekommt eine eigene uuid
            $uuid = Webfrap::uuid();

            $sql[] = <<<SQL
UPDATE {$tableName} SET {$colName} = '{$uuid}' where {$colName} = {$pos['rowid']};

SQL;

          }

        } elseif ($type == 'uuid[]') {

          $rows = $this->db->select('select rowid from '.$tableName.' where '.$colName.' is null;'.NL);

          foreach ($rows as $pos) {

            // jeder eintrag bekommt eine eigene uuid
            $uuid = Webfrap::uuid();
            $sql[] = <<<SQL
UPDATE {$tableName} SET {$colName} = '{"{$uuid}"}' where {$colName} = {$pos['rowid']};

SQL;


          }
        } else {

    if (DEBUG)
      Debug::console('Got non matched type for set not null: '.$type);

      $default = $default?:' ';

          $sql[] = <<<SQL
UPDATE {$tableName} SET {$colName} = '{$default}' where {$colName} is null;

SQL;
        }


        $sql[] = <<<SQL
ALTER TABLE {$tableName} ALTER column {$colName} SET NOT NULL;

SQL;

      } else {
        $sql[] = <<<SQL
ALTER TABLE {$tableName} ALTER column {$colName} DROP NOT NULL;

SQL;

      }


    }

    $change = true;


    foreach ($sql as $alterSql) {
      Debug::console($alterSql);
      Log::warn($alterSql);
    }

    if ($this->createPatch) {
      foreach ($sql as $alterSql) {
        $this->sqlPatch .= $alterSql.NL;
      }
    }


    if ($this->syncDb) {
      foreach ($sql as $alterSql) {
        if (!$this->db->exec($alterSql)) {
          $change = false;
        }

      }

      return $change;

    } else {
      return true;
    }

  }//end public function alterColumn */

  /**
   * Umbenennen einer Column
   *
   * @param string $colOldName
   * @param string $colNewName
   * @param string $tableName
   * @param string $dbName
   * @param string $schemaName
   *
   * @return boolean
   */
  public function renameColumn($colOldName, $colNewName, $tableName = null, $dbName = null, $schemaName = null  )
  {
    if (!$dbName)
      $dbName = $this->dbName;

    if (!$schemaName)
      $schemaName = $this->schemaName;

    if (!$tableName)
      $tableName = $this->tableName;

    $alterSql = <<<SQL
ALTER TABLE {$tableName} RENAME COLUMN {$colOldName} TO {$colNewName};
SQL;

    if ($this->db->exec($alterSql)) {
      return true;
    } else {
      return false;
    }

  }//end public function renameColumn */


  /**
   * @param string $dbName
   * @param string $tableName
   * @param string $schemaName
   *
   * @throws LibDb_Exception
   *
   * @test TestDbAdmin::test_diffColumn
   */
  public function diffColumn($colName, $data , $tableName = null, $dbName = null, $schemaName = null  )
  {

    if (!$dbName)
      $dbName = $this->dbName;

    if (!$schemaName)
      $schemaName = $this->schemaName;

    if (!$tableName)
      $tableName = $this->tableName;


    if (!$dbData = $this->getColumnData($colName, $tableName, $dbName, $schemaName)) {
      throw new LibDb_Exception(
        'Requested Column '.$colName.' for Table: '.$tableName.' in Schema: '.$schemaName.' Database: '.$dbName.' not exists'
      );
    }

    return $this->diffCol($data , $dbData , $tableName);

  }//end public function diffColumn */

  /**
   * @param string $dbName
   * @param string $tableName
   * @param string $schemaName
   *
   * @throws LibDb_Exception
   *
   * @test TestDbAdmin::test_diffColumn
   */
  public function reportDiffColumn($colName, $data , $tableName = null, $dbName = null, $schemaName = null  )
  {

    if (!$dbName)
      $dbName = $this->dbName;

    if (!$schemaName)
      $schemaName = $this->schemaName;

    if (!$tableName)
      $tableName = $this->tableName;


    if (!$dbData = $this->getColumnData($colName, $tableName, $dbName, $schemaName)) {
      throw new LibDb_Exception
      (
        'Requested Column '.$colName.' for Table: '.$tableName.' in Schema: '.$schemaName.' Database: '.$dbName.' not exists'
      );
    }

    return $this->reportDiffCol($data , $dbData , $tableName);

  }//end public function diffColumn */

  /**
   * @param string $colName
   * @param array $data
   * @param string $tableName
   * @param string $schemaName
   */
  public function addColumn($colName, $data, $tableName = null,  $schemaName = null)
  {

    if (!$schemaName)
      $schemaName = $this->schemaName;

    if (!$tableName)
      $tableName = $this->tableName;

    /**
    ADD [ COLUMN ] column type [ column_constraint [ ... ] ]
     */

    $queryPool = array();

    if (!$this->invertMapping) {
      $this->invertMapping = array_flip($this->nameMapping);
    }

    $rawType = null;

    if (!isset($data[LibDbAdmin::COL_TYPE])) {
      if (!isset($data['type'])) {
        Message::addError('Missing the Type in the given Data for add new column: '.$colName);
        Debug::console('Missing the Type in the given Data for add new column: '.$colName ,$data);

        return;
      } else {
        $type     = $data['type'];
      }
    } else {
      $rawType = $data[LibDbAdmin::COL_TYPE];

      if ('bool' == $rawType)
        $rawType = 'boolean';

      if (!isset($this->invertMapping[$rawType])) {
        Debug::console('Wrong datatype ', Debug::dumpFull($data), null, true);
        Message::addError('Tried to sync with nonexisting datatype: '.$rawType);

        return false;
      }

      $type = $this->invertMapping[$rawType];
    }

    if ('' == trim($type)) {
      Debug::console('got empty type '.$tableName.': '.$colName);
      Message::addError('got empty type '.$tableName.': '.$colName);

      return false;
    }

    $sql  = 'ALTER TABLE '.$tableName.' ADD COLUMN '.$colName.' '.$type ;

    if (!in_array($type, array
      (
        'bytea', 'inet', 'integer',
        'int4', 'int2', 'int8',
        'smallint', 'bigint',
        'cidr', 'macaddr', 'inet',
        'date', 'interval', 'time',
        'text', 'timestamp'
    )))
    {
      if (isset($data[LibDbAdmin::COL_LENGTH])) {
        if (trim($data[LibDbAdmin::COL_LENGTH]) != '')
          $sql .= '('.str_replace('.',',',$data[LibDbAdmin::COL_LENGTH]).')';
      } else {
        if (trim($data[LibDbAdmin::COL_PRECISION])) {
          $sql .= '('.$data[LibDbAdmin::COL_PRECISION];

          if (trim($data[LibDbAdmin::COL_SCALE])) {
            $sql .= ','.$data[LibDbAdmin::COL_SCALE];
          }
          $sql .= ')';
        }
      }

    }

    if (isset($data[LibDbAdmin::COL_DEFAULT])) {
      $data['default'] = $data[LibDbAdmin::COL_DEFAULT];
    }

    if (trim($data['default']) != '') {
      if (in_array($type, array
      (
        'varchar', 'text', 'date',
        'time', 'timestamp', 'cidr','inet',
        'macaddr', 'interval'
      )))
      {
        $sql .= ' DEFAULT \''.(string) $data['default'].'\' ';
      } else {
        $sql .= ' DEFAULT '.(string) $data['default'].' ';
      }
    }


    $sql .= ';'.NL;

    $queryPool[] = $sql ;

    if (isset($data[LibDbAdmin::COL_NULL_ABLE])) {
      $data['required'] = $data[self::COL_NULL_ABLE]=='YES'?'false':'true';
    }

    if ((string) $data['required'] === 'true') {

        $update = null;

        if (in_array($type, array('char','varchar','text'))) {
          $update = <<<SQL
UPDATE {$tableName} SET {$colName} = ' ' where {$colName} is null;

SQL;
        } elseif ($type == 'boolean') {
          $update = <<<SQL
UPDATE {$tableName} SET {$colName} = false where {$colName} is null;

SQL;
        } elseif (in_array($type, array('char[]','varchar[]','text[]'))  ) {
          $update = <<<SQL
UPDATE {$tableName} SET {$colName} = '{""}' where {$colName} is null;

SQL;
        } elseif ($type == 'integer' || $type == 'numeric' || $type == 'int' || $type == 'smallint' || $type == 'bigint') {
          $update = <<<SQL
UPDATE {$tableName} SET {$colName} = 0 where {$colName} is null;

SQL;
        } elseif ($type == 'integer[]' || $type == 'numeric[]' || $type == 'int[]' || $type == 'smallint[]' || $type == 'bigint[]') {
          $update = <<<SQL
UPDATE {$tableName} SET {$colName} = '{0}' where {$colName} is null;

SQL;
        } elseif ($type == 'time' || $type == 'timestamp' || $type == 'date') {
          $update = <<<SQL
UPDATE {$tableName} SET {$colName} = now() where {$colName} is null;

SQL;
        } elseif ($type == 'time[]' || $type == 'timestamp[]' || $type == 'date[]') {
          $update = <<<SQL
UPDATE {$tableName} SET {$colName} = '{now()}' where {$colName} is null;

SQL;
        } elseif ($type == 'uuid') {

          $rows = $this->db->select('select rowid from '.$tableName.' where '.$colName.' is null;'.NL);

          foreach ($rows as $pos) {

            // jeder eintrag bekommt eine eigene uuid
            $uuid = Webfrap::uuid();

            $tmpQuery = <<<SQL
UPDATE {$tableName} SET {$colName} = '{$uuid}' where {$colName} = {$pos['rowid']};

SQL;
            $queryPool[] = $tmpQuery;


          }

        } elseif ($type == 'uuid[]') {

          $rows = $this->db->select('select rowid from '.$tableName.' where '.$colName.' is null;'.NL);

          foreach ($rows as $pos) {

            // jeder eintrag bekommt eine eigene uuid
            $uuid = Webfrap::uuid();
            $tmpQuery = <<<SQL
UPDATE {$tableName} SET {$colName} = '{"{$uuid}"}' where {$colName} = {$pos['rowid']};

SQL;
            $queryPool[] = $tmpQuery ;

          }

        } else {

          if (DEBUG)
            Debug::console('fallback got no default for: '.$type);

          $update = <<<SQL
UPDATE {$tableName} SET {$colName} = ' ' where {$colName} is null; --else $type

SQL;
        }

      if ($update)
        $queryPool[] = $update;


      $alter = "ALTER TABLE {$tableName} ALTER column {$colName} SET NOT NULL;".NL;


     $queryPool[] = $alter ;

    }//end (string) $data['required'] === 'true'


    $change = true;

    if ($this->createPatch) {
      foreach ($queryPool as $alterSql) {
        $this->sqlPatch .= $alterSql.NL;
      }
    }


    if ($this->syncDb) {
      foreach ($queryPool as $alterSql) {
        if (!$this->db->exec($alterSql)) {
          $change = false;
        }
      }

      return $change;

    } else {
      return true;
    }

  }//end public function addColumn */

  /**
   * @param $colName
   * @param $tableName
   * @param $schemaName
   */
  public function dropColumn($colName,  $tableName= null, $schemaName = null)
  {

    if (!$schemaName)
      $schemaName = $this->schemaName;

    if (!$tableName)
      $tableName = $this->tableName;

    $sql = "ALTER TABLE {$tableName} drop column {$colName} RESTRICT;";

    if ($this->createPatch)
      $this->sqlPatch .= $sql.NL;

    if ($this->syncDb)
      return $this->db->exec($sql);
    else
      return true;

  }//end public function dropColumn */


  /**
   * @param array $newData
   * @param array $dbData
   * @param string $tableName
   */
  public function diffCol($newData , $dbData , $tableName)
  {

    $diff = array();

    foreach ($newData as $key => $value) {
      if ($dbData[$key] != $value) {
        $diff[] = $key;
      }
    }

    return $diff;

  }//end public function diffCol */

  /**
   * @param array $newData
   * @param array $dbData
   * @param string $tableName
   */
  public function reportDiffCol($newData , $dbData , $tableName)
  {

    $diff = array();

    foreach ($newData as $key => $value) {
      if ($dbData[$key] != $value) {
        $diff[] = "{$key}: {$dbData[$key]} != {$value}" ;
      }
    }

    return implode(', ', $diff);

  }//end public function reportDiffCol */

  /**
   * @param $dbName
   * @param $tableName
   * @param $schemaName
   *
   * @test TestDbAdmin::test_getColumnData
   */
  public function getColumnData($theCol, $tableName = null, $dbName = null, $schemaName = null  )
  {

    if (!$dbName)
      $dbName = $this->dbName;

    if (!$schemaName)
      $schemaName = $this->schemaName;

    if (!$tableName)
      $tableName = $this->tableName;

    $colName      = LibDbAdmin::COL_NAME;
    $colDefault   = LibDbAdmin::COL_DEFAULT;
    $colNullAble  = LibDbAdmin::COL_NULL_ABLE;
    $colType      = LibDbAdmin::COL_TYPE;
    $colLength    = LibDbAdmin::COL_LENGTH;
    $colPrecision = LibDbAdmin::COL_PRECISION;
    $colScale     = LibDbAdmin::COL_SCALE;

    $sql = <<<SQL
  SELECT
    column_name as {$colName},
    column_default as {$colDefault},
    is_nullable as {$colNullAble},
    udt_name as {$colType},
    character_maximum_length as {$colLength},
    numeric_precision as {$colPrecision},
    numeric_scale as {$colScale}

    FROM  information_schema.columns
    WHERE
    table_catalog = '$dbName'
    AND table_schema = '$schemaName'
    AND table_name = '$tableName'
    AND column_name = '$theCol'  ;
SQL;

    if (!$data = $this->db->select($sql)->get()) {
      throw  new LibDb_Exception('col '.$theCol.' not exists');
    }

    $data[$colLength] = (int) $data[$colLength];
    $data[$colPrecision] = (int) $data[$colPrecision];
    $data[$colScale] = (int) $data[$colScale];

    return $data;

  }//end public function getColumnData */

  /**
   * @param string $tableName
   * @param string $dbName
   * @param string $schemaName
   */
  public function getTableColumns( $tableName, $dbName = null, $schemaName = null  )
  {

    if (!$dbName)
      $dbName = $this->dbName;

    if (!$schemaName)
      $schemaName = $this->schemaName;

    $colName      = LibDbAdmin::COL_NAME;
    $colDefault   = LibDbAdmin::COL_DEFAULT;
    $colNullAble  = LibDbAdmin::COL_NULL_ABLE;
    $colType      = LibDbAdmin::COL_TYPE;
    $colLength    = LibDbAdmin::COL_LENGTH;
    $colPrecision = LibDbAdmin::COL_PRECISION;
    $colScale     = LibDbAdmin::COL_SCALE;

    $sql = <<<SQL
  SELECT
    column_name as {$colName},
    column_default as {$colDefault},
    is_nullable as {$colNullAble},
    udt_name as {$colType},
    character_maximum_length as {$colLength},
    numeric_precision as {$colPrecision},
    numeric_scale as {$colScale}

  FROM
    information_schema.columns
  WHERE
      table_catalog = '$dbName'
      AND table_schema = '$schemaName'
      AND table_name = '$tableName'
SQL;

    return $this->db->select($sql)->getAll();

  }//end public function getTableColumnData */


/*//////////////////////////////////////////////////////////////////////////////
// sync methods
//////////////////////////////////////////////////////////////////////////////*/

 /**
   * @param $tableName
   * @param $entity
   * @param boolean $multiSeq
   */
  public function syncEntityTable($tableName, $entity, $multiSeq = false)
  {

    foreach ($entity as $attribute) {

      $colName = $attribute->name();

      // never change rowid or any m_ flags
      //if ($attribute->inCategory('meta'))
      //  continue;

      if ($this->columnExists($colName , $tableName)) {

        if (!$this->syncAttributeColumn($tableName, $attribute, $multiSeq)) {
          $this->dropColumn($colName,$tableName);
          $this->createAttributeColumn($tableName, $attribute, $multiSeq);
        }
      } else {  // colum not exists
        $this->createAttributeColumn($tableName, $attribute, $multiSeq);
      }

    }

    $this->setTableOwner($tableName);

  }//end protected function syncTable */

  /**
   * @param string $tableName
   * @param LibGenfTreeNodeEntity $entity
   * @param boolean $multiSeq
   */
  public function createEntityTable($tableName, $entity, $multiSeq = false)
  {

    $colData = array();

    //<attribute name="name" type="varchar" size="120" required="false"  >

    foreach ($entity as $attribute) {
      $colData[] = $this->columnAttributeData($attribute, $tableName, $multiSeq);
    }

    $this->createTable($tableName, $colData);
    Message::addMessage('Tabelle '.$tableName.' wurde erfolgreich erstellt');

  }//end protected function createTable */

  /**
   * @param string $tableName
   * @param LibGenfTreeNodeAttribute $attribute
   * @param boolean $multiSeq
   * @return unknown_type
   */
  public function syncAttributeColumn($tableName, $attribute, $multiSeq)
  {

    //TODO maybe this should be a "little" more genereric
    $orgType  = trim($attribute->dbType());

    $mapping  = $this->nameMapping;

    if (isset($mapping[$orgType])) {
      $type     = $mapping[$orgType];
    } else {
      Error::addError('missing $orgType'.$orgType);
      $type = 'text';
    }


    if ($seqName = $attribute->sequence()) {
      $default =  "nextval('{$seqName}'::regclass)";
    } elseif ($attribute->name('rowid')) {
      $seqName = Db::SEQUENCE;
      $default =  "nextval('{$seqName}'::regclass)";
    } elseif ($def = $attribute->defaultValue()) {

      if (!$attribute->target()  )
        $default = $def;
      else
        $default = '';
    } else {
      $default = '';
    }

    $precision  = null;
    $scale      = null;
    $length     = null;
    $size       = $attribute->size();

    if ($orgType == 'numeric') {
      $tmp = explode('.'  , $size);

      $precision = $tmp[0];

      if (isset($tmp[1]))
        $scale = $tmp[1];
      else
        $scale = 0;

    } elseif ($orgType == 'smallint') {
      $precision  = '16';
      $scale      = '0';
    } elseif ($orgType == 'integer' || $orgType == 'int') {
      $precision  = '32';
      $scale      = '0';
    } elseif ($orgType == 'bigint') {
      $precision  = '64';
      $scale      = '0';
    } elseif ($orgType == 'char') {
      if (trim($size) == '') {
        $length = '1';
      } else {
        $length = trim($size);
      }
    } else {
      $length = trim($size);
    }

    if ($attribute->required()) {
      $nullAble = 'NO';
    } else {
      $nullAble = 'YES';
    }

    $colName = $attribute->name();

    $checkNegativ = array(
      'integer',
      'int2' ,
      'smallint'  ,
      'bigint'  ,
      'int8'  ,
      'numeric' ,
    );


    if( in_array($type,$checkNegativ) ){
      if($default && $default < 0){
        $default = "($default)";
      }
    }

    $data = array(
      LibDbAdmin::COL_NAME        => $colName,
      LibDbAdmin::COL_DEFAULT     => $default,
      LibDbAdmin::COL_NULL_ABLE   => $nullAble,
      LibDbAdmin::COL_TYPE        => $type,
      LibDbAdmin::COL_LENGTH      => $length,
      LibDbAdmin::COL_PRECISION   => $precision,
      LibDbAdmin::COL_SCALE       => $scale,
    );

    if ($diff = $this->diffColumn($colName , $data, $tableName  )) {
      try {
        $this->alterColumn($colName , $data, $diff, $tableName);
        Message::addMessage('Column: '.$colName.' in Tabelle '.$tableName.' wurde angepasst');

        return true;
      } catch (LibDb_Exception $e) {
        // error was allready reported in the exception
        return false;
      }
    }

    return true;

  }//end protected function syncColumn */

  /**
   * @param $tableName
   * @param LibGenfTreeNodeAttribute $attribute
   * @param boolean $multiSeq
   * @return unknown_type
   */
  public function createAttributeColumn($tableName, $attribute, $multiSeq  )
  {

    if (is_object($attribute)) {
      $colName = $attribute->name();
    } else {
      $colName = $attribute['col_name'];
    }

    $this->addColumn($colName , $this->columnAttributeData($attribute, $tableName),  $tableName);
    Message::addMessage('Column: '.$colName.' in Tabelle '.$tableName.' wurde erstellt');

  }//end protected function createColumn */

  /**
   * @param LibGenfTreeNodeAttribute $attribute
   * @param string $tableName
   * @param boolean $multiSeq
   */
  public function columnAttributeData($attribute, $tableName = null, $multiSeq = false)
  {

    if (is_object($attribute)) {
      if (!$tableName)
        $tableName = $attribute->name->source;
    } else {
      if (!$tableName) {
        throw new LibDb_Exception('Missing TableName in Column Attribute '.$attribute['col_name']);
      }
    }

    if (is_object($attribute)) {

      if ($sequence = $attribute->sequence()) {
        if ($multiSeq) {
          if (is_string($sequence)) {
            $default =  "nextval('".$sequence."'::regclass)";
          } else {
            $default =  "nextval('".$tableName."_".$attribute->name()."_seq'::regclass)";
          }

          //$dbAdmin->createSequence($tableName."_".$attribute->name()."_seq");
        } else {

          if (!is_string($sequence)) {
            $sequence =  Db::SEQUENCE;
          }

          $default = "nextval('{$sequence}'::regclass)";
        }
      } elseif ($attribute->name(Db::PK)) {
        $seqName = Db::SEQUENCE;
        $default = "nextval('{$seqName}'::regclass)";
      } elseif ($def = $attribute->defaultValue()) {

        if (!$attribute->target())
          $default = $def;
        else
          $default = '';
      } else {
        $default = '';
      }

      $type     = $attribute->dbType();

      if ($type == 'bytea') {
        $size     = '';
      } else {
        $size     = str_replace('.' , ',', $attribute->size());
      }

      $colData  = array
      (
        'name'      => $attribute->name(),
        'type'      => $type,
        'size'      => $size,
        'required'  => $attribute->required()?'true':'false',
        'default'   => $default,
      );
    } else {

      if (trim($attribute['col_length']) == '') {
        $size = $attribute['col_length'];
      } else {
        $size = $attribute['col_scale'].(trim($attribute['col_precision'])==''?'.'.$attribute['col_precision']:'');
      }

      $colData  = array
      (
        'name'      => $attribute['col_name'],
        'type'      => $attribute['col_type'],
        'size'      => $size,
        'required'  => $attribute['col_null_able'] == 'YES'?'false':'true',
        'default'   => $attribute['col_default'],
      );
    }

    return $colData;

  }//end protected function columnData */

/*//////////////////////////////////////////////////////////////////////////////
// Sequence Logic
//////////////////////////////////////////////////////////////////////////////*/


  /**
   * @param string $tableName
   * @param array<array> $data
   * @param string def=null $schemaName
   */
  public function createSequence( $seqName,  $schemaName = null, $start = null  )
  {

    if (!$schemaName)
      $schemaName = $this->schemaName;

    // if is null use the default start
    if (is_null($start))
      $start = self::SEQ_START;

    if ($this->createPatch) {
      $this->sqlPatch .= "CREATE SEQUENCE {$schemaName}.{$seqName} START ".$start." INCREMENT BY 1 ;".NL;

      if ($this->owner)
        $this->sqlPatch .= "ALTER TABLE  {$schemaName}.{$seqName} OWNER TO {$this->owner} ;".NL;
    }

    if ($this->syncDb) {
      $this->db->exec("CREATE SEQUENCE {$schemaName}.{$seqName} START ".$start." INCREMENT BY 1 ;");

      if ($this->owner)
        $this->db->exec("ALTER TABLE  {$schemaName}.{$seqName} OWNER TO {$this->owner};");
    }


  }//end public function createSequence */


  /**
   * @param string $tableName
   * @param array<array> $data
   * @param string def=null $schemaName
   */
  public function createTableSequence( $schemaName,  $tableName  )
  {

    if (!$schemaName)
      $schemaName = $this->schemaName;

    $seqName = $schemaName.'.'.$tableName.'_rowid_seq';

    $createSql = <<<SQL
CREATE SEQUENCE {$seqName}
  INCREMENT 1
  MINVALUE 1
  MAXVALUE 9223372036854775807
  START 1
  CACHE 1;

SQL;

    $alterSql = "ALTER TABLE  {$seqName} OWNER TO {$this->owner};";

    if ($this->createPatch) {
      $this->sqlPatch .= $createSql.NL;
      $this->sqlPatch .= $alterSql.NL;
    }

    if ($this->syncDb) {
      $this->db->exec($createSql);
      $this->db->exec($alterSql);
    }


  }//end public function createTableSequence */

  /**
   *
   * @param string $tableName
   * @param string def=null $dbName
   * @param string def=null $schemaName
   *
   * @test TestDbAdmin::test_tableExists
   */
  public function sequenceExists( $tableName, $dbName = null, $schemaName = null  )
  {

    if (!$dbName)
      $dbName = $this->dbName;

    if (!$schemaName)
      $schemaName = $this->schemaName;

    $sql = <<<SQL
  SELECT
    count(sequence_name) as num_seq
    FROM  information_schema.sequences
    WHERE
    sequence_catalog = '$dbName'
    AND sequence_schema = '$schemaName'
    AND upper(sequence_name) = upper('{$tableName}') ;
SQL;

    return (boolean) (int) $this->db->select($sql)->getField('num_seq');

  }//end public function sequenceExists */

  /**
   *
   * @param unknown_type $dbName
   * @param unknown_type $schemaName
   * @return unknown_type
   */
  public function createMainSequence($dbName, $schemaName   )
  {

    $seqName = Db::SEQUENCE;

    if ($this->createPatch) {
      $this->sqlPatch .= "CREATE SEQUENCE {$schemaName}.{$seqName} START ".self::SEQ_START." INCREMENT BY 1 ;".NL;
      $this->sqlPatch .= "ALTER TABLE  {$schemaName}.{$seqName} OWNER TO {$connection->owner};".NL;
    }


    if ($this->syncDb) {
      $this->db->exec("CREATE SEQUENCE {$schemaName}.{$seqName} START ".self::SEQ_START." INCREMENT BY 1 ;");
      $this->db->exec("ALTER TABLE  {$schemaName}.{$seqName} OWNER TO {$connection->owner};");
    } else

      return true;

  }//end public function createMainSequence */

  /**
   * Owner einer Sequence ändern
   * @param string $sequence
   * @param string $owner
   */
  public function chownSequence($sequence, $owner = null)
  {

    if (!$owner)
      $owner = $this->owner;

    $sql ='';

    if ( $this->owner)
      $sql .= "ALTER SEQUENCE {$sequence} OWNER TO {$owner}; ";

    if ($this->createPatch)
      $this->sqlPatch .= $sql.NL.NL;

    if ($this->syncDb)
      return $this->db->exec($sql);
    else
      return true;

  }//end public function setTableOwner */

  /**
   * @param string $schema Name des Schemas
   * @return array Liste aller vorhandenen Sequenzen
   */
  public function getSequences($schema)
  {

    $sql = <<<SQL
SELECT
  cl.oid,
  relname as name,
  pg_get_userbyid(relowner) AS owner,
  relacl,
  description
FROM
  pg_class cl
LEFT OUTER JOIN
  pg_description des ON des.objoid=cl.oid
JOIN
  pg_namespace ns
    ON ns.oid = cl.relnamespace

 WHERE
   relkind = 'S'
     AND ns.nspname  = '{$schema}'
 ORDER BY relname

SQL;

    $sql .= ";";

    return $this->db->select($sql)->getAll();

  }//end public function getSequences */

/*//////////////////////////////////////////////////////////////////////////////
// Functions
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $schemaName
   * @param string $dbName
   */
  public function getFunctions($schemaName = null, $dbName = null  )
  {

    if (!$schemaName)
      $schemaName = $this->schemaName;

    if (!$dbName)
      $dbName = $this->dbName;

    $sql = <<<SQL
  SELECT
    pr.oid, pr.xmin, pr.*,
    format_type(TYP.oid, NULL) AS typname,
    typns.nspname AS typnsp,
    lanname, proargnames,
    pg_get_expr(proargdefaults, 'pg_catalog.pg_class'::regclass) AS proargdefaultvals,
    pronargdefaults,
    proconfig,
    pg_get_userbyid(proowner) as funcowner,
    description
  FROM pg_proc pr
  JOIN pg_type typ ON typ.oid=prorettype
  JOIN pg_namespace typns ON typns.oid = typ.typnamespace
  JOIN pg_language lng ON lng.oid=prolang
  LEFT OUTER JOIN pg_description des ON des.objoid=pr.oid
 WHERE
   proisagg = FALSE
     AND typname <> 'trigger'
     typns.nspname = '{$schemaName}'
 ORDER BY proname

SQL;

    return $this->db->select($sql)->getAll();

  }//end public function getFunctions */



/*//////////////////////////////////////////////////////////////////////////////
// Trigger
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $schemaName
   * @param string $dbName
   */
  public function getTriggers($schemaName = null, $dbName = null  )
  {

    if (!$schemaName)
      $schemaName = $this->schemaName;

    if (!$dbName)
      $dbName = $this->dbName;

    $sql = <<<SQL
SELECT
  pr.proname,
  pr.prosrc,
  pr.proargtypes,
  format_type(TYP.oid, NULL) AS typname,
  typns.nspname AS typnsp,
  proargnames,
  pg_get_expr(proargdefaults, 'pg_catalog.pg_class'::regclass) AS proargdefaultvals,
  pronargdefaults,
  pg_get_userbyid(proowner) as funcowner,
  description
  FROM pg_proc pr
  JOIN pg_type typ ON typ.oid=prorettype
  JOIN pg_namespace typns ON typns.oid = typ.typnamespace
  JOIN pg_language lng ON lng.oid=prolang
  LEFT OUTER JOIN pg_description des ON des.objoid=pr.oid
 WHERE
  proisagg = FALSE
  AND typname = 'trigger'
  AND typns.nspname = '{$schemaName}'
 ORDER BY proname;

SQL;

    return $this->db->select($sql)->getAll();

  }//end public function getTriggers */

} // end class LibDbAdminPostgresql

