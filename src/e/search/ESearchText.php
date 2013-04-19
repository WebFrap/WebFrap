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
class ESearchText
{

  const EQUALS        = 1;
  
  const START_WITH    = 2;

  const CONTAINS      = 3;
  
  const END_WITH      = 4;

  const IS_NULL       = 5;

  /**
   * @var array
   */
  public static $labels = array(
    self::EQUALS      => 'equals',
    self::START_WITH  => 'starts with',
    self::CONTAINS    => 'contains',
    self::END_WITH    => 'ends with',
    self::IS_NULL     => 'is empty',
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

}//end class ESearchText

