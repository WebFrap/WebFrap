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
 * Das Interface für die Logappender
 *
 * @package WebFrap
 * @subpackage tech_core
 */
interface ILogAppender
{

  /** hinzufügen einer neuen Logline
   *
   * @param string  time  Zeitpunkt des Logeintrags
   * @param string  level Das Loglevel
   * @param string  file Die Datei der Loglinie
   * @param int     line Die Zeilennummer
   * @param string  message Die eigentliche Logmeldung
   * @param Exception  message Die eigentliche Logmeldung
   * @return void
   */
  public function logline($time,  $level,  $file,  $line,  $message, $exception );


} // end interface ILogAppender
