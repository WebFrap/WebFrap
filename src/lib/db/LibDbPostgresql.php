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
 * @author dominik alexander bonsch <dominik.bonsch@webfrap.net>
 */
class LibDbPostgresql extends LibDbConnection
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Der Standard Fetch Mode
   */
  protected $fetchMode = PGSQL_ASSOC;

  /**
   * Holen der Daten als Assoziativer Array
   */
  const fetchAssoc = PGSQL_ASSOC;

  /**
   * Holen der Daten als Numerischer Array
   */
  const fetchNum = PGSQL_NUM;

  /**
   * Holen der Daten als Doppelter Assoziativer und Numerischer Array
   */
  const fetchBoth = PGSQL_BOTH;

  /**
   * the type of the sql sqlBuilder for this database class
   *
   * @var string
   */
  protected $builderType = 'Postgresql';

  /**
   * @return string
   */
  public function __toString()
  {
    return 'Database Connection: ' .
      $this->databaseName.'.'.$this->schema.' Type: '.$this->getParserType();

  }//end public function __toString */

/*//////////////////////////////////////////////////////////////////////////////
// Special Queries
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $sql
   */
  public function roubstSelect($sql)
  {

    try {
      if (DEBUG) {
        $start = Webfrap::startMeasure();
      }

      $res = $this->select($sql);

      if (DEBUG) {
        $duration = Webfrap::getDuration($start);
        $this->queryTime += $duration;
        Debug::console('ROBUST SELECT SQL dur:'.$duration.' num:'.$this->counter.':  '.$sql  );
      }

      return $res;
    } catch (Exception $e) {
      return null;
    }

  }//end public function roubstSelect */

  /**
   * de:
   * eine einfach select abfrage an die datenbank
   * select wird immer auf der lesende connection ausgeführt
   *
   * @param string $sql ein SQL String
   * @return LibDbPostgresqlResult
   * @throws LibDb_Exception
   *  - bei inkompatiblen parametern
   */
  public function select($sql  )
  {

    ++$this->counter ;
    $duration = -1;

    if (!is_string($sql)) {
      // Fehlermeldung raus und gleich mal nen Trace laufen lassen
      throw new LibDb_Exception(
        'incompatible parameters'
      );
    }

    // Query protokolieren bei bedarf
    if ($this->protocol)
      $this->protocol->write($sql);

    if (Log::$levelDebug)
      Log::debug('SELECT SQL '.$this->counter.':  '.$sql  );

    if (DEBUG) {
      $start = Webfrap::startMeasure();
    }

    if (!is_resource($this->connectionRead)) {
      Debug::console('Lost Connection to the Database!!! Try to reconnect');
      $this->connect();
    }

    if (!$this->result = pg_query($this->connectionRead , $sql)) {

      // Fehlermeldung raus und gleich mal nen Trace laufen lassen
      throw new LibDb_Exception(
        'Read failed',
        'DB Response: '.pg_last_error($this->connectionRead),
        Response::INTERNAL_ERROR,
        $sql,
        $this->counter
      );
    }

    if (DEBUG) {
      $duration = Webfrap::getDuration($start);
      $this->queryTime += $duration;
      Debug::console('SELECT SQL num:'.$this->counter.' dur:'.$duration.' :  '.$sql, null,true  );
    }

    return new LibDbPostgresqlResult($this->result, $this, $sql, $this->counter, $duration);

  } // end public function select */

  /**
   * de:
   * ausführen einer insert query
   *
   * @param mixed $sql
   * @param string $tableName
   * @param string $tablePk
   * @return int
   * @throws LibDb_Exception im fehlerfall
   */
  public function insert($sql, $tableName, $tablePk)
  {

    ++$this->counter ;
    $duration = -1;

    if (!is_string($sql)) {
      throw new LibDb_Exception(
        'incompatible parameters'
      );
    }

    if (Log::$levelDebug)
      Log::debug('INSERT SQL: '.$sql);

    if (DEBUG) {
      $start = Webfrap::startMeasure();
    }

    if ($this->protocol)
      $this->protocol->write($sql);

    if (!is_resource($this->connectionWrite)) {
      Debug::console('Lost Connection to the Database!!! Try to reconnect');
      $this->connect();
    }

    if (!$this->result = pg_query($this->connectionWrite , $sql)) {
      throw new LibDb_Exception (
        'Insert failed',
        'DB Response: '.pg_last_error($this->connectionWrite),
        Response::INTERNAL_ERROR,
        $sql,
        $this->counter
      );
    }

    // das kann passieren, wenn eine insert if not exists query läuft
    // dann kann es dazu kommen, dass kein datensatz angelegt wird, also
    // wollen wir in dem kontext dann auch keine id zurückgeben
    if (!pg_affected_rows($this->result))
      return null;

    //$sqlstring = 'select currval(\''.strtolower($tableName).'_'.strtolower($tablePk).'_seq\')';
    $sqlstring = "select currval('".Db::SEQUENCE."');";

    if (!$this->result = pg_query($this->connectionWrite , $sqlstring)) {
      throw new LibDb_Exception (
        'Failed to receive a new id',
        'No Db Result: '.pg_last_error($this->connectionWrite),
        Response::INTERNAL_ERROR,
        $sqlstring,
        $this->counter
      );
    }

    if (!$row = pg_fetch_row($this->result)) {
      throw new LibDb_Exception (
        I18n::s('wbf.error.DBFailedToGetNewId')
      );
    }

    if (DEBUG) {
      $duration = Webfrap::getDuration($start);
      $this->queryTime += $duration;
      Debug::console('INSERT SQL dur:'.$duration.' num:'.$this->counter.':  '.$sql  );
    }

    return $row[0];

  } // end public function insert */

  /**
   * de:
   * ausführen einer insert query
   *
   * @param string $seqName
   * @return int
   * @throws LibDb_Exception im fehlerfall
   */
  public function nextVal($seqName  )
  {

    ++$this->counter ;

    $sqlstring = "select nextval('".$seqName."');";

    if (!$this->result = pg_query($this->connectionWrite, $sqlstring)) {
      throw new LibDb_Exception(
        'Failed to receive a new id',
        'No Db Result: '.pg_last_error($this->connectionWrite),
        Response::INTERNAL_ERROR,
        $sqlstring
      );
    }

    $row = pg_fetch_row($this->result);

    return $row[0];

  } // end public function nextVal */

  /**
   * de:
   * ausführen einer insert query
   *
   * @param string $seqName
   * @return int
   * @throws LibDb_Exception im fehlerfall
   */
  public function currVal($seqName  )
  {

    ++$this->counter ;

    $sqlstring = "select currval('".$seqName."');";

    if (!$this->result = pg_query($this->connectionRead, $sqlstring)) {
      throw new LibDb_Exception(
        'Failed to receive a new id',
        'No Db Result: '.pg_last_error($this->connectionRead),
        Response::INTERNAL_ERROR,
        $sqlstring
      );
    }

    $row = pg_fetch_row($this->result);

    return $row[0];

  } // end public function currVal */

  /**
   * Den aktuellen Wert einer Sequence auslesen
   *
   * @param string $seqName
   * @return int
   * @throws LibDb_Exception im fehlerfall
   */
  public function sequenceValue($seqName  )
  {

    ++$this->counter ;

    $sqlstring = "select last_value from {$seqName};";

    if (!$this->result = pg_query($this->connectionRead, $sqlstring)) {
      throw new LibDb_Exception
      (
        'Failed to receive a new id',
        'No Db Result: '.pg_last_error($this->connectionRead),
        Response::INTERNAL_ERROR,
        $sqlstring
      );
    }

    $row = pg_fetch_row($this->result);

    return $row[0];

  } // end public function sequenceValue */

  /**
   * de:
   * ausführen einer insert query
   *
   * @param string $seqName
   * @return int
   * @throws LibDb_Exception im fehlerfall
   */
  public function lastVal($seqName  )
  {

    ++$this->counter ;

    $sqlstring = "select lastval('".$seqName."');";

    if (!$this->result = pg_query($this->connectionRead, $sqlstring)) {
      throw new LibDb_Exception(
        'Failed to receive a new id',
        'No Db Result: '.pg_last_error($this->connectionRead),
        Response::INTERNAL_ERROR,
        $sqlstring
      );
    }

    $row = pg_fetch_row($this->result);

    return $row[0];

  } // end public function lastVal */

  /**
   * @param string $sql
   * @param string $tableName
   *
   * @throws LibDb_Exception
   * @return LibDbPostgresqlResult
   */
  public function create($sql , $tableName = null)
  {

    ++$this->counter ;

    /*
    if (is_object($sql) || $tableName) {
      $sqlstring = $this->sqlBuilder->buildInsert($sql , $tableName);
    } elseif (is_string($sql)) {
      $sqlstring = $sql;
    } elseif (is_array($sql)  ) {
      $sqlstring = $this->sqlBuilder->buildInsert($sql , $tableName);
    } else {
      throw new LibDb_Exception ('incompatible parameters');
    }
    */

    if (!is_string($sql)) {
      throw new LibDb_Exception(
        'incompatible parameters'
      );
    }

    $sqlstring = $sql;

    if (Log::$levelDebug)
      Log::debug('CREATE SQL: '.$sqlstring);

    if ($this->protocol)
      $this->protocol->write($sqlstring);

    if (!is_resource($this->connectionWrite)) {
      Debug::console('Lost Connection to the Database!!! Try to reconnect');
      $this->connect();
    }

    if (!$this->result = pg_query($this->connectionWrite , $sqlstring)) {
      throw new LibDb_Exception(
        'Create Failed',
        'DB Response: '.pg_last_error($this->connectionWrite),
        Response::INTERNAL_ERROR,
        $sqlstring
      );
    }

    if (DEBUG)
      Debug::console('CREATE: '.$sqlstring);

    return new LibDbPostgresqlResult($this->result , $this);

  } // end public function create */

  /**
   * Ein Updatestatement an die Datenbank schicken
   *
   * @param string $sql Ein Aktion Object
   * @throws LibDb_Exception
   * @return int
   */
  public function update($sql   )
  {

    ++$this->counter ;

    if (!is_string($sql)) {
      throw new LibDb_Exception('incompatible parameters');
    }

    if (Log::$levelDebug)
      Log::debug('UPDATE SQL '.$this->counter.':  '.$sql  );

    if (DEBUG)
      Debug::console('UPDATE SQL '.$this->counter.':  '.$sql);

    if ($this->protocol)
      $this->protocol->write($sql);

    if (!is_resource($this->connectionWrite)) {
      Log::warn('Lost Connection to the Database!!! Try to reconnect');
      Debug::console('Lost Connection to the Database!!! Try to reconnect');
      $this->connect();
    }

    if (!$this->result = pg_query($this->connectionWrite, $sql)) {
      // Fehlermeldung raus und gleich mal nen Trace laufen lassen
      throw new LibDb_Exception(
        'Update Failed',
        'DB Response: '.pg_last_error($this->connectionWrite),
        Response::INTERNAL_ERROR,
        $sql
      );
    }

    return new LibDbPostgresqlResult($this->result,$this);

  }// end public function update */

  /**
   * @todo add some error handling and a response
   */
  public function multiDelete(array $sqls)
  {
    foreach ($sqls as $sql)
      $this->delete($sql);
  }//end public function multiDelete */

  /**
   * Ein Deletestatement and die Datenbank schicken
   *
   * @param res Sql Ein Aktion Object
   * @throws LibDb_Exception
   * @return int Anzahl der gelöschten Datensätze
   */
  public function delete($sql)
  {

    ++$this->counter ;

    if (!is_string($sql)) {
      $args = func_get_args();

      throw new LibDb_Exception(
        'Datenbank delete() hat inkompatible Parameter bekommen'
      );
    }

    if (Log::$levelDebug)
      Log::debug('DELETE SQL '.$this->counter.':  '.$sql);

    if (DEBUG)
      Debug::console('DELETE SQL '.$this->counter.':  '.$sql);

    if ($this->protocol)
      $this->protocol->write($sql);

    if (!is_resource($this->connectionWrite)) {
      Debug::console('Lost Connection to the Database!!! Try to reconnect');
      $this->connect();
    }

    if (!$this->result = pg_query($this->connectionWrite , $sql)) {
      // Fehlermeldung raus und gleich mal nen Trace laufen lassen
      throw new LibDb_Exception(
        'Delete failed',
        'DB Response: '.pg_last_error($this->connectionWrite),
        Response::INTERNAL_ERROR,
        $sql
      );
    }

    return pg_affected_rows($this->result);

  } // end public function delete */

