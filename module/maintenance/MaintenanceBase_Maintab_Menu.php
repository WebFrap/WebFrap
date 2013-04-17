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
 * @subpackage ModEnterprise
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class MaintenanceBase_Maintab_Menu extends WgtDropmenu
{

  /**
   * @var array
   */
  public $crumbs = null;

  /**
   * build the window menu
   * @param TArray $params
   */
  public function buildMenu($params)
  {

    $iconMenu         = $this->view->icon('control/menu.png'   , 'Menu'    );
    $iconMisc         = $this->view->icon('control/misc.png'   , 'Misc'    );
    $iconClose        = $this->view->icon('control/close.png'  , 'Close'   );
    $iconEntity       = $this->view->icon('control/entity.png' , 'Entity'  );
    $iconSearch       = $this->view->icon('control/search.png' , 'Search'  );

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
        <a class="wgtac_close" >{$iconClose} {$this->view->i18n->l('Close', 'wbf.label')}</a>
      </li>
    </ul>
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
  public function addActions( $params)
  {

    // add the button action for save in the window
    // the code will be binded direct on a window object and is removed
    // on close
    // all buttons with the class save will call that action
    $code = <<<BUTTONJS

    self.getObject().find(".wgtac_close").click(function() {
      self.close();
    });


BUTTONJS;

    $this->addJsCode($code);

  }//end public function addActions */

}//end class WebfrapNavigation_Maintab_Menu

