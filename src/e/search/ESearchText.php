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
class ESearchText
{

  const EQUALS        = 1;
  
  const START_WITH    = 2;

  const CONTAINS      = 3;
  
  const END_WITH      = 4;

  const IS_NULL       = 5;
  
  const IS_NOT_NULL   = 6;

  /**
   * @var array
   */
  public static $text = array(
    self::EQUALS      => 'equals',
    self::START_WITH  => 'starts with',
    self::CONTAINS    => 'contains',
    self::END_WITH    => 'ends with',
    self::IS_NULL     => 'is empty',
    self::IS_NOT_NULL => 'is not empty',
  );

}//end class ESearchText

