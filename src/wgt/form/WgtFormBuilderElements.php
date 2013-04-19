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
 * Formklasse für Element Only Inputelemente
 * 
 * Zb für Sidebars oder sonstige komplett Custom positionierung von Elementen
 *
 * @package WebFrap
 * @subpackage tech_core
 */
class WgtFormBuilderElements extends WgtFormBuilder
{


  /**
   * @param string $name
   * @param string $value
   * @param array $attributes
   * @param array $params
   */
  public function input(
    $label,
    $name,
    $value = null,
    $attributes = array(),
    $params = null
  ) {

    $pNode = $this->prepareParams($params);

    if (isset($attributes['id'])) {
      $id      = $attributes['id'];
      $inpName = $name;
    } else {

      $tmp = explode(',', $name);

      if (count($tmp) > 1) {
        $id      = $tmp[0]."-".$tmp[1];
        $inpName = $tmp[0]."[{$tmp[1]}]";
      } else {
        $id      = $tmp[0];
        $inpName = $tmp[0];
      }

      $attributes['id']     = "wgt-input-{$id}";
    }

    $attributes['type']   = 'text';

    if (!isset($attributes['class']))
      $attributes['class']  = $pNode->size;

    if ($this->id)
      $attributes['class']  .= ' asgd-'.$this->id;

    if (!isset($attributes['name']))
      $attributes['name']   = $inpName;

    $attributes['value']  = str_replace('"', '\"', $value);

    $codeAttr = Wgt::asmAttributes($attributes);


    $html = <<<CODE

<input {$codeAttr} />

CODE;
 

    return $this->out($html);

  }//end public function input */


  /**
   * @param string $name
   * @param string $value
   * @param string $label
   * @param string $subName
   * @param array $attributes
   * @param array $params
   */
  public function autocomplete(
    $label,
    $name,
    $value = null,
    $loadUrl = null,
    $attributes = array(),
    $params = null
  ) {

    $pNode = $this->prepareParams($params);

    if (isset($attributes['id'])) {
      $id      = $attributes['id'];
      $inpName = $name;
    } else {

      $tmp = explode(',', $name);

      if (count($tmp) > 1) {
        $id      = $tmp[0]."-".$tmp[1];
        $inpName = $tmp[0]."[{$tmp[1]}]";
      } else {
        $id      = $tmp[0];
        $inpName = $tmp[0];
      }

      $attributes['id']     = "wgt-input-{$id}";
    }


    if ($pNode->entityMode) {

      if (!isset($attributes['class']))
        $class  = 'wcm wcm_ui_autocomplete wgt-ignore '.$pNode->size;
      else
        $class  = 'wcm wcm_ui_autocomplete wgt-ignore '.$pNode->size.' '.$attributes['class'];

      if ($this->id)
        $attributes['class']  = 'asgd-'.$this->id;
      else
        $attributes['class'] = '';

      if (!isset($attributes['name']))
        $attributes['name']   = $inpName;

      //$attributes['value']  = str_replace('"', '\"', $value);

      $attributes['type'] = 'hidden';

      $hidenAttr = Wgt::asmAttributes($attributes);


      $attributes['class']  = $class;
      $attributes['type']   = 'text';
      $attributes['id']     =  $attributes['id'].'-tostring';
      $attributes['name']   =  'tostring-'.$attributes['name'];

      $stringAttributes = Wgt::asmAttributes($attributes);

      $html = <<<CODE

    <input {$hidenAttr} />
    <input {$stringAttributes} /><var class="meta" >{"url":"{$loadUrl}","type":"entity"}</var>{$pNode->appendText}

CODE;

    } else {

      $attributes['type']   = 'text';

      if (!isset($attributes['class']))
        $attributes['class']  = 'wcm wcm_ui_autocomplete '.$pNode->size;
      else
        $attributes['class']  = 'wcm wcm_ui_autocomplete '.$pNode->size.' '.$attributes['class'];

      if ($this->id)
        $attributes['class']  .= ' asgd-'.$this->id;

      if (!isset($attributes['name']))
        $attributes['name']   = $inpName;

      $attributes['value']  = str_replace('"', '\"', $value);

      $codeAttr = Wgt::asmAttributes($attributes);

      $html = <<<CODE

    <input {$codeAttr} /><var class="meta" >{"url":"{$loadUrl}"}</var>{$pNode->appendText}

CODE;
    }

    return $this->out($html);

  }//end public function autocomplete */



