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
 *
 * @package WebFrap
 * @subpackage Core
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class EWebfrapConfidential
{
/*//////////////////////////////////////////////////////////////////////////////
// Constantes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var int
   */
  const PUBLICLY = 0;

  /**
   * @var int
   */
  const CUSTOMER = 1;

  /**
   * @var int
   */
  const RESTRICTED = 2;

  /**
   * @var int
   */
  const CONFIDENTIAL = 3;

  /**
   * @var int
   */
  const SECRET = 4;

  /**
   * @var int
   */
  const TOP_SECRET = 5;

  /**
   * @var array
   */
  public static $labels = array(
    self::PUBLICLY   => 'Public',
    self::CUSTOMER   => 'Customer Only',
    self::RESTRICTED   => 'Restricted',
    self::CONFIDENTIAL   => 'Confidential',
    self::SECRET   => 'Secret',
    self::TOP_SECRET   => 'Top Secret',
  );

  /**
   * @param string $key
   * @param string $def
   * @return string
   */
  public static function label($key, $def = null)
  {

    if (!is_null($def)) {
      
      return isset(self::$labels[$key])
        ? self::$labels[$key]
        : $def;
    } else {
      
      return isset(self::$labels[$key])
        ? self::$labels[$key]
        : $labels[self::PUBLICLY];
    }


  }//end public static function label */

}// end class EWebfrapConfidential

