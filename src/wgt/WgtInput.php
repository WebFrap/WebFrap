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
abstract class WgtInput extends WgtAbstract
{
/*//////////////////////////////////////////////////////////////////////////////
// attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Das Label zum Inputelement
   * @var string
   */
  public $label     = null;

  /**
   * ist das feld ein pflichtfeld
   * @var boolean
   */
  public $required  = false;

  /**
   * Flag ob auf dem Feld ein Unique Constraint liegt
   * @var boolean
   */
  public $unqiue  = false;
  
  /**
   *
   * @var boolean
   */
  public $bigLabel  = false;

  /**
   *
   * @var boolean
   */
  public $activ     = null;

  /**
   *
   * @var string
   */
  public $type      = null;

  /**
   * flag if in the ajax request the element is serialized to html
   * or if just the value of the element will be sended
   * @var boolean
   */
  public $serializeElement = false;

  /**
   * Liste mit texten die irgendwo im inhalt platziert werden können
   * @var array
   */
  public $texts     = null;

  /**
   * s
   * @var string
   */
  public $assignedForm = null;

  /**
   * Flag für einen readonly modus des input elements
   * @var boolean
   */
  public $readOnly = null;

  /**
   * Die klassen
   * @var array
   */
  public $classes = array();

  /**
   * Size des Inputelements
   * @var string
   */
  public $size = 'medium';

  /**
   * Größe des Lables
   * @var string
   */
  public $labelSize = null;

  /**
   * Doku
   * @var string
   */
  public $docu = null;

/*//////////////////////////////////////////////////////////////////////////////
// methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * default constructor
   *
   * @param int $name the name of the wgt object
   * @param LibTemplate $view
   */
  public function __construct($name = null, $view = null)
  {

    $this->texts  = new TArray();

    $this->name   = $name;
    $this->init();

    if ($view)
      $view->addElement($name, $this);

  } // end public function __construct */

  /**
   * @param string $key
   * @param string $text
   */
  public function setText($key , $text)
  {
    $this->texts->$key = $text;
  }//end public function setText */

  /**
   * @param string $class
   */
  public function addInputClass($class)
  {
    $this->classes[$class] = $class;
  }//end public function addInputClass */

  /**
   * @param string $class
   */
  public function hasInputClass($class)
  {
    return isset($this->classes[$class]);
  }//end public function addInputClass */

  /**
   * @param string $class
   */
  public function removeInputClass($class)
  {

    if (isset($this->classes[$class]))
      unset($this->classes[$class]);

  }//end public function removeInputClass */

  /**
   *
   * @param string $label
   * @param boolean $required
   * @return void
   */
  public function setLabel($label, $required = null)
  {

    $this->label    = $label;

    if (!is_null($required))
      $this->required = $required;

  }//end public function setLabel */

  /**
   * @param string $formId
   * @param string $prefix
   */
  public function setAssignedForm($formId, $prefix = 'asgd-')
  {
    $this->assignedForm = $prefix.$formId;
  }//end public function setAssignedForm */

 /**
  * @param boolean $required
  * @return void
  */
  public function setRequired($required = true)
  {

    if ($required) {
      $this->classes['wcm'] = 'wcm';
      $this->classes['wcm_valid_required'] = 'wcm_valid_required';
    } else {
      if (isset($this->classes['wcm_valid_required']))
        unset($this->classes['wcm_valid_required']);
    }

    $this->required = $required;

  }// end public function setRequired */
  
 /**
  * @param boolean $unique
  * @return void
  */
  public function setUnique($unique = true)
  {

    if ($unique) {
      $this->classes['wcm'] = 'wcm';
      $this->classes['wcm_valid_unique'] = 'wcm_valid_unique';
    } else {
      if (isset($this->classes['wcm_valid_unique']))
        unset($this->classes['wcm_valid_unique']);
    }

    $this->unqiue = $unique;

  }// end public function setRequired */

 /**
  * Setzen des Validators
  * @param boolean $validator
  * @param boolean $required
  * @param boolean $unique
  * @return void
  */
  public function setValidator($validator, $required = false, $unique = false)
  {

    $this->classes['wcm'] = 'wcm';
    
    // kann auch unique sein wenn nur required oder unique gesetzt werden soll
    if ($validator)
      $this->classes['wcm_valid_'.$validator] = 'wcm_valid_'.$validator;
    
    if($unique)
      $this->classes['wcm_valid_unique'] = 'wcm_valid_unique';
      
    if($required)
      $this->classes['wcm_valid_required'] = 'wcm_valid_required';

    $this->required = $required;
    
  }// end public function setValidator */

 /**
  * @param string $data
  * @param string $value
  * @return void
  */
  public function setData($data , $value = null)
  {
    $this->attributes['value'] = $data;
  }// end public function setData */

  /** add Data to the Item
   *
   * @param string $key
   * @param array $value
   * @return void
   */
  public function addData($key , $value = null)
  {
    $this->setData($key);
  }//end public function addData */

 /**
  * @param mixed
  * @return void
  */
  public function getData($key = null)
  {
    return isset($this->attributes['value'])
      ? $this->attributes['value']
      : null;

  }// end public function getData */

