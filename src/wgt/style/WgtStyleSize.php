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
class WgtStyleSize
  extends WgtStyleNode
{
////////////////////////////////////////////////////////////////////////////////
// attribute
////////////////////////////////////////////////////////////////////////////////

  /**
   * width
   * @var string
   */
  public $width   = null;

  /**
   * unit for the width, default is px
   *
   * @var string
   */
  public $widthUnit   = 'px';

  /**
   * height
   * @var string
   */
  public $height  = null;

  /**
   * unit for the height, default is px
   *
   * @var string
   */
  public $heightUnit  = 'px';

////////////////////////////////////////////////////////////////////////////////
// attribute
////////////////////////////////////////////////////////////////////////////////

  /**
   * @return string
   */
  public function build()
  {

    $style = '';

    // font
    if(!is_null($this->width))
      $style .= 'width:'.$this->width.$this->widthUnit.';';

    // font
    if(!is_null($this->height))
      $style .= 'height:'.$this->height.$this->heightUnit.';';

    return $style;


  }//end public function build */

} // end class WgtStyleSize


