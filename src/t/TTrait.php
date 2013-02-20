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
class TTrait
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @var array
   */
  protected $funcs = array();

  /**
   * Zugriff Auf die Elemente per magic get
   *
   * @param string $key
   * @return mixed
   */
  public function __call($funcName , $params )
  {

    if (!isset($this->funcs[$funcName]) ) {
      throw new FunctionNotExists_Exception( 'Requested invalid functioncall '.$funcName );
    }

    $func = $this->funcs[$funcName];
    $anz  = count($params);

    switch ($anz) {
      case 0: return $func();
      case 1: return $func($params[0]);
      case 2: return $func($params[0],$params[1]);
      case 3: return $func($params[0],$params[1],$params[2]);
      case 4: return $func($params[0],$params[1],$params[2],$params[3]);
      case 5: return $func($params[0],$params[1],$params[2],$params[3],$params[4]);
      case 6: return $func($params[0],$params[1],$params[2],$params[3],$params[4],$params[5]);
      case 7: return $func($params[0],$params[1],$params[2],$params[3],$params[4],$params[5],$params[6]);
      case 8: return $func($params[0],$params[1],$params[2],$params[3],$params[4],$params[5],$params[6],$params[7]);
      case 9: return $func($params[0],$params[1],$params[2],$params[3],$params[4],$params[5],$params[6],$params[7],$params[8]);
      default:
      {
        return call_user_func_array($func, $params );
        break;
      }
    }

  }// end public function __call */

  /**
   * Zugriff Auf die Elemente per magic set
   * @param string $key
   * @param mixed $value
   */
  public function __set($key , $value )
  {
    $this->funcs[$key] = $value;
  }// end public function __set */

  /**
   * Zugriff Auf die Elemente per magic get
   *
   * @param string $key
   * @return mixed
   */
  public function __get($key )
  {
    return isset($this->funcs[$key])?$this->funcs[$key]:null;
  }// end public function __get */

}//end class TTrait
