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
 * Container für url methoden
 * @package WebFrap
 * @subpackage tech_core
 */
final class SValid
{

  /** Privater Konstruktor zum Unterbinde von Instanzen
   */
  private function __construct(){}

  /**
   * Extrahieren der ACL Teile der URL zusammebauen zu einem
   * validen ACL Url String
   * @param TFlowFlag $params
   * @return string
   */
  public static function text($text )
  {
    return htmlentities($text,null,'UTF-8');

  }//end public static function buildAcl */

}// end final class SValid

