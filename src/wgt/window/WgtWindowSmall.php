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
class WgtWindowSmall
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
  public $width     = 400;

  /**
   * Enter description here...
   *
   * @var int
   */
  public $height    = 300;

  /**
   *
   * @var boolean
   */
  public $resizable = false;

  /**
   *
   * @var boolean
   */
  public $movable   = false;

  /**
   * Enter description here...
   *
   * @var boolean
   */
  public $closable  = true ;


} // end class WgtWindowDefault

