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
 * @subpackage Navigation
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class WebfrapNavigation_Maintab_Menu extends WgtDropmenu
{

  /**
   * @var array
   */
  public $crumbs = null;

  /**
   * build the window menu
   * @param TArray $params
   */
  public function buildMenu($params )
  {

    $iconMenu         = $this->view->icon( 'control/menu.png'   , 'Menu'    );
    $iconMisc         = $this->view->icon( 'control/misc.png'   , 'Misc'    );
    $iconClose        = $this->view->icon( 'control/close.png'  , 'Close'   );
    $iconEntity       = $this->view->icon( 'control/entity.png' , 'Entity'  );
    $iconSearch       = $this->view->icon( 'control/search.png' , 'Search'  );

    $iconList        = $this->view->icon( 'control/close.png'  , 'List'   );
    $iconIcons       = $this->view->icon( 'control/entity.png' , 'Icons'  );
    $iconDetails     = $this->view->icon( 'control/search.png' , 'Details'  );

    $entries = new TArray();

    $this->content = <<<HTML

  <div class="inline" >
    <button
      class="wcm wcm_control_dropmenu wgt-button"
      id="{$this->id}-control"
      wgt_drop_box="{$this->id}"  >{$iconMenu} {$this->view->i18n->l('Menu','wbf.label')}</button>
      <var id="{$this->id}-control-cfg-dropmenu"  >{"triggerEvent":"mouseover","closeOnLeave":"true"}</var>
  </div>

  <div class="wgt-dropdownbox" id="{$this->id}" >
    <ul>
      <li>
        <a class="wgtac_close" >{$iconClose} {$this->view->i18n->l( 'Close', 'wbf.label' )}</a>
      </li>
    </ul>
  </div>

  <div class="wgt-panel-control" >
    <div
      class="wcm wcm_control_buttonset wgt-button-set"
      id="wgt-mentry-my_message-boxtype" >
      <input
        type="radio"
        class="wgt-mentry-my_message-boxtype fparam-wgt-form-my_message-search"
        id="wgt-mentry-my_message-boxtype-in"
        value="in"
        name="mailbox"
        checked="checked" /><label
          for="wgt-mentry-my_message-boxtype-in"
          class="wcm wcm_ui_tip-top"
          tooltip="Show Inbox"  >{$iconList}</label>
      <input
        type="radio"
        class="wgt-mentry-my_message-boxtype fparam-wgt-form-my_message-search"
        id="wgt-mentry-my_message-boxtype-out"
        value="out"
        name="mailbox"  /><label
          for="wgt-mentry-my_message-boxtype-out"
          class="wcm wcm_ui_tip-top"
          tooltip="Show Outbox" >{$iconIcons}</label>
      <input
        type="radio"
        class="wgt-mentry-my_message-boxtype fparam-wgt-form-my_message-search"
        id="wgt-mentry-my_message-boxtype-both"
        value="both"
        name="mailbox" /><label
          for="wgt-mentry-my_message-boxtype-both"
          class="wcm wcm_ui_tip-top"
          tooltip="Show All Messages" >{$iconDetails}</label>
    </div>
  </div>

HTML;

    $this->content .= $this->crumbs;

    $this->content .= <<<HTML
<div class="right" >
  <input
    type="text"
    id="wgt-input-webfrap_navigation_search-tostring"
    name="key"
    class="large wcm wcm_ui_autocomplete wgt-ignore"  />
  <var class="wgt-settings" >
    {
      "url"  : "ajax.php?c=Webfrap.Navigation.search&amp;key=",
      "type" : "ajax"
    }
  </var>
  <button
    id="wgt-button-webfrap_navigation_search"
    class="wgt-button append"
  >
    {$iconSearch} Search
  </button>

</div>
HTML;

  }//end public function buildMenu */

  /**
   * just add the code for the edit ui controlls
   *
   * @param TFlowFlag $params the named parameter object that was created in
   *   the controller
   * {
   *   string formId: the id of the form;
   * }
   */
  public function addActions(  $params )
  {

    // add the button action for save in the window
    // the code will be binded direct on a window object and is removed
    // on close
    // all buttons with the class save will call that action
    $code = <<<BUTTONJS

    self.getObject().find(".wgtac_close").click(function(){
      self.close();
    });


BUTTONJS;

    $this->addJsCode($code);

  }//end public function addActions */

}//end class WebfrapNavigation_Maintab_Menu

