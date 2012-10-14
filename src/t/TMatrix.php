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
class TMatrix
  implements ITObject, Iterator, Countable
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  protected $pool = array();

////////////////////////////////////////////////////////////////////////////////
// Magic Methodes
////////////////////////////////////////////////////////////////////////////////

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

  }//end public function __construct( )

  /**
   * Zugriff Auf die Elemente per magic set
   * @param string $key
   * @param mixed $value
   */
  public function __set( $key , $value )
  {

    $tmp = explode('_',$key);

    if( count($tmp) == 0 )
    {
      $this->pool[$key]  = $value;
    }
    else
    {
      $this->pool[$tmp[0]][$tmp[1]] = $value;
    }

  }// end of public function __set( $key , $value )

  /**
   * Zugriff Auf die Elemente per magic get
   *
   * @param string $key
   * @return mixed
   */
  public function __get( $key )
  {
    $tmp = explode('_',$key);

    if( count($tmp) == 0 )
    {
      return isset($this->pool[$tmp[0]])?$this->pool[$tmp[0]]:null;
    }
    else
    {
      return isset($this->pool[$tmp[0]][$tmp[1]])?$this->pool[$tmp[0]][$tmp[1]]:null;
    }

  }// end of public function __get( $key )

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

}//end class TArray

// NO Rowcounter here, will crash the system
//