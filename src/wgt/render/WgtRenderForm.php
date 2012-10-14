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
class WgtRenderForm
{
////////////////////////////////////////////////////////////////////////////////
// public interface attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * Die Id des Formulars
   * @var string $keyName
   */
  public $id   = null;

  /**
   * Die Action des Formulars
   * @var string
   */
  public $action   = null;

  /**
   * Methodes des Formulars
   * @var string
   */
  public $method   = null;
  
  /**
   * Der Domainkey des Elements
   * @var string
   */
  public $domainKey = null;
  
  /**
   * Flag ob das Formular direkt ausgegeben werden soll
   * oder zurückgegeben werden soll
   * @var boolean
   */
  public $cout = true;
  
  /**
   * Check ob das Formular per Ajax verschickt wird
   * @var boolean
   */
  public $ajax = true;
  
  /**
   * Liste der I18n Languages
   * @var array
   */
  public $i18nLanguages = array
  (
    array( 'id' => 'de', 'value' => 'german' ),
    array( 'id' => 'en', 'value' => 'english'  )
  );
  
////////////////////////////////////////////////////////////////////////////////
// Constructor
////////////////////////////////////////////////////////////////////////////////

  /**
   * @param string $action
   * @param string $id
   * @param string $method
   * @param boolean $cout   
   */
  public function __construct( $action, $domainKey, $method = 'post', $cout = true )
  {
    
    $this->action     = $action;
    $this->id        = 'wgt-form-'.$domainKey;
    $this->domainKey  = $domainKey;
    $this->method     = $method;
    $this->cout       = $cout;
    
  }//end public function __construct */

////////////////////////////////////////////////////////////////////////////////
// Magic Methodes
////////////////////////////////////////////////////////////////////////////////
  
  /**
   * @param string $code
   */
  public function out( $code )
  {
    
    if( $this->cout )
      echo $code;
      
    return $code;
    
  }//end public function out */

////////////////////////////////////////////////////////////////////////////////
// Some Static help Methodes
////////////////////////////////////////////////////////////////////////////////
  
  /**
   * @param boolean $ajax
   */
  public function form(  )
  {
    
    $code = <<<CODE
<form method="{$this->method}" action="{$this->action}" id="{$this->id}" >
CODE;

    if( $this->ajax )
      $code .= '</form>';

    return $this->out( $code );
    
  }//end public static function form */
  
  /**
   * @return string
   */
  public function close(  )
  {

    return $this->out( '</form>' );
    
  }//end public static function close */
  
  
  /**
   * @param string $label
   * @param string $icon
   * @param array $attributes
   * @param string $callbackCode
   */
  public function submit
  ( 
    $label, 
    $icon = null, 
    $attributes = array(), 
    $callbackCode = '' 
  )
  {
    
    $callback = '';
    if( $this->ajax )
    {
      if( $callbackCode )
        $callback = ",'',{callback:function(){{$callbackCode}}}";
    }
      
    $attributes['class'] = 'wgt-button';
    
    if( $this->ajax )
      $attributes['onclick'] = "\$R.form('{$this->id}'{$callback});";
      
    $attrCode = Wgt::asmAttributes($attributes);
    
    $iconCode = '';
    if( $icon )
      $iconCode = Wgt::icon($icon,'xsmall', array('alt'=>$label));

    $code = <<<CODE
<button {$attrCode} >{$iconCode}{$label}</button>
CODE;

    return $this->out( $code );
    
  }//end public static function form */
  
  /**
   * @param string $label
   * @param string $name
   * @param string $value
   * @param array $attributes
   * @param string $formId
   * @param string $appendText
   * @param string $size
   */
  public function input
  ( 
    $label, 
    $name, 
    $value = null, 
    $attributes = array(),
    $appendText = null,
    $size = 'medium'
  )
  {
    
    if( is_string($attributes) )
    {
      $size = $attributes;
      $attributes = array();
    }
    

    if( isset($attributes['id']) )
    {
      $id      = $attributes['id'];
      $inpName = $name;
    }
    else 
    {
    
      $tmp = explode(',', $name);
      
      if( count($tmp) > 1 )
      {
        $id      = $tmp[0]."-".$tmp[1];
        $inpName = $tmp[0]."[{$tmp[1]}]";
      }
      else 
      {
        $id      = $tmp[0];
        $inpName = $tmp[0];
      }
    
      $attributes['id']     = "wgt-input-{$id}"; 
    }
    
    $attributes['type']   = 'text';
    
    if( !isset($attributes['class']) )
      $attributes['class']  = $size;
    
    if( $this->id )
      $attributes['class']  .= ' asgd-'.$this->id;
    
    if( !isset($attributes['name']) )
      $attributes['name']   = $inpName;
      
    $attributes['value']  = str_replace('"', '\"', $value);

    $codeAttr = Wgt::asmAttributes( $attributes );

    $helpIcon = '';
    $helpText = '';
    if( is_array( $label ))
    {
       $helpIcon = '<span onclick="$S(\'#wgt-input-help-'.$id.'\').modal();" >'.Wgt::icon( 'control/help.png', 'xsmall' ).'</span> ';
       $helpText = '<div id="wgt-input-help-'.$id.'" class="template" >'.$label[1].'</div>';
       $label = $label[0];
    }
    
    $html = <<<CODE

<div id="wgt_box_{$id}" >
  <label for="wgt-input-{$id}" class="wgt-label">{$helpIcon}{$label}</label>
  {$helpText}
  <div class="wgt-input {$size}" >
    <input {$codeAttr} />{$appendText}
  </div>
  <div class="wgt-clear tiny" ></div>
</div>

CODE;

    return $this->out($html);

  }//end public static function input */
  
