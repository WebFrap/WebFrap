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
 * Objekt zum generieren einer Inputbox
 * @package WebFrap
 * @subpackage tech_core
 */
class WgtInputMoney extends WgtInput
{

  /**
   * @var string
   */
  public $size = 'small';
  
  /**
   * @param array $attributes
   * @return string
   */
  public function build( $attributes = array() )
  {
    
    $id = $this->getId();
    
    if( $attributes )
      $this->attributes = array_merge($this->attributes,$attributes);

    // add the date validator for datepicker
    if (!isset($this->attributes['class']) )
      $this->attributes['class'] = 'small wcm wcm_ui_money ar';
    else
      $this->attributes['class'] .= ' wcm wcm_ui_money ar';
      
    $icon = View::$iconsWeb;
      
    $this->texts->afterInput = <<<HTML
        <var>{"button":"{$id}-ap-button"}</var>
        <button 
        	id="{$id}-ap-button" 
        	class="wgt-button append just-annotate"
        	tabindex="-1"  >
          <img class="icon xsmall" src="{$icon}xsmall/control/money.png" />
        </button>
    
HTML;

    return parent::build();

  } // end public function build */

} // end class WgtItemInput


