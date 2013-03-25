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
 * @subpackage ModExample
 * @author Dominik Bonsch <db@s-db.de>
 * @copyright Softwareentwicklung Dominik Bonsch <db@s-db.de>
 */
class ExampleQuery_Maintab_View extends WgtMaintab
{
/*//////////////////////////////////////////////////////////////////////////////
// methodes
//////////////////////////////////////////////////////////////////////////////*/

 /**
  * @param LibRequestPhp $request
  * @param LibResponseHttp $response
  * @param TFlag $params
  * @return null
  */
  public function displayQuery($request, $response, $params)
  {

    // set the window title
    $this->setTitle('Simple Query');
    $this->setLabel('Simple Query');

    // set the form template
    $this->setTemplate('example/query/simple');

    $this->addVar('data', $this->model->runQuery());

    return null;

  }//end public function displayQuery */

}//end class ExampleMessage_Menu_Maintab_View

