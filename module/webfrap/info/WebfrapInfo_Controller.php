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
class WebfrapInfo_Controller
  extends ControllerCrud
{
/*//////////////////////////////////////////////////////////////////////////////
// Methoden
//////////////////////////////////////////////////////////////////////////////*/


  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_legend( $request, $response )
  {

    
    $params = $this->getFlags( $request );
    
    // laden der passenden subview
    $view = $response->loadView
    (
      'webfrap_legend',
      'WebfrapInfo'
    );
    
    if( !$view )
    {
      return new Error
      ( 
        'The requested Viewtype not exists', 
        Response::NOT_IMPLEMENTED 
      );
    }

    $view->displayLegend( $params );
    
    return null;

  } // end public service_legend */
  
  

}//end class WebfrapInfo_Controller

