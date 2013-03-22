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
class ExampleTech_Maintab_View extends WgtMaintabCustom
{
/*//////////////////////////////////////////////////////////////////////////////
// Methoden
//////////////////////////////////////////////////////////////////////////////*/

  public $crumbs = '';

  /**
   * @param string $menuName
   * @return void
   */
  public function displayTree()
  {

    $this->setTemplate('example/tech/tree', true  );

    $this->setTitle('Tech Examples');
    $this->setLabel('Tech Examples');

    $this->addMenu();
    $this->addActions();

  }//end public function displayTree */

  /**
   * add a drop menu to the create window
   *
   * @param TFlag $params the named parameter object that was created in
   *   the controller
   * {
   *   string formId: the id of the form;
   * }
   */
  public function addMenu()
  {

    // benötigte resourcen laden
    $acl    = $this->getAcl();
    $user   = $this->getUser();

    $iconMisc         = $this->icon('control/misc.png'      ,'Misc');
    $iconClose         = $this->icon('control/close.png'      ,'Close');
    $iconEntity         = $this->icon('control/entity.png'      ,'Entity');
    $iconSearch         = $this->icon('control/search.png'      ,'Search');
    $iconRefresh         = $this->icon('control/refresh.png'      ,'Refresh');

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
      wgt_drop_box="{$menu->id}"  ><i class="icon-reorder" ></i> {$this->i18n->l('Menu','wbf.label')} <i class="icon-angle-down" ></i></button>
      <var id="{$menu->id}-control-cfg-dropmenu"  >{"triggerEvent":"click"}</var>
  </div>

  <div class="wgt-dropdownbox" id="{$menu->id}" >

    <ul>
{$entries->support}
    </ul>
    <ul>
      <li>
        <a class="wgtac_close" ><i class="icon-remove-circle" ></i> {$this->i18n->l('Close', 'wbf.label')}</a>
      </li>
    </ul>

  </div>

<div class="wgt-panel-control" >
  <button
    class="wgt-button"
    onclick="\$R.get('maintab.php?c=Example.Tech.tree');" >{$iconRefresh} {$this->i18n->l('Refresh','wbf.label')}</button>
</div>

HTML;


  }//end public function addMenu */



  /**
   * build the window menu
   * @param TArray $params
   */
  protected function entriesSupport($menu)
  {

    $iconSupport    = $this->icon('control/support.png' ,'Support');
    $iconBug        = $this->icon('control/bug.png'     ,'Bug');
    $iconFaq        = $this->icon('control/faq.png'     ,'Faq');
    $iconHelp       = $this->icon('control/help.png'    ,'Help');

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
  public function addActions()
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

    $this->addJsCode($code);

  }//end public function addActions */

}//end class WebfrapNavigation_Maintab

