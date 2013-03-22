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
class ImportExample_Csv_Controller extends Controller
{
/*//////////////////////////////////////////////////////////////////////////////
// Methoden
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param LibRequestHttp
   * @param LibResponseHttp
   * @return void
   */
  public function service_import($request, $response)
  {

    $params = $this->getFlags($request);

    $view = $this->view->newWindow
    (
      'import-example-csv',
      'ImportExample_Csv'
    );

    $model = $this->loadModel('ImportExample_Csv');
    $model->import();

    $view->setModel($model);

    $view->displayStats($params);

  }//end public function service_import */

}//end class ImportExample_Csv_Controller

