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
 * @package WebFrap
 * @subpackage tech_core
 */
class WgtInputTime extends WgtInput
{

  public $size = 'small';

  /**
   * @param array $attributes
   * @return unknown_type
   */
  public function build($attributes = array())
  {

    if ($attributes)
      $this->attributes = array_merge($this->attributes,$attributes);

    // ist immer ein text attribute
    $this->attributes['type']= 'text';

    // add the date validator for datepicker
    if (!isset($this->attributes['class'])) {
      $this->classes['wcm'] = 'wcm';
      $this->classes['wcm_ui_timepicker'] = 'wcm_ui_timepicker';
      $this->classes['small'] = 'small';
      $this->classes['valid_time'] = 'valid_time';
      $this->classes['ar'] = 'ar';
    } else {
      $this->classes['wcm'] = 'wcm';
      $this->classes['wcm_ui_timepicker'] = 'wcm_ui_timepicker';
      $this->classes['valid_time'] = 'valid_time';
      $this->classes['ar'] = 'ar';
    }

    $icon = View::$iconsWeb;

    $id = $this->getId();

    $this->texts->afterInput = <<<HTML
        <var>{"button":"{$id}-ap-button"}</var>
        <button
          id="{$id}-ap-button"
          class="wgt-button append"
          tabindex="-1"  >
          <img class="icon xsmall" src="{$icon}xsmall/control/clock.png" />
        </button>

HTML;

    return parent::build();

  } // end public function build */

  /**
   * Parser for the input field
   *
   * @return String
   */
  public function buildAjaxArea()
  {

    if (!isset($this->attributes['id']))
      return '';

    if (!isset($this->attributes['value']))
      $this->attributes['value'] = '';

    $html = '<htmlArea selector="input#'.$this->attributes['id'].'" action="value" ><![CDATA['
      .$this->attributes['value'].']]></htmlArea>'.NL;

    return $html;

  } // end public function buildAjaxArea */

} // end class WgtInputTime

