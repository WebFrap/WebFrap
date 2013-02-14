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
class WgtWidgetProtocol extends WgtWidget
{
/*//////////////////////////////////////////////////////////////////////////////
// attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $containerId
   * @param string $tabId
   * @param string $tabSize
   * @return void
   */
  public function asTab($containerId, $tabId, $tabSize = 'medium' )
  {

    $user     = $this->getUser();
    $view     = $this->getView();

    $profile = $user->getProfileName();

    $params = new TArray();

    $db = $this->getDb();
    $query = $db->newQuery('WbfsysProtocolMessage_Table');

    $params->order = array
    (
      'wbfsys_protocol_message.m_time_created desc'
    );

    $query->fetch(null,$params);

    $tableProtocol = $view->newItem('TableWbfsysProtocolMessage','TableWbfsysProtocolMessage');
    $tableProtocol->setId('wgt-table_widget_protocol');
    $tableProtocol->setData($query );
    $tableProtocol->addAttributes(array
    (
      'style' => 'width:99%;'
    ));
    $tableProtocol->setPagingId('wgt-form_widget_protocol_search');
    $tableProtocol->setActions(array());
    $tableProtocol->enableNav = false;

    $tableProtocol->buildHtml();

    $html = <<<HTML
    <div id="{$tabId}" class="wgt_tab {$tabSize} {$containerId}" title="protocol"  >
      <form
        id="wgt-form_widget_protocol_search"
        class="wcm wcm_req_ajax"
        action="ajax.php?c=Wbfsys.ProtocolMessage.search&amp;targetId=wgt-table_widget_protocol" method="post" ></form>
      <h2>Action Protocol</h2>
      {$tableProtocol}
      <div class="wgt-clear small"></div>
    </div>
HTML;

    return $html;

  }//end public function asTab */


}//end class WgtTreeMessage