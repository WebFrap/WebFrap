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
 * @todo implement me
 */
class LibLogMail
  implements LibLogAdapter
{

  /**
   *
   * @param array $conf
   */
  public function __construct( $conf )
  {

    throw NotYetImplementedException('Not yet implemented!!!');

  } // end public function __construct */

  /**
   * (non-PHPdoc)
   * @see src/i/ILogAppender#logline()
   */
  public function logline( $time,  $level,  $file,  $line,  $message, $exception )
  {
    echo "$time\t$level\t$file\t$line\t$message".NL;
  } // end public function logline */

} // end class LibLogMail
