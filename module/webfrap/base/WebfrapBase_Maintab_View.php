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
class WebfrapBase_Maintab_View extends WgtMaintab
{
/*//////////////////////////////////////////////////////////////////////////////
// Methoden
//////////////////////////////////////////////////////////////////////////////*/

  public $crumbs = '';
  
  /**
   * @param string $menuName
   * @return void
   */
  public function displayMenu($menuName, $params  )
  {


    $this->setTemplate( 'webfrap/navigation/maintab/modmenu'  );
    
    $className = 'ElementMenu'.ucfirst($params->menuType) ;

    $modMenu = $this->newItem( 'modMenu', $className );
    
    $menuData = DaoFoldermenu::get( 'webfrap/'.$menuName, true );
    $modMenu->setData
    (
      $menuData,
      'maintab.php'
    );
    $this->crumbs = $modMenu->buildCrumbs();
    
    if ($modMenu->title  )
      $this->setTitle($menuData->title );
    else 
      $this->setTitle('Webfrap Menu');
    
    if ($modMenu->label  )
      $this->setLabel($menuData->label );
    else 
      $this->setLabel( 'Webfrap Menu' );

    $params = new TArray();
    $this->addMenu($params );
    $this->addActions($params );

  }//end public function displayMenu */

  /**
   * add a drop menu to the create window
   *
   * @param TFlag $params the named parameter object that was created in
   *   the controller
   * {
   *   string formId: the id of the form;
   * }
   */
  public function addMenu($params )
  {
    
    // benötigte resourcen laden
    $acl    = $this->getAcl();
    $user   = $this->getUser();
    $access = $params->access;

    $iconMisc         = $this->icon('control/misc.png'      ,'Misc');
    $iconClose         = $this->icon('control/close.png'      ,'Close');
    $iconEntity         = $this->icon('control/entity.png'      ,'Entity');
    $iconSearch         = $this->icon('control/search.png'      ,'Search');


    $entries = new TArray();

    $menu     = $this->newMenu
    (
      $this->id.'_dropmenu'
    );
    $menu->id = $this->id.'_dropmenu';

    $menu->content = <<<HTML

  <div class="inline" >
    <button 
      class="wcm wcm_control_dropmenu wgt-button"
      id="{$menu->id}-control" 
      wgt_drop_box="{$menu->id}"  ><div class="left" >{$this->i18n->l('Menu','wbf.label')}</div><div class="right" ><span class="ui-icon ui-icon-triangle-1-s right"  > </span></div></button>
      <var id="{$menu->id}-control-cfg-dropmenu"  >{"triggerEvent":"click"}</var>
  </div>
    
  <div class="wgt-dropdownbox" id="{$menu->id}" >

    <ul>
{$entries->support}
    </ul>
    <ul>
      <li>
        <a class="wgtac_close" >{$iconClose} {$this->i18n->l( 'Close', 'wbf.label' )}</a>
      </li>
    </ul>

  </div>

HTML;

    $menu->content .= $this->crumbs;

    $menu->content .= <<<HTML

<div class="right" >
  <input
    type="text"
    id="wgt-input-webfrap_navigation_search-tostring"
    name="key"
    class="large wcm wcm_ui_autocomplete wgt-ignore"  />
  <var class="wgt-settings" >{
      "url"  : "ajax.php?c=Webfrap.Navigation.search&amp;key=",
      "type" : "ajax"
    }</var>
  <button
    id="wgt-button-webfrap_navigation_search"
    tabindex="-1"
    class="wgt-button append" >
    {$iconSearch}
  </button>
  
</div>

HTML;

  }//end public function addMenu */



  /**
   * build the window menu
   * @param TArray $params
   */
  protected function entriesSupport($menu )
  {

    $iconSupport    = $this->icon( 'control/support.png' ,'Support' );
    $iconBug        = $this->icon( 'control/bug.png'     ,'Bug' );
    $iconFaq        = $this->icon( 'control/faq.png'     ,'Faq' );
    $iconHelp       = $this->icon( 'control/help.png'    ,'Help' );

    $html = <<<HTML
    
      <li>
        <a class="deeplink" >{$iconSupport} {$this->i18n->l('Support','wbf.label')}</a>
        <span>
          <ul>
            <li><a 
              class="wcm wcm_req_ajax" 
              href="modal.php?c=Webfrap.Docu.open&amp;key=wbfsys_message-create" >{$iconHelp} {$this->i18n->l('Help','wbf.label')}</a></li>
            <li><a 
              class="wcm wcm_req_ajax" 
              href="modal.php?c=Wbfsys.Issue.create&amp;context=create" >{$iconBug} {$this->i18n->l('Bug','wbf.label')}</a></li>
            <li><a 
              class="wcm wcm_req_ajax" 
              href="modal.php?c=Wbfsys.Faq.create&amp;context=create" >{$iconFaq} {$this->i18n->l('FAQ','wbf.label')}</a></li>
          </ul>
        </span>
      </li>

HTML;

    return $html;
    
  }//end public function entriesSupport */
  

  /**
   * this method is for adding the buttons in a create window
   * per default there is only one button added: save with the action
   * to save the window onclick
   *
   * @param TFlag $params the named parameter object that was created in
   *   the controller
   * {
   *   string formId: the id of the form;
   * }
   */
  public function addActions(  )
  {

    // add the button actions for create in the window
    // the code will be binded direct on a window object and is removed
    // on close
    // all buttons with the class save will call that action
    $code = <<<BUTTONJS

// close tab
self.getObject().find(".wgtac_close").click(function(){
  self.close();
});

BUTTONJS;

    $this->addJsCode($code );

  }//end public function addActions */
  

}//end class WebfrapNavigation_Maintab

