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
 * @subpackage Groupware
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class WebfrapMessage_New_Maintab_View
  extends WgtMaintab
{
/*//////////////////////////////////////////////////////////////////////////////
// Methoden
//////////////////////////////////////////////////////////////////////////////*/

  
  /**
   * @param TFlag $params
   * @return void
   */
  public function displayNew(  $params )
  {

    $this->setLabel( 'New Message');
    $this->setTitle( 'New Message' );

    $this->setTemplate( 'webfrap/message/maintab/create_form', true );

    $this->addMenu( $params );

  }//end public function displayNew */

  /**
   * add a drop menu to the create window
   *
   * @param TFlowFlag $params the named parameter object that was created in
   *   the controller
   * {
   *   string formId: the id of the form;
   * }
   */
  public function addMenu( $params )
  {

    $iconMenu          = $this->icon( 'control/menu.png'     ,'Menu'   );
    $iconClose         = $this->icon( 'control/close.png'    ,'Close'   );
    $iconSearch        = $this->icon( 'control/search.png'   ,'Search'  );
    $iconBookmark      = $this->icon( 'control/bookmark.png' ,'Bookmark');
    $iconSupport   = $this->icon( 'control/support.png'  ,'Support' );
    $iconBug       = $this->icon( 'control/bug.png'      ,'Bug' );
    $iconFaq       = $this->icon( 'control/faq.png'      ,'Faq' );
    $iconHelp      = $this->icon( 'control/help.png'     ,'Help' );

    $iconSend      = $this->icon( 'message/send.png' ,'Send' );
      
    $menu     = $this->newMenu( $this->id.'_dropmenu' );
    
    $menu->id = $this->id.'_dropmenu';

    $menu->content = <<<HTML
    
<div class="inline" >
  <button 
    class="wcm wcm_control_dropmenu wgt-button"
    id="{$this->id}_dropmenu-control" 
    wgt_drop_box="{$this->id}_dropmenu"  >{$iconMenu} {$this->i18n->l('Menu','wbf.label')}</button>
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
  <button class="wgt-button wgtac_send" >{$iconSend} {$this->i18n->l('Send','wbf.label')}</button>
</div>


HTML;
    
    $this->injectActions( $menu, $params );

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
  public function injectActions( $menu, $params )
  {

    // add the button action for save in the window
    // the code will be binded direct on a window object and is removed
    // on close
    // all buttons with the class save will call that action
    $code = <<<BUTTONJS

    // close tab
    self.getObject().find(".wgtac_close").click(function(){
      \$S('#{$this->id}_dropmenu-control').dropdown('remove');
      self.close();
    });
    
    self.getObject().find(".wgtac_send").click( function(){
      \$R.form( 'wgt-form-wbf-message-form',null,{success:function(){ self.close(); }} );
    });

BUTTONJS;


    $this->addJsCode( $code );

  }//end public function injectActions */

}//end class WebfrapMessage_New_Maintab_View

