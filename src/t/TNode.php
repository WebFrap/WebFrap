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
 * Node Klasse
 * magic __get und __set sind Elemente
 * indexoperator [] greift auf Attribute der Elemente zu
 *
 * @package WebFrap
 * @subpackage tech_core
 */
class TNode
  implements ITObject, Iterator, Countable
{

/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * pool mit attributen
   * @var array
   */
  protected $attributes = array();

  /**
   * pool mit elementen
   * @var array
   */
  protected $pool = array();

/*//////////////////////////////////////////////////////////////////////////////
// Magic Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   */
  public function __construct( )
  {

    $anz = func_num_args();

    if ($anz) {
      if ($anz == 1 and is_array(func_get_arg(0)) ) {
        $this->pool = func_get_arg(0);
      } else {
        $this->pool = func_get_args();
      }
    }

  }//end public function __construct( )

  /**
   * Enter description here...
   *
   * @param string $key
   * @param mixed $value
   */
  public function __set($key , $value )
  {
    $this->pool[$key] = $value;
  }// end of public function __set */

  /**
   * Enter description here...
   *
   * @param string $key
   * @return mixed
   */
  public function __get($key )
  {
    return isset($this->pool[$key])?$this->pool[$key]:null;
  }// end of public function __get */

/*//////////////////////////////////////////////////////////////////////////////
// Interface: ArrayAccess
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $offset
   * @param string $value
   */
  public function offsetSet($offset, $value)
  {
    $this->attributes[$offset] = $value;
  }//end public function offsetSet */

  /**
   * @param string $offset
   */
  public function offsetGet($offset)
  {
    return $this->attributes[$offset];
  }//end public function offsetGet */

  /**
   * @param string $offset
   */
  public function offsetUnset($offset)
  {
    unset($this->attributes[$offset]);
  }//end public function offsetUnset */

  /**
   * @param string $offset
   */
  public function offsetExists($offset)
  {
    return isset($this->attributes[$offset])?true:false;
  }//end public function offsetExists */

/*//////////////////////////////////////////////////////////////////////////////
// Interface: Iterator
//////////////////////////////////////////////////////////////////////////////*/

  public function current ()
  {
    return current($this->pool);
  }//end public function current */

  public function key ()
  {
    return key($this->pool);
  }//end public function key */

  public function next ()
  {
    return next($this->pool);
  }//end public function next */

  public function rewind ()
  {
    reset($this->pool);
  }//end public function rewind */

  public function valid ()
  {
    return current($this->pool)? true:false;
  }//end public function valid */

/*//////////////////////////////////////////////////////////////////////////////
// Interface: Countable
//////////////////////////////////////////////////////////////////////////////*/

  public function count()
  {
    return count($this->pool);
  }//end public function count */

/*//////////////////////////////////////////////////////////////////////////////
// methodes
//////////////////////////////////////////////////////////////////////////////*/

} // end class TNode

