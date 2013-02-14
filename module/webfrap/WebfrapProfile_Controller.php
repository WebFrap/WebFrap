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
class WebfrapProfile_Controller extends Controller
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
    'display',
    'save_profile',
    'settings',
    'save_setting',
    'change',
  );

/*//////////////////////////////////////////////////////////////////////////////
// Methoden
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return void
   */
  public function change( )
  {

    $user = $this->getUser();

    $profile = $this->getRequest()->param('profile',Validator::CNAME);

    if(!$profile)
      $profile = $this->getRequest()->data('profile',Validator::CNAME);

    if($profile)
      $user->switchProfile($profile);

    $flow = Webfrap::getInstance();
    $flow->redirectToDefault();

  }//end public function display */

  /**
   * @return void
   */
  public function display( )
  {

    if(!$this->view->isType( View::WINDOW ))
    {
      $this->errorPage('Invalid Request');
    }

    $view = $this->view->newWindow('WbfsysProfile', 'Default');
    $view->setTitle('my profile');

    $button = $view->newButton('save');
    $button->text = 'save';
    $button->class = 'save';

    $view->setTemplate( 'base/profile' );


  }//end public function display */


  /**
   * @return void
   */
  public function settings( )
  {

    if(!$this->view->isType( View::WINDOW ))
    {
      $this->errorPage('Invalid Request');
    }

    $view = $this->view->newWindow('WbfsysProfile', 'Default');
    $view->setTitle('my settings');

    $button = $view->newButton('save');
    $button->text = 'save';
    $button->class = 'save';

    $view->setTemplate( 'base/settings' );


  }//end public function display */


}//end class ControllerWebfrapProfile

