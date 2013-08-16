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
abstract class LibParserSqlAbstract
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @var LibDbAbstract
   */
  protected $db = null;

  /**
   * Felder die abgefragt werden sollen
   * @var array()
   */
  protected $cols = array();

  /**
   * Felder die abgefragt werden sollen
   * @var array()
   */
  protected $values = array();

  /**
   * Name der Tables mit denen gearbeitet wird
   * @var array()
   */
  protected $table = null;

  /**
   * Joinbedingungen
   * @var array()
   */
  protected $joinOn = array();

  /**
   * Limit der Abfrage
   * @var int
   */
  protected $limit = null;

  /**
   * Offset der Abfrage
   *  @var int
   */
  protected $offset = null;

  /**
   * Group by Parameter
   * @var array()
   */
  protected $group = array();

  /**
   * @var array()
   */
  protected $having = array();

  /**
   * Die Wherebedingungen
   * @var array()
   */
  protected $where = array();

  /**
   * the orders
   * @var array
   */
  protected $order = array();

  /**
   * Is es eine Singelrow oder eine Multirow Query
   */
  public $singleRow = false;

  /**
   * Enter description here...
   *
   * @var string
   */
  protected $newId = null;

  /**
   * Database Data Object
   *
   * @var LibParserSqlAbstract
   */
  protected $dataObj = null;

  /**
   * Enter description here...
   *
   * @var string
   */
  protected $name = null;

  /**
   * Enter description here...
   *
   * @var boolean
   */
  protected $prepare = null;

  /**
   * the table schema
   * @var string
   */
  protected $schema = null;

  /**
   * Der generierte SQL String wird in dieser Variable gespeichert.
   * @return string
   */
  protected $sql = null;

/*//////////////////////////////////////////////////////////////////////////////
// Getter and Setter Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Standardkonstruktor bekommt den Namen der Query übergeben
   *
   * @param string $name Name der Query
   * @param LibSqlConnection $db
   *
   * @return void
   */
  public function __construct( $name = null, $db = null)
  {

    $this->name = $name;
    $this->db = $db;

  }//end public function __construct */

