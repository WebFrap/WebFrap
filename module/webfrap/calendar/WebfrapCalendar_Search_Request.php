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
class WebfrapCalendar_Search_Request extends ContextListing
{

  public $start = null;

  public $end = null;

  /**
   * Auswerten des Requests
   * @param LibRequestHttp $request
   */
  public function interpretRequest($request)
  {

    $this->extSearchValidator = new ValidSearchBuilder();
    parent::interpretRequest($request);

    $this->conditions = array();

    // search free
    $this->conditions['free'] = $request->param('free_search', Validator::SEARCH);

    $start = $request->param('start', Validator::INT);
    if(!$start)
      $start = time();
    $this->start = date('Y-m-d H:i:s',$start );

    $end = $request->param('end', Validator::INT);
    if(!$end)
      $end = time()+2678400; // + 31 tage... gehen wir mal davon aus + ein monat
    $this->end = date('Y-m-d H:i:s',$end );


  }//end public function interpretRequest */

} // end class WebfrapMessage_Table_Search_Request */

