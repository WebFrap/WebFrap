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
 * Static Interface to get the activ configuration object
 * @package WebFrap
 * @subpackage tech_core
 *
 */
class Event extends BaseChild
{
/*//////////////////////////////////////////////////////////////////////////////
// static attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Action Pool
   * @var array
   */
  public static $pool = array();

/*//////////////////////////////////////////////////////////////////////////////
// pool logic
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @param string $key
   * @param string $classname
   *
   * @throws Lib_Exception
   */
  public static function getEvent($key, $classname)
  {

    if (!isset(self::$pool[$key])) {
      if (!Webfrap::classExists($classname)) {
        throw new Lib_Exception('Requested nonexisting Action: '.$classname.' key '.$key);
      } else {
        self::$pool[$key] = new $classname();
      }
    }

    return self::$pool[$key];

  }//end public static function getEvent */

}// end class Event
