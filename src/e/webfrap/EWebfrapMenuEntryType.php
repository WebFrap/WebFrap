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
 * @subpackage Menu
 */
class EWebfrapMenuEntryType
{
/*//////////////////////////////////////////////////////////////////////////////
// Constantes
//////////////////////////////////////////////////////////////////////////////*/


  /**
   * @var int
   */
  const ROOT = 1;

  /**
   * @var int
   */
  const SUBMENU = 2;

  /**
   * @var int
   */
  const ENTRY = 3;


/*//////////////////////////////////////////////////////////////////////////////
// Labels
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var array
   */
  public static $labels = array(
    self::ROOT => 'Root',
    self::SUBMENU => 'Submenu',
    self::ENTRY => 'Entry',
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


}//end class EWebfrapMenuEntryType

