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
class ESearchTextStrict
{

  const EQUALS        = 1;

  const IS_NULL       = 5;
  
  const IS_NOT_NULL   = 6;

  /**
   * @var array
   */
  public static $text = array(
    self::EQUALS      => 'equals',
    self::IS_NULL     => 'is empty',
    self::IS_NOT_NULL => 'is not empty',
  );

}//end class ESearchTextStrict

