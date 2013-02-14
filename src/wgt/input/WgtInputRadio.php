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
class WgtInputRadio extends WgtInput
{
/*//////////////////////////////////////////////////////////////////////////////
// attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Type vordefinieren
   * @var array
   */
  protected $attributes     = array( 'type' => 'radio' );

/*//////////////////////////////////////////////////////////////////////////////
// Getter and Setter
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @param $data
   */
  public function setElements( $data )
  {
    $this->data = $data;
  }//end public function setElements */

/*//////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * (non-PHPdoc)
   * @see src/wgt/WgtInput#element()
   */
  public function element()
  {

    $id = $this->getId();

    if( isset($this->attributes['value']) )
      unset($this->attributes['value']);

    unset($this->attributes['id']);

    $attribute = '';

    foreach( $this->attributes as $key => $value )
      $attribute .= $key.'="'.$value.'" ';

    $html = '';

    foreach( $this->data as $value => $label )
    {
      $html .= '<label class="wgt-label" for="'.$id.'_'.$value.'" >'.$label.'</label>
    <div class="wgt-input '.$this->width.'" ><input id="'.$id.'_'.$value.'" '.$attribute.' value="'.$value.'" /></div>'.NL;

    }

    return $html;

  }//end public function element */


  /**
   * @param array $attributes
   * @return string
   */
  public function build( $attributes = array() )
  {

    if( $attributes ) 
      $this->attributes = array_merge($this->attributes,$attributes);

    $id = $this->getId();

    $html = '<div class="wgt-box input" id="wgt-box-'.$id.'" >'.$this->element().'<div class="wgt-clear tiny" >&nbsp;</div></div>'.NL;

    return $html;

  }//end public function build */

}//end class WgtItemRadio

