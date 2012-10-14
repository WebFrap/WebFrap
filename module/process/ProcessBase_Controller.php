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
class ProcessBase_Controller
  extends Controller
{
////////////////////////////////////////////////////////////////////////////////
// Methoden
////////////////////////////////////////////////////////////////////////////////


  /**
   * @return void
   */
  public function service_showHistory( $request, $response )
  {

    $request  = $this->getRequest();
    $response = $this->getResponse();


    $processId = $request->param( 'process', Validator::INT  );
    $objid     = $request->param( 'objid', Validator::INT  );
    $entity    = $request->param( 'entity', Validator::CNAME  );

    $view = $response->loadView
    (
      'process-base-history',
      'ProcessBase',
      'displayHistory'
    );

    $params = $this->getFlags( $request );

    $model = $this->loadModel( 'ProcessBase' );
    $model->loadEntity( $entity, $objid );
    $model->setProcessId( $processId );

    $view->setModel( $model );

    $view->displayHistory( $processId, $params );


  }//end public function showHistory */




}//end class ProcessBase_Controller

