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
 * Die Basis Connection Klasse für alle Datenbankverbindungen
 *
 * @package WebFrap
 * @subpackage tech_core
 */
abstract class LibDbConnection
{
/*//////////////////////////////////////////////////////////////////////////////
// Constantes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * fetch as assoc array
   */
  const fetchAssoc        = null;

  /**
   * fetch as numeric array
   */
  const fetchNum          = null;

  /**
   * fetch assoc and numeric
   */
  const fetchBoth         = null;

/*//////////////////////////////////////////////////////////////////////////////
// Public Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * The ORM Layer in the WebFrap Database Layer
   * @var LibDbOrm
   */
  public $orm                  = null;

  /**
   * name of the connected Database
   *
   * @var string
   */
  public $databaseName      = null;

  /**
   * Databaseconf
   */
  public $schema            = null;

  /**
   * Die Connection URL
   * @var string
   */
  public $dbUrl      = null;

  /**
   * Der Port der Datenbank
   * @var string
   */
  public $dbPort      = null;

  /**
   * Der aktive User
   * @var string
   */
  public $dbuser  = null;

  /**
   * Der aktive User
   * @var string
   */
  public $dbPwd      = null;

  /**
   * Zeit die für Datenbankabfragen aufgewendet wurde
   * @var string
   */
  public $queryTime      = 0;

/*//////////////////////////////////////////////////////////////////////////////
// Protected Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * the datbase resource id for the read connection
   * @var resource id
   */
  protected $connectionRead    = null;

  /**
   * the datbase resource id for the write connection
   * @var resource id
   */
  protected $connectionWrite   = null;

  /**
   * works the database in cluster mode
   *
   * @var boolean
   */
  protected $clusterMode      = false;

  /**
   * database connection result
   * @var resource id
   */
  protected $result            = null;

  /**
   * object pool for prepared statements
   * @var array
   */
  protected $prepares          = array();

  /**
   * counter for database requests
   */
  protected $counter           = 0;

  /**
   * Speichert das SQL Objekt zwischen
   * @var ISqlParser
   */
  protected $activObject       = null;

  /**
   * Speichern der letzten Abfrage
   */
  protected $lastQuery         = null;

  /**
   * array with the database connection parameters
   * @var array
   */
  protected $conf              = null;

  /**
   * the fetchmode for the database
   */
  protected $fetchMode         = null;

  /**
   * the type of the sql
   * @var string
   */
  protected $builderType        = null;

  /**
   * if this logger is set, all queries are logged in this object
   * @var LibProtocolFile
   */
  protected $protocol            = null;

/*//////////////////////////////////////////////////////////////////////////////
// Constructor
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Default Constructor
   * creating the connection to the database
   */
  public function __construct($conf)
  {

    $this->conf = $conf;
    $this->orm = new LibDbOrm($this, $this->builderType  );

    // Verbindung zur Datenbank erstellen
    $this->connect();

    //Message::addMessage("Called Database Connection ".Debug::backtrace());

    // Counter auf 0 setzte
    $this->counter = 0;

  } // end function __construct */

  /**
   * destructor
   */
  public function __destruct()
  {
    // discconnect on destruct
    $this->dissconnect();
  }//end public function __destruct */

  /**
   * To String Methode, implementiert für bessere Fehlermeldungen
   * @return string
   */
  public function __toString()
  {
    return 'Database Connection: ' .$this->databaseName .' Type: '.$this->getParserType();
  }//end public function __toString */

/*//////////////////////////////////////////////////////////////////////////////
// Getter and Setter Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * setter for logger
   * @param LibProtocolFile $protocol
   */
  public function close()
  {
    $this->dissconnect();
  }//end public function close */

  /**
   * setter for logger
   * @param LibProtocolFile $protocol
   */
  public function setProtocol($protocol)
  {
    $this->protocol = $protocol;
  }//end public function setProtocol */

  /**
   * reset the activ logger object
   */
  public function resetProtocol()
  {
    $this->protocol = null;
  }//end public function resetProtocol */

  /**
   * Setzten des Aktiven Schemas
   *
   * @param string Schema Das aktive Schema
   * @return bool
   */
  abstract public function setSearchPath($schema);

