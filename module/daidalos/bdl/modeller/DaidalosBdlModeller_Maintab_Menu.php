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
 * @subpackage Daidalos
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class DaidalosBdlModeller_Maintab_Menu extends WgtDropmenu
{
/*//////////////////////////////////////////////////////////////////////////////
// Methoden
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * add a drop menu to the create window
   *
   * @param TFlowFlag $params the named parameter object that was created in
   *   the controller
   * {
   *   string formId: the id of the form;
   * }
   */
  public function buildMenu( $params)
  {

    $iconMenu          = $this->view->icon('control/menu.png'     ,'Menu'   );
    $iconClose         = $this->view->icon('control/close.png'    ,'Close'   );
    $iconSearch        = $this->view->icon('control/search.png'   ,'Search'  );
    $iconBookmark      = $this->view->icon('control/bookmark.png' ,'Bookmark');

    $iconAdd        = $this->view->icon('control/add.png' ,'Add');
    $iconSync        = $this->view->icon('daidalos/sync.png' ,'Sync');

    $entries = new TArray();
    $entries->support  = $this->entriesSupport($params);

    $this->content = <<<HTML
<ul class="wcm wcm_ui_dropmenu wgt-dropmenu" id="{$this->id}"  >
  <li class="wgt-root" >
    <button class="wgt-button" >{$iconMenu} {$this->view->i18n->l('Menu','wbf.label')}</button>
    <ul style="margin-top:-10px;" >
      <li>
        <p>{$iconAdd} Add</p>
        <ul>
          <li><a class="wcm wcm_req_ajax" href="maintab.php?c=Daidalos.Bdl_Repo.create" >{$iconAdd} New Repo</a></li>
          <li><a class="wcm wcm_req_ajax" href="maintab.php?c=Daidalos.Bdl_Project.create" >{$iconAdd} New Project</a></li>
        </ul>
      </li>
      <li>
        <p>{$iconSync} Sync</p>
        <ul>
          <li><a class="wcm wcm_req_put" href="ajax.php?c=Daidalos.BdlIndex.sync" >{$iconSync} Sync Index</a></li>
          <li><a class="wcm wcm_req_put" href="ajax.php?c=Daidalos.BdlDocu.sync" >{$iconSync} Sync Docu</a></li>
        </ul>
      </li>
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
   * @param TFlag $params
   */
  protected function entriesSupport($params)
  {

    $iconSupport = $this->view->icon('control/support.png'  ,'Support');
    $iconBug     = $this->view->icon('control/bug.png'      ,'Bug');
    $iconFaq     = $this->view->icon('control/faq.png'      ,'Faq');
    $iconHelp    = $this->view->icon('control/help.png'     ,'Help');

    $html = <<<HTML

      <li>
        <p>{$iconSupport} Support</p>
        <ul>
          <li><a class="wcm wcm_req_ajax" href="modal.php?c=Wbfsys.Issue.create&amp;context=menu" >{$iconBug} Bug</a></li>
          <li><a class="wcm wcm_req_ajax" href="modal.php?c=Wbfsys.Faq.create&amp;context=menu" >{$iconFaq} Faq</a></li>
        </ul>
      </li>

HTML;

    return $html;

  }//end public function entriesSupport */

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
  public function injectActions($view, $params)
  {

    // add the button action for save in the window
    // the code will be binded direct on a window object and is removed
    // on close
    // all buttons with the class save will call that action
    $code = <<<BUTTONJS

    self.getObject().find(".wgtac_close").click(function() {
      self.close();
    });

    self.getObject().find(".wgtac_sync_index").click(function() {
      \$R.put('ajax.php?c=Daidalos.BdlIndex.sync');
    });

BUTTONJS;

    $view->addJsCode($code);

  }//end public function injectActions */

}//end class DaidalosBdlModeller_Maintab_Menu

