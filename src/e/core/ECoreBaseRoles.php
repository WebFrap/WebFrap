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
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 * @package WebFrap
 * @subpackage tech_core
 */
class ECoreProcessEvent
{

  const ON_CREATE = 1;

  const ON_UPDATE = 2;

  const ON_SAVE = 3;

  const ON_SHOW = 4;

  const ON_FIRST_SHOW = 5;

  const ON_DELETE = 6;

  const ON_DEACTIVATE = 7;

  const ON_ACTIVATE = 8;

  const ON_STEP_FORWARD = 9;

  const ON_STEP_BACK = 11;

  const ON_STATUS_UP = 12;

  const ON_STATUS_DOWN = 13;

  const ON_FINISH = 14;

  const ON_REOPEN = 15;

  /**
   * Key Map
   * @var array
   */
  public static $text = array
  (
    self::ON_CREATE => 'onCreate',
    self::ON_UPDATE => 'onUpdate',
    self::ON_SAVE => 'onSave',
    self::ON_SHOW => 'onShow',
    self::ON_FIRST_SHOW => 'onFirstShow',
    self::ON_DELETE => 'onDelete',
    self::ON_DEACTIVATE => 'onDeactivate',
    self::ON_ACTIVATE => 'onActivate',
    self::ON_STEP_FORWARD => 'onStepForward',
    self::ON_STEP_BACK => 'onStepBack',
    self::ON_STATUS_UP => 'onStatusUp',
    self::ON_STATUS_DOWN => 'onStatusDown',
    self::ON_FINISH => 'onFinish',
    self::ON_REOPEN => 'onReopen',
  );

}//end class ECoreProcessEvent

