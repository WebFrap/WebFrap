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
 * @subpackage wbfsys_message
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright webfrap.net <contact@webfrap.net>
 */
class MyMessage_Widget extends WgtWidget
{
  /**
   * @param string $containerId die Id des Tab Containers in dem das Widget platziert wird
   * @param string $tabId die ID des Tabs für das Widget
   * @param string $tabSize die Höhe des Widgets in
   *
   * @return void
   */
  public function asTab($containerId, $tabId, $tabSize = 'medium')
  {

    // benötigte resourcen laden
    $user     = $this->getUser();
    $view     = $this->getView();
    $acl      = $this->getAcl();
    $db        = $this->getDb();
    $request  = $this->getRequest();

    $profile  = $user->getProfileName();

    $params         = new TFlagListing($request);
    $params->qsize  = 25;

    // die query muss für das paging und eine korrekte anzeige
    // die anzahl der gefundenen datensätze ermitteln
    $params->loadFullSize = true;

    // ok nun kommen wir zu der zugriffskontrolle
    $access = new MyMessage_Widget_Access(null, null, $this);
    $access->load($user->getProfileName(), $params);

     // access direkt übergeben
    $params->access = $access;

    // filter für die query konfigurieren
    $condition = array();
    $condition['filters'] = array();
    $condition['filters']['mailbox'] = 'in';
    $condition['filters']['archive'] = false;

    $query = $db->newQuery('MyMessage_Widget');

    $query->fetch
    (
      $condition,
      $params
    );

    $table = new MyMessage_Widget_Table_Element('tableWbfsysMessageItem', $view);
    $table->setId('wgt-table-my_message-widget');

    $table->setData($query);
    $table->addAttributes(array
    (
      'style' => 'width:99%;'
    ));

    $params->searchFormId = 'wgt-form-my_message-widget-search';

    $table->setPagingId($params->searchFormId);

    $actions   = array();

    $actions[] = 'show';
    $actions[] = 'respond';
    $actions[] = 'forward';
    $actions[] = 'archive';

    $table->addActions($actions);
    $table->setAccess($params->access);

    // Über Listenelemente können Eigene Panelcontainer gepackt werden
    // hier verwenden wir ein einfaches Standardpanel mit Titel und
    // simple Suchfeld
    $tabPanel = new MyMessage_Widget_Table_Panel($table);
    $tabPanel->setAccess($params->access);

    $tabPanel->addButton
    (
      'create',
      array
      (
        Wgt::ACTION_JS,
        'Create',
        '$R.get(\'maintab.php?c=My.Message_Crud.create&ltab=table&amp;target_mask=MyMessage_Widget\');return false;',
        'message/create.png',
        'wcm wcm_ui_button',
        'wbf.label'
      )
    );

    $table->buildHtml();

    $html = <<<HTML
    <div id="{$tabId}" class="wgt_tab {$tabSize} {$containerId}" title="My Messages"  >
      <form
        id="wgt-form-my_message-widget-search"
        class="wcm wcm_req_ajax"
        action="ajax.php?c=Widget.MyMessage.reload"
        method="get" ></form>
      {$table}
      <div class="wgt-clear small" ></div>
    </div>
HTML;

    return $html;

  }//end public function asTab */

