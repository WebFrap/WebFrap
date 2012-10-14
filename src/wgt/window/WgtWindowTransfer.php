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
class WgtWindowTransfer
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
  public $top           = 200 ;

  /**
   * Enter description here...
   *
   * @var int
   */
  public $left          = 200 ;

  /**
   * Enter description here...
   *
   * @var int
   */
  public $minWidth      = 550 ;

  /**
   * Enter description here...
   *
   * @var int
   */
  public $minHeight     = 300 ;

  /**
   * Enter description here...
   *
   * @var int
   */
  public $width         = 1100;

  /**
   * Enter description here...
   *
   * @var int
   */
  public $height        = 600 ;

  /**
   * Enter description here...
   *
   * @var boolean
   */
  public $visible       = true ;

  /**
   * Enter description here...
   *
   * @var boolean
   */
  public $resizableX    = false ;

  /**
   * Enter description here...
   *
   * @var boolean
   */
  public $resizableY    = false;

  /**
   * Enter description here...
   *
   * @var boolean
   */
  public $movable       = true ;

  /**
   * Enter description here...
   *
   * @var boolean
   */
  public $closable      = true ;

  /**
   * Enter description here...
   *
   * @var boolean
   */
  public $maximizable   = false ;


} // end class WgtWindowDefault

