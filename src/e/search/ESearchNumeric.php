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
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 * @package WebFrap
 * @subpackage tech_core
 */
class ESearchNumeric
{

  const EQUALS = 1;
  
  const SMALLER = 2;

  const SMALLER_EQUAL = 3;
  
  const BIGGER = 4;
  
  const BIGGER_EQUAL = 5;
  
  const IS_NULL = 6;

  /**
   * @var array
   */
  public static $labels = array(
    self::EQUALS => 'equals',
    self::SMALLER => 'smaller',
    self::SMALLER_EQUAL => 'smaller or equal',
    self::BIGGER => 'bigger',
    self::BIGGER_EQUAL => 'bigger or equal',
    self::IS_NULL => 'is empty',
  );
  
  /**
   * @param string $key
   * @return string
   */
  public static function label($key)
  {
    return isset(self::$labels[$key])
      ? self::$labels[$key]
      : ''; // per default custom

  }//end public static function label */

}//end class ESearchNumeric

