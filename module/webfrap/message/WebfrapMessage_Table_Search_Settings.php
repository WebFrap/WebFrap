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
 * @subpackage Groupware
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class WebfrapMessage_Table_Search_Request extends LibSettingsNode
{

  /**
   * Auswerten des Requests
   * @param LibRequestHttp $request
   */
  public function interpretRequest($request)
  {

    parent::interpretRequest($request);

    $this->conditions = array();

    // search free
    $this->conditions['free'] = $request->param('free_search', Validator::SEARCH );

    // die channels
    $this->conditions['filters']['channel'] = $request->paramList('channel', Validator::BOOLEAN, true);
    $this->conditions['filters']['mailbox'] = $request->param('mailbox', Validator::CKEY);
    $this->conditions['filters']['archive'] = $request->param('archive', Validator::BOOLEAN);

    Debug::console( 'channel' ,$this->conditions['filters']['channel'],null, true );

  }//end public function interpretRequest */

} // end class WebfrapMessage_Table_Search_Request */

