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
class WgtWindowTemplate
  extends WgtWindow
{
////////////////////////////////////////////////////////////////////////////////
// mode
////////////////////////////////////////////////////////////////////////////////

  /**
   *
   * @var Ui
   */
  public $ui     = null;

////////////////////////////////////////////////////////////////////////////////
// getter & setter
////////////////////////////////////////////////////////////////////////////////

  /**
   * @return void
   */
  public function init()
  {

    $this->minWidth  = 300;
    $this->minHeight = 200;
    $this->width     = 950;
    $this->height    = 650;
    $this->resizable = true;
    $this->movable   = true;
    $this->closable  = true;

    $this->models    = new TArray();

  }//end public function init */



} // end class WgtWindowTemplate

