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
class WgtInputWindow extends WgtInput
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @var string
   */
  public $refValue  = '';

  /**
   *
   * @var string
   */
  public $selectionUrl   = '';

  /**
   *
   * @var string
   */
  public $listIcon  = 'control/link.png';

  /**
   *
   * @var string
   */
  public $showUrl = '';

  /**
   *
   * @var string
   */
  public $conEntity = null;

  /**
   * should this element be hidden
   * @var string
   */
  public $hide      = false;

  /**
   * the activ view object
   * @var LibTemplate
   */
  public $view      = null;

  /**
   *
   * @var string
   */
  public $uniqueKey = '';

  /**
   * Daten für einen Automcomplete Zugriff
   * Wenn gesetzt ist das Inputelement nichtmehr Readonly
   * Sondern in Autocomplete Feld
   *
   * @var string
   */
  public $autocomplete = null;

/*//////////////////////////////////////////////////////////////////////////////
// Getter + Setter
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @param $url
   * @return void
   */
  public function setListUrl($url )
  {
    $this->selectionUrl = $url;
  }//end public function setListUrl */

  /**
   *
   * @param $icon
   * @return void
   */
  public function setListIcon($icon )
  {
    $this->listIcon = $icon;
  }//end public function setListIcon */

  /**
   *
   * @param $url
   * @return void
   */
  public function setEntityUrl($url )
  {
    $this->showUrl = $url;
  }//end public function setEntityUrl */

  /**
   *
   * @param $value
   * @return void
   */
  public function setRefValue($value )
  {
    $this->refValue = $value;
  }//end public function setRefValue */

  /**
   *
   * @param string $value
   * @return void
   */
  public function setAutocomplete($autocomplete )
  {
    $this->autocomplete = $autocomplete;
  }//end public function setAutocomplete */

  /**
   *
   * @param boolean $hide
   * @return void
   */
  public function setHide($hide = true )
  {
    $this->hide = $hide;
  }//end public function setHide */

