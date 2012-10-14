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
 *
 * font-family:   Schriftfamilie  Schriftart, Inherit
 * font-size:     Schriftgröße  Längenangabe, Prozentangabe, xx-small, x-small, small, smaller, medium, large, x-large, xx-large, larger, Inherit
 * font-style:    Schriftstil   italic, oblique, normal, Inherit
 * font-variant:  Kapitälchen   small-caps, normal, Inherit
 * font-weight:   Schriftgewicht  normal, bold, bolder, lighter, 100 - 900, Inherit
 *
 * color:         Vordergrundfarbe  Farbangabe, Inherit
 *
 * direction:       Schreibrichtung   ltr, rtl, Inherit
 * letter-spacing:  Zeichenabstand  normal, Längenangabe, Inherit
 * line-height:     Zeilenhöhe  normal, Zahl, Längenangabe oder Prozentangabe, Inherit
 * text-align:      Horizontale Ausrichtung   left,right,center,justify, Inherit
 * text-decoration: Textdekoration  none, underline, overline, line-through, blink, Inherit
 * text-indent:     Texteinrückung  Längen- oder Prozentangabe, Inherit
 * text-transform:  Großschreibung  lowercase, uppercase, capitalize, none, Inherit
 * unicode-bidi:    Vertikale Ausrichtung   normal, embed, bidi-override, Inherit
 * vertical-align:  Vertikale Ausrichtung   Längen- oder Prozentangabe, sub,super, baseline, top, bottom, middle, text-top, text-bottom, Inherit
 * white-space:     Textumbruch   normal, pre, nowrap, pre-line, pre-wrap, Inherit
 * word-spacing:    Wortabstand   Längenangabe, normal, Inherit
 * text-shadow:     Textschatten  Farbangabe, Längenangabe
 *
 * @package WebFrap
 * @subpackage tech_core
 */
class WgtStyleText
  extends WgtStyleNode
{
////////////////////////////////////////////////////////////////////////////////
// font attribute
////////////////////////////////////////////////////////////////////////////////

  /**
   * font-family
   * @var string
   */
  public $font      = null;

  /**
   * font-size:
   * @var int
   */
  public $size      = null;

  /**
   * font-size
   * @var string
   */
  public $sizeUnit  = 'px';

  /**
   * font-style
   * @var string
   */
  public $style     = null;

  /**
   * font-variant
   * @var string
   */
  public $variant   = null;

  /**
   * font-weight
   * @var string
   */
  public $weight   = null;

////////////////////////////////////////////////////////////////////////////////
// color attribute
////////////////////////////////////////////////////////////////////////////////

  /**
   * color
   * @var string
   */
  public $color     = null;

////////////////////////////////////////////////////////////////////////////////
// text attribute
////////////////////////////////////////////////////////////////////////////////

  /**
   * direction
   * @var unknown_type
   */
  public $direction = null;

  /**
   * letter-spacing
   * @var string
   */
  public $letterSpacing = null;

  /**
   * line-height
   * @var string
   */
  public $lineHeight = null;


  /**
   * text-align
   * @var string
   */
  public $align     = null;


  /**
   * text-decoration
   * @var string
   */
  public $decoration     = null;


  /**
   * text-indent
   * @var string
   */
  public $indent = null;

  /**
   * text-transform
   * @var string
   */
  public $transform = null;

  /**
   * unicode-bidi
   * @var string
   */
  public $bidi = null;

  /**
   * vertical-align
   * @var string
   */
  public $valign = null;

  /**
   * white-space
   * @var string
   */
  public $whiteSpace = null;

  /**
   * word-spacing
   * @var string
   */
  public $wordSpace = null;

  /**
   * text-shadow
   * @var string
   */
  public $textShadow = null;


////////////////////////////////////////////////////////////////////////////////
// method
////////////////////////////////////////////////////////////////////////////////

  /**
   * @return string
   */
  public function build()
  {

    $style = '';

    // font
    if(!is_null($this->font))
      $style .= 'font-family:'.$this->font.';';

    if(!is_null($this->size))
      $style .= 'font-size:'.$this->size.$this->sizeUnit.';';

    if(!is_null($this->style))
      $style .= 'font-style:'.$this->style.';';

    if(!is_null($this->variant))
      $style .= 'font-variant:'.$this->variant.';';

    if(!is_null($this->weight))
      $style .= 'font-weight:'.$this->weight.';';

    // color
    if(!is_null($this->color))
      $style .= 'color:'.$this->color.';';

    // text
    if(!is_null($this->direction))
      $style .= 'direction:'.$this->direction.';';

    if(!is_null($this->letterSpacing))
      $style .= 'letter-spacing:'.$this->letterSpacing.';';

    if(!is_null($this->lineHeight))
      $style .= 'line-height:'.$this->lineHeight.';';

    if(!is_null($this->align))
      $style .= 'text-align:'.$this->align.';';

    if(!is_null($this->decoration))
      $style .= 'text-decoration:'.$this->decoration.';';

    if(!is_null($this->indent))
      $style .= 'text-indent:'.$this->indent.';';

    if(!is_null($this->transform))
      $style .= 'text-transform:'.$this->transform.';';

    if(!is_null($this->bidi))
      $style .= 'unicode-bidi:'.$this->bidi.';';

    if(!is_null($this->valign))
      $style .= 'vertical-align:'.$this->valign.';';

    if(!is_null($this->whiteSpace))
      $style .= 'white-space:'.$this->whiteSpace.';';

    if(!is_null($this->wordSpace))
      $style .= 'word-spacing:'.$this->wordSpace.';';

    if(!is_null($this->textShadow))
      $style .= 'text-shadow:'.$this->textShadow.';';

    return $style;


  }//end public function build */

} // end class WgtStyleText


