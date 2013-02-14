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
class CmsMedia_Maintab_Menu extends WgtDropmenu
{
/*//////////////////////////////////////////////////////////////////////////////
// menu: create
//////////////////////////////////////////////////////////////////////////////*/
    
  /**
   * add a drop menu to the create window
   *
   * @param TFlag $params the named parameter object that was created in
   *   the controller
   * {
   *   string formId: the id of the form;
   * }
   */
  public function buildMenu( $params )
  {
  
    // benötigte resourcen laden
    $acl   = $this->getAcl();
    $view   = $this->getView();

    $iconMenu    = $view->icon('control/menu.png',  'Menu' );
    $iconExecute    = $view->icon('control/exec.png', 'Send' );
    $iconBookmark  = $view->icon('control/bookmark.png', 'Bookmark' );
    $iconClose     = $view->icon('control/close.png', 'Close' );

    $entries = new TArray();
    $entries->support  = $this->entriesSupport( $params );


    $this->content = <<<HTML
<ul class="wcm wcm_ui_dropmenu wgt-dropmenu" id="{$this->id}" >
  <li class="wgt-root" >
    <button class="wcm wcm_ui_button" >{$iconMenu} {$view->i18n->l('Menu','wbf.label')}</button>
    <ul style="margin-top:-10px;" >
      <li>
        <p class="wgtac_bookmark" >{$iconBookmark} {$view->i18n->l('Bookmark','wbf.label')}</p>
      </li>
{$entries->custom}
{$entries->support}
      <li>
        <p class="wgtac_close" >{$iconClose} {$view->i18n->l('Close','wbf.label')}</p>
      </li>
    </ul>
  </li>
{$entries->customButton}
  <li class="wgt-root" >
    <button 
      class="wcm wcm_ui_button wgtac_run_all wcm_ui_tip-top"
      title="{$view->i18n->l('Run All','wbf.label')}" >{$iconExecute} {$view->i18n->l('Run All','wbf.label')}</button>
    <ul style="margin-top:-10px;" ></ul>
  </li>

</ul>
HTML;

  }//end public function buildMenu */

  /**
   * build the window menu
   * @param TArray $params
   */
  protected function entriesSupport( $params )
  {

    $iconSupport         = $this->view->icon('control/support.png'      ,'Support');
    $iconBug         = $this->view->icon('control/bug.png'      ,'Bug');
    $iconFaq         = $this->view->icon('control/faq.png'      ,'Faq');
    $iconHelp         = $this->view->icon('control/help.png'      ,'Help');


    $html = <<<HTML

      <li>
        <p>{$iconSupport} {$this->view->i18n->l('Support','wbf.label')}</p>
        <ul>

          <li><a class="wcm wcm_req_ajax" href="modal.php?c=Webfrap.Docu.open&amp;key=wbfsys_message-create" >{$iconHelp} {$this->view->i18n->l('Help','wbf.label')}</a></li>

          <li><a class="wcm wcm_req_ajax" href="modal.php?c=Wbfsys.Issue.create&amp;context=create" >{$iconBug} {$this->view->i18n->l('Bug','wbf.label')}</a></li>

          <li><a class="wcm wcm_req_ajax" href="modal.php?c=Wbfsys.Faq.create&amp;context=create" >{$iconFaq} {$this->view->i18n->l('FAQ','wbf.label')}</a></li>

        </ul>
      </li>

HTML;

    return $html;
    
  }//end public function entriesSupport */

}//end class MaintenanceDbConsistency_Maintab_Menu

