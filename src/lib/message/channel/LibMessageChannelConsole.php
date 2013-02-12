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
 *
 * @package WebFrap
 * @subpackage tech_core
 */
class LibMessageChannelConsole
  extends LibMessageChannel
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  public $type = 'console';

  /**
   * (non-PHPdoc)
   * @see LibMessageChannel::getRenderer()
   */
  public function getRenderer()
  {

    if (!$this->renderer) {
      $this->renderer = new LibMessageRendererConsole();
    }

    return $this->renderer;

  }//end public function getRenderer */

  /* (non-PHPdoc)
   * @see LibMessageChannel::send()
   */
  public function send( $message, $receivers )
  {
    // TODO Auto-generated method stub

  }//end public function send */

} // end LibMessageChannelConsole