/*//////////////////////////////////////////////////////////////////////////////
// Getter and Setter Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Die SQL Query abfragen
   *
   * @return string
   */
  public function getSql()
  {
    return $this->sql;
  } // end public function getSql */

  /**
   * setzten einer Fertigen SQL Abfrage
   *
   * @param string Sqlstring Einen fertigen SQL String
   * @return boolean
   */
  public function setSql($sqlString)
  {
    $this->sql = $sqlString;
  } // end ublic function setSql */

  /**
   * Setzen des Namens der SQL Query
   *
   * @param string Name
   * @return void
   */
  public function setName($name)
  {
    $this->name = $name;
  } // end public function setName */

  /**
   * Name der Verbindung abfragen
   *
   * @return string
   */
  public function getName()
  {
    return $this->name;
  } // end public function getName */

  /**
   * Name der Verbindung abfragen
   * @param LibDbConnection
   * @return string
   */
  public function setDb($db = null  )
  {

    if ($db) {
      $this->db = $db;
    } else {
      $this->db = Webfrap::$env->getDb();
    }

  } //end public function setDb */

  /**
   * @return LibDbConnection
   */
  public function getDb()
  {

    if (!$this->db)
      $this->db = Webfrap::$env->getDb();

    return $this->db;

  }//end public function getDb */

  /**
   * Setzten ob die Anfrage Prepareable ist
   *
   * @param bool Prepare
   * @return
   */
  public function setPrepareable($prepare)
  {
    $this->prepareAble = $prepare;
  }//end public function setPrepareable */

  /**
   * Abfragen ob die Anfrage Prepareable ist
   *
   * @return bool
   */
  public function isPrepareable()
  {
    return $this->prepareAble ;
  }//end public function isPrepareable */

  /**
   * setzten ob es eine Singelrow oder Multirow Query ist
   *
   * @param bool Single
   * @return
   */
  public function setSingle($single = true)
  {
    $this->singleRow = $single;
  }//end public function setSingle */

  /**
   * Abfragen ob es eine Singel oder Multirow ist
   *
   * @return bool
   */
  public function getSingle()
  {
    return $this->singleRow ;
  }//end public function getSingle */

  /**
   * setzten der abzufragenden Felder
   *
   * @param array $cols Die abzufragenden Cols
   * @return boolean
   */
  public function setCols($cols)
  {
    if (is_array($cols))
      $this->cols = $cols;

    else if (is_string($cols))
      $this->cols =  array($cols);

  }//end public function setCols */

  /**
   * Abfragefelder hinzufuegen
   *
   * @param array $cols Die abzufragenden Felder
   * @return booleane
   */
  public function addCols($cols)
  {
    if (is_array($cols)) {
      $this->cols = array_merge($this->cols, $cols);

      return true;
    }

    return false;

  }//end public function addCols */

  /**
   * Abfragen der Values im Objekt
   *
   * @return array
   */
  public function getCols()
  {
    return $this->cols;
  } // end public function getCols */

  /**
   * setzten der abzufragenden Felder
   *
   * @param array $values Die abzufragenden Cols
   * @return boolean
   */
  public function setValues($values)
  {

    if (is_array($values))
      $this->values = $values;

  } // end public function setValues */

  /**
   * Abfragefelder hinzufuegen
   *
   * @param array $values Die abzufragenden Felder
   * @return booleane
   */
  public function addValues($values)
  {

    if (is_array($values))
      $this->values = array_merge($this->values, $values);

  } // end public function addValues */

  /**
   * Abfragen der Values im Objekt
   *
   * @return array
   */
  public function getValues()
  {

    $this->values;

  } // end public function getValues */

  /**
   * setzten der Tables die abgefragt werden sollen
   *
   * @param string $table
   * @return boolean
   */
  public function setTable($table)
  {

    $this->table = $table;

  } // end public function setTable */

  /**
   * Tables abfragen
   *
   * @return string
   */
  public function getTable()
  {
    return $this->table;
  } // end public function getTable */

  /**
   * @param string $schema
   */
  public function setSchema($schema)
  {
    $this->schema = $schema;
  }//end public function setSchema */

  /**
   * Abfragen des gerade aktiven Schemas
   *
   * @return string
   */
  public function getSchema()
  {
    return $this->schema;
  } // end of member function getSchema */

  /**
   * setting the join conditions
   *
   * @param string $table
   * @param string $on
   * @param string $type
   * @param string $where
   *
   * @return LibParserSqlAbstract
   */
  public function setJoinOn($table, $on, $type = null, $where = null  )
  {

    if (is_array($table) && is_array($on[0])) {
      $this->joinOn = array_merge($this->joinOn, $on[0]);
    } elseif (is_array($table) && is_string($on[0])  ) {
      $this->joinOn[] = $table;
    } elseif (is_string($table) && is_string($on)  ) {
      $this->joinOn[] = array($table, $on, $where, $type);
    }

    return $this;

  }//end public function setJoinOn */

  /**
   * Hinzufügen von Joinbedingungen
   *
   * @param array/string Dat1
   * @param string Dat2
   * @param string Dat3 Type des Joins
   * @return boolean
   */
  public function addJoinOn($tableLeft , $tableRight = null , $type = null , $cond = null)
  {

    if (is_array($tableLeft) && is_array(current($tableLeft))) {
      $this->joinOn = array_merge($this->joinOn , $tableLeft);
    } elseif (is_array($tableLeft)  && is_string(current($tableLeft))) {
      $this->joinOn[] = $tableLeft;
    } elseif (is_string($tableLeft) && is_string($tableRight)  ) {
      $this->joinOn[] = array($tableLeft , $tableRight , $type , $cond);
    } else {
      Error::report('Got invalid join metadata');

      return false;
    }

    return true;

  } // end public function addJoinOn */

  /**
   * Joinbedingungen abfragen
   *
   * @return array
   */
  public function getJoinOn()
  {
    return $this->joinOn;
  } // end public function getJoinOn */

  /**
   * Setzen des Tabellenfeldes aus der die neue Id abgefragt werden
   *
   * @param string Name Name der Tabelle aus der die neue Sequence Id
   *  ausgelesen werden soll,
   * @return void
   * @throws LibDb_Exception
   */
  public function setNewid($name)
  {

    $this->newId = trim($name);

  } // end public function setNewid */

  /**
   * Abfragen der neuen Id
   *
   * @return mixed
   */
  public function getNewid()
  {
    return $this->newId;
  } // end public function getNewid */

  /**
   * Reihenfolge hinzufügen
   *
   * @param array $order
   * @return boolean
   */
  public function setOrder($order)
  {

    if (is_array($order)) {
      $this->order = $order;

      return true;
    } elseif (is_string($order)) {
      $this->order = array($order);

      return true;
    }

    return false;

  } // end public function setOrder */

  /**
   * Reihenfolge hinzufügen
   *
   * @param array $order
   * @return boolean
   */
  public function addOrder($order)
  {

    if (is_array($order)) {
      $this->order = array_merge($this->order , $order);

      return true;
    } elseif (is_string($order)) {
      $this->order[] = $order;

      return true;
    }

    return false;
  }// end public function addOrder */

  /**
   * Abfragen hinzufügen
   *
   * @return array
   */
  public function getOrder()
  {
    return $this->order;

  } // end public function getOrder */

  /**
   * reset the complete order data
   * most uses to reset a the order to get the full num rows after a query
   *
   */
  public function resetOrder()
  {
    $this->order = array();
  } //end public function resetOrder */

  /**
   * setzten der Where Bedingungen
   *
   * @param array Where
   * @return boolean
   */
  public function setWhere($where)
  {

    if (is_string($where)) {
      $this->where = array($where);
    } elseif (is_array($where)) {
      $this->where = $where;
    }

  } // end public function setWhere */

  /**
   * Where Bedingung hizufügen
   *
   * @param array $where
   * @return boolean
   */
  public function addWhere($where)
  {

    if (is_string($where)) {
      $this->where[] = $where ;
    } elseif (is_array($where)) {
      $this->where = array_merge($this->where, $where);
    }

  } // end public function addWhere */

  /**
   * Where Bedingung abfragen
   *
   * @return array
   */
  public function getWhere()
  {
    return $this->where;

  } // end public function getWhere */

  /**
   * Group By setzten
   *
   * @param array $group
   * @return void
   */
  public function setGroup($group)
  {

    if (is_array($group)) {
      $this->group = $group;

      return true;
    } elseif (is_string($group)) {
      $this->group = array($group);

      return true;
    }

    return false;

  } // end public function setGroup */

  /**
   * Group By hinzufügen
   *
   * @param array $group
   * @return boolean
   */
  public function addGroup($group)
  {

    if (is_array($group)) {
      $this->group = array_merge($this->group , $group);

      return true;
    } elseif (is_string($group)) {
      $this->group = array($group);

      return true;
    }

    return false;

  } // end public function addGroup */

  /**
   * Group By abfragen
   *
   * @return array
   */
  public function getGroup()
  {
    return $this->group;

  }// end public function getGroup */

  /**
   * Having By setzten
   *
   * @param array $having
   * @return void
   */
  public function setHaving($having)
  {

    if (is_array($having)) {
      $this->having = $having;

      return true;
    } elseif (is_string($having)) {
      $this->having = array($having);

      return true;
    }

    return false;

  } // end public function setHaving */

  /**
   * Having By hinzufügen
   *
   * @param array $having
   * @return boolean
   */
  public function addHaving($having)
  {

    if (is_array($having)) {
      $this->having = array_merge($this->having, $having);

      return true;
    } elseif (is_string($having)) {
      $this->having = array($having);

      return true;
    }

    return false;

  } // end public function addHaving */

  /**
   * Having By abfragen
   *
   * @return array
   */
  public function getHaving()
  {
    return $this->having;

  } // end public function getHaving */

  /**
   * setzten von Limit und Offset
   *
   * @param int $limit Anzahl Abfrage Erfgebnisse die gewünscht werden
   * @param int $offset Optional Offset, Ab wo soll weiter ausgegeben werden
   * @return boolean
   */
  public function setLimits($limit = null,  $offset = null)
  {

    $this->limit = (int) $limit;
    $this->offset = (int) $offset;

    return true;

  } // end public function setLimits */

  /**
   * setzten von Limit und Offset
   *
   * @param int $limit Anzahl Abfrage Erfgebnisse die gewünscht werden
   * @return void
   */
  public function setLimit($limit = null)
  {
    $this->limit = (int) $limit;
  } // end public function setLimit */

  /**
   * setzten von Limit und Offset
   *
   * @param int $limit Anzahl Abfrage Erfgebnisse die gewünscht werden
   * @return void
   */
  public function setOffset($offset = null)
  {
    $this->offset = (int) $offset;
  } // end public function setOffset */

  /**
   *
   * @return string
   */
  public function getLimit()
  {
    return $this->limit;
  }//end public function getLimit */

  /**
   *
   * @return string
   */
  public function getOffset()
  {
    return $this->offset;
  }//end public function getOffset */

  /**
   * reset the limit/offset
   * often used for resetting query params to get the number of rows
   * that wold be found without limit and offset
   *
   * @return array
   */
  public function resetLimits()
  {
    $this->limit = null;
    $this->offset = null;
  } // end public function resetLimits */

