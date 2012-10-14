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
 * @package WebFrap
 * @subpackage tech_core
 */
class WgtElementKnowhowNode
  extends WgtAbstract
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////
  
  /**
   * @var string
   */
  public $label = 'Know How Node';

  /**
   * @var string
   */
  public $urlSave = 'ajax.php?c=Webfrap.KnowhowNode.save';
  
  /**
   * @var string
   */
  public $urlDelete = 'ajax.php?c=Webfrap.KnowhowNode.delete';

  /**
   * Die ID des Containers an welchem der Node angehängt werden soll
   * @var int
   */
  public $containerId = null;
  
  /**
   * @var WbfsysKnowhowNode_Entity
   */
  public $dataNode = null;
  
  /**
   * @var string
   */
  public $idKey = null;
  
  /**
   * Flag ob der Savenode angezeigt werden soll
   * @var boolean
   */
  public $displaySave = true;
  
  /**
   * Das User Element
   * @var User
   */
  public $user = null;
  
  /**
   * Das View Objekt
   * @var LibTemplate
   */
  public $view = null;
  
  /**
   * Der Access Container
   * @var 
   */
  public $access = null;

////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * default constructor
   *
   * @param int $name the name of the wgt object
   */
  public function __construct( $name = null, $view = null )
  {

    $this->texts  = new TArray();

    $this->idKey   = $name;
    $this->init();

    if( $view )
    {
      $view->addElement( $name, $this );
      $this->view = $view;
      $this->user = $view->getUser();
    }
    else 
    {
      $this->view = Webfrap::$env->getView();
      $this->user = Webfrap::$env->getUser();
    }

  } // end public function __construct */
  
////////////////////////////////////////////////////////////////////////////////
// Getter & Setter
////////////////////////////////////////////////////////////////////////////////

  /**
   * @return string
   */
  public function getIdKey()
  {
    
    if( is_null( $this->idKey ) )
      $this->idKey = Webfrap::uniqKey();
      
    return $this->idKey;
    
  }//end public function getIdKey */
  
  /**
   * @param string $id
   */
  public function setIdKey( $id )
  {
    $this->idKey = $id;
  }//end public function setIdKey */
  
  /**
   * (non-PHPdoc)
   * @see WgtAbstract::setId()
   */
  public function setId( $id )
  {
    $this->idKey = $id;
  }//end public function setId */
  
  /**
   * @param WbfsysKnowhowNode_Entity $dataNode
   */
  public function setDataNode( $dataNode )
  {
    $this->dataNode = $dataNode;
  }//end public function setDataNode */
  
////////////////////////////////////////////////////////////////////////////////
// render
////////////////////////////////////////////////////////////////////////////////
  
  /**
   * @param TFlag $params
   * @return string
   */
  public function render( $params = null )
  {
    
    if( $this->html )
      return $this->html;

    $this->idKey = $this->getIdKey( );
    
    if( $this->dataNode->getId() )
      $saveText = 'Save Node';
    else 
      $saveText = 'Add Node';

    $htmlSaveButton = '';
      
    if( $this->displaySave )
    {

      $htmlSaveButton = <<<BUTTON
      
    <div class="full">
      <div class="wgt-clear small">&nbsp;</div>
      <div class="right" style="margin-right:15px;" ><button 
        class="wgt-button"
        onclick="\$R.form('wgt-form-knowhow-node-{$this->idKey}');"
        id="wgt-input-knowhow-{$this->idKey}-cntrl" >{$saveText}</buttom></div>
      <div class="wgt-clear tiny">&nbsp;</div>
    </div>
      
BUTTON;

    }

    $html = <<<HTML

<div 
  class="wgt-space" 
  id="wgt-knowhow-node-{$this->idKey}"
  style="width:820px;height:auto;" >

  <div class="editor" >
    
    <form 
      method="post"
      id="wgt-form-knowhow-node-{$this->idKey}"
      action="{$this->urlSave}&amp;element={$this->idKey}" ></form>
      
    <input 
      type="hidden" 
      name="rowid" 
      id="wgt-input-knowhow-{$this->idKey}-rowid"
      value="{$this->dataNode->getId()}"
      class="asgd-wgt-form-knowhow-node-{$this->idKey}" />
      
    <input 
      type="hidden" 
      name="container_id" 
      id="wgt-input-knowhow-{$this->idKey}-container_id"
      value="{$this->dataNode->id_container}" 
      class="asgd-wgt-form-knowhow-node-{$this->idKey} static" />

    <div class="wgt_box input" >
      <label class="wgt-label xsmall" >Title <span class="wgt-required" >*</span></label>
      <div class="wgt-input large" ><input 
        type="text"
        value="{$this->dataNode->getSecure('title')}"
        class="large asgd-wgt-form-knowhow-node-{$this->idKey}"
        id="wgt-input-knowhow-{$this->idKey}-title"
        name="title"
        style="width:650px;" /></div>
      <div class="wgt-clear tiny" >&nbsp;</div>
    </div>
    
    <div class="wgt_box input" >
      <label class="wgt-label xsmall" >Key <span class="wgt-required">*</span></label>
      <div class="wgt-input large" ><input 
        type="text"
        value="{$this->dataNode->getSecure('access_key')}"
        class="large asgd-wgt-form-knowhow-node-{$this->idKey}"
        id="wgt-input-knowhow-{$this->idKey}-access_key"
        name="access_key"
        style="width:150px;" /></div>
      <div class="wgt-clear tiny" >&nbsp;</div>
    </div>
    
    <div class="wgt_box input" >
      <div class="wgt-input full" ><textarea 
        class="wcm wcm_ui_wysiwyg asgd-wgt-form-knowhow-node-{$this->idKey}"
        id="wgt-input-knowhow-{$this->idKey}-content"
        name="content"
        style="width:350px;" >{$this->dataNode->getSecure('raw_content')}</textarea><var id="wgt-input-knowhow-{$this->idKey}-content-cfg-wysiwyg" >{
        "width":"800",
        "height":"600",
        "mode":"know_how"
        }</div>
      <div class="wgt-clear tiny" >&nbsp;</div>
    </div>
    
		{$htmlSaveButton}
    
  </div>
  
</div>

HTML;


    return $html;

  }// end public function render */


}// end class WgtElementKnowhowNode


