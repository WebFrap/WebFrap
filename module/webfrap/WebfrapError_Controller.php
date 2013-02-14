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
class WebfrapError_Controller extends Controller
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
    'lastphperror'
  );

  /**
   * Name of the default action
   *
   * @var string
   */
  protected $defaultAction = 'lastphperror';

/*//////////////////////////////////////////////////////////////////////////////
// Methoden
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return void
   */
  public function lastPhpError( )
  {

    if (!$this->view->isType( View::SUBWINDOW ))
    {
      $this->invalidRequest();
      return false;
    }

    $view = $this->view->newWindow('WebfrapLastError', 'Default');
    $view->setTitle('Last PHP Error');

    $view->setTemplate( 'error/last_error' );
    $view->addVar( 'errorData' , file_get_contents( PATH_GW.'log/first_log.html' ) );

  }//end public function lastPhpError */



}//end class ControllerWebfrapEditor