 /**
  * @param mixed
  * @return void
  */
  public function setActive($active = true)
  {
    $this->activ = $active;
  }// end public function setActive */

 /**
  * @return string the value of the input field
  */
  public function value()
  {
    return isset($this->attributes['value'])?$this->attributes['value']:null;
  }// end public function value */

  /**
   * set the item to readonly
   *
   * @param boolean $readOnly
   */
  public function setReadOnly($readOnly = true)
  {

    $this->readOnly = $readOnly;

    if ($readOnly) {
      //$this->attributes['disabled'] = 'disabled';
      $this->attributes['readonly'] = 'readonly';
    } else {
      /*
      if (isset($this->attributes['disabled']))
        unset($this->attributes['disabled']);
      */

      if (isset($this->attributes['readonly']))
        unset($this->attributes['readonly']);
    }

  }//end public function setReadOnly */

/*//////////////////////////////////////////////////////////////////////////////
// buildr
//////////////////////////////////////////////////////////////////////////////*/

 /**
  * @return string
  */
  public function element()
  {
    return '<input '.$this->asmAttributes().' />';
  }// end public function element */

  /**
   * @param array
   * @return string
   */
  public function renderElement($attributes = array())
  {

    if ($attributes)
      $this->attributes = array_merge($this->attributes, $attributes);

    // ist immer ein text attribute
    if (!isset($this->attributes['type']))
      $this->attributes['type'] = 'text';

    return $this->element();

  }//end public function renderElement */

  /**
   * @return string
   */
  public function buildLabel()
  {

    $required = $this->required
      ? '<span class="wgt-required">*</span>'
      : '';

    return $this->label.' '.$required;

  }//end public function buildLabel */

  public function renderDocu($id)
  {

    if ($this->docu) {
       return '<span class="wcm wcm_ui_dropform" id="wgt-input-help-'.$id.'" ><i class="icon-info-sign" ></i><var>{"size":"small","button":""}</var></span>'
         .'<div class="wgt-input-help-'.$id.' hidden" ><div class="wgt-panel title" ><h2>Help</h2></div><div class="wgt-space" >'.$this->docu.'</div></div>';
    }

    return null;
  }

  /**
   * @param array
   * @return string
   */
  public function build($attributes = array())
  {

    if ($attributes)
      $this->attributes = array_merge($this->attributes,$attributes);

    // ist immer ein text attribute
    if (!isset($this->attributes['type']))
      $this->attributes['type'] = 'text';

    $id = $this->getId();

    $required = $this->required?'<span class="wgt-required">*</span>':'';

    $helpIcon = $this->renderDocu($id);

    $html = <<<HTML
    <div class="wgt-box input" id="wgt-box-{$id}" >
      {$this->texts->topBox}
      <div class="wgt-label" ><label
        for="{$id}" >{$this->texts->beforeLabel}{$this->label}{$this->texts->afterLabel} {$required}{$this->texts->endLabel}
      </label>{$helpIcon}</div>
      {$this->texts->middleBox}
      <div class="wgt-input {$this->width}" >{$this->texts->beforInput}{$this->element()}{$this->texts->afterInput}</div>
      {$this->texts->bottomBox}
      <div class="wgt-clear tiny" >&nbsp;</div>

    </div>

HTML;

    return $html;

  }//end public function build */

  /**
   * @return string
   */
  public function buildAjaxArea()
  {

    if (!isset($this->attributes['id']))
      return '';

    if (!isset($this->attributes['value']))
      $this->attributes['value'] = '';

    if ($this->serializeElement) {
      $html = '<htmlArea selector="input#'.$this->attributes['id'].'" action="thml" ><![CDATA['
        .$this->element().']]></htmlArea>'.NL;
    } else {
      $html = '<htmlArea selector="input#'.$this->attributes['id'].'" action="value" ><![CDATA['
        .$this->attributes['value'].']]></htmlArea>'.NL;
    }

    return $html;

  }//end public function buildAjaxArea */

  /**
   * build the attributes
   * @param array $attributes
   * @return string
   */
  protected function asmAttributes($attributes = array(), $setType = true)
  {

    if (!$attributes) {
      $attributes = $this->attributes;
    } else {
      $attributes = array_merge($this->attributes, $attributes);
    }

    if ($attributes && $setType)
      $this->attributes['type'] = $this->type;

    if (!isset($attributes['class'])) {
      $attributes['class'] = '';
    }

    if ($this->readOnly) {
      $attributes['readonly'] = 'readonly';
      $this->classes['wgt-readonly'] = 'wgt-readonly';
    }

    if ($this->required) {
      $this->classes['wcm'] = 'wcm';
      $this->classes['wcm_valid_required'] = 'wcm_valid_required';
    }

    if ($this->classes) {
      $attributes['class'] = implode(' ', $this->classes).' '.$attributes['class'];
    }

    $html = '';

    if (!isset($attributes['id']))
      $attributes['id'] = 'wgt-input-'.uniqid();

    foreach($attributes as $key => $value)
      $html .= $key.'="'.$value.'" ';

    return $html;

  }// end protected function asmAttributes */

}//end class WgtInput

