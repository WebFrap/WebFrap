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
 * @package WebFrap
 * @subpackage taskplanner
 */
class ETaskType
{
/*//////////////////////////////////////////////////////////////////////////////
// Constantes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var int
   */
  const CUSTOM = 0;

  /**
   * @var int
   */
  const MINUTE = 1;

  /**
   * @var int
   */
  const MINUTE_5 = 2;

  /**
   * @var int
   */
  const MINUTE_15 = 4;

  /**
   * @var int
   */
  const MINUTE_30 = 5;

  /**
   * @var int
   */
  const HOUR = 6;

  /**
   * @var int
   */
  const HOUR_6 = 7;

  /**
   * @var int
   */
  const HOUR_12 = 8;

  /**
   * @var int
   */
  const WORK_DAY = 9;

  /**
   * @var int
   */
  const WEEK_END = 10;

  /**
   * @var int
   */
  const DAY = 11;

  /**
   * @var int
   */
  const WEEK_2 = 12;

  /**
   * @var int
   */
  const MONTH_START = 13;
  /**
   * @var int
   */
  const MONTH_END = 14;
  
  /**
   * @var int
   */
  const MONTH_3_START = 15;

  /**
   * @var int
   */
  const MONTH_3_END = 16;

  /**
   * @var int
   */
  const MONTH_6_START = 17;

  /**
   * @var int
   */
  const MONTH_6_END = 18;

  /**
   * @var int
   */
  const YEAR_START = 19;

  /**
   * @var int
   */
  const YEAR_END = 20;
  
  /**
   * @var int
   */
  const MONTH_END_WORKDAY = 21;

/*//////////////////////////////////////////////////////////////////////////////
// Labels
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var array
   */
  public static $labels = array
  (
    self::CUSTOM     => 'Custom',
    self::MINUTE     => 'Every minute',
    self::MINUTE_5   => 'Every 5 minutes',
    self::MINUTE_15  => 'Every 15 minutes',
    self::MINUTE_30  => 'Every 30 minutes',
    self::HOUR       => 'Every hour',
    self::HOUR_6     => 'Every 6 hours',
    self::HOUR_12    => 'Every 12 hours',
    self::DAY        => 'Every day',
    self::WORK_DAY   => 'Every working day',
    self::WEEK_END   => 'Every weekend',
    self::WEEK_2     => 'Every second week',
    self::MONTH_START => 'Every month start',
    self::MONTH_END  => 'Every month end',
    self::MONTH_3_START => 'Every quater start',
    self::MONTH_3_END   => 'Every quater end',
    self::MONTH_6_START => 'Every half year start',
    self::MONTH_6_END   => 'Every half year end',
    self::YEAR_START    => 'Every year start',
    self::YEAR_END      => 'Every year end',
    self::MONTH_END_WORKDAY => 'Every month end (workday)'
  );

  /**
   * @param string $key
   * @return string
   */
  public static function label($key)
  {
    return isset(self::$labels[$key])
      ? self::$labels[$key]
      : self::$labels[self::CUSTOM]; // per default custom

  }//end public static function label */

}//end class ETaskType

