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
class SDate
{

  public static $monthDays = array
  (
    'jan' => 31,
    1 => 31,
    'feb' => 28,
    2 => 28,
    'mar' => 31,
    3 => 31,
    'mar' => 31,
    3 => 31,
  );
  
  /**
   * get the actual time in standard format
   *
   * @return string
   */
  public static function getTime( $format = 'h:i:s' , $time = null )
  {
    if( $time )
    {
      if( is_numeric($time) )
      {
        return date($format,$time);
      }
      else
      {
        return date($format,strtotime($time));
      }
    }
    else
    {
      return date($format);
    }

  }//end public static function getTime( $format = 'h:i:s' )

  /**
   * get the actual timestamp in standard format
   *
   * @return string
   */
  public static function getTimestamp( $format = 'Y-m-d h:i:s' , $timestamp = null )
  {
    
    if( $timestamp )
    {
      if( is_numeric($timestamp) )
      {
        return date($format,$timestamp);
      }
      else
      {
        return date($format,strtotime($timestamp));
      }
    }
    else
    {
      return date($format);
    }
    
  }//end public static function getTimestamp */

  /**
   * get the actual date as standart format
   * @return string
   */
  public static function getDate( $format = 'Y-m-d' , $date = null )
  {
    
    if( $date )
    {
      if( is_numeric($date) )
      {
        return date($format,$date);
      }
      else
      {
        return date($format,strtotime($date));
      }
    }
    else
    {
      return date($format);
    }
    
  }//end public static function getDate( $format = 'Y-m-d' )
  
  
  /**
   * Check if the year is a leapyear
   * @param boolean $timeStamp
   */
  public static function isLeapYear( $timeStamp )
  {
    
    if( $timeStamp > 3000 )
      return (date( 'L', $timeStamp ) == '1') ;
    else 
      return (date( 'L', mktime(  0, 0, 0, 0, 0, $timeStamp ) ) == '1');
    
  }//end public static function isLeapYear */
  
  /**
   * 
   */
  public function getFilteredMonthDays( $year, $month, $days = array(), $weeks = array() )
  {
    
    ///TODO wochentag donnerstag sonst keine 4 wochen etc
    $filteredDays = array();
    
    $week = 1;
    $numDays = date( 't', mktime(  0, 0, 0, 0, $month, $year ) );
    
    for( $pos = 1; $pos < $numDays; ++$pos )
    {
      
      $theTime = mktime( 0, 0, 0, $pos, $month, $year  );
      
      $numDay = date('w',$theTime);
      
      if( in_array($numDay, $days) )
        $filteredDays[] = $pos;

      
    }

  }//end public function getFilteredMonthDays */
  
  /**
   * Check if the year is a leapyear
   * @param int $year
   * @param int $month
   */
  public static function getMonthDays( $year, $month )
  {
    
    return date( 't', mktime(  0, 0, 0, 0, $month, $year ) );
      
  }//end public static function getMonthDays */

}// end class SDate


