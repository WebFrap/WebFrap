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
      id="wgt-mentry-navigation-boxtype" >
      <input
        type="radio"
        class="wgt-mentry-navigationtype fparam-wgt-form-navigation-search"
        id="wgt-mentry-navigationtype-box"
        value="box"
        name="nav-boxtype"
        checked="checked" /><label
          for="wgt-mentry-navigationtype-box"
          class="wcm wcm_ui_tip-top"
          tooltip="Show boxes"  ><i class="icon-th" ></i></label>
      <input
        type="radio"
        class="wgt-mentry-navigation-boxtype fparam-wgt-form-navigation-search"
        id="wgt-mentry-navigationtype-tile"
        value="tile"
        name="nav-boxtype"  /><label
          for="wgt-mentry-navigationtype-tile"
          class="wcm wcm_ui_tip-top"
          tooltip="Show tiles" ><i class="icon-th-list" ></i></label>
      <input
        type="radio"
        class="wgt-mentry-navigation-boxtype fparam-wgt-form-navigation-search"
        id="wgt-mentry-navigationtype-list"
        value="list"
        name="nav-boxtype" /><label
          for="wgt-mentry-navigationtype-list"
          class="wcm wcm_ui_tip-top"
          tooltip="Show as List" ><i class="icon-list" ></i></label>
    </div>
  </div>

HTML;

    $this->content .= $this->crumbs;

    $this->content .= <<<HTML
<div class="right" >
  &nbsp;&nbsp;&nbsp;
  <button
    class="wcm wcm_ui_tip-left wgt-button wgtac_close"
    tabindex="-1"
    tooltip="Close the active tab"  ><i class="icon-remove-circle" ></i></button>
</div>
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

