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
class WebfrapTask_Controller
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
    'table',
  );

  /**
   * Name of the default action
   *
   * @var string
   */
  protected $defaultAction = 'overview';

////////////////////////////////////////////////////////////////////////////////
// Methoden
////////////////////////////////////////////////////////////////////////////////

  /**
   * @return void
   */
  public function table( )
  {

    if(!$this->view->isType( View::SUBWINDOW ))
    {
      $this->errorPage('Invalid Request');
    }

    $view = $this->view->newWindow('WebfrapMessages', 'Default');
    $view->setTitle('Message System');

    $view->setTemplate( 'base/task/overview' );


    $menu = $view->newMenu('test_menu');
    $menu->content = <<<CODE
<ul class="wgt-dropmenu" id="theWindowMenu" style="z-index:500;height:16px;"  >
  <li>
    <a href="#" style="height:10px;padding:4px;border:1px solid #003466;color:#003466;background-color:#DCDCDC;margin-right:5px;" >menu</a>
    <ul style="margin-top:-10px;" >
      <li class="current">
        <a class="wcm wcm_req_ajax" href="modal.php?c=Webfrap.Task.create" >new task</a>
      </li>
      <li>
        <a href="#" >send reminders</a>
      </li>
      <li>
        <a href="#" >statistics</a>
      </li>
    </ul>
  </li>
</ul>
CODE;


    $button = $view->newButton('new_task');
    $button->text = 'new task';
    $button->class = 'new_task';

    $code = <<<CODE
    self.getObject().find(".new_task").click(function()
    {
      \$R.get('modal.php?c=Webfrap.Task.create');
    });

CODE;

    $view->addJsCode($code);


    $this->model->loadTasks( $view );


  }//end public function table */



}//end class ControllerWebfrapMessage

