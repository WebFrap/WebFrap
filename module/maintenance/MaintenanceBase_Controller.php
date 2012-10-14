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
class MaintenanceBase_Controller
  extends Controller
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * list with all callable methodes in this subcontroller
   *
   * @var array
   */
  protected $callAble = array
  (
    'menu',
    'message',
    'showstatus'
  );


////////////////////////////////////////////////////////////////////////////////
// Methoden
////////////////////////////////////////////////////////////////////////////////


  /**
   * @return void
   */
  public function menu( )
  {

    if( $this->view->isType( View::SUBWINDOW ) )
    {
      $view = $this->view->newWindow('WebfrapMainMenu', 'Default');
    }
    if( $this->view->isType( View::MAINTAB ) )
    {
      $view = $this->view->newMaintab('WebfrapMainMenu', 'Default');
      $view->setLabel('Explorer');
    }
    else
    {
      $view = $this->view;
    }


    $view->setTitle('Maintenance Menu');

    $view->setTemplate( 'webfrap/menu/modmenu' );

    $menuName = $this->request->get('menu',Validator::CNAME);

    if( !$menuName )
      $menuName = 'default';

    $modMenu = $view->newItem( 'modMenu', 'MenuFolder' );
    $modMenu->setData( DaoFoldermenu::get( 'maintenance/'.$menuName, true ) );

  }//end public function menu */


  /**
   * @return void
   */
  public function showStatus( )
  {

    if( $this->view->isType( View::SUBWINDOW ) )
    {
      $view = $this->view->newWindow('WebfrapMainMenu', 'Default');
      $view->setTitle('Maintenance Menu');
    }
    else
    {
      $view = $this->view;
    }

    $view->setTemplate( 'maintenance/show_status' );

  }//end public function showStatus */

  /**
   * @return void
   */
  public function message( )
  {

    if( $this->view->isType( View::SUBWINDOW ) )
    {
      $view = $this->view->newWindow('WebfrapMainMenu', 'Default');
      $view->setTitle('Maintenance Menu');
    }
    else
    {
      $view = $this->view;
      $view->setIndex('maintenance');
    }

    $user     = $this->getUser();
    $profile  = $user->getProfile();


    // panel
    $view->addVar('desktopPanel',     $profile->getPanel() );

    // panel
    $view->addVar('desktopNavigation',     $profile->getNavigation() );


    $view->setTemplate( 'maintenance/message' );

  }//end public function message */

}//end class MaintenanceBase_Controller

