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
class WebfrapDesktop_Controller
  extends Controller
{
////////////////////////////////////////////////////////////////////////////////
// Parent Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @var string
   */
  protected $defaultAction = 'desktop';

  /**
   * all callable methodes
   *
   * @var array
   */
  protected $callAble = array
  (
    'display',
    'displaysimple',
    'dropmenu',
  );


////////////////////////////////////////////////////////////////////////////////
// Methoden
////////////////////////////////////////////////////////////////////////////////

  /**
   * default method for creating the desktop
   * @return void
   */
  public function display()
  {

    $view = $this->getView();
    $view->setTitle('Desktop');

    $conf = Conf::get('view');
    $view->setHtmlHead( $conf['head.user'] );

    $profile = $this->getUser()->getProfile();

    $view->menu = $profile->getNavigation();

    $profile->getDesktop()->display( $view );

  } // end public function display */
  
  
  /**
   * default method for creating the desktop
   * @return void
   */
  public function dropmenu()
  {

    $view = $this->getView();
    $view->setTitle('Desktop');

    $conf = Conf::get('view');
    $view->setHtmlHead( $conf['head.user'] );

    $profile = $this->getUser()->getProfile();

    $view->menu = $profile->getNavigation();

    $profile->getDesktop()->display( $view );

  } // end public function dropmenu */

  /**
   * default method for creating the desktop
   * @return void
   */
  public function displaySimple( $view = null )
  {

    if(!$view)
    {
      $view = $this->view;
    }

    $view->setTitle('Desktop');
    $view->setTemplate( 'webfrap/desktop_simple'  );

  } // end public function displaySimple */

} // end class ControllerWebfrapDesktop


