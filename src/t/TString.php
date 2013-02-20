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
class TString
  implements ArrayAccess, Iterator, Countable
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * default is empty
   */
  protected $data = '';

  /**
   *
   * @var int
   */
  protected $iteratorPos = 0;

/*//////////////////////////////////////////////////////////////////////////////
// Magic Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Standard Konstruktor
   * Nimmt beliebig viele Elemente oder einen einzigen Array
   */
  public function __construct($data = '' )
  {
    $this->data = $data;

  }//end public function __construct */

  /**
   *
   */
  public function __toString()
  {
    return $this->data;
  }//end public function __toString */

/*//////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////*/

  public function lower(  )
  {
    return new TString( strtolower($this->data ) );
  }

  public function upper(  )
  {
    return new TString( strtoupper($this->data ) );
  }

  public function split($delimiter, $offset = null  )
  {

    if ($offset )
      $tmp = explode($delimiter , $this->data , $offset );
    else
      $tmp = explode($delimiter , $this->data  );

    if (!$tmp)
      return array();

    $tmp2 = array();
    foreach($tmp as $text )
      $tmp2 = new TString($text );

    return $tmp2;

  }//end public function split

/*//////////////////////////////////////////////////////////////////////////////
// Interface: ArrayAccess
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @see ArrayAccess:offsetSet
   */
  public function offsetSet($offset, $value)
  {

    if (!ctype_digit($offset)) {
      Error::addError("Invalid offset Type");

      return false;
    }

    $this->data[$offset] = $value;

    return true;

  }//end public function offsetSet */

  /**
   * @see ArrayAccess:offsetGet
   */
  public function offsetGet($offset)
  {

    if (!ctype_digit($offset)) {
      Error::addError("Invalid offset Type");

      return null;
    }

    return $this->data[$offset];
  }//end public function offsetGet */

  /**
   * @see ArrayAccess:offsetUnset
   */
  public function offsetUnset($offset)
  {

    if (!ctype_digit($offset)) {
      Error::addError("Invalid offset Type");

      return false;
    }

    unset($this->data[$offset]);
  }//end public function offsetUnset */

  /**
   * @see ArrayAccess:offsetExists
   */
  public function offsetExists($offset)
  {

    if (!ctype_digit($offset)) {
      Error::addError("Invalid offset Type");

      return false;
    }

    return isset($this->data[$offset])?true:false;
  }//end public function offsetExists */

/*//////////////////////////////////////////////////////////////////////////////
// Interface: Iterator
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @see Iterator::current
   */
  public function current()
  {
    return isset($this->data[$this->iteratorPos])?$this->data[$this->iteratorPos]:null;
  }//end public function current */

  /**
   * @see Iterator::key
   */
  public function key ()
  {
    return $this->iteratorPos;
  }//end public function key */

  /**
   * @see Iterator::next
   */
  public function next ()
  {
    ++$this->iteratorPos;

    return $this->current();
  }//end public function next */

  /**
   * @see Iterator::rewind
   */
  public function rewind ()
  {
    $this->iteratorPos = 0;
  }//end public function rewind */

  /**
   * @see Iterator::valid
   */
  public function valid ()
  {
    return isset($this->data[$this->iteratorPos])?true:false;
  }//end public function valid */

/*//////////////////////////////////////////////////////////////////////////////
// Interface: Countable
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @see Countable::count
   */
  public function count()
  {
    return strlen($this->data);
  }//end public function count */

}//end class TString
