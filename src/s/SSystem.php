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
final class SSystem
{

  /** Privater Konstruktor zum Unterbinde von Instanzen
   */
  private function __construct() {}

  /**
   * @param string $command
   * @return string
   */
  public static function call($command)
  {

    $result = '';
    if ($proc = popen("($command)2>&1","r")) {
      while (!feof($proc))
        $result .= fgets($proc, 1000);

      pclose($proc);

      return $result;
    }

    return null;

  }//end public static function call */

}// end final class SSystem

