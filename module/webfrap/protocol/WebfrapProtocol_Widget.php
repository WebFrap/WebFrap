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
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 *
 */
class WebfrapProtocol_Widget extends WgtWidget
{
/*//////////////////////////////////////////////////////////////////////////////
// attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param LibTemplate $view
   * @param string $tabId
   * @param string $tabSize
   * @return void
   */
  public function asTab( $containerId, $tabId, $tabSize = 'medium' )
  {

    $user     = $this->getUser();
    $view     = $this->getView();

    $profile  = $user->getProfileName();

    $params         = new TArray();
    $params->qsize  = 25;

    $db     = $this->getDb();
    $query  = $db->newQuery('WebfrapProtocol');

    $params->order = array
    (
      'wbfsys_protocol_message.m_time_created desc'
    );

    $query->fetchFullProtocol($params);

    $tableProtocol = $view->newItem('tableWbfsysProtocolMessage','WebfrapProtocol_Table');
    $tableProtocol->setId('wgt-table_widget_protocol');
    $tableProtocol->setData( $query );
    $tableProtocol->addAttributes(array
    (
      'style' => 'width:99%;'
    ));
    $tableProtocol->setPagingId('wgt-form-widget_protocol-search');
    $tableProtocol->setActions(array());
    $tableProtocol->enableNav = false;

    $tableProtocol->buildProtocolEntityHtml();

    $html = <<<HTML
    <div id="{$tabId}" class="wgt_tab {$tabSize} {$containerId}" title="protocol"  >
      <form
        id="wgt-form-widget_protocol-search"
        class="wcm wcm_req_ajax"
        action="ajax.php?c=Widget.WebfrapProtocol.reload" method="post" ></form>
      <h2>Action Protocol</h2>
      {$tableProtocol}
      <div class="wgt-clear small"></div>
    </div>
HTML;

    return $html;

  }//end public function asTab */


  /**
   * @param LibTemplate $view
   * @param string $tabId
   * @param string $tabSize
   * @return void
   */
  public function runReload( $view, $tabSize = 'medium' )
  {

    $condition    = array();

    $httpRequest  = $this->getRequest();
    $db           = $this->getDb();
    $orm          = $db->getOrm();
    $view->getI18n();
    $params       = $this->getSearchFlags();

    /*
    if( $httpRequest->method('POST')  )
    {
      if( $free = $httpRequest->param('free_search' , Validator::TEXT) )
        $condition['free'] = $free;

      if (!$fieldsWbfsysProtocolMessage = $this->getRegisterd('search_fields_wbfsys_protocol_message') )
      {
         $fieldsWbfsysProtocolMessage   = $orm->getSearchCols('WbfsysProtocolMessage');
      }

      if( $refs = $httpRequest->dataSearchIds( 'search_wbfsys_protocol_message' ) )
      {
        $fieldsWbfsysProtocolMessage = array_unique( array_merge
        (
          $fieldsWbfsysProtocolMessage,
          $refs
        ));
      }

      $filterWbfsysProtocolMessage     = $httpRequest->checkSearchInput
      (
        $orm->getValidationData( 'WbfsysProtocolMessage', $fieldsWbfsysProtocolMessage ),
        $orm->getErrorMessages( 'WbfsysProtocolMessage'  ),
        'search_wbfsys_protocol_message'
      );
      $condition['wbfsys_protocol_message'] = $filterWbfsysProtocolMessage->getData();

      if( $mRoleCreate = $httpRequest->param( 'search_wbfsys_protocol_message', Validator::EID, 'm_role_create'   ) )
        $condition['wbfsys_protocol_message']['m_role_create'] = $mRoleCreate;

      if( $mRoleChange = $httpRequest->param( 'search_wbfsys_protocol_message', Validator::EID, 'm_role_change'   ) )
        $condition['wbfsys_protocol_message']['m_role_change'] = $mRoleChange;

      if( $mTimeCreatedBefore = $httpRequest->param( 'search_wbfsys_protocol_message', Validator::DATE, 'm_time_created_before'   ) )
        $condition['wbfsys_protocol_message']['m_time_created_before'] = $mTimeCreatedBefore;

      if( $mTimeCreatedAfter = $httpRequest->param( 'search_wbfsys_protocol_message', Validator::DATE, 'm_time_created_after'   ) )
        $condition['wbfsys_protocol_message']['m_time_created_after'] = $mTimeCreatedAfter;

      if( $mTimeChangedBefore = $httpRequest->param( 'search_wbfsys_protocol_message', Validator::DATE, 'm_time_changed_before'   ) )
        $condition['wbfsys_protocol_message']['m_time_changed_before'] = $mTimeChangedBefore;

      if( $mTimeChangedAfter = $httpRequest->param( 'search_wbfsys_protocol_message}', Validator::DATE, 'm_time_changed_after'   ) )
        $condition['wbfsys_protocol_message']['m_time_changed_after'] = $mTimeChangedAfter;

      if( $mRowid = $httpRequest->param( 'search_wbfsys_protocol_message', Validator::EID, 'm_rowid'   ) )
        $condition['wbfsys_protocol_message']['m_rowid'] = $mRowid;

      if( $mUuid = $httpRequest->param( 'search_wbfsys_protocol_message', Validator::TEXT, 'm_uuid'    ) )
        $condition['wbfsys_protocol_message']['m_uuid'] = $mUuid;

    }
    */

    $query = $db->newQuery('WebfrapProtocol');

    $query->fetchFullProtocol
    (
      $params
    );

    $table = $view->newItem
    (
      'tableWbfsysProtocolMessage',
      'WebfrapProtocol_Table'
    );

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
    $table->setId( 'wgt-table_widget_protocol' );

    $acl = $this->getAcl();

    if( $acl->access( array('wbfsys/protocol_message:edit') ) )
    {
      $actions[] = 'edit';
    }

    if( $acl->access( array('wbfsys/protocol_message:delete') ) )
    {
      $actions[] = 'delete';
    }

    $table->addActions( $actions );

    // for paging use the default search form, to enshure to keep the order
    // and to page in search results if there was any search
    $table->setPagingId('wgt-form-widget_protocol-search');

    // refresh the table in ajax requests
    $table->refresh    = true;

    // the table should only replace the content inside of the container
    // but not the container itself
    $table->insertMode = false;

    $table->buildProtocolEntityHtml();

    return $table;

  }//end public function runReload */


  /**
   * @param TFlowFlag $flowFlags
   * @return TFlowFlag
   */
  protected function getSearchFlags( $flowFlags = null )
  {

    if (!$flowFlags )
      $flowFlags = new TFlowFlag();


    // start position of the query and size of the table
    $flowFlags->start
      = $this->request->get('start', Validator::INT );

    // stepsite for query (limit) and the table
    if (!$flowFlags->qsize = $this->request->get('qsize', Validator::INT ) )
      $flowFlags->qsize = Wgt::$defListSize;

    // order for the multi display element
    $flowFlags->order
      = $this->request->get('order', Validator::CNAME );

    // target for a callback function
    $flowFlags->target
      = $this->request->get('target', Validator::CKEY  );

    // target for some ui element
    $flowFlags->targetId
      = $this->request->get('targetId', Validator::CKEY  );

    // flag for beginning seach filter
    if( $text = $this->request->get('begin', Validator::TEXT  ) )
    {
      // whatever is comming... take the first char
      $flowFlags->begin = $text[0];
    }


    return $flowFlags;

  }//end protected function getSearchFlags */

}//end class WebfrapProtocol_Widget