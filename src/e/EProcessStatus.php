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
class EProcessStatus
{
/*//////////////////////////////////////////////////////////////////////////////
// constantes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var int
   */
  const RUNNING = 0;

  /**
   * @var int
   */
  const WARNING = 1;

  /**
   * @var int
   */
  const FROZEN = 2;

  /**
   * @var int
   */
  const ABORTED = 3;

  /**
   * @var int
   */
  const COMPLETED = 4;

/*//////////////////////////////////////////////////////////////////////////////
// Labels
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var array
   */
  public static $labels = array
  (
    self::RUNNING   => 'Running',
    self::WARNING   => 'Warning',
    self::FROZEN    => 'Frozen',
    self::ABORTED   => 'Aborted',
    self::COMPLETED => 'Completed'
  );

  /**
   * @var array
   */
  public static $classes = array
  (
    self::RUNNING   => 'ok',
    self::WARNING   => 'warn',
    self::FROZEN    => 'frozen',
    self::ABORTED   => 'bad',
    self::COMPLETED => 'completed'
  );

  /**
   * @param string $key
   * @return string
   */
  public static function label($key )
  {
    return isset( self::$labels[$key] )
      ? self::$labels[$key]
      : self::$labels[self::RUNNING]; // no status? so it's running

  }//end public static function label */

  /**
   * @param string $key
   * @return string
   */
  public static function statusClass($key )
  {
    return $key && isset(self::$classes[$key])
      ? 'state-'.self::$classes[$key]
      : 'state-'.self::$classes[self::RUNNING]; // no status? so it's running

  }//end public static function statusClass */

}//end class EProcessStatus

