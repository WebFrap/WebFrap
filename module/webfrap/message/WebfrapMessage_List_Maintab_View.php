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
 * @subpackage Groupware
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class WebfrapMessage_List_Maintab_View extends WgtMaintab
{
/*//////////////////////////////////////////////////////////////////////////////
// Methoden
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param TFlag $params
   * @return void
   */
  public function displayList(  $params )
  {

    $this->setLabel( 'My Communications &amp; Tasks');
    $this->setTitle( 'My Communications &amp; Tasks' );

    //$this->addVar( 'node', $this->model->node );

    // benötigte resourcen laden
    $user     = $this->getUser();
    $acl      = $this->getAcl();
    $request  = $this->getRequest();

    $params->qsize  = 50;

    // die query muss für das paging und eine korrekte anzeige
    // die anzahl der gefundenen datensätze ermitteln
    $params->loadFullSize = true;

    $params->searchFormId = 'wgt-form-webfrap-groupware-search';

    $data = $this->model->fetchMessages($params );

    $table = new WebfrapMessage_Table_Element( 'messageList', $this );
    $table->setId( 'wgt-table-webfrap-groupware_message' );
    $table->access = $params->access;

    $table->setData($data );
    $table->addAttributes(array
    (
      'style' => 'width:99%;'
    ));

    $table->setPagingId($params->searchFormId );


    $table->buildHtml();

    // Über Listenelemente können Eigene Panelcontainer gepackt werden
    // hier verwenden wir ein einfaches Standardpanel mit Titel und
    // simplem Suchfeld
    $tabPanel = new WgtPanelTable($table );

    //$tabPanel->title = $view->i18n->l( 'Tasks', 'project.task.label' );
    //$tabPanel->searchKey = 'project_task';

    // display the toggle button for the extended search
    //$tabPanel->advancedSearch = true;

    // search element im maintab
    $searchElement = $this->setSearchElement( new WgtPanelElementSearch_Splitted($table ) );
    $searchElement->searchKey = 'my_message';
    $searchElement->searchFieldSize = 'xlarge';
    //$searchElement->advancedSearch = true;
    $searchElement->focus = true;

    $this->setTemplate( 'webfrap/message/maintab/list', true );

    $this->addMenu($params );

  }//end public function displayList */

  /**
   * add a drop menu to the create window
   *
   * @param TFlowFlag $params the named parameter object that was created in
   *   the controller
   * {
   *   string formId: the id of the form;
   * }
   */
  public function addMenu($params )
  {

    $iconLtChat    = $this->icon( 'groupware/group_chat.png'      ,'Chat' );
    $iconLtFull    = $this->icon( 'groupware/group_full.png'      ,'Full' );
    $iconLtHead    = $this->icon( 'groupware/group_head.png'     ,'Head' );

    $menu     = $this->newMenu($this->id.'_dropmenu' );

    $menu->id = $this->id.'_dropmenu';

    $menu->content = <<<HTML

<div class="inline" >
  <button
    class="wcm wcm_control_dropmenu wgt-button ui-state-default"
    id="{$this->id}_dropmenu-control"
    style="text-align:left;"
    wgt_drop_box="{$this->id}_dropmenu"  ><i class="icon-reorder" ></i> Menu <i class="icon-angle-down" ></i></button>
</div>

<div class="wgt-dropdownbox" id="{$this->id}_dropmenu" >
  <ul>
    <li>
      <a class="wgtac_bookmark" ><i class="icon-bookmark" ></i> {$this->i18n->l('Bookmark', 'wbf.label')}</a>
    </li>
  </ul>
  <ul>
    <li>
      <a class="deeplink" ><i class="icon-info-sign" ></i> {$this->i18n->l('Support', 'wbf.label')}</a>
      <span>
      <ul>
        <li><a class="wcm wcm_req_ajax" href="modal.php?c=Wbfsys.Faq.create&amp;context=menu" ><i class="icon-question-sign" ></i> {$this->i18n->l('Faq', 'wbf.label')}</a></li>
      </ul>
      </span>
    </li>
    <li>
      <a class="wgtac_close" ><i class="icon-remove-circle" ></i> {$this->i18n->l('Close','wbf.label')}</a>
    </li>
  </ul>
</div>

<!--
<div class="wgt-panel-control" >
  <div id="wgt-mentry-swlt-message" >

    <button
      id="wgt-mentry-swlt-message-head"
      class="wgtac_view_table wgt-button"  >
      {$iconLtChat}
    </button>
    <button
      id="wgt-mentry-swlt-message-full"
      class="wgtac_view_treetable wgt-button"
      style="margin-left:-6px;" >
      {$iconLtFull}
    </button>
    <button
      id="wgt-mentry-swlt-message-chat"
      class="wgtac_view_treetable wgt-button"
      style="margin-left:-6px;" >
      {$iconLtHead}
    </button>

  </div>
</div>
-->

<div class="wgt-panel-control" >
  <button class="wgt-button wgtac_new_msg" ><i class="icon-plus-sign" ></i> {$this->i18n->l('New Message','wbf.label')}</button>
</div>

<div class="wgt-panel-control" >
  <button class="wgt-button wgtac_refresh" ><i class="icon-refresh" ></i> {$this->i18n->l('Check for Messages','wbf.label')}</button>
</div>



HTML;

    $this->injectActions($menu, $params );

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
  public function injectActions($menu, $params )
  {

    // add the button action for save in the window
    // the code will be binded direct on a window object and is removed
    // on close
    // all buttons with the class save will call that action
    $code = <<<BUTTONJS

    self.getObject().find(".wgtac_close").click(function(){
      self.close();
    });

    self.getObject().find(".wgtac_new_msg").click(function(){
      \$R.get('maintab.php?c=Webfrap.Message.formNew');
    });

    self.getObject().find(".wgtac_refresh").click(function(){
      \$R.form('wgt-form-my_message-search');
    });

    self.getObject().find('.wgt-mentry-my_message-boxtype').change( function(){
      \$R.form('wgt-form-my_message-search');
    });

BUTTONJS;

    $this->addJsCode($code );

  }//end public function injectActions */

}//end class DaidalosBdlNodeProfile_Maintab_View

