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

/** Form Class
 *
 * @package WebFrap
 * @subpackage tech_core
 */
class WgtFormBuilder
{
/*//////////////////////////////////////////////////////////////////////////////
// public interface attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Die Id des Formulars
   * @var string $keyName
   */
  public $id   = null;


  /**
   * Data Key
   * @var string $dKey
   */
  public $dKey   = null;

  /**
   * Die Action des Formulars
   * @var string
   */
  public $action   = null;

  /**
   * Der Domainkey des Elements
   * @var string
   */
  public $domainKey = null;

  /**
   * Methodes des Formulars
   * @var string
   */
  public $method   = null;

  /**
   * Flag ob das Formular direkt ausgegeben werden soll
   * oder zurückgegeben werden soll
   * @var boolean
   */
  public $cout = true;

  /**
   * @var LibDbConnection
   */
  public $db = null;

  /**
   * @var TFlag
   */
  public $defParams = null;

  /**
   * Check ob das Formular per Ajax verschickt wird
   * @var boolean
   */
  public $ajax = true;

  /**
   * Liste der I18n Languages
   * @var array
   */
  public $i18nLanguages = array(
    array('id' => 'de', 'value' => 'german'),
    array('id' => 'en', 'value' => 'english'  )
  );

  /**
   * @var LibTemplate
   */
  public $view = null;

/*//////////////////////////////////////////////////////////////////////////////
// Constructor
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $view
   * @param string $action
   * @param string $domainKey
   * @param string $method
   * @param boolean $cout
   */
  public function __construct(
    $view,
    $action,
    $domainKey,
    $method = 'post',
    $cout = true
  ) {

    $this->view   = $view;
    $this->action = $action;
    $this->id       = 'wgt-form-'.$domainKey;
    $this->dKey     = 'asgd-wgt-form-'.$domainKey;
    $this->domainKey = $domainKey;
    $this->method    = $method;
    $this->cout     = $cout;

    $this->defParams = new TFlag();

    $this->defParams->plain = false;
    $this->defParams->size  = 'medium';
    $this->defParams->appendText = null;
    $this->defParams->helpText   = null;

  }//end public function __construct */

/*//////////////////////////////////////////////////////////////////////////////
// Helper Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $code
   */
  public function out($code)
  {

    if ($this->cout)
      echo $code;

    return $code;

  }//end public function out */

  /**
   * @param string $key
   * @return LibSqlQuery
   */
  public function loadQuery($key)
  {

    if (!$this->db)
      $this->db = Webfrap::$env->getDb();

    return $this->db->newQuery($key);

  }//end public function loadQuery */

/*//////////////////////////////////////////////////////////////////////////////
// Form Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return string
   */
  public function form()
  {

    $code = <<<CODE
<form method="{$this->method}" action="{$this->action}" id="{$this->id}" accept-charset="utf-8" >
CODE;

    if ($this->ajax)
      $code .= '</form>';

    return $this->out($code);

  }//end public static function form */

  /**
   * @return string
   */
  public function close()
  {

    return $this->out('</form>');

  }//end public static function close */

  /**
   * rückgabe der assign klasse für das form
   * @return string
   */
  public function asgd()
  {
    return 'asgd-'.$this->id;
  }//end public function asgd */

  /**
   * @param string $label
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

    $helpIcon = '';
    $helpText = '';
    if ($pNode->helpText) {
       $helpIcon = '<span onclick="$S(\'#wgt-input-help-'.$id.'\').modal();" >'.Wgt::icon('control/help.png', 'xsmall').'</span> ';
       $helpText = '<div id="wgt-input-help-'.$id.'" class="template" >'.$pNode->helpText.'</div>';
    }

    if ($pNode->plain) {
      $html = <<<CODE

<input {$codeAttr} />

CODE;

    } else {
      $html = <<<CODE

<div id="wgt_box_{$id}" >
  <label for="wgt-input-{$id}" class="wgt-label">{$helpIcon}{$label}{$pNode->requiredText}</label>
  {$helpText}
  <div class="wgt-input {$pNode->size}" >
    <input {$codeAttr} />{$pNode->appendText}
  </div>
  <div class="wgt-clear tiny" ></div>
</div>

CODE;
    }

    return $this->out($html);

  }//end public function input */

  /**
   * @param string $label
   * @param string $name
   * @param string $value
   * @param array $attributes
   * @param array $params
   */
  public function richInput(
    $type,
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
      $attributes['class'] = 'wcm wcm_ui_'.$type;

    $attributes['class']  .= ' '.$pNode->size;

    if ($this->id)
      $attributes['class']  .= ' asgd-'.$this->id;

    if (!isset($attributes['name']))
      $attributes['name']   = $inpName;

    $attributes['value']  = str_replace('"', '\"', $value);

    $codeAttr = Wgt::asmAttributes($attributes);

    $helpIcon = '';
    $helpText = '';
    if ($pNode->helpText) {
       $helpIcon = '<span onclick="$S(\'#wgt-input-help-'.$id.'\').modal();" >'.$this->view->icon('control/help.png', 'Help').'</span> ';
       $helpText = '<div id="wgt-input-help-'.$id.'" class="template" >'.$pNode->helpText.'</div>';
    }

    $appendButton = '';
    if (isset($params['button'])) {

      $appendButton = <<<BUTTON

 <var>{"button":"wgt-input-{$id}-ap-button"}</var>
  <button
    id="wgt-input-{$id}-ap-button"
    class="wgt-button append"
    tabindex="-1"  >
      {$this->view->icon($params['button'], $label)}
  </button>

BUTTON;

    }

    if ($pNode->plain) {
      $html = <<<CODE

<input {$codeAttr} />

CODE;

    } else {
      $html = <<<CODE

<div id="wgt_box_{$id}" >
  <label for="wgt-input-{$id}" class="wgt-label">{$helpIcon}{$label}{$pNode->requiredText}</label>
  {$helpText}
  <div class="wgt-input {$pNode->size}" >
    <input {$codeAttr} />{$appendButton}{$pNode->appendText}
  </div>
  <div class="wgt-clear tiny" ></div>
</div>

CODE;
    }

    return $this->out($html);

  }//end public function richInput */


  /**
   * @param string $name
   * @param string $value
   * @param array $params
   */
  public function hidden
  (
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

      $attributes['id'] = "wgt-input-{$id}";
    }

    $attributes['type'] = 'hidden';

    if ($this->id)
      $attributes['class'] = ' asgd-'.$this->id;

    if (!isset($attributes['name']))
      $attributes['name'] = $inpName;

    $attributes['value'] = str_replace('"', '\"', $value);

    $codeAttr = Wgt::asmAttributes($attributes);

    $html = <<<CODE

<input {$codeAttr} />

CODE;

