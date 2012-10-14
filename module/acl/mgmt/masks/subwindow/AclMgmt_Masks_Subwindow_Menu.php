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
 * Read before change:
 * It's not recommended to change this file inside a Mod or App Project.
 * If you want to change it copy it to a custom project.

 *
 * @package WebFrap
 * @subpackage ModEnterprise
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright webfrap.net <contact@webfrap.net>
 */
class AclMgmt_Masks_Subwindow_Menu
  extends WgtDropmenu
{
////////////////////////////////////////////////////////////////////////////////
// Menu Logic
////////////////////////////////////////////////////////////////////////////////

/**
   * add a drop menu to the create window
   *
   * @param TFlag $params the named parameter object that was created in
   *   the controller
   * {
   *   string formId: the id of the form;
   * }
   */
  public function buildMenu( $objid, $params )
  {
  
    $view             = $this->getView();
    $user            = $this->getUser();
    $access           = $params->access;
    
    $iconMenu        = $view->icon( 'control/menu.png'      ,'Menu' );
    $iconEdit        = $view->icon( 'control/save.png'      ,'Save' );
    $iconBookmark    = $view->icon( 'control/bookmark.png'  ,'Bookmark' );
    $iconClose       = $view->icon( 'control/close.png'     ,'Close' );

    $entries = new TArray();
    $entries->support  = $this->entriesSupport( $objid, $params );


    $this->content = <<<HTML

<div class="inline" >
  <button 
    class="wcm wcm_control_dropmenu wgt-button"
    id="{$this->id}-control" 
    wgt_drop_box="{$this->id}"  >{$iconMenu} {$view->i18n->l('Menu','wbf.label')}</button>
      <var id="{$this->id}-control-cfg-dropmenu"  >{"triggerEvent":"mouseover","closeOnLeave":"true"}</var>
</div>
    
<div class="wgt-dropdownbox" id="{$this->id}" >

  <ul>
    <li>
      <a class="wgtac_bookmark" >{$iconBookmark} {$view->i18n->l('Bookmark','wbf.label')}</a>
    </li>
  </ul>
  
  <ul>
{$entries->custom}
{$entries->support}
  </ul>
  
  <ul>
    <li>
      <a class="wgtac_close" >{$iconClose} {$view->i18n->l('Close','wbf.label')}</a>
    </li>
  </ul>
  
</div>

HTML;

  }//end public function buildMenu */

  /**
   * build the window menu
   * @param int $objid
   * @param TArray $params
   */
  protected function entriesSupport( $objid, $params )
  {
  
    $view = $this->getView();

    $iconSupport  = $view->icon(  'control/support.png'  ,'Support');
    $iconBug      = $view->icon(  'control/bug.png'      ,'Bug'  );
    $iconFaq      = $view->icon(  'control/faq.png'      ,'Faq'  );
    $iconHelp     = $view->icon(  'control/help.png'     ,'Help' );


    $html = <<<HTML

  <li>
    <p>{$iconSupport} {$this->view->i18n->l('Support','wbf.label')}</p>
    <ul>
      <li><a class="wcm wcm_req_ajax" href="modal.php?c=Wbfsys.SecurityArea_Maintenance.help&amp;context=edit" >{$iconHelp} Help</a></li>
      <li><a class="wcm wcm_req_ajax" href="modal.php?c=Wbfsys.Issue.create&amp;context=edit" >{$iconBug} Bug</a></li>
      <li><a class="wcm wcm_req_ajax" href="modal.php?c=Wbfsys.Faq.create&amp;context=edit" >{$iconFaq} Faq</a></li>
    </ul>
  </li>

HTML;

    return $html;

  }//end public function entriesSupport */

  /**
   * @param LibTemplatePresenter $view
   * @param int $objid
   * @param TArray $params
   */
  public function addMenuLogic( $view, $objid, $params  )
  {

    // add the button actions for new and search in the window
    // the code will be binded direct on a window object and is removed
    // on window Close
    // all buttons with the class save will call that action
    $code = <<<BUTTONJS

    self.getObject().find(".wgtac_close").click(function()
    {
      self.getObject().close();
    });

    self.getObject().find(".wgtac_mask_employee_active").click(function()
    {
      self.close( );
      \$R.get( 'maintab.php?c=Employee.Active_Acl.listing' );
    });

    self.getObject().find(".wgtac_mask_employee_archive").click(function()
    {
      self.close( );
      \$R.get( 'maintab.php?c=Employee.Archive_Acl.listing' );
    });

    self.getObject().find(".wgtac_mask_employee_highpotential").click(function()
    {
      self.close( );
      \$R.get( 'maintab.php?c=Employee.Highpotential_Acl.listing' );
    });

    self.getObject().find(".wgtac_mask_employee_management").click(function()
    {
      self.close( );
      \$R.get( 'maintab.php?c=Employee.Management_Acl.listing' );
    });

    self.getObject().find(".wgtac_mask_employee_planned").click(function()
    {
      self.close( );
      \$R.get( 'maintab.php?c=Employee.Planned_Acl.listing' );
    });

    self.getObject().find(".wgtac_mask_my_employee_data").click(function()
    {
      self.close( );
      \$R.get( 'maintab.php?c=My.EmployeeData_Acl.listing' );
    });

BUTTONJS;

    $view->addJsCode( $code );

  }//end public function addMenuLogic */

} // end class AclMgmt_Masks_Subwindow_Menu */

