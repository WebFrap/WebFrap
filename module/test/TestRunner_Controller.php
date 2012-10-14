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
 *
 * @package WebFrap
 * @subpackage Core
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class TestRunner_Controller
  extends Controller
{

  /**
   *
   * Enter description here ...
   * @var array
   */
  protected $callAble = array
  (
    'help',
    'folder',
    'file',
  );

/*//////////////////////////////////////////////////////////////////////////////
// methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   */
  public function folder()
  {

    $view   = $response->loadView('test-report', 'TestRunner');
    $model  = $this->loadModel('TestRunner');
    $view->setModel( $model );

    $request = $this->getRequest();

    if( $folder = $request->param( 'folder', Validator::TEXT ) )
    {
      $view->displayFolder($folder);
    }

    return true;

  }//end public function folder */

  /**
   *
   */
  public function file()
  {

    $view   = $response->loadView('test-report', 'TestRunner');
    $model  = $this->loadModel('TestRunner');
    $view->setModel($model);

    $request = $this->getRequest();


    if( $file = $request->param( 'file', Validator::TEXT ) )
    {
      $view->displayFile( $file );
    }

    return true;

  }//end public function file */

  /**
   *
   */
  public function help()
  {

    $view   = $response->loadView('test-help', 'TestRunner');
    $view->displayHelp();

  }//end public function help */

}// end class Test_Controller

