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
 * @subpackage Core
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class Webfrap_Acl_Subwindow_Menu
  extends WgtDropmenu
{
////////////////////////////////////////////////////////////////////////////////
// Menu Logic
////////////////////////////////////////////////////////////////////////////////

/**
   * add a drop menu to the create window
   *
   * @param TFlowFlag $params the named parameter object that was created in
   *   the controller
   * {
   *   string formId: the id of the form;
   * }
   */
  public function build( $objid, $params )
  {

    $iconMenu        = $this->view->icon('control/menu.png'      ,'Menu');
    $iconEdit        = $this->view->icon('control/save.png'      ,'Save');
    $iconBookmark    = $this->view->icon('control/bookmark.png'  ,'Bookmark');
    $iconClose       = $this->view->icon('control/close.png'     ,'Close');

    $entries = new TArray();
    $entries->support  = $this->entriesSupport( $objid, $params );


    $this->content = <<<HTML
<ul class="wcm wcm_ui_dropmenu wgt-dropmenu" id="{$this->id}" >
  <li class="wgt-root" >
    <button class="wcm wcm_ui_button" >{$iconMenu} {$this->view->i18n->l('Menu','wbf.label')}</button>
    <ul style="margin-top:-10px;" >
      <li>
        <p class="wgtac_bookmark" >{$iconBookmark} {$this->view->i18n->l('Bookmark','wbf.label')}</p>
      </li>
{$entries->support}
      <li>
        <p class="wgtac_close" >{$iconClose} {$this->view->i18n->l('Close','wbf.label')}</p>
      </li>
    </ul>
  </li>
  <li class="wgt-root" >
    <button class="wcm wcm_ui_button wgtac_edit" >{$iconEdit} {$this->view->i18n->l('Save','wbf.label')}</button>
    <ul style="margin-top:-10px;" ></ul>
  </li>
</ul>
HTML;

  }//end public function build */

  /**
   * build the window menu
   * @param int $objid
   * @param TArray $params
   */
  protected function entriesSupport( $objid, $params )
  {

    $iconSupport  = $this->view->icon(  'control/support.png'  ,'Support');
    $iconBug      = $this->view->icon(  'control/bug.png'      ,'Bug'  );
    $iconFaq      = $this->view->icon(  'control/faq.png'      ,'Faq'  );
    $iconHelp     = $this->view->icon(  'control/help.png'     ,'Help' );


    $html = <<<HTML

  <li>
    <p>{$iconSupport} Support</p>
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
   * @param LibTemplatePublisher $view
   * @param int $objid
   * @param TArray $params
   */
  public function addMenuLogic( $view, $objid, $params  )
  {

    // add the button actions for new and search in the window
    // the code will be binded direct on a window object and is removed
    // on close
    // all buttons with the class save will call that action
    $code = <<<BUTTONJS

    self.getObject().find(".wgtac_edit").click(function()
    {
      \$R.form('{$params->formId}');
    });

    self.getObject().find(".wgtac_search").click(function()
    {
      \$R.form('{$params->searchFormId}');
    });

    self.getObject().find('#wgt-button-app-sec_group').click(function()
    {
      if(\$S('#wgt-input-wbfsys_security_access-id_group-value').val()=='')
      {
        \$D.errorWindow('Error','Please select a group first');
        return;
      }

      \$R.form('wgt-form-append_acl');
      \$S('#wgt-form-append_acl').get(0).reset();

    });

BUTTONJS;

    $view->addJsCode($code);

  }//end public function addMenuLogic */

} // end class WebFrap_Acl_Subwindow_Menu */

