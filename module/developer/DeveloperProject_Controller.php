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
 * @subpackage Developer
 */
class DeveloperBase_Controller
  extends Controller
{



  protected $defaultAction = 'modmenu';




////////////////////////////////////////////////////////////////////////////////
// Methoden
////////////////////////////////////////////////////////////////////////////////

  /**
   * @return void
   */
  public function modMenu( )
  {

    if( $this->view->isType( View::WINDOW ) )
    {
      $view = $this->view->newWindow('WebfrapMainMenu', 'Default');
      $view->setTitle('Blog Menu');
    }
    else
    {
      $view = $this->view;
    }

    $crumbMenu =  $view->newItem('modMenuCrumb','MenuCrumbmenu');
    $crumb = $crumbMenu->addEntry
    (
      'Menu' ,
      'maintab.php?mod=Webfrap&mex=Base&do=modMenu&amp;menu=false',
      'ajax_window'
    );
    $crumb->icon = 'webfrap/webfrap.gif';

    $crumb = $crumbMenu->addEntry
    (
      'Developer Menu' ,
      'maintab.php?mod=Developer&mex=Base&do=modMenu&amp;menu=false',
      'ajax_window'
    );
    $crumb->icon = 'webfrap/webfrap.gif';

    $view->setTemplate( 'MenuModmenuCrumb' , 'webfrap' );

    $modMenu = $view->newItem('modMenu' ,'MenuDeveloperModmenu');

  } // end public function modMenu


} // end class MexDeveloperBase