/*//////////////////////////////////////////////////////////////////////////////
// Prepare Crud Queries
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Senden einer Datenbankabfrage zum erstellen eines Ausführplans
   *
   * @param string Name Name der Abfrage
   * @param string Der Fertige SQL Code
   * @return void
   * @throws LibDb_Exception
   */
  public function prepareSelect($name,  $sqlstring)
  {

    ++$this->counter ;

    if (trim($name) == '' || trim($sqlstring) == '') {
      // Fehlermeldung raus und gleich mal nen Trace laufen lassen
      $args = func_get_args();
      Error::addError(
       'Wrong Parameters',
       'LibDb_Exception',
       $args
      );
    }

    if (Log::$levelDebug)
      Log::debug(__FILE__ , __LINE__ ,'PREPARE SELECT: '.$name.' SQL: '.$sqlstring);

    if (!$this->result = pg_prepare($this->connectionRead, $name,  $sqlstring)) {
      throw new LibDb_Exception
      (
      'Die Afrage hat kein Result geliefert: '.pg_last_error()
      );
    }

  } // end public function prepareSelect */

  /**
   * Ein Insert Statement an die Datenbank schicken
   *
   * @param res Sql Ein Aktion Object
   * @throws LibDb_Exception
   * @return int
   */
  public function prepareInsert($name,  $sqlstring  )
  {

    ++$this->counter ;

    if (trim($name) == '' || trim($sqlstring) == ''  ) {
      // Fehlermeldung raus und gleich mal nen Trace laufen lassen
      $args = func_get_args();
      throw new LibDb_Exception
      (
        'Datenbank prepareInsert() hat inkompatible Parameter bekommen'
      );
    }

    if (Log::$levelDebug)
      Log::debug(__FILE__ , __LINE__ ,'PREPARE INSERT: '.$name.' SQL: '.$sqlstring);

    if (!$this->result = pg_prepare($this->connectionWrite, $name,  $sqlstring)) {
      throw new LibDb_Exception
      (
        'Die Afrage hat kein Result geliefert: '.pg_last_error()
      );
    }

  } // end public function prepareInsert */

  /**
   * Ein Updatestatement an die Datenbank schicken
   *
   * @param string $name
   * @param string $sqlstring
   * @throws LibDb_Exception
   * @return int
   */
  public function prepareUpdate($name,  $sqlstring  )
  {

    ++$this->counter ;

    if (trim($name) == '' || trim($sqlstring) == ''  ) {
      // Fehlermeldung raus und gleich mal nen Trace laufen lassen
      $args = func_get_args();
      throw new LibDb_Exception
      (
        'Datenbank prepareUpdate hat inkompatible Parameter bekommen'
      );
    }

    if (Log::$levelDebug)
      Log::debug(__FILE__ , __LINE__ ,'Name: '.$name.' SQL: '.$sqlstring);

    if (!$this->result = pg_prepare($this->connectionWrite, $name,  $sqlstring)) {
      throw new LibDb_Exception
      (
        'Die Afrage hat kein Result geliefert: '.pg_last_error()
      );
    }

  } // end public function prepareUpdate */

  /**
   * Ein Deletestatement and die Datenbank schicken
   *
   * @param res Sql Ein Aktion Object
   * @return
   */
  public function prepareDelete($name,  $sqlstring  )
  {

    ++$this->counter ;

    if (trim($name) == '' || trim($sqlstring) == ''  ) {
      // Fehlermeldung raus und gleich mal nen Trace laufen lassen
      $args = func_get_args();
      throw new LibDb_Exception
      (
        'Datenbank prepareInsert() hat inkompatible Parameter bekommen'
      );
    }

    if (Log::$levelDebug)
      Log::debug(__FILE__ , __LINE__ ,'Name: '.$name.' SQL: '.$sqlstring);

    if (!$this->result = pg_prepare($this->connectionWrite, $name,  $sqlstring)) {
      throw new LibDb_Exception
      (
        'Die Afrage hat kein Result geliefert: '.pg_last_error()
      );
    }

  } // end public function prepareDelete */

