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
class EMessageAspect
{
/*//////////////////////////////////////////////////////////////////////////////
// Constantes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var int
   */
  const NO_ASPECT = 0;

  /**
   * @var int
   */
  const MESSAGE = 1;

  /**
   * @var int
   */
  const DOCUMENT = 2;

  /**
   * @var int
   */
  const APPOINTMENT = 4;

  /**
   * @var int
   */
  const SHARED = 5;

  /**
   * @var int
   */
  const TASK = 6;

  /**
   * @var int
   */
  const DISCUSSION = 7;

  /**
   * @var int
   */
  const CHECKLIST = 8;

  /**
   * @var array
   */
  public static $labels = array(
    self::NO_ASPECT => 'No Aspect',
    self::MESSAGE => 'Message',
    self::NOTICE => 'Notice / Memo',
    self::APPOINTMENT => 'Appointment',
    self::SHARED => 'Shared',
    self::TASK => 'Task',
    self::DISCUSSION => 'Discussion',
    self::CHECKLIST => 'Checklist',
  );

  /**
   * @param string $key
   * @param string $def
   * @return string
   */
  public static function label($key, $def = null)
  {

    if (!is_null($def)  )
    {
      return isset(self::$labels[$key])
        ? self::$labels[$key]
        : $def;
    }
    else
    {
      return isset(self::$labels[$key])
        ? self::$labels[$key]
        : '0';
    }


  }//end public static function label */

}// end class EMessageAspect