  /**
   * @param string $name
   * @param string $value
   * @param string $label
   * @param array $attributes
   * @param array $params
   */
  public function wysiwyg(
    $label,
    $name,
    $value = null,
    $attributes = array(),
    $params = null
  ) {

    $pNode = $this->prepareParams($params);

    if (isset($attributes['id'])) {
      $id      = $attributes['id'];
      $inpName = $name;
    } else {

      $tmp = explode(',', $name);

      if (count($tmp) > 1) {
        $id      = $tmp[0]."-".$tmp[1];
        $inpName = $tmp[0]."[{$tmp[1]}]";
      } else {
        $id      = $tmp[0];
        $inpName = $tmp[0];
      }

      $attributes['id']     = "wgt-wysiwyg-{$id}";
    }

    $attributes['class']  = 'wcm wcm_ui_wysiwyg '.$pNode->size;

    if ($this->id)
      $attributes['class']  .= ' asgd-'.$this->id;

    if (!isset($attributes['name']))
      $attributes['name']   = $inpName;

    $codeAttr = Wgt::asmAttributes($attributes);

    $html = <<<CODE

    <textarea {$codeAttr}>{$value}</textarea>

CODE;

  //<var id="{$id}-cfg-wysiwyg" >{"mode":"{$mode}"}</var>"
    return $this->out($html);

  }//end public function wysiwyg */


  /**
   * @param string $name
   * @param string $value
   * @param string $label
   * @param array $attributes
   * @param array $params
   */
  public function textarea(
    $label,
    $name,
    $value = null,
    $attributes = array(),
    $params = null
  ) {

    $pNode = $this->prepareParams($params);

    if (isset($attributes['id'])) {
      $id      = $attributes['id'];
      $inpName = $name;
    } else {

      $tmp = explode(',', $name);

      if (count($tmp) > 1) {
        $id      = $tmp[0]."-".$tmp[1];
        $inpName = $tmp[0]."[{$tmp[1]}]";
      } else {
        $id      = $tmp[0];
        $inpName = $tmp[0];
      }

      $attributes['id']     = "wgt-textarea-{$id}";
    }

    $attributes['class']  = ''.$pNode->size;

    if ($this->id)
      $attributes['class']  .= ' asgd-'.$this->id;

    if (!isset($attributes['name']))
      $attributes['name']   = $inpName;

    $codeAttr = Wgt::asmAttributes($attributes);


    $html = <<<CODE

<textarea {$codeAttr}>{$value}</textarea>

CODE;

  //<var id="{$id}-cfg-wysiwyg" >{"mode":"{$mode}"}</var>"
    return $this->out($html);

  }//end public function textarea */

  /**
   * @param string $label
   * @param string $name
   * @param string $value
   * @param array $attributes
   * @param array $params
   */
  public function upload
  (
    $label,
    $name,
    $value = null,
    $attributes = array(),
    $params = null
  )
  {

    $pNode = $this->prepareParams($params);

    if (isset($attributes['id'])) {
      $id      = $attributes['id'];
      $inpName = $name;
    } else {

      $tmp = explode(',', $name);

      if (count($tmp) > 1) {
        $id      = $tmp[0]."-".$tmp[1];
        $inpName = $tmp[0]."[{$tmp[1]}]";
      } else {
        $id      = $tmp[0];
        $inpName = $tmp[0];
      }

      $attributes['id']     = "wgt-input-{$id}";
    }

    $attributes['type']     = 'file';

    if (!isset($attributes['class']))
      $attributes['class'] = $pNode->size;

    $attributes['class']    .= ' wgt-behind';

    if ($this->id)
      $attributes['class']  .= ' asgd-'.$this->id;

    $attributes['name']   = $inpName;

    $attributes['onchange']   = "\$S('input#wgt-input-{$id}-display').val(\$S(this).val());\$S(this).attr('title',\$S(this).val());";

    $codeAttr = Wgt::asmAttributes($attributes);


    $value  = str_replace('"', '\"', $value);

    $icon = Wgt::icon('control/upload_image.png', 'xsmall', array('alt'=>"Upload Image"));

    if ($pNode->clean) {
      return <<<CODE

  <div style="position:relative;overflow:hidden;" class="wgt-input {$pNode->size}" >
    <input {$codeAttr} />
    <input
      type="text"
      value="{$value}"
      class="medium wgt-ignore wgt-overlay"
      id="wgt-input-{$id}-display" name="{$id}-display" />
    <button
      class="wgt-button wgt-overlay append {$pNode->size}"
      tabindex="-1" >
      {$icon}
    </button>
  </div>

CODE;
    }

    $html = <<<CODE

<div id="wgt_box_{$id}" >
  <label for="wgt-input-{$id}" class="wgt-label">{$label}{$pNode->requiredText}</label>
  <div style="position:relative;" class="wgt-input {$pNode->size}" >
    <input {$codeAttr} />
    <input
      type="text"
      value="{$value}"
      class="{$pNode->size} wgt-ignore wgt-overlay"
      id="wgt-input-{$id}-display" name="{$id}-display" />
    <button
      class="wgt-button wgt-overlay append {$pNode->size}"
      tabindex="-1" >
      {$icon}
    </button>
      {$pNode->appendText}
  </div>
  <div class="wgt-clear tiny" ></div>
</div>

CODE;

    return $this->out($html);

  }//end public function upload */

