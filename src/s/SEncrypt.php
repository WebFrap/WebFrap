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

// include password compat lib if not exists
if(!function_exists('password_hash')){
    include PATH_ROOT.'WebFrap_Vendor/vendor/password/password.php';
}

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
  public static function passwordHash($value, $mainSalt = '', $dynSalt = '')
  {
    //return sha1($mainSalt.$dynSalt.$value);

    return password_hash($mainSalt.$dynSalt.$value, PASSWORD_BCRYPT, array("cost" => 20));
    
  }//end public static function passwordHash */

  /**
   * @return string
   */
  public static function createSalt($size = 10)
  {
    return substr(uniqid(mt_rand(), true),  0, $size);

  }//end public static function createSalt */

  /**
   * @return string
   */
  public static function uniqueToken($size = 12)
  {
    return substr(uniqid(mt_rand(), true),  0, $size  );

  }//end public static function uniqueToken */

}// end SEncrypt

