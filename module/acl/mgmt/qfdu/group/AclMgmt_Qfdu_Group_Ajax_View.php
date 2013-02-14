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
class AclMgmt_Qfdu_Group_Ajax_View extends LibTemplateAjaxView
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/
  
  /**
   * @var DomainNode
   */
  public $domainNode = null;
  
  /**
   * @var AclMgmt_Qfdu_Model
   */
  public $model = null;
    
/*//////////////////////////////////////////////////////////////////////////////
// display methodes
//////////////////////////////////////////////////////////////////////////////*/



  /**
   * append a new user in relation to an area / entity to a group
   *
   * on connect the server pushes a new table row via ajax area to the client
   * the ajax area appends automatically at the end of the listing element body
   *
   * @param WbfsysAreaAssignment_Entity $eAssignment
   * @param TArray $context useriput / control flags
   */
  public function displayConnect( $eAssignment, $context )
  {
    
    $ui = $this->tplEngine->loadUi( 'AclMgmt_Qfdu_Group' );
    $ui->domainNode = $this->domainNode;
    $ui->setModel( $this->model );
    $ui->setView( $this->getView() );

    // add the id to the form
    if (!$context->searchFormId )
      $context->searchFormId = 'wgt-form-table-'.$this->domainNode->domainName.'-acl-qfdu-search';

    // ok it's definitly an ajax request
    $context->ajax = true;

    $ui->createListItem
    (
      $this->model->searchQualifiedUsers( $context->areaId, $context, $eAssignment->getId() ),
      $context->areaId,
      $context->access,
      $context
    );

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

    $ui = $this->tplEngine->loadUi( 'AclMgmt_Qfdu_Group' );
    $ui->domainNode = $this->domainNode;
    $ui->setModel( $this->model );
    $ui->setView( $this->getView() );

    // add the id to the form
    if (!$context->searchFormId )
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
  public function displayLoadGridUsers( $groupId, $context )
  {
    
    /* @var $ui  AclMgmt_Qfdu_Ui  */
    $ui = $this->tplEngine->loadUi( 'AclMgmt_Qfdu' );
    $ui->domainNode = $this->domainNode;
    $ui->setModel( $this->model );
    $ui->setView( $this->getTpl() );

    // add the id to the form
    if (!$context->searchFormId )
      $context->searchFormId = 'wgt-form-table-'.$this->domainNode->domainName.'-acl-qfdu-search';

    // ok it's definitly an ajax request
    $context->ajax = true;

    $ui->listBlockUsers
    (
      $groupId,
      $context
    );

    return null;

  }//end public function displayLoadGridUsers */
  
  /**
   * search pushes a rendered listing element body to the client, that replaces
   * the existing body
   *
   * @param int $groupId
   * @param int $userId
   * @param TArray $context control flags
   */
  public function displayLoadGridDsets( $groupId, $userId, $context )
  {
    
    /* @var $ui  AclMgmt_Qfdu_Ui  */
    $ui = $this->tplEngine->loadUi( 'AclMgmt_Qfdu' );
    $ui->domainNode = $this->domainNode;
    $ui->setModel( $this->model );
    $ui->setView( $this->getTpl() );

    // add the id to the form
    if (!$context->searchFormId )
      $context->searchFormId = 'wgt-form-table-'.$this->domainNode->domainName.'-acl-qfdu-search';

    // ok it's definitly an ajax request
    $context->ajax = true;

    $ui->listBlockDsets
    (
      $groupId,
      $userId,
      $context
    );

    return null;

  }//end public function displayLoadGridDsets */

} // end class AclMgmt_Qfdu_Group_Ajax_View */

