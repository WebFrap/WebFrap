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
class WgtInputInput extends WgtInput
{

  /**
   * @param string $iconImg
   */
  public function setAppendButton( $iconImg )
  {
    
    $icon = View::$iconsWeb;
    $id   = $this->getId();
      
    $this->texts->afterInput = <<<HTML
        <var>{"button":"{$id}-ap-button"}</var>
        <button 
        	id="{$id}-ap-button" 
        	class="wgt-button append"
        	tabindex="-1"  >
          <img class="icon xsmall" src="{$icon}xsmall/{$iconImg}" />
        </button>
    
HTML;

  }//end public function setAppendButton */
  
  /**
   * @param array $attributes
   * @return string
   */
  public function build( $attributes = array() )
  {

    if( $attributes ) 
      $this->attributes = array_merge( $this->attributes, $attributes );

    // ist immer ein text attribute
    if (!isset( $this->attributes['type'] ) )
      $this->attributes['type']= 'text';

    $attributes = $this->asmAttributes();

    $required = $this->required
      ? '<span class="wgt-required">*</span>'
      : '';

    $id = $this->getId();

    $html = '<div class="wgt-box input" id="wgt-box-'.$id.'" >
      <label class="wgt-label" for="'.$id.'" >'.$this->label.' '.$required.'</label>
      <div class="wgt-input '.$this->width.'" ><input '.$attributes.' /></div>
      <div class="wgt-clear tiny" >&nbsp;</div>
    </div>'.NL;

    return $html;

  }//end public function build */

  /**
   * (non-PHPdoc)
   * @see src/wgt/WgtAbstract#buildAjax()
   */
  public function buildAjax()
  {

    if (!isset( $this->attributes['id'] ) )
      return '';

    if (!isset( $this->attributes['value'] ) )
      $this->attributes['value'] = '';

    $html = '<htmlArea selector="input#'.$this->attributes['id'].'" action="value" ><![CDATA['
      .$this->attributes['value'].']]></htmlArea>'.NL;

    return $html;

  }//end public function buildAjax */


} // end class WgtItemInput


