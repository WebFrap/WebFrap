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
class WgtElementCommentTree
  extends WgtAbstract
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/
  
  /**
   * @var string
   */
  public $label = 'Comments';

  /**
   * @var string
   */
  public $urlCreate = 'ajax.php?c=Webfrap.Comment.save';
  
  /**
   * @var string
   */
  public $urlDelete = 'ajax.php?c=Webfrap.Comment.disconnect';
  
  /**
   * Die ID des Datensatzes der getaggt werden soll
   * @var int
   */
  public $refId = null;
  
  /**
   * Die ID des Datensatzes der getaggt werden soll
   * @var int
   */
  public $domainKey = null;
  
  
  /**
   * Die Maske in der die acls embeded wurden
   * @var string
   */
  public $refMask = null;
  
  /**
   * Die Maske in der die acls embeded wurden
   * @var string
   */
  public $refField = null;
  
  /**
   * Das User Element
   * @var User
   */
  public $user = null;
  
  /**
   * @var LibTemplate
   */
  public $view = null;
  
  /**
   * Der Access Container
   * @var 
   */
  public $access = null;
  
  /**
   * Context Container
   * @var Context
   */
  public $context = null;
  
  /**
   * Breite des Comment Tree
   * @var int
   */
  public $width = 900;

/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * default constructor
   *
   * @param int $name the name of the wgt object
   */
  public function __construct( $name = null, $view = null )
  {

    $this->texts  = new TArray();

    $this->name   = $name;
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
  
  /**
   * @param TFlag $params
   * @return string
   */
  public function render( $params = null )
  {
    
    if( $this->html )
      return $this->html;

    $this->name       = $this->getId( );
    $iconAdd  = $this->icon( 'control/add.png', 'Add' );
    
    $this->context = new WebfrapComment_Context();
    $this->context->element  = $this->name;
    $this->context->refMask  = $this->refMask;
    $this->context->refField = $this->refField;
    $this->context->refId    = $this->refId;
    
    $codeEntr = $this->renderEntry( $this->name, 0 );
    
    $htmlEditor = '';
    
    if( $this->access->update )
    {
    
      $htmlEditor = <<<HTML
    
  <div class="editor" style="width:500px;margin:0px auto;" >
    
    <form 
      method="post"
      id="wgt-form-commenttree-{$this->name}-{$this->refId}"
      action="{$this->urlCreate}{$this->context->toUrlExt()}" ></form>
      
    <input 
      type="hidden" 
      name="refid" 
      value="{$this->refId}" 
      class="asgd-wgt-form-commenttree-{$this->name}-{$this->refId} static" />
      
    <input 
      type="hidden" 
      name="rowid" 
      id="wgt-input-commenttree-{$this->name}-rowid-{$this->refId}"
      class="asgd-wgt-form-commenttree-{$this->name}-{$this->refId}" />
      
    <input 
      type="hidden" 
      name="parent" 
      id="wgt-input-commenttree-{$this->name}-parent-{$this->refId}"
      class="asgd-wgt-form-commenttree-{$this->name}-{$this->refId}" />

    <div class="wgt_box input" >
      <label class="wgt-label">Title <span class="wgt-required" >*</span></label>
      <div class="wgt-input large"><input 
        type="text"
        class="large asgd-wgt-form-commenttree-{$this->name}-{$this->refId}"
        id="wgt-input-commenttree-{$this->name}-title-{$this->refId}"
        name="title"
        style="width:350px;" /></div>
      <div class="wgt-clear tiny" >&nbsp;</div>
    </div>
    
    <div class="wgt_box input" >
      <label class="wgt-label full" >Comment <span class="wgt-required">*</span></label>
      <div class="wgt-input full" ><textarea 
        class="wcm wcm_ui_wysiwyg large medium-height asgd-wgt-form-commenttree-{$this->name}-{$this->refId}"
        id="wgt-input-commenttree-{$this->name}-comment-{$this->refId}"
        name="content"
        style="width:350px;" ></textarea>
        <var id="wgt-input-commenttree-{$this->name}-comment-{$this->refId}-cfg-wysiwyg" >{
        "width":"473",
        "height":"250"
        }</div>
      <div class="wgt-clear tiny" >&nbsp;</div>
    </div>
    
    <div class="full">
      <div class="wgt-clear small" >&nbsp;</div>
      <div class="right" style="margin-right:15px;" ><button 
        class="wgt-button"
      	tabindex="-1"
        id="wgt-input-commenttree-{$this->name}-cntrl-{$this->refId}" >Submit</buttom></div>
      <div class="wgt-clear tiny" >&nbsp;</div>
    </div>
    
  </div>
    
HTML;
    
    }
    
    $html = <<<HTML

<div 
  class="wcm wcm_widget_comment_tree wgt-content_box wgt-comment_tree" 
  id="wgt-comment_tree-{$this->name}-{$this->refId}"
  wgt_key="{$this->name}" 
  wgt_refid="{$this->refId}" 
  style="width:{$this->width}px;height:auto;" >
  
  <var id="wgt-comment_tree-{$this->name}-cfg-comment_tree" >{
    "url_delete":"{$this->urlDelete}{$this->context->toUrlExt()}"
  }</var>
  
  <div class="head" >
    <h2>{$this->label}</h2>
  </div>
  
  <div class="content" style="height:330px;"  >
    <ul class="wgt-tree" id="wgt-comment_tree-{$this->name}-cnt-0" >
    {$codeEntr}
    </ul>
  </div>
  
{$htmlEditor}
  
</div>

HTML;


    return $html;

  } // end public function render */
  
  /**
   * @param int $this->name
   * @return string
   */
  public function renderEntry( $elemId, $parentID )
  {
    
    $html = '';
    
    /*
id,
title,
rate,
content,
time_created,
parent,
firstname,
lastname,
user_name
     */
    
    if( isset( $this->data[$parentID] ) )
    {
      
      $entries = $this->data[$parentID];
      
      foreach( $entries as $entry )
      {
        
        /*<a class="rate" >Rate</a> |
         |
        <a class="delete" >Delete</a>*/
        
        $date = date( 'Y-m-d - H:i',  strtotime($entry['time_created'])  );
        
        $buttonEdit = '';
        $buttonAdd  = '';
    
        if( $this->access->update  )
        {
          
          $buttonAdd = <<<HTML
        <a class="answer" >Answer</a> |
        <a class="citate" >Citate</a> 
HTML;

        }
        
        if( $this->access->delete || $entry['creator_id'] === $this->user->getId() )
        {
          $buttonEdit = <<<HTML
 |
        <a class="edit" >Edit</a>
HTML;
        }
        
        
        $html .= <<<HTML
  <li>
    <div 
      class="wcm wcm_widget_comment_entry  wgt-comment comment-{$entry['id']}" 
      wgt_eid="{$entry['id']}" >
      
      <h3>{$entry['title']}</h3>
      <p>Autor <span class="user" >({$entry['user_name']}) {$entry['lastname']}, {$entry['firstname']}</span> <span class="date" >{$date}</span></p>
      <div class="content" >{$entry['content']}</div>
      <div class="cntrl" wgt_id="{$entry['id']}" >
{$buttonAdd}{$buttonEdit}
      </div>
      
    </div>
HTML;
        
        $entryID = (int)$entry['id'];
        
        $html .= '<ul id="wgt-comment_tree-'.$elemId.'-cnt-'.$entry['id'].'" >';
        if( isset( $this->data[$entryID] ) )
        {
          $html .= $this->renderEntry( $elemId, $entryID );
        }
        $html .= '</ul>';
        
        
        $html .= '</li>';
      }
      
    }
    
    return $html;
    
  }//end public function renderEntry */
  
  
  /**
   * @param int $elemId
   * @return string
   */
  public function renderAjaxUpdateEntry( $elemId, $entry )
  {
    
    $date = date( 'Y-m-d - H:i',  strtotime($entry['time_created'])  );
    
    $buttonEdit = '';
    $buttonAdd  = '';
    
    if( $this->access->update )
    {
      
      $buttonAdd = <<<HTML
        <a class="answer" >Answer</a> |
        <a class="citate" >Citate</a> 
HTML;

    }
    
    if( $this->access->delete || $entry['creator_id'] === $this->user->getId() )
    {
      
      $buttonEdit = <<<HTML
 |
        <a class="edit" >Edit</a>
HTML;

    }
      
    $html = <<<HTML

    <div 
      class="wcm wcm_widget_comment_entry  wgt-comment comment-{$entry['id']}" 
      wgt_eid="{$entry['id']}" >
      
      <h3>{$entry['title']}</h3>
      <p>Autor <span class="user" >({$entry['user_name']}) {$entry['lastname']}, {$entry['firstname']}</span> <span class="date" >{$date}</span></p>
      <div class="content" >{$entry['content']}</div>
      <div class="cntrl" wgt_id="{$entry['id']}" >
{$buttonAdd}{$buttonEdit}
      </div>
      
    </div>
HTML;
    
    return $html;
    
  }//end public function renderAjaxUpdateEntry */
  
  /**
   * @param int $elemId
   * @param int $entry
   * @return string
   */
  public function renderAjaxAddEntry( $elemId, $entry )
  {

    /*
id,
title,
rate,
content,
time_created,
parent,
firstname,
lastname,
user_name
     */
    
    $date = date( 'Y-m-d - H:i',  strtotime($entry['time_created'])  );
        
    $html = <<<HTML
  <li>
    <div 
      class="wcm wcm_widget_comment_entry  wgt-comment comment-{$entry['id']}" 
      wgt_eid="{$entry['id']}" >
      
      <h3>{$entry['title']}</h3>
      <p>Autor <span class="user" >({$entry['user_name']}) {$entry['lastname']}, {$entry['firstname']}</span> <span class="date" >{$date}</span></p>
      <div class="content" >{$entry['content']}</div>
      <div class="cntrl" wgt_id="{$entry['id']}" >
        <a class="answer" >Answer</a> |
        <a class="citate" >Citate</a> |
        <a class="edit" >Edit</a>
      </div>
      
    </div>
HTML;

    $html .= '<ul id="wgt-comment_tree-'.$elemId.'-cnt-'.$entry['id'].'" >';
    $html .= '</ul>';
    $html .= '</li>';
    
    return $html;
    
  }//end public function renderAjaxAddEntry */

} // end class WgtElementCommentTree


