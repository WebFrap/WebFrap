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
 *
 * @author domnik alexander bonsch <dominik.bonsch@webfrap.net>
 */
class DomainModule
{

  /**
   * @var string
   */
  public $label = null;

  /**
   * @var string
   */
  public $name = null;

  /**
   * @var string
   */
  public $aclKey = null;

  /**
   * @var string
   */
  public $domainKey = null;

  /**
   * @var [DomainNode]
   */
  private static $pool = array();

  /**
   * @param string $key
   * @return DomainNode
   */
  public static function getNode($key)
  {

    if (!array_key_exists($key, self::$pool)) {

      $className = SParserString::subToCamelCase($key).'_Domain';

      if (!Webfrap::classExists($className)) {
        self::$pool[$key] = null;

        return null;
      }

      self::$pool[$key] = new $className;
    }

    return self::$pool[$key];

  }//end public static function getNode */

}//end class DomainNode
