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
 * @subpackage Maintenance
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class WebfrapDataConnector_Controller extends Controller
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var array
   */
  protected $options = array(
    'form' => array(
      'method'    => array('GET'),
      'views'      => array('modal')
    ),
    'selection' => array(
      'method'    => array('GET'),
      'views'      => array('modal')
    ),
  );

/*//////////////////////////////////////////////////////////////////////////////
// Methoden
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_form($request, $response)
  {

    ///@trows InvalidRequest_Exception
    $view = $response->loadView(
      'webfrap-data-connector-form',
      'WebfrapDataConnector' ,
      'displayForm'
    );

    $view->displayForm();

  }//end public function service_form */
  
  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_selection($request, $response)
  {

    ///@trows InvalidRequest_Exception
    $view = $response->loadView(
      'webfrap-data-connector-selection',
      'WebfrapDataConnector' ,
      'displaySelection'
    );

    $view->displaySelection();

  }//end public function service_form */

}//end class WebfrapDataConnector_Controller

