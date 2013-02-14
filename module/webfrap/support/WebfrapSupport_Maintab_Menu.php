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
class WebfrapNavigation_Maintab_Menu extends WgtDropmenu
{

  /**
   * 
   * Enter description here ...
   * @var unknown_type
   */
  public $crumbs = null;

  /**
   * build the window menu
   * @param TArray $params
   */
  public function buildMenu( $params )
  {

    $iconMenu         = $this->view->icon( 'control/menu.png'   , 'Menu'    );
    $iconMisc         = $this->view->icon( 'control/misc.png'   , 'Misc'    );
    $iconClose        = $this->view->icon( 'control/close.png'  , 'Close'   );
    $iconEntity       = $this->view->icon( 'control/entity.png' , 'Entity'  );
    $iconSearch       = $this->view->icon( 'control/search.png' , 'Search'  );

    $entries = new TArray();

    $this->content = <<<HTML
<ul class="wcm wcm_ui_dropmenu wgt-dropmenu" id="{$this->id}" style="z-index:500;height:16px;"  >
  <li class="wgt-root" >
    <button class="wcm wcm_ui_button" >{$iconMenu} {$this->view->i18n->l('Menu','wbf.label')}</button>
    <ul style="margin-top:-10px;" >
{$entries->support}
      <li>
        <p class="wgtac_close" >{$iconClose} {$this->view->i18n->l('Close','wbf.label')}</p>
      </li>
    </ul>
  </li>
</ul>
HTML;

    $this->content .= $this->crumbs;
        
    $this->content .= <<<HTML
<div class="right" >
  <input
    type="text"
    id="wgt-input-webfrap_navigation_search-tostring"
    name="key"
    class="xlarge wcm wcm_ui_autocomplete wgt-ignore"  />
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

