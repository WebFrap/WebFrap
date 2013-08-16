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
class LibDbPostgresqlResult extends LibDbResult
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Der Standard Fetch Mode
   */
  protected $fetchMode = PGSQL_ASSOC;

  /**
   * @var array
   */
  protected $tableMetaData = array();

/*//////////////////////////////////////////////////////////////////////////////
// Constantes
//////////////////////////////////////////////////////////////////////////////*/

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

/*//////////////////////////////////////////////////////////////////////////////
// Special Queries
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Löschen eines Ausführplans in der Datenbank
   *
   * @param string Name Name der Abfrage die gelöscht werden soll
   * @return void
   * @throws LibDb_Exception
   */
  public function deallocate()
  {
    $db = $this->dbObject->deallocate($this);
  } // end public function deallocate()

  /**
   * Ausführen einer Vorbereiteten Datenbankabfrage
   *
   * @param   string Name Name der Query in der Datenbank
   * @param   array Values Ein Array mit den Daten
   * @throws  LibDb_Exception
   */
  public function executeQuery($values = array())
  {
    return $this->dbObject->executeQuery($this , $values , $this->single);
  } // end public function executeQuery($values = array())

  /**
   * Ausführen einer Vorbereiteten Datenbankabfrage
   *
   * @param   string Name Name der Query in der Datenbank
   * @param   array Values Ein Array mit den Daten
   * @throws  LibDb_Exception
   */
  public function executeAction($values = array(), $getNewId = false)
  {
    return $this->dbObject->executeAction($this , $values , $getNewId);
  } // end public function executeAction($values = array(), $getNewId = false)

  /**
   * Auslesen des letzten Abfrageergebnisses
   * @return array
   */
  public function getAll()
  {

    $res = array();
    $this->pos = 0;

    while ($this->row = pg_fetch_assoc($this->result))
      $res[] = $this->row;

    if (DEBUG)
      Debug::console('Query: '.$this->numQuery.' dur:'.$this->duration.', '.$this->name, $res  );

    return $res;

  } // end public function getAll */

  /**
   * Alle Felder einer Column auslesen
   *
   * @param string $colName
   * @return array
   */
  public function getColumn($colName)
  {

    $rows = array();
    $this->pos = 0;

    while ($this->row = pg_fetch_assoc($this->result))
      $rows[] = $this->row[$colName];

    return $rows;

  } // end public function getColumn */

  /**
   * Das Nächste Result Abfragen
   *
   * @return array
   */
  public function get()
  {

    if (!$this->row = pg_fetch_assoc($this->result)) {
      $this->pos = null;

      return array();
    } else {
      ++ $this->pos;

      return $this->row;
    }

  } // end public function get */

  /**
   * Das Nächste Result Abfragen
   * @param string $key
   * @return array
   */
  public function getField($key)
  {

    if (!$this->row = pg_fetch_assoc($this->result)) {
      $this->pos = null;

      return null;
    } else {
      ++ $this->pos;

      return $this->row[$key];
    }

  } // end public function getField */

  /**
   * Das Nächste Result Abfragen
   *
   * @return array
   */
  public function load()
  {

    $this->row = pg_fetch_assoc($this->result);
    $this->pos = 0;

  } // end public function load */

  /**
   * Das Nächste Result Abfragen
   *
   * @return array
   */
  public function getQSize()
  {

    if (!$this->row = pg_fetch_assoc($this->result)) {
      return 0;
    } else {
      return isset($this->row['size'])?$this->row['size']:0;
    }

  } // end public function getRow */

  /**
   * Das Result der letzten Afrage leeren
   */
  public function freeResult()
  {
    pg_free_result($this->result);

    return true;
  } // end public function clearResult */

/*//////////////////////////////////////////////////////////////////////////////
// Getter for Query Metadata
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Die Numrows der Letzten Aktion abfragen
   *
   * @return int
   */
  public function getNumRows()
  {
    if (is_null($this->numRows)) {
      $this->numRows = pg_num_rows($this->result);
    }

    return $this->numRows;
  } // end public function getNumRows */

  /**
   * Die Affected Rows der letzen Query erfragen
   *
   * @return int
   */
  public function getAffectedRows()
  {
    return pg_affected_rows($this->result);
  } // end public function getAffectedRows */

  /**
   * @return int
   */
  public function getNumFields()
  {
    if (is_null($this->numFields)) {
      $this->numFields = pg_num_fields($this->result);
    }

    return $this->numFields;

  } // end public function getNumFields */

  /**
   * @param string $key
   */
  public function getFieldName($key)
  {

    if ($key <= ($this->getNumFields()) && $key>=0) {
      $fieldName = pg_field_name($this->result, $key);

      return $fieldName;
    } else {
      return false;
    }

  } // end public function getFieldName */

  /**
   * @param string $key
   */
  public function getFieldType($key)
  {

    if ($key <= ($this->getNumFields()) && $key>=0) {
      $fieldType = pg_field_type($this->result, $key);

      return $fieldType;
    } else {
      return false;
    }

  } // end public function getFieldType */

} //end class LibDbPostgresqlResult

