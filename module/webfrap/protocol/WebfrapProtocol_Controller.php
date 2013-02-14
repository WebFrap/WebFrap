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
class WebfrapProtocol_Controller extends Controller
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

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

/*//////////////////////////////////////////////////////////////////////////////
// Base Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_overlayDset($request, $response )
  {

    $dKey     = $request->param('dkey', Validator::TEXT );
    $objid    = $request->param('objid', Validator::EID );

    /* @var $view WebfrapProtocol_Ajax_View  */
    $view = $response->loadView
    (
    	'webfrap-protocol-dset',
    	'WebfrapProtocol',
    	'displayOverlay'
    );

    /* @var $model WebfrapProtocol_Model */
    $model = $this->loadModel( 'WebfrapProtocol' );

    $view->setModel($model );
    $view->displayOverlay($dKey, $objid );


  }//end public function service_overlayDset */


} // end class WebfrapProtocol_Controller


