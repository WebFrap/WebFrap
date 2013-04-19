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
 * Render Element für Form Elemente
 *
 * @package WebFrap
 * @subpackage tech_core
 */
class WgtRndForm
{

  /**
   * Rendern eines Buttons
   *
   * @param string $name
   * @param string $value
   * @param array $attributes
   * @return string
   */
  public static function button($value , $attributes = array() , $ro = false)
  {

    $ro =  $ro ? ' readonly="readonly" ':'';

    if (! isset($attributes['id'])  )
      $attributes['id'] = 'wgt_submit_'.uniqid();

    $attr = Wgt::asmAttributes($attributes);

    return '<button class="wgt-button" '.$attr.' '.$ro.' >'.$value.'</button>';

  }//end public static function button */

  /**
   * create a selectbox
   *
   * @param string $name
   * @param boolean $checked
   * @param array $attributes
   * @param boolean $ro
   * @return unknown
   */
  public static function checkbox($name , $checked , $attributes = array() , $ro = false)
  {

    $checked = ($checked && $checked != 'f')   ? ' checked="checked" ':'';
    $ro =  $ro ? ' disabled="disabled" ':'';

    if (! isset($attributes['id'])  )
      $attributes['id'] = 'wgtid_check_'.uniqid();

    $attr = Wgt::asmAttributes($attributes);

    return '<input type="checkbox" name="'.$name.'" '.$checked.' '.$attr.' '.$ro.' />';

  }//end public static function checkbox */

  /**
   * create a selectbox
   *
   * @param string $name
   * @param array $attributes
   * @param boolean $ro
   * @return unknown
   */
  public static function file($name , $attributes = array() , $ro = false)
  {

    $ro =  $ro ? ' disabled="disabled" ':'';

    if (! isset($attributes['id'])  )
      $attributes['id'] = 'wgtid_check_'.uniqid();

    $attr = Wgt::asmAttributes($attributes);

    return '<input type="file" name="'.$name.'" '.$attr.' '.$ro.' />';

  }//end public static function file */

  /**
   * create an input field
   *
   * @param string $name
   * @param string $value
   * @param array $attributes
   * @return string
   */
  public static function input($name , $value = '',  $attributes = array() , $ro = false)
  {

    $ro =  $ro ? ' readonly="readonly" ':'';

    if (! isset($attributes['id'])  )
      $attributes['id'] = 'wgtid_input_'.uniqid();

    $attr = Wgt::asmAttributes($attributes);

    return '<input type="text" name="'.$name.'" value="'.$value.'" '.$attr.' '.$ro.' />';

  }//end public static function input */

  /**
   * @param string $name
   * @param string $value
   * @param string $label
   * @param string $subName
   */
  public static function inputBox($name, $value, $label, $subName = null, $params = array())
  {

    if ($subName) {
      $id      = $subName."-".$name;
      $inpName = $subName."[$name]";
    } else {
      $id      = $name;
      $inpName = $name;
    }

    $size = 'medium';

    if (isset($params['size']))
      $size = $params['size'];

    $inpAddr = '';

    if (isset($params['readonly']) && $params['readonly'])
      $inpAddr .= ' readonly="readonly" ';

    $html = <<<CODE

<div id="wgt_box_{$id}">
  <label for="wgt-input-{$id}" class="wgt-label">{$label}</label>
  <div class="wgt-input" >
    <input
      type="text"
      value="{$value}"
      class="{$size}"
      id="wgt-input-{$id}"
      name="{$inpName}" {$inpAddr}  />
  </div>
</div>

CODE;

    return $html;

  }//end public static function inputBox */

  /**
   * create an input field
   *
   * @param string $name
   * @param string $value
   * @param array $attributes
   * @return string
   */
  public static function password($name , $value = '',  $attributes = array() , $ro = false)
  {

    $ro =  $ro ? ' readonly="readonly" ':'';

    if (! isset($attributes['id'])  )
      $attributes['id'] = 'wgtid_input_'.uniqid();

    $attr = Wgt::asmAttributes($attributes);

    return '<input type="password" name="'.$name.'" value="'.$value.'" '.$attr.' '.$ro.' />';

  }//end public static function password */

