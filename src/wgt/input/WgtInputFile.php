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
class WgtInputFile extends WgtInput
{

  /**
   * @var string
   */
  public $link = null;

  /**
   * @param string $link
   */
  public function setLink($link)
  {
    $this->link = $link;
  }//end public function setLink */

  /**
   *
   * @return unknown_type
   */
  public function build($attributes = array())
  {

    if ($attributes)
      $this->attributes = array_merge($this->attributes,$attributes);

    // ist immer ein text attribute
    $this->attributes['type'] = 'text';
    $value = null;

    if (isset($this->attributes['value'])) {
      $value = $this->attributes['value'];
    }

    if ($this->link)
      $this->texts->afterInput = '<p><a href="'.$this->link.'" target="new_download" >'.$value.'</a></p>';

    $id       = $this->getId();

    $fName    = $this->attributes['name'];

    $required = $this->required?'<span class="wgt-required">*</span>':'';
    $icon     = Wgt::icon('control/upload.png', 'xsmall', 'Upload');

    $this->attributes['class'] = isset($this->attributes['class'])
      ? $this->attributes['class'].' wgt-ignore wgt-overlay'
      : 'wgt-ignore wgt-overlay';

    $this->attributes['id']      .= '-display';
    $this->attributes['name']     = 'display-'.$this->attributes['name'];

    $asgdForm = $this->assignedForm
      ? 'asgd-'.$this->assignedForm
      : '';

    $helpIcon = $this->renderDocu($id);

    $html = <<<HTML
    <div class="wgt-box input" id="wgt-box-{$id}" >
      {$this->texts->topBox}
      <div class="wgt-label" ><label
        for="{$id}" >{$this->texts->beforeLabel}{$this->label}{$this->texts->afterLabel} {$required}{$this->texts->endLabel}</label>
      {$this->texts->middleBox}
        {$helpIcon}
      </div>
      <div
        class="wgt-input {$this->width}"
        style="position:relative;" ><input
          class="wgt-behind {$asgdForm}"
          onchange="\$S('input#{$id}-display').val(\$S(this).val());"
          type="file"
          name="{$fName}"
          id="{$id}" />{$this->element()}<button
            class="wgt-button append wgt-overlay"
            tabindex="-1"  >{$icon}</button>{$this->texts->afterInput}</div>
      {$this->texts->bottomBox}
      <div class="wgt-clear tiny" >&nbsp;</div>
    </div>

HTML;

    return $html;

  } // end public function build */

} // end class WgtItemFile