/*//////////////////////////////////////////////////////////////////////////////
// Parsers
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param array $cols
   * @return string
   */
  public function buildCols($cols = array())
  {

    if (!$cols)
      $cols = $this->cols;

    $sql = ' ';

    foreach ($cols as $col)
      $sql .= ' '.$col.',';

    return substr($sql , 0, -1);

  }//end public function buildCols */

  /**
   * @param array $where
   * @return string
   */
  public function buildWhere($where = array())
  {

    if (!$where)
      $where = $this->where;

    $sql = ' ';

    foreach ($where as $cond)
      $sql .= ' '.$cond.' ';

    return $sql;

  }//end public function buildWhere */

  /**
   * @param array $order
   * @return string
   */
  public function buildOrder($order = array())
  {

    if (!$order) {
      $order = $this->order;
    }

    return implode(', ' , $order);

  }//end public function buildOrder */

  /**
   * @param array $group
   * @return string
   */
  public function buildGroupBy($group = array())
  {
    if (!$group) {
      $group = $this->group;
    }

    return implode(', ' , $group);

  }//end public function buildGroupBy */

  /**
   * @param array $having
   * @return string
   */
  public function buildHaving($having = array())
  {

    if (!$having) {
      $having = $this->having;
    }

    return implode(', ', $having);

  }//end public function buildHaving */

  /**
   * @param int $limit
   * @param int $offset
   *
   * @return string
   */
  public function buildLimit($limit = null, $offset = null  )
  {

    if (!$limit) {
      $limit = $this->limit;
    }

    if (!$offset) {
      $offset = $this->offset;
    }

    $sql = '';

    if ($limit && -1 != $limit) {
      $sql .= ' LIMIT '.$limit.' ';
    }

    if ($offset) {
      $sql .= ' OFFSET '.$offset.' ';
    }

    return $sql;

  }//end public function buildHaving */

  /**
   * clean the buildr data
   * @return void
   */
  public function clean()
  {

    $this->cols = array();
    $this->values = array();
    $this->table = null;
    $this->schema = null;
    $this->joinOn = array();
    $this->limit = null;
    $this->offset = null;
    $this->group = array();
    $this->having = array();
    $this->where = array();
    $this->order = array();
    $this->newId = null;

  }//end public function clean */

  /**
   * clean the query
   *
   */
  public function cleanQuery()
  {

    $this->sql = null;

  }//end public function cleanQuery */

