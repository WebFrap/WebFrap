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
class WebfrapCalendar_Controller extends Controller
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
    'display'
  );

  /**
   * Name of the default action
   *
   * @var string
   */
  protected $defaultAction = 'display';

/*//////////////////////////////////////////////////////////////////////////////
// Methoden
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return void
   */
  public function display( )
  {

    if(!$this->view->isType( View::SUBWINDOW ))
    {
      $this->errorPage('Invalid Request');
    }

    $view = $this->view->newWindow('WebfrapMainMenu', 'Default');
    //$view->setTitle('Calendar');

    $view->setTemplate( 'base/calendar' );

  }//end public function display */



}//end class ControllerWebfrapCalendar