    return $this->out($html);

  }//end public function hidden */

  /**
   * @param string $name
   * @param string $value
   * @param string $label
   * @param string $subName
   * @param array $attributes
   * @param array $params
   */
  public function autocomplete
  (
    $label,
    $name,
    $value = null,
    $loadUrl = null,
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





    $helpIcon = '';
    $helpText = '';
    if ($pNode->helpText) {
      $helpIcon = '<span onclick="$S(\'#wgt-input-help-'.$id.'\').modal();" >'.Wgt::icon('control/help.png', 'xsmall').'</span> ';
      $helpText = '<div id="wgt-input-help-'.$id.'" class="template" >'.$pNode->helpText.'</div>';
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

<div id="wgt_box_{$id}" >
  <label for="wgt-input-{$id}" class="wgt-label">{$helpIcon}{$label}{$pNode->requiredText}</label>
  {$helpText}
  <div class="wgt-input {$pNode->size}" >
    <input {$hidenAttr} />
    <input {$stringAttributes} /><var class="meta" >{"url":"{$loadUrl}","type":"entity"}</var>{$pNode->appendText}
  </div>
  <div class="wgt-clear tiny" ></div>
</div>

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

<div id="wgt_box_{$id}" >
  <label for="wgt-input-{$id}" class="wgt-label">{$helpIcon}{$label}{$pNode->requiredText}</label>
  {$helpText}
  <div class="wgt-input {$pNode->size}" >
    <input {$codeAttr} /><var class="meta" >{"url":"{$loadUrl}"}</var>{$pNode->appendText}
  </div>
  <div class="wgt-clear tiny" ></div>
</div>

CODE;
    }

    return $this->out($html);

  }//end public function autocomplete */


  /**
   * @param string $label
   * @param string $id
   * @param string $element
   * @param array $attributes
   * @param array $params
   */
  public function decorateInput
  (
    $label,
    $id,
    $element,
    $attributes = array(),
    $params = null
  )
  {

    $pNode = $this->prepareParams($params);

    $html = <<<CODE

<div id="wgt_box_{$id}" >
  <label for="wgt-input-{$id}" class="wgt-label">{$label}{$pNode->requiredText}</label>
  <div class="wgt-input {$pNode->size}" style="width:200px;" >
    {$element}
    {$pNode->appendText}
  </div>
  <div class="wgt-clear tiny" ></div>
</div>

CODE;

    return $this->out($html);

  }//end public function decorateInput */


  /**
   * @param string $name
   * @param string $value
   * @param string $label
   * @param array $attributes
   * @param array $params
   */
  public function wysiwyg
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

      $attributes['id']     = "wgt-wysiwyg-{$id}";
    }

    $attributes['class']  = 'wcm wcm_ui_wysiwyg '.$pNode->size;

    if ($this->id)
      $attributes['class']  .= ' asgd-'.$this->id;

    if (!isset($attributes['name']))
      $attributes['name']   = $inpName;

    $codeAttr = Wgt::asmAttributes($attributes);

    $helpIcon = '';
    $helpText = '';
    if ($pNode->helpText) {
       $helpIcon = '<span onclick="$S(\'#wgt-input-help-'.$id.'\').modal();" >'.Wgt::icon('control/help.png', 'xsmall').'</span> ';
       $helpText = '<div id="wgt-input-help-'.$id.'" class="template" >'.$pNode->helpText.'</div>';
    }

    if ($pNode->plain) {
      $html = <<<CODE

<textarea {$codeAttr}>{$value}</textarea>

CODE;

      return $this->out($html);
    }

    $html = <<<CODE

<div id="wgt_box_{$id}" >
  <label for="wgt-input-{$id}" class="wgt-label large" >{$helpIcon}{$label}{$pNode->requiredText}</label>
  {$helpText}
  <div class="wgt-input {$pNode->size} left" >
    <textarea {$codeAttr}>{$value}</textarea>
  </div>
  {$pNode->appendText}
  <div class="wgt-clear tiny" ></div>
</div>

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

    $helpIcon = '';
    $helpText = '';
    if ($pNode->helpText) {
       $helpIcon = '<span onclick="$S(\'#wgt-input-help-'.$id.'\').modal();" >'.Wgt::icon('control/help.png', 'xsmall').'</span> ';
       $helpText = '<div id="wgt-input-help-'.$id.'" class="template" >'.$pNode->helpText.'</div>';
    }

    if ($pNode->plain) {
      return <<<CODE

<textarea {$codeAttr}>{$value}</textarea>

CODE;
    }

    $html = <<<CODE

<div id="wgt_box_{$id}" >
  <label for="wgt-input-{$id}" style="display:block;" >{$helpIcon}{$label}{$pNode->requiredText}</label>
  {$helpText}
  <div class="wgt-input {$pNode->size} " >
    <textarea {$codeAttr}>{$value}</textarea>
  </div>
  <div class="wgt-clear tiny" ></div>
