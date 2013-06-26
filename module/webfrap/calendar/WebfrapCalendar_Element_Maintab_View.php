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
class WebfrapCalendar_Element_Maintab_View extends WgtMaintab
{
/*//////////////////////////////////////////////////////////////////////////////
// Methoden
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param WebfrapCalendar_Element_Search_Request $params
   * @return void
   */
  public function displayElement($userRqt)
  {

    $this->setLabel('Callendar');
    $this->setTitle('Callendar');

    $this->setTemplate('webfrap/calendar/maintab/element', true);

    $this->addMenu($userRqt);

  }//end public function displayElement */

  /**
   * add a drop menu to the create window
   *
   * @param TFlowFlag $params the named parameter object that was created in
   *   the controller
   * {
   *   string formId: the id of the form;
   * }
   */
  public function addMenu($params)
  {

    $menu     = $this->newMenu($this->id.'_dropmenu');

    $menu->id = $this->id.'_dropmenu';

    $menu->content = <<<HTML

<div class="inline" >
  <button
    class="wcm wcm_control_dropmenu wgt-button ui-state-default"
    id="{$this->id}_dropmenu-control"
    style="text-align:left;"
    wgt_drop_box="{$this->id}_dropmenu"  ><i class="icon-reorder" ></i> Menu <i class="icon-angle-down" ></i></button>
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
  <div
    class="wcm wcm_control_buttonset wgt-button-set"
    id="wgt-mentry-groupware-data" >
    <input
      type="radio"
      id="wgt-mentry-groupware-data-mail"
      value="maintab.php?c=Webfrap.Message.messageList"
      class="{$this->id}-maskswitcher"
      name="nav-boxtype" /><label
        for="wgt-mentry-groupware-data-mail"
        class="wcm wcm_ui_tip-top"
        tooltip="Show the messages"  ><i class="icon-envelope-alt" ></i></label>
    <input
      type="radio"
      id="wgt-mentry-groupware-data-contact"
      value="maintab.php?c=Webfrap.Contact.list"
      class="{$this->id}-maskswitcher"
      name="nav-boxtype"  /><label
        for="wgt-mentry-groupware-data-contact"
        class="wcm wcm_ui_tip-top"
        tooltip="Show the contacts" ><i class="icon-user" ></i></label>
    <input
      type="radio"
      id="wgt-mentry-groupware-data-calendar"
      value="maintab.php?c=Webfrap.Calendar.element"
      class="{$this->id}-maskswitcher"
      checked="checked"
      name="nav-boxtype" /><label
        for="wgt-mentry-groupware-data-calendar"
        class="wcm wcm_ui_tip-top"
        tooltip="Show Calendar" ><i class="icon-calendar" ></i></label>
  </div>
</div>

<div
  id="{$this->id}-cruddrop"
  class="wcm wcm_control_split_button inline" style="margin-left:3px;"  >

  <button
    class="wcm wcm_ui_tip-top wgt-button wgtac_create  splitted"
    tabindex="-1"
      ><i class="icon-plus-sign" ></i> {$this->i18n->l('Create','wbf.label')}</button><button
    id="{$this->id}-cruddrop-split"
    class="wgt-button append"
    tabindex="-1"
    style="margin-left:-4px;"
    wgt_drop_box="{$this->id}-cruddropbox" ><i class="icon-angle-down" ></i></button>

</div>

<div class="wgt-dropdownbox" id="{$this->id}-cruddropbox" >

  <ul>
    <li><a
      class="wcm wgtac_search_con wcm_ui_tip-top"
      title="Search for Persons and connect with them" ><i class="icon-plus-sign" ></i> {$this->i18n->l('Search & Connect','wbf.label')}</a></li>
    <li>
  </ul>

  <var id="{$this->id}-cruddrop-cfg"  >{"triggerEvent":"click","align":"right"}</var>
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

    // add the button action for save in the window
    // the code will be binded direct on a window object and is removed
    // on close
    // all buttons with the class save will call that action
    $code = <<<BUTTONJS

    self.getObject().find(".wgtac_close").click(function() {
      self.close();
    });

    self.getObject().find(".wgtac_create").click(function() {
      \$R.get('modal.php?c=Webfrap.Contact.formNew');
    });

    self.getObject().find(".wgtac_search_con").click(function() {
      \$R.get('maintab.php?c=Webfrap.Contact.selection');
    });

    self.getObject().find(".wgtac_refresh").click(function() {
      \$R.form('wgt-form-webfrap-contact-search');
    });


    self.getObject().find('.{$this->id}-maskswitcher').change(function() {
      \$R.get(\$S(this).val());
    });


BUTTONJS;

    $this->addJsCode($code);

  }//end public function injectActions */

}//end class DaidalosBdlNodeProfile_Maintab_View

