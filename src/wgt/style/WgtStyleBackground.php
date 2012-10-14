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


/*
background-attachment   Hintergrund fixieren  fixed, scroll, Inherit
 Hintergrundbild   url(), none, Inherit
Prozentangabe Längenangabe
Längenangabe Prozentangabe
Schlüsselwort Schlüsselwort, Inherit
 */

/**
 * @package WebFrap
 * @subpackage tech_core
 */
class WgtStyleBackground
  extends WgtStyleNode
{
////////////////////////////////////////////////////////////////////////////////
// attribute
////////////////////////////////////////////////////////////////////////////////

  /**
   * css
   * @var string
   */
  public $css = null;

  /**
   * Hexvalue Color
   * @var string
   */
  public $color = null;

  /**
   *  background-image
   * @var string
   */
  public $image = null;

  /**
   * Hintergrund wiederholen
   * css: background-repeat
   *
   * @validValue
   * {
   * 'no-repeat',
   * 'repeat',
   * 'repeat-x',
   * 'repeat-y',
   * 'Inherit'
   * }
   * @var string
   */
  public $repeat = null;

  /**
   * background-position
   * @var string
   */
  public $position = null;

////////////////////////////////////////////////////////////////////////////////
// attribute
////////////////////////////////////////////////////////////////////////////////

  /**
   * @return string
   */
  public function build()
  {

    if( $this->css )
      return 'background: '.$this->css.';';

    $style = '';

    // background-image
    if(!is_null($this->image))
      $style .= 'background-image:url(\''.$this->image.'\');';

    // font
    if(!is_null($this->color))
      $style .= 'background-color:'.$this->color.';';

    // background-repeat
    if(!is_null($this->repeat))
      $style .= 'background-repeat:'.$this->repeat.';';

    // background-position
    if(!is_null($this->position))
      $style .= 'background-position:'.$this->position.';';

    return $style;


  }//end public function build */

} // end class WgtStyleBackground


