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
class WebfrapMessage_Show_Maintab_View extends WgtMaintab
{
/*//////////////////////////////////////////////////////////////////////////////
// Methoden
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param TFlag $params
   * @return void
   */
  public function displayShow( $params)
  {

    $message = $this->model->getMessageNode();

    $this->setLabel('Message: '.$message->title);
    $this->setTitle('Message: '.$message->title);

    $this->addVar('msgNode', $message);
    $this->addVar('refs', $this->model->loadMessageReferences($message->msg_id));
    $this->addVar('attachments', $this->model->loadMessageAttachments($message->msg_id));
    $this->addVar('checklist', $this->model->loadMessageChecklist($message->msg_id));
    $this->setTemplate('webfrap/message/maintab/show_page', true);

    $this->addMenu($params,$message);

  }//end public function displayShow */

  /**
   * add a drop menu to the create window
   *
   * @param TFlowFlag $params the named parameter object that was created in
   *   the controller
   * {
   *   string formId: the id of the form;
   * }
   */
  public function addMenu($params,$message)
  {

    $menu     = $this->newMenu($this->id.'_dropmenu');

    $menu->id = $this->id.'_dropmenu';

    $menu->content = <<<HTML

<div class="inline" >
  <button
    class="wcm wcm_control_dropmenu wgt-button"
    id="{$this->id}_dropmenu-control"
    wgt_drop_box="{$this->id}_dropmenu"  ><i class="icon-reorder" ></i> {$this->i18n->l('Menu','wbf.label')}</button>
</div>

<div class="wgt-dropdownbox" id="{$this->id}_dropmenu" >
  <ul>
    <li>
      <a class="wgtac_bookmark" ><i class="icon-bookmark" ></i> {$this->i18n->l('Bookmark', 'wbf.label')}</a>
    </li>
  </ul>
  <ul>
    <li>
      <a class="deeplink" ><i class="icon-info-sign" ></i> {$this->i18n->l('Support', 'wbf.label')}</a>
      <span>
      <ul>
        <li><a
        	class="wcm wcm_req_ajax"
        	href="modal.php?c=Wbfsys.Faq.create&amp;context=menu" ><i class="icon-question-sign" ></i> {$this->i18n->l('Faq', 'wbf.label')}</a></li>
      </ul>
      </span>
    </li>
    <li>
      <a class="wgtac_close" ><i class="icon-remove-circle" ></i> {$this->i18n->l('Close','wbf.label')}</a>
    </li>
  </ul>
</div>

<div class="wgt-panel-control" >
  <button
  	class="wgt-button wgtac_forward" ><i class="icon-share-alt" ></i> {$this->i18n->l('Forward','wbf.label')}</button>
</div>

<div class="wgt-panel-control" >
  <button
  	class="wgt-button wgtac_reply" ><i class="icon-reply" ></i> {$this->i18n->l('Reply','wbf.label')}</button>
</div>

<div class="wgt-panel-control" >
  <button
  	class="wgt-button wgtac_save save_first"
  	id="wgt-btn-show-msg-save-{$message->msg_id}" ><i class="icon-save" ></i> {$this->i18n->l('Save','wbf.label')}</button>
</div>

HTML;

    $this->injectActions($menu, $params);

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
  public function injectActions($menu, $params)
  {

    $message = $this->model->getMessageNode();

    // add the button action for save in the window
    // the code will be binded direct on a window object and is removed
    // on close
    // all buttons with the class save will call that action
    $code = <<<BUTTONJS

    // close tab
    self.getObject().find(".wgtac_close").click(function() {
      \$S('#{$this->id}_dropmenu-control').dropdown('remove');
      self.close();
    });

    self.getObject().find(".wgtac_forward").click(function() {
      \$R.get('maintab.php?c=Webfrap.Message.formForward&objid={$message->msg_id}',{success:function() { self.close(); }});
    });

    self.getObject().find(".wgtac_reply").click(function() {
      \$R.get('maintab.php?c=Webfrap.Message.formReply&objid={$message->msg_id}',{success:function() { self.close(); }});
    });

   self.getObject().find(".wgtac_save").click(function() {
      \$R.form('wgt-form-msg-show-save-{$message->msg_id}');
   });

BUTTONJS;

    $this->addJsCode($code);

  }//end public function injectActions */

}//end class WebfrapMessage_Show_Maintab_View