/*//////////////////////////////////////////////////////////////////////////////
// Statement Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Löschen eines Ausführplans in der Datenbank
   *
   * @param string Name Name der Abfrage die gelöscht werden soll
   * @return void
   * @throws LibDb_Exception
   */
  public function deallocate($name)
  {

    if (!$this->result = pg_query($this->connectionWrite , 'DEALLOCATE '.$name  )) {
      throw new LibDb_Exception
      (
      'Konnte deallocate nicht ausführen'
      );
    }

  } // end public function deallocate */

  /**
   * Ausführen einer Vorbereiteten Datenbankabfrage
   *
   * @param   string Name Name der Query in der Datenbank
   * @param   array Values Ein Array mit den Daten
   * @throws  LibDb_Exception
   */
  public function executeQuery($name,  $values = null, $returnIt = true, $single = false)
  {

    if (is_object($name)) {
      $obj = $name;
      $name = $obj->getName();
      $values = $obj->getPrepareValues();
      $single = $obj->getSingelRow();
    }

    if (!$this->result = pg_execute($this->connectionRead, $name, $values)) {
      throw new LibDb_Exception
      (
      'Konnte Execute nicht ausführen: '.pg_last_error()
      );
    }

    if ($returnIt) {

      if (!$ergebnis = pg_fetch_all($this->result)) {
        if (Log::$levelDebug)
          Log::debug('Got no Result'  );

        return array();
      }

      if ($single) {
        if (Log::$levelDebug)
          Log::debug('Returned SingelRow'  );

        return $ergebnis[0];
      } else {
        if (Log::$levelDebug)
          Log::debug('Returned MultiRow'  );

        return $ergebnis;
      }
    } else {
      return true;
    }

  } // end public function executeQuery */

  /**
   * Ausführen einer Vorbereiteten Datenbankabfrage
   *
   * @param   string Name Name der Query in der Datenbank
   * @param   array Values Ein Array mit den Daten
   * @throws  LibDb_Exception
   */
  public function executeAction($name,  $values = null, $getNewId = false)
  {

    if (is_object($name)) {
      $obj = $name;
      $name = $obj->getName();
      $values = $obj->getPrepareValues();
    }

    if (!$this->result = pg_execute($this->connectionWrite, $name, $values)) {
      Error::addError
      (
      'Konnte Execute nicht ausführen: '.pg_last_error() ,
      'LibDb_Exception'
      );
    }

    if ($getNewId or $this->activObject->getNewid()) {
      $table = $this->activObject->getTable();
      if (!$this->result = pg_query
      (
      $this->connection ,
      $sqlstring = 'select currval(\''.strtolower($table).'_'.strtolower($getNewId).'_seq\')')
      )
      {

        Error::addError
        (
          'Konnte die neue Id nicht abfragen',
          'LibDb_Exception'
        );

      }

      if (! $row = pg_fetch_assoc($this->result)) {
        Error::addError
        (
          'Konnte die neue Id nicht lesen',
          'LibDb_Exception'
        );
      }

      return $row['currval'];
    } else {
      return pg_affected_rows($this->result);
    }

  } // end public function executeAction */

