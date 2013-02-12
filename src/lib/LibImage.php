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
 * @package WebFrap
 * @subpackage tech_core
 */
class LibImage
{
////////////////////////////////////////////////////////////////////////////////
// Static Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @var LibImageAdapter
   */
  private static $defAdapter = null;

////////////////////////////////////////////////////////////////////////////////
// static getter
////////////////////////////////////////////////////////////////////////////////

  /**
   * @return LibImageAdapter
   */
  public static function getAdapter(  )
  {

    if( !self::$defAdapter )
      self::$defAdapter = new LibImage_Gd();

    return self::$defAdapter;

  }//end public static function getAdapter */

  /**
   * @return LibImageAdapter
   */
  public static function newAdapter(  )
  {
    return new LibImage_Gd();

  }//end public static function newAdapter */

}//end class LibImage
