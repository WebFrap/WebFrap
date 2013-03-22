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
final class SParserArray
{

  /** Privater Konstruktor zum Unterbinde von Instanzen
   */
  private function __construct(){}

  /**
   * fusion the first layer of a multidim array
   *
   * @param array $arr
   * @return array
   */
  public static function multiDimFusion($arr)
  {

    $data = array();

    foreach ($arr as $tmp) {
      foreach ($tmp as $tmp2) {
        ///FIXME figure out why php5.2.5 needs a trim() here an earlier versions not
        $data[] = trim($tmp2);
      }
    }

    return $data;

  }//end public static function childParentFusion */

}// end class SParserString

