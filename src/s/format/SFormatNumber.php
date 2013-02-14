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
class SFormatNumber
{

  /**
   * 
   */
  public static function formatMoney( $data )
  {
    return number_format($data,2,',','.');
  }//end public static function formatMoney */

  /**
   * @param int $value
   * @return string
   */
  public static function formatFileSize( $value )
  {
    
    if (!$value )
      return '-';

    $labels = array('bytes', 'kb', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB' );
    $key = floor(log($value)/log(1024));

    return sprintf( '%.2f '.$labels[$key], ($value/pow(1024, floor($key))) );
    
    //return ($value/pow(1024, floor($key))).$labels[$key];

  }//end public static function formatFileSize */

} // end class SFormatNumbers