/*//////////////////////////////////////////////////////////////////////////////
// Simple Queries
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * a raw sql query
   *
   * @param   string $sql sql als string oder criteria
   * @param   boolean $returnit Should be returned?
   * @param   boolean $single Is a single Row Query
   * @throws  LibDb_Exception
   * @return array
   */
  public function query($sql)
  {

    if (Log::$levelDebug)
      Log::debug('QUERY SQL: '. $sql  );

    if ($this->protocol)
      $this->protocol->write($sql);

    if (!is_resource($this->connectionRead)) {
      Debug::console('Lost Connection to the Database!!! Try to reconnect');
      $this->connect();
    }

    if (!$this->result = pg_query($this->connectionRead , (string) $sql)) {
      throw new LibDb_Exception
      (
        'Query Failed: '.pg_last_error($this->connectionRead)
      );
    }

    $anz = pg_num_rows($this->result);

    if (Log::$levelDebug)
      Log::debug('Returned NumRows: '.$anz  );

    return $anz;

  } // end public function query */

  /**
   * Einfaches ausführen einer nicht select query
   * @param string $sql
   * @throws LibDb_Exception
   * @return boolean
   */
  public function exec($sql)
  {

    if (Log::$levelDebug)
      Log::debug('EXEC SQL: '. $sql  );

    if ($this->protocol)
      $this->protocol->write($sql);

    if (DEBUG)
      Debug::console('EXEC SQL' , (string) $sql);

    if (!is_resource($this->connectionWrite)) {
      Debug::console('Lost Connection to the Database!!! Try to reconnect');
      $this->connect();
    }

    if (!$this->result = pg_query($this->connectionWrite , (string)$sql)) {
      // false alarm?!
      if (!$error = pg_last_error($this->connectionWrite)) {
        throw new LibDb_Exception(
          'Query Failed, but Postgres returned no error! '.$sql
        );
      }

      throw new LibDb_Exception(
        'Query Failed: '.$error.' '.$sql
      );
    }

    return true;

  }// end public function exec */

  /**
   * execute a sql
   *
   * @param string $sql sql als string
   * @throws  LibDb_Exception
   * @return mixed
   */
  public function crud($sql , $insertId = null , $table = null)
  {

    if ($this->protocol)
      $this->protocol->write($sql);

    if (!$this->result = pg_query($this->connectionWrite , $sql)) {
      Error::addError
      (
        'Query Failed: '.pg_last_error($this->connectionWrite),
        'LibDb_Exception'
      );
    }

    if (!$insertId) {
      return pg_affected_rows($this->result);
    } else {

      if
      (!$this->result = pg_query
        (
          $this->connection ,
          'select currval(\''.strtolower($table).'_'.strtolower($insertId).'_seq\')'
        )
      )
      {

        Error::addError
        (
          I18n::s('failed to get the new id from the sequence'),
          'LibDb_Exception'
        );

      }

      if (!$row = pg_fetch_assoc($this->result)) {
        Error::addError
        (
          I18n::s('failed to get the new id from the sequence'),
          'LibDb_Exception'
        );
      }

      return $row['currval'];
    }

  } // end public function crud */

  /**
   * eine ddl query ausführen
   *
   * @param string $sql
   * @return null oder fehlermeldung
   */
  public function ddlQuery($sql)
  {

    if ($this->protocol)
      $this->protocol->write($sql);

    if (!is_resource($this->connectionWrite)) {
      Debug::console('Lost Connection to the Database!!! Try to reconnect');
      $this->connect();
    }

    if (!$this->result = pg_query($this->connectionWrite , $sql))
      return pg_last_error($this->connectionWrite);

    else
      return null;

  }//end public function ddlQuery */

  /**
   * Funktion zum einfachen durchleiten einer logquery in die Datenbank
   * @param string $sql
   */
  public function logQuery($sql)
  {
    pg_send_query($this->connectionWrite , $sql);
  } // end public function logQuery */