  /**
   * @param string $label
   * @param string $name
   * @param string $checked
   * @param array $attributes
   * @param array $params
   */
  public function checkbox(
    $label,
    $name,
    $checked,
    $attributes = array(),
    $params = null
  ) {

    $pNode = $this->prepareParams($params);

    if (isset($attributes['id'])) {
      $id      = $attributes['id'];
      $inpName = $name;
    } else {

      $tmp = explode(',', $name);

      if (count($tmp) > 1) {
        $id      = $tmp[0]."-".$tmp[1];
        $inpName = $tmp[0]."[{$tmp[1]}]";
      } else {
        $id      = $tmp[0];
        $inpName = $tmp[0];
      }

      $attributes['id']     = "wgt-input-{$id}";
    }

    $attributes['type']   = 'checkbox';

    if ($checked && !('false' === $checked || 'f' === $checked))
      $attributes['checked']  = 'checked';

    if (!isset($attributes['class']))
      $attributes['class'] = '';

    if ($this->id)
      $attributes['class']  .= ' asgd-'.$this->id;

    if (!isset($attributes['name']))
      $attributes['name']   = $inpName;

    $codeAttr = Wgt::asmAttributes($attributes);

    $html = <<<CODE

<input {$codeAttr} />

CODE;

    return $this->out($html);

  }//end public function checkbox */


  /**
   * @param string $label
   * @param string $name
   * @param string $active
   * @param array $data
   * @param array $attributes
   * @param array $params
   */
  public function ratingbar(
    $label,
    $name,
    $active,
    $data = array(),
    $attributes = array(),
    $params = null
  ) {

    $pNode = $this->prepareParams($params);

    if (!$data) {
      $data = array
      (
        '0.5' => '0.5',
        '1' => '1',
        '1.5' => '1.5',
        '2' => '2',
        '2.5' => '2.5',
        '3' => '3',
        '3.5' => '3.5',
        '4' => '4',
        '4.5' => '4.5',
        '5' => '5',
      );
    }

    if (!$pNode->starParts)
      $pNode->starParts = 2;

    if (isset($attributes['id'])) {
      $id      = $attributes['id'];
      $inpName = $name;
    } else {

      $tmp = explode(',', $name);

      if (count($tmp) > 1) {
        $id      = $tmp[0]."-".$tmp[1];
        $inpName = $tmp[0]."[{$tmp[1]}]";
      } else {
        $id      = $tmp[0];
        $inpName = $tmp[0];
      }

      $attributes['id']     = "wgt-input-{$id}";
    }

    $attributes['type']   = 'checkbox';

    if (!isset($attributes['name']))
      $attributes['name']   = $inpName;

    if (!isset($attributes['class']))
      $attributes['class']   = '';

    $codeAttr = Wgt::asmAttributes($attributes);


    $html = <<<HTML

      <div id="{$id}" class="wcm wcm_ui_star_rating wgt-input {$pNode->size}" >
HTML;

    $activTitle = '&nbsp;';

    $splitClass = '';
    $splitKey   = 'false';
    if (1 < (int) $pNode->starParts) {
      $splitClass = "{split:{$pNode->starParts}}";
      $splitKey = "true";
    }

    foreach ($data as $value => $title) {

      if ($active == $value) {
        $checked     = ' checked="checked" ';
        $activTitle  = $title;
      } else {
        $checked     = '';
      }

      $html .= '<input title="'.$title.'" id="'.$id.'-'.$value.'" onclick="$S(\'div#'.$id.'_text\').text(\''.$title.'\');"'
        .' value="'.$value.'" class="'.$attributes['class'].' wgt_start_rating wgt_ignore '.$splitClass.'"  '
        .$checked.' name="_'.$attributes['name'].'" type="radio"  />'.NL;
    }

    $html .= <<<HTML

    <var id="{$id}-cfg-rating" >{"half":"{$splitKey}"}</var>
    <span id="{$id}_text" class="wgt_rating_text" style="white-space:nowrap;" >{$activTitle}</span>
    <input type="hidden" id="{$id}" class="asgd-{$this->id} wgt_value"  name="{$attributes['name']}" value="{$active}" />
  </div>
  <div class="wgt-clear tiny" ></div>

HTML;

    return $this->out($html);

  }//end public function ratingbar */



