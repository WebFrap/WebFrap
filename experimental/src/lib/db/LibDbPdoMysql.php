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
 * @subpackage tech_core
 */
class LibDbPdoMysql
     extends LibDbPdo
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Der Standard Fetch Mode
   */
  protected $fetchMode   = PDO::FETCH_ASSOC;

  /**
   * Holen der Daten als Assoziativer Array
   */
  const fetchAssoc  = PDO::FETCH_ASSOC;

  /**
   * Holen der Daten als Numerischer Array
   */
  const fetchNum    = PDO::FETCH_NUM;

  /**
   * Holen der Daten als Doppelter Assoziativer und Numerischer Array
   */
  const fetchBoth   = PDO::FETCH_BOTH;

  /**
   * Database Connection Object
   * @var Pdo
   */
  protected $connection        = null;

  /**
   * the type of the sql sqlBuilder for this database class
   *
   * @var string
   */
  protected $builderType = 'Mysql';

/*//////////////////////////////////////////////////////////////////////////////
// Application Logic
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Eine Selectquery an die Datenbank
   *
   * @param mixed $sql Ein Select Object
   * @param bool[optional] $returnit, Soll die Anfrage gleich zurückgegeben werden?
   * @param bool[optional] $send, Soll die Anfrage Assynchron gesendet werden
   * @return mixed
   * @throws LibDb_Exception
   */
  public function select($sql  )
  {

    ++$this->counter ;

    if (is_object($sql)  ) {
      if (!$sqlstring = $this->sqlBuilder->buildSelect($sql)) {
        // Fehlermeldung raus und gleich mal nen Trace laufen lassen
        throw new LibDb_Exception
        (
        I18n::s('failed to build sql','wbf.log.dbFailedToParseSql')
        );
      }
    } elseif (is_string($sql)) {
      $sqlstring = $sql;
    } else {
      // Fehlermeldung raus und gleich mal nen Trace laufen lassen
      $args = func_get_args();
      Error::addError
      (
        I18n::s('wbf.log.dbIncopatibleParameters'),
        'LibDb_Exception',
        $args
      );
    }

    if (Log::$levelDebug)
      Log::debug('Select Query: '. $sqlstring);

    if (DEBUG)
      Debug::console('Select Query: '. $sqlstring);

    if (!$this->result = $this->connection->query($sqlstring)  ) {
      // Fehlermeldung raus und gleich mal nen Trace laufen lassen
      Error::addError
      (
      'Query Error: '.$this->extractPdoError().' for query: '.$sqlstring,
      'LibDb_Exception'
      );
    }

    return new LibDbPdoMysqlResult($this->result , $this , $sqlstring  );

  }//end public function select */

  /**
   * send an insert Request to the Database
   *
   * @param mixed $sql
   * @param string $tableName
   * @param string $tablePk
   * @return int
   * @throws LibDb_Exception
   */
  public function insert($sql , $tableName = null, $tablePk = null)
  {

    ++$this->counter ;

    if (is_object($sql) || $tableName) {
      $sqlstring = $this->sqlBuilder->buildInsert($sql , $tableName);
    } elseif (is_string($sql)) {
      $sqlstring = $sql;
    } elseif (is_array($sql)  ) {
      $sqlstring = $this->sqlBuilder->buildInsert($sql , $tableName);
    } else {
        $args = func_get_args();
        Error::addError
        (
        I18n::s('wbf.log.dbIncopatibleParameters'),
        'LibDb_Exception',
        $args
        );
    }

    $this->lastQuery = $sqlstring;

    if (Log::$levelDebug)
      Log::debug('SQL: '.$sqlstring);

    $this->affectedRows = $this->connection->exec($sqlstring);

    if ($this->affectedRows === false) {
      $args = func_get_args();
      Error::addError
      (
      'Query Error: '.$this->extractPdoError(),
      'LibDb_Exception',
      $args
      );

    }

    $id = $this->connection->lastInsertId();

    return $id ;

  } // end  public function insert($sql , $tableName = null, $tablePk = null)

  /**
   * set the activ schema
   * we have stupid mysql, that knows no schema
   * @param string Schema Das aktive Schema
   * @return bool
   */
  public function setSearchPath($schema)
  {

    $this->schema = $schema;

    return true;
  } // end public function setSearchPath($schema)

  /**
   * execute a sql
   *
   * @param   string $sql Pure Sql Query
   * @throws  LibDb_Exception
   * @return int
   */
  public function exec($sql , $insertId = null , $table = null  )
  {

    $this->result = null;

    $this->affectedRows = $this->connection->exec($sql);

    if ($this->affectedRows === false) {
      Error::addError
      (
      'Query Failed: '.$this->extractPdoError(),
      'LibDb_Exception'
      );
    }

    if ($insertId) {
      return $this->connection->lastInsertId();
    } else {
      return $this->affectedRows;
    }

  } // end public function exec($sql  )

  /**
   * Ausführen einer Vorbereiteten Datenbankabfrage
   *
   * @param   string Name Name der Query in der Datenbank
   * @param   array Values Ein Array mit den Daten
   * @throws  LibDb_Exception
   */
  public function executeAction($name,  $values = null, $getNewId = null)
  {

    if (!isset($this->prepares[$name])) {
      Error::addError
      (
      I18n::s('wbf.error.foundNoPrepare',array($name)),
      'LibDb_Exception'
      );
    }

    $result = $this->prepares[$name];
    $result->clean();

    $pos = 1;

    foreach ($values as $value) {
      $result->bind_param($pos,$value);
      ++$pos;
    }

    $this->affectedRows = $result->execute($sqlstring);

    if ($this->affectedRows === false) {
      $args = func_get_args();
      Error::addError
      (
      'Query Error: '.$this->extractPdoError(),
      'LibDb_Exception',
      $args
      );

    }

    if ($getNewId) {
      return $this->connection->lastInsertId();
    } else {
      return $this->affectedRows;
    }

  } // end public function executeAction($name,  $values = null, $getNewId = false)

  /**
   * Erstellen einer Datenbankverbindung
   *
   * @return void
   */
  protected function connect()
  {

    try {
      $this->connection = new PDO
      (
        'mysql:host='.$this->conf['dbhost'].';dbname='.$this->conf['dbname'].';port='.$this->conf['dbport'],
        $this->conf['dbuser'],
        $this->conf['dbpwd']
      );
    } catch (PDOException $e) {

      Error::addError
      (
      'Konnte Die Datenbank Verbindung nicht herstellen :'.$e->getMessage() ,
      'LibDb_Exception' ,
      $this->conf
      );

      throw new LibDb_Exception($e->getMessage());
    }

    $this->databaseName = $this->conf['dbname'];

  } // end protected function connect()

  /**
   * Daten zum einfügen in eine Tabelle konvertieren
   *
   * @param string $table
   * @param array $daten
   * @return array
   */
  public function convertData($table , $daten)
  {

    if (!isset($this->quotesCache[$table])) {
      $quotesData = PATH_GW.'data/db_quotes_cache/mysql/'.$this->databaseName.'/'.$table.'.php';

      if (file_exists($quotesData)) {
        require_once $quotesData;
      } else {
        Error::addError
        (
        I18n::s('wbf.log.noDataForConvertTableData',array($table,$quotesData)),
        'LibDb_Exception'
        );
      }
    }

    $tmp = array();

    foreach ($daten as $key => $value) {
      if (isset($this->quotesCache[$table][$key])) {
        if ($this->quotesCache[$table][$key]) {
          if (trim($value) == '') {
            $tmp[$key] = 'null';
          } else {
            $tmp[$key] = "'".$value."'";
          }

        } else {
          if (trim($value) == '') {
            $tmp[$key] = 'null';
          } else {
            $tmp[$key] = $value;
          }
        }
      } else {
        Error::addError
        (
        I18n::s('wbf.log.noDataForConvertTableRow',array($table,$key)),
        'LibDb_Exception'
        );
      }
    }

    return $tmp;

  } // end protected function convertData($table , $daten)

  /**
   *
   * @param $table
   * @return unknown_type
   */
  protected function loadMetadata( $table)
  {
    $tmp = explode('_',$table);

    $quotesData = 'db/mysql/'.$table.'.php';

    $quotesDataPath = null;

    foreach (Conf::$confPath as $path) {
      if (file_exists($path.$quotesData)) {
        $quotesDataPath = $path.$quotesData;
        break;
      }
    }

    if ($quotesDataPath) {
      include $quotesDataPath;
    } else {

      $message = $quotesData.' ist nicht vorhanden';

      Error::addError
      (
      $message,
      //I18n::s('wbf.log.noDataForConvertTableData',array($table,$quotesData)),
      'LibDb_Exception'
      );
    }
  }//end protected function loadMetadata */

} //end class DbPdoMysql