  /**
   * @param string $tabId
   * @param string $tabSize
   * @return void
   */
  public function embed($tabId, $tabSize = 'medium')
  {
    // benötigte resourcen laden
    $user     = $this->getUser();
    $view     = $this->getView();
    $db        = $this->getDb();
    $acl      = $this->getAcl();
    $request  = $this->getRequest();

    $profile  = $user->getProfileName();

    $params         = new TFlagListing($request);
    $params->qsize  = 25;

    // die query muss für das paging und eine korrekte anzeige
    // die anzahl der gefundenen datensätze ermitteln
    $params->loadFullSize = true;

    // access container
    $access = new MyMessage_Widget_Access(null, null, $this);
    $access->load($user->getProfileName(), $params);

     // access direkt übergeben
    $params->access = $access;

    // filter für die query konfigurieren
    $condition = array();

    $condition['filters'] = array();
    $condition['filters']['mailbox'] = 'in';
    $condition['filters']['archive'] = false;

    // erstellen uns ausführen der datenbankabfrage
    $query  = $db->newQuery('MyMessage_Widget');
    $query->fetch
    (
      $condition,
      $params
    );


    $table = new MyMessage_Widget_Table_Element('tableMyMessageItem', $view);
    $table->setId('wgt-table-my_message-widget');
    $table->setData($query);
    $table->addAttributes(array
    (
      'style' => 'width:99%;'
    ));

    $params->searchFormId = 'wgt-form-my_message-widget-search';
    $table->setPagingId($params->searchFormId);

    $actions   = array();

    $actions[] = 'show';
    $actions[] = 'respond';
    $actions[] = 'forward';
    $actions[] = 'archive';

    $table->addActions($actions);
    $table->setAccess($params->access);

    // Über Listenelemente können Eigene Panelcontainer gepackt werden
    // hier verwenden wir ein einfaches Standardpanel mit Titel und
    // simple Suchfeld
    $tabPanel = new MyMessage_Widget_Table_Panel($table);
    $tabPanel->setAccess($params->access);

    $tabPanel->addButton
    (
      'create',
      array
      (
        Wgt::ACTION_JS,
        'Create',
        '$R.get(\'maintab.php?c=My.Message_Crud.create&ltab=table&amp;target_mask=MyMessage_Widget\');return false;',
        'message/create.png',
        'wcm wcm_ui_button',
        'wbf.label'
      )
    );

    $table->buildHtml();

    $html = <<<HTML
    <div id="{$tabId}" class="wgt_tab {$tabSize}" title="My Messages"  >
      <form
        id="{$params->searchFormId}"
        class="wcm wcm_req_ajax"
        action="ajax.php?c=Widget.MyMessage.reload"
        method="get" ></form>

      {$table}

      <div class="wgt-clear small"></div>
    </div>
HTML;

    return $html;

  }//end public function embed */

  /**
   * @param string $tabSize
   * @return void
   */
  public function runReload($tabSize = 'medium')
  {

    $condition      = array();

    $httpRequest    = $this->getRequest();
    $db             = $this->getDb();
    $orm            = $db->getOrm();
    $view           = $this->getView();
    $user           = $this->getUser();
    $acl            = $this->getAcl();

    $view->getI18n();

    $params       = $this->getSearchFlags();

    $params->ajax = true;

    // die query muss für das paging und eine korrekte anzeige
    // die anzahl der gefundenen datensätze ermitteln
    $params->loadFullSize = true;

    // access container
    $access = new MyMessage_Widget_Access(null, null, $this);
    $access->load($user->getProfileName(), $params);

     // access direkt übergeben
    $params->access = $access;

    $condition = array();
    if ($free = $httpRequest->param('free_search', Validator::TEXT)) {
      $condition['free'] = $free;
    }

    $condition['filters'] = array();

    $condition['filters']['mailbox'] = 'in';
    if ($mailbox = $httpRequest->param('filter', Validator::CKEY, 'mailbox')) {
      $condition['filters']['mailbox'] = $mailbox;
    }

    $condition['filters']['archive'] = false;
    if ($mailbox = $httpRequest->param('filter', Validator::BOOLEAN, 'archive')) {
      $condition['filters']['archive'] = true;
    }

    $query = $db->newQuery('MyMessage_Widget');

    $query->fetch
    (
      $condition,
      $params
    );

    $table = new MyMessage_Widget_Table_Element('tableMyMessageItem', $view);

    // use the query as datasource for the table
    $table->setData($query);

    // set the offset to set the paging menu correct
    $table->start    = $params->start;

    // set the position for the size menu
    $table->stepSize = $params->qsize;

    // check if there is a filter for the first char
    if ($params->begin)
      $table->begin    = $params->begin;

    // if there is a given tableId for the html id of the the table replace
    // the default id with it
    $table->setId('wgt-table-my_message-widget');

    $actions   = array();

    $actions[] = 'show';
    $actions[] = 'respond';
    $actions[] = 'forward';
    $actions[] = 'archive';

    $table->addActions($actions);
    $table->setAccess($params->access);

    // for paging use the default search form, to enshure to keep the order
    // and to page in search results if there was any search
    $table->setPagingId('wgt-form-my_message-widget-search');

    // run build
    if ($params->ajax) {
      // set refresh to true, to embed the content of this element inside
      // of the ajax.tpl index as "htmlarea"
      $table->refresh    = true;

      // the table should only replace the content inside of the container
      // but not the container itself
      $table->insertMode = false;
    }

    if ($params->append) {
      $table->setAppendMode(true);
      $table->buildAjax();

      // sync the columnsize after appending new entries
      if ($params->ajax) {
        $jsCode = <<<WGTJS

  \$S('table#{$table->id}-table').grid('syncColWidth');

WGTJS;
        $view->addJsCode($jsCode);
      }

    } else {
      // if this is an ajax request and we replace the body, we need also
      // to change the displayed found "X" entries in the footer
      if ($params->ajax) {
        $jsCode = <<<WGTJS

  \$S('table#{$table->id}-table').grid('setNumEntries', {$table->dataSize}).grid('syncColWidth');

WGTJS;

        $view->addJsCode($jsCode);

      }

      $table->buildHtml();
    }

    return $table;

  }//end public function runReload */

