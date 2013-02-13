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
class DaidalosSync_Controller
  extends Controller
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @var unknown_type
   */
  protected $callAble = array
  (
    'listing',
    'sync',
  );


  /**
   * @return void
   */
  public function listing( )
  {

    if( $this->tplEngine->isType( View::WINDOW ) )
    {
      $view = $this->tplEngine->newWindow('DaidalosSync', 'DaidalosSync');
    }
    else
    {
      $view = $this->tplEngine;
    }

    $model = $this->loadModel('DaidalosProjects');
    $view->setModel( $model );

    $params = $this->getFlags( $this->getRequest() );

    $view->displayListing( $params );

  } // end public function listing */


  /**
   * @return void
   */
  public function syncAll( )
  {

    $model = $this->loadModel('DaidalosProjects');
    $params = $this->getFlags( $this->getRequest() );


  } // end public function syncAll */

  /**
   * @return void
   */
  public function sync( )
  {

    $model = $this->loadModel('DaidalosProjects');
    $params = $this->getFlags( $this->getRequest() );

  } // end public function sync


  /**
   * @return void
   */
  public function syncRepo( )
  {

    $model = $this->loadModel('DaidalosProjects');
    $params = $this->getFlags( $this->getRequest() );


  } // end public function sync */

}//end class DaidalosSync_Controller

