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
 * @copyright webfrap.net <contact@webfrap.net>
 */
class WebfrapCoredata_Acl_Masks_Subwindow_Menu
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
<ul class="wcm wcm_ui_dropmenu wgt-dropmenu" id="{$this->id}" >
  <li class="wgt-root" >
    <button class="wcm wcm_ui_button" >{$iconMenu} {$this->view->i18n->l('Menu','wbf.label')}</button>
    <ul style="margin-top:-10px;" >
      <!--
      <li>
        <p class="wgtac_bookmark" >{$iconBookmark} {$this->view->i18n->l('Bookmark','wbf.label')}</p>
      </li>
      -->
{$entries->support}
      <li>
        <p class="wgtac_close" >{$iconClose} {$this->view->i18n->l('Close','wbf.label')}</p>
      </li>
    </ul>
  </li>
</ul>
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

BUTTONJS;

    $view->addJsCode( $code );

  }//end public function addMenuLogic */

} // end class WebfrapCoredata_Acl_Masks_Subwindow_Menu */

