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
class WgtInputDate extends WgtInput
{

  /**
   * @param array $attributes
   * @return string
   */
  public function build($attributes = array() )
  {
    
    $id = $this->getId();
    
    if ($attributes )
      $this->attributes = array_merge($this->attributes,$attributes);

    // add the date validator for datepicker
    if (!isset($this->attributes['class']) )
    {
      $this->classes['small'] = 'small';
      $this->classes['wcm'] = 'wcm';
      $this->classes['wcm_ui_date'] = 'wcm_ui_date';
      $this->classes['ar'] = 'ar';
    } else {
      $this->classes['small'] = 'small';
      $this->classes['wcm'] = 'wcm';
      $this->classes['wcm_ui_date'] = 'wcm_ui_date';
      $this->classes['ar'] = 'ar';
    }

    $icon = View::$iconsWeb;
      
    $this->texts->afterInput = <<<HTML
        <var>{"button":"{$id}-ap-button"}</var>
        <button 
        	id="{$id}-ap-button" 
        	class="wgt-button append"
        	tabindex="-1"  >
          <img class="icon xsmall" src="{$icon}xsmall/control/calendar.png" alt="Calendar" />
        </button>
    
HTML;

    return parent::build();

  } // end public function build */

} // end class WgtInputDate


