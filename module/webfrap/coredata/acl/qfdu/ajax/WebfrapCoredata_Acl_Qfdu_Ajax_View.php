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
 * This Class was generated with a Cartridge based on the WebFrap GenF Framework
 * This is the final Version of this class.
 * It's not expected that somebody change the Code via Hand.
 *
 * You are allowed to change this code, but be warned, that you'll loose
 * all guarantees that where given for this project, for ALL Modules that
 * somehow interact with this file.
 * To regain guarantees for the code please contact the developer for a code-review
 * and a change of the security-hash.
 *
 * The developer of this Code has checksums to proof the integrity of this file.
 * This is a security feature, to check if there where any malicious damages
 * from attackers against your installation.
 *
 *
 * @package WebFrap
 * @subpackage Core
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright webfrap.net <contact@webfrap.net>
 */
class WebfrapCoredata_Acl_Qfdu_Ajax_View
  extends LibTemplateAjaxView
{
////////////////////////////////////////////////////////////////////////////////
// display methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * automcomplete for the user roles
   *
   * inject the search result from the autocomplete request as json in the view
   * the view will answer as a normal ajax / xml request but embed the
   * json data as data package, which will be returned in the browser from the
   * calling request method
   *
   * @param string $areaId the rowid of the activ area
   * @param string $key the search key from the autocomplete field
   * @param TArray $params useriput / control flags
   *
   * @return void
   */
  public function displayAutocomplete( $areaId, $key, $params )
  {

    $view = $this->getTplEngine();
    $view->setRawJsonData( $this->model->getUsersByKey( $areaId, $key, $params ) );

    return null;

  }//end public function displayAutocomplete */

  /**
   * automcomplete for the Iteration entity
   *
   * inject the search result from the autocomplete request as json in the view
   * the view will answer as a normal ajax / xml request but embed the
   * json data as data package, which will be returned in the browser from the
   * calling request method
   *
   * @param string $areaId the rowid of the activ area
   * @param string $key the search key from the autocomplete field
   * @param TArray $params useriput / control flags
   */
  public function displayAutocompleteEntity( $areaId, $key, $params )
  {

    $view = $this->getTplEngine();
    $view->setRawJsonData( $this->model->getEntitiesByKey($areaId, $key, $params) );

    return null;

  }//end public function displayAutocompleteEntity */

  /**
   * append a new user in relation to an area / entity to a group
   *
   * on connect the server pushes a new table row via ajax area to the client
   * the ajax area appends automatically at the end of the listing element body
   *
   * @param string $areaId the rowid of the activ area
   * @param TArray $params useriput / control flags
   */
  public function displayConnect( $areaId, $params )
  {

    $ui = $this->tplEngine->loadUi( 'WebfrapCoredata_Acl_Qfdu' );
    $ui->setModel( $this->model );

    $ui->listEntry( $areaId, $params->access, $params, true );

    return null;

  }//end public function displayConnect */

  /**
   * search pushes a rendered listing element body to the client, that replaces
   * the existing body
   *
   * @param int $areaId the rowid of the activ area
   * @param TArray $params control flags
   */
  public function displaySearch( $areaId, $params )
  {

    $ui = $this->tplEngine->loadUi( 'WebfrapCoredata_Acl_Qfdu' );
    $ui->setModel( $this->model );
    $ui->setView( $this->getView() );

    // add the id to the form
    if( !$params->searchFormId )
      $params->searchFormId = 'wgt-form-table-project_iteration-acl-qfdu-search';

    // ok it's definitly an ajax request
    $params->ajax = true;

    $ui->createListItem
    (
      $this->model->searchQualifiedUsers( $areaId, $params ),
      $areaId,
      $params->access,
      $params
    );

    return null;

  }//end public function displaySearch */

} // end class WebfrapCoredata_Acl_Qfdu_Ajax_View */

