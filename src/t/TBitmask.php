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
class TBitmask
  implements ArrayAccess , Iterator
{

  /** the bitmask array
   */
  protected $mask  = array();

  /**
   *
   * @var int
   */
  protected $value = null;

/*//////////////////////////////////////////////////////////////////////////////
// Magic Functions
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @param array/int $data
   */
  public function __construct($data = null )
  {

    if ( is_numeric($data) ) {
      $this->value = $data;
      $this->createMask((int) $data);
    } elseif ( is_array($data) ) {
      //$this->mask = array_flip($data);
      $this->mask = $data;
      $this->createValue($data);
    }

  } // end public function __construct

  /**
   * Enter description here...
   *
   * @return string
   */
  public function __toString()
  {
    return (string) $this->value;
  }//end public function __toString

  /**
   * Enter description here...
   *
   * @param array/int $data
   */
  public function setData($data)
  {
    if ( is_numeric($data) ) {
      $this->value = $data;
      $this->createMask((int) $data);
    } elseif ( is_array($data) ) {
      //$this->mask = array_flip($data);
      $this->mask = $data;
      $this->createValue($data );
    }
  }//end public function setData

  /**
   * Enter description here...
   *
   * @param array $data
   */
  public function createMask($data )
  {

    $this->mask = array();

    $n = 1 ;
    while ($data > 0) {
      if ($data & 1 == 1) {
        $this->mask[$n] = 1;
      }
      $n *= 2 ;
      $data >>= 1 ;
    }

  }//end public function createMask

  /**
   * Enter description here...
   *
   * @param array $data
   */
  public function createValue($data )
  {

    $this->value = 0;
    $this->value = array_sum( array_keys($data)  );

  }//end public function createValue

/*//////////////////////////////////////////////////////////////////////////////
// Interface: ArrayAccess
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Enter description here...
   *
   * @param int $offset
   * @param boolean $value
   */
  public function offsetSet($offset, $value)
  {

    if ($value )
      $this->mask[$offset] = $value;
    else
      unset($this->mask[$offset]);

  }//end public function offsetSet($offset, $value)

  /**
   * Enter description here...
   *
   * @param int $offset
   * @return boolean
   */
  public function offsetGet($offset)
  {
    return isset($this->mask[(int) $offset])?true:false;
  }//end public function offsetGet($offset)

  /**
   * Enter description here...
   *
   * @param int $offset
   */
  public function offsetUnset($offset)
  {
    unset($this->mask[$offset]);
  }//end public function offsetUnset($offset)

  /**
   * Enter description here...
   *
   * @param int $offset
   * @return boolean
   */
  public function offsetExists($offset)
  {
    return isset($this->mask[$offset])?true:false;
  }//end public function offsetExists($offset)

/*//////////////////////////////////////////////////////////////////////////////
// Interface: Iterator
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   */
  public function current()
  {
    return current($this->mask);
  }//end public function current ()

  /**
   *
   */
  public function key()
  {
    return key($this->mask);
  }//end public function key ()

  /**
   *
   */
  public function next()
  {
    return next($this->mask);
  }//end public function next ()

  /**
   *
   */
  public function rewind()
  {
    reset($this->mask);
  }//end public function rewind ()

  /**
   *
   */
  public function valid()
  {
    return current($this->mask)? true:false;
  }//end public function valid ()

} // end class TBitmask

