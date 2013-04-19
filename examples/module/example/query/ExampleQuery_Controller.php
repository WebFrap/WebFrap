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
 * Dummy class for Extentions
 * This class will be loaded if the System requests for an Extention that
 * doesn't exist
 * @package WebFrap
 * @subpackage Core
 */
class ExampleQuery_Controller extends ControllerService
{
/*//////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////*/


  /**
   * @param LibRequestPhp $request
   * @param LibResponseHttp $response
   * @return boolean
   *
   * Is callable via: maintab.php?c=Example.Query.simpleQuery
   */
  public function service_simpleQuery($request, $response)
  {

    // extracts controll flow flags from the request
    $params   = $this->getFlags($request);

    // create a new subview object
    $view = $response->loadView('example_query-simple_query', 'ExampleQuery');

    // get the model
    $model = $this->loadModel('ExampleQuery');
    $view->setModel($model);

    // now the view hast to render the result
    $view->displayQuery($request, $response, $params);

  }//end public function service_simpleQuery */

} // end class ExampleQuery_Controller
