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
class LibDbMysqli extends LibDbConnection
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/


  /**
   * Der Standard Fetch Mode
   */
  protected $fetchMode   = MYSQLI_ASSOC;

  /**
   * Holen der Daten als Assoziativer Array
   */
  const fetchAssoc  = MYSQLI_ASSOC;

  /**
   * Holen der Daten als Numerischer Array
   */
  const fetchNum    = MYSQLI_NUM;

  /**
   * Holen der Daten als Doppelter Assoziativer und Numerischer Array
   */
  const fetchBoth   = MYSQLI_BOTH;

  /**
   * Database Connection Object
   * @var Mysqli
   */
  protected $connection        = null;

  /**
   * the type of the sql  for this database class
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
  public function select($sql , $returnit = true , $singleRow = false )
  {
    if (Log::$levelDebug)
      Log::start(__file__,__line__,__method__,array($sql, $returnit, $singleRow));

    ++$this->counter ;

    if ( is_object($sql) )
    {
      $this->activObject = $sql;

      $singleRow = $sql->getSingelRow();

      if (  !$sqlstring = $this->activObject->getSql() )
      {
        if (!$sqlstring = $this->activObject->buildSelect() )
        {
          // Fehlermeldung raus und gleich mal nen Trace laufen lassen
          throw new LibDb_Exception( I18n::s( 'Failed to build the SQL', 'wbf.message' ) );
        }
      }
    }
    elseif ( is_string($sql) )
    {
      $sqlstring = $sql;
      $this->activObject = null;
    } else {
      // Fehlermeldung raus und gleich mal nen Trace laufen lassen
      $args = func_get_args();
      throw new LibDb_Exception(I18n::s('wbf.log.dbIncopatibleParameters'));
    }

    if (Log::$levelDebug)
      Log::debug( __file__ , __line__ , 'Select Query: '. $sqlstring );

    // close result
    if (!is_null($this->result) )
    {
      //$this->result->close();
    }

    $this->result = $this->connection->query($sqlstring );

    if ($this->result === false  )
    {
      // Fehlermeldung raus und gleich mal nen Trace laufen lassen
      throw new LibDb_Exception
      (
      I18n::s('wbf.log.dbNoResult',array($this->connection->error))
      );
    }

    $this->lastQuery = $sqlstring;

    if ($returnit )
    {

      $data = array();

      while($row = $this->result->fetch_array($this->fetchMode ) )
      {
        $data[] = $row;
      }


      if ($singleRow )
      {
        if (Log::$levelDebug)
          Log::debug( __file__ , __line__ , 'Returned SingelRow'  );

        if ( isset($data[0] ) )
        {
          if (Log::$levelTrace)
            Debug::logDump('Single Row Query: '.$sqlstring , $data[0] );

          return $data[0];
        }
        else
        {
          return array();
        }
      } else {
        if (Log::$levelDebug)
          Log::debug( __file__ , __line__ , 'Returned MultiRow'  );

        if (Log::$levelTrace)
          Debug::logDump('Multi Row Query: '.$sqlstring , $data );

        return $data;
      }
    } else {
      $anz = $this->result->num_rows;

      if (Log::$levelDebug)
        Log::debug( __file__ , __line__ , 'Returned NumRows: '.$anz  );

      return $anz;
    }

  } // end public function select($sql , $returnit = true , $singleRow = false )

  /**
   * send an insert Request to the Database
   *
   * @param mixed $sql
   * @param string $tableName
   * @param string $tablePk
   * @return int
   * @throws LibDb_Exception
   */
  public function insert($sql , $tableName = null, $tablePk = null )
  {
    if (Log::$levelDebug)
      Log::start(__file__,__line__,__method__,array($sql , $tableName , $tablePk));

    ++$this->counter ;


    if ( is_object($sql ) )
    {

      $this->activObject = $sql;

      if (!$sqlstring = $this->activObject->getSql() )
      {
        if (!$sqlstring = $this->buildInsert() )
        {
          $args = func_get_args();
          throw new LibDb_Exception
          (
          I18n::s('wbf.log.dbFailedToParseSql'),
          'LibDb_Exception',
          $args
          );
        }
      }

    }
    elseif ( is_string($sql) and STestSql::isInsertQuery($sql) )
    {
      $sqlstring = $sql;
    } else {
        $args = func_get_args();
        throw new LibDb_Exception
        (
        I18n::s('wbf.log.dbIncopatibleParameters')
        );
    }

    $this->lastQuery = $sqlstring;

    if (Log::$levelDebug)
      Log::debug(__file__ , __line__ ,'SQL: '.$sqlstring );

    if (! $this->connection->query($sqlstring) )
    {
      throw new LibDb_Exception
      (
        I18n::s('wbf.log.dbNoResult',array($this->connection->error ))
      );
    }

    if ($errmessage = $this->connection->error )
    {

      throw new LibDb_Exception
      (
        I18n::s('wbf.log.dbGotError',array($errmessage))
      );

    }

    $id = $this->connection->insert_id;

    if (Log::$levelDebug)
      Log::debug(__file__,__line__,'GOT ID : '.$id );

    return $id ;

  } // end  public function insert($sql , $tableName = null, $tablePk = null )

  /**
   * Ein Updatestatement an die Datenbank schicken
   *
   * @param String $sql Ein Aktion Object
   * @return boolean
   * @throws LibDb_Exception
   */
  public function update($sql  )
  {
    if (Log::$levelDebug)
      Log::start(__file__,__line__,__method__,array($sql));

    ++$this->counter ;

    if ( is_object($sql ) )
    {

      $this->activObject = $sql;

      if (!$sqlstring = $this->activObject->getSql() )
      {
        if (!$sqlstring = $this->buildUpdate() )
        {
          $args = func_get_args();
          throw new LibDb_Exception
          (
          __file__ , __file__,
          I18n::s('wbf.log.dbFailedToParseSql'),
          'LibDb_Exception',
          $args
          );
        }
      }
    }
    elseif ( is_string($sql) and STestSql::isUpdateQuery($sql) )
    {
      $sqlstring = $sql;
    } else {
      throw new LibDb_Exception( I18n::s('wbf.log.dbIncopatibleParameters') );
    }

    if (Log::$levelDebug)
      Log::debug( __file__ , __line__ , 'SQL:  '.$sqlstring  );

    $this->lastQuery = $sqlstring;

    if (! $this->connection->query($sqlstring ) )
    {

      // Fehlermeldung raus und gleich mal nen Trace laufen lassen
      throw new LibDb_Exception( I18n::s('wbf.log.dbNoResult',array($this->connection->error )) );

    }

    if ($errmessage = $this->connection->error )
    {
      // Fehlermeldung raus und gleich mal nen Trace laufen lassen
      throw new LibDb_Exception( I18n::s('wbf.log.dbGotError',array($errmessage)) );
    }

  } // end public function update($sql  )

  /**
   * Ein Deletestatement and die Datenbank schicken
   *
   * @param mixed $sql
   * @return boolean
   * @throws LibDb_Exception
   */
  public function delete($sql )
  {

    ++$this->counter ;

    if ( is_object($sql ) )
    {

      $this->activObject = $sql;

      if (!$sqlstring = $this->activObject->getSql() )
      {
        if (!$sqlstring = $this->buildDelete() )
        {
          throw new LibDb_Exception
          (
            I18n::s('wbf.log.dbFailedToParseSql')
          );
        }
      }
    }
    elseif ( is_string($sql) and $this->isDeleteQuery($sql) )
    {
      $sqlstring = $sql;
    } else {
      throw new LibDb_Exception
      (
        I18n::s('wbf.log.dbIncopatibleParameters')
      );
    }

    $this->lastQuery = $sqlstring;

    if (!$this->connection->query($sqlstring ) )
    {
      // Fehlermeldung raus und gleich mal nen Trace laufen lassen
      throw new LibDb_Exception
      (
        I18n::s('wbf.log.dbNoResult',array($this->connection->error ))
      );
    }

    if ($errmessage = $this->connection->error  )
    {
      // Fehlermeldung raus und gleich mal nen Trace laufen lassen
      throw new LibDb_Exception
      (
        I18n::s('wbf.log.dbGotError',array($errmessage))
      );
    }

    return true;

  } // end public function delete($sql )

  /**
   * set the activ schema
   * we have stupid mysql, that knows no schema
   * @param string Schema Das aktive Schema
   * @return bool
   */
  public function setSearchPath($schema )
  {
    if (Log::$levelDebug)
      Log::start(__file__,__line__,__method__,array($schema));

    $this->schema = $schema;

    return true;
  } // end public function setSearchPath($schema )

  /**
   * Senden einer Datenbankabfrage zum erstellen eines Ausführplans
   *
   * @param string Name Name der Abfrage
   * @param string Der Fertige SQL Code
   * @return void
   * @throws LibDb_Exception
   */
  public function prepareSelect($name,  $sqlstring = null )
  {
    if (Log::$levelDebug)
      Log::start(__file__,__line__,__method__,array($name,  $sqlstring));

    ++$this->counter ;

    if ( is_object($name) )
    {
      $this->activObject = $name;

      if (  !$sqlstring = $this->activObject->getSql() )
      {
        if (!$sqlstring = $this->activObject->buildSelect() )
        {
          // Fehlermeldung raus und gleich mal nen Trace laufen lassen
          //$args = func_get_args();
          throw new LibDb_Exception(I18n::s('wbf.log.dbFailedToParseSql'));
        }
      }
      $name = $this->activObject->getName();

    }
    elseif (trim($name) == '' or trim($sqlstring) == '' )
    {
       // Fehlermeldung raus und gleich mal nen Trace laufen lassen
       //$args = func_get_args();
       throw new LibDb_Exception(I18n::s('wbf.log.dbIncopatibleParameters'));
    }


    if (Log::$levelDebug)
      Log::debug(__file__ , __line__ ,'Name: '.$name.' SQL: '.$sqlstring );

    if (!$this->result = $this->connection->prepare($sqlstring ) )
    {
      throw new LibDb_Exception
      (
        I18n::s('wbf.log.dbNoResult',array($this->connection->error ))
      );
    }

    $this->prepares[$name] = $this->result;


  } // end public function prepareSelect($name,  $sqlstring = null )

  /**
   * Ein Insert Statement an die Datenbank schicken
   *
   * @param res Sql Ein Aktion Object
   * @return int
   */
  public function prepareInsert($name,  $sqlstring = null )
  {


    ++$this->counter ;

    if ( is_object($name) )
    {
      $this->activObject = $name;

      if (  !$sqlstring = $this->activObject->getSql() )
      {
        if (!$sqlstring = $this->activObject->buildInsert( true ) )
        {
          // Fehlermeldung raus und gleich mal nen Trace laufen lassen
          $args = func_get_args();
          throw new LibDb_Exception
          (
          I18n::s('wbf.log.dbFailedToParseSql')
          );
        }
      }
      $name = $this->activObject->getName();

    }
    elseif (trim($name) == '' or trim($sqlstring) == '' )
    {
       // Fehlermeldung raus und gleich mal nen Trace laufen lassen
       $args = func_get_args();
       throw new LibDb_Exception
       (
       I18n::s('wbf.log.dbIncopatibleParameters')
       );
    }


    if (Log::$levelDebug)
      Log::debug(__file__ , __line__ ,'Name: '.$name.' SQL: '.$sqlstring );

    if (!$this->result = $this->connection->prepare($sqlstring ) )
    {
      throw new LibDb_Exception
      (
      I18n::s('wbf.log.dbNoResult',array($this->connection->error ))
      );
    }

    $this->prepares[$name] = $this->result;

  } // end public function prepareInsert($name,  $sqlstring = null )

  /**
   * Ein Updatestatement an die Datenbank schicken
   *
   * @param res Sql Ein Aktion Object
   * @param boolean Send
   * @return int
   */
  public function prepareUpdate($name,  $sqlstring = null )
  {

    ++$this->counter ;

    if ( is_object($name) )
    {
      $this->activObject = $name;

      if (  !$sqlstring = $this->activObject->getSql() )
      {
        if (!$sqlstring =$this->activObject->buildUpdate( true ) )
        {
          // Fehlermeldung raus und gleich mal nen Trace laufen lassen
          throw new LibDb_Exception
          (
            I18n::s('wbf.log.dbFailedToParseSql')
          );
        }
      }
      $name = $this->activObject->getName();

    }
    elseif (trim($name) == '' or trim($sqlstring) == '' )
    {
       // Fehlermeldung raus und gleich mal nen Trace laufen lassen
       $args = func_get_args();
       throw new LibDb_Exception
       (
         I18n::s('wbf.log.dbIncopatibleParameters')
       );
    }


    if (Log::$levelDebug)
      Log::debug(__file__ , __line__ ,'Name: '.$name.' SQL: '.$sqlstring );

    if (!$this->result = $this->connection->prepare($sqlstring ) )
    {
      throw new LibDb_Exception
      (
        I18n::s('wbf.log.dbNoResult',array($this->connection->error ))
      );
    }

    $this->prepares[$name] = $this->result;

  } // end public function prepareUpdate($name,  $sqlstring = null )

  /**
   * Ein Deletestatement and die Datenbank schicken
   *
   * @param res Sql Ein Aktion Object
   * @return
   */
  public function prepareDelete($name,  $sqlstring = null  )
  {
    if (Log::$levelDebug)
      Log::start(__file__,__line__,__method__,array($name,  $sqlstring));

    ++$this->counter ;

    if ( is_object($name) )
    {
      $this->activObject = $name;

      if (  !$sqlstring = $this->activObject->getSql() )
      {
        if (!$sqlstring = $this->activObject->buildDelete( ) )
        {
          // Fehlermeldung raus und gleich mal nen Trace laufen lassen
          throw new LibDb_Exception
          (
            I18n::s('wbf.log.dbFailedToParseSql')
          );
        }
      }
      $name = $this->activObject->getName();

    }
    elseif (trim($name) == '' or trim($sqlstring) == '' )
    {
      // Fehlermeldung raus und gleich mal nen Trace laufen lassen

      throw new LibDb_Exception
      (
        I18n::s('wbf.log.dbIncopatibleParameters')
      );
    }

    if (Log::$levelDebug)
      Log::debug(__file__ , __line__ ,'Name: '.$name.' SQL: '.$sqlstring );

    if (!$this->result = $this->connection->prepare($sqlstring ) )
    {
      throw new LibDb_Exception
      (
        I18n::s('wbf.log.dbNoResult',array($this->connection->error ))
      );
    }

    $this->prepares[$name] = $this->result;

  } // end of member function delete

  /**
   * Löschen eines Ausführplans in der Datenbank
   *
   * @param string Name Name der Abfrage die gelöscht werden soll
   * @return void
   * @throws LibDb_Exception
   */
  public function deallocate($name )
  {


    if ( isset($this->prepares[$name] ) )
    {
      unset($this->prepares[$name]);
    }

  } // end public function deallocate($name )

  /**
   * Ausführen einer Vorbereiteten Datenbankabfrage
   *
   * @param   string Name Name der Query in der Datenbank
   * @param   array Values Ein Array mit den Daten
   * @throws  LibDb_Exception
   */
  public function executeQuery($name,  $values = null, $returnIt = true, $single = false )
  {


  } // end public function executeQuery($name,  $values = null, $returnIt = true, $single = false )

  /**
   * Ausführen einer Vorbereiteten Datenbankabfrage
   *
   * @param   string Name Name der Query in der Datenbank
   * @param   array Values Ein Array mit den Daten
   * @throws  LibDb_Exception
   */
  public function executeAction($name,  $values = null, $getNewId = false )
  {


  } // end public function executeAction($name,  $values = null, $getNewId = false )

  /**
   * a raw sql query
   *
   * @param   string $sql Pure Sql Query
   * @param   boolean $returnit Should be returned?
   * @param   boolean $single Is a single Row Query
   * @throws  LibDb_Exception
   * @return array
   */
  public function query($sql, $returnit = true, $single = false )
  {


    if (!$this->result = $this->connection->query($sql ) )
    {
      throw new LibDb_Exception
      (
        'Query Failed: '. $this->connection->error
      );
    }

    if ($returnit )
    {

      $data = array();

      while($row = $this->result->fetch_array($this->fetchMode ) )
      {
        $data[] = $row;
      }


      if ($single )
      {
        if (Log::$levelDebug)
          Log::debug( __file__ , __line__ , 'Returned SingelRow'  );

        if (Log::$levelTrace)
          Debug::logDump('Single Row Query: '.$sql , $data[0] );

        return $data[0];
      } else {
        if (Log::$levelDebug)
          Log::debug( __file__ , __line__ , 'Returned MultiRow'  );

        if (Log::$levelTrace)
          Debug::logDump('Multi Row Query: '.$sql , $data );

        return $data;
      }
    } else {
      $anz = $this->result->num_rows;

      if (Log::$levelDebug)
        Log::debug( __file__ , __line__ , 'Returned NumRows: '.$anz  );

      return $anz;
    }

  } // end public function query($sql, $returnit = true, $single = false )

  /**
   * execute a sql
   *
   * @param   string $sql Pure Sql Query
   * @throws  LibDb_Exception
   * @return mixed
   */
  public function exec($sql , $insertId = null , $table = null )
  {
    if (Log::$levelDebug)
      Log::start(__file__,__line__,__method__,array($sql));

    if (!$this->result = $this->connection->query($sql ) )
    {
      throw new LibDb_Exception
      (
        'Query Failed: '.$this->connection->error
      );
    }

    return $this->connection->affected_rows;

  } // end public function exec($sql  )

  /**
   * Enter description here...
   *
   * @param unknown_type $sql
   * @return unknown
   */
  public function ddlQuery($sql )
  {
    if (!$this->result = $this->connection->query($sql ) )
    {
      return $this->connection->error;
    } else {
      return false;
    }
  }//end public function ddlQuery($sql )

  /**
   * Auslesen des letzten Abfrageergebnisses
   *
   * @param int $Mode
   * @return array
   */
  public function getAll($mode = null )
  {


    $data = array();

    if (is_null($mode ) )
    {
      $mode = $this->fetchMode;
    }

    while($row = $this->result->fetch_array($mode) )
    {
      $data[] = $row;
    }

    return $data;

  } // end public function getAll($mode = null )

  /**
   * Das Nächste Result Abfragen
   *
   * @return array

   */
  public function getRow($mode = null )
  {


    if (is_null($mode ) )
    {
      $mode = $this->fetchMode;
    }

    return $this->result->fetch_array($mode);

  } // end public function getRow($mode = null )

  /**
   * Das Result der letzten Afrage leeren
   *
   * @return

   */
  public function clearResult( )
  {


    $this->result->clean();

  } // end public function clearResult( )

  /**
   * Die Numrows der Letzten Aktion abfragen
   *
   * @return int

   */
  public function getNumRows( )
  {


    return $this->connection->num_rows;

  } // end public function getNumRows( )

  /**
   * Die Affected Rows der letzen Query erfragen
   *
   * @return int
   */
  public function getAffectedRows( )
  {


    return $this->connection->affected_rows;
  } // end public function getAffectedRows( )

  /**
   * Meldungen des Datenbanksystems abfragen
   *
   * @return string
   */
  public function getNotice( )
  {

    return $this->connection->info;

  } // end public function getNotice( )

  /**
   * Fehlermeldungen des Datenbanksystems abfragen
   *
   * @return string
   */
  public function getError( )
  {


    return $this->connection->error;
  } // end public function getError( )

  /**
   * Starten einer Transaktion
   *
   * @return void
   */
  public function begin($write = true  )
  {


    $this->connection->autocommit( false  );

  } // end public function begin( )

  /**
   * Transaktion wegen Fehler abbrechen
   *
   * @return void
   */
  public function rollback($write = true  )
  {


    $this->connection->rollback();
    $this->connection->autocommit( true  );

  } // end public function rollback( )

  /**
   * Transaktion erfolgreich Abschliesen
   *
   * @return void
   */
  public function commit($write = true  )
  {


    $this->connection->commit();
    $this->connection->autocommit( true  );

  } // end public function commit( )

  /**
   * send a query to the database
   *
   * @return
   */
  public function logQuery($sql )
  {
    $this->connection->send_query($sql );
  } // end public function logQuery($sql )

  /**
   * Den Status des Results Checken
   *
   * @return
   */
  public function checkStatus( )
  {

    return true;

  } // end public function checkStatus( )

  /**
   * Erstellen einer Datenbankverbindung
   *
   * @param res Sql Ein Select Object
   * @return
   */
  protected function connect()
  {


    $this->connection = new mysqli
    (
      $this->conf['dbhost'],
      $this->conf['dbuser'],
      $this->conf['dbpwd'],
      $this->conf['dbname'],
      $this->conf['dbport']
    );

    $this->databaseName = $this->conf['dbname'];

    /* check connection */
    if (mysqli_connect_errno() )
    {
      throw new LibDb_Exception
      (
        'Konnte Die Datenbank Verbindung nicht herstellen :'.mysqli_connect_error()
      );
    }

  } // end protected function connect()

  /**
   * Schliesen der Datenbankverbindung
   *
   * @param res Sql Ein Select Object
   * @return void
   */
  protected function dissconnect()
  {

    if ($this->connection )
    {
      $this->connection->close();
      $this->connection = null;
    }

  } // end protected function dissconnect()

  /**
   * Daten zum einfügen in eine Tabelle konvertieren
   *
   * @param string $table
   * @param array $daten
   * @return array
   */
  public function convertData($table , $daten )
  {

    if (Log::$levelDebug)
      Debug::logDump('convertData $daten',$daten);

    if (!isset($this->quotesCache[$table]) )
    {
      $quotesData = PATH_GW.'data/db_quotes_cache/mysql/'.$this->databaseName.'/'.$table.'.php';

      if ( file_exists($quotesData ) )
      {
        require_once $quotesData;
      } else {
        throw new LibDb_Exception
        (
          I18n::s('wbf.log.noDataForConvertTableData',array($table,$quotesData))
        );
      }
    }

    $tmp = array();

    foreach($daten as $key => $value )
    {
      if ( isset($this->quotesCache[$table][$key]) )
      {
        if ($this->quotesCache[$table][$key])
        {
          if (trim($value) == '')
          {
            $tmp[$key] = 'null';
          }
          else
          {
            $tmp[$key] = "'".$value."'";
          }

        }
        else
        {
          if (trim($value) == '')
          {
            $tmp[$key] = 'null';
          }
          else
          {
            $tmp[$key] = $value;
          }
        }
      } else {
        throw new LibDb_Exception
        (
          I18n::s('wbf.log.noDataForConvertTableRow',array($table,$key))
        );
      }
    }

    return $tmp;

  } // end protected function convertData($table , $daten )

  /**
   * Erstellen einer Datenbankverbindung
   *
   * @param res Sql Ein Select Object
   * @return
   */
  public function addSlashes($value )
  {

    if ( get_magic_quotes_gpc() )
    {
      $this->firstStripThenAddSlashes($value );
    } else {
      if (is_array($value))
      {
        $tmp = array();
        foreach($value as $key => $data )
        {
          $tmp[$key] = $this->addSlashes($data );
        }
        $value = $tmp;
      }else
      {
        $value = $this->connection->real_escape_string($value);
      }
    }

    return $value;

  } // end public function addSlashes($value )

  /**
   * Erstellen einer Datenbankverbindung
   *
   * @param res Sql Ein Select Object
   * @return
   */
  protected function firstStripThenAddSlashes($value )
  {


    if (is_array($value))
    {
      $tmp = array();
      foreach($value as $key => $data )
      {
        $tmp[$key] = $this->firstStripThenAddSlashes($data );
      }
      $value = $tmp;
    }else
    {

      $value = $this->connection->real_escape_string(stripslashes($value));
    }

    return $value;

  } // end protected function firstStripThenAddSlashes($value )

  /**
   * Enter description here...
   *
   * @param string $table the name of the table
   * @param array  $fields the fieldnames for the quotes
   */
  public function getQuotesData($table , $fields = array() )
  {


    if (!isset($this->quotesCache[$table]) )
    {
      $quotesData = PATH_GW.'data/db_quotes_cache/mysql/'.$this->databaseName.'/'.$table.'.php';

      if ( file_exists($quotesData ) )
      {
        require_once $quotesData;
      } else {
        throw new LibDb_Exception
        (
          I18n::s('wbf.log.noDataForConvertTableData',array($table,$quotesData))
        );
      }
    }

    if (!$fields)
    {
      return $this->quotesCache[$table];
    }

    $tmp = array();

    foreach($fields as $key => $value )
    {
      if ( isset($this->quotesCache[$table][$key]) )
      {
        $tmp[$key] = $this->quotesCache[$table][$key];
      } else {
        throw new LibDb_Exception
        (
          I18n::s('wbf.log.noDataForConvertTableRow',array($table,$key))
        );
      }
    }

    return $tmp;


  }
/* (non-PHPdoc)
   * @see LibDbConnection::crud()
   */
  public function crud($sql, $insertId = null, $table = null) {
    // TODO Auto-generated method stub
    
  }
//end public function getQuotesData($table , $fields = array() )

} //end class DbMysqli

