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
class DaidalosDbSchemaTable_Maintab_View extends WgtMaintab
{
/*//////////////////////////////////////////////////////////////////////////////
// Methoden
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $dbKey
   * @param string $schemaKey
   * @param TFlag $params
   * @return void
   */
  public function display($dbKey, $schemaKey, $params )
  {

    $this->setLabel( 'Schema: '.$schemaKey );
    $this->setTitle( 'Tables for Db: '.$dbKey.' Schema: '.$schemaKey );

    $this->setTemplate( 'daidalos/db/list_db_schema_tables' );

    $this->addVar( 'dbName', $dbKey );
    $this->addVar( 'schemaName', $schemaKey );

    $this->addVar( 'tables', $this->model->getSchemaTables($dbKey, $schemaKey ) );

    $params = new TArray();
    $this->addMenuMenu($params );

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
  public function addMenuMenu($params )
  {

    $iconMenu          = $this->icon( 'control/menu.png'     ,'Menu'   );
    $iconClose         = $this->icon( 'control/close.png'    ,'Close'   );
    $iconSearch        = $this->icon( 'control/search.png'   ,'Search'  );
    $iconBookmark      = $this->icon( 'control/bookmark.png' ,'Bookmark');

    $iconSupport = $this->icon( 'control/support.png'  ,'Support' );
    $iconBug     = $this->icon( 'control/bug.png'      ,'Bug' );
    $iconFaq     = $this->icon( 'control/faq.png'      ,'Faq' );
    $iconHelp    = $this->icon( 'control/help.png'     ,'Help' );

    $iconQuery         = $this->icon( 'daidalos/query.png' ,'Query' );

    $menu     = $this->newMenu
    (
      $this->id.'_dropmenu'
    );

    $menu->id = $this->id.'_dropmenu';

    $entries = new TArray();

    $menu->content = <<<HTML
<div class="inline" >
  <button
    class="wcm wcm_control_dropmenu wgt-button"
    id="{$this->id}-control"
    wgt_drop_box="{$this->id}_dropmenu"  >{$iconMenu} {$this->i18n->l('Menu','wbf.label')}</button>
  <var id="{$this->id}-control-cfg-dropmenu"  >{"triggerEvent":"mouseover","closeOnLeave":"true","align":"right"}</var>
</div>

<div class="wgt-dropdownbox" id="{$this->id}_dropmenu" >

  <ul>
    <li>
      <a class="wgtac_bookmark" >{$iconBookmark} {$this->i18n->l('Bookmark', 'wbf.label')}</a>
    </li>
  </ul>

  <ul>
    <li>
      <a class="deeplink" >{$iconSupport} {$this->i18n->l('Support', 'wbf.label')}</a>
      <span>
      <ul>
        <li><a class="wcm wcm_req_ajax" href="modal.php?c=Wbfsys.Issue.create&amp;context=menu" >{$iconBug} {$this->i18n->l('Bug', 'wbf.label')}</a></li>
        <li><a class="wcm wcm_req_ajax" href="modal.php?c=Wbfsys.Faq.create&amp;context=menu" >{$iconFaq} {$this->i18n->l('Faq', 'wbf.label')}</a></li>
      </ul>
      </span>
    </li>
    <li>
      <a class="wgtac_close" >{$iconClose} {$this->i18n->l('Close','wbf.label')}</a>
    </li>
  </ul>

</div>

<div class="wgt-panel-control" >
  <button class="wgt-button wgtac_query" >{$iconQuery} {$this->i18n->l('Query','wbf.label')}</button>
</div>

HTML;

    $this->injectActions($params );

  }//end public function addMenuMenu */

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
  protected function injectActions($params )
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
      \\\$R.get( 'maintab.php?c=Daidalos.Db.query' );
    });

BUTTONJS;

    $this->addJsCode($code );

  }//end protected function injectActions */

}//end class DaidalosDbSchemaTable_Maintab_View

