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
class ECoreSupportedBrowser
{

  const IE_6           = 1;

  const IE_7           = 2;

  const IE_8           = 3;

  const FF_1_5         = 4;

  const FF_2           = 5;

  const FF_3           = 6;

  const OPERA_8        = 7;

  const OPERA_9        = 8;

  const OPERA_9_5      = 9;

  const SAFARI_2       = 10;

  const SAFARI_3       = 11;

  const SAFARI_4       = 12;

  /**
   * Enter description here...
   *
   * @var array
   */
  public static $text = array
  (
  self::IE_6       => 'Internet Explorer 6',
  self::IE_7       => 'Internet Explorer 7',
  self::IE_8       => 'Internet Explorer 8',
  self::FF_1_5     => 'Firefox 1.5',
  self::FF_2       => 'Firefox 2',
  self::FF_3       => 'Firefox 3',
  self::OPERA_8    => 'Opera 8',
  self::OPERA_9    => 'Opera 9',
  self::OPERA_9_5  => 'Opera 9.5',
  self::SAFARI_2   => 'Safari 2',
  self::SAFARI_3   => 'Safari 3',
  self::SAFARI_4   => 'Safari 4',
  );

}//end class ECoreSupportedBrowser