/*//////////////////////////////////////////////////////////////////////////////
// Getter for Query Metadata
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Meldungen des Datenbanksystems abfragen
   * @param boolean $write
   * @return string
   */
  public function getNotice($write = true)
  {

    if ($write)
      return pg_last_notice($this->connectionWrite);

    else
      return pg_last_notice($this->connectionRead);

  } // end public function getNotice */

  /**
   * Fehlermeldungen des Datenbanksystems abfragen
   * @param boolean $write
   * @return string
   */
  public function getError($write = true)
  {

    if ($write)
      return pg_last_error($this->connectionWrite);

    else
      return pg_last_error($this->connectionRead);

  } // end public function getError */

  /**
   * Die Affected Rows der letzen Query erfragen
   *
   * @return int
   */
  public function getAffectedRows()
  {
    return pg_affected_rows($this->result);
  } // end public function getAffectedRows */

/*//////////////////////////////////////////////////////////////////////////////
// Transactions
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Starten einer Transaktion
   * @param boolean $write
   * @return
   */
  public function begin($write = true)
  {

    Debug::console('DB Begin');
    
    if ($write) {
      if (! $this->result = pg_query($this->connectionWrite , 'BEGIN')) {
        Error::addError (
          'Fehler beim ausführen von Begin: '.pg_last_error($this->connectionWrite) ,
          'LibDb_Exception'
        );
      }
    } else {
      if (! $this->result = pg_query($this->connectionRead , 'BEGIN')) {
        Error::addError (
          'Fehler beim ausführen von Begin: '.pg_last_error($this->connectionRead) ,
          'LibDb_Exception'
        );
      }
    }

  } // end public function begin */

  /**
   * Transaktion wegen Fehler abbrechen
   *
   * @return
   */
  public function rollback($write = true)
  {

    Debug::console('DB Rollback');

    if ($write) {
      if (! $this->result = pg_query($this->connectionWrite , 'ROLLBACK')) {
        Error::addError(
          'Fehler beim ausführen von Rollback: '.pg_last_error($this->connectionWrite) ,
          'LibDb_Exception'
        );
      }
    } else {
      if (! $this->result = pg_query($this->connectionRead , 'ROLLBACK')) {
        Error::addError(
          'Fehler beim ausführen von Rollback: '.pg_last_error($this->connectionRead) ,
          'LibDb_Exception'
        );
      }
    }

  } // end public function rollback */

  /**
   * Transaktion erfolgreich Abschliesen
   *
   * @return
   */
  public function commit($write = true)
  {
    Debug::console('DB Commit');

    if ($write) {
      if (! $this->result = pg_query($this->connectionWrite , 'COMMIT')) {
        Error::addError(
          'Fehler beim ausführen von Commit: '.pg_last_error($this->connectionWrite) ,
          'LibDb_Exception'
        );
      }
    } else {
      if (! $this->result = pg_query($this->connectionRead , 'COMMIT')) {
        Error::addError(
          'Fehler beim ausführen von Commit: '.pg_last_error($this->connectionRead) ,
          'LibDb_Exception'
        );
      }
    }

  } // end public function commit */

