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
class EUserSettingType
{
/*//////////////////////////////////////////////////////////////////////////////
// Constantes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var int
   */
  const MESSAGES = 1;
  const LISTING = 2;
  const LISTING_REF = 3;
  const SELECTION = 4;

/*//////////////////////////////////////////////////////////////////////////////
// Labels
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var array
   */
  public static $labels = array(
    self::MESSAGES     => 'Messages',
    self::LISTING      => 'Listing',
    self::LISTING_REF  => 'Listing Ref',
    self::SELECTION    => 'Selection',
  );

  /**
   * @var array
   */
  public static $classes = array(
    self::MESSAGES     => 'WebfrapMessage_Table_Search_Settings',
    self::LISTING      => 'WgtSettings_Search_Listing',
    self::LISTING_REF  => 'WgtSettings_Search_Listing',
    self::SELECTION    => 'WgtSettings_Search_Listing',
  );

  /**
   * @param string $key
   * @return string
   */
  public static function label($key)
  {

    return isset(self::$labels[$key])
      ? self::$labels[$key]
      : null; // sollte nicht passieren

  }//end public static function label */

  /**
   * @param string $key
   * @return string
   */
  public static function getClass($key)
  {

    return isset(self::$classes[$key])
      ? self::$classes[$key]
      : null; // sollte nicht passieren

  }//end public static function getClass */

}//end class EUserSettingType

