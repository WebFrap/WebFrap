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
class WebfrapAnnouncement_Table_Maintab_Menu extends WgtDropmenu
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
  public function buildMenu($params )
  {
  
    // benötigte resourcen laden
    $acl   = $this->getAcl();
    $view   = $this->getView();

    $iconMenu        = $this->view->icon('control/menu.png'      ,'Menu');
    $iconMisc        = $this->view->icon('control/misc.png'      ,'Misc');
    $iconClose       = $this->view->icon('control/close.png'      ,'Close');
    $iconEntity      = $this->view->icon('control/entity.png'      ,'Entity');
    $iconBookmark    = $this->view->icon('control/bookmark.png'      ,'Bookmark');
    $iconAdd         = $this->view->icon('control/add.png'      ,'Create');

    $iconSupport   = $this->view->icon( 'control/support.png'  ,'Support' );
    $iconBug       = $this->view->icon( 'control/bug.png'      ,'Bug' );
    $iconFaq       = $this->view->icon( 'control/faq.png'      ,'Faq' );
    $iconHelp      = $this->view->icon( 'control/help.png'     ,'Help' );

    $entries = new TArray();



    // prüfen ob der aktuelle benutzer überhaupt neue einträge anlegen darf
    if ($params->access->insert )
    {
    
      $entries->buttonInsert = <<<BUTTON
      
<div class="wgt-panel-control" >
  <button class="wcm wcm_ui_button wgtac_new" >{$iconAdd} {$this->view->i18n->l('New','wbf.label')}</button>
</div>

BUTTON;

    }


    $this->content = <<<HTML
    
<div class="inline" >
  <button 
    class="wcm wcm_control_dropmenu wgt-button"
    id="{$this->id}-control" 
    wgt_drop_box="{$this->id}_dropmenu"  >{$iconMenu} {$this->view->i18n->l('Menu','wbf.label')}</button>
  <var id="{$this->id}-control-cfg-dropmenu"  >{"triggerEvent":"mouseover","closeOnLeave":"true","align":"right"}</var>
</div>
    
<div class="wgt-dropdownbox" id="{$this->id}_dropmenu" >
  <ul>
    <li>
      <a class="wgtac_bookmark" >{$iconBookmark} {$this->view->i18n->l('Bookmark', 'wbf.label')}</a>
    </li>
  </ul>
  <ul>
    <li>
      <a class="deeplink" >{$iconSupport} {$this->view->i18n->l('Support', 'wbf.label')}</a>
      <span>
      <ul>
        <li><a class="wcm wcm_req_ajax" href="modal.php?c=Wbfsys.Issue.create&amp;context=menu" >{$iconBug} {$this->view->i18n->l('Bug', 'wbf.label')}</a></li>
        <li><a class="wcm wcm_req_ajax" href="modal.php?c=Wbfsys.Faq.create&amp;context=menu" >{$iconFaq} {$this->view->i18n->l('Faq', 'wbf.label')}</a></li>
      </ul>
      </span>
    </li>
    <li>
      <a class="wgtac_close" >{$iconClose} {$this->view->i18n->l('Close','wbf.label')}</a>
    </li>
  </ul>
</div>

{$entries->buttonInsert}

HTML;

  }//end public function buildMenu */



}//end class WbfsysAnnouncement_Table_Maintab_Menu

