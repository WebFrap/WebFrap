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
 * @subpackage Core
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class WebfrapContext_Controller extends Controller
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var array
   */
  protected $options           = array(
    'set' => array(
      'method'    => array('PUT'),
      'views'      => array('ajax')
    ),
    'reset' => array(
      'method'    => array('PUT'),
      'views'      => array('ajax')
    ),
    'resetall' => array(
      'method'    => array('PUT'),
      'views'      => array('ajax')
    ),
  );

/*//////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////*/

 /**
  * @param LibRequestHttp $request
  * @param LibResponseHttp $response
  * @return boolean
  */
  public function service_set($request, $response)
  {

    $request = $this->getRequest();
    $session = $this->getSession();

    $contextKey = $request->param('key',Validator::CKEY);
    $contextID = $request->param('id',Validator::INT);

    $session->setContext($contextKey, $contextID);

  }//end public function service_set */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return boolean
   */
  public function service_reset($request, $response)
  {

  	$request = $this->getRequest();
  	$session = $this->getSession();

    $contextKey = $request->param('key',Validator::CKEY);
  	$session->resetContext($contextKey);

  }//end public function service_reseset */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return boolean
   */
  public function service_resetall($request, $response)
  {

  	$request = $this->getRequest();
  	$session = $this->getSession();
  	$session->resetAllContexts();

  }//end public function service_reseset */

} // end class WebfrapContext_Controller

