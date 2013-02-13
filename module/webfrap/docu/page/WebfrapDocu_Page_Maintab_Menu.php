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
class WebfrapDocu_Page_Maintab_Menu
  extends WgtDropmenu
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
  public function buildMenu( $key, $params )
  {

    $iconMenu          = $this->view->icon( 'control/menu.png'     ,'Menu'   );
    $iconClose         = $this->view->icon( 'control/close.png'    ,'Close'   );
    $iconSearch        = $this->view->icon( 'control/search.png'   ,'Search'  );
    $iconBookmark      = $this->view->icon( 'control/bookmark.png' ,'Bookmark');
    $iconSave          = $this->view->icon( 'control/save.png' ,'Save' );
    $iconRefresh       = $this->view->icon( 'control/refresh.png' ,'Refresh' );


    $entries = new TArray();

    $tmp = explode('-',$key);

    $crumbs = array();
    $path   = array();
    foreach( $tmp as $cData )
    {
      $path[] = $cData;
      $crumbs[implode('-',$path)] = SParserString::subToName( $cData );
    }

    $crumbMenu = new WgtControlCrumb();
    $crumbMenu->setPathCrumb( $crumbs, 'maintab.php?c=Webfrap.Docu.page&page=' );


    $this->content = <<<HTML

<div class="inline" >
  <button
    class="wcm wcm_control_dropmenu wgt-button"
    id="{$this->id}_dropmenu-control"
    wgt_drop_box="{$this->id}_dropmenu"  >{$iconMenu} {$this->view->i18n->l('Menu','wbf.label')}</button>
</div>

<div class="wgt-dropdownbox" id="{$this->id}_dropmenu" >
  <ul>
    <li>
      <a class="wgtac_bookmark" >{$iconBookmark} {$this->view->i18n->l('Bookmark', 'wbf.label')}</a>
    </li>
  </ul>
  <ul>
    <li>
      <a class="wgtac_close" >{$iconClose} {$this->view->i18n->l('Close', 'wbf.label')}</a>
    </li>
  </ul>
</div>

HTML;

    $this->content .= $crumbMenu->buildCrumbs();

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
  public function injectActions( $view, $params )
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


    $view->addJsCode( $code );

  }//end public function injectActions */

}//end class WebfrapDocu_Menu_Maintab_Menu

