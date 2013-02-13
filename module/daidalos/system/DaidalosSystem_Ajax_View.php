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
 */
class DaidalosSystem_Ajax_View
  extends LibTemplateAjaxView
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * automcomplete for the user roles
   *
   * inject the search result from the autocomplete request as json in the view
   * the view will answer as a normal ajax / xml request but embed the
   * json data as data package, which will be returned in the browser from the
   * calling request method
   *
   * @param string $key the search key from the autocomplete field
   * @param TArray $params useriput / controll flags
   *
   * @return void
   */
  public function displayAutocomplete(  $key, $params )
  {

    $view = $this->getTplEngine();
    $view->setRawJsonData( $this->model->getUsersByKey( $key, $params) );

  }//end public function displayAutocomplete */



} // end class DaidalosSystem_Ajax_View

