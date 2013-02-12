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
 * class WgtItemInput
 * Objekt zum generieren einer Inputbox
 * @package WebFrap
 * @subpackage tech_core
 */
class WgtInputFileImage
  extends WgtInput
{

  /**
   *
   * Enter description here ...
   * @var string
   */
  public $link = null;

  public function setLink( $link )
  {
    $this->link = $link;
  }

  public $source = null;

  public function setSource( $source )
  {
    $this->source = $source;
  }

  /**
   * die build methode zum rendern des input elements
   *
   * @param array $attributes
   * @return string
   */
  public function build( $attributes = array() )
  {

    if( $attributes )
      $this->attributes = array_merge( $this->attributes, $attributes );

    // ist immer ein text attribute
    $this->attributes['type'] = 'text';

    $value = null;

    if ( isset( $this->attributes['value'] ) ) {
      $value = $this->attributes['value'];
    }

    $id = $this->getId();

    $required = $this->required?'<span class="wgt-required" >*</span>':'';

    //$htmlImage = '';
    if ($this->source) {
      $this->texts->afterInput = '<div class="wgt-box-thumb" ><img
        onclick="$D.openImageWindow({src:\''.$this->link.'\',alt:\''.$this->label.'\'})"
        src="'.$this->source.'" alt="'.$this->label.'" /></div>';
    }

    $fName    = $this->attributes['name'];
    $required = $this->required?'<span class="wgt-required">*</span>':'';
    $icon     = Wgt::icon('control/upload_image.png', 'xsmall', 'Upload Image' );

    $this->attributes['class'] = isset($this->attributes['class'])
      ? $this->attributes['class'].' wgt-ignore wgt-overlay'
      : 'wgt-ignore wgt-overlay';

    $this->attributes['id']      .= '-display';
    $this->attributes['name']     = 'display-'.$this->attributes['id'];

    $asgdForm = $this->assignedForm
      ? 'asgd-'.$this->assignedForm
      : '';

    $html = <<<HTML
    <div class="wgt-box input" id="wgt-box-{$id}" >
      {$this->texts->topBox}
      <label class="wgt-label" for="{$id}" >{$this->texts->beforeLabel}{$this->label}{$this->texts->afterLabel} {$required}{$this->texts->endLabel}</label>
      {$this->texts->middleBox}
      <div class="wgt-input {$this->width}" style="position:relative;" >
        <input class="wgt-behind wcm wcm_ui_tip {$asgdForm}" onchange="\$S('input#{$id}-display').val(\$S(this).val());\$S(this).attr('title',\$S(this).val());" type="file" name="{$fName}" id="{$id}" />
        {$this->element()}<button
            class="wgt-button wgt-overlay append"
            tabindex="-1"  >{$icon}</button>{$this->texts->afterInput}</div>
      {$this->texts->bottomBox}
      <div class="wgt-clear tiny" >&nbsp;</div>
    </div>

HTML;

    return $html;

  } // end public function build */

  /**
   * (non-PHPdoc)
   * @see src/wgt/WgtAbstract#buildAjaxArea()
   */
  public function buildAjaxArea()
  {

    if(!isset($this->attributes['id']))

      return '';

    if( !isset($this->attributes['value']) )
      $this->attributes['value'] = '';

    $html = '<htmlArea selector="input#'.$this->attributes['id'].'" action="value" ><![CDATA['
      .$this->attributes['value'].']]></htmlArea>'.NL;

    return $html;

  }//end public function buildAjaxArea */

} // end class WgtInputFileImage
