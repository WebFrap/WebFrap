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
class EMessageStatus
{
/*//////////////////////////////////////////////////////////////////////////////
// attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var int
   */
  const IS_NEW = 1;

  /**
   * @var int
   */
  const OPEN = 2;

  /**
   * @var int
   */
  const ARCHIVED = 3;

  /**
   * @var array
   */
  public static $labels = array
  (
    self::IS_NEW   => 'New',
    self::OPEN     => 'Opened',
    self::ARCHIVED => 'Archived',
  );

  /**
   * @param string $key
   * @return string
   */
  public static function label($key )
  {
    return isset( self::$labels[$key] )
      ? self::$labels[$key]
      : 'New';

  }//end public static function label */

}//end class EMessageStatus