</div>

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
  public function checkbox
  (
    $label,
    $name,
    $checked,
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

    if ($pNode->plain)
      return "<input {$codeAttr} />";

    $html = <<<CODE

<div id="wgt_box_{$id}" >
  <label for="wgt-input-{$id}" class="wgt-label">{$label}</label>
  <div class="wgt-input" style="width:40px;" >
    <input {$codeAttr} />
  </div>
</div>

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
  public function ratingbar
  (
    $label,
    $name,
    $active,
    $data = array(),
    $attributes = array(),
    $params = null
  )
  {

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

    $helpIcon = '';
    $helpText = '';
    if ($pNode->helpText) {
       $helpIcon = '<span onclick="$S(\'#wgt-input-help-'.$id.'\').modal();" >'.Wgt::icon('control/help.png', 'xsmall').'</span> ';
       $helpText = '<div id="wgt-input-help-'.$id.'" class="template" >'.$pNode->helpText.'</div>';
    }


    $html = <<<HTML
    <div id="wgt_box_{$id}" >
      <label for="wgt-input-{$id}" class="wgt-label">{$helpIcon}{$label}{$pNode->requiredText}</label>
      {$helpText}
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
</div>



HTML;

    return $this->out($html);

  }//end public function ratingbar */


  /**
   * @param string $label
   * @param string $name
   * @param string $value
   * @param array $attributes
   * @param string $formId
   * @param string $appendText
   * @param string $size
   */
  public function password
  (
    $label,
    $name,
    $value = null,
    $attributes = array(),
    $params = null,
    $check = true
  ) {


    $pNode = $this->prepareParams($params);

    if (is_string($attributes)) {
      $size = $attributes;
      $attributes = array();
    }


    if (isset($attributes['id'])) {
      $id      = $attributes['id'];
      $inpName = $name;

      $tmp = explode('[', $inpName, 2);

      if (1 == count($tmp))
        $inpNameCheck = $inpName.'_check';
      else
        $inpNameCheck = $tmp[0].'_check['.$tmp[1];

    } else {

      $tmp = explode(',', $name);

      if (count($tmp) > 1) {
        $id      = $tmp[0]."-".$tmp[1];
        $inpName = $tmp[0]."[{$tmp[1]}]";
        $inpNameCheck = $tmp[0]."-check[{$tmp[1]}]";
      } else {
        $id      = $tmp[0];
        $inpName = $tmp[0];

        $tmp2 = explode('[', $inpName, 2);

        if (1 == count($tmp2))
          $inpNameCheck = $inpName.'_check';
        else
          $inpNameCheck = $tmp2[0].'_check['.$tmp2[1];
      }

      $attributes['id']     = "wgt-input-{$id}";
    }

    $attributes['type']   = 'password';

    if (!isset($attributes['class']))
      $attributes['class']  = $size;

    if ($this->id)
      $attributes['class']  .= ' asgd-'.$this->id;

    if (!isset($attributes['name']))
      $attributes['name']   = $inpName;

    $attrCheck       = $attributes;
    $attrCheck['id'] = $attributes['id'].'-check';
    $attrCheck['name'] = $inpNameCheck;

    $codeAttrCheck = Wgt::asmAttributes($attrCheck);

    $attributes['value']  = str_replace('"', '\"', $value);

    $codeAttr = Wgt::asmAttributes($attributes);

    $helpIcon = '';
    $helpText = '';
    if (is_array($label)) {
       $helpIcon = '<span onclick="$S(\'#wgt-input-help-'.$id.'\').modal();" >'.Wgt::icon('control/help.png', 'xsmall').'</span> ';
       $helpText = '<div id="wgt-input-help-'.$id.'" class="template" >'.$label[1].'</div>';
       $label = $label[0];
    }

    $html = <<<CODE

<div id="wgt_box_{$id}" >
  <label for="wgt-input-{$id}" class="wgt-label">{$helpIcon}{$label}{$pNode->requiredText}</label>
  {$helpText}
  <div class="wgt-input {$size}" >
    <input {$codeAttr} />{$pNode->appendText}
  </div>
  <div class="wgt-clear tiny" ></div>
</div>

CODE;

    if ($check) {
      $html .= <<<CODE

<div id="wgt_box_{$id}-check" >
  <label for="wgt-input-{$id}-check" class="wgt-label">{$helpIcon}{$label} Check{$pNode->requiredText}</label>
  <div class="wgt-input {$size}" >
    <input {$codeAttrCheck} />
  </div>
  <div class="wgt-clear tiny" ></div>
</div>

CODE;

    }

    return $this->out($html);

  }//end public static function password */


  /**
   * @param string $label
   * @param string $name
   * @param string $value
   * @param array $attributes
   * @param array $params
   */
  public function sumField
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

    $attributes['type']   = 'text';

    if (!isset($attributes['class']))
      $attributes['class']  = $pNode->size;

    if ($this->id)
      $attributes['class']  .= ' asgd-'.$this->id;

    if (!isset($attributes['name']))
      $attributes['name']   = $inpName;

    $attributes['value']  = str_replace('"', '\"', $value);

    $codeAttr = Wgt::asmAttributes($attributes);

    $helpIcon = '';
    $helpText = '';
    if ($pNode->helpText) {
      $helpIcon = '<span onclick="$S(\'#wgt-input-help-'.$id.'\').modal();" >'.Wgt::icon('control/help.png', 'xsmall').'</span> ';
      $helpText = '<div id="wgt-input-help-'.$id.'" class="template" >'.$pNode->helpText.'</div>';
    }

    $html = <<<CODE

<div id="wgt_box_{$id}" >
  <label for="wgt-input-{$id}" class="wgt-label">{$helpIcon}{$label}{$pNode->requiredText}</label>
  {$helpText}
  <div class="wgt-input {$pNode->size}" >
    <input {$codeAttr} />{$pNode->appendText}
  </div>
  <div class="wgt-clear tiny" ></div>
</div>

CODE;

    return $this->out($html);

  }//end public function input */



  /**
   * @param string $name
   * @param string $value
   * @param string $elementKey
   * @param string $data
   * @param string $value
   * @param array $attributes
   * @param array $params
   */
  public function selectboxByKey
  (
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
      $tmpId = str_replace(array('[',']'), array('-','-'), $tmp[0]);

      if (count($tmp) > 1) {

        $id      = $tmpId."-".$tmp[1];
        $inpName = $tmp[0]."[{$tmp[1]}]";
      } else {
        $id      = $tmpId;
        $inpName = $tmp[0];
      }

      $attributes['id']     = "wgt-input-{$id}";
    }

    if(!isset($attributes['name'])){
    	$attributes['name'] = $name;
    }

    if(!isset($attributes['class'])){
    	$attributes['class'] = 'asgd-'.$this->id;
    } else {
    	$attributes['class'] .= ' asgd-'.$this->id;
    }

    if (!Webfrap::classLoadable($elementKey))
      return '<!-- Missing '.$elementKey.' -->';

    $selectBoxNode = new $elementKey();

    $selectBoxNode->addAttributes($attributes);
    $selectBoxNode->setWidth('medium');

    $selectBoxNode->assignedForm = $this->id;

    $selectBoxNode->setActive($value);

    $selectBoxNode->setReadonly($pNode->readonly);
    $selectBoxNode->setRequired($pNode->required);

    $selectBoxNode->setData($data);

    $selectBoxNode->setLabel($label);

    // set an empty first entry
    if (!is_null($pNode->firstFree))
      $selectBoxNode->setFirstFree($pNode->firstFree);

    return $this->out($selectBoxNode->build());

  }//end public function selectboxByKey */

  /**
   * @param string $label
   * @param string $name
   * @param string $elementKey
   * @param string $data
   * @param string $value
   * @param array $attributes
   * @param array $params
   */
  public function multiSelectByKey
  (
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
        'class'     => 'asgd-'.$this->id,
      )
    );
    $selectBoxNode->setWidth('small');

    $selectBoxNode->assignedForm = $this->id;

    $selectBoxNode->setActive($value);

    //$selectBoxNode->setReadonly($readOnly);
    //$selectBoxNode->setRequired($required);

    $selectBoxNode->setData($data);
    $selectBoxNode->setLabel($label);

    // set an empty first entry
    //if (!is_null($firstFree))
      //$selectBoxNode->setFirstFree($firstFree);
    return $this->out($selectBoxNode->build());

  }//end public function multiSelectByKey */


