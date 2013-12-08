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
 * Logappender der einfach die Logmeldungen sammelt
 * @package WebFrap
 * @subpackage tech_core
 */
class LibLogCollector implements LibLogAdapter
{

  /**
   */
  public static $loglines = array();

  /**
   * (non-PHPdoc)
   * @see src/i/ILogAppender#logline()
   */
  public function logline($time,  $level,  $file,  $line,  $message, $exception)
  {
    self::$loglines[] = array($time,  $level,  $file, $line, $message);
  } // end public function logline */

} // end class LibLogCollector

