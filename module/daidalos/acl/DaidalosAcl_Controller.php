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
 */
class DaidalosAcl_Controller extends Controller
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var string
   */
  protected $callAble = array
  (
    'form',
    'updateacl',
    'deactivateallusers',
  );


/*//////////////////////////////////////////////////////////////////////////////
//Logic: Meta Model
//////////////////////////////////////////////////////////////////////////////*/


  /**
   *
   */
  public function form( $params = null )
  {

    $params = $this->getFlags( $this->getRequest() );

    $view   = $response->loadView('wgt-view-daidalos_acl-form', 'DaidalosAcl');

    $model  = $this->loadModel('DaidalosAcl');

    $view->setModel( $model );
    $view->displayForm( $params );

  }//end public function form */

  /**
   *
   */
  public function updateAcl( $params = null )
  {

    $params = $this->getFlags( $this->getRequest() );

    $model  = $this->loadModel('DaidalosAcl');
    $model->updateArea( $this->getRequest() );

  }//end public function updateAcl */

  /**
   *
   */
  public function deactivateAllUsers( $params = null )
  {

    $response = $this->getResponse();
    $params   = $this->getFlags( $this->getRequest() );
    $model    = $this->loadModel('DaidalosAcl');

    $model->dissableAllUsers();

    $response->addMessage( 'Dissabled all Users' );

  }//end public function deactivateAllUsers */




}//end class DaidalosAcl_Controller

