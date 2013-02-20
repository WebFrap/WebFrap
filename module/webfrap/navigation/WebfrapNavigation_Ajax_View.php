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
class WebfrapNavigation_Ajax_View extends LibTemplatePlain
{
/*//////////////////////////////////////////////////////////////////////////////
// display methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $key
   * @param TArray $params
   */
  public function displayAutocomplete($key, $params )
  {

    $view = $this->getTplEngine();
    $view->setRawJsonData($this->model->searchEntriesAutocomplete($key, $params ) );

  }//end public function displayAutocomplete */

  /**
   * @param string $key
   * @param LibSqlQuery $data
   * @param TArray $params
   */
  public function displayNavlist($key, $data, $params )
  {

  }//end public function displayNavlist */

} // end class Webfrap_Navigation_Ajax_View */

