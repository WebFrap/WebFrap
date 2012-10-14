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
class WgtWindowDefault
  extends WgtWindow
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * Enter description here...
   *
   * @var int
   */
  public $minWidth  = 300;

  /**
   * Enter description here...
   *
   * @var int
   */
  public $minHeight = 200;

  /**
   * Enter description here...
   *
   * @var int
   */
  public $width     = 950;

  /**
   * Enter description here...
   *
   * @var int
   */
  public $height    = 650;

  /**
   *
   * @var boolean
   */
  public $resizable = true;

  /**
   *
   * @var boolean
   */
  public $movable   = true;

  /**
   * Enter description here...
   *
   * @var boolean
   */
  public $closable  = true ;


} // end class WgtWindowDefault

