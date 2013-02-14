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
 * @subpackage ModDeveloper
 */
class DeveloperBase_Controller extends Controller
{

  protected $defaultAction = 'menu';


  protected $callAble = array
  (
    'menu','sandbox'
  );



/*//////////////////////////////////////////////////////////////////////////////
// Methoden
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return void
   */
  public function menu( )
  {

    if( $this->view->isType( View::WINDOW ) )
    {
      $view = $this->view->newWindow('WebfrapMainMenu', 'Default');

      $view->setStatus('Developer Tools');
    }
    else
    {
      $view = $this->view;
    }

    $view->setTitle('Menu Developer Tools');
    $view->setTemplate( 'webfrap/menu/modmenu' );

    $menuName = $this->request->get('menu',Validator::CNAME);

    if (!$menuName )
      $menuName = 'default';

    $modMenu = $view->newItem( 'modMenu', 'MenuFolder' );
    $modMenu->setData( DaoFoldermenu::get( 'daidalos/'.$menuName, true ) );

  }//end public function menu */


  /**
   * @return void
   */
  public function sandbox( )
  {

    if( $this->view->isType( View::WINDOW ) )
    {
      $view = $this->view->newWindow('WbfDevSandbox', 'Default');
    }
    else
    {
      $view = $this->view;
    }

    $view->setTitle('Sandbox');

    $template = $this->request->get('key','text');

    $view->setTemplate( 'sandbox/'.str_replace('.','/',$template));

  } // end public function sandbox


} // end class DeveloperBase_Controller

