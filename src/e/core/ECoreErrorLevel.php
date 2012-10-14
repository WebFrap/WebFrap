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
class ECoreErrorLevel
{


  const DISPLAY       = 1;

  const LIGHT         = 2;

  const MODERATE      = 3;

  const HEAVY         = 4;

  const BLOCKER       = 5;


  /**
   * Enter description here...
   *
   * @var array
   */
  public static $text = array
  (
    self::DISPLAY   => 'wbf.enum.errorlevel.Display',
    self::LIGHT     => 'wbf.enum.errorlevel.Light',
    self::MODERATE  => 'wbf.enum.errorlevel.Moderate',
    self::HEAVY     => 'wbf.enum.errorlevel.Heavy',
    self::BLOCKER   => 'wbf.enum.errorlevel.Blocker',
  );

}//end class ECoreErrorLevel

