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
 * Kleine Registry Klasse zum zwischenspeichern von nicht persistenten Daten
 * analog GLOBAL
 *
 * @package WebFrap
 * @subpackage tech_core
 */
class Registry extends TArray
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @var Registry
   */
  private static $instance = null;

  protected $flow         = null;
  protected $module       = null;
  protected $controller   = null;

/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Enter description here...
   *
   */
  public static function init()
  {
    self::$instance = new Registry();
  }//end public static function init */

  /**
   * Enter description here...
   *
   */
  public static function shutdown()
  {

  }//end public static function shutdown */

  /**
   *
   */
  public static function getActive()
  {

    if (!self::$instance)
      self::$instance = new Registry();

    return self::$instance;

  }//end public static function getActive */

/*//////////////////////////////////////////////////////////////////////////////
// getter & setter methodes
//////////////////////////////////////////////////////////////////////////////*/

  public function setFlow($flow)
  {
    $this->flow = $flow;
  }

  public function getFlow()
  {
    return $this->flow;
  }

  public function setModule($module)
  {
    $this->module = $module;
  }
  public function getModule()
  {
    return $this->module;
  }

  public function setController($controller)
  {
    $this->controller = $controller;
  }
  public function getController()
  {
    return $this->controller;
  }

/*//////////////////////////////////////////////////////////////////////////////
// Method
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Enter description here...
   *
   * @param string $key
   * @param mixed  $data
   * @param string $subkey = null
   */
  public function register($key,  $data, $subkey = null)
  {
    if (!is_null($subkey)) {
      if (!isset($this->pool[$key]))
        $this->pool[$key] = array();

      $this->pool[$key][$subkey] = $data;
    } else {
      $this->pool[$key] = $data;
    }

  }//end public static function register */

  /**
   *
   * @param $key
   * @param $subkey = null
   * @return void
   */
  public function unregister($key, $subkey = null)
  {
    if (!is_null($subkey)) {
      if (isset($this->pool[$key][$subkey]))
        unset($this->pool[$key][$subkey]);
    } else {
      if (isset($this->pool[$key]))
        unset($this->pool[$key]);
    }

  }//end public static function unregister */

  /**
   *
   * @param $key
   * @param $subkey = null
   * @return mixed
   */
  public function get($key, $subkey = null)
  {
    if (!is_null($subkey)) {
      if (isset($this->pool[$key][$subkey]))
        return $this->pool[$key][$subkey];
      else
        return null;
    } else {
      if (isset($this->pool[$key]))
        return $this->pool[$key];
      else
        return null;
    }

  }//end public static function get */

  /**
   * @see ArrayAccess:offsetSet
   */
  public function offsetSet($offset, $value)
  {

    Debug::console("Registry set ".$offset, $value);

    if (is_null($offset))
      $this->pool[] = $value;
    else
      $this->pool[$offset] = $value;

  }//end public function offsetSet */

  /**
   * @see ArrayAccess:offsetGet
   */
  public function offsetGet($offset)
  {

    Debug::console("Registry get ".$offset, (isset($this->pool[$offset])
      ? $this->pool[$offset]
      : null));

    return isset($this->pool[$offset])
      ? $this->pool[$offset]
      : null ;

  }//end public function offsetGet */

} // end class Registry