  /**
   * request the activ search path from the database if exists
   *
   * @return string
   */
  public function getSearchPath()
  {
    return $this->schema;
  } // end public function getSearchPath */

  /**
   * create a unique key for prepared queries
   * @return string
   */
  public function createKey()
  {
    return 'wgt-'.rand();
  } // end public function createKey */

  /**
   * set at fetch mode for the database
   * @param  string $fetchMode
   * @return void
   */
  public function setFetchMode($fetchMode)
  {
    $this->fetchMode = $fetchMode;
  } // end public function setFetchMode */

  /**
   * Abfrage der Anzahl Querys zur Laufzeit des Scriptes
   *
   * @return int
   */
  public function getNumQuerys()
  {
    return $this->counter;
  } // end public function getNumQuerys */

  /**
   * Erstellen eines neuen Query Objekts.
   * Alle Abragen auserhalb des ORMs sind in Datenbankspezifische Query Objekte
   * zu packen
   *
   * New Query liefert automatisch das passende Query Objekt zu aktuell aktiven
   * Datenbank
   *
   * @param string $name
   * @return LibSqlQuery
   * @throws LibDb_Exception Wenn die angefragte Query nicht existiert
   */
  public function newQuery($name  )
  {

    $defClassName = $name.'_Query';
    $dbClassName  = $defClassName.'_'.$this->builderType;

    $defClassNameOld = 'Query'.$name;
    $dbClassNameOld  = $defClassName.$this->builderType;

    if (Webfrap::classExists($dbClassName)) {
      return new $dbClassName(null, $this);
    } elseif (Webfrap::classExists($defClassName)) {
      return new $defClassName(null, $this);
    } elseif (Webfrap::classExists($dbClassNameOld)) {
      return new $dbClassNameOld(null, $this);
    } elseif (Webfrap::classExists($defClassNameOld)) {
      return new $defClassNameOld(null, $this);
    } else {

      throw new LibDb_Exception(
        'Requested nonexisting Query: '.$defClassName.'. Please check the loadpath of WebFrap, or if this Class exists.'
       );

    }

  }//end public function newQuery */

  /**
   * @param string $name
   * @return LibSqlFilter
   * @throws LibDb_Exception wenn der angefragte Filter nicht existiert
   */
  public function newFilter($name  )
  {

    $defClassName = $name.'_Filter';
    $dbClassName  = $defClassName.'_'.$this->builderType;

    if (Webfrap::classExists($dbClassName)) {

      return new $dbClassName(null, $this);
    
    } elseif (Webfrap::classExists($defClassName)) {

      return new $defClassName(null, $this);
    
    } else {
      
      return null;
      
      /*
      throw new LibDb_Exception(
        'Requested nonexisting Filter: '.$defClassName.'. '
        .'Please check the loadpath of WebFrap, or if this Class exists.'
      );
      */

    }

  }//end public function newFilter */

  /**
   * Ein Leeres Datenbank Result zurückgeben
   *
   * Wird verwendet, wenn von vorne herein klar ist, das ein Datenbank Query
   * so oder so keine Daten zurück geben würde.
   *
   * Zb eine Leere IN Query
   *
   * @return LibDbEmptyResult
   */
  public function getEmptyResult()
  {
    return new LibDbEmptyResult();

  }//end public function getEmptyResult */

  /**
   * Request the ORM Layer of the DB
   * @return LibDbOrm
   */
  public function getOrm()
  {

    // initialize the orm just when it is requested
    if (!$this->orm)
      $this->orm = new LibDbOrm(
        $this, $this->builderType,
        $this->databaseName, $this->schema
      );

    return $this->orm;

  }//end public function getOrm */

  /**
   * Enter description here...
   * @todo replace with getBuilderType
   * @return string
   */
  public function getParserType()
  {
    return ucfirst($this->builderType);
  }//end public function getParserType */

  /**
   * Den namen des DBMS types für die aktuelle Connection erfragen
   * @return string
   */
  public function getConnectionDbms()
  {
    return ucfirst($this->builderType);
  }//end public function getConnectionDbms */

