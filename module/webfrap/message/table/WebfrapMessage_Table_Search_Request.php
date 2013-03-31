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
  
  public $order = array();

  /**
   * @param LibRequestHttp $request
   */
  public function __construct($request, $settings)
  {

    $this->filter = new TFlag();

    $filters = $request->param('filter', Validator::BOOLEAN);

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
    $this->conditions['free'] = $request->param('free_search', Validator::SEARCH);

    // die channels
    if ($request->paramExists('channel')){

      $channels = $request->paramList(
      	'channel',
        Validator::BOOLEAN,
        true
      );

      $this->settings->setChannel($channels->content());

      $this->conditions['filters']['channel'] = $channels;

    } else {

      if (count($this->settings->channels))
        $this->conditions['filters']['channel'] = new TArray((array)$this->settings->channels);
      else
        $this->conditions['filters']['channel'] = new TArray((array)array('inbox'=>true));
    }

    if ($request->paramExists('aspect')){

      $aspects = $request->param(
      	'aspect',
        Validator::INT
      );

      $this->settings->setAspects($aspects);

      $this->conditions['aspects'] = $aspects;

    } else {

      $this->conditions['aspects'] = isset($this->settings->aspects)
        ? $this->settings->aspects
        : array(1);
    }

    if ($request->paramExists('status')){

      $status = $request->paramList(
      	'status',
        Validator::BOOLEAN,
        true
      );

      $this->settings->setStatus($status->content());

      $this->conditions['filters']['status'] = $status;

    } else {

      $this->conditions['filters']['status'] = new TArray((array)$this->settings->status);
    }

    if ($request->paramExists('task_action')){

      $taskAction = $request->paramList(
      	'task_action',
        Validator::BOOLEAN,
        true
      );

      $this->settings->setTaskAction($taskAction->content());

      $this->conditions['filters']['task_action'] = $taskAction;

    } else {

      $this->conditions['filters']['task_action'] = new TArray((array)$this->settings->taskAction);
    }
    
    $this->conditions['order'] = array();

    // order by
    if ($title = $request->param('order', Validator::CNAME,'titel'))
      if ('' != trim($title))
        $this->conditions['order'][] = 'wbfsys_message.title '.('asc' == $title?'asc':'desc');
      
    if ($sender = $request->param('order', Validator::CNAME,'sender'))
      if ('' != trim($sender))
        $this->conditions['order'][] = 'sender.wbfsys_role_user_name '.('asc' == $sender?'asc':'desc');
      
    if ($receiver = $request->param('order', Validator::CNAME,'receiver'))
      if ('' != trim($receiver))
        $this->conditions['order'][] = 'receiver.wbfsys_role_user_name '.('asc' == $receiver?'asc':'desc');
      
    if ($date = $request->param('order', Validator::CNAME,'date'))
      if ('' != trim($date))
        $this->conditions['order'][] = 'wbfsys_message.m_time_created '.('asc' == $date?'asc':'desc');
      
    if ($priority = $request->param('order', Validator::CNAME,'priority'))
      if ('' != trim($priority))
        $this->conditions['order'][] = 'wbfsys_message.priority '.('asc' == $priority?'asc':'desc');


  }//end public function interpretRequest */

} // end class WebfrapMessage_Table_Search_Request */

