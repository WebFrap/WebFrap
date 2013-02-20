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
 * Collection to fetch result and bundle them
 *
 * @package WebFrap
 * @subpackage tech_core
 */
abstract class LibSqlQuery
  implements Iterator, Countable
{
/*//////////////////////////////////////////////////////////////////////////////
// Konstanten
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var int
   */
  const SOURCE_KEY  = 0;

  /**
   * @var int
   */
  const FIELD       = 1;

  /**
   * @var int
   */
  const OPERATOR    = 2;

  /**
   * @var int
   */
  const VALUE       = 3;

  /**
   * @var int
   */
  const CONDITION   = 4;

  /**
   * @var int
   */
  const NOT         = 5;

  /**
   * @var int
   */
  const CASE_SENSITIVE  = 6;

  /**
   * @var int
   */
  const HEAD        = 7;

/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * conditions
   * @var scalar/array
   */
  public $condition = null;

  /**
   * conditions
   * @var array
   *   sourceKey
   *     table name
   *   field
   *     field name
   *   operator
   *     equals
   *     start_width
   *     end_width
   *     like
   *     in
   *     between
   *     smaller
   *     smaller_or_equal
   *     bigger
   *     bigger_or_equal
   *  value
   *    the value
   *   not
   *     true/false
   *   condition
   *     and
   *     or
   *  case_sensitiv
   *    true/false/null
   *   head
   */
  public $extendedConditions = array();

  /**
   * @var array
   */
  public $cols = array();

  /**
   * Wird benötigt wenn die Daten zb. generisch z.B in einen Export geschrieben
   * werden
   *
   * @var array
   */
  public $structure = array();

  /**
   * Flag ob diese Query eine distinct query ist..
   * @var boolean
   */
  public $distinct = false;

/*//////////////////////////////////////////////////////////////////////////////
// Protected Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @var LibDbResult
   */
  protected $result = null;

  /**
   * variable to store the fetched data if directly loaded
   * @var array
   */
  protected $data = null;

  /**
   * number of matched results in the result source
   *
   * @var int
   */
  protected $sourceSize = null;

  /**
   * the actual query object
   *
   * @var LibSqlCriteria
   */
  protected $criteria = null;

  /**
   * the clousure for calculating the size
   * @var LibSqlCriteria
   */
  protected $calcQuery = null;

  /**
   * this variable is used to store tempory data for joins, which can be accessed
   * in the fetch methodes an to a join
   * @var array
   */
  protected $addJoins = array();

  /**
   * Cache für die Anzahl der gefundenen Einträge
   * @var int
   */
  protected $size = null;

  /**
   * Liste mit allen IDs
   * @var array
   */
  protected $ids = null;

/*//////////////////////////////////////////////////////////////////////////////
// injectable object
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * the actual query object
   *
   * @var LibDbConnection
   */
  protected $db = null;

  /**
   * the actual query object
   *
   * @var User
   */
  protected $user = null;

  /**
   * de:
   * Der für dieses Query Objekt zuständige Adapter für den Zugriff auf die ACLs
   *
   * @var LibAclAdapter
   */
  protected $acl = null;

/*//////////////////////////////////////////////////////////////////////////////
// Magic
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param array $condition
   * @param LibDbConnection $db
   */
  public function __construct($condition = null, $db = null )
  {
    if (!is_null($condition) )
      $this->condition = $condition;

    $this->db = $db;

    if ( DEBUG )
      Debug::console('created new query '.get_class($this));

  }//end public function __construct */

/*//////////////////////////////////////////////////////////////////////////////
// inject getter + setter
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param User $user
   */
  public function setUser($user )
  {
    $this->user = $user;
  }//end public function setUser */

  /**
   * @return User
   */
  public function getUser()
  {
    if (!$this->user)
      $this->user = User::getActive();

    return $this->user;
  }//end public function getUser */

  /**
   * @param LibAclAdapter $acl
   */
  public function setAcl($acl )
  {
    $this->user = $acl;
  }//end public function setAcl */

  /**
   * @return LibAclAdapter
   */
  public function getAcl()
  {
    if (!$this->acl)
      $this->acl = Acl::getActive();

    return $this->acl;
  }//end public function getAcl */

/*//////////////////////////////////////////////////////////////////////////////
// Logic
///////////////////////////////////////s/////////////////////////////////////////

  /**
   *
   * @param LibSqlFilter $queryPart
   * @param TFlowFlag $params
   */
  public function inject($queryPart, $params )
  {

    if (!$this->criteria )
      $this->criteria = $this->getDb()->orm->newCriteria();

    $queryPart->inject($this->criteria, $params );

  }//end public function inject */

  /**
   *
   * @param string/array $condition
   */
  public function setCondition($condition )
  {
    $this->condition  = $condition;
  }//end public function setCondition */

  /**
   *
   * @return string/array
   */
  public function getCondition(  )
  {
    return $this->condition;
  }//end public function getCondition */

  /**
   * leeren des results
   */
  public function clean()
  {
    $this->result = null;
    $this->sourceSize = null;
  }//end public function clean */

  /**
   * get the size of the last query
   * @return int
   */
  public function getSize()
  {
    if (!is_null($this->size) )
      return $this->size;

   return $this->result->count();

  }//end public function getSize */

  /**
   * get the size of the last query that should have been given back
   * if there was no offset and no limit
   *
   * @return int
   */
  public function getSourceSize()
  {

    if (is_null($this->sourceSize) ) {
      if (!$this->calcQuery )
        return null;

      if ( is_string($this->calcQuery) ) {
        if ($res = $this->getDb()->select($this->calcQuery ) ) {
          $tmp = $res->get();

          if (!isset($tmp[Db::Q_SIZE])) {

            if (DEBUG)
              Debug::console('got no Db::Q_SIZE');

            $this->sourceSize = 0;
          } else {
            $this->sourceSize = $tmp[Db::Q_SIZE];
          }

        }
      } else {
        if ($res = $this->getDb()->getOrm()->select($this->calcQuery ) ) {
          $tmp =  $res->get();

          if (!isset($tmp[Db::Q_SIZE])) {
            if (DEBUG)
              Debug::console('got no Db::Q_SIZE');

            $this->sourceSize = 0;
          } else {
            $this->sourceSize = $tmp[Db::Q_SIZE];
          }
        }
      }

    }

    return $this->sourceSize;

  }//end public function getSourceSize */

  /**
   * @param int $sourceSize
   */
  public function setSourceSize($sourceSize )
  {
    $this->sourceSize = $sourceSize;
  }//end public function setSourceSize */

  /**
   * request one single row from the database
   *
   * @return array
   */
  public function get()
  {

    if ($this->result)
      return $this->result->get();
    else
      return array();

  }//end public function get */

  /**
   * request one single row from the database
   *
   * @return array
   */
  public function getField($fieldKey )
  {

    if ($this->result)
      return $this->result->getField($fieldKey );
    else
      return array();

  }//end public function getField */

  /**
   * fetch all rows from the database
   * @return array
   */
  public function getAll()
  {

    if (is_array($this->data ))
      return $this->data;
    else if (is_array($this->result ))
      return $this->result; // dirty quickfix for a generator issue
    else if ($this->result)
      return $this->result->getAll();
    else
      return array();

  }//end public function getAll */

  /**
   * load the data an store it
   * @return array
   */
  public function load()
  {

    if ($this->result)
      $this->data = $this->result->getAll();
    else
      $this->data = array();

  }//end public function loadData */

  /**
   * load the data an store it
   * @param string $key
   * @param boolean $noEmpty
   *
   * @return array
   */
  public function getColumn($key, $noEmpty = false )
  {

    if (is_null($this->data) )
      $this->load();

    $columns = array();

    if ($noEmpty) {
      foreach ($this->data as $row) {

        if ( isset($row[$key] ) && '' != trim($row[$key])  ) {
          $columns[] = $row[$key];
        }

      }
    } else {
      foreach ($this->data as $row) {

        if ( isset($row[$key] ) ) {
          $columns[] = $row[$key];
        }

      }
    }

    return $columns;

  }//end public function getColumn */

  /**
   * Render der extended Conditions
   *
   * @param LibSqlCriteria $criteria
   * @param array $extConds
   *
   * @return array
   */
  public function renderExtendedConditions($criteria, $extConds  )
  {

    foreach ($extConds as $extCond) {

      if ( is_object($extCond ) ) {

        $checkOp = isset($extCond->checkOp  )
          ? ' '.strtoupper($extCond->checkOp ).' '
          : ' AND ';

        $qOp = isset($extCond->queryOp  )
          ? strtoupper($extCond->queryOp )
          : 'AND';

        $tmp = array();

        foreach ($extCond->checks as $subCond) {
          $tmp[] = $this->renderExtendedCondition($subCond );
        }

        $sql = ' ( '.implode($checkOp, $tmp).' ) ';
        $criteria->where($sql, $qOp );
      } else {

        $sql = $this->renderExtendedCondition($extCond );

        $cond = isset($extCond[self::CONDITION] )
          ? strtoupper($extCond[self::CONDITION])
          : 'AND';

        $criteria->where($sql, $cond );
      }

    }

  }//end public function renderExtendedConditions */

  /**
   * Render der extended Condition
   *
   * @param array $extConds
   *
   * @return array
   */
  public function renderExtendedCondition($extCond  )
  {

    $sql = '';

    $isCS = ( isset($extCond[self::CASE_SENSITIVE] ) && $extCond[self::CASE_SENSITIVE] );

    $sql .= isset($extCond[self::NOT] ) && $extCond[self::NOT]
      ? ' NOT '
      : '';

    if ($isCS) {
      $sql .= 'UPPER('.$extCond[self::SOURCE_KEY].'.'.$extCond[self::FIELD].')';
    } else {
      $sql .= $extCond[self::SOURCE_KEY].'.'.$extCond[self::FIELD];
    }

    if ('in' != $extCond[self::OPERATOR]) {
      $value = $this->db->addSlashes($extCond[self::VALUE]);
    } else {
      $value = $extCond[self::VALUE];
    }

    switch ($extCond[self::OPERATOR]) {
      case 'equals':
      {
        if ($isCS )
          $sql .= " = UPPER('{$value}') ";
        else
          $sql .= " = '{$value}' ";

        break;
      }
      case 'null':
      {
        $sql .= " IS NULL ";
        break;
      }
      case 'like':
      {
        if ($isCS )
          $sql .= " like UPPER('%{$value}%') ";
        else
          $sql .= " like '%{$value}%' ";

        break;
      }
      case 'start_with':
      {
        if ($isCS )
          $sql .= " like UPPER('{$value}%') ";
        else
          $sql .= " like '{$value}%' ";

        break;
      }
      case 'end_with':
      {
        if ($isCS )
          $sql .= " like UPPER('%{$value}') ";
        else
          $sql .= " like '%{$value}' ";

        break;
      }
      case 'in':
      {

        if ( is_array($value) ) {

          $tmp = array();

          if ($isCS) {

            foreach ($value as $vNode) {
              $tmp[] = "UPPER('".$this->db->addSlashes($vNode)."')";
            }

            $sql .= " IN(".implode( ', ', $tmp ).") ";
          } else {
            $sql .= " IN('".implode( "', '", $value )."') ";
          }
        } else {
          $sql .= " IN( {$value} ) ";
        }

        break;
      }
      default:
      {
        throw new LibDb_Exception( "Got nonsupported extended condition operator: ".$extCond[self::OPERATOR] );
      }

    }

    return $sql;

  }//end public function renderExtendedCondition */

  /**
   * load the database Object
   * @return LibDbConnection
   */
  protected function getDb()
  {

    if (!$this->db)
      $this->db = Db::getActive();

    return  $this->db;

  }//end public function getDb */

  /**
   * load the database Object
   * @return LibDbConnection
   */
  protected function getOrm()
  {

    if (!$this->db)
      $this->db = Db::getActive();

    return  $this->db->getOrm();

  }//end public function getDb */

  /**
   * get the size of the last query
   * @return int
   */
  public function getIds()
  {
   return $this->ids;

  }//end public function getIds */

/*//////////////////////////////////////////////////////////////////////////////
// Interface: Iterator
//////////////////////////////////////////////////////////////////////////////*/

  ///TODO Checken ob das wieder korrekt umgestellt werden kann

  /**
   */
  public function current ()
  {
    if (is_array($this->data))
      return current($this->data);

    if ($this->result)
      return $this->result->current();

  }//end public function current */

  /**
   */
  public function key ()
  {
    if (is_array($this->data))
      return key($this->data);

    if ($this->result)
      return $this->result->key();
  }//end public function key */

  /**
   */
  public function next ()
  {

    if (is_array($this->data))
      return next($this->data);

    if ($this->result)
      return $this->result->next();

  }//end public function next */

  /**
   */
  public function rewind ()
  {

    if (is_array($this->data))
      return reset($this->data);

    if ($this->result)
      $this->result->rewind();

  }//end public function rewind */

  /**
   */
  public function valid ()
  {

    if (is_array($this->data))
      return current($this->data)? true:false;

    if ($this->result)
      return $this->result->valid();

  }//end public function valid */

/*//////////////////////////////////////////////////////////////////////////////
// Interface: Countable
//////////////////////////////////////////////////////////////////////////////*/

  /**
   */
  public function count()
  {

    if (is_array($this->data))
      return count($this->data);

    return count($this->result);

  }//end public function count */

}//end abstract class LibSqlQuery
