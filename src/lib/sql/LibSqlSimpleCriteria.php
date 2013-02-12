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
class LibSqlSimpleCriteria
  implements ISqlParser
{
////////////////////////////////////////////////////////////////////////////////
// const
////////////////////////////////////////////////////////////////////////////////

  const JOIN_TYPE     = 0;

  const SRC           = 1;
  const SRC_FIELD     = 2;

  const TARGET        = 3;
  const TARGET_FIELD  = 4;

  const WHERE         = 5;
  const TARGET_ALIAS  = 6;

////////////////////////////////////////////////////////////////////////////////
// attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * Felder die abgefragt werden sollen
   * @var array
   */
  public $cols      = null;

  /**
   *
   * @var string
   */
  public $table     = null;

  /**
   * Joinbedingungen
   * @var array
   */
  public $joinOn    = array();

  /**
   * Joinbedingungen
   * @var array
   */
  public $joinIndex    = array();

  /**
   * Limit der Abfrage
   * @var int
   */
  public $limit     = null;

  /**
   * Offset der Abfrage
   * @var int
   */
  public $offset    = null;

  /**
   * Group by Parameter
   * @var array
   */
  public $group     = array();

  /**
   * @var array
   */
  public $having    = array();

  /**
   * Die Wherebedingungen
   * @var string
   */
  public $where     = null;

  /**
   * Oder Reihenfolge
   * @var array
   */
  public $order     = array();

  /**
   * the values
   * @var array
   */
  public $values     = array();

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

////////////////////////////////////////////////////////////////////////////////
// Constructor and Magic Functions
////////////////////////////////////////////////////////////////////////////////

  /**
   * Standardkonstruktor bekommt den Namen der Query übergeben
   *
   * @param string Name Name der Query
   * @param bool[optional] Prepare Soll die Anfrage erst mit
   *   Prepare in die Datenbank und dann mit Execute abgefragt
   * @param bool[optional] Cache Kann gecached werden
   * @return void
   */
  public function __construct( $name )
  {
    $this->name = $name;
  } // end public function __construct */

  /**
   *
   */
  public function __toString()
  {
    try {
      if(!$this->sql)
        $this->build();
    } catch ( LibDb_Exception $e ) {
      // return an empty query to no provocate an php error
      return '';
    }

    return $this->sql;
  }//end public function __toString */

////////////////////////////////////////////////////////////////////////////////
// insert and update methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * Abfragefelder hinzufuegen
   *
   * @param array $values
   * @return booleane
   */
  public function values( $values )
  {

    if( is_array( $values ) )
      $this->values = array_merge( $this->values , $values );

    return $this;

  } // end public function values */

  /**
   * setzten der Tables die abgefragt werden sollen
   *
   * @param string $table
   * @return LibSqlCriteria
   */
  public function table( $table )
  {
    $this->table = $table;

    return $this;
  } // end public function table */

////////////////////////////////////////////////////////////////////////////////
// Criteria Methods
////////////////////////////////////////////////////////////////////////////////

  /**
   * setzten ob es eine Singelrow oder Multirow Query ist
   *
   * @param bool Single
   * @return
   */
  public function single( $single = true )
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
  public function count( $cols = array( Db::PK ) )
  {

    $this->cols = array($cols) ;

    // unnötige daten entfernen
    $this->limit  = null; // limit und offset müssen weg um die gesamtsumme zu bekommen
    $this->offset = null;
    $this->order  = null;

    return $this;
  } // end public function count */

  /**
   *
   * Enter description here ...
   * @param string $key
   */
  public function isJoined( $key )
  {
    return isset( $this->joinIndex[$key] );
  }//end public function isJoined */

  /**
   * setzten der abzufragenden Felder
   *
   * @param array/string $cols Die abzufragenden Cols
   * @return LibSqlCriteria
   */
  public function select( $cols )
  {

    if( is_array( $cols ) )
      $this->cols = $cols;

    else if( is_string($cols) )
      $this->cols = array($cols);

    return $this;
  } // end public function setCols */

  /**
   * Abfragefelder hinzufuegen
   *
   * @param array/string $cols the cols to add to the query
   * @return LibSqlCriteria
   */
  public function selectAlso( $cols )
  {

    if( is_array( $cols ) )
      $this->cols = array_merge( $this->cols , $cols );

    else if( is_string($cols) )
      $this->cols[] = $cols;

    return $this;
  } // end public function selectAlso */

  /**
   * setzten der Tables die abgefragt werden sollen
   *
   * @param string $table
   * @return LibSqlCriteria
   */
  public function from( $table )
  {

    $this->joinIndex[$table] = true;

    $this->table = $table;

    return $this;
  } // end public function table */

  /**
   * setzten der Joinbedingungen
   *
   * @param array/string $table
   * @param string[optional] $on
   * @param string[optional] $type
   * @param string[optional] $where
   * @return LibSqlCriteria
   */
  public function joinOn( $src, $srcField, $target, $targetField, $where = null, $alias = null )
  {

    $key = $alias?$alias:$target;

    if ( isset( $this->joinIndex[$key] ) ) {
      Log::warn('tried to join an allready joined table, that can be an error');

      return $this;
    } else {
      $this->joinIndex[$key] = true;
    }

    $this->joinOn[] = array( null, $src, $srcField, $target, $targetField, $where, $alias );

    return $this;

  } // end public function joinOn */

  /**
   * setzten der Joinbedingungen
   *
   * @param string $sql
   * @return LibSqlCriteria
   */
  public function specialJoin( $sql, $key = null )
  {

    if ($key) {
      if ( isset( $this->joinIndex[$key] ) ) {
        Log::warn('tried to join an allready joined table, that can be an error');

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
   * @return LibSqlCriteria
   */
  public function join( $sql, $key = null )
  {

    if ($key) {
      if ( is_array($key) ) {
        foreach ($key as $subKey) {
          $this->joinIndex[$subKey] = true;
        }
      } else {
        if ( isset( $this->joinIndex[$key] ) ) {
          Log::warn('tried to join an allready joined table, that can be an error');

          return $this;
        } else {
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
  public function joinAcls( $sql )
  {

    $this->joinOn[] = $sql;

    return $this;

  }//end public function joinAcls */

  /**
   *
   */
  public function leftJoinOn( $src, $srcField, $target, $targetField, $where = null, $alias = null )
  {

    $key = $alias?$alias:$target;

    if ( isset( $this->joinIndex[$key] ) ) {
      Log::warn('tried to join an allready joined table, that can be an error');

      return $this;
    } else {
      $this->joinIndex[$key] = true;
    }

    $this->joinOn[] = array( 'LEFT', $src, $srcField, $target, $targetField, $where, $alias );

    return $this;

  } // end public function leftJoinOn */

  /**
   *
   */
  public function rightJoinOn( $src, $srcField, $target, $targetField, $where = null, $alias = null )
  {

    $key = $alias?$alias:$target;

    if ( isset( $this->joinIndex[$key] ) ) {
      Log::warn('tried to join an allready joined table, that can be an error');

      return $this;
    } else {
      $this->joinIndex[$key] = true;
    }

    $this->joinOn[] = array( 'RIGHT', $src, $srcField, $target, $targetField, $where, $alias );

    return $this;

  } // end public function rightJoinOn */

  /**
   * Reihenfolge hinzufügen
   *
   * @param array Order
   * @return LibSqlCriteria
   */
  public function orderBy( $order )
  {

    if( is_array($order) )
      $this->order = $order;

    elseif( is_string( $order ) )
      $this->order = array( $order );

    return $this;

  } // end public function orderBy */

  /**
   * setzten der Where Bedingungen
   * wenn bereits eine bedingung gesetzt ist wird mit und verknüpft
   *
   * @param array Where
   * @return LibSqlCriteria
   */
  public function where( $where  , $connect = 'and' )
  {

    if(!$this->where)
      $this->where = $where;

    else
      $this->where .= ' '.$connect.' '.$where;

    return $this;

  } // end public function where */

  /**
   *
   * @param $in
   * @param $connect
   * @return unknown_type
   */
  public function whereIn( $in  , $connect = 'and' )
  {

    if(!$in)

      return $this;

    $where =  $this->table.'.'.WBF_DB_KEY.'  IN( '.implode(',',$in).' ) ';

    if(!$this->where)
      $this->where = $where;

    else
      $this->where .= ' '.$connect.' '.$where;

    return $this;

  } // end public function whereIn */

  /**
   *
   * @param $in
   * @param $connect
   * @return unknown_type
   */
  public function whereNotIn( $in  , $connect = 'and' )
  {

    if(!$in)

      return $this;

    $where =  $this->table.'.'.WBF_DB_KEY.' NOT IN( '.implode(',',$in).' ) ';

    if(!$this->where)
      $this->where = $where;

    else
      $this->where .= ' '.$connect.' '.$where;

    return $this;
  } // end public function whereIn */

  /**
   * setzten der Where Bedingungen
   * wenn bereits eine bedingung gesetzt ist wird mit und verknüpft
   *
   * @param array Where
   * @return LibSqlCriteria
   */
  public function whereKeyHasValue( $wheres  , $connect = 'and' )
  {

    $tmpWheres = array();

    foreach ($wheres as $key => $value) {
      if ( is_null($value) || trim($value) == '' ) {
        $tmpWheres[] = ' '.$key.' IS NULL ';
      } else {
        $tmpWheres[] = ' '.$key.' = '.$value.' ';
      }

    }

    $where = implode( 'and' , $tmpWheres );

    if ( '' != trim( $where ) ) {
      if(!$this->where)
        $this->where = $where;

      else
        $this->where .= ' '.$connect.' '.$where;
    }

    return $this;
  } // end public function whereKeyHasValue */

  /**
   * setzten der Where Bedingungen
   *
   * @param array Where
   * @return LibSqlCriteria
   */
  public function andIs( $where )
  {

    if(!$this->where)
      $this->where = $where;
    else
      $this->where .= ' and '.$where;

    return $this;
  } // end public function andIs

  /**
   * setzten der Where Bedingungen
   *
   * @param array Where
   * @return LibSqlCriteria
   */
  public function andNot( $where )
  {

    if(!$this->where)
      $this->where =  ' not '.$where;
    else
      $this->where .= ' and not '.$where;

    return $this;
  } // end public function andNot */

  /**
   * setzten der Where Bedingungen
   *
   * @param array Where
   * @return LibSqlCriteria
   */
  public function orIs( $where )
  {

    if(!$this->where)
      $this->where =  $where;
    else
      $this->where .= ' or '.$where;

    return $this;
  } // end public function orIs */

  /**
   * setzten der Where Bedingungen
   *
   * @param array Where
   * @return LibSqlCriteria
   */
  public function orNot( $where )
  {

    if(!$this->where)
      $this->where =  ' or '.$where;
    else
      $this->where .= ' or not '.$where;

    return $this;
  } // end public function orNot */

  /**
   * Group By hinzufügen
   *
   * @param array Group
   * @return LibSqlCriteria
   */
  public function groupBy( $group )
  {

    if( is_array( $group ) )
      $this->group = array_merge( $this->group , $group );

    elseif( is_string($group) )
      $this->group = array($group);

    return $this;
  } // end public function groupBy */

  /**
   * Having By hinzufügen
   *
   * @param array Having
   * @return LibSqlCriteria
   */
  public function having( $having )
  {

    if( is_array( $having ) )
      $this->having = array_merge( $this->having , $having );

    elseif( is_string($having) )
      $this->having = array($having);

    return $this;
  } // end public function having */

  /**
   * setzten von Limit und Offset
   *
   * @param int $Limit Anzahl Abfrage Erfgebnisse die gewünscht werden
   * @param int $Offset Optional Offset, Ab wo soll weiter ausgegeben werden
   * @return LibSqlCriteria
   */
  public function limit( $limit )
  {
    $this->limit = $limit;

    return $this;
  } // end public function limit */

  /**
   * setzten von Limit und Offset
   *
   * @param int $Limit Anzahl Abfrage Erfgebnisse die gewünscht werden
   * @param int $Offset Optional Offset, Ab wo soll weiter ausgegeben werden
   * @return LibSqlCriteria
   */
  public function offset( $offset )
  {
    $this->offset = $offset;

    return $this;
  } // end public function offset */

 /**
   * setzten von Limit und Offset
   *
   * @param int $Limit Anzahl Abfrage Erfgebnisse die gewünscht werden
   * @param int $Offset Optional Offset, Ab wo soll weiter ausgegeben werden
   * @return LibSqlCriteria
   */
  public function prepare( $name )
  {
    $this->name = $name;

    return $this;
  } // end public function prepare */

////////////////////////////////////////////////////////////////////////////////
// Sql Parser Methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * das generiert sql zurückgeben
   * @return string
   */
  public function getSql()
  {
    return $this->sql;
  }//end public function getSql */

  /**
   *
   * @return string
   */
  public function build( $db = null )
  {

    if(!$db)
      $db = Db::getParser();

    $this->sql = $db->buildSelect($this);

    return $this->sql;

  }//end public function build */

}//end class LibSqlCriteria
