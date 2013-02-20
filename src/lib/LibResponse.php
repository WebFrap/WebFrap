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
class LibResponse extends PBase
{

  public $view = null;

  /**
   * Setup der Response
   */
  public function init()
  {

    $this->getI18n();

  }//end public function init */

  /**
   * Ausgabe
   */
  public function out()
  {

  }//end public function init */

  /**
   * @return LibResponseContext
   */
  public function createContext()
  {
    return new LibResponseContext($this );

  }//end public function createContext */

} // end LibResponse