/*//////////////////////////////////////////////////////////////////////////////
// title
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $label
   * @param string $nodeKey
   * @param array $labels
   */
  public function i18nLabel($label, $nodeKey, $labels)
  {

    $iconAdd = $this->icon('control/add.png', 'Add');
    $iconDel = $this->icon('control/delete.png', 'Delete');

    $addInput = WgtForm::input(
      'Label',
      $this->domainKey.'-label-text',
      '',
      array(
        'name'  => 'label[text]',
        'class' => 'medium wgte-text'
      )
    );

    $langSelector = WgtForm::decorateInput(
        'Lang',
        'wgt-select-'.$this->domainKey.'-label-lang',
        <<<HTML
<select
      id="wgt-select-{$this->domainKey}-label-lang"
      name="label[lang]"
      data_source="select_src-{$this->domainKey}-lang"
      class="wcm wcm_widget_selectbox wgte-lang"
        >
        <option>Select a language</option>
    </select>
HTML
    );

    $listLabels = '';

    foreach ($labels as $lang => $label) {
      $listLabels .= '<li class="lang-'.$lang.'" >'. WgtForm::input(
        'Lang '.Wgt::icon('flags/'.$lang.'.png', 'xsmall', array(), ''),
        $this->domainKey.'-label-'.$lang,
        $label, array(
          'name'  => $nodeKey.'[label]['.$lang.']',
          'class' => 'medium lang-'.$lang
        ),
        $this->id,
        '<button class="wgt-button wgta-drop" wgt_lang="'.$lang.'" tabindex="-1" >'.$iconDel.'</button>'
      ).'</li>';
    }

    $html = <<<CODE
<fieldset class="wgt-space bw61" >
  <legend>{$label}</legend>

  <div id="wgt-i18n-list-{$this->domainKey}-label" class="wcm wcm_widget_i18n-input-list bw6" >

  <div class="left bw3" >
    {$addInput}
    {$langSelector}

    <button class="wgt-button wgta-append" tabindex="-1" >{$iconAdd} Add Language</button>
  </div>

  <div class="right bw3" >
    <ul class="wgte-list"  >
    {$listLabels}
    </ul>
  </div>

  <var id="wgt-i18n-list-{$this->domainKey}-label-cfg-i18n-input-list" >
  {
    "key":"{$this->domainKey}-label",
    "inp_prefix":"{$nodeKey}[label]",
    "form_id":"{$this->id}"
  }
  </var>

  </div>

</fieldset>
CODE;

    return $this->out($html);

  }//end public function i18nLabel */

  /**
   * @param string $label
   * @param string $nodeKey
   * @param array $labels
   */
  public function i18nText($label, $nodeKey, $texts)
  {

    $iconAdd = $this->icon('control/add.png', 'Add');
    $iconDel = $this->icon('control/delete.png', 'Delete');

    $i18nTexts = '';

    foreach ($texts as $lang => $text) {

      $innerWysiwyg = $this->wysiwyg(
        $lang,
        $this->domainKey.'-'.$nodeKey.'-'.$lang,
        $text,
        array(
          'name' => $nodeKey.'['.$lang.']'
         ),
        $this->id,
        null,
        true,
        true
      );

      $i18nTexts .= <<<HTML
    <div
      id="wgt-tab-{$this->domainKey}-{$nodeKey}-{$lang}"
      title="{$lang}" wgt_icon="xsmall/flags/{$lang}.png"
      class="wgt_tab wgt-tab-{$this->domainKey}_{$nodeKey}">
      <fieldset id="wgt-fieldset-{$this->domainKey}-{$nodeKey}-{$lang}"  class="wgt-space bw6 lang-{$lang}"  >
        <legend>Lang {$lang}</legend>
        {$innerWysiwyg}
      </fieldset>
    </div>
HTML;

    }


    $html = <<<CODE
<div
  id="wgt-tab-{$this->domainKey}_{$nodeKey}"
  class="wcm wcm_ui_tab wcm_widget_i18n-input-tab wgt-space wgt-border ui-corner-top bw62"  >
  <div id="wgt-tab-{$this->domainKey}_{$nodeKey}-head" class="wgt_tab_head ui-corner-top" >

    <div class="wgt-container-controls">
      <div class="wgt-container-buttons" >
        <h2 style="width:120px;float:left;text-align:left;" >{$label}</h2>
      </div>
      <div class="tab_outer_container">
        <div class="tab_scroll" >
          <div class="tab_container"></div>
        </div>
     </div>
    </div>
  </div>

  <div id="wgt-tab-{$this->domainKey}_{$nodeKey}-body" class="wgt_tab_body" >
{$i18nTexts}
  </div>

  <div class="wgt-panel" >
    <select
      id="wgt-select-{$this->domainKey}-new-lang"
      name="{$nodeKey}[lang]"
      data_source="select_src-{$this->domainKey}-lang"
      class="wcm wcm_widget_selectbox wgte-lang" >
      <option>Select a language</option>
    </select>

    <button class="wgt-button wgta-append" tabindex="-1" >{$iconAdd} Add Language</button>
  </div>

  <div class="wgt-clear xxsmall" ></div>

  <var id="wgt-tab-{$this->domainKey}_{$nodeKey}-cfg-i18n-input-tab" >
  {
    "key":"{$this->domainKey}-{$nodeKey}",
    "inp_prefix":"{$nodeKey}",
    "form_id":"{$this->id}",
    "tab_id":"wgt-tab-{$this->domainKey}_{$nodeKey}"
  }
  </var>

</div>
CODE;

    return $this->out($html);

  }//end public function i18nText */

  /**
   *
   */
  public function i18nSelectSrc()
  {

    $langCode = array('{"i":"0","v":"Select a language"}');

    if ($this->i18nLanguages) {
      foreach ($this->i18nLanguages as $lang) {
        $langCode[] = '{"i":"'.$lang['id'].'","v":'.json_encode($lang['value']).'}';
      }
    }

    $langCode = implode(','.NL, $langCode  );

    $html = <<<HTML
    <var id="select_src-{$this->domainKey}-lang" >
    [
    {$langCode}
    ]
    </var>
HTML;

    return $this->out($html);

  }//end public function i18nSelectSrc */

/*//////////////////////////////////////////////////////////////////////////////
// title
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $label
   * @return string
   */
  public function submit($label, $appendCode = null, $icon = null)
  {

    $codeIcon = '';

    if ($icon)
      $codeIcon = $this->view->icon($icon, $label).' ';

    $html = <<<CODE

<button class="wgt-button" tabindex="-1" onclick="\$R.form('{$this->id}');{$appendCode}"  >{$codeIcon}{$label}</button>

CODE;

    return $this->out($html);

  }//end public function input */

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

    if ($pNode->required)
      $pNode->requiredText = ' <span class="wgt-required" >*</span>';

    if (!$pNode->appendText)
      $pNode->appendText = $appendText;

    return $pNode;

  }//end public function prepareParams */

}//end class WgtFormBuilder