/*//////////////////////////////////////////////////////////////////////////////
// Full Query Parsers
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Parser für Selectanfragen
   * @param LibParserSqlAbstract $sql
   *
   * @return string
   */
  public function buildSelect($sql = null)
  {

    if (!$sql)
      $sql = $this;

    return $this->buildSelectSql($sql);

  }//end public function buildSelect */

  /**
   * Parser für Selectanfragen
   * @param LibSqlCriteria $obj
   *
   * @return string
   */
  public function buildSelectSql($obj, $isSubQuery = false)
  {

    if ($obj->filters) {

      foreach ($obj->filters as $position => $filter) {
        $filter->filter($obj, $position);
      }

    }

    $sql = 'SELECT ';

    if ($obj->distinct) {
      $sql .= ' DISTINCT ';
    }

    /*
    // wenn distinct oder group by müssen die order by in die select
    if ($obj->distinct || $obj->group) {
      if ($obj->order) {

        foreach ($obj->order as $oNode) {
          if (!isset($obj->colsIndex[$oNode])) {
            $obj->colsIndex[$oNode] = true;
            $obj->cols[] = $oNode.' as "ob-'.str_replace('.', '-', $oNode).'"';
          }
        }

      }
    }

    // sicher stellen, dass alle nötigen felder im group by vorhanden sind
    if ($obj->group) {
      foreach ($obj->group as $gNode) {
        if (!isset($obj->colsIndex[$gNode])) {
          $obj->colsIndex[$gNode] = true;
          $obj->cols[] = $gNode.' as "gb-'.str_replace('.', '-', $gNode).'"';
        }
      }
    }
    */

    if (!$obj->cols) {
      throw new LibDb_Exception(I18n::s('got no cols','wbf.message'));
    }

    $sql .= implode(', ', $obj->cols);

    if (!$obj->table) {

      if ($obj->subQuery) {
        $sql .= ' FROM ('. $this->buildSelectSql($obj->subQuery, true) .') as '.$obj->subQuery->name;
      } else {
        throw new LibDb_Exception(I18n::s('got no table','wbf.message'));
      }
    } else {
      $sql .= ' FROM '. $obj->table .' '.$obj->as.' ';
    }

    // Die Joins falls vorhanden generieren
    if ($obj->joinOn) {

      foreach ($obj->joinOn as $join) {

        /*
         *  JOIN_TYPE = 0;
         *  SRC = 1;
         *  SRC_FIELD = 2;
         *  TARGET = 3;
         *  TARGET_FIELD = 4;
         *  WHERE = 5;
         *  TARGET_ALIAS = 6;
         */

        if (is_string($join)) {
          $sql .= $join;
        } else {
          $sql .=  $join[LibSqlCriteria::JOIN_TYPE];

          $sql .= ' JOIN '.$join[LibSqlCriteria::TARGET].' '.$join[LibSqlCriteria::TARGET_ALIAS].' ON ';
          $sql .= $join[LibSqlCriteria::SRC].'.'.$join[LibSqlCriteria::SRC_FIELD].' = ';

          $sql .= isset($join[LibSqlCriteria::TARGET_ALIAS])
            ? $join[LibSqlCriteria::TARGET_ALIAS]
            : $join[LibSqlCriteria::TARGET];
          $sql .= '.'.$join[LibSqlCriteria::TARGET_FIELD].' ';

          if ($join[LibSqlCriteria::WHERE])
            $sql .= ' AND '.$join[LibSqlCriteria::WHERE];
        }

      }//end foreach

    }//end if ($obj->joinOn)

    // Filter im plementieren
    if ($obj->where)
      $sql .= ' WHERE '.$obj->where ;

    if ($obj->filter) {

      if (!$obj->where) {
        $sql .= ' WHERE '.$obj->filter ;
      } else {
        $sql .= ' AND ('.$obj->filter .') ' ;
      }

    }

    if ($obj->filtersBlocks) {

      $first = false;
      if (!$obj->where && !$obj->filter) {
        $sql .= ' WHERE ';
        $first = true;
      }

      foreach ($obj->filtersBlocks as $fBlock) {

        if ($first) {
          $sql .= ' '.$fBlock['not'].' ('.$fBlock['content'].') ';
        } else {
          $sql .= ' '.$fBlock['con'].' '.$fBlock['not'].' ('.$fBlock['content'].') ';
        }

        $first = false;
      }

    }

    // Die Group By Bedingungen auslesen
    if ($obj->group)
      $sql .= ' GROUP BY '.implode(', ' , $obj->group);

    // FIXME having funktioniert so nicht
    if ($obj->having)
      $sql .= ' HAVING '.implode(', ' , $obj->having);

    // Die Order By Bedingungen auslesen
    if ($obj->order)
      $sql .= ' ORDER BY '.implode(', ' , $obj->order);

    if ( $obj->limit && -1 != $obj->limit)
      $sql .= ' LIMIT ' . $obj->limit;

    if ($obj->offset)
      $sql .= ' OFFSET ' . $obj->offset;

    if (!$isSubQuery)
      $sql .= ';'.NL;

    $obj->sql = $sql;

    return $sql;

  } // end public function buildSelectSelf */

