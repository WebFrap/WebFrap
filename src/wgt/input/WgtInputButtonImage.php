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
 * class WgtItemAutocomplete
 * Objekt zum generieren einer Inputbox
 * @package WebFrap
 * @subpackage tech_core
 */
class WgtInputButtonImage extends WgtInput
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * path to the icon
   *
   * @var string
   */
  protected $icon = null;

  /**
   * path to the icon
   *
   * @var string
   */
  public $size = null;

/*//////////////////////////////////////////////////////////////////////////////
// Getter and Setter
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * setter for the icon
   *
   * @param string $icon
   * @param string $size
   */
  public function setIcon($icon  , $size = 'xsmall' )
  {

    $this->icon = $icon;
    $this->size = $size;

  }//end public function setIcon($icon )

/*//////////////////////////////////////////////////////////////////////////////
// Logic
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Parser for the input field
   * @param array $attributes
   * @return String
   */
  public function build($attributes = array() )
  {

    if ($attributes ) 
      $this->attributes = array_merge($this->attributes, $attributes );

    if ( isset($this->attributes['type'] ) )
    {
      unset($this->attributes['type']);
    }

    $attributes = $this->asmAttributes();
    $src = View::$iconsWeb.$this->size.'/'.$this->icon;

    $this->html = '<input type="button" style="background-image:url('.$src.');background-position:2px center;" class="wgtButton icon" '.$attributes.' />'.NL;

    return $this->html;

  } // end public function build */

} // end class WgtItemInput


