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
    'search' => array(
      'method'    => array('GET'),
      'views'      => array('ajax')
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

  }//end public function service_selection */
  
  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_search($request, $response)
  {

    ///@throws InvalidRequest_Exception
    /* @var $model WebfrapDataConnector_Ajax_View */
    $view = $response->loadView(
      'webfrap-data-connector-search',
      'WebfrapDataConnector' ,
      'displaySearch'
    );
    
    $searchReq = new WebfrapDataConnector_Search_Request($request);
    
    /* @var $model WebfrapDataConnector_Model */
    $model = $this->loadModel('WebfrapDataConnector');
    $view->model = $model;
    $view->displaySearch( $searchReq );

  }//end public function service_search */

}//end class WebfrapDataConnector_Controller

