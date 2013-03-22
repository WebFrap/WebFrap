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
 * Ein Array Objekt für Simple Daten
 * @package WebFrap
 * @subpackage tech_core
 */
class TArray implements ITObject, Iterator, Countable
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * the array data body for the Array Object
   * @var array
   */
  protected $pool = array();

  /**
   * @var int
   */
  protected $autoPointer = 0;

/*//////////////////////////////////////////////////////////////////////////////
// Magic Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Standard Konstruktor
   * Nimmt beliebig viele Elemente oder einen einzigen Array
   */
  public function __construct()
  {

    if ($anz = func_num_args()) {
      if ($anz == 1 and is_array(func_get_arg(0))) {
        $this->pool = func_get_arg(0);
      } else {
        // hier kommt auf jeden fall ein Array
        $this->pool = func_get_args();
      }
    }

  }//end public function __construct */

  /**
   * Zugriff Auf die Elemente per magic set
   * @param string $key
   * @param mixed $value
   */
  public function __set($key , $value)
  {

    if (is_null($key)) {
      $key = $this->autoPointer;
      ++ $this->autoPointer;
    }

    $this->pool[$key] = $value;

  }// end of public function __set */

  /**
   * Zugriff Auf die Elemente per magic get
   *
   * @param string $key
   * @return mixed
   */
  public function __get($key)
  {
    return isset($this->pool[$key])?$this->pool[$key]:null;
  }// end of public function __get */

/*//////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return string
   */
  public function content()
  {

    if (func_num_args()  ) {
      if (is_array(func_get_arg(0))) {
        $this->pool = func_get_arg(0);
      }
    } else {
      return $this->pool;
    }

  }//end public function content

/*//////////////////////////////////////////////////////////////////////////////
// Interface: ArrayAccess
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @see ArrayAccess:offsetSet
   */
  public function offsetSet($offset, $value)
  {

    if (is_null($offset))
      $this->pool[] = $value;
    else
      $this->pool[$offset] = $value;

  }//end public function offsetSet */

  /**
   * @see ArrayAccess:offsetGet
   */
  public function offsetGet($offset)
  {
    return isset($this->pool[$offset])
      ? $this->pool[$offset]
      : null ;

  }//end public function offsetGet */

  /**
   * @see ArrayAccess:offsetUnset
   */
  public function offsetUnset($offset)
  {
    unset($this->pool[$offset]);
  }//end public function offsetUnset */

  /**
   * @see ArrayAccess:offsetExists
   */
  public function offsetExists($offset)
  {
    return isset($this->pool[$offset])?true:false;
  }//end public function offsetExists */

/*//////////////////////////////////////////////////////////////////////////////
// Interface: Iterator
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @see Iterator::current
   */
  public function current ()
  {
    return current($this->pool);
  }//end public function current */

  /**
   * @see Iterator::key
   */
  public function key ()
  {
    return key($this->pool);
  }//end public function key */

  /**
   * @see Iterator::next
   */
  public function next ()
  {
    return next($this->pool);
  }//end public function next */

  /**
   * @see Iterator::rewind
   */
  public function rewind ()
  {
    reset($this->pool);
  }//end public function rewind */

  /**
   * @see Iterator::valid
   */
  public function valid ()
  {
    return current($this->pool)? true:false;
  }//end public function valid */

/*//////////////////////////////////////////////////////////////////////////////
// Interface: Countable
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @see Countable::count
   */
  public function count()
  {
    return count($this->pool);
  }//end public function count */

/*//////////////////////////////////////////////////////////////////////////////
// methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   */
  public function append($entry)
  {
    ++$this->autoPointer;
    $this->pool[] = $entry;
  }//end public function append */

  /**
   * @return array
   */
  public function asArray()
  {
    return $this->pool;
  }//end public function asArray */

  /**
   * @param string $key
   */
  public function exists($key)
  {
    return array_key_exists($key , $this->pool);
  }//end public function exists */

  /**
   * @param string $glue
   * @return string
   */
  public function implode($glue = '')
  {
    return implode($glue , $this->pool);
  }//end public function implode */

  /**
   * @return array
   */
  public function keys()
  {
    return array_keys($this->pool);
  }//end public function keys */

/*//////////////////////////////////////////////////////////////////////////////
// methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $obj
   * @param string $values
   * @return TArray
   */
  public static function def($obj, $values)
  {

    if (!$obj) {
      return new TArray($values);
    } else {
      foreach ($values as $key => $val) {
        if (!$obj->exists($key))
          $obj->$key = $val;
      }

      return $obj;
    }

  }//end public static function def

  /**
   * @return string
   */
  public function toJson()
  {
    return json_encode($this->pool);
  }//end public function toJson */

}//end class TArray