  /**
   * @param string $label
   * @param string $name
   * @param string $value
   * @param array $attributes
   * @param string $formId
   * @param string $appendText
   * @param string $size
   */
  public function date
  ( 
    $label, 
    $name, 
    $value = null, 
    $attributes = array(),
    $appendText = null,
    $size = 'small'
  )
  {
    
    if( isset($attributes['id']) )
    {
      $id      = $attributes['id'];
    }
    else 
    {
    
      $tmp = explode(',', $name);
      
      if( count($tmp) > 1 )
      {
        $id      = $tmp[0]."-".$tmp[1];
      }
      else 
      {
        $id      = $tmp[0];
      }
    
      $attributes['id']     = "wgt-input-{$id}"; 
    }
    
    if( isset($attributes['class']) )
    {
      $attributes['class'] .= ' wcm wcm_ui_date '.$size;
    }
    else 
    {
      $attributes['class'] = 'wcm wcm_ui_date '.$size;
    }
    
    $appendText = <<<HTML
        <var>{"button":"{$attributes['id']}-ap-button"}</var>
        <button id="{$attributes['id']}-ap-button" class="wgt-button append" >
          {$this->icon('control/calendar.png','Date')}
        </button>
    
HTML;

    return $this->input
    (
      $label, 
      $name, 
      $value, 
      $attributes,
      $appendText,
      $size
    );

  }//end public static function date */
  
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
    $appendText = null,
    $size = 'medium',
    $check = true
  )
  {
    
    if( is_string($attributes) )
    {
      $size = $attributes;
      $attributes = array();
    }
    

    if( isset($attributes['id']) )
    {
      $id      = $attributes['id'];
      $inpName = $name;
      
      $tmp = explode( '[', $inpName, 2 );
      
      if( 1 == count($tmp) )
        $inpNameCheck = $inpName.'_check';
      else 
        $inpNameCheck = $tmp[0].'_check['.$tmp[1];
      
    }
    else 
    {
    
      $tmp = explode(',', $name);
      
      if( count($tmp) > 1 )
      {
        $id      = $tmp[0]."-".$tmp[1];
        $inpName = $tmp[0]."[{$tmp[1]}]";
        $inpNameCheck = $tmp[0]."-check[{$tmp[1]}]";
      }
      else 
      {
        $id      = $tmp[0];
        $inpName = $tmp[0];
        
        $tmp2 = explode( '[', $inpName, 2 );
        
        if( 1 == count($tmp2) )
          $inpNameCheck = $inpName.'_check';
        else 
          $inpNameCheck = $tmp2[0].'_check['.$tmp2[1];
      }
    
      $attributes['id']     = "wgt-input-{$id}"; 
    }
    
    $attributes['type']   = 'password';
    
    if( !isset($attributes['class']) )
      $attributes['class']  = $size;
    
    if( $this->id )
      $attributes['class']  .= ' asgd-'.$this->id;
    
    if( !isset($attributes['name']) )
      $attributes['name']   = $inpName;
      
    $attrCheck       = $attributes;
    $attrCheck['id'] = $attributes['id'].'-check';
    $attrCheck['name'] = $inpNameCheck;
      
    $codeAttrCheck = Wgt::asmAttributes( $attrCheck );
      
    $attributes['value']  = str_replace('"', '\"', $value);

    $codeAttr = Wgt::asmAttributes( $attributes );

    $helpIcon = '';
    $helpText = '';
    if( is_array( $label ))
    {
       $helpIcon = '<span onclick="$S(\'#wgt-input-help-'.$id.'\').modal();" >'.Wgt::icon( 'control/help.png', 'xsmall' ).'</span> ';
       $helpText = '<div id="wgt-input-help-'.$id.'" class="template" >'.$label[1].'</div>';
       $label = $label[0];
    }
    
    $html = <<<CODE

<div id="wgt_box_{$id}" >
  <label for="wgt-input-{$id}" class="wgt-label">{$helpIcon}{$label}</label>
  {$helpText}
  <div class="wgt-input {$size}" >
    <input {$codeAttr} />{$appendText}
  </div>
  <div class="wgt-clear tiny" ></div>
</div>

CODE;

    if( $check )
    {
      $html .= <<<CODE

<div id="wgt_box_{$id}-check" >
  <label for="wgt-input-{$id}-check" class="wgt-label">{$helpIcon}{$label} Check</label>
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
   * @param string $name
   * @param string $value
   * @param string $label
   * @param string $subName
   */
  public function autocomplete
  ( 
    $label, 
    $name, 
    $value = null,  
    $loadUrl = null,
    $attributes = array(), 
    $appendText = null,
    $size = 'medium'
  )
  {

    if( isset($attributes['id']) )
    {
      $id      = $attributes['id'];
      $inpName = $name;
    }
    else 
    {
    
      $tmp = explode(',', $name);
      
      if( count($tmp) > 1 )
      {
        $id      = $tmp[0]."-".$tmp[1];
        $inpName = $tmp[0]."[{$tmp[1]}]";
      }
      else 
      {
        $id      = $tmp[0];
        $inpName = $tmp[0];
      }
    
      $attributes['id']     = "wgt-input-{$id}"; 
    }
    
    $attributes['type']   = 'text';
    
    if( !isset($attributes['class']) )
      $attributes['class']  = 'wcm wcm_ui_autocomplete '.$size;
    else 
      $attributes['class']  = 'wcm wcm_ui_autocomplete '.$size.' '.$attributes['class'];
    
    if( $this->id )
      $attributes['class']  .= ' asgd-'.$this->id;
    
    if( !isset($attributes['name']) )
      $attributes['name']   = $inpName;
      
    $attributes['value']  = str_replace('"', '\"', $value);

    $codeAttr = Wgt::asmAttributes( $attributes );

    $helpIcon = '';
    $helpText = '';
    if( is_array( $label ))
    {
       $helpIcon = '<span onclick="$S(\'#wgt-input-help-'.$id.'\').modal();" >'.Wgt::icon( 'control/help.png', 'xsmall' ).'</span> ';
       $helpText = '<div id="wgt-input-help-'.$id.'" class="template" >'.$label[1].'</div>';
       $label = $label[0];
    }
    
    $html = <<<CODE

<div id="wgt_box_{$id}" >
  <label for="wgt-input-{$id}" class="wgt-label">{$helpIcon}{$label}</label>
  {$helpText}
  <div class="wgt-input {$size}" >
    <input {$codeAttr} /><var class="meta" >{"url":"{$loadUrl}"}</var>{$appendText}
  </div>
  <div class="wgt-clear tiny" ></div>
</div>

CODE;

    return $this->out( $html );

  }//end public static function autocomplete */
  
  
  /**
   * @param string $name
   * @param string $value
   * @param string $label
   * @param string $subName
   */
  public function decorateInput
  ( 
    $label, 
    $id, 
    $element,
    $appendText = null
  )
  {

    $html = <<<CODE

<div id="wgt_box_{$id}" >
  <label for="wgt-input-{$id}" class="wgt-label">{$label}</label>
  <div class="wgt-input medium" style="width:200px;" >
    {$element}
    {$appendText}
  </div>
  <div class="wgt-clear tiny" ></div>
</div>

CODE;

    return $this->out( $html );

  }//end public static function decorateInput */
  
  
  /**
   * @param string $name
   * @param string $value
   * @param string $label
   * @param string $subName
   */
  public function wysiwyg
  ( 
    $label, 
    $name, 
    $value = null, 
    $attributes = array(), 
    $append = null,
    $plain = false,
    $forceReturn = false
  )
  {

    if( isset($attributes['id']) )
    {
      $id      = $attributes['id'];
      $inpName = $name;
    }
    else 
    {
    
      $tmp = explode(',', $name);
      
      if( count($tmp) > 1 )
      {
        $id      = $tmp[0]."-".$tmp[1];
        $inpName = $tmp[0]."[{$tmp[1]}]";
      }
      else 
      {
        $id      = $tmp[0];
        $inpName = $tmp[0];
      }
    
      $attributes['id']     = "wgt-wysiwyg-{$id}"; 
    }
    
    $attributes['class']  = 'wcm wcm_ui_wysiwyg medium ';
    
    if( $this->id )
      $attributes['class']  .= ' asgd-'.$this->id;
    
    if( !isset($attributes['name']) )
      $attributes['name']   = $inpName;

    $codeAttr = Wgt::asmAttributes( $attributes );
    
    $helpIcon = '';
    $helpText = '';
    if( is_array( $label ))
    {
       $helpIcon = '<span onclick="$S(\'#wgt-input-help-'.$id.'\').modal();" >'.Wgt::icon( 'control/help.png', 'xsmall' ).'</span> ';
       $helpText = '<div id="wgt-input-help-'.$id.'" class="template" >'.$label[1].'</div>';
       $label = $label[0];
    }
    
    if( $plain )
    {
      return <<<CODE

<textarea {$codeAttr}>{$value}</textarea>

CODE;
    }

    $html = <<<CODE

<div id="wgt_box_{$id}" >
  <label for="wgt-input-{$id}" class="wgt-label large" >{$helpIcon}{$label}</label>
  {$helpText}
  <div class="wgt-input medium left" >
    <textarea {$codeAttr}>{$value}</textarea>
  </div>
  <div class="wgt-clear tiny" ></div>
</div>

CODE;

  //<var id="{$id}-cfg-wysiwyg" >{"mode":"{$mode}"}</var>" 
    if( $forceReturn )
      return $html;
  
    return $this->out( $html );

  }//end public static function wysiwyg */
  
  /**
   * @param string $label
   * @param string $name
   * @param string $value
   * @param string $attributes
   * @param boolean $clean
   */
  public function upload
  ( 
    $label, 
    $name, 
    $value = null, 
    $attributes = array(), 
    $clean = false
  )
  {

    if( isset($attributes['id']) )
    {
      $id      = $attributes['id'];
      $inpName = $name;
    }
    else 
    {
    
      $tmp = explode(',', $name);
      
      if( count($tmp) > 1 )
      {
        $id      = $tmp[0]."-".$tmp[1];
        $inpName = $tmp[0]."[{$tmp[1]}]";
      }
      else 
      {
        $id      = $tmp[0];
        $inpName = $tmp[0];
      }
    
      $attributes['id']     = "wgt-input-{$id}"; 
    }
    
    $attributes['type']     = 'file';

    if( !isset($attributes['class']) )
      $attributes['class'] = 'medium';
    
    $attributes['class']    .= ' wgt-behind';
    
    if( $this->id )
      $attributes['class']  .= ' asgd-'.$this->id;
    
    $attributes['name']   = $inpName;
    $attributes['value']  = str_replace('"', '\"', $value);
    
    $attributes['onchange']   = "\$S('input#wgt-input-{$id}-display').val(\$S(this).val());\$S(this).attr('title',\$S(this).val());";

    $codeAttr = Wgt::asmAttributes( $attributes );
    
    $icon = Wgt::icon( 'control/upload_image.png', 'xsmall', array('alt'=>"Upload Image") );

    if( $clean )
    {
      $html = <<<CODE

  <div style="position:relative;overflow:hidden;" class="wgt-input medium" >
    <input {$codeAttr} />
    <input 
      type="text" 
      class="medium wgt-ignore wgt-overlay" 
      id="wgt-input-{$id}-display" name="{$id}-display" />
    <button class="wgt-button wgt-overlay append" >
      {$icon}
    </button>
  </div>

CODE;

      return $this->out( $html );
      
    }
    
    $html = <<<CODE

<div id="wgt_box_{$id}" >
  <label for="wgt-input-{$id}" class="wgt-label">{$label}</label>
  <div style="position:relative;" class="wgt-input medium" >
    <input {$codeAttr} />
    <input 
      type="text" 
      class="medium wgt-ignore wgt-overlay" 
      id="wgt-input-{$id}-display" name="{$id}-display" />
    <button class="wgt-button wgt-overlay append" >
      {$icon}
    </button>
  </div>
  <div class="wgt-clear tiny" ></div>
</div>

CODE;

    return $this->out( $html );

  }//end public static function upload */
  
  /**
   * @param string $label
   * @param string $name
   * @param string $checked
   * @param string $attributes
   * @param boolean $plain
   */
  public function checkbox
  ( 
    $label, 
    $name,
    $checked, 
    $attributes = array(), 
    $plain      = false 
  )
  {

    if( isset($attributes['id']) )
    {
      $id      = $attributes['id'];
      $inpName = $name;
    }
    else 
    {
    
      $tmp = explode(',', $name);
      
      if( count($tmp) > 1 )
      {
        $id      = $tmp[0]."-".$tmp[1];
        $inpName = $tmp[0]."[{$tmp[1]}]";
      }
      else 
      {
        $id      = $tmp[0];
        $inpName = $tmp[0];
      }
    
      $attributes['id']     = "wgt-input-{$id}"; 
    }
    
    $attributes['type']   = 'checkbox';
    
    if( $checked && 'false' != $checked )
      $attributes['checked']  = 'checked';
    
    if( $this->id )
      $attributes['class']  = 'asgd-'.$this->id;
    
    if( !isset( $attributes['name'] ) )
      $attributes['name']   = $inpName;

    $codeAttr = Wgt::asmAttributes( $attributes );
    
    if( $plain )
      return "<input {$codeAttr} />";

    $html = <<<CODE

<div id="wgt_box_{$id}" >
  <label for="wgt-input-{$id}" class="wgt-label">{$label}</label>
  <div class="wgt-input" >
    <input {$codeAttr} />
  </div>
</div>

CODE;

    return $this->out( $html );

  }//end public static function checkbox */
  
  /**
   * @param string $label
   * @param string $nodeKey
   * @param array $labels
   */
  public function i18nLabel( $label, $nodeKey, $labels )
  {
    
    $iconAdd = $this->icon( 'control/add.png', 'Add' );
    $iconDel = $this->icon( 'control/delete.png', 'Delete' );
    
    $addInput = WgtForm::input
    ( 
      'Label', 
      $this->domainKey.'-label-text', 
      '',
      array
      ( 
        'name'  => 'label[text]',
        'class' => 'medium wgte-text'
      )  
    );
    
    $langSelector = WgtForm::decorateInput
    ( 
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
    
    foreach( $labels as $lang => $label )
    {
      $listLabels .= '<li class="lang-'.$lang.'" >'. WgtForm::input
      ( 
        'Lang '.Wgt::icon( 'flags/'.$lang.'.png', 'xsmall', array(), '' ), 
        $idPrefix.'-label-'.$lang, 
        $label, array
        (
          'name'  => $nodeKey.'[label]['.$lang.']',
          'class' => 'medium lang-'.$lang
        ), 
        $formId,
        '<button class="wgt-button wgta-drop" wgt_lang="'.$lang.'" >'.$iconDel.'</button>'
      ).'</li>';
    }
    
    $html = <<<CODE
<fieldset class="wgt-space bw61" >
  <legend>{$label}</legend>
  
  <div id="wgt-i18n-list-{$this->domainKey}-label" class="wcm wcm_widget_i18n-input-list bw6" >

  <div class="left bw3" >
    {$addInput}
    {$langSelector}

    <button class="wgt-button wgta-append" >{$iconAdd} Add Language</button>
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
  public function i18nText( $label, $nodeKey, $texts )
  {
    
    $iconAdd = $this->icon( 'control/add.png', 'Add' );
    $iconDel = $this->icon( 'control/delete.png', 'Delete' );
    
    $i18nTexts = '';
    
    foreach( $texts as $lang => $text )
    {
      
      $innerWysiwyg = $this->wysiwyg
      ( 
        $lang, 
        $idPrefix.'-'.$nodeKey.'-'.$lang, 
        $text, 
        array
        ( 
          'name' => $nodeKey.'['.$lang.']'
        ), 
        $formId,
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
  class="wcm wcm_ui_tab wcm_widget_i18n-input-tab wgt-space wgt-border wgt-corner-top bw62"  >
  <div id="wgt-tab-{$this->domainKey}_{$nodeKey}-head" class="wgt_tab_head wgt-corner-top" >

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
    
    <button class="wgt-button wgta-append" >{$iconAdd} Add Language</button>
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

    $langCode = array( '{"i":"0","v":"Select a language"}' );
    
    if( $this->i18nLanguages )
    {
      foreach( $this->i18nLanguages as $lang )
      {
        $langCode[] = '{"i":"'.$lang['id'].'","v":'.json_encode($lang['value']).'}';
      }
    }
    
    $langCode = implode( ','.NL, $langCode  );
  
    $html = <<<HTML
    <var id="select_src-{$this->domainKey}-lang" >
    [
    {$langCode}
    ]
    </var>
HTML;

    return $this->out($code);
        
  }//end public function i18nSelectSrc */
  
  
  /**
   * @param string $name
   * @param string $label
   * @param string $class
   */
  public function icon( $name, $label, $class = 'icon' )
  {
    
    $attributes = array ('alt'=> $label );
    
    return Wgt::icon( $name, 'xsmall', $attributes, $class );
    
  }//end public function icon */
  
}//end class WgtRenderForm


