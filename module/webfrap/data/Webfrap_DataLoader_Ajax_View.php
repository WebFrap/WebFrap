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
 * Read before change:
 * It's not recommended to change this file inside a Mod or App Project.
 * If you want to change it copy it to a custom project.

 *
 * @package WebFrap
 * @subpackage Acl
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright webfrap.net <contact@webfrap.net>
 */
class Webfrap_DataLoader_Ajax_View extends LibTemplateAjaxView
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/
  
 
  /**
   * 
   * @param string $key the search key from the autocomplete field
   * @param TArray $context useriput / control flags
   *
   * @return void
   */
  public function displayEntityAutocomplete($key, $context )
  {

    $view = $this->getTplEngine();
    $view->setRawJsonData($this->model->getEntityByKey($key, $context ) );

    return null;

  }//end public function displayEntityAutocomplete */

} // end class WebfrapData_Loader_Ajax_View */

