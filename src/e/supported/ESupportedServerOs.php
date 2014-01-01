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
 * Liste der (Theoretisch) supporteten Server Betriebsysteme
 * 
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 * @package WebFrap
 * @subpackage tech_core
 */
class ESupportedServerOs
{

  const WINDOWS = 1;

  const LINUX = 2;

  const SOLARIS = 3;

  const BSD = 4;

  const MAC = 5;

  /**
   * @var array
   */
  public static $labels = array(
    self::WINDOWS => 'Windows',
    self::LINUX => 'Linux',
    self::SOLARIS => 'Solaris',
    self::BSD => 'BSD',
    self::MAC => 'MacOsX'
  );
  
  /**
   * @param string $key
   * @return string
   */
  public static function label($key)
  {
    return isset(self::$labels[$key])
      ? self::$labels[$key]
      : ''; 

  }//end public static function label */

}//end class ESupportedServerOs