  /**
   * create an input field
   *
   * @param string $name
   * @param string $value
   * @param array $attributes
   * @return string
   */
  public static function inputImage($name , $src, $value = '',  $attributes = array() , $ro = false)
  {

    $ro =  $ro ? ' readonly="readonly" ':'';

    if (! isset($attributes['id'])  )
      $attributes['id'] = 'wgtid_input_'.uniqid();

    $src = View::$iconsWeb.'xsmall/'.$src;

    $attr = Wgt::asmAttributes($attributes);

    return '<span '.$attr.' ><img src="'.$src.'" name="'.$name.'" '.$ro.' />'.$value.'</span>';

  }//end public static function inputImage */

  /**
   * Enter description here...
   *
   * @param string $value
   * @param array $attributes
   * @param boolean $ro
   * @return string
   */
  public static function submit($value , $attributes = array() , $ro = false)
  {

    $ro =  $ro ? ' readonly="readonly" ':'';

    if (! isset($attributes['id'])  )
      $attributes['id'] = 'wgt_submit_'.uniqid();

    $attr = Wgt::asmAttributes($attributes);

    return '<input type="submit" class="wgt-button submit" value="'.$value.'" '.$attr.' '.$ro.' />';

  }//end public static function submit */

  /**
   * create an input field
   *
   * @param string $name
   * @param string $value
   * @param array $attributes
   * @return string
   */
  public static function fakeButton($value , $href , $attributes = array())
  {

    if (! isset($attributes['id'])  )
      $attributes['id'] = 'wgt-button_'.uniqid();

    if (isset($attributes['class'])  )
      $attributes['class'] .= ' wgt-button';
    else
      $attributes['class'] = 'wgt-button';

    $attr = Wgt::asmAttributes($attributes);

    return '<a href="'.$href.'" '.$attr.'  >'.$value.'</a>';

  }//end public static function button */

  /**
   * create an input field
   *
   * @param string $name
   * @param string $value
   * @param array $attributes
   * @return string
   */
  public static function reset($value , $attributes = array() , $ro = false)
  {

    $ro =  $ro ? ' readonly="readonly" ':'';

    if (! isset($attributes['id'])  )
      $attributes['id'] = 'wgt_submit_'.uniqid();

    $attr = Wgt::asmAttributes($attributes);

    return '<input type="reset" class="wgt-button submit" value="'.$value.'" '.$attr.' '.$ro.' />';

  }//end public static function reset */

  /**
   * create an input field
   *
   * @param string $name
   * @param string $value
   * @param array $attributes
   * @return string
   */
  public static function hidden($name , $value = '',  $attributes = array()  )
  {

    if (! isset($attributes['id'])  )
      $attributes['id'] = 'wgt-input-'.uniqid();

    $attr = Wgt::asmAttributes($attributes);

    return '<input type="hidden"  name="'.$name.'" value="'.$value.'" '.$attr.' />';

  }//end public static function hidden */

  /**
   * create a textarea
   *
   * @param string $name
   * @param string $value
   * @param array $attributes
   * @return string
   */
  public static function textarea($name , $value = '',  $attributes = array() , $ro = false)
  {

    $ro =  $ro ? ' readonly="readonly" ':'';

    if (! isset($attributes['id'])  )
      $attributes['id'] = 'wgt-input-'.uniqid();

    $attr = Wgt::asmAttributes($attributes);

    return '<textarea type="text" name="'.$name.'" '.$attr.' '.$ro.' />'.$value.'</textarea>';

  }//end public static function textarea */

  /**
   * Enter description here...
   *
   * @param string $data
   * @return string
   */
  public static function labeldElement($label , $content)
  {
    return '<div class="wgt_box">
      <label class="wgt-label" >'.$label.'</label>
      <div class="wgt-input" >'.$content.'</div>
      </div>';
  }//end public static function labeldElement */

  /**
   *
   * @param $data
   * @param $attributes
   * @param $activ
   * @return unknown_type
   */
  public static function selectbox($data , $attributes = array()  , $params = null)
  {

    if (is_string($attributes)) {
      $attributes = ' name="'.$attributes.'" ';
    }

    $attributes = Wgt::asmAttributes($attributes);

    if (!$params)
      $params = new TArray();

    $select = '<select '.$attributes.' '.$params->multiple.' '.$params->size.' >'.NL;

    if (!is_null($params->firstFree)) {
      $select .= '<option value=" ">'.$params->firstFree.'</option>'.NL;
    }

    foreach ($data as $row) {
      $value  = $row['value'];
      $id     = $row['id'];

      $selected = ($params->activ == $id)? 'selected="selected"' : '';
      $select .= '<option '.$selected.' value="'.$id.'">'.$value.'</option>'.NL;
    }

    $select .= '</select>'.NL;

    return $select;

  }//end public static function selectbox */

}//end class Wgt