/*//////////////////////////////////////////////////////////////////////////////
// Parser für Insert
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Parser für Inputanfragen
   * @param array $values die Datensätze die eingefügt werden solle
   * @param string $table name der Tabelle
   *
   * @return string
   */
  public function buildInsert($values = null, $table = null, $dropEmptyWhitespace = true)
  {

    if ($table) {
      return $this->buildInsertSql($values, $table, $dropEmptyWhitespace);
    } elseif (is_object($values)) {
      return $this->buildInsertSql($values->getValues(), $values->getTable(), $dropEmptyWhitespace);
    } else {
      return $this->buildInsertSql($this->values, $this->table, $dropEmptyWhitespace);
    }

  } // end public function buildInsert */

  /**
   * de:
   * bauen einer SQL Query die nur dann einen bestimmten Datensatz erstellt, wenn er
   * noch nicht existiert
   *
   * @param array $values die Datensätze die eingefügt werden solle
   * @param string $table name der Tabelle
   * @param array $duplicates liste mit den feldern die auf duplikate geprüft werden sollen
   * @return string
   * @throws LibDb_Exception wenn zum prüfen auf duplikate keys angefragt werden die nicht existieren
   */
  public function buildInsertIfNotExistsQuery(array $values, $table, array $duplicates, $dropEmptyWhitespace = true)
  {

    $db = $this->getDb();

    if (!$values = $db->orm->convertData($table , $values, $dropEmptyWhitespace)  ) {
      throw new LibDb_Exception('Failed to convert the data to insert');
    }

    $cols = implode(',', array_keys($values));

    $keyVal = array();
    $keyDupl = array();

    foreach ($values as $key => $value) {
      $keyVal[] = " $value as $key ";
    }

    foreach ($duplicates as $dupKey) {

      if (!array_key_exists($dupKey, $values)) {
        //throw new LibDb_Exception('Requested an insert if not exists action, but the values not exists');
        $keyDupl[] = " $dupKey IS NULL ";
      } elseif (is_null($values[$dupKey])) {
        $keyDupl[] = " $dupKey IS NULL ";
      } else {
        $keyDupl[] = " $dupKey = {$values[$dupKey]} ";
      }

    }

    $sqlValues = implode(', ', $keyVal);
    $sqlDuplKeys = implode(' AND ', $keyDupl);

    $sql = <<<SQL

INSERT INTO {$table}
(
  {$cols}
)
(
  select
    {$sqlValues}
  WHERE
    NOT EXISTS
  (
    SELECT
      1
    FROM
    {$table}
    WHERE
      {$sqlDuplKeys}
  )
);

SQL;

    return $sql;

  } // end public function buildInsertIfNotExistsQuery */

  /**
   * Parser für Inputanfragen
   * @param array $values
   * @param string $table
   * @param boolean $dropEmptyWhitespace
   * @return string
   */
  public function buildInsertSql($values , $table, $dropEmptyWhitespace = true)
  {

    $db = $this->getDb();

    $sql = 'INSERT INTO '.$table.' ';

    if (!$values = $db->orm->convertData($table , $values, $dropEmptyWhitespace)  ) {
      throw new LibDb_Exception('Failed to convert the data to insert');
    }

    $cols = implode(',',array_keys($values));
    $data = implode(',',$values);

    $sql .= ' ('.$cols.') VALUES ('.$data.'); ' ;

    return $sql;

  }//end public function buildInsert */

