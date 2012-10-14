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
class ECoreProcessStepEvent
{


  const ON_SAVE         = 3;

  const ON_SHOW         = 4;

  const ON_DELETE       = 6;

  const ON_STEP_FORWARD = 9;

  const ON_FIRST_REACH   = 10;

  const ON_STEP_BACK    = 11;

  const ON_STATUS_UP    = 12;

  const ON_STATUS_DOWN  = 13;

  /**
   * Enter description here...
   *
   * @var array
   */
  public static $text = array
  (
  self::ON_SAVE         => 'onSave',
  self::ON_SHOW         => 'onShow',
  self::ON_DELETE       => 'onDelete',
  self::ON_STEP_FORWARD => 'onStepForward',
  self::ON_FIRST_REACH  => 'onFirstReach',
  self::ON_STEP_BACK    => 'onStepBack',
  self::ON_STATUS_UP    => 'onStatusUp',
  self::ON_STATUS_DOWN  => 'onStatusDown',
  );


}//end class ECoreProcessStepEvent

