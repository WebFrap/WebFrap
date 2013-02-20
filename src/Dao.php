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
 * Vorlage für alle vorhandenen Datenbank Zugriffsklassen
 * @package WebFrap
 * @subpackage tech_core
 */
class Dao
  implements ArrayAccess, Iterator, Countable
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * mixed data in the array
   * @var array
   */
  protected $data = array();

  /**
   * object pool for allready loaded daos
   *
   * @var array<Entity>
   */
  protected $objPool = array();

/*//////////////////////////////////////////////////////////////////////////////
// Interface: ArrayAccess
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @see ArrayAccess:offsetSet
   */
  public function offsetSet($offset, $value)
  {
    $this->data[$offset] = $value;
  }//end public function offsetSet */

  /**
   * @see ArrayAccess:offsetGet
   */
  public function offsetGet($offset)
  {
    return $this->data[$offset];
  }//end public function offsetGet */

  /**
   * @see ArrayAccess:offsetUnset
   */
  public function offsetUnset($offset)
  {
    unset($this->data[$offset]);
  }//end public function offsetUnset */

  /**
   * @see ArrayAccess:offsetExists
   */
  public function offsetExists($offset)
  {
    return isset($this->data[$offset])?true:false;
  }//end public function offsetExists */

/*//////////////////////////////////////////////////////////////////////////////
// Interface: Iterator
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @see Iterator::current
   */
  public function current ()
  {
    return current($this->data);
  }//end public function current */

  /**
   * @see Iterator::key
   */
  public function key ()
  {
    return key($this->data);
  }//end public function key */

  /**
   * @see Iterator::next
   */
  public function next ()
  {
    return next($this->data);
  }//end public function next */

  /**
   * @see Iterator::rewind
   */
  public function rewind ()
  {
    reset($this->data);
  }//end public function rewind */

  /**
   * @see Iterator::valid
   */
  public function valid ()
  {
    return current($this->data)? true:false;
  }//end public function valid */

/*//////////////////////////////////////////////////////////////////////////////
// Interface: Countable
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @see Countable::count
   */
  public function count()
  {
    return count($this->data);
  }//end public function count */

/*//////////////////////////////////////////////////////////////////////////////
// Entity Pool
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Enter description here...
   *
   * @param int $id
   * @param unknown_type $entity
   */
  public function addToPool($id , $entity )
  {

    if (!$id)
      return;

    if (!isset($this->objPool[(int) $id])  )
      $this->objPool[$id] = $entity;

  }//end public function addToPool */

  /**
   * Enter description here...
   *
   * @param int $id
   * @return Dbo
   */
  public function getFromPool($id)
  {
    if (isset($this->objPool[$id]))
      return $this->objPool[$id];

    return null;
  }//end public function getFromPool */

  /**
   * Enter description here...
   *
   * @param int $id
   * @return Dbo
   */
  public function removeFromPool($id)
  {
    if (isset($this->objPool[$id]))
      unset($this->objPool[$id] );

  }//end public function getFromPool */

/*//////////////////////////////////////////////////////////////////////////////
// Logic
//////////////////////////////////////////////////////////////////////////////*/

}//end class Dao

