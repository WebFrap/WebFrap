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
class AclMgmt_Qfdu_Dset_Ajax_View
  extends LibTemplateAjaxView
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////
  
  /**
   * @var DomainNode
   */
  public $domainNode = null;
    
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
   * @param TArray $context useriput / control flags
   *
   * @return void
   */
  public function displayAutocomplete( $areaId, $key, $context )
  {

    $view = $this->getTplEngine();
    $view->setRawJsonData( $this->model->getUsersByKey( $areaId, $key, $context ) );

    return null;

  }//end public function displayAutocomplete */

  /**
   * automcomplete for the Employee entity
   *
   * inject the search result from the autocomplete request as json in the view
   * the view will answer as a normal ajax / xml request but embed the
   * json data as data package, which will be returned in the browser from the
   * calling request method
   *
   * @param string $areaId the rowid of the activ area
   * @param string $key the search key from the autocomplete field
   * @param TArray $context useriput / control flags
   */
  public function displayAutocompleteEntity( $areaId, $key, $context )
  {

    $view = $this->getTplEngine();
    $view->setRawJsonData( $this->model->getEntitiesByKey( $areaId, $key, $context ) );

    return null;

  }//end public function displayAutocompleteEntity */

  /**
   * append a new user in relation to an area / entity to a group
   *
   * on connect the server pushes a new table row via ajax area to the client
   * the ajax area appends automatically at the end of the listing element body
   *
   * @param string $areaId the rowid of the activ area
   * @param TArray $context useriput / control flags
   */
  public function displayConnect( $areaId, $context )
  {

    $ui = $this->tplEngine->loadUi( 'AclMgmt_Qfdu' );
    $ui->setModel( $this->model );
    $ui->domainNode = $this->domainNode;

    $ui->listEntry( $areaId, $context->access, $context, true );

    return null;

  }//end public function displayConnect */

  /**
   * search pushes a rendered listing element body to the client, that replaces
   * the existing body
   *
   * @param int $areaId the rowid of the activ area
   * @param TArray $context control flags
   */
  public function displaySearch( $areaId, $context )
  {

    $ui = $this->tplEngine->loadUi( 'AclMgmt_Qfdu' );
    $ui->domainNode = $this->domainNode;
    $ui->setModel( $this->model );
    $ui->setView( $this->getView() );

    // add the id to the form
    if( !$context->searchFormId )
      $context->searchFormId = 'wgt-form-table-'.$this->domainNode->domainName.'-acl-qfdu-search';

    // ok it's definitly an ajax request
    $context->ajax = true;

    $ui->createListItem
    (
      $this->model->searchQualifiedUsers( $areaId, $context ),
      $areaId,
      $context->access,
      $context
    );

    return null;

  }//end public function displaySearch */
  
  /**
   * search pushes a rendered listing element body to the client, that replaces
   * the existing body
   *
   * @param int $areaId the rowid of the activ area
   * @param TArray $context control flags
   */
  public function displayLoadGridUsers( $dsetId, $context )
  {
    
    /* @var $ui  AclMgmt_Qfdu_Dset_Ui  */
    $ui = $this->tplEngine->loadUi( 'AclMgmt_Qfdu_Dset' );
    $ui->domainNode = $this->domainNode;
    $ui->setModel( $this->model );
    $ui->setView( $this->getTpl() );

    // add the id to the form
    if( !$context->searchFormId )
      $context->searchFormId = 'wgt-form-table-'.$this->domainNode->domainName.'-acl-tdset-search';

    // ok it's definitly an ajax request
    $context->ajax = true;

    $ui->listBlockUsers
    (
      $dsetId,
      $context
    );

    return null;

  }//end public function displayLoadGridUsers */
  
  /**
   * search pushes a rendered listing element body to the client, that replaces
   * the existing body
   *
   * @param int $userId
   * @param int $dsetId
   * @param TArray $context control flags
   */
  public function displayLoadGridGroups( $userId, $dsetId, $context )
  {
    
    /* @var $ui  AclMgmt_Qfdu_Dset_Ui  */
    $ui = $this->tplEngine->loadUi( 'AclMgmt_Qfdu_Dset' );
    $ui->domainNode = $this->domainNode;
    $ui->setModel( $this->model );
    $ui->setView( $this->getTpl() );

    // add the id to the form
    if( !$context->searchFormId )
      $context->searchFormId = 'wgt-form-table-'.$this->domainNode->domainName.'-acl-tdset-search';

    // ok it's definitly an ajax request
    $context->ajax = true;

    $ui->listBlockGroups
    (
      $userId,
      $dsetId,
      $context
    );

    return null;

  }//end public function displayLoadGridGroups */

} // end class AclMgmt_Qfdu_Dset_Ajax_View */

