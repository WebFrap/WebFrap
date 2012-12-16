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
class AclMgmt_Qfdu_Ui
  extends Ui
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * the model
   * @var AclMgmt_Qfdu_Model
   */
  protected $model = null;
  
  /**
   * @var DomainNode
   */
  public $domainNode = null;

////////////////////////////////////////////////////////////////////////////////
// Listing Methodes
////////////////////////////////////////////////////////////////////////////////
  
  /**
   * just deliver changed table rows per ajax interface
   *
   * @param string $areaId
   * @param LibAclContainer $access
   * @param array $params named parameters
   * @param boolean $insert
   * @return void
   */
  public function listBlockUsers( $groupId, $context )
  {
    
    //$className = $this->domainNode->domainAclMask.'_Qfdu_Treetable_Element';
    
    /**/
    $table = new AclMgmt_Qfdu_Group_Treetable_Element
    (
      $this->domainNode,
      'listingQualifiedUsers',
      $this->view
    );

    // den access container dem listenelement übergeben
    $table->setAccess( $context->access );
    $table->setAccessPath( $context, $context->aclKey, $context->aclNode );

    $table->areaId = $context->areaId;
    $table->domainNode = $this->domainNode;

    $table->setUserData( $this->model->loadGridUsers( $groupId, $context ) );

    // if a table id is given use it for the table
    if( $context->targetId )
      $table->id = $context->targetId;

    $table->setPagingId( $context->searchFormId );

    // add the id to the form
    if( !$context->formId )
      $context->formId = 'wgt-form-'.$this->domainNode->domainName.'-acl-tgroup-update';

    $table->setSaveForm( $context->formId );
    //$table->addUserActions( array( 'delete' ) );

    $this->view->setPageFragment( 'groupUsersEntry', $table->renderUserBlock( $groupId, $context ) );

    $jsCode = <<<WGTJS

  \$S('table#{$table->id}-table').grid('renderRowLayout').grid('syncColWidth');

WGTJS;

    $this->view->addJsCode( $jsCode );


  }//end public function listBlockUsers */

  /**
   * just deliver changed table rows per ajax interface
   *
   * @param int $groupId
   * @param int $userId
   * @param array $context named parameters
   * @param boolean $insert
   * @return void
   */
  public function listBlockDsets( $groupId, $userId, $context )
  {
    
    //$className = $this->domainNode->domainAclMask.'_Qfdu_Treetable_Element';

    $table = new AclMgmt_Qfdu_Group_Treetable_Element
    (
      $this->domainNode,
      'listingQualifiedUsers',
      $this->view
    );

    // den access container dem listenelement übergeben
    $table->setAccess( $context->access );
    $table->setAccessPath( $context, $context->aclKey, $context->aclNode );

    $table->areaId = $context->areaId;
    $table->domainNode = $this->domainNode;

    $table->setDsetData( $this->model->loadGridDsets( $groupId, $userId, $context ) );

    // if a table id is given use it for the table
    if( $context->targetId )
      $table->id = $context->targetId;

    $table->setPagingId( $context->searchFormId );

    // add the id to the form
    if( !$context->formId )
      $context->formId = 'wgt-form-'.$this->domainNode->domainName.'-acl-tgroup-update';

    $table->setSaveForm( $context->formId );
    //$table->addDatasetActions( array( 'delete' ) );

    $this->view->setPageFragment( 'groupUsersEntry', $table->renderDsetBlock( $groupId, $userId, $context ) );

    $jsCode = <<<WGTJS

  \$S('table#{$table->id}-table').grid('renderRowLayout').grid('syncColWidth');

WGTJS;

    $this->view->addJsCode( $jsCode );


  }//end public function listBlockUsers */
  
  /**
   * just deliver changed table rows per ajax interface
   *
   * @param string $areaId
   * @param LibAclContainer $access
   * @param array $params named parameters
   * @param boolean $insert
   * @return void
   */
  public function listEntry( $areaId, $access, $params, $insert )
  {
    
    //$className = $this->domainNode->domainAclMask.'_Qfdu_Treetable_Element';
    
    $table = new AclMgmt_Qfdu_Group_Treetable_Element
    (
      $this->domainNode,
      'listingQualifiedUsers',
      $this->view
    );

    // den access container dem listenelement übergeben
    $table->setAccess( $access );
    $table->setAccessPath( $params, $params->aclKey, $params->aclNode );

    $table->areaId = $areaId;

    $assignEntity = $this->model->getEntityWbfsysGroupUsers();

    $data = $this->model->getEntryWbfsysGroupUsers(  $params );

    $table->setData( $data );

    // if a table id is given use it for the table
    if( $params->targetId )
      $table->id = $params->targetId;

    $table->setPagingId( $params->searchFormId );

    // add the id to the form
    if( !$params->formId )
      $params->formId = 'wgt-form-'.$this->domainNode->domainName.'-acl-tgroup-update';

    $table->setSaveForm( $params->formId );
      
    /*
    $table->addActions( array( 'inheritance', 'sep', 'delete' ), 'group' );
    $table->addActions( array( 'delete' ), 'user' );
    $table->addActions( array( 'delete' ), 'dset' );
    */

    $this->view->setPageFragment( 'groupUsersEntry', $table->buildAjaxEntry( ) );

    if( $insert )
    {

      $jsCode = <<<WGTJS

  \$S('table#{$table->id}-table').grid('renderRowLayout').grid('incEntries').grid('syncColWidth');

WGTJS;

    }
    else
    {

      $jsCode = <<<WGTJS

  \$S('table#{$table->id}-table').grid('renderRowLayout').grid('syncColWidth');

WGTJS;

    }

    $this->view->addJsCode( $jsCode );

    return $table;

  }//end public function listEntry */

