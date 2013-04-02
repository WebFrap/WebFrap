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
class ESearchBoolean
{

  const IS_TRUE       = 1;

  const IS_FALSE      = 2;
  
  const IS_T_OR_F     = 3;

  const IS_NULL       = 4;

  /**
   * Minimale liste potentiell vorhandener serverbetriebsysteme
   *
   * @var array
   */
  public static $text = array(
    self::IS_TRUE      => 'True',
    self::IS_FALSE     => 'False',
    self::IS_T_OR_F    => 'True or False',
    self::IS_NULL      => 'Is not Set',
  );

}//end class ESearchBoolean

