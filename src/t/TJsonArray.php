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
 * Json Array,
 * erlaub nur intwerte als index
 *
 * @package WebFrap
 * @subpackage tech_core
 *
 */
class TJsonArray
  implements ArrayAccess, Iterator, Countable
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
   *
   * Enter description here ...
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
  public function __construct( )
  {

    if( $anz = func_num_args() )
    {
      if( $anz == 1 and is_array(func_get_arg(0)) )
      {
        $this->pool = func_get_arg(0);
      }
      else
      {
        // hier kommt auf jeden fall ein Array
        $this->pool = func_get_args();
      }
    }

  }//end public function __construct */

  /**
   * @return string
   */
  public function __toString()
  {

    $assembled = array();

    foreach( $this->pool as $value )
    {
      if( is_object($value) )
      {
        $jsValue = (string)$value;
      }
      elseif( is_bool($value) )
      {
        $jsValue = $value?'true':'false';
      }
      elseif( is_numeric($value) )
      {
        $jsValue = $value;
      }
      else
      {
        $jsValue = '"'.str_replace(array('"','\\',"\n"), array('\"','\\\\',"\\n"), (string)$value).'"';
      }

      $assembled[] = $jsValue;
    }

    return '['.implode( ',', $assembled ).']';

  }//end public function __toString */

/*//////////////////////////////////////////////////////////////////////////////
// Interface: ArrayAccess
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @see ArrayAccess:offsetSet
   */
  public function offsetSet($offset, $value)
  {

    if( is_null($offset) )
      $this->pool[] = $value;
    else
      $this->pool[$offset] = $value;

  }//end public function offsetSet */

  /**
   * @see ArrayAccess:offsetGet
   */
  public function offsetGet($offset)
  {
    return $this->pool[$offset];
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
   * @param mixed $entry
   */
  public function append( $entry )
  {
    ++$this->autoPointer;
    $this->pool[] = $entry;
  }//end public function append */

  /**
   * @return array
   */
  public function asArray(  )
  {
    return $this->pool;
  }//end public function asArray */

  /**
   * @param string $key
   */
  public function exists( $key )
  {
    return array_key_exists( $key , $this->pool );
  }//end public function exists */



}//end class TJsonArray