/*//////////////////////////////////////////////////////////////////////////////
// Parser für Update
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Bauen der update Query
   *
   * @param array $values
   * @param string $table
   * @param string $pk
   * @param string $id
   *
   * @return string
   */
  public function buildUpdate($values = array(), $table = null , $pk = null , $id = null)
  {

    if (is_object($values)  ) {
      return $this->buildUpdateObj($values);
    } elseif ($table) {
      return $this->buildUpdateSql($values, $table, $pk, $id);
    } else {
      return $this->buildUpdateObj($this);
    }

  } //end public function buildUpdate */

  /**
   * Parser für Updateanfragen
   *
   * @return string
   */
  public function buildUpdateObj($obj = null)
  {

    $db = $this->getDb();

    if (!$obj)
      $obj = $this;

    $sql = 'UPDATE '.$obj->table.' SET ';

    if (!$values = $db->orm->convertTableData($obj->table, $obj->values))
      throw new LibDb_Exception('Convert failed');

    foreach ($values as $key => $value)
      $sql .= ' '.$key.' = '.$value.' , ';

    $sql = substr($sql , 0 , -2);

    // Die Where Bedingungen generieren
    if ($obj->where) {
      if (is_string($obj->where)) {
        $sql .= ' WHERE '.$obj->where;
      } else {
        $sql .= ' WHERE '.implode(' ', $obj->where);
      }
    }

    return $sql;

  }//end public function buildUpdateObj */

  /**
   * Parser für Updateanfragen
   * @param array $values
   * @param string $table
   * @param string $pk
   * @param int $id
   *
   * @return string
   */
  public function buildUpdateSql($values, $table, $pk, $id = null)
  {

    $db = $this->getDb();

    $sql = 'UPDATE '.$table.' SET ';

    if (!$values = $db->orm->convertData($table , $values  ))
      throw new LibDb_Exception('Konvert ist fehlgeschlagen');

    foreach ($values as $key => $value)
      $sql .= ' '.$key.' = '.$value.' , ';

    $sql = substr($sql, 0, -2);

    $sql .= ' WHERE ';

    if (is_array($pk)) {

      $tmpWhere = array();

      foreach ($pk as $wKey => $wValue) {
        $tmpWhere[] = ' '.$wKey." = '".$wValue."'";
      }

      $sql .= implode(' and ', $tmpWhere);

    } else {
      // Die Where Bedingungen generieren
      if ($id)
        $sql .= ' '.$pk.' = '.$id;
      else
        $sql .= $pk;
    }

    return $sql.';';

  } // end public function buildUpdateSql */

