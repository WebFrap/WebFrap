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
class WebfrapHistory_Controller
  extends Controller
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @var array
   */
  protected $options           = array
  (
    'overlaydset' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'ajax' )
    ),
  );

////////////////////////////////////////////////////////////////////////////////
// Base Methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_overlayDset( $request, $response )
  {

    $element  = $request->param( 'element', Validator::EID );
    $dKey     = $request->param( 'dkey', Validator::TEXT );
    $objid    = $request->param( 'objid', Validator::EID );

    /* @var $view WebfrapHistory_Ajax_View  */
    $view = $response->loadView
    (
    	'webfrap-history-dset',
    	'WebfrapHistory',
    	'displayOverlay'
    );

    /* @var $model WebfrapHistory_Model */
    $model = $this->loadModel( 'WebfrapHistory' );

    $view->setModel( $model );
    $view->displayOverlay( $element, $dKey, $objid );


  }//end public function service_overlayDset */


} // end class WebfrapHistory_Controller


