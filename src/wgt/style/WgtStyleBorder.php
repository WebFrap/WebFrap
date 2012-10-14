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
 * border         Rahmen
 * border-color   Rahmenfarbe   transparent, Eine der Farbangabe, Inherit
 * border-width   Rahmenbreite  thin, medium, thick, Längenangabe, Inherit
 * border-style   Rahmenart   none, dotted, dashed, solid, double, groove, ridge, inset, outset, Inherit
 *
 * border-bottom        Rahmen unten  Die Werte für
 * border-bottom-color  Rahmenfarbe unten   Eine der Farbangabe
 * border-bottom-style  Rahmenart unten   none, dotted, dashed, solid, double, groove, ridge, inset, outset, Inherit
 * border-bottom-width  Rahmenbreite unten  thin, medium, thick, Längenangabe, Inherit
 *
 * border-left          Rahmen links  Die Werte für
 * border-left-color    Rahmenfarbe links   Eine der Farbangabe
 * border-left-style    Rahmenart links   none, dotted, dashed, solid, double, groove, ridge, inset, outset, Inherit
 * border-left-width    Rahmenbreite links  thin, medium, thick, Längenangabe, Inherit
 *
 * border-right         Rahmen rechts   Die Werte für
 * border-right-color   Rahmenfarbe rechts  Eine der Farbangabe
 * border-right-style   Rahmenart rechts  none, dotted, dashed, solid, double, groove, ridge, inset, outset, Inherit
 * border-right-width   Rahmenbreite rechts   thin, medium, thick, Längenangabe, Inherit
 *
 * border-top           Rahmen oben   Die Werte für
 * border-top-color     Rahmenfarbe oben  Eine der Farbangabe
 * border-top-style     Rahmenart oben  none, dotted, dashed, solid, double, groove, ridge, inset, outset, Inherit
 * border-top-width     Rahmenbreite oben   thin, medium, thick, Längenangabe, Inherit
 *
 * @package WebFrap
 * @subpackage tech_core
 */
class WgtStyleBorder
  extends WgtStyleNode
{
////////////////////////////////////////////////////////////////////////////////
// attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @var string
   */
  public $color = null;

  /**
   * @var string
   */
  public $width = null;

  /**
   * @var string
   */
  public $style = null;

  /**
   * @var string
   */
  public $css = null;

////////////////////////////////////////////////////////////////////////////////
// buildr
////////////////////////////////////////////////////////////////////////////////

  /**
   * Implementieren eines Getters für die StyleElemente
   *
   * @return WgtStyleNode
   */
  public function __get( $type )
  {

    if(!isset( $this->subStyle[$type] ))
    {
      $this->subStyle[$type] = new WgtStyleBorder;
    }

    return $this->subStyle[$type];

  }//end public function __get */

  /**
   * @return string
   */
  public function build()
  {

    $style = '';

    if( $this->css )
    {
      $style .= 'border: '.$this->css.';';
    }
    else if( $this->color && !is_null($this->width) && $this->style )
    {
      $style .= 'border: '.$this->width.'px '.$this->style.' '.$this->color.';';
    }
    else
    {
      if($this->color)
        $style .= 'border-color:'.$this->color.';';

      if(!is_null($this->width))
        $style .= 'border-width:'.$this->width.';';

      if($this->style)
        $style .= 'border-style:'.$this->style.';';
    }

    foreach( $this->subStyle  as $key => $subStyle )
    {
      $style .= $subStyle->subParser( $key );
    }

    return $style;

  }//end public function build */

  /**
   * @param string $subName
   */
  public function subParser( $subName )
  {
    $style = '';

    if( $this->css )
    {
      $style .= 'border-'.$subName.': '.$this->css.';';
    }
    else if( $this->color && !is_null($this->width) && $this->style )
    {
      $style .= 'border-'.$subName.': '.$this->width.'px '.$this->style.' '.$this->color.';';
    }
    else
    {
      if($this->color)
        $style .= 'border-'.$subName.'-color:'.$this->color.';';

      if(!is_null($this->width))
        $style .= 'border-'.$subName.'-width:'.$this->width.';';

      if($this->style)
        $style .= 'border-'.$subName.'-style:'.$this->style.';';
    }

    return $style;

  }//end public function subParser */

} // end class WgtStyleBorder