/*//////////////////////////////////////////////////////////////////////////////
// Connection Status
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Setzten des Aktiven Schemas
   *
   * @param string Schema Das aktive Schema
   * @return bool
   */
  public function setSearchPath($schema)
  {

    //Falsche Daten übergeben
    if (!is_string($schema))
      throw new LibDb_Exception('got wrong db type');

    if (Log::$levelDebug)
      Log::debug("Set Search_path $schema ");

    if (DEBUG) {
      Debug::console("PG: set search_path $schema ");
    }

    $sqlstring = 'SET search_path = "'.$schema.'", pg_catalog;';

    /*
    if ($this->protocol)
      $this->protocol->write($sqlstring);
    */

    if ($this->clusterMode) {
      if (!$this->result = pg_query($this->connectionWrite , $sqlstring)) {
        // Fehlermeldung raus und gleich mal nen Trace laufen lassen
        Error::addError(
          'got an error from the database: '.pg_last_error ($this->connectionWrite),
          'LibDb_Exception'
        );

      }
    }

    if (!$this->result = pg_query($this->connectionRead , $sqlstring)) {

      Log::error('Failed to change schema');

      // Fehlermeldung raus und gleich mal nen Trace laufen lassen
      Error::addError(
        'got an error from the database: '.pg_last_error ($this->connectionRead),
        'LibDb_Exception'
      );

    }

    Log::debug('New schema is '.$schema);

    $this->schema = $schema;

    return true;
  } // end public function setSearchPath */

  /**
   * Den Status des Results Checken
   *
   * @return
   */
  public function checkStatus()
  {

    $status = pg_result_status($this->result , PGSQL_STATUS_LONG  );
    switch ($status) {
      case 'PGSQL_COMMAND_OK':{}
      case 'PGSQL_TUPLES_OK':{}
      case 'PGSQL_COPY_OUT':{}
      case 'PGSQL_COPY_IN':
      {
        return false;
        break;
      }// ENDE CASE

      case 'PGSQL_EMPTY_QUERY' :
      {
        return 'PG1' ;
        break;
      }// ENDE CASE
      case 'PGSQL_BAD_RESPONSE' :
      {
        return 'PG2' ;
        break;
      }// ENDE CASE
      case 'PGSQL_NONFATAL_ERROR' :
      {
        return 'PG3' ;
        break;
      }// ENDE CASE
      case 'PGSQL_FATAL_ERROR' :
      {
        return 'PG4' ;
        break;
      } // ENDE CASE

      default:
      {
        return 'PG5' ;
        break;
      } // ENDE DEFAULT
    } // ENDE SWITCH

  } // end public function checkStatus */

  /**
   * Erstellen einer Datenbankverbindung
   *
   * @param res Sql Ein Select Object
   * @return
   */
  protected function connect()
  {

    if (isset($this->conf['quote']) && $this->conf['quote'] == 'multi')
      $this->quoteMulti = true;

    $pgsql_con_string = 'host='.$this->conf['dbhost']
      .' port='.$this->conf['dbport']
      .' dbname='.$this->conf['dbname']
      .' user='.$this->conf['dbuser']
      .' password='.$this->conf['dbpwd'];

    $this->dbUrl = $this->conf['dbhost'];
    $this->dbPort = $this->conf['dbport'];
    $this->databaseName = $this->conf['dbname'];
    $this->dbUser = $this->conf['dbuser'];
    $this->dbPwd = $this->conf['dbpwd'];

    if (Log::$levelConfig)
      Log::config('DbVerbindungsparameter: '. $pgsql_con_string);

    if (DEBUG) {
      $pgsql_con_debug = 'host='.$this->conf['dbhost']
        .' port='.$this->conf['dbport']
        .' dbname='.$this->conf['dbname']
        .' user='.$this->conf['dbuser']
        .' password=******************';

      Debug::console('PG: Constring '.$pgsql_con_debug);
    }

    if (!$this->connectionRead = pg_connect($pgsql_con_string)) {

      Error::addError(
        'Konnte Die Datenbank Verbindung nicht herstellen :'.pg_last_error(),
        'LibDb_Exception' ,
        $pgsql_con_string
      );

    }

    $this->connectionWrite = $this->connectionRead;

    if ($this->schema) {
      $this->setSearchPath($this->schema);
    } elseif (isset($this->conf['dbschema'])) {
      $this->schema = $this->conf['dbschema'];
      $this->setSearchPath($this->conf['dbschema']);
    }

  }//end function connect */

  /**
   * Schliesen der Datenbankverbindung
   *
   * @param res Sql Ein Select Object
   * @return
   */
  protected function dissconnect()
  {
    if (is_resource($this->connectionRead))
      pg_close($this->connectionRead);

    if (is_resource($this->connectionWrite))
      pg_close($this->connectionWrite);

  } // end protected function dissconnect */

  /**
   * @return LibDbAdminPostgresql
   */
  public function getManager()
  {
    return new LibDbAdminPostgresql($this);

  }//end public function getManager */

  /**
   * @param string $schema
   */
  public function reconnect($schema = null)
  {
    $this->dissconnect();

    if (isset($this->conf['quote']) && $this->conf['quote'] == 'multi')
      $this->quoteMulti = true;

    $pgsql_con_string = 'host='.$this->conf['dbhost']
      .' port='.$this->conf['dbport']
      .' dbname='.$this->conf['dbname']
      .' user='.$this->conf['dbuser']
      .' password='.$this->conf['dbpwd'];

    $this->databaseName = $this->conf['dbname'];

    if (Log::$levelConfig)
      Log::config('Db Verbindungsparameter: '. $pgsql_con_string);

    if (DEBUG) {
      $pgsql_con_debug = 'host='.$this->conf['dbhost']
        .' port='.$this->conf['dbport']
        .' dbname='.$this->conf['dbname']
        .' user='.$this->conf['dbuser']
        .' password=******************';

      Debug::console('PG: Constring '.$pgsql_con_debug);
    }

    if (!$this->connectionRead = pg_connect($pgsql_con_string)) {

      Error::addError(
        'Konnte Die Datenbank Verbindung nicht herstellen :'.pg_last_error(),
        'LibDb_Exception' ,
        $pgsql_con_string
      );

    }

    $this->connectionWrite = $this->connectionRead;

    if ($schema) {
      $this->setSearchPath($schema);
    } elseif ($this->schema) {
      $this->setSearchPath($this->schema);
    } elseif (isset($this->conf['dbschema'])) {
      $this->schema = $this->conf['dbschema'];
      $this->setSearchPath($this->conf['dbschema']);
    }

  }

  /**
   *
   * @param string $schema
   */
  public function switchSchema($schema = null)
  {
    if ($schema) {
      $this->setSearchPath($schema);
    } elseif ($this->schema) {
      $this->setSearchPath($this->schema);
    } else {
      $this->setSearchPath('public');
    }

  }//end public function switchSchema */

  /**
   * Erstellen einer Datenbankverbindung
   *
   * @param res Sql Ein Select Object
   * @return string
   * @deprecated use escape
   */
  public function addSlashes($value)
  {

    if (get_magic_quotes_gpc()) {
      $this->firstStripThenAddSlashes($value);
    } else {
      if (is_array($value)) {
        $tmp = array();

        foreach ($value as $key => $data)
          $tmp[$key] = $this->addSlashes($data);

        $value = $tmp;
      } else {
        $value = pg_escape_string($this->connectionWrite,  $value);
      }
    }

    return $value;

  } // end public function addSlashes */

  /**
   * Erstellen einer Datenbankverbindung
   *
   * @param res Sql Ein Select Object
   * @return
   */
  public function escape($value)
  {

    if (get_magic_quotes_gpc()) {
      $this->firstStripThenAddSlashes($value);
    } else {
      if (is_array($value)) {
        $tmp = array();

        foreach ($value as $key => $data)
          $tmp[$key] = $this->addSlashes($data);

        $value = $tmp;
      } else {
        $value = pg_escape_string($this->connectionWrite,  $value);
      }
    }

    return $value;

  } // end public function escape */

  /**
   * Erstellen einer Datenbankverbindung
   *
   * @param res Sql Ein Select Object
   * @return
   */
  protected function firstStripThenAddSlashes($value)
  {

    if (is_array($value)) {

      $tmp = array();

      foreach ($value as $key => $data)
        $tmp[$key] = $this->firstStripThenAddSlashes($data);

      $value = $tmp;

    } else {

      $value = pg_escape_string($this->connectionWrite, stripslashes($value));
    }

    return $value;

  } // end protected function firstStripThenAddSlashes */

} //end class LibDbPostgresql

