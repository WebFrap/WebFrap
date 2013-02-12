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
 * @author Dominik Bonsch
 * @copyright Dominik Bonsch <dominik.bonsch@webfrap.net>
 */
class WebfrapSetup_Controller
  extends Controller
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   *
   * @var boolean
   */
  protected $fullAccess = true;
  
  /**
   * array with the actions that can be access without be loggedin
   * @var array
   */
  protected $publicAccess       = array
  (
  'start',
  );

  /**
   * Enter description here...
   *
   * @var array
   */
  protected $callAble = array
  (
  'start',
  );

////////////////////////////////////////////////////////////////////////////////
// The Controller and Init
////////////////////////////////////////////////////////////////////////////////

  /**
   *
   * @return void
   */
  public function start( $params = null )
  {

    $view = $response->loadView( 'startPage', 'WebfrapSetup' );

    $params = $this->getFlags( $this->getRequest() );

    $view->displayStart( $params );

  }//end public function start */



} // end class WebfrapSetup_Controller


