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
 * @subpackage ModDeveloper
 */
class DeveloperBuilder_Controller
  extends Controller
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * the default Action this action will be called there is noch
   * action in the request
   * @var string
   */
  protected $defaultAction = 'keymappbuilder';

  protected $callAble = array('keymappbuilder');

////////////////////////////////////////////////////////////////////////////////
// Methoden
////////////////////////////////////////////////////////////////////////////////

  /**
   * @return void
   */
  public function keymappBuilder( )
  {

    if( $this->view->isType( View::WINDOW ) || $this->view->isType( View::AJAX )  )
    {
      View::$sendMenu = false;
      $view = $this->view->newWindow('DumpWindow', 'Default' );
    }
    else
    {
      $view = $this->view;
    }

    $view->setTemplate( 'BuildPostKeyMap' , 'developer' );

  } // end public function keymappBuilder( )


} // end class DeveloperBuilder_Controller

