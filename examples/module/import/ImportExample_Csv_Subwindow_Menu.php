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
class ImportExample_Csv_Subwindow_Menu
  extends WgtDropmenu
{
////////////////////////////////////////////////////////////////////////////////
// menu: edit
////////////////////////////////////////////////////////////////////////////////

  /**
   * add a drop menu to the create window
   *
   * @param int $objid
   * @param TFlag $params the named parameter object that was created in
   *   the controller
   * {
   *   string formId: the id of the form;
   * }
   */
  public function buildMenu( $objid, $params )
  {

    $iconMenu        = $this->view->icon('control/menu.png'      ,'Menu');
    $iconEdit        = $this->view->icon('control/save.png'      ,'Save');
    $iconClose       = $this->view->icon('control/close.png'     ,'Close');


    $entries = new TArray();
    $entries->maintenance   = $this->entriesMaintenance( $objid, $params );


    $this->content = <<<HTML
<ul class="wcm wcm_ui_dropmenu wgt-dropmenu" id="{$this->id}" >
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

  }//end public function buildMenu */

  /**
   * build the window menu
   * @param TArray $params
   */
  protected function entriesSupport( $objid, $params )
  {

    $iconSupport  = $this->view->icon('control/support.png'  ,'Support');
    $iconBug      = $this->view->icon('control/bug.png'      ,'Bug');
    $iconFaq      = $this->view->icon('control/faq.png'      ,'Faq');
    $iconHelp     = $this->view->icon('control/help.png'     ,'Help');



    $html = <<<HTML

      <li>
        <p>{$iconSupport} Support</p>
        <ul>
          <li><a class="wcm wcm_req_ajax" href="modal.php?c=Project.Constraint_Maintenance.help&amp;context=edit" >{$iconHelp} Help</a></li>
          <li><a class="wcm wcm_req_ajax" href="modal.php?c=Wbfsys.Issue.create&amp;context=edit" >{$iconBug} Bug</a></li>
          <li><a class="wcm wcm_req_ajax" href="modal.php?c=Wbfsys.Faq.create&amp;context=edit" >{$iconFaq} Faq</a></li>
        </ul>
      </li>

HTML;

    return $html;
  }//end public function entriesSupport */





}//end class ProcessBase_Subwindow_Menu

