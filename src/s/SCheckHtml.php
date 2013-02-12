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
class SCheckHtml
{

  /**
   * @param string $allClasses
   * @param string $classToCheck
   */
  public static function hasClass( $allClasses, $classToCheck )
  {

    $tmp = explode( ' ', $allClasses );

    if( in_array( $classToCheck, $tmp ) )

      return true;

    return false;

  }//end public static function hasClass */

}// end class SCheckHtml
