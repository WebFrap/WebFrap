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
   * Mit den Options wird der zugriff auf die Service Methoden konfiguriert
   *
   * @var array
   */
  protected $options           = array
  (
    'display' => array
    (
      'method'    => array( 'GET', 'POST' ),
      'views'      => array( 'html' )
    ),
    'displaysimple' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'html' )
    ),
    'dropmenu' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'html' )
    ),
  );

////////////////////////////////////////////////////////////////////////////////
// Methoden
////////////////////////////////////////////////////////////////////////////////

  /**
   * default method for creating the desktop
   * @return void
   */
  public function service_display( $request, $response )
  {

    $view = $this->getView();
    $view->setTitle('Desktop');

    $conf = Conf::get('view');
    $view->setHtmlHead( $conf['head.user'] );

    $profile = $this->getUser()->getProfile();

    $view->menu = $profile->getNavigation();

    $profile->getDesktop()->display( $view );

  } // end public function service_display */

  /**
   * default method for creating the desktop
   * @return void
   */
  public function service_refresh( $request, $response )
  {

    $tpl = $this->getTpl();
    $tpl->setTitle( 'Desktop' );

    $area = $tpl->newArea( 'wgt-ui-desktop' );
    $area->position = '#wgt-ui-desktop';
    $area->action = 'html';

    $profile = $this->getUser()->getProfile();
    $profile->getDesktop()->display( $area );

    $tpl->setJsonData( time() );

  } // end public function service_refresh */


  /**
   * default method for creating the desktop
   * @return void
   */
  public function service_dropmenu( $request, $response )
  {

    $view = $this->getView();
    $view->setTitle('Desktop');

    $conf = Conf::get('view');
    $view->setHtmlHead( $conf['head.user'] );

    $profile = $this->getUser()->getProfile();

    $view->menu = $profile->getNavigation();

    $profile->getDesktop()->display( $view );

  } // end public function service_dropmenu */

  /**
   * default method for creating the desktop
   * @return void
   */
  public function service_displaySimple(  $request, $response  )
  {

    if( !$view )
    {
      $view = $this->view;
    }

    $view->setTitle('Desktop');
    $view->setTemplate( 'webfrap/desktop_simple'  );

  } // end public function service_displaySimple */

} // end class WebfrapDesktop_Controller