////////////////////////////////////////////////////////////////////////////////
// Delete & Clean Methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * method to remove a row from a table via ajax request
   *
   * @param string $key
   * @param string $itemId
   * @return void
   */
  public function removeGroupEntry( $key, $itemId )
  {
    $view = $this->getView();

    $code = <<<JSCODE

    \$S('#{$itemId}_row_{$key}').fadeOut(100,function(){\$S('#{$itemId}_row_{$key}').remove();});
    \$S('#{$itemId}-table').grid('decEntries');

    \$S('#{$itemId}_row_{$key}').fadeOut(100,function(){
      \$S('#{$itemId}_row_{$key}').remove();
      \$S('#{$itemId}-table .group-{$key}').remove();
    });

JSCODE;

    $this->view->addJsCode($code);

  }//end public function removeGroupEntry */

  /**
   * remove all assigned entries from a user
   *
   * @param int $groupId  
   * @param int $userId 
   * @param string $itemId
   * @return void
   */
  public function cleanUserEntry( $groupId, $userId, $itemId  )
  {

    // remove all children from the user
    $code = <<<JSCODE

    \$S('#{$itemId}-table .user-{$userId}.group-{$groupId}').fadeOut(100,function(){
      \$S('#{$userId}-table .user-{$userId}.group-{$groupId}').remove();
    });

JSCODE;

    $this->view->addJsCode( $code );

  }//end public function cleanUserEntry */

  /**
   * method to remove a row from a table via ajax request
   *
   * @param int $groupId
   * @param int $userId
   * @param string $itemId
   * @return void
   */
  public function removeUserEntry( $groupId, $userId, $itemId  )
  {

    // remove user entry and children
    $code = <<<JSCODE

    \$S('#{$itemId}_row_{$groupId}_{$userId}').fadeOut(100,function(){
      \$S('#{$itemId}_row_{$groupId}_{$userId}').remove();
      \$S('#{$userId}-table .user-{$userId}.group-{$groupId}').remove();
    });

JSCODE;

    $this->view->addJsCode($code);

  }//end public function removeUserEntry */

  /**
   * method to remove a row from a table via ajax request
   *
   * @param string $key
   * @param string $itemId
   * @return void
   */
  public function removeDatasetEntry( $key, $itemId  )
  {

    $code = <<<JSCODE

    \$S('#{$itemId}_row_{$key}').fadeOut(100,function(){\$S('#{$itemId}_row_{$key}').remove();});

JSCODE;

    $this->view->addJsCode($code);

  }//end public function removeDatasetEntry */

} // end class AclMgmt_Qfdu_Ui */

