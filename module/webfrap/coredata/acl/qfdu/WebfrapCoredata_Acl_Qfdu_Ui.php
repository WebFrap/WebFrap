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
class WebfrapCoredata_Acl_Qfdu_Ui
  extends Ui
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * the model
   * @var WebfrapCoredata_Acl_Qfdu_Model
   */
  protected $model = null;

////////////////////////////////////////////////////////////////////////////////
// Listing Methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * create a table item for the entity
   *
   * @param LibSqlQuery $data Die Datenbank Query zum befüllen des Listenelements
   * @param int $areaId die ID der Area
   * @param LibAclContainer $access Der Container mit den Zugriffsrechten
   * @param TFlag $params named parameters
   *
   * @return WebfrapCoredata_Acl_Qfdu_Treetable_Element
   */
  public function createListItem( $data, $areaId, $access, $params  )
  {

    $listObj = new WebfrapCoredata_Acl_Qfdu_Treetable_Element
    (
      'listingQualifiedUsers',
      $this->view
    );

    $listObj->areaId = $areaId;

    // use the query as datasource for the table
    $listObj->setData( $data );

    // den access container dem listenelement übergeben
    $listObj->setAccess( $access );
    $listObj->setAccessPath( $params, $params->aclKey, $params->aclNode );

    // set the offset to set the paging menu correct
    $listObj->start    = $params->start;

    // set the position for the size menu
    $listObj->stepSize = $params->qsize;

    // check if there is a filter for the first char
    if( $params->begin )
      $listObj->begin  = $params->begin;

    // if there is a given tableId for the html id of the the table replace
    // the default id with it
    if( $params->targetId )
      $listObj->setId( $params->targetId );

    $listObj->addActions( array( 'inheritance', 'sep', 'delete' ) );
    $listObj->addUserActions( array( 'delete' ) );
    $listObj->addDatasetActions( array( 'delete' ) );

    // for paging use the default search form, to enshure to keep the order
    // and to page in search results if there was any search
    if(!$params->searchFormId)
      $params->searchFormId = 'wgt-form-table-project_iteration-acl-qfdu-search';

    $listObj->setPagingId( $params->searchFormId );

    // add the id to the form
    if( !$params->formId )
      $params->formId = 'wgt-form-project_iteration-acl-update';

    $listObj->setSaveForm( $params->formId );


    if( $params->ajax )
    {
      // refresh the table in ajax requests
      $listObj->refresh    = true;

      // the table should only replace the content inside of the container
      // but not the container itself
      $listObj->insertMode = false;
    }
    else
    {
      // create the panel
      $tabPanel = new WgtPanelTable( $listObj );

      $tabPanel->title      = $this->view->i18n->l
      (
        'Qualified User Access for Iteration',
        'project.iteration.label'
      );
      $tabPanel->searchKey  = 'project_iteration_acl_qfdu';
    }


    if( $params->append  )
    {
      $listObj->setAppendMode(true);
      $listObj->buildAjax();

      $jsCode = <<<WGTJS

  \$S('table#{$listObj->id}-table').grid('syncColWidth').grid('refreshTree');

WGTJS;

      $this->view->addJsCode( $jsCode );

    }
    else
    {
      // if this is an ajax request and we replace the body, we need also
      // to change the displayed found "X" entries in the footer
      if( $params->ajax )
      {
        $jsCode = <<<WGTJS

  \$S('table#{$listObj->id}-table').grid('setNumEntries',{$listObj->dataSize}).grid('syncColWidth').grid('refreshTree');

WGTJS;

        $this->view->addJsCode( $jsCode );

      }

      $listObj->buildHtml();
    }

    return $listObj;

  }//end public function createListItem */

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

    $table = new WebfrapCoredata_Acl_Qfdu_Treetable_Element
    (
      'listingQualifiedUsers',
      $this->view
    );

    // den access container dem listenelement übergeben
    $table->setAccess( $access );
    $table->setAccessPath( $params, $params->aclKey, $params->aclNode );

    $table->areaId = $areaId;

    $assignEntity = $this->model->getEntityWbfsysGroupUsers();

    $data = $this->model->getEntryWbfsysGroupUsers(  $params );

    $table->setData( array( $data['wbfsys_role_group_rowid'] => $data ) );

    if( isset($data['wbfsys_group_users_vid']) && trim($data['wbfsys_group_users_vid']) != '' )
    {
      $table->dataUser[$data['wbfsys_role_group_rowid']][$data['wbfsys_role_user_rowid']] = array
      (
        'id'    => $data['wbfsys_role_user_rowid'],
        'name'  => $data['wbfsys_role_user_name'],
      );

      $table->dataEntity[$data['wbfsys_role_group_rowid']][$data['wbfsys_role_user_rowid']][] = $data;
    }
    else
    {
      $table->dataUser[$data['wbfsys_role_group_rowid']][$data['wbfsys_role_user_rowid']] = $data;
    }

    // if a table id is given use it for the table
    if( $params->targetId )
      $table->id = $params->targetId;

    $table->setPagingId( $params->searchFormId );

    // add the id to the form
    if( !$params->formId )
      $params->formId = 'wgt-form-project_iteration-acl-update';

    $table->setSaveForm( $params->formId );

    $table->addActions( array( 'inheritance', 'sep', 'delete' ) );
    $table->addUserActions( array( 'delete' ) );
    $table->addDatasetActions( array( 'delete' ) );

    $this->view->setPageFragment( 'groupUsersEntry', $table->buildAjaxEntry( ) );

    if( $insert )
    {

      $jsCode = <<<WGTJS

  \$S('table#{$table->id}-table').grid('reColorize').grid('incEntries').grid('syncColWidth').grid('refreshTree');

WGTJS;

    }
    else
    {

      $jsCode = <<<WGTJS

  \$S('table#{$table->id}-table').grid('reColorize').grid('syncColWidth').grid('refreshTree');

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

} // end class WebfrapCoredata_Acl_Qfdu_Ui */

