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
class EUserType
{
/*//////////////////////////////////////////////////////////////////////////////
// Constantes
//////////////////////////////////////////////////////////////////////////////*/


  /**
   * Der System Account, gibts nur einmal
   * @var int
   */
  const SYSTEM = 1;
  
  /**
   * @var int
   */
  const USER = 2;

  /**
   * @var int
   */
  const MACHINE = 3;

  /**
   * @var int
   */
  const ORGANISATION = 4;

  /**
   * @var int
   */
  const BUIZ_NODE =5;

  /**
   * @var int
   */
  const BOT = 6;

  /**
   * @var int
   */
  const SPIDER = 7;

/*//////////////////////////////////////////////////////////////////////////////
// Labels
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var array
   */
  public static $labels = array(
    self::SYSTEM => 'System',
    self::USER => 'User',
    self::MACHINE => 'Machine',
    self::ORGANISATION => 'Organisation',
    self::BUIZ_NODE => 'BuizNode',
    self::BOT => 'Bot',
    self::SPIDER => 'Spider',
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


}//end class EUserType

