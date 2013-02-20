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
class SEncrypt
{

  /**
   * wrapper method for password encryption
   *
   * @param string $value
   * @return string sha1 hash
   */
  public static function passwordHash($value, $mainSalt = '', $dynSalt = '' )
  {
    return sha1($mainSalt.$dynSalt.$value );

  }//end public static function passwordHash */

  /**
   * @return string
   */
  public static function createSalt($size = 10 )
  {
    return substr( uniqid(mt_rand(), true),  0, $size );

  }//end public static function createSalt */

  /**
   * @return string
   */
  public static function uniqueToken($size = 12 )
  {
    return substr( uniqid(mt_rand(), true),  0, $size  );

  }//end public static function uniqueToken */

}// end SEncrypt

