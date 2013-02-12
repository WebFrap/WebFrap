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
class DaidalosDbTable_Maintab_View
  extends WgtMaintab
{

  /**
   * @var DaidalosDbView_Model
   */
  public $model = null;

////////////////////////////////////////////////////////////////////////////////
// Methoden
////////////////////////////////////////////////////////////////////////////////

  /**
   * @param TFlag $params
   * @return void
   */
  public function displayListing( $params )
  {

    $label = 'DB: '.$this->model->dbName.' Schema: '.$this->model->schemaName.' Views';

    $this->setLabel( $label );
    $this->setTitle( $label );

    $this->addVar( 'views', $this->model->getViews( $this->model->schemaName )  );

    $this->setTemplate( 'daidalos/db/maintab/list_db_views' );
    //$table = $this->newItem( 'tableCompilation' , 'DaidalosDb_Table' );

    //$this->tabId = 'daidalos_db_form_backup';

    $this->addMenu( $params );

  }//end public function displayListing */

  /**
   * add a drop menu to the create window
   *
   * @param TFlowFlag $params the named parameter object that was created in
   *   the controller
   * {
   *   string formId: the id of the form;
   * }
   */
  public function addMenu( $params )
  {

    $menu     = $this->newMenu
    (
      $this->id.'_dropmenu'
    );

    $menu->id = $this->id.'_dropmenu';

    $iconMenu          = $this->icon( 'control/menu.png'     ,'Menu'   );
    $iconClose         = $this->icon( 'control/close.png'    ,'Close'   );
    $iconSearch        = $this->icon( 'control/search.png'   ,'Search'  );
    $iconBookmark      = $this->icon( 'control/bookmark.png' ,'Bookmark');

    $iconQuery         = $this->icon( 'daidalos/query.png' ,'Query' );

    $iconSupport = $this->icon( 'control/support.png'  ,'Support' );
    $iconBug     = $this->icon( 'control/bug.png'      ,'Bug' );
    $iconFaq     = $this->icon( 'control/faq.png'      ,'Faq' );

    $iconCreateView    = $this->icon( 'daidalos/table_import.png' ,'Create Wbf Views' );
    $iconRecreate      = $this->icon( 'daidalos/table_dump.png' ,'Refresh Wbf Views' );
    $iconDeleteView    = $this->icon( 'daidalos/table_clean.png' ,'Delete Wbf Views' );

    $iconRefresh       = $this->icon( 'control/refresh.png' ,'Refresh' );

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
    <li><a
      class="wcm wcm_req_put"
      href="ajax.php?c=Daidalos.DbView.createWbfViews&db={$params->dbName}&schema={$params->schemaName}" >{$iconCreateView} Create Wbf Views</a></li>
    <li><a
      class="wcm wcm_req_put"
      href="ajax.php?c=Daidalos.DbView.reCreateWbfViews&db={$params->dbName}&schema={$params->schemaName}" >{$iconRecreate} Re Create Wbf Views</a></li>
    <li><a
      class="wcm wcm_req_del"
      href="ajax.php?c=Daidalos.DbView.deleteWbfViews&db={$params->dbName}&schema={$params->schemaName}" >{$iconDeleteView} Delete Wbf Views</a></li>

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
  <button class="wgt-button wgtac_refresh" >{$iconRefresh}</button>
</div>

<div class="wgt-panel-control" >
  <button class="wgt-button wgtac_query" >{$iconQuery}</button>
</div>

HTML;

    $this->injectActions( $params );

  }//end public function addMenu */

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

    self.getObject().find(".wgtac_query").click(function(){
      \$R.get( 'maintab.php?c=Daidalos.Db.query' );
    });

    self.getObject().find(".wgtac_refresh").click(function(){
      \$R.get( 'maintab.php?c=Daidalos.DbView.listing&db={$params->dbName}&schema={$params->schemaName}' );
    });

BUTTONJS;

    $this->addJsCode( $code );

  }//end public function injectActions */

}//end class DaidalosProjects_Maintab
