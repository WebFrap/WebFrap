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
class ECorePriority
{

  const MIN       = 1;

  const LOW       = 2;

  const MEDIUM    = 3;

  const HIGH      = 4;

  const MAX       = 5;

  /**
   * Key Map
   * @var array
   */
  public static $text = array
  (
    self::MIN     => 'core.enum.priority.min',
    self::LOW     => 'core.enum.priority.low',
    self::MEDIUM  => 'core.enum.priority.medium',
    self::HIGH    => 'core.enum.priority.high',
    self::MAX     => 'core.enum.priority.max',
  );

}//end class ECorePriority

