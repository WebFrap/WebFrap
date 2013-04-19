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
 * @subpackage ModMy
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class MyActionLog_Table_Maintab_Menu extends WgtDropmenu
{
  /**
   * de:
   * zusammenbaue des dropmenüs für die maintab view
   *
   * @param TArray $params benamte parameter
   * {
   *   @param LibAclContainer access: der container mit den zugriffsrechten für
   *    die aktuelle maske
   * }
   */
  public function buildMenu($params)
  {

    $iconMenu         = $this->view->icon('control/menu.png'      ,'Menu');
    $iconMisc         = $this->view->icon('control/misc.png'      ,'Misc');
    $iconClose         = $this->view->icon('control/close.png'      ,'Close');
    $iconEntity         = $this->view->icon('control/entity.png'      ,'Entity');
    $iconBookmark         = $this->view->icon('control/bookmark.png'      ,'Bookmark');
    $iconAdd         = $this->view->icon('control/add.png'      ,'Create');

    $entries = new TArray();

    // prüfen ob die person zugriff auf die wartungsmenüs hat
    if ($params->access->maintenance) {
      $entries->maintenance  = $this->entriesMaintenance($params);
    }

    // um rechte vergeben zu können werde selbst administrative rechte benötigt

    $entries->support  = $this->entriesSupport($params);

    // prüfen ob der aktuelle benutzer überhaupt neue einträge anlegen darf
    if ($params->access->insert) {
      $entries->buttonInsert = <<<BUTTON
  <li class="wgt-root" >
    <button class="wcm wcm_ui_button wgtac_new" >{$iconAdd} {$this->view->i18n->l('New','wbf.label')}</button>
    <ul style="margin-top:-10px;" ></ul>
  </li>

BUTTON;
    }

    $this->content = <<<HTML
<ul class="wcm wcm_ui_dropmenu wgt-dropmenu" id="{$this->id}" >
  <li class="wgt-root" >
    <button class="wcm wcm_ui_button" >{$iconMenu} {$this->view->i18n->l('Menu','wbf.label')}</button>
    <ul style="margin-top:-10px;" >
      <li>
        <p class="wgtac_bookmark" >{$iconBookmark} {$this->view->i18n->l('Bookmark','wbf.label')}</p>
      </li>
{$entries->maintenance}
{$entries->support}
      <li>
        <p class="wgtac_close" >{$iconClose} {$this->view->i18n->l('Close','wbf.label')}</p>
      </li>
    </ul>
  </li>
{$entries->buttonInsert}
</ul>
HTML;

  }//end public function buildMenu */



  /**
   * build the window menu
   * @param TArray $params
   */
  protected function entriesMaintenance($params)
  {

    $iconMaintenance    = $this->view->icon('control/maintenance.png'      ,'Maintenance');
    $iconStats          = $this->view->icon('control/stats.png'      ,'Stats');
    $iconProtocol       = $this->view->icon('control/protocol.png'      ,'Protocol');

    $html = <<<HTML

  <li>
    <p>{$iconMaintenance} {$this->view->i18n->l('Maintenance', 'wbf.label')}</p>
    <ul>
      <li>
        <a class="wcm wcm_req_ajax" href="modal.php?c=Project.Project_Maintenance.protocolEntity" >{$iconProtocol} {$this->view->i18n->l('Protocol', 'wbf.label')}</a>
      </li>
      <li>
        <a class="wcm wcm_req_ajax" href="modal.php?c=Project.Project_Maintenance.statsEntity" >{$iconStats} {$this->view->i18n->l('Stats', 'wbf.label')}</a>
      </li>
    </ul>
  </li>

HTML;

    return $html;

  }//end public function entriesMaintenance */

  /**
   * build the window menu
   * @param TArray $params
   */
  protected function entriesSupport($params)
  {

    $iconSupport         = $this->view->icon('control/support.png'      ,'Support');
    $iconBug         = $this->view->icon('control/bug.png'      ,'Bug');
    $iconFaq         = $this->view->icon('control/faq.png'      ,'Faq');
    $iconHelp         = $this->view->icon('control/help.png'      ,'Help');
    $iconReport         = $this->view->icon('control/report.png'      ,'import');

    $html = <<<HTML

      <li>
        <p>{$iconSupport} Support</p>
        <ul>
          <li><a class="wcm wcm_req_ajax" href="modal.php?c=Wbfsys.Issue.create&amp;context=table" >{$iconBug} Bug</a></li>
          <li><a class="wcm wcm_req_ajax" href="modal.php?c=Wbfsys.Faq.create&amp;context=table" >{$iconFaq} FAQ</a></li>
        </ul>
      </li>

HTML;

    return $html;

  }//end public function entriesSupport */

}//end class ProjectProject_Table_Maintab_Menu

