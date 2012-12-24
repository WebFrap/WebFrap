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
 * @subpackage tech_core
 */
class ETaskType
{
////////////////////////////////////////////////////////////////////////////////
// attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @var int
   */
  const MINUTE = 60;

  /**
   * @var int
   */
  const MINUTE_5 = 300;
  
  /**
   * @var int
   */
  const MINUTE_15 = 900;
  
  /**
   * @var int
   */
  const MINUTE_30 = 1800;
  
  /**
   * @var int
   */
  const HOUR = 3600;
  
  /**
   * @var int
   */
  const HOUR_6 = 21600;
  
  /**
   * @var int
   */
  const HOUR_12 = 43200;
  
  /**
   * @var int
   */
  const WORK_DAY = 1;
  
  /**
   * @var int
   */
  const WEEKEND = 2;
  
  /**
   * @var int
   */
  const DAY = 86400;
  
  /**
   * @var int
   */
  const WEEK = 604800;
  
  /**
   * @var int
   */
  const WEEK_2 = 1209600;
  
  /**
   * @var int
   */
  const MONTH = 3;
  
  /**
   * @var int
   */
  const MONTH_3 = 4;
  
  /**
   * @var int
   */
  const MONTH_6 = 5;
  
  /**
   * @var int
   */
  const YEAR = 6;
  
  /**
   * @var array
   */
  public static $labels = array
  (
    self::MINUTE     => 'Every minute',
    self::MINUTE_5   => 'Every 5 minutes',
    self::MINUTE_15  => 'Every 15 minutes',
    self::MINUTE_30  => 'Every 30 minutes',
    self::HOUR       => 'Every hour',
    self::HOUR_6     => 'Every 6 hours',
    self::HOUR_12    => 'Every 12 hours',
    self::WORK_DAY   => 'Every working day',
    self::WEEKEND    => 'Every weekend',
    self::DAY        => 'Every day',
    self::WEEK       => 'Every week',
    self::WEEK_2     => 'Every second week',
    self::MONTH      => 'Every month',
    self::MONTH_3    => 'Every quater',
    self::MONTH_6    => 'Every half year',
    self::YEAR       => 'Every year'
  );
  
  /**
   * @param string $key
   * @return string
   */
  public static function label( $key )
  {
    
    return isset( self::$labels[$key] ) 
      ? self::$labels[$key]
      : 'No type selected';
      
  }//end public static function label */

}//end class ETaskType

