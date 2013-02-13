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
class DaidalosSupportUser_Maintab_View
  extends WgtMaintab
{
/*//////////////////////////////////////////////////////////////////////////////
// Methoden
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param TFlag $params
   * @return void
   */
  public function display( $request, $response, $params )
  {

    $this->setLabel( 'Support User' );
    $this->setTitle( 'Support User' );

    $this->setTemplate( 'daidalos/system/support_user/maintab/overview' );

    $params = new TArray();
    $this->addMenuMenu(  $params );

  }//end public function display */

  
  /**
   * add a drop menu to the create window
   *
   * @param TFlowFlag $params the named parameter object that was created in
   *   the controller
   * {
   *   string formId: the id of the form;
   * }
   */
  public function addMenuMenu( $params )
  {

    $menu     = $this->newMenu
    (
      $this->id.'_dropmenu'
    );
    
    $menu->id = $this->id.'_dropmenu';
    $this->injectActions(  $params );

    $iconMenu          = $this->icon( 'control/menu.png',  'Menu' );
    $iconClose         = $this->icon( 'control/close.png',  'Close' );
    $iconSearch        = $this->icon( 'control/search.png',  'Search' );
    $iconBookmark      = $this->icon( 'control/bookmark.png',  'Bookmark');
    $iconQuery         = $this->icon( 'daidalos/query.png',  'Query' );
    $iconCreate        = $this->icon( 'control/add.png',  'Create' );

    $entries = new TArray();
    $entries->support  = $this->entriesSupport( $params );


    $menu->content = <<<HTML
<ul class="wgt-dropmenu" id="{$this->id}" style="z-index:500;height:16px;"  >
  <li class="wgt-root" >
    <button class="wgt-button" >{$iconMenu} {$this->i18n->l('Menu','wbf.label')}</button>
    <ul style="margin-top:-10px;" >
      <li>
        <p class="wgtac_bookmark" >{$iconBookmark} {$this->i18n->l('Bookmark','wbf.label')}</p>
      </li>
{$entries->support}
{$entries->report}
      <li>
        <p class="wgtac_close" >{$iconClose} {$this->i18n->l('Close','wbf.label')}</p>
      </li>
    </ul>
  </li>
  <li class="wgt-root" >
    <button class="wgt-button wgtac_create" >{$iconCreate} {$this->i18n->l('Create','wbf.label')}</button>
    <ul style="margin-top:-10px;" ></ul>
  </li>
  <li class="wgt-root" >
    <button class="wgt-button wgtac_query" >{$iconQuery} {$this->i18n->l('Query','wbf.label')}</button>
    <ul style="margin-top:-10px;" ></ul>
  </li>
</ul>
HTML;

  }//end public function buildMenu */



  /**
   * @param TFlag $params
   */
  protected function entriesSupport( $params )
  {

    $iconSupport = $this->icon( 'control/support.png'  ,'Support' );
    $iconBug     = $this->icon( 'control/bug.png'      ,'Bug' );
    $iconFaq     = $this->icon( 'control/faq.png'      ,'Faq' );
    $iconHelp    = $this->icon( 'control/help.png'     ,'Help' );

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
  public function injectActions( $params )
  {

    // add the button action for save in the window
    // the code will be binded direct on a window object and is removed
    // on close
    // all buttons with the class save will call that action
    $code = <<<BUTTONJS

    self.getObject().find(".wgtac_close").click(function(){
      self.close();
    });


BUTTONJS;


    $this->addJsCode( $code );

  }//end public function injectActions */

}//end class DaidalosProjects_Maintab

