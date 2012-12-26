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
class ETaskStatus
{
////////////////////////////////////////////////////////////////////////////////
// attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @var int
   */
  const ACTIVE = 0;

  /**
   * @var int
   */
  const DISABLED = 1;

  /**
   * @var int
   */
  const DELETED = 2;
 
  
  /**
   * @var array
   */
  public static $labels = array
  (
    self::ACTIVE    => 'Active',
    self::DISABLED  => 'Disabled',
    self::DELETED   => 'Deleted',
  );
  
  /**
   * @param string $key
   * @return string
   */
  public static function label( $key )
  {
    
    return isset( self::$labels[$key] ) 
      ? self::$labels[$key]
      : 'Active'; // no status? so it's not disabled... 
      
  }//end public static function label */

}//end class ETaskType

