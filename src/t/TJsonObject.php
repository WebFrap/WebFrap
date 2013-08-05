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
class TJsonObject
{

  /**
   * the array data body for the Array Object
   * @var array
   */
  protected $pool = array();

  /**
   * Standard Konstruktor
   * Nimmt beliebig viele Elemente oder einen einzigen Array
   */
  public function __construct()
  {

    if ($anz = func_num_args()) {

      if ($anz === 1) {
        $arg = func_get_arg(0);
        if (is_array($arg) && !is_null($arg))
          $this->pool = $arg;
      } else {
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

    foreach ($this->pool as $key => $value) {

      if (is_object($value)) {
        $jsValue = (string) $value;
      } elseif (is_bool($value)) {
        $jsValue = $value?'true':'false';
      } elseif (is_numeric($value)) {
        $jsValue = $value;
      } elseif (is_string($value)) {
        $jsValue = '"'.str_replace(array('"','\\',"\n"), array('\"','\\\\',"\\n"), (string) $value).'"';
      } else {
        $jsValue = 'null';
      }

      $assembled[] = '"'.$key.'":'.$jsValue;
    }

    return '{'.implode(',', $assembled).'}';

  }//end public function __toString */

  /**
   * Zugriff Auf die Elemente per magic set
   * @param string $key
   * @param mixed $value
   */
  public function __set($key , $value)
  {
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
    return isset($this->pool[$key])
      ?$this->pool[$key]
      :null;
  }// end of public function __get */
  
  /**
   * @param string $key
   * @return boolean
   */
  public function __isset($key){
    return isset($this->pool[$key])
      ? true
      : false;
  }

}//end class TJsonObject

