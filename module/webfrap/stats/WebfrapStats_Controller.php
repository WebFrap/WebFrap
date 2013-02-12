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
class WebfrapStats_Controller
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
    'open' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'maintab' )
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
  public function service_open( $request, $response )
  {

    $idContainer  = $request->param( 'container', Validator::EID );
    $nodeKey      = $request->param( 'node', Validator::TEXT );
    $objid        = $request->param( 'objid', Validator::EID );
    
    /* @var $view WebfrapKnowhowNode_Maintab_View  */
    $view = $response->loadView
    ( 
    	'know_how-node-form', 
    	'WebfrapKnowhowNode', 
    	'displayForm'
    );
    
    /* @var $model WebfrapKnowhowNode_Model */
    $model = $this->loadModel( 'WebfrapKnowhowNode' );
    
    if( $objid )
    {
      $model->loadNodeById( $objid );
    }
    elseif( $nodeKey )
    {
      $model->loadNodeByKey( $nodeKey, $idContainer );
    }
    
    $view->setModel( $model );
    $view->displayForm( $nodeKey, $idContainer );
    

  }//end public function service_open */



} // end class WebfrapStats_Controller


