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
class LibSqlCriteria
  implements ISqlParser
{
/*//////////////////////////////////////////////////////////////////////////////
// const
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Der Join Type
   * @var int
   */
  const JOIN_TYPE     = 0;

  /**
   * @var int
   */
  const SRC           = 1;
  const SRC_FIELD     = 2;

  const TARGET        = 3;
  const TARGET_FIELD  = 4;

  const WHERE         = 5;
  const TARGET_ALIAS  = 6;

/*//////////////////////////////////////////////////////////////////////////////
// attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Felder die abgefragt werden sollen
   * @var LibSqlCriteria
   */
  public $subQuery   = null;

  /**
   * Ist die Abfrage distinct
   * @var array
   */
  public $distinct   = null;

  /**
   * Felder die abgefragt werden sollen
   * @var array
   */
  public $cols       = array();

  /**
   * Wird benötigt um im falle von DISTINCT queries
   * oder group by queries sicher zu stellen, dass alle nötigen
   * felder im select teil vorhanden sind
   *
   *
   * @var array
   */
  public $colsIndex       = array();

  /**
   *
   * @var string
   */
  public $table      = null;

  /**
   * Joinbedingungen
   * @var array
   */
  public $joinOn     = array();

  /**
   * Joinbedingungen
   * @var array
   */
  public $joinIndex  = array();


  /**
   * Limit der Abfrage
   * @var int
   */
  public $limit      = null;

  /**
   * Offset der Abfrage
   * @var int
   */
  public $offset     = null;

  /**
   * Group by Parameter
   * @var array
   */
  public $group      = array();

  /**
   * @var array
   */
  public $having     = array();

  /**
   * Die Wherebedingungen
   * @var string
   */
  public $where      = null;


  /**
   * Die Wherebedingungen
   * @var string
   */
  public $filter    = null;

  /**
   * Oder Reihenfolge
   * @var array
   */
  public $order      = array();

  /**
   * the values
   * @var array
   */
  public $values     = array();

  /**
   * the values
   * @var array
   */
  public $unions     = array();

  /**
   * filter objekte
   * @var array
   */
  public $filters    = array();

  /**
   * Filterblocks
   * @var array
   */
  public $filtersBlocks    = array();

  /**
   * Der generierte SQL String wird in dieser Variable gespeichert.
   * @var string
   */
  public $sql       = null;

  /**
   * der name für prepare statements
   * @var string
   */
  public $name      = null;

  /**
   * parameter für prepare statements
   * @var array
   */
  public $param     = array();

  /**
   * Is es eine Singelrow oder eine Multirow Query
   * @var boolean
   */
  public $singleRow = false;


  /**
   * @var LibDbConnection
   */
  protected $db = null;

/*//////////////////////////////////////////////////////////////////////////////
// Constructor and Magic Functions
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Standardkonstruktor bekommt den Namen der Query übergeben
   *
   * @param string $name Name der Query
   * @param LibSqlConnection $db Name der Query
   *
   * @return void
   */
  public function __construct($name, $db = null )
  {

    $this->name = $name;

    if (!$db )
    {
      $db = Webfrap::$env->getDb();
    }

    $this->db = $db;

  } // end public function __construct */

  /**
   * @return string
   */
  public function __toString()
  {
    try
    {
      if (!$this->sql )
        $this->build();
    }
    catch( LibDb_Exception $e )
    {
      // return an empty query to no provocate an php error
      return '';
    }

    return $this->sql;

  }//end public function __toString */

/*//////////////////////////////////////////////////////////////////////////////
// insert and update methodes
//////////////////////////////////////////////////////////////////////////////*/


  /**
   * Abfragefelder hinzufuegen
   *
   * @param array $values
   * @return boolean
   */
  public function values($values )
  {

    if ( is_array($values ) )
      $this->values = array_merge($this->values, $values );

    return $this;

  } // end public function values */

  /**
   * setzten der Tables die abgefragt werden sollen
   *
   * @param string $table
   * @return LibSqlCriteria
   */
  public function table($table )
  {

    $this->table = $table;
    return $this;

  } // end public function table */


/*//////////////////////////////////////////////////////////////////////////////
// Criteria Methods
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * setzten ob es eine Singelrow oder Multirow Query ist
   *
   * @param bool $single
   * @return LibSqlCriteria
   */
  public function single($single = true )
  {

    $this->singleRow = $single;
    return $this;

  } // end public function single */

  /**
   * setzten der abzufragenden Felder
   *
   * @param array/string $cols Die abzufragenden Cols
   * @return LibSqlCriteria
   */
  public function count($cols = array( Db::PK ), $cleanGroup = false )
  {

    $this->cols = array($cols ) ;

    // unnötige daten entfernen
    $this->limit  = null; // limit und offset müssen weg um die gesamtsumme zu bekommen
    $this->offset = null;
    $this->order  = null;

    if ($cleanGroup )
    {
      $this->group = array();
    }

    return $this;

  } // end public function count */

  /**
   * @param string $key
   */
  public function isJoined($key )
  {

    return isset($this->joinIndex[$key] );

  }//end public function isJoined */

  /**
   * setzten der abzufragenden Felder
   *
   * @param array/string $cols Die abzufragenden Cols
   * @return LibSqlCriteria
   */
  public function select($cols, $distinct = null )
  {

    if (!is_null($distinct) )
      $this->distinct = $distinct;

    if ($this->distinct )
    {

      if ( is_array($cols ) )
      {
        $this->cols = $cols;

        foreach(  $cols as $colName )
        {
          $tmp = explode( ' as ', $colName );
          $this->colsIndex[trim($tmp[0])] = true;
        }

      }
      else if ( is_string($cols ) ){

        $this->cols = array($cols );

        // darf nur ein einziges feld sein!
        $tmp = explode( ' as ', $cols );
        $this->colsIndex[trim($tmp[0])] = true;

      }

    } else {
      if ( is_array($cols ) )
        $this->cols = $cols;

      else if ( is_string($cols ) )
        $this->cols = array($cols );
    }

    return $this;

  } // end public function setCols */


  /**
   * Abfragefelder hinzufuegen
   *
   * @param array/string $cols the cols to add to the query
   * @return LibSqlCriteria
   */
  public function selectAlso($cols )
  {

    if ($this->distinct )
    {

      if ( is_array($cols ) )
      {
        $this->cols = array_merge($this->cols, $cols  ) ;

        foreach(  $cols as $colName )
        {
          $tmp = explode( ' as ', $colName );
          $this->colsIndex[trim($tmp[0])] = true;
        }

      }
      else if ( is_string($cols ) ){

        $this->cols[] = $cols;

        // darf nur ein einziges feld sein!
        $tmp = explode( ' as ', $cols );
        $this->colsIndex[trim($tmp[0])] = true;

      }

    } else {
      if ( is_array($cols ) )
        $this->cols = array_merge($this->cols, $cols  ) ;

      else if ( is_string($cols ) )
        $this->cols[] = $cols;
    }

    return $this;

  } // end public function selectAlso */

  /**
   * setzten der Tables die abgefragt werden sollen
   *
   * @param string $table
   * @param string $indexKey der key für den index check
   * @return LibSqlCriteria
   */
  public function from($table, $indexKey = null )
  {


    if ( is_object($table ) )
      $table = $table->getTable();

    if (!$indexKey )
      $indexKey = $table;

    $this->joinIndex[$indexKey] = true;

    $this->table = $table;
    return $this;

  } // end public function table */



  /**
   * setzten der Joinbedingungen
   *
   * @param array/string $src
   * @param string $srcField
   * @param string $target
   * @param string $targetField
   * @param string $where
   * @param string $alias
   * @return LibSqlCriteria
   */
  public function joinOn($src, $srcField, $target, $targetField, $where = null, $alias = null )
  {

    $key = $alias?$alias:$target;

    if ( isset($this->joinIndex[$key.'.'.$srcField] ) )
    {
      Log::warn( 'Tried to join an allready joined table, that can be an error' );
      return $this;
    } else {
      $this->joinIndex[$key.'.'.$srcField] = true;
    }


    $this->joinOn[] = array( null, $src, $srcField, $target, $targetField, $where, $alias );
    return $this;

  } // end public function joinOn */

  /**
   * setzten der Joinbedingungen
   *
   * @param string $sql
   * @param string $key
   *
   * @return LibSqlCriteria
   */
  public function specialJoin($sql, $key = null )
  {

    if ($key )
    {
      if ( isset($this->joinIndex[$key] ) )
      {
        Log::warn( 'Tried to join an allready joined table, that can be an error' );
        return $this;
      } else {
        $this->joinIndex[$key] = true;
      }
    }

    $this->joinOn[] = $sql;
    return $this;

  }//end public function specialJoin */

  /**
   * setzten der Joinbedingungen
   *
   * @param string $sql
   * @param string $key
   *
   * @return LibSqlCriteria
   */
  public function join($sql, $key = null )
  {

    if ($key )
    {
      if ( is_array($key ) )
      {
        foreach($key as $subKey )
        {
          $this->joinIndex[$subKey] = true;
        }
      } else {
        if ( isset($this->joinIndex[$key] ) )
        {
          Log::warn( 'Tried to join an allready joined table, that can be an error' );
          return $this;
        }
        else
        {
          $this->joinIndex[$key] = true;
        }
      }
    }

    $this->joinOn[] = $sql;
    return $this;

  }//end public function join */


  /**
   * setzten der Joinbedingungen
   *
   * @param string $sql
   * @return LibSqlCriteria
   */
  public function joinAcls($sql )
  {

    $this->joinOn[] = $sql;
    return $this;

  }//end public function joinAcls */

  /**
   * @param $src
   * @param $srcField
   * @param $target
   * @param $targetField
   * @param $where
   * @param $alias
   */
  public function leftJoinOn($src, $srcField, $target, $targetField, $where = null, $alias = null )
  {

    $key = $alias?$alias:$target;

    if ( isset($this->joinIndex[$key.'.'.$srcField] ) )
    {
      Log::warn( 'Tried to join an allready joined table, that can be an error' );
      return $this;
    } else {
      $this->joinIndex[$key.'.'.$srcField] = true;
    }

    $this->joinOn[] = array( 'LEFT', $src, $srcField, $target, $targetField, $where, $alias );
    return $this;

  } // end public function leftJoinOn */

  /**
   * @param $src
   * @param $srcField
   * @param $target
   * @param $targetField
   * @param $where
   * @param $alias
   */
  public function rightJoinOn($src, $srcField, $target, $targetField, $where = null, $alias = null )
  {

    $key = $alias?$alias:$target;

    if ( isset($this->joinIndex[$key.'.'.$srcField] ) )
    {
      Log::warn( 'Tried to join an allready joined table, that can be an error' );
      return $this;
    } else {
      $this->joinIndex[$key.'.'.$srcField] = true;
    }

    $this->joinOn[] = array( 'RIGHT', $src, $srcField, $target, $targetField, $where, $alias );
    return $this;

  } // end public function rightJoinOn */

  /**
   * Reihenfolge hinzufügen
   *
   * @param array $order
   * @return LibSqlCriteria
   */
  public function orderBy($order )
  {

    if ( is_array($order ) )
      $this->order = array_merge($this->order, $order );

    elseif ( is_string($order ) )
      $this->order[] = $order;
    else
      throw new LibDb_Exception( 'Added invalid parameter in order by '.gettype($order) );

    return $this;

  } // end public function orderBy */

  /**
   * Reihenfolge hinzufügen
   *
   * @param array $order
   * @return LibSqlCriteria
   */
  public function setOrderBy($order )
  {

    if ( is_array($order ) )
      $this->order = $order;

    elseif ( is_string($order ) )
      $this->order[] = array($order);
    else
      throw new LibDb_Exception( 'Added invalid parameter in order by '.gettype($order) );

    return $this;

  } // end public function setOrderBy */

  /**
   * Hinzufügen eines filters
   *
   * @param string $filter
   * @param string $connect
   * @return LibSqlCriteria
   */
  public function filter($filter , $connect = 'AND', $not = ''  )
  {

    if ( is_array($filter ) )
    {

      if (!$filter )
      {
        Log::warn
        (
          'Got empty filter variable. This should not happen as the developer should '
          .' first check if the filte is empty before adding an empty array in filter.'
        );
        return $this;
      }

      $filterCode = implode( ' OR ', $filter );

      if (!$this->filter )
        $this->filter = $not.' ( '.$filterCode.' )';

      else
        $this->filter .= ' '.$connect.' '.$not.' ( '.$filterCode.' )';
    } else {
      if (!$this->filter )
        $this->filter = $filter;

      else
        $this->filter .= ' '.$connect.' '.$not.' '.$filter;
    }

    return $this;

  } // end public function filter */

  /**
   * Hinzufügen eines filters
   *
   * @param string $filter
   * @param string $connect
   * @param string $not
   * @param string $blockConnect
   * @return LibSqlCriteria
   */
  public function filterBlock($block, $filter, $connect = 'AND', $not = '', $blockConnect = 'AND'   )
  {


    if (!isset($this->filtersBlocks[$block]) )
    {
      $this->filtersBlocks[$block] = array
      (
        'con'     => $blockConnect,
        'not'     => $not,
        'content' => $filter
      );
    } else {
      $this->filtersBlocks[$block]['content'] .= $connect.' '.$filter;
    }

    return $this;

  } // end public function filterBlock */

  /**
   * setzten der Where Bedingungen
   * wenn bereits eine bedingung gesetzt ist wird mit und verknüpft
   *
   * @param string $where
   * @param string $connect
   * @return LibSqlCriteria
   */
  public function where($where, $connect = 'AND' )
  {

    if (!$this->where )
      $this->where = $where;

    else
      $this->where .= ' '.$connect.' '.$where;

    return $this;

  } // end public function where */

  /**
   *
   * @param string $in
   * @param string $connect
   * @return LibSqlCriteria
   */
  public function whereIn($in, $connect = 'AND' )
  {

    if (!$in )
      return $this;

    $where =  $this->table.'.rowid  IN( '.implode(',',$in).' ) ';

    if (!$this->where )
      $this->where = $where;

    else
      $this->where .= ' '.$connect.' '.$where;

    return $this;

  } // end public function whereIn */

  /**
   *
   * @param string $in
   * @param string $connect
   *
   * @return LibSqlCriteria
   */
  public function whereNotIn($in, $connect = 'AND' )
  {

    if (!$in )
      return $this;

    $where =  $this->table.'.rowid NOT IN( '.implode(',',$in).' ) ';

    if (!$this->where)
      $this->where = $where;

    else
      $this->where .= ' '.$connect.' '.$where;

    return $this;

  } // end public function whereNotIn */

  /**
   * setzten der Where Bedingungen
   * wenn bereits eine bedingung gesetzt ist wird mit und verknüpft
   *
   * @param array $wheres
   * @param string $connect
   *
   * @return LibSqlCriteria
   */
  public function whereKeyHasValue($wheres, $connect = 'AND' )
  {

    $tmpWheres = array();

    foreach($wheres as $key => $value )
    {

      if (is_null($value) || trim($value) == '' )
      {
        $tmpWheres[] = ' '.$key.' IS NULL ';
      } else {
        $tmpWheres[] = ' '.$key.' = '.$value.' ';
      }

    }

    $where = implode( 'AND' , $tmpWheres );

    if ( '' != trim($where ) )
    {
      if (!$this->where )
        $this->where = $where;

      else
        $this->where .= ' '.$connect.' '.$where;
    }

    return $this;

  } // end public function whereKeyHasValue */

  /**
   * setzten der Where Bedingungen
   *
   * @param array $where
   *
   * @return LibSqlCriteria
   */
  public function andIs($where )
  {

    if (!$this->where )
      $this->where = $where;
    else
      $this->where .= ' AND '.$where;

    return $this;

  } // end public function andIs */

  /**
   * setzten der Where Bedingungen
   *
   * @param array $where
   * @return LibSqlCriteria
   */
  public function andNot($where )
  {

    if (!$this->where )
      $this->where =  ' NOT ( '.$where.' ) ';
    else
      $this->where .= ' AND NOT ( '.$where.' ) ';

    return $this;

  } // end public function andNot */

  /**
   * setzten der Where Bedingungen
   *
   * @param array $where
   * @return LibSqlCriteria
   */
  public function orIs($where )
  {

    if (!$this->where )
      $this->where =  $where;
    else
      $this->where .= ' OR ( '.$where.' ) ';

    return $this;

  }// end public function orIs */


  /**
   * setzten der Where Bedingungen
   *
   * @param array $where
   * @return LibSqlCriteria
   */
  public function orNot($where )
  {

    if (!$this->where )
      $this->where =  ' NOT ( '.$where.' ) ';
    else
      $this->where .= ' OR NOT ( '.$where.' ) ';

    return $this;

  }// end public function orNot */

/*//////////////////////////////////////////////////////////////////////////////
// Grouping
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Group By hinzufügen
   *
   * @param array $group
   * @return LibSqlCriteria
   */
  public function groupBy($group )
  {

    if ( is_array($group ) )
      $this->group = array_merge($this->group , $group );

    elseif ( is_string($group ) )
      $this->group[] = $group;

    return $this;

  }// end public function groupBy */

  /**
   * Group By hinzufügen
   *
   * @param array $group
   * @return LibSqlCriteria
   */
  public function setGroupBy($group )
  {

    if ( is_array($group ) )
      $this->group = $group;

    elseif ( is_string($group ) )
      $this->group = array($group );

    return $this;

  }// end public function setGroupBy */

/*//////////////////////////////////////////////////////////////////////////////
// Having
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Having By hinzufügen
   *
   * @param array $having
   * @return LibSqlCriteria
   */
  public function having($having )
  {

    if ( is_array($having ) )
      $this->having = array_merge($this->having , $having );

    elseif ( is_string($having ) )
      $this->having[] = $having;

    return $this;

  }// end public function having */

  /**
   * Having By hinzufügen
   *
   * @param array $having
   * @return LibSqlCriteria
   */
  public function setHaving($having )
  {

    if ( is_array($having ) )
      $this->having = $having;

    elseif ( is_string($having ) )
      $this->having = array($having ) ;

    return $this;

  }// end public function setHaving */

/*//////////////////////////////////////////////////////////////////////////////
// Limit & Offset
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * setzten von Limit und Offset
   *
   * @param int $Limit Anzahl Abfrage Erfgebnisse die gewünscht werden
   * @return LibSqlCriteria
   */
  public function limit($limit )
  {

    $this->limit = $limit;
    return $this;

  }// end public function limit */

  /**
   * setzten von Limit und Offset
   *
   * @param int $offset Optional Offset, Ab wo soll weiter ausgegeben werden
   * @return LibSqlCriteria
   */
  public function offset($offset )
  {

    $this->offset = $offset;
    return $this;

  }// end public function offset */

/*//////////////////////////////////////////////////////////////////////////////
// filter
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param LibSqlFilter $filter
   */
  public function addFilter($filter )
  {

    $this->filters[] = $filter;

  }//end public function addFilter */

/*//////////////////////////////////////////////////////////////////////////////
// prepare
//////////////////////////////////////////////////////////////////////////////*/

 /**
   * setzten von Limit und Offset
   *
   * @param int $Limit Anzahl Abfrage Erfgebnisse die gewünscht werden
   * @param int $Offset Optional Offset, Ab wo soll weiter ausgegeben werden
   * @return LibSqlCriteria
   */
  public function prepare($name )
  {
    $this->name = $name;
    return $this;

  }// end public function prepare */

/*//////////////////////////////////////////////////////////////////////////////
// Sql Parser Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * das generiert sql zurückgeben
   * @return string
   */
  public function getSql()
  {

    return $this->sql;

  }//end public function getSql */

  /**
   * @param LibParserSqlAbstract $queryBuilder
   *
   * @return string
   */
  public function build($queryBuilder = null )
  {

    if (!$queryBuilder )
      $queryBuilder = $this->db->orm->getQueryBuilder();

    $this->sql = $queryBuilder->buildSelect($this );
    return $this->sql;

  }//end public function build */


}//end class LibSqlCriteria

