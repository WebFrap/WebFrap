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
class TestRunner_Controller extends Controller
{

  /**
   * @var array
   */
  protected $options           = array
  (
    'help' => array
    (
      'views'      => array('cli')
    ),
    'folder' => array
    (
      'views'      => array('cli')
    ),
    'file' => array
    (
      'views'      => array('cli')
    ),
  );

/*//////////////////////////////////////////////////////////////////////////////
// methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   */
  public function service_folder($request, $response)
  {

    $view   = $response->loadView('test-report', 'TestRunner');
    $model  = $this->loadModel('TestRunner');
    $view->setModel($model);

    if ($folder = $request->param('folder', Validator::TEXT)) {
      $view->displayFolder($folder);
    }

    return true;

  }//end public function folder */

  /**
   *
   */
  public function service_file($request, $response)
  {

    $view   = $response->loadView('test-report', 'TestRunner');
    $model  = $this->loadModel('TestRunner');
    $view->setModel($model);

    if ($file = $request->param('file', Validator::TEXT)) {
      $view->displayFile($file);
    }

    return true;

  }//end public function file */

  /**
   *
   */
  public function service_help($request, $response)
  {

    $view   = $response->loadView('test-help', 'TestRunner');
    $view->displayHelp();

  }//end public function help */

}// end class Test_Controller

