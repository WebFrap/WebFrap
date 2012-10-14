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
class WebfrapAdmin_Controller
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
    'menu'
  );

  /**
   * Name of the default action
   *
   * @var string
   */
  protected $defaultAction = 'menu';

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
      $view->setTitle('Admin Main Menu');
    }
    else
    {
      $view = $this->view;
    }

    $view->setTemplate( 'webfrap/modmenu' );

    $modMenu = $view->newItem( 'modMenu', 'MenuFolder'  );
    $modMenu->setData( DaoFoldermenu::get('webfrap/admin',true) );

  } // end public function menu */



}//end class ControllerAdminBase

