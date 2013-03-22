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
 * @subpackage ModSync
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class DaidalosProjects_Maintab_Menu extends WgtDropmenu
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
  public function buildMenu($params)
  {

    $iconMenu          = $this->view->icon('control/menu.png'     ,'Menu'   );
    $iconClose         = $this->view->icon('control/close.png'    ,'Close'   );
    $iconSearch        = $this->view->icon('control/search.png'   ,'Search'  );
    $iconBookmark      = $this->view->icon('control/bookmark.png' ,'Bookmark');

    $entries = new TArray();
    $entries->support  = $this->entriesSupport($params);

    $this->content = <<<HTML
<ul class="wgt-dropmenu" id="{$this->id}" style="z-index:500;height:16px;"  >
  <li class="wgt-root" >
    <button class="wgt-button" >{$iconMenu} {$this->view->i18n->l('Menu','wbf.label')}</button>
    <ul style="margin-top:-10px;" >
      <li>
        <p class="wgtac_bookmark" >{$iconBookmark} {$this->view->i18n->l('Bookmark','wbf.label')}</p>
      </li>
{$entries->support}
{$entries->report}
      <li>
        <p class="wgtac_close" >{$iconClose} {$this->view->i18n->l('Close','wbf.label')}</p>
      </li>
    </ul>
  </li>
  <li class="wgt-root" >
    <button class="wgt-button wgtac_search" >{$iconSearch} {$this->view->i18n->l('Search','wbf.label')}</button>
    <ul style="margin-top:-10px;" ></ul>
  </li>
</ul>
HTML;

  }//end public function buildMenu */



  /**
   * build the window menu
   * @param TArray $params
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

}//end class DaidalosProjects_Maintab_Menu

