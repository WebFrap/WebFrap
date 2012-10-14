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
 *
 * @package WebFrap
 * @subpackage Core
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright webfrap.net <contact@webfrap.net>
 */
class MyMessage_Crud_Show_Maintab_Menu
  extends WgtDropmenu
{

////////////////////////////////////////////////////////////////////////////////
// menu: edit
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
  
    // benötigte resourcen laden
    $acl   = $this->getAcl();
    $view  = $this->getView();
  
    $iconMenu        = $view->icon( 'control/menu.png', 'Menu' );
    
    $iconRespond     = $view->icon( 'message/mail_respond.png', 'Respond' );
    $iconForward     = $view->icon( 'message/mail_forward.png', 'Forward' );
    $iconArchive     = $view->icon( 'message/mail_archive.png', 'Archive' );
    $iconSpam        = $view->icon( 'message/spam.png', 'Spam' );
    $iconHam         = $view->icon( 'message/ham.png', 'Ham' );

    
    $iconClose       = $view->icon( 'control/close.png', 'Close' );
    $iconMgmt      = $view->icon( 'relation/management.png', 'Management' );
    $iconEntity    = $view->icon( 'relation/entity.png', 'Entity' );


    $entries = new TArray();
    $entries->support  = $this->entriesSupport( $objid, $params );


    // prüfen ob der aktuelle benutzer überhaupt neue einträge anlegen darf
    if( $params->access->update )
    {

      $entries->buttonUpdate = <<<BUTTON
  <!-- 
  <li class="wgt-root" >
    <button
      class="wcm wcm_ui_button wgtac_edit wcm_ui_tip-top"
      title="Respond to the Message" >{$iconRespond} {$view->i18n->l('Respond','wbf.label')}</button>
    <ul style="margin-top:-10px;" ></ul>
  </li>
  <li class="wgt-root" >
    <button
      class="wcm wcm_ui_button wgtac_edit wcm_ui_tip-top"
      title="Forward this message" >{$iconForward} {$view->i18n->l('Forward','wbf.label')}</button>
    <ul style="margin-top:-10px;" ></ul>
  </li>
  -->
  <li class="wgt-root" >
    &nbsp;&nbsp;&nbsp;
  </li>
  
  <li class="wgt-root" >
    <button
      class="wcm wcm_ui_button wgtac_archive wcm_ui_tip-top"
      title="Archive this mail" >{$iconArchive} {$view->i18n->l('Archive','wbf.label')}</button>
    <ul style="margin-top:-10px;" ></ul>
  </li>
  
  <!--
  <li class="wgt-root" >
    &nbsp;&nbsp;&nbsp;
  </li>
  
  <li class="wgt-root" >
    <button
      class="wcm wcm_ui_button wgtac_edit wcm_ui_tip-top"
      title="Mark as Spam" >{$iconSpam} {$view->i18n->l('Spam','wbf.label')}</button>
    <ul style="margin-top:-10px;" ></ul>
  </li>
  
  <li class="wgt-root" >
    <button
      class="wcm wcm_ui_button wgtac_edit wcm_ui_tip-top"
      title="Mark as Ham" >{$iconHam} {$view->i18n->l('Ham','wbf.label')}</button>
    <ul style="margin-top:-10px;" ></ul>
  </li>
  -->

BUTTON;

    }

    $this->content = <<<HTML
<ul class="wcm wcm_ui_dropmenu wgt-dropmenu" id="{$this->id}" >
  <li class="wgt-root" >
    <button class=" wcm wcm_ui_button" >{$iconMenu} {$view->i18n->l('Menu', 'wbf.label')}</button>
    <ul style="margin-top:-10px;" >
{$entries->customStart}
{$entries->customEnd}
{$entries->support}
      <li>
        <p class="wgtac_close" >{$iconClose} {$view->i18n->l('Close', 'wbf.label')}</p>
      </li>
    </ul>
  </li>
{$entries->buttonUpdate}

{$entries->customButton}
</ul>

HTML;

  }//end public function buildMenu */

  /**
   * build the window menu
   * @param TArray $params
   */
  protected function entriesSupport( $objid, $params )
  {

    $iconSupport   = $this->view->icon('control/support.png'  ,'Support');
    $iconBug       = $this->view->icon('control/bug.png'      ,'Bug');
    $iconFaq       = $this->view->icon('control/faq.png'      ,'Faq');
    $iconHelp      = $this->view->icon('control/help.png'     ,'Help');

    $html = <<<HTML

      <li>
        <p>{$iconSupport} {$this->view->i18n->l('Support','wbf.label')}</p>
        <ul>
          <li><a class="wcm wcm_req_ajax" href="modal.php?c=Webfrap.Docu.open&amp;key=wbfsys_message-edit" >{$iconHelp} {$this->view->i18n->l('Help','wbf.label')}</a></li>
          <li><a class="wcm wcm_req_ajax" href="modal.php?c=Wbfsys.Issue.create&amp;context=edit" >{$iconBug} {$this->view->i18n->l('Bug','wbf.label')}</a></li>
          <li><a class="wcm wcm_req_ajax" href="modal.php?c=Wbfsys.Faq.create&amp;context=edit" >{$iconFaq} {$this->view->i18n->l('FAQ','wbf.label')}</a></li>
        </ul>
      </li>

HTML;

    return $html;
  }//end public function entriesSupport */

 


}//end class WbfsysMessage_Crud_Edit_Maintab_Menu

