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
class WebfrapBase_Controller
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
    'about','welcome','menu','desktop','playground'
  );

  /**
   * Name of the default action
   *
   * @var string
   */
  protected $defaultAction = 'about';

////////////////////////////////////////////////////////////////////////////////
// Methoden
////////////////////////////////////////////////////////////////////////////////

  /**
   * @return void
   */
  public function welcome( )
  {

    //$this->view->setIndex('default_plain');
    $this->view->setTemplate( 'webfrap/welcome' );

  }//end public function welcome */

  /**
   * @return void
   */
  public function about( )
  {

    if(!$this->view->isType( View::SUBWINDOW ))
    {
      $this->errorPage('Invalid Request');
      return false;
    }

    $view = $this->view->newWindow('WbfsysWindow', 'Default');
    //$view->setTitle('Calendar');

    $view->setTemplate( 'base/about_layer' );

  }//end public function about */

  /**
   * @return void
   */
  public function menu( )
  {

    if( $this->view->isType( View::SUBWINDOW ) )
    {
      $view = $this->view->newWindow('WebfrapMainMenu', 'Default');
    }
    else  if( $this->view->isType( View::MAINTAB ) )
    {
      $view = $this->view->newMaintab('WebfrapMainMenu', 'Default');
      $view->setLabel('Explorer');
    }
    else
    {
      $view = $this->view;
    }

    $view->setTitle('Webfrap Main Menu');

    $view->setTemplate( 'webfrap/menu/modmenu'  );

    $modMenu = $view->newItem( 'modMenu', 'MenuFolder'  );
    $modMenu->setData( DaoFoldermenu::get('webfrap/root',true) );

  } // end public function menu */


  /**
   * @return void
   */
  public function playground( )
  {

    $request = $this->getRequest();

    $template = $request->paramExists('template')?
      $request->param('template',Validator::CNAME)
      :'def';

    $this->view->setTitle('Welcome to Webfrap');
    $this->view->setTemplate( 'playground/'.$template );

  } // end public function playground */


}//end class ControllerWebfrapBase

