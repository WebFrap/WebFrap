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
class DaidalosDb_Maintab_Menu
  extends WgtDropmenu
{
////////////////////////////////////////////////////////////////////////////////
// Methoden
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
  public function buildMenu( $params )
  {
    
    $view = $this->view;

    $iconMenu          = $view->icon( 'control/menu.png'     ,'Menu'   );
    $iconClose         = $view->icon( 'control/close.png'    ,'Close'   );
    $iconSearch        = $view->icon( 'control/search.png'   ,'Search'  );
    $iconBookmark      = $view->icon( 'control/bookmark.png' ,'Bookmark');
    $iconQuery         = $view->icon( 'daidalos/query.png' ,'Query' );
    $iconSupport = $view->icon( 'control/support.png'  ,'Support' );
    $iconBug     = $view->icon( 'control/bug.png'      ,'Bug' );
    $iconFaq     = $view->icon( 'control/faq.png'      ,'Faq' );

    $entries = new TArray();
    //$entries->support  = $this->entriesSupport( $params );

    $this->content = <<<HTML
    
<div class="inline" >
  <button 
    class="wcm wcm_control_dropmenu wgt-button"
    id="{$this->id}-control" 
    wgt_drop_box="{$this->id}_dropmenu"  >{$iconMenu} {$view->i18n->l('Menu','wbf.label')}</button>
</div>
    
<div class="wgt-dropdownbox" id="{$this->id}_dropmenu" >
  <ul>
    <li>
      <a class="wgtac_bookmark" >{$iconBookmark} {$view->i18n->l('Bookmark', 'wbf.label')}</a>
    </li>
  </ul>
  <ul>
    <li>
      <a class="deeplink" >{$iconSupport} {$view->i18n->l('Support', 'wbf.label')}</a>
      <span>
      <ul>
        <li><a class="wcm wcm_req_ajax" href="modal.php?c=Wbfsys.Issue.create&amp;context=menu" >{$iconBug} {$view->i18n->l('Bug', 'wbf.label')}</a></li>
        <li><a class="wcm wcm_req_ajax" href="modal.php?c=Wbfsys.Faq.create&amp;context=menu" >{$iconFaq} {$view->i18n->l('Faq', 'wbf.label')}</a></li>
      </ul>
      </span>
    </li>
    <li>
      <a class="wgtac_close" >{$iconClose} {$view->i18n->l('Close','wbf.label')}</a>
    </li>
  </ul>
</div>

<div class="wgt-panel-control" >
  <button class="wgt-button wgtac_query" >{$iconQuery} {$view->i18n->l('Query','wbf.label')}</button>
</div>

HTML;


  }//end public function buildMenu */


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
  public function injectActions( $view,  $params )
  {


    // add the button action for save in the window
    // the code will be binded direct on a window object and is removed
    // on close
    // all buttons with the class save will call that action
    $code = <<<BUTTONJS

    self.getObject().find(".wgtac_close").click(function(){
      self.close();
    });
    
    self.getObject().find(".wgtac_query").click(function(){
      \$R.get( 'maintab.php?c=Daidalos.Db.query' );
    });

BUTTONJS;


    $view->addJsCode( $code );

  }//end public function injectActions */

}//end class DaidalosDb_Maintab_Menu

