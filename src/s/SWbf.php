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
final class SWbf
{

  /** Privater Konstruktor zum Unterbinde von Instanzen
   */
  private function __construct(){}


  /**
   * Enter description here...
   *
   * @param string $version
   * @return string
   */
  public static function versionToString( $version )
  {
    return str_replace('.','x',$version);
  }//end public static function versionToString */


}// end final class SWbf


