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
class WgtInputWindow
  extends WgtInput
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   *
   * @var string
   */
  public $refValue  = '';

  /**
   *
   * @var string
   */
  public $listUrl   = '';

  /**
   *
   * @var string
   */
  public $listIcon  = 'control/link.png';

  /**
   *
   * @var string
   */
  public $entityUrl = '';

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

////////////////////////////////////////////////////////////////////////////////
// Getter & Setter
////////////////////////////////////////////////////////////////////////////////

  /**
   *
   * @param $url
   * @return void
   */
  public function setListUrl( $url )
  {
    $this->listUrl = $url;
  }//end public function setListUrl */

  /**
   *
   * @param $icon
   * @return void
   */
  public function setListIcon( $icon )
  {
    $this->listIcon = $icon;
  }//end public function setListIcon */

  /**
   *
   * @param $url
   * @return void
   */
  public function setEntityUrl( $url )
  {
    $this->entityUrl = $url;
  }//end public function setEntityUrl */

  /**
   *
   * @param $value
   * @return void
   */
  public function setRefValue( $value )
  {
    $this->refValue = $value;
  }//end public function setRefValue */



  /**
   *
   * @param $value
   * @return void
   */
  public function setAutocomplete( $autocomplete )
  {
    $this->autocomplete = $autocomplete;
  }//end public function setAutocomplete */

  /**
   *
   * @param $value
   * @return void
   */
  public function setHide( $hide = true )
  {
    $this->hide = $hide;
  }//end public function setHide */

////////////////////////////////////////////////////////////////////////////////
// Parser
////////////////////////////////////////////////////////////////////////////////

  /**
   * build all data to a ui element
   * @param array $attributes
   * @return string
   */
  public function build( $attributes = array() )
  {

    if( $this->html )
      return $this->html;

    if( $attributes )
      $this->attributes = array_merge($this->attributes,$attributes);

    // ist immer ein text attribute
    $this->attributes['type'] = 'hidden';

    $attrHidden = array();
    $attrHidden['value']  = $this->conEntity?$this->conEntity->getId():null;
    $attrHidden['id']     = $this->getId();
    $attrHidden['name']   = $this->attributes['name'];

    $attrHidden['class']  = $this->assignedForm
      ? 'asgd-'.$this->assignedForm:
      '';

    $showAttr           = $this->attributes;
    $showAttr['id']     = $showAttr['id'].'-tostring';
    $showAttr['value']  = $this->conEntity?$this->conEntity->text():null;
    $showAttr['name']   = substr( $this->attributes['name'], 0, -1  ).'-tostring]';
    $showAttr['class']  .= ' wgt-ignore';


    $codeAutocomplete = '';

    // nur readonly wenn autocomplete
    if( !$this->autocomplete || $this->readOnly )
    {

      $showAttr['readonly'] = 'readonly';
      $showAttr['class']  .= ' wgt-readonly';
    }
    else
    {
      $codeAutocomplete = '<var id="var-'.$showAttr['id'].'" >'.$this->autocomplete.'</var>';
      $showAttr['class']  .= ' wcm wcm_ui_autocomplete';
    }
    
    
    if( $this->readOnly )
    {
      $buttonAppend = "";
    }
    else
    {
      $buttonAppend = "<button class=\"wgt-button append\" ><img class=\"icon xsmall\" src=\"".View::$iconsWeb."xsmall/webfrap/menu.png\" /></button>";
    }
    

    unset($showAttr['type']);

    $htmlShowAttr = $this->asmAttributes($showAttr);
    $required     = $this->required?'<span class="wgt-required">*</span>':'';

    if( !$this->hide )
    {
      $html = '<div class="wgt-box input" id="wgt-box-'.$this->attributes['id'].'" >
        <label class="wgt-label" for="'.$this->attributes['id'].'" >'.$this->label.' '.$required.'</label>
        <div class="wgt-input '.$this->width.'" >
          <input type="hidden" class="'.$attrHidden['class'].'" value="'.$attrHidden['value'].'" id="'.$attrHidden['id'].'" name="'.$attrHidden['name'].'" />
          <input type="text" '.$htmlShowAttr.' />'.$codeAutocomplete.'
          '.$buttonAppend.'
        </div>
        <div class="wgt-clear tiny" >&nbsp;</div>
      </div>'.NL;
    }
    else
    {
      $html = '<input type="hidden" class="'.$attrHidden['class'].'" value="'.$attrHidden['value'].'" id="'.$attrHidden['id'].'" name="'.$attrHidden['name'].'" />'.NL;
    }

    $this->html = $html;

    return $this->html;

  }//end public function build */

  /**
   * @param string $attrId
   */
  public function buildJavascript( $attrId )
  {

    
    if( $this->readOnly )
    {
      $valAdd     = '0';
      $valRemove  = '0';
    }
    else 
    {
      $valAdd     = '1';
      $valRemove  = '1';
    }
      
    $theme = View::$themeWeb;
    
    $this->jsCode = "   if( undefined !== self && typeof self.getObject == 'function' ){";

    $this->jsCode .= <<<CODE

    self.getObject().find('input#{$attrId}-tostring').parent().find('button').menuSelector({
      stringField : self.getObject().find('input#{$attrId}-tostring'),
      hiddenField : self.getObject().find('input#{$attrId}'),
      add_link    : "'{$this->listUrl}&closeWindow=true'",
      edit_link   : "'{$attrId}', '{$this->entityUrl}&amp;objid='",
      add         : {$valAdd},
      edit        : 1,
      remove      : {$valRemove}
    });

CODE;

    if( $this->readOnly )
    {

      $this->jsCode .= <<<CODE

    self.getObject().find('input#{$attrId}-tostring').dblclick(
      function( e ){
        if( '' == self.getObject().find('input#{$attrId}').val() ){
          \$R.get( '{$this->listUrl}&closeWindow=true' );
        }
      }
    );

CODE;

    }

    /*
        else
        {
          \$R.get( '{$this->entityUrl}&amp;objid='+self.getObject().find('input#{$attrId}').val() );
        }
     */

    $this->jsCode .= ' } ';

      // add_image   : "{$theme}icons/xsmall/{$this->listIcon}",

      // &amp;target={$attrId}-onDrop_{$attrId}

  }//end public function buildJavascript */

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

    $this->editUrl = null;

    if( $this->serializeElement )
    {

      $html = '<htmlArea selector="input#'.$this->attributes['id'].'" action="thml" ><![CDATA['
        .$this->element().']]></htmlArea>'.NL;
    }
    else
    {

      $html = '<htmlArea selector="input#'.$this->attributes['id'].'" action="value" ><![CDATA['
        .$this->attributes['value'].']]></htmlArea>'.NL;

      $html .= '<htmlArea selector="input#'.$this->attributes['id'].'_tostring" action="value" ><![CDATA['
        .$this->conEntity->text().']]></htmlArea>'.NL;

    }

    return $html;

  }//end public function buildAjaxArea


}//end class WgtInputWindow