  /**
   * Getter für den Namen der aktuell selektierten Datenbank
   * @return string
   */
  public function getDatabaseName()
  {
    return $this->databaseName;
  }//end public function getDatabaseName */

  /**
   * Das akttuell aktive default Schema der Datenbankverbindung erfragen
   * @return string
   */
  public function getSchemaName()
  {
    return $this->schema;
  }//end  public function getSchemaName */

  /**
   * @return LibDbAdminPostgresql
   */
  public function getManager()
  {
    return new LibDbAdminPostgresql($this);

  }//end public function getManager */

/*//////////////////////////////////////////////////////////////////////////////
// Logic
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $string
   */
  public function dbArrayToArray($string   )
  {

    // erstes und letztes zeichen ignorieren
    $string = substr($string , 1 , -1);

    if (strpos('"', $string) === false)
      return explode(',' , $string);

    if (!$length = strlen($string))
      return null;

    $open = false;

    $array = array();
    $ignoreNext = false;

    $value = '';

    // über den string itterieren
    for ($pos = 0; $pos < $length ; ++$pos) {

      $char = $string[$pos];

      // escapes einbaun
      if ($char == '\\') {
        $ignoreNext = true;
        continue;
      }
      // end escapes

      if ($char == '"' && !$ignoreNext) {
        // abschnitt is abgeschlossen
        if ($open) {
          // zuordnen und escape entfernen
          $array[] = str_replace('\"' , '"'  , $value) ;
          $value = '';
          $open = false;
        } else { // neuer abschnitt beginnt
          $open = true;
        }
      } else {
        // wenn offen dann an value anhängen
        if ($open)
          $value .= $char;

      }

      $ignoreNext = false;

    }//end foreach ($string as $char)

    return $array;

  }//end public function dbArrayToArray */

  /**
   * eine art explode mit escape für kommas
   */
  public function dbStringToArray($string   )
  {

    // erstes und letztes zeichen ignorieren
    $string = substr($string , 1 , -1);

    if (strpos('"', $string) === false)
      return explode(',' , $string);

    $length = strlen($string);

    $open = false;

    $array = array();
    $ignoreNext = false;

    $value = '';

    // über den string itterieren
    for ($pos = 0; $pos < $length ; ++$pos) {

      $char = $string[$pos];

      if ($char == "\\") {
        $ignoreNext = true;
        continue;
      }

      // end escapes

      if ($char == ';' &&  !$ignoreNext) {
        $array[] = $value;
        $value = '';
      } else {
        $value .= $char;
      }

      $ignoreNext = false;

    }//end foreach ($string as $char)

    if (trim($value)  != '')
      $array[] = $value;

    return $array;

  }//end public function dbArrayToArray */

  /**
   * @param string $datas
   * @return array
   */
  public function dbArrayToString($datas)
  {

    $serialized = '{';

    $tmp = array();

    foreach ($datas as $data) {
      $data = str_replace(array('"',"'"), array('\"', "\'")   , $data  );
      $tmp[] = '"'.$data.'"';
    }

    $serialized .= implode(',' , $tmp);
    $serialized .= '}';

    return $serialized;

  }//end public function dbArrayToString */

/*//////////////////////////////////////////////////////////////////////////////
// Cache
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   */
  public function saveCache()
  {

    // speichern des ORM Caches
    if ($this->orm)
      $this->orm->saveCache();

  }//end public function saveCache */

/*//////////////////////////////////////////////////////////////////////////////
// Abstract Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * send a select query to the database
   *
   * @param mixed   $sql a select query as string or object
   * @return LibDbResult
   */
  abstract public function select($sql);

  /**
   * send an insert statement to the tatabase
   *
   * @param mixed $sql a sql string or query object
   * @param string $tableName the name of the table
   * @param string $tablePk the name of the tablepk
   * @param string $dropEmptyWhitespace the name of the tablepk
   * @return LibDbResult
   */
  abstract public function insert($sql , $tableName, $tablePk  );