  /**
   * @param string $name
   * @param string $value
   * @param string $elementKey
   * @param string $data
   * @param string $value
   * @param array $attributes
   * @param array $params
   */
  public function selectboxByKey(
    $label,
    $name,
    $elementKey,
    $data,
    $value = null,
    $attributes = array(),
    $params = null
  ) {

    $pNode = $this->prepareParams($params);

    if (isset($attributes['id'])) {
      $id      = $attributes['id'];
      $inpName = $name;
    } else {

      $tmp = explode(',', $name);

      if (count($tmp) > 1) {
        $id      = $tmp[0]."-".$tmp[1];
        $inpName = $tmp[0]."[{$tmp[1]}]";
      } else {
        $id      = $tmp[0];
        $inpName = $tmp[0];
      }

      $attributes['id']     = "wgt-input-{$id}";
    }

    if (!Webfrap::classLoadable($elementKey))
      return '<!-- Missing '.$elementKey.' -->';

    $selectBoxNode = new $elementKey();

    $selectBoxNode->addAttributes(
      array(
        'name'      => $name,
        'id'        => $id,
        'class'     => 'small asgd-'.$this->id,
      )
    );
    $selectBoxNode->setWidth($pNode->size);

    $selectBoxNode->assignedForm = $this->id;

    $selectBoxNode->setActive($value);

    $selectBoxNode->setReadonly($pNode->readonly);
    $selectBoxNode->setRequired($pNode->required);

    $selectBoxNode->setData($data);

    // set an empty first entry
    if (!is_null($pNode->firstFree))
      $selectBoxNode->setFirstFree($pNode->firstFree);

    return $this->out($selectBoxNode->element());

  }//end public function selectboxByKey */

  /**
   * @param string $name
   * @param string $elementKey
   * @param string $data
   * @param string $value
   * @param array $attributes
   * @param array $params
   */
  public function multiSelectByKey(
    $label,
    $name,
    $elementKey,
    $data,
    $value = null,
    $attributes = array(),
    $params = null
  ) {

    $pNode = $this->prepareParams($params);

    if (!$pNode->exists('firstFree'))
      $pNode->firstFree = ' ';

    if (isset($attributes['id'])) {
      $id      = $attributes['id'];
      $inpName = $name;
    } else {

      $tmp = explode(',', $name);

      if (count($tmp) > 1) {
        $id      = $tmp[0]."-".$tmp[1];
        $inpName = $tmp[0]."[{$tmp[1]}]";
      } else {
        $id      = $tmp[0];
        $inpName = $tmp[0];
      }

      $attributes['id']     = "wgt-input-{$id}";
    }

    if (!Webfrap::classLoadable($elementKey))
      return '<!-- Missing '.$elementKey.' -->';

    $selectBoxNode = new $elementKey();

    $selectBoxNode->addAttributes(
      array(
        'name'      => $name,
        'id'        => $id,
        'class'     => 'medium asgd-'.$this->id,
      )
    );
    $selectBoxNode->setWidth('small');

    $selectBoxNode->assignedForm = $this->id;

    $selectBoxNode->setActive($value);

    //$selectBoxNode->setReadonly($readOnly);
    //$selectBoxNode->setRequired($required);

    $selectBoxNode->setData($data);

    // set an empty first entry
    //if (!is_null($firstFree))
      //$selectBoxNode->setFirstFree($firstFree);
    return $this->out($selectBoxNode->element());

  }//end public function multiSelectByKey */



/*//////////////////////////////////////////////////////////////////////////////
// title
//////////////////////////////////////////////////////////////////////////////*/



  /**
   * @param array $params
   * @param string $size
   * @param string $appendText
   */
  public function prepareParams(
    $params,
    $size = 'medium',
    $appendText = ''
  ) {

    if (is_array($params)) {
      $pNode = new TFlag($params);
    } elseif (is_object($params)) {
      $pNode = $params;
    } else {
      $pNode = clone $this->defParams;
    }

    if (!$pNode->size)
      $pNode->size = $size;

    return $pNode;

  }//end public function prepareParams */

}//end class WgtFormBuilder

