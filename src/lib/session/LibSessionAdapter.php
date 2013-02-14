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
 *
 * @package WebFrap
 * @subpackage tech_core
 */
abstract class LibSessionAdapter
    implements ArrayAccess
{
/*//////////////////////////////////////////////////////////////////////////////
// Magic Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Enter description here...
   *
   * @param unknown_type $key
   * @param unknown_type $value
   */
  public function __set($key , $value )
  {
    $this->session[$key] = $value;
  }// end of public function __set($key , $value )

  /**
   * Enter description here...
   *
   * @param unknown_type $key
   * @return unknown
   */
  public function __get($key )
  {
    return isset($this->session[$key])?$this->session[$key]:null;
  }// end of public function __get($key )

/*//////////////////////////////////////////////////////////////////////////////
// Interface: ArrayAccess
//////////////////////////////////////////////////////////////////////////////*/

  public function offsetSet($offset, $value)
  {
    $this->session[$offset] = $value;
  }//end public function offsetSet($offset, $value)

  public function offsetGet($offset)
  {
    return $this->session[$offset];
  }//end public function offsetGet($offset)

  public function offsetUnset($offset)
  {
    unset($this->session[$offset]);
  }//end public function offsetUnset($offset)

  public function offsetExists($offset)
  {
    return isset($this->session[$offset])?true:false;
  }//end public function offsetExists($offset)

/*//////////////////////////////////////////////////////////////////////////////
// Logic
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Enter description here...
   *
   * @param unknown_type $name
   * @param unknown_type $sessionId
   * @param unknown_type $sessionSavePath
   * @return void
   */
  public abstract function start($name, $sessionId = null , $sessionSavePath = null );

  /**
   * @return void
   */
  public abstract function close();

  /**
   * @return void
   */
  public abstract function destroy();


/*//////////////////////////////////////////////////////////////////////////////
// Static Logic
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Enter description here...
   *
   * @param unknown_type $key
   * @param unknown_type $value
   * @return void
   */
  public function add($key , $value = null )
  {
    $this->session[$key] = $value;
  }

  /**
   * Enter description here...
   *
   * @param unknown_type $key
   * @param unknown_type $value
   * @return void
   */
  public function append($key , $value = null )
  {
    if ( is_array($key) )
    {
      $this->session = array_merge($this->session,$key) ;
    } else {
      $this->session[$key][] = $value;
    }

  }

  /**
   * Enter description here...
   *
   * @param unknown_type $key
   * @param unknown_type $value
   * @return  mixed
   */
  public abstract function get($key )
  {
    return isset($this->session[$key])?$this->session[$key]:null;
  }

  /**
   * Enter description here...
   *
   * @param string $key
   * @return boolean
   */
  public abstract function exists($key )
  {
    return isset($this->session[$key])?true:false;
  }

  /**
   * Enter description here...
   *
   * @param string $key
   * @return void
   */
  public abstract function delete($key )
  {
    if (isset($this->session[$key])) unset($this->session[$key]);
  }



}//end class LibSessionAdapter

