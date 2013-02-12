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
 * @subpackage wbfsys_announcement
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright webfrap.net <contact@webfrap.net>
 */
class MyAnnouncement_Widget
  extends WgtWidget
{
  /**
   * @param string $containerId die Id des Tab Containers in dem das Widget platziert wird
   * @param string $tabId die ID des Tabs für das Widget
   * @param string $tabSize die Höhe des Widgets in
   *
   * @return void
   */
  public function asTab( $containerId, $tabId, $tabSize = 'medium' )
  {

    // benötigte resourcen laden
    $user     = $this->getUser();
    $view     = $this->getView();
    $acl      = $this->getAcl();
    $db        = $this->getDb();
    $request  = $this->getRequest();

    $profile  = $user->getProfileName();

    $params         = new TFlagListing( $request );
    $params->qsize  = 12;

    // die query muss für das paging und eine korrekte anzeige
    // die anzahl der gefundenen datensätze ermitteln
    $params->loadFullSize = true;

    // ok nun kommen wir zu der zugriffskontrolle
    $access = new MyAnnouncement_Widget_Access( null, null, $this );
    $access->load( $user->getProfileName(), $params );

     // access direkt übergeben
    $params->access = $access;

    // Notlösung

    $wbfAnModel = $this->loadModel( 'WebfrapAnnouncement' );
    $wbfAnModel->getUserChannel( $user );

    // filter für die query konfigurieren
    $condition = array();

    $condition['filters']['archive'] = true;

    if( $request->param( 'filter', Validator::INT, 'archive' ) )
      unset( $condition['filters']['archive'] );

    if( $request->param( 'filter', Validator::INT, 'important' ) )
      $condition['filters']['important'] = true;

    $query  = $db->newQuery( 'MyAnnouncement_Widget' );
    $query->fetch
    (
      $user,
      $condition,
      $params
    );

    $table = new MyAnnouncement_Widget_Table_Element( 'tableMyAnnouncementItem', $view );
    $table->setId( 'wgt-table-my_announcement-widget' );

    $table->setData( $query );
    $table->addAttributes(array
    (
      'style' => 'width:99%;'
    ));

    $params->searchFormId = 'wgt-form-my_announcement-widget-search';

    $table->setPagingId( $params->searchFormId );

    $actions   = array();
    $actions[] = 'archive';

    $table->addActions( $actions );
    $table->setAccess( $params->access );

    // Über Listenelemente können Eigene Panelcontainer gepackt werden
    // hier verwenden wir ein einfaches Standardpanel mit Titel und
    // simple Suchfeld
    $tabPanel = new MyAnnouncement_Widget_Table_Panel( $table );
    $tabPanel->setAccess( $params->access );

    $table->buildHtml();

    $html = <<<HTML
    <div id="{$tabId}" class="wgt_tab {$tabSize} {$containerId}" title="My Announcements"  >
      <form
        id="wgt-form-my_announcement-widget-search"
        class="wcm wcm_req_ajax"
        action="ajax.php?c=Widget.MyAnnouncement.reload"
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
  public function embed( $tabId, $tabSize = 'medium' )
  {
    // benötigte resourcen laden
    $user     = $this->getUser();
    $view     = $this->getView();
    $db        = $this->getDb();
    $acl      = $this->getAcl();
    $request  = $this->getRequest();

    $profile  = $user->getProfileName();

    $params         = new TFlagListing( $request );
    $params->qsize  = 12;

    // die query muss für das paging und eine korrekte anzeige
    // die anzahl der gefundenen datensätze ermitteln
    $params->loadFullSize = true;

    // access container
    $access = new MyAnnouncement_Widget_Access( null, null, $this );
    $access->load( $user->getProfileName(), $params );

     // access direkt übergeben
    $params->access = $access;

    // filter für die query konfigurieren
    $condition = array();




    // erstellen uns ausführen der datenbankabfrage
    $query  = $db->newQuery( 'MyAnnouncement_Widget' );
    $query->fetch
    (
      $condition,
      $params
    );


    $table = new MyAnnouncement_Widget_Table_Element( 'tableMyAnnouncementItem', $view );
    $table->setId( 'wgt-table-my_announcement-widget' );
    $table->setData( $query );
    $table->addAttributes(array
    (
      'style' => 'width:99%;'
    ));

    $params->searchFormId = 'wgt-form-my_announcement-widget-search';
    $table->setPagingId( $params->searchFormId );

    $actions   = array();
    $actions[] = 'archive';

    $table->addActions( $actions );
    $table->setAccess( $params->access );

    // Über Listenelemente können Eigene Panelcontainer gepackt werden
    // hier verwenden wir ein einfaches Standardpanel mit Titel und
    // simple Suchfeld
    $tabPanel = new MyAnnouncement_Widget_Table_Panel( $table );
    $tabPanel->setAccess( $params->access );


    $table->buildHtml();

    $html = <<<HTML
    <div id="{$tabId}" class="wgt_tab {$tabSize} {$containerId}" title="My Announcements"  >
      <form
        id="{$params->searchFormId}"
        class="wcm wcm_req_ajax"
        action="ajax.php?c=Widget.MyAnnouncement.reload"
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
  public function runReload( $tabSize = 'medium' )
  {

    $condition      = array();

    $request    = $this->getRequest();
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
    $access = new MyAnnouncement_Widget_Access( null, null, $this );
    $access->load( $user->getProfileName(), $params );

     // access direkt übergeben
    $params->access = $access;

    $condition = array();
    if ( $free = $request->param( 'free_search', Validator::TEXT ) ) {
      $condition['free'] = $free;
    }

    // filter für die query konfigurieren
    $condition['filters']['archive'] = true;

    if( $request->param( 'filter', Validator::INT, 'archive' ) )
      unset( $condition['filters']['archive'] );

    if( $request->param( 'filter', Validator::INT, 'important' ) )
      $condition['filters']['important'] = true;

    $query = $db->newQuery( 'MyAnnouncement_Widget' );
    $query->fetch
    (
      $user,
      $condition,
      $params
    );

    $table = new MyAnnouncement_Widget_Table_Element( 'tableMyAnnouncementItem', $view );

    // use the query as datasource for the table
    $table->setData($query);

    // set the offset to set the paging menu correct
    $table->start    = $params->start;

    // set the position for the size menu
    $table->stepSize = $params->qsize;

    // check if there is a filter for the first char
    if( $params->begin )
      $table->begin    = $params->begin;

    // if there is a given tableId for the html id of the the table replace
    // the default id with it
    $table->setId( 'wgt-table-my_announcement-widget' );

    $actions   = array();
    $actions[] = 'archive';

    $table->addActions( $actions );
    $table->setAccess( $params->access );

    // for paging use the default search form, to enshure to keep the order
    // and to page in search results if there was any search
    $table->setPagingId( 'wgt-form-my_announcement-widget-search' );

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
    } else {
      $table->buildHtml();
    }

    return $table;

  }//end public function runReload */

  /**
   * @param string $tabSize
   * @return void
   */
  public function append(  $tabSize = 'medium' )
  {

    $condition      = array();

    $request    = $this->getRequest();
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
    $access = new MyAnnouncement_Widget_Access( null, null, $this );
    $access->load( $user->getProfileName(), $params );

     // access direkt übergeben
    $params->access = $access;

    // filter für die query konfigurieren
    $condition = array();
    if ( $free = $request->param( 'free_search', Validator::TEXT ) ) {
      $condition['free'] = $free;
    }

    // filter für die query konfigurieren
    $condition['filters']['archive'] = true;

    if( $request->param( 'filter', Validator::INT, 'archive' ) )
      unset( $condition['filters']['archive'] );

    if( $request->param( 'filter', Validator::INT, 'important' ) )
      $condition['filters']['important'] = true;

    $query = $db->newQuery( 'MyAnnouncement_Widget' );
    $query->fetch
    (
      $condition,
      $params
    );

    $table = new MyAnnouncement_Widget_Table_Element
    (
      'tableMyAnnouncementItem',
      $view
    );

    // use the query as datasource for the table
    $table->setData( $query );

    // set the offset to set the paging menu correct
    $table->start    = $params->start;

    // set the position for the size menu
    $table->stepSize = $params->qsize;

    // check if there is a filter for the first char
    if( $params->begin )
      $table->begin    = $params->begin;

    // if there is a given tableId for the html id of the the table replace
    // the default id with it
    $table->setId( 'wgt-table-my_announcement-widget' );

    $actions   = array();
    $actions[] = 'archive';

    $table->addActions( $actions );
    $table->setAccess( $params->access );

    // for paging use the default search form, to enshure to keep the order
    // and to page in search results if there was any search
    $table->setPagingId( 'wgt-form-my_announcement-widget-search' );

    // set refresh to true, to embed the content of this element inside
    // of the ajax.tpl index as "htmlarea"
    $table->refresh = true;

    // the table should only replace the content inside of the container
    // but not the container itself
    $table->insertMode = false;

    $table->buildHtml( );

    return $table;

  }//end public function append */

  /**
   * @param TFlag $params
   * @return TFlag
   */
  protected function getSearchFlags( $params = null )
  {

    $request = $this->getRequest();

    if( !$params )
      $params = new TFlagListing( $request );

    // start position of the query and size of the table
    $params->start
      = $request->param('start', Validator::INT );

    // stepsite for query (limit) and the table
    if( !$params->qsize = $request->param( 'qsize', Validator::INT ) )
      $params->qsize = 12;

    // order for the multi display element
    $params->order
      = $request->param( 'order', Validator::CNAME );

    // target for a callback function
    $params->target
      = $request->param( 'target', Validator::CKEY  );

    // target for some ui element
    $params->targetId
      = $request->param( 'target_id', Validator::CKEY  );

    // append ist das flag um in listenelementen die einträge
    // anhängen zu lassen anstelle den body zu pagen
    if( $append = $request->param( 'append', Validator::BOOLEAN ) )
      $params->append  = $append;

    // flag for beginning seach filter
    if ( $text = $request->param( 'begin', Validator::TEXT ) ) {
      // whatever is comming... take the first char
      $params->begin = $text[0];
    }

    return $params;

  }//end protected function getSearchFlags */

}// end class MyAnnouncement_Widget
