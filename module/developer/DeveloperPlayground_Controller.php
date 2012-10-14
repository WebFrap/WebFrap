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
class DeveloperPlayground_Controller
  extends Controller
{

  /**
   *
   * @var unknown_type
   */
  protected $defaultAction = 'play';

////////////////////////////////////////////////////////////////////////////////
// Der Controller
////////////////////////////////////////////////////////////////////////////////

  /**
   * @param string $action
   */
  public function run( $action = null )
  {

    if(!$this->checkAction( $action ))
      return;

    $func = $this->activAction;

    $this->$func(  );

  }//end public function run


////////////////////////////////////////////////////////////////////////////////
// Methoden
////////////////////////////////////////////////////////////////////////////////

  /**
   * @return void
   */
  public function html(  )
  {

    $key = $this->request->get( 'key' , Validator::CNAME );
    $key = str_replace('_','/',$key);

    $this->view->setTemplate('playground/'.$key );

  }//end public function html */


  /**
   * @return void
   */
  public function window( )
  {

    $key = $this->request->get( 'key' , Validator::CNAME );
    $key = str_replace('_','/',$key);

    $window = $this->view->newWindow( 'test' );

    $window->setTemplate('playground/'.$key );
    $window->setTitle('Payground Window');
    $window->setStatus('Payground Window');

  }//end public function window */


} // end class ControllerDeveloperPlayground

