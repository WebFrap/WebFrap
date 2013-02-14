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
class WebfrapDashboard_Controller extends Controller
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/
  
  /**
   * Mit den Options wird der zugriff auf die Service Methoden konfiguriert
   * 
   * @var array
   */
  protected $options           = array
  (
    'dashboard' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'html' )
    ),
    'reloadquiklinks' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'ajax' )
    ),
    'reloadbookmarks' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'ajax' )
    ),
    'reloadlastvisited' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'ajax' )
    ),
    'reloadmostvisited' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'ajax' )
    ),
    'reloaddesktop' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'ajax' )
    ),
  );

/*//////////////////////////////////////////////////////////////////////////////
// Methoden
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param LibRequestHttp $request
   * @param LibResonseHttp $response
   * @return void
   */
  public function service_dashboard( $request, $response )
  {

    $view = $this->view;

    $selectWidget = $view->newInput( 'selectWidget' , 'SelectboxCmsMashupWidget'  );
    $selectWidget->addAttributes
    (array(
    'class' => 'medium'
    ));


    $mashup = $view->addItem( 'dashboard' , 'Mashup' );
    $mashup->where = ' id_owner = '.User::getActive()->getId();

    $view->setTitle('Dashboard');
    $view->setTemplate( 'mashup' , 'webfrap' );

  } // end public function service_dashboard */

  
  /**
   * @param LibRequestHttp $request
   * @param LibResonseHttp $response
   * @return void
   */
  public function service_reloadQuikLinks( $request, $response )
  {

    // laden der passenden subview
    $view = $response->loadView
    (
      'webfrap_desktop_reload_quik_links',
      'WebfrapDashboard',
      'displayReloadQuikLinks',
      null,
      true
    );
    
    $model = $this->loadModel( 'WebfrapDashboard' );
    
    $view->setModel( $model );
    
    $view->displayReloadQuikLinks();

  } // end public function service_reloadQuikLinks */
  

  
} // end class WebfrapDashboard_Controller