/*//////////////////////////////////////////////////////////////////////////////
// Parser
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * build all data to a ui element
   * @param array $attributes
   * @return string
   */
  public function build($attributes = array() )
  {

    if ($this->html )
      return $this->html;

    if ($attributes )
      $this->attributes = array_merge($this->attributes, $attributes );

    // ist immer ein text attribute
    $this->attributes['type'] = 'hidden';

    $attrHidden = array();
    $attrHidden['value']  = $this->conEntity?$this->conEntity->getId():null;
    $attrHidden['id']     = $this->getId();
    $attrHidden['name']   = $this->attributes['name'];

    $attrHidden['class']  = $this->assignedForm
      ? 'asgd-'.$this->assignedForm
      : '';

    $showAttr           = $this->attributes;
    $showAttr['id']     = $showAttr['id'].'-tostring';
    $showAttr['value']  = $this->conEntity?$this->conEntity->text():null;
    $showAttr['name']   = substr($this->attributes['name'], 0, -1  ).'-tostring]';
    $showAttr['class']  .= ' wgt-ignore';


    $codeAutocomplete = '';

    // nur readonly wenn autocomplete
    if (!$this->autocomplete || $this->readOnly )
    {

      $showAttr['readonly'] = 'readonly';
      $showAttr['class']  .= ' wgt-readonly';
    } else {
      $codeAutocomplete = '<var id="var-'.$showAttr['id'].'" >'.$this->autocomplete.'</var>';
      $showAttr['class']  .= ' wcm wcm_ui_autocomplete';
    }

    $iconMenu = $this->icon( 'control/selection.png', 'Window selector' );

    if ($this->readOnly )
    {
      $codeUnset  = "";
      $entryUnset = "";
    } else {

      $codeUnset = ',
   "unset":"true"';

      $iconUnset = $this->icon('control/delete.png', 'Unset');

      $entryUnset = <<<HTML
      <li class="unset" ><a>{$iconUnset} Unset</a></li>
HTML;

    }

    $codeOpen   = '';
    $entryOpen  = '';

    if ($this->showUrl )
    {

      $codeOpen = <<<HTML
,
   "open":"{$this->showUrl}&amp;rqtby=inp&amp;input={$attrHidden['id']}&amp;objid="
HTML;

      $iconOpen = $this->icon('control/entity.png', 'Open');

      $entryOpen = <<<HTML
            <li class="open" ><a>{$iconOpen} Open</a></li>
HTML;

    }

    $codeSelection  = '';
    $entrySelection = '';

    if ($this->selectionUrl )
    {

      $codeSelection = <<<HTML
,
   "selection":"{$this->selectionUrl}"
HTML;

      $iconAdd = $this->icon('control/add.png', 'Add');
      $iconSearch = $this->icon('control/change.png', 'Change');

      $entrySelection = <<<HTML
            <li class="add" ><a>{$iconAdd} Add</a></li>
            <li class="change" ><a>{$iconSearch} Change</a></li>
HTML;

    }

      $buttonAppend = <<<HTML
  <button
    class="wcm wcm_control_selection wgt-button append"
    tabindex="-1"
    id="{$attrHidden['id']}-control"
    wgt_drop_box="{$attrHidden['id']}-control-drop" >{$iconMenu}</button>

  <var id="{$attrHidden['id']}-control-cfg-selection" >{
   "element":"{$attrHidden['id']}"{$codeSelection}{$codeOpen}{$codeUnset}
  }</var>
HTML;


    unset($showAttr['type']);

    $htmlShowAttr = $this->asmAttributes($showAttr);
    $required     = $this->required?'<span class="wgt-required">*</span>':'';

    $id = $this->attributes['id'];
    $helpIcon = $this->renderDocu($id );

    if (!$this->hide )
    {
      $html = '<div class="wgt-box input" id="wgt-box-'.$this->attributes['id'].'" >
        <div class="wgt-label" >
          <label  for="'.$this->attributes['id'].'" >'.$this->label.' '.$required.'</label>
          '.$helpIcon.'
        </div>
        <div class="wgt-input '.$this->width.'" >
          <input
            type="hidden" class="'.$attrHidden['class'].'"
            value="'.$attrHidden['value'].'"
            id="'.$attrHidden['id'].'"
            name="'.$attrHidden['name'].'" />
          <input type="text" '.$htmlShowAttr.' />'.$codeAutocomplete.'
          '.$buttonAppend.'
        </div>

        <div class="wgt-dropdownbox"  id="'.$this->attributes['id'].'-control-drop" >
          <ul>
            '.$entrySelection.$entryOpen.$entryUnset.'
          </ul>
        </div>

        <div class="wgt-clear tiny" >&nbsp;</div>
      </div>'.NL;
    } else {
      $html = '<input
        type="hidden"
        class="'.$attrHidden['class'].'"
        value="'.$attrHidden['value'].'"
        id="'.$attrHidden['id'].'"
        name="'.$attrHidden['name'].'" />'.NL;
    }

    $this->html = $html;

    return $this->html;

  }//end public function build */

  /**
   * @param string $attrId
   */
  public function buildJavascript($attrId )
  {

    return '';

  }//end public function buildJavascript */

  /**
   * (non-PHPdoc)
   * @see src/wgt/WgtAbstract#buildAjaxArea()
   */
  public function buildAjaxArea()
  {

    if (!isset($this->attributes['id']))
      return '';

    if (!isset($this->attributes['value']) )
      $this->attributes['value'] = '';

    $this->editUrl = null;

    if ($this->serializeElement )
    {

      $html = '<htmlArea selector="input#'.$this->attributes['id'].'" action="thml" ><![CDATA['
        .$this->element().']]></htmlArea>'.NL;
    } else {

      $html = '<htmlArea selector="input#'.$this->attributes['id'].'" action="value" ><![CDATA['
        .$this->attributes['value'].']]></htmlArea>'.NL;

      $html .= '<htmlArea selector="input#'.$this->attributes['id'].'_tostring" action="value" ><![CDATA['
        .$this->conEntity->text().']]></htmlArea>'.NL;

    }

    return $html;

  }//end public function buildAjaxArea


}//end class WgtInputWindow


