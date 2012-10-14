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
 * Logappender für die Ausgabe der Logmeldung in die Console
 * @package WebFrap
 * @subpackage tech_core
 */
class LobLogCli
  implements LibLogAdapter
{

  /**
   * (non-PHPdoc)
   * @see src/i/ILogAppender#logline()
   */
  public function logline( $time,  $level,  $file,  $line, $message, $exception )
  {
    echo "$time\t$level\t$file\t$line\t$message".NL;
  } // end public function logline */


} // end class LobLogCli

