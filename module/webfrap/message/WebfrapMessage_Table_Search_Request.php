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
class WebfrapMessage_Table_Search_Request extends ContextListing
{

  /**
   * @var WebfrapMessage_Table_Search_Settings
   */
  public $settings = null;

  /**
   * @param LibRequestHttp $request
   */
  public function __construct($request, $settings)
  {

    $this->filter = new TFlag();

    $filters = $request->param('filter', Validator::BOOLEAN );

    if ($filters) {
      foreach ($filters as $key => $value) {
        $this->filter->$key = $value;
      }
    }

    $this->settings = $settings;

    $this->interpretRequest($request);

  } // end public function __construct */

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
    if( $request->paramExists('channel') ){

      $channels = $request->paramList(
      	'channel',
        Validator::BOOLEAN,
        true
      );

      $this->settings->setChannel( $channels->content() );

      $this->conditions['filters']['channel'] = new $channels;

    } else {

      $this->conditions['filters']['channel'] = new TArray((array)$this->settings->channel);
    }


  }//end public function interpretRequest */

} // end class WebfrapMessage_Table_Search_Request */

