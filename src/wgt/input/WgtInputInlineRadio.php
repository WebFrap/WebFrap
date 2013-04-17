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
class WgtInputInlineRadio extends WgtInput
{
/*//////////////////////////////////////////////////////////////////////////////
// attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var array
   */
  public $attributes     = array();

/*//////////////////////////////////////////////////////////////////////////////
// Getter and Setter
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @param $data
   */
  public function setElements($data)
  {
    $this->data = $data;
  }//end public function setElements */

  /**
   */
  public function setActive($activ = true)
  {
    $this->activ = $activ;
  }//end public function setActiv */

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

      if (isset($this->attributes['value']))
        unset($this->attributes['value']);

      if (isset($this->attributes['type']))
        unset($this->attributes['type']);

      unset($this->attributes['id']);

      $attribute = '';
      foreach ($this->attributes as $key => $value)
        $attribute .= $key.'="'.$value.'" ';

      $html = '<ul class="wgt_list inline" >';

      foreach ($this->data as $value => $label) {
        $checked = '';

        if ($this->activ == $value)
          $checked = ' selected="selected" ';

        $html .= '<li>'.$label.'<br /><input type="radio" '.$attribute.'  id="'.$id.'_'.$value.'" '.$checked.' value="'.$value.'" /></li>'.NL;
      }

      $html .= '</ul>';

      return $html;

  }//end public function element */

  /**
   *
   * @param $attributes
   * @return unknown_type
   */
  public function build($attributes = array())
  {

    if ($attributes) $this->attributes = array_merge($this->attributes,$attributes);

    $id = $this->getId();

    $html = '<div class="wgt-box input" id="wgt-box-'.$id.'" >'.$this->element().'<div class="wgt-clear tiny" >&nbsp;</div></div>'.NL;

    return $html;

  }//end public function build */

}//end class WgtInputInlineRadio

