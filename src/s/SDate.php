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
  }//end public static function getTimestamp( $format = 'Y-m-d h:i:s' )

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

}// end class SDate


