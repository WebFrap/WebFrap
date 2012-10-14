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
class DeveloperStatus_Controller
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
  protected $defaultAction = 'allStats';

  /**
   *
   * @var array
   */
  protected $callAble           = array
  (
    'allstats'
  );

////////////////////////////////////////////////////////////////////////////////
// Methoden
////////////////////////////////////////////////////////////////////////////////

  /**
   * @return void
   */
  public function allStats( )
  {

    if( $this->view->isType( View::WINDOW ) )
    {
      $view = $this->view->newWindow('WebfrapStatusMonitor', 'Default');
      $view->setStatus('Status Monitor');
    }
    else
    {
      $view = $this->view;
    }

    $view->setTemplate( 'daidalos/dump_status'  );

    $user = $this->getUser();
    $view->addVar( 'userStatus' , $user->getData() );


  } // end public function allStats


} // end class MexDeveloperStatus

