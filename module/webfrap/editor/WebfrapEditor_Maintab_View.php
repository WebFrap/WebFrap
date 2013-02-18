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
 * @subpackage Daidalos
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class WebfrapEditor_Maintab_View extends WgtMaintab
{
/*//////////////////////////////////////////////////////////////////////////////
// Methoden
//////////////////////////////////////////////////////////////////////////////*/

  
  /**
   * @param string $nodeKey
   * @param int $containerId
   * @return void
   */
  public function displayForm($nodeKey, $containerId )
  {
    
    /* @var $model WebfrapKnowhowNode_Model */
    $model = $this->model;

    $activeNode = $model->getActiveNode();
    
    if (!is_null($activeNode)  )
    {
      $this->setLabel( 'Edit '.$activeNode->access_key );
      $this->setTitle( 'Edit '.$activeNode->access_key );
      $idKey = $activeNode->getId();
    } else {
      $this->setLabel( 'Add '.$nodeKey );
      $this->setTitle( 'Add '.$nodeKey );
      $activeNode = $model->preCreateNode($nodeKey, $containerId ); 
      $idKey = 'new';
    }


    $this->setTemplate( 'webfrap/knowhow_node/maintab/node_form' );
    
    $knHowNode = new WgtElementKnowhowNode( 'node', $this );
    $knHowNode->setDataNode($activeNode ); 
    
    $knHowNode->setId($idKey );
    $knHowNode->displaySave = false;
    
    $this->addMenu($activeNode );

  }//end public function displayForm */


  /**
   * add a drop menu to the create window
   *
   * @param TFlowFlag $params the named parameter object that was created in
   *   the controller
   * {
   *   string formId: the id of the form;
   * }
   */
  public function addMenu($activeNode )
  {

    $iconMenu          = $this->icon( 'control/menu.png'     ,'Menu'   );
    $iconClose         = $this->icon( 'control/close.png'    ,'Close'   );
    $iconSearch        = $this->icon( 'control/search.png'   ,'Search'  );
    $iconBookmark      = $this->icon( 'control/bookmark.png' ,'Bookmark');
    $iconSave          = $this->icon( 'control/save.png' ,'Save' );
    $iconShow          = $this->icon( 'control/show.png' ,'Show' );
    
    $iconSupport   = $this->icon( 'control/support.png'  ,'Support' );
    $iconBug       = $this->icon( 'control/bug.png'      ,'Bug' );
    $iconFaq       = $this->icon( 'control/faq.png'      ,'Faq' );
    $iconHelp      = $this->icon( 'control/help.png'     ,'Help' );
    
    $nodeId = $activeNode->getId();
      
    $menu     = $this->newMenu($this->id.'_dropmenu' );
    
    $menu->id = $this->id.'_dropmenu';


    $menu->content = <<<HTML
    
<div class="inline" >
  <button 
    class="wcm wcm_control_dropmenu wgt-button"
    id="{$this->id}-control" 
    wgt_drop_box="{$this->id}_dropmenu"  >{$iconMenu} {$this->i18n->l('Menu','wbf.label')}</button>
  <var id="{$this->id}-control-cfg-dropmenu"  >{"triggerEvent":"mouseover","closeOnLeave":"true","align":"right"}</var>
</div>
    
<div class="wgt-dropdownbox" id="{$this->id}_dropmenu" >
  <ul>
    <li>
      <a class="wgtac_bookmark" >{$iconBookmark} {$this->i18n->l('Bookmark', 'wbf.label')}</a>
    </li>
  </ul>
  <ul>
    <li>
      <a class="deeplink" >{$iconSupport} {$this->i18n->l('Support', 'wbf.label')}</a>
      <span>
      <ul>
        <li><a class="wcm wcm_req_ajax" href="modal.php?c=Wbfsys.Issue.create&amp;context=menu" >{$iconBug} {$this->i18n->l('Bug', 'wbf.label')}</a></li>
        <li><a class="wcm wcm_req_ajax" href="modal.php?c=Wbfsys.Faq.create&amp;context=menu" >{$iconFaq} {$this->i18n->l('Faq', 'wbf.label')}</a></li>
      </ul>
      </span>
    </li>
    <li>
      <a class="wgtac_close" >{$iconClose} {$this->i18n->l('Close','wbf.label')}</a>
    </li>
  </ul>
</div>
  
<div class="wgt-panel-control" >
  <button class="wgt-button wgtac_save" >{$iconSave} {$this->i18n->l('Save','wbf.label')}</button>
</div>

HTML;

    if ($nodeId )
    {
      $menu->content .= <<<BUTTONJS

<div class="wgt-panel-control" >
  <button class="wgt-button wgtac_show" >{$iconShow} {$this->i18n->l('Show','wbf.label')}</button>
</div>

BUTTONJS;

    }
    
    $this->injectActions($menu, $activeNode );

  }//end public function addMenu */
  

  /**
   * just add the code for the edit ui controls
   *
   * @param int $objid die rowid des zu editierende Datensatzes
   * @param TFlag $params benamte parameter
   * {
   *   @param LibAclContainer access: der container mit den zugriffsrechten für
   *     die aktuelle maske
   *
   *   @param string formId: die html id der form zum ansprechen des update
   *     services
   * }
   */
  public function injectActions($menu, $activeNode )
  {

    // add the button action for save in the window
    // the code will be binded direct on a window object and is removed
    // on close
    // all buttons with the class save will call that action
    
    $id = $activeNode->getId();
    
    if (!$id )
      $idKey = 'new';
    else 
      $idKey = $id;
    
    $code = <<<BUTTONJS

    self.getObject().find(".wgtac_close").click(function(){
      self.close();
    });
    
    self.getObject().find(".wgtac_save").click(function(){
      \$R.form('wgt-form-knowhow-node-{$idKey}');
    });


BUTTONJS;

    if ($id )
    {
      $code .= <<<BUTTONJS

    self.getObject().find(".wgtac_show").click(function(){
      self.close();
      \$R.get('maintab.php?c=Webfrap.KnowhowNode.show&objid={$id}');
    });

BUTTONJS;

    }


    $this->addJsCode($code );

  }//end public function injectActions */

}//end class DaidalosBdlNodeProfile_Maintab_View

