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
class LibDbDummy
  extends LibDbConnection
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * Der Standard Fetch Mode
   */
  protected $fetchMode  = 0;

  /**
   * Holen der Daten als Assoziativer Array
   */
  const fetchAssoc  = 1;

  /**
   * Holen der Daten als Numerischer Array
   */
  const fetchNum    = 2;

  /**
   * Holen der Daten als Doppelter Assoziativer und Numerischer Array
   */
  const fetchBoth   = 3;

  /**
   * the type of the sql  for this database class
   *
   * @var string
   */
  protected $builderType = 'Dummy';

////////////////////////////////////////////////////////////////////////////////
// Application Logic
////////////////////////////////////////////////////////////////////////////////

  /**
   * Wiederherstellen der Verbindung nach dem Serialisieren
   *
   * @return
   */
  public function wakeup( )
  {

  } // end public function wakeup( )

  /**
   * Eine Selectquery an die Datenbank
   *
   * @param object Sql Ein Select Object
   * @param bool[optional] $returnit, Soll die Anfrage gleich zurückgegeben werden?
   * @param bool[optional] $send, Soll die Anfrage Assynchron gesendet werden
   * @return
   */
  public function select( $sql , $returnit = true , $singleRow = false )
  {

  } // end public function select( $sql , $returnit = true , $singleRow = false )

  /**
   * send an insert Request to the Database
   *
   * @param mixed $sql
   * @param string $tableName
   * @param string $tablePk
   * @return int
   */
  public function insert( $sql , $tableName = null, $tablePk = null )
  {

  } // end public function insert( $sql , $tableName = null, $tablePk = null )

  /**
   * Ein Updatestatement an die Datenbank schicken
   *
   * @param String $sql Ein Aktion Object
   * @return int
   */
  public function update( $sql  )
  {

  } // end public function update( $sql  )

  /**
   * Ein Deletestatement and die Datenbank schicken
   *
   * @param res Sql Ein Aktion Object
   * @return
   */
  public function delete( $sql )
  {

  } // end public function delete( $sql )

  /**
   * Setzten des Aktiven Schemas
   *
   * @param string Schema Das aktive Schema
   * @return bool
   */
  public function setSearchPath( $schema )
  {
    return true;
  } // end public function setSearchPath( $schema )

  /**
   * Senden einer Datenbankabfrage zum erstellen eines Ausführplans
   *
   * @param string Name Name der Abfrage
   * @param string Der Fertige SQL Code
   * @return void
   * @throws LibDb_Exception
   */
  public function prepareSelect( $name,  $sqlstring = null )
  {

  } // end public function prepareSelect( $name,  $sqlstring = null )

  /**
   * Ein Insert Statement an die Datenbank schicken
   *
   * @param res Sql Ein Aktion Object
   * @return int
   */
  public function prepareInsert( $name,  $sqlstring = null )
  {

  } // end public function prepareInsert( $name,  $sqlstring = null )

  /**
   * Ein Updatestatement an die Datenbank schicken
   *
   * @param res Sql Ein Aktion Object
   * @param boolean Send
   * @return int
   */
  public function prepareUpdate( $name,  $sqlstring = null )
  {

  } // end public function prepareUpdate( $name,  $sqlstring = null )

  /**
   * Ein Deletestatement and die Datenbank schicken
   *
   * @param res Sql Ein Aktion Object
   * @return
   */
  public function prepareDelete( $name,  $sqlstring = null  )
  {

  } // end public function prepareDelete( $name,  $sqlstring = null  )

  /**
   * Löschen eines Ausführplans in der Datenbank
   *
   * @param string Name Name der Abfrage die gelöscht werden soll
   * @return void
   * @throws LibDb_Exception
   */
  public function deallocate( $name )
  {

  } // end public function deallocate( $name )

  /**
   * Ausführen einer Vorbereiteten Datenbankabfrage
   *
   * @param   string Name Name der Query in der Datenbank
   * @param   array Values Ein Array mit den Daten
   * @throws  LibDb_Exception
   */
  public function executeQuery( $name,  $values = null, $returnIt = true, $single = false )
  {

  } // end public function executeQuery( $name,  $values = null, $returnIt = true, $single = false )

  /**
   * Ausführen einer Vorbereiteten Datenbankabfrage
   *
   * @param   string Name Name der Query in der Datenbank
   * @param   array Values Ein Array mit den Daten
   * @throws  LibDb_Exception
   */
  public function executeAction( $name,  $values = null, $getNewId = false )
  {
    if(Log::$levelDebug)
      Log::start(__file__,__line__,__method__,array($name, $values, $getNewId));

  } // end public function executeAction( $name,  $values = null, $getNewId = false )

  /**
   * a raw sql query
   *
   * @param   string $sql Pure Sql Query
   * @param   boolean $returnit Should be returned?
   * @param   boolean $single Is a single Row Query
   * @throws  LibDb_Exception
   * @return array
   */
  public function query( $sql, $returnit = true, $single = false )
  {
    if(Log::$levelDebug)
      Log::start(__file__,__line__,__method__,array($sql, $returnit, $single));

  } // end public function query( $sql, $returnit = true, $single = false )

  /**
   * execute a sql
   *
   * @param   string $sql Pure Sql Query
   * @throws  LibDb_Exception
   * @return mixed
   */
  public function exec( $sql , $insertId = null , $table = null  )
  {
    if(Log::$levelDebug)
      Log::start(__file__,__line__,__method__,array($sql , $insertId, $table));

  } // end public function exec( $sql  )

  /**
   * Enter description here...
   *
   * @param unknown_type $sql
   * @return unknown
   */
  public function ddlQuery( $sql )
  {
    if(Log::$levelDebug)
      Log::start(__file__,__line__,__method__);
  }//end public function ddlQuery( $sql )

  /**
   * Catche des Datenbankresults nach einer Executeanweisung
   *
   * @throws LibDb_Exception
   * @return void
   */
  public function getResult( )
  {
    if(Log::$levelDebug)
      Log::start(__file__,__line__,__method__);

  } // end public function getResult( )

  /**
   * Auslesen des letzten Abfrageergebnisses
   *
   * @param int $Mode
   * @return array
   */
  public function getAll( $mode = null )
  {
    if(Log::$levelDebug)
      Log::start(__file__,__line__,__method__,array($mode));

  } // end public function getAll( $mode = null )

  /**
   * Das Nächste Result Abfragen
   *
   * @return array

   */
  public function getRow( $mode = null )
  {
    if(Log::$levelDebug)
      Log::start(__file__,__line__,__method__,array($mode));

  } // end public function getRow( $mode = null )

  /**
   * Das Result der letzten Afrage leeren
   *
   * @return
   */
  public function clearResult( )
  {
    if(Log::$levelDebug)
      Log::start(__file__,__line__,__method__);

  } // end public function clearResult( )

  /**
   * Die Numrows der Letzten Aktion abfragen
   *
   * @return int
   */
  public function getNumRows( )
  {
    if(Log::$levelDebug)
      Log::start(__file__,__line__,__method__);

  } // end public function getNumRows( )

  /**
   * Die Affected Rows der letzen Query erfragen
   *
   * @return int
   */
  public function getAffectedRows( )
  {
    if(Log::$levelDebug)
      Log::start(__file__,__line__,__method__);

  } // end of member function getAffectedRows

  /**
   * Meldungen des Datenbanksystems abfragen
   *
   * @return string
   */
  public function getNotice( )
  {
    if(Log::$levelDebug)
      Log::start(__file__,__line__,__method__);

  } // end public function getNotice( )

  /**
   * Fehlermeldungen des Datenbanksystems abfragen
   *
   * @return string
   */
  public function getError( )
  {
    if(Log::$levelDebug)
      Log::start(__file__,__line__,__method__);

  } // end public function getError( )

  /**
   * Starten einer Transaktion
   *
   * @return
   */
  public function begin( $write = true )
  {
    if(Log::$levelDebug)
      Log::start(__file__,__line__,__method__);

  } // end public function begin( )

  /**
   * Transaktion wegen Fehler abbrechen
   *
   * @return
   */
  public function rollback($write = true   )
  {
    if(Log::$levelDebug)
      Log::start(__file__,__line__,__method__);

  } // end public function rollback( )

  /**
   * Transaktion erfolgreich Abschliesen
   *
   * @return
   */
  public function commit($write = true  )
  {
    if(Log::$levelDebug)
      Log::start(__file__,__line__,__method__);

  } // end public function commit( )

  /**
   * Funktion zum einfachen durchleiten einer logquery in die Datenbank
   *
   * @return
   */
  public function logQuery( $sql )
  {

  } // end public function logQuery( $sql )

  /**
   * Den Status des Results Checken
   *
   * @return
   */
  public function checkStatus( )
  {
    if(Log::$levelDebug)
      Log::start(__file__,__line__,__method__);

  } // end public function checkStatus( )

  /**
   * Erstellen einer Datenbankverbindung
   *
   * @param res Sql Ein Select Object
   * @return
   */
  public function connect()
  {
    if(Log::$levelDebug)
      Log::start(__file__,__line__,__method__);

  } // end protected function connect()

  /**
   * Schliesen der Datenbankverbindung
   *
   * @param res Sql Ein Select Object
   * @return
   */
  public function dissconnect()
  {
    if(Log::$levelDebug)
      Log::start(__file__,__line__,__method__);

  } // end of member function dissconnect

  /**
   * Daten zum einfügen in eine Tabelle konvertieren
   *
   * @param string Table
   * @param array Daten
   * @return array
   */
  public function convertData( $table , $daten , $prepare = false )
  {
    if(Log::$levelDebug)
      Log::start(__file__,__line__,__method__,array($table , $daten , $prepare));

    return $daten;

  } // end protected function convertData( $table , $daten , $prepare = false )

  /**
   * Erstellen einer Datenbankverbindung
   *
   * @param res Sql Ein Select Object
   * @return
   */
  public function addSlashes( $value )
  {
    if(Log::$levelDebug)
      Log::start(__file__,__line__,__method__,array($value));

    if ( get_magic_quotes_gpc() ) {
      return $value;
    } else {
      if (is_array($value)) {
        $tmp = array();
        foreach ($value as $key => $data) {
          $tmp[$key] = $this->addSlashes( $data );
        }
        $value = $tmp;
      } else {
        $value = addslashes( $value );
      }
    }

    return $value;

  }
/* (non-PHPdoc)
   * @see LibDbConnection::crud()
   */
  public function crud($sql, $insertId = null, $table = null)
  {
    // TODO Auto-generated method stub

  }
 // end public function addSlashes( $value )

} //end class DbDummy
