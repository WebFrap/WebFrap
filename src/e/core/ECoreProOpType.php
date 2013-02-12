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
class ECoreProOpType
{

  /**
   * it's an url
   * @var int
   */
  const URL           = 1;

  /**
   * it's an action
   * @var int
   */
  const ACTION        = 2;

  /**
   * Key map
   * @var array
   */
  public static $text = array
  (
    self::URL       => 'core.enum.type.url',
    self::ACTION    => 'core.enum.type.action',
  );

}//end class ECoreProOpType
