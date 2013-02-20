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
class WebfrapIssue_Controller extends Controller
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
    'form',
  );

  /**
   * Name of the default action
   *
   * @var string
   */
  protected $defaultAction = 'form';

/*//////////////////////////////////////////////////////////////////////////////
// Methoden
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return void
   */
  public function form( )
  {

    if (!$this->view->isType( View::WINDOW )) {
      $this->errorPage('Invalid Request');
    }

    $view = $this->view->newWindow('WbfSysHelp', 'Default');
    $view->setTitle('Help System');

    $view->setTemplate( 'base/issue/form' );

    $button = $view->newButton('save');
    $button->text = 'send report';
    $button->class = 'save';

  }//end public function form */

}//end class ControllerWebfrapIssue

