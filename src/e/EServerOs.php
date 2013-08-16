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
class EServerOs
{

  const WINDOWS = 1;

  const LINUX = 2;

  const SOLARIS = 3;

  const BSD = 4;

  const MAC = 5;

  /**
   *
   * @var array
   */
  public static $text = array
  (
    self::WINDOWS => 'Windows',
    self::LINUX => 'Linux',
    self::SOLARIS => 'Solaris',
    self::BSD => 'BSD',
    self::MAC => 'MacOsX'
  );

}//end class ECoreServerOs

