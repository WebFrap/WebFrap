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
 *
 */
abstract class TSuperglobalAbstract
  extends TObject
  implements ArrayAccess, Iterator, Countable
{

////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   *
   * @var RequestAbstract
   */
  protected $request = array();

  /**
   *
   * @var array
   */
  protected $pool = array();

////////////////////////////////////////////////////////////////////////////////
// Interface: ArrayAccess
////////////////////////////////////////////////////////////////////////////////

  public function offsetSet($offset, $value)
  {
    $this->pool[$offset] = $value;
  }//end public function offsetSet($offset, $value)

  public function offsetGet($offset)
  {
    return $this->pool[$offset];
  }//end public function offsetGet($offset)

  public function offsetUnset($offset)
  {
    unset($this->pool[$offset]);
  }//end public function offsetUnset($offset)

  public function offsetExists($offset)
  {
    return isset($this->pool[$offset])?true:false;
  }//end public function offsetExists($offset)

////////////////////////////////////////////////////////////////////////////////
// Interface: Iterator
////////////////////////////////////////////////////////////////////////////////

  public function current ()
  {
    return current($this->pool);
  }//end public function current ()

  public function key ()
  {
    return key($this->pool);
  }//end public function key ()

  public function next ()
  {
    return next($this->pool);
  }//end public function next ()

  public function rewind ()
  {
    reset($this->pool);
  }//end public function rewind ()

  public function valid ()
  {
    return current($this->pool)? true:false;
  }//end public function valid ()

////////////////////////////////////////////////////////////////////////////////
// Interface: Countable
////////////////////////////////////////////////////////////////////////////////

  public function count()
  {
    return count($this->pool);
  }//end public function count()

////////////////////////////////////////////////////////////////////////////////
// Logic
////////////////////////////////////////////////////////////////////////////////

  public function dump()
  {
    return $this->pool;
  }

  /**
   * getter for Superglobal Object
   *
   * @param string/array $key
   * @param string $validator
   * @param string $subkey
   */
  public abstract function get($key = null , $validator = null, $subkey = null );

  /**
   * adder for Superglobal Object
   *
   * @param string/array $key
   * @param string/array $value
   * @param string $subkey
   */
  public abstract function add($key, $value = null , $subkey  = null );

  /**
   * check if a value exists
   *
   * @param string/array $key
   * @param string $subkey
   */
  public abstract function exists($key, $subkey = null);


}//end abstract class TSuperglobalAbstract

