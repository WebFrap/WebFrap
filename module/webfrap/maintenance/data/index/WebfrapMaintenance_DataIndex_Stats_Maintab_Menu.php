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
 * @subpackage Maintenance
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright webfrap.net <contact@webfrap.net>
 */
class WebfrapMaintenance_DataIndex_Stats_Maintab_Menu extends WgtDropmenu
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
    $acl     = $this->getAcl();
    $view   = $this->getView();

    $iconMenu      = $view->icon(  'control/menu.png',  'Menu');
    $iconRebuild   = $view->icon(  'maintenance/rebuild_index.png', 'Rebuild Index');
    $iconBookmark  = $view->icon(  'control/bookmark.png', 'Bookmark');
    $iconClose     = $view->icon(  'control/close.png', 'Close');

    $entries = new TArray();
    $entries->support  = $this->entriesSupport( $params );


    // prüfen ob der aktuelle benutzer überhaupt neue einträge anlegen darf
    if( $params->access->maintenance )
    {

      $entries->buttonInsert = <<<BUTTON
      
  <div class="wgt-panel-control" >
    <button 
      class="wcm wcm_ui_button wgtac_recreate wcm_ui_tip-top"
      title="{$view->i18n->l('Recreate the index','wbf.label')}" >{$iconRebuild} {$view->i18n->l('Recreate index','wbf.label')}</button>
  </div>

BUTTON;

    }


    $this->content = <<<HTML
    
  <div class="inline" >
    <button 
      class="wcm wcm_control_dropmenu wgt-button"
      tabindex="-1"
      id="{$this->id}-control" 
      wgt_drop_box="{$this->id}"  >{$iconMenu} {$this->view->i18n->l('Menu','wbf.label')}</button>
      <var id="{$this->id}-control-cfg-dropmenu"  >{"triggerEvent":"click"}</var>
  </div>
    
  <div class="wgt-dropdownbox" id="{$this->id}" >
    <ul>
      <li>
        <a class="wgtac_bookmark" >{$iconBookmark} {$view->i18n->l('Bookmark','wbf.label')}</a>
      </li>
    {$entries->support}
      <li>
        <a class="wgtac_close" >{$iconClose} {$this->view->i18n->l( 'Close', 'wbf.label' )}</a>
      </li>
    </ul>
  </div>

{$entries->buttonInsert}

HTML;

  }//end public function buildMenu */

  /**
   * build the window menu
   * @param TArray $params
   */
  protected function entriesSupport( $params )
  {

    $iconSupport    = $this->view->icon('control/support.png'  ,'Support');
    $iconBug        = $this->view->icon('control/bug.png'     ,'Bug');
    $iconFaq        = $this->view->icon('control/faq.png'     ,'Faq');
    $iconHelp       = $this->view->icon('control/help.png'    ,'Help');

    $html = <<<HTML
		
      <li>
        <a class="deeplink" >{$iconSupport} {$this->view->i18n->l('Support','wbf.label')}</a>
        <span>
          <ul>
            <li><a 
            	class="wcm wcm_req_ajax" 
            	href="modal.php?c=Webfrap.Docu.open&amp;key=wbfsys_message-create" >{$iconHelp} {$this->view->i18n->l('Help','wbf.label')}</a></li>
            <li><a 
            	class="wcm wcm_req_ajax" 
            	href="modal.php?c=Wbfsys.Issue.create&amp;context=create" >{$iconBug} {$this->view->i18n->l('Bug','wbf.label')}</a></li>
            <li><a 
            	class="wcm wcm_req_ajax" 
            	href="modal.php?c=Wbfsys.Faq.create&amp;context=create" >{$iconFaq} {$this->view->i18n->l('FAQ','wbf.label')}</a></li>
          </ul>
        </span>
      </li>

HTML;

    return $html;
    
  }//end public function entriesSupport */

}//end class WebfrapMaintenance_DataIndex_Stats_Maintab_Menu