  /**
   * Ein Updatestatement an die Datenbank schicken
   *
   * @param res Sql Ein Aktion Object
   * @param bool Send Soll gesendet oder gewartet werden
   * @return LibDbResult
   */
  abstract public function update($sql);

  /**
   * Ein Deletestatement and die Datenbank schicken
   *
   * @param res $sql Sql Ein Aktion Object
   * @return LibDbResult
   */
  abstract public function delete($sql  );

  /**
   * Senden einer Datenbankabfrage zum erstellen eines Ausführplans
   *
   * @param string Name Name der Abfrage
   * @param string Der Fertige SQL Code
   * @return void
   */
  abstract public function prepareSelect($name,  $sqlstring  );

    /**
   * Senden einer Datenbankabfrage zum erstellen eines Ausführplans
   *
   * @param string Name Name der Abfrage
   * @param string Der Fertige SQL Code
   * @return void
   */
  abstract public function prepareInsert($name,  $sqlstring  );

  /**
   * Senden einer Datenbankabfrage zum erstellen eines Ausführplans
   *
   * @param string Name Name der Abfrage
   * @param string Der Fertige SQL Code
   * @return void
   */
  abstract public function prepareUpdate($name,  $sqlstring  );

  /**
   * Senden einer Datenbankabfrage zum erstellen eines Ausführplans
   *
   * @param string Name Name der Abfrage
   * @param string Der Fertige SQL Code
   * @return void
   */
  abstract public function prepareDelete($name,  $sqlstring  );

  /**
   * Löschen eines Ausführplans in der Datenbank
   *
   * @param string Name Name der Abfrage die gelöscht werden soll
   * @return
   */
  abstract public function deallocate($name);

  /**
   * Ausführen einer Vorbereiteten Datenbankabfrage
   *
   * @param string Name Name der Query in der Datenbank
   * @param array Values Ein Array mit den Daten
   * @param bool[optional] $returnit, Sollen die Datensätze Zurückgegeben werden
   * @return
   */
  abstract public function executeQuery($name,  $values = null, $returnIt = true);

    /**
   * Ausführen einer Vorbereiteten Datenbankabfrage
   *
   * @param string Name Name der Query in der Datenbank
   * @param array Values Ein Array mit den Daten
   * @param bool[optional] $returnit, Sollen die Datensätze Zurückgegeben werden
   * @return
   */
  abstract public function executeAction($name,  $values = null, $getNewId = false);

  /**
   * Durchreichen einer reinen SQL Abfrage
   *
   * @param string Sql Die SQL Abfragen
   * @param bool Returnit soll die Afrage nur gesendet werden oder gleich das Ergebnis zurück?
   * @return array
   */
  abstract public function query($sql);

  /**
   * Durchreichen einer reinen SQL Abfrage
   *
   * @param string Sql Die SQL Abfragen
   * @return int
   */
  abstract public function crud($sql , $insertId = null , $table = null);

  /**
   * send a ddl query as create and alter table, but also create user etc
   *
   * @param string $sql
   */
  abstract public function ddlQuery($sql);

  /**
   * Starten einer Transaktion
   *
   * @return
   */
  abstract public function begin($write = true);

  /**
   * Transaktion wegen Fehler abbrechen
   *
   * @return
   */
  abstract public function rollback($write = true);

  /**
   * Transaktion erfolgreich Abschliesen
   *
   * @return
   */
  abstract public function commit($write = true);

  /**
   * Funktion zum einfachen durchleiten einer logquery in die Datenbank
   *
   * @return
   */
  abstract public function logQuery($sql);

  /**
   * Den Status des Results Checken
   *
   * @return
   */
  abstract public function checkStatus();

  /**
   * Erstellen einer Datenbankverbindung
   *
   * @param res Sql Ein Select Object
   * @return
   */
  abstract protected function connect();

  /**
   * Schliesen der Datenbankverbindung
   *
   * @param res Sql Ein Select Object
   * @return
   */
  abstract protected function dissconnect();

  /**
   * Daten zum einfügen in eine Tabelle konvertieren
   *
   * @param mixed $value
   * @return array
   */
  abstract public function addSlashes($value);

} // end abstract class DbAbstract

