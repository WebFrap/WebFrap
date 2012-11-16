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
class AclMgmt_Dset_Ui
  extends Ui
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * the model
   * @var AclMgmt_Dset_Model
   */
  protected $model = null;
  
  /**
   * the model
   * @var DomainNode
   */
  public $domainNode = null;

////////////////////////////////////////////////////////////////////////////////
// Listing Methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * create a table item for the entity
   *
   * @param LibSqlQuery $data
   * @param EnterpriseEmployee_Entity $domainEntity
   * @param int $areaId
   * @param LibAclContainer $access
   * @param TFlag $params named parameters
   *
   * @return AclMgmt_Dset_Treetable_Element
   */
  public function createListItem( $data, $domainEntity, $areaId, $access, $params  )
  {

    $listObj = new AclMgmt_Dset_Treetable_Element
    (
      $this->domainNode,
      'listingDsetUsers',
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
    $listObj->setId( 'wgt-treetable-'.$this->domainNode->aclDomainKey.'-acl-dset' );


    // for paging use the default search form, to enshure to keep the order
    // and to page in search results if there was any search
    if( !$params->searchFormId )
      $params->searchFormId = 'wgt-form-table-'.$this->domainNode->aclDomainKey.'-acl-dset-search';

    $listObj->setPagingId( $params->searchFormId );

    // add the id to the form
    if( !$params->formId )
      $params->formId = 'wgt-form-'.$this->domainNode->aclDomainKey.'-acl-dset-update';

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
        $this->domainNode->label.' "{@label@}" User Access',
        $this->domainNode->domainI18n.'.label',
        array
        (
          'label' => $domainEntity->text()
        )
      );
      $tabPanel->searchKey  = ''.$this->domainNode->aclDomainKey.'_acl_dset';
    }

    if( $params->append  )
    {
      $listObj->setAppendMode(true);
      $listObj->buildAjax();

      $jsCode = <<<WGTJS

  \$S('table#{$listObj->id}-table').grid('syncColWidth');

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

  \$S('table#{$listObj->id}-table').grid('setNumEntries','{$listObj->dataSize}').grid('syncColWidth');

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
   * @param array $params named parameters
   * @param boolean $insert
   *
   * @return AclMgmt_Dset_Treetable_Element
   */
  public function listEntry( $access, $params,  $insert )
  {

    $table = new AclMgmt_Dset_Treetable_Element
    (
      $this->domainNode,
      'listingDsetUsers',
      $this->view
    );

    // den access container dem listenelement übergeben
    $table->setAccess( $access );
    $table->setAccessPath( $params, $params->aclKey, $params->aclNode );

    $assignEntity = $this->model->getEntityWbfsysGroupUsers();

    $data = $this->model->getEntryWbfsysGroupUsers( $params );

    $table->setData( array( $data['group_users_id_group'] => $data ) );

    $table->dataUser[$data['group_users_id_group']][$data['group_users_id_user']] = $data;

    // if a table id is given use it for the table
    if( $params->targetId  )
      $table->id = $params->targetId;

    $table->setPagingId( $params->searchFormId );

    // add the id to the form
    if( !$params->formId )
      $params->formId = 'wgt-form-'.$this->domainNode->aclDomainKey.'-acl-dset-update';

    $table->setSaveForm( $params->formId );

    $table->addActions( array( 'inheritance', 'sep', 'delete' ) );
    $table->addUserActions( array( 'delete' ) );

    $this->view->setPageFragment( 'groupUsersEntry', $table->buildAjaxEntry( ) );

    if( $insert )
    {

      $jsCode = <<<WGTJS

  \$S('table#{$table->id}-table').grid('reColorize').grid('incEntries').grid('syncColWidth');
  \$S('#{$table->id}_row_{$data['group_users_id_group']}_{$data['group_users_id_user']}').appendSubTree(\$S('#{$table->id}_row_{$data['group_users_id_group']}'));

WGTJS;

    }
    else
    {

      $jsCode = <<<WGTJS

  \$S('table#{$table->id}-table').grid('reColorize').grid('syncColWidth');

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
   *
   * @return void
   */
  public function removeGroupEntry( $key, $itemId  )
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
   *
   * @return void
   */
  public function cleanGroupEntry( $groupId, $userId, $itemId  )
  {

    // remove all children from the user
    $code = <<<JSCODE

    \$S('#{$itemId}-table .user-{$userId}.group-{$groupId}').fadeOut(100,function(){
      \$S('#{$userId}-table .user-{$userId}.group-{$groupId}').remove();
    });

JSCODE;

    $this->view->addJsCode($code);

  }//end public function cleanGroupEntry */

  /**
   * method to remove a row from a table via ajax request
   *
   * @param int $groupId
   * @param int $userId
   * @param int $itemId
   *
   * @return void
   */
  public function removeUserEntry( $groupId, $userId, $itemId )
  {

    // remove user entry and children
    $code = <<<JSCODE

    \$S('#{$itemId}_row_{$groupId}_{$userId}').fadeOut(100,function(){
      \$S('#{$itemId}_row_{$groupId}_{$userId}').remove();
    });

JSCODE;

    $this->view->addJsCode( $code );

  }//end public function removeUserEntry */


} // end class AclMgmt_Dset_Ui */

