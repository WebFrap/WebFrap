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
 * Ein Wert
 *   Abstand oben, unten, links und rechts
 * Zwei Werte
 *   Der erste Wert für den Abstand oben und unten, der Zweite links und rechts
 * Drei Werte
 *   Der erste Wert für den Abstand oben, der Zweite links und rechts und der Dritte unten
 * Vier Werte
 *   Der erste Wert für den Abstand oben, der Zweite rechts, der Dritte unten und der Vierte links
 *
 * @package WebFrap
 * @subpackage tech_core
 */
class WgtStyleMargin
  extends WgtStyleNode
{
////////////////////////////////////////////////////////////////////////////////
// attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @var string
   */
  public $css = null;

  /**
   *
   * @var unknown_type
   */
  public $top = null;

  /**
   *
   * @var unknown_type
   */
  public $bottom = null;

  /**
   *
   * @var unknown_type
   */
  public $left = null;

  /**
   *
   * @var unknown_type
   */
  public $right = null;

  /**
   *
   * @var unknown_type
   */
  public $unit = 'px';

////////////////////////////////////////////////////////////////////////////////
// buildr
////////////////////////////////////////////////////////////////////////////////



  /**
   * @return string
   */
  public function build()
  {

    $style = '';

    if( $this->css )
    {
      $style .= 'margin: '.$this->css.';';
    }
    else
    {
      if(!is_null($this->top))
        $style .= 'margin-top:'.$this->top.$this->unit.';';

      if(!is_null($this->bottom))
        $style .= 'margin-bottom:'.$this->bottom.$this->unit.';';

      if(!is_null($this->left))
        $style .= 'margin-left:'.$this->left.$this->unit.';';

      if(!is_null($this->right))
        $style .= 'margin-right:'.$this->right.$this->unit.';';
    }

    return $style;

  }//end public function build */



} // end class WgtStyleMargin


