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
class MyBase_Controller
  extends Controller
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * list with all callable methodes in this subcontroller
   *
   * @var array
   */
  protected $callAble = array
  (
    'menu','persons'
  );

  /**
   * Name of the default action
   *
   * @var string
   */
  protected $defaultAction = 'menu';

/*//////////////////////////////////////////////////////////////////////////////
// Methoden
//////////////////////////////////////////////////////////////////////////////*/


  /**
   * @return void
   */
  public function menu( )
  {

    if( $this->view->isType( View::SUBWINDOW ) )
    {
      $view = $this->view->newWindow('WebfrapMainMenu', 'Default');
      $view->setTitle('Reports');
    }
    else
    {
      $view = $this->view;
    }

    $view->setTemplate( 'webfrap/menu/modmenu'  );

    $modMenu = $view->newItem( 'modMenu', 'MenuFolder'  );
    $modMenu->setData( DaoFoldermenu::get('report/overview',true) );

  } // end public function menu */

/*//////////////////////////////////////////////////////////////////////////////
// reports
//////////////////////////////////////////////////////////////////////////////*/


  /**
   * @return void
   */
  public function persons( )
  {

    if( $this->view->isType( View::SUBWINDOW ) )
    {
      $view = $this->view->newWindow('ReportDisplay', 'Default');
      $view->setTitle('Person Reports');
      $view->setModel( $this->model );
    }
    else
    {
      $view = $this->view;
    }

    $view->setTemplate( 'report/base/persons'  );


  } // end public function menu */


}//end class MyBase_Controller