  /**
   * @param string $tabSize
   * @return void
   */
  public function append( $tabSize = 'medium')
  {

    $condition      = array();

    $httpRequest    = $this->getRequest();
    $db             = $this->getDb();
    $orm            = $db->getOrm();
    $view           = $this->getView();
    $user           = $this->getUser();
    $acl            = $this->getAcl();

    $view->getI18n();

    $params       = $this->getSearchFlags();

    // die query muss für das paging und eine korrekte anzeige
    // die anzahl der gefundenen datensätze ermitteln
    $params->loadFullSize = true;

    // access container
    $access = new MyMessage_Widget_Access(null, null, $this);
    $access->load($user->getProfileName(), $params);

     // access direkt übergeben
    $params->access = $access;

    // filter für die query konfigurieren
    $condition = array();
    if ($free = $httpRequest->param('free_search', Validator::TEXT)) {
      $condition['free'] = $free;
    }

    $condition['filters'] = array();

    $condition['filters']['mailbox'] = 'both';
    if ($mailbox = $httpRequest->param('filter', Validator::CKEY, 'mailbox')) {
      $condition['filters']['mailbox'] = $mailbox;
    }

    $condition['filters']['archive'] = false;
    if ($mailbox = $httpRequest->param('filter', Validator::BOOLEAN, 'archive')) {
      $condition['filters']['archive'] = true;
    }

    $query = $db->newQuery('MyMessage_Widget');

    $query->fetch
    (
      $condition,
      $params
    );

    $table = new MyMessage_Widget_Table_Element
    (
      'tableMyMessageItem',
      $view
    );

    // use the query as datasource for the table
    $table->setData($query);

    // set the offset to set the paging menu correct
    $table->start    = $params->start;

    // set the position for the size menu
    $table->stepSize = $params->qsize;

    // check if there is a filter for the first char
    if ($params->begin)
      $table->begin    = $params->begin;

    // if there is a given tableId for the html id of the the table replace
    // the default id with it
    $table->setId('wgt-table-my_message-widget');

    $actions   = array();

    $actions[] = 'show';
    $actions[] = 'respond';
    $actions[] = 'archive';

    $table->addActions($actions);
    $table->setAccess($params->access);

    // for paging use the default search form, to enshure to keep the order
    // and to page in search results if there was any search
    $table->setPagingId('wgt-form-my_message-widget-search');

    // set refresh to true, to embed the content of this element inside
    // of the ajax.tpl index as "htmlarea"
    $table->refresh = true;

    // the table should only replace the content inside of the container
    // but not the container itself
    $table->insertMode = false;

    $table->buildHtml();

    return $table;

  }//end public function append */

  /**
   * @param TFlag $params
   * @return TFlag
   */
  protected function getSearchFlags($params = null)
  {

    $request = $this->getRequest();

    if (!$params)
      $params = new TFlagListing($request);

    // start position of the query and size of the table
    $params->start
      = $request->param('start', Validator::INT);

    // stepsite for query (limit) and the table
    if (!$params->qsize = $request->param('qsize', Validator::INT))
      $params->qsize = Wgt::$defListSize;

    // order for the multi display element
    $params->order
      = $request->param('order', Validator::CNAME);

    // target for a callback function
    $params->target
      = $request->param('target', Validator::CKEY  );

    // target for some ui element
    $params->targetId
      = $request->param('target_id', Validator::CKEY  );

    // append ist das flag um in listenelementen die einträge
    // anhängen zu lassen anstelle den body zu pagen
    if ($append = $request->param('append', Validator::BOOLEAN))
      $params->append  = $append;

    // flag for beginning seach filter
    if ($text = $request->param('begin', Validator::TEXT)) {
      // whatever is comming... take the first char
      $params->begin = $text[0];
    }

    return $params;

  }//end protected function getSearchFlags */

}// end class MyMessage_Widget

