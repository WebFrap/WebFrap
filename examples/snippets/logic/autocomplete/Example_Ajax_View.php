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
 * Exception to throw if you want to throw an unspecific Exception inside the
 * bussines logic.
 * If you don't catch it it will be catched by the system and you will get an
 * Error Screen Inside the Applikation.
 *
 * @package WebFrap
 * @subpackage Example
 */
class Example_Ajax_View extends LibTemplateAjaxView
{
/*//////////////////////////////////////////////////////////////////////////////
// display methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $key
   * @param TArray $params
   */
  public function displayAutocomplete($key, $params)
  {

    $view = $this->getTpl();
    $view->setRawJsonData($this->model->getAutolistByKey($key, $params));

  }//end public function displayAutocomplete */

}//end class Example_Ajax_View

