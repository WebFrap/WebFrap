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
class Webfrap_Acl_Ajax_View
  extends LibTemplatePlain
{
////////////////////////////////////////////////////////////////////////////////
// display methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @param string $key
   * @param TArray $params
   */
  public function displayAutocomplete( $key, $params )
  {

    $view = $this->getTplEngine();
    $view->setRawJsonData( $this->model->searchGroupsAutocomplete($key, $params) );

  }//end public function displayAutocomplete */

  /**
   * @param TArray $params
   */
  public function displayConnect( $params )
  {

    $ui = $this->tplEngine->loadUi('ProjectAlias_Acl');
    $ui->setModel( $this->model );

    return $ui->listEntry( true, $params );

  }//end public function displayConnect */

  /**
   * @param int $areaId
   * @param TArray $params
   */
  public function displaySearch( $areaId, $params )
  {

    $ui = $this->tplEngine->loadUi('ProjectAlias_Acl');
    $ui->setModel( $this->model );

    // add the id to the form
    if( !$params->searchFormId )
      $params->searchFormId = 'wgt-form-table-project_alias-acl-search';

    $ui->createListItem
    (
      $this->model->search( $areaId, $this->tplEngine, $params ),
      $params
    );

  }//end public function displaySearch */

} // end class WebFrap_Acl_Ajax_View */

