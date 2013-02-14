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
 * @subpackage Core
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class WebfrapSearch_Controller extends Controller
{

  
  /**
   * Die Options zum definieren der Zugriffsparameter
   * @var array
   */
  protected $options           = array
  (
    'search' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'ajax' )
    ),
  );
  
/*//////////////////////////////////////////////////////////////////////////////
// Base Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_search( $request, $response )
  {
      
    /* @var WebfrapSearch_Model */
    $model = $this->loadModel( 'WebfrapSearch' );
    
    /* @var WebfrapSearch_Ajax_View */
    $view  = $response->loadView
    ( 
      'webfrap-search-request', 
      'WebfrapSearch',
      'displaySearch' 
    );
    
    $view->setModel( $model );
    
    $model->parseRequest( $request );
    
    $view->displaySearch( $request->param( 'element', Validator::CKEY ) );
  
  }//end public function service_search */


} // end class WebfrapSearch_Controller


