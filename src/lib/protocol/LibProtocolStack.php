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
 * Class to create simple protocols
 * @package WebFrap
 * @subpackage tech_core
 *
 */
class LibProtocolStack
{

  public $stack = array();

  /** Default constructor
   *  the conf and open a file
   *
   */
  public function __construct( )
  {

  }//end public function __construct */

  /** Schreiben der Loglinie in das Logmedium
   *
   *
   * @param string message Die eigentliche Logmeldung
   * @return

   */
  public function write($message )
  {

    $this->stack[] = $message;

  } // end public function write */

  /**
   * Leere des Protocol Stacks
   */
  public function clear()
  {
    $this->stack = array();
  }//end protected function clear */

  public function render()
  {
    return implode( NL, $this->stack );

  }//end public function render */

} // end LibProtocolStack