/*//////////////////////////////////////////////////////////////////////////////
// Parser für Delete
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $table
   * @param string $pk
   * @param int $id
   *
   * @return string
   */
  public function buildDelete($table = null, $pk = null, $id = null)
  {

    if (is_object($table)) {
      return $this->buildDeleteObj($table);
    } elseif ($pk) {
      return $this->buildDeleteSql($table, $pk, $id);
    } else {
      return $this->buildDeleteObj($this);
    }

  }//end public function buildDelete */

  /**
   *
   * @param $obj
   * @return string
   */
  public function buildDeleteObj($obj = null)
  {

    if (!$obj)
      $obj = $this;

    $sql = 'DELETE FROM ';
    $sql .= $obj->table;

    if ($obj->where) {
      if (is_string($obj->where)) {
        $sql .= ' WHERE '.$obj->where;
      } else {
        $sql .= ' WHERE '.implode(' ', $obj->where);
      }
    }

    return $sql.';';

  }//end public function buildDeleteObj */

  /**
   *
   * @param $table
   * @param $pk
   * @param $id
   * @return string
   */
  public function buildDeleteSql($table, $pk, $id = null)
  {

    $sql = 'DELETE FROM '.$table.' WHERE ';

    if ($id)
      $sql .= " $pk = $id ";
    else
      $sql .= $pk;

    return $sql.';';

  }//end public function buildDeleteSql */

} // end abstract class LibDbParserAbstract

