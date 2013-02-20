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
class AclMgmt_Qfdu_User_Ui extends MvcUi
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * the model
   * @var AclMgmt_Qfdu_Model
   */
  protected $model = null;

  /**
   * @var DomainNode
   */
  public $domainNode = null;

/*//////////////////////////////////////////////////////////////////////////////
// Listing Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * create a table item for the entity
   *
   * @param LibSqlQuery $data Die Datenbank Query zum befüllen des Listenelements
   * @param int $areaId die ID der Area
   * @param LibAclContainer $access Der Container mit den Zugriffsrechten
   * @param TFlag $params named parameters
   *
   * @return AclMgmt_Qfdu_Treetable_Element
   */
  public function createListItem($data, $access, $params  )
  {

    //$className = $this->domainNode->domainAclMask.'_Qfdu_Treetable_Element';
    //$className = 'AclMgmt_Qfdu_User_Treetable_Element';

    $listObj = new AclMgmt_Qfdu_User_Treetable_Element
    (
      $this->domainNode,
      'listingQualifiedUsers',
      $this->view
    );

    $areaId              = $params->areaId;
    $listObj->areaId     = $areaId;
    $listObj->domainNode = $this->domainNode;

    // use the query as datasource for the table
    $listObj->setUserData($data, true );

    // den access container dem listenelement übergeben
    $listObj->setAccess($access );
    $listObj->setAccessPath($params, $params->aclKey, $params->aclNode );

    // set the offset to set the paging menu correct
    $listObj->start    = $params->start;

    // set the position for the size menu
    $listObj->stepSize = $params->qsize;

    // check if there is a filter for the first char
    if ($params->begin )
      $listObj->begin  = $params->begin;

    // if there is a given tableId for the html id of the the table replace
    // the default id with it
    if ($params->targetId )
      $listObj->setId($params->targetId );

    // for paging use the default search form, to enshure to keep the order
    // and to page in search results if there was any search
    if (!$params->searchFormId )
      $params->searchFormId = 'wgt-form-table-'.$this->domainNode->aclDomainKey.'-acl-tuser-search';

    $listObj->setPagingId($params->searchFormId );

    // add the id to the form
    if (!$params->formId )
      $params->formId = 'wgt-form-'.$this->domainNode->aclDomainKey.'-acl-tuser-update';

    $listObj->setSaveForm($params->formId );


    if ($params->ajax) {
      // refresh the table in ajax requests
      $listObj->refresh    = true;

      // the table should only replace the content inside of the container
      // but not the container itself
      $listObj->insertMode = false;
    } else {
      // create the panel
      $tabPanel = new WgtPanelTable($listObj );

      $tabPanel->title      = $this->view->i18n->l
      (
        'Qualified User Access for {@label@}',
        'wbf.label',
        array
        (
          'label' => $this->domainNode->label
        )
      );
      $tabPanel->searchKey  = $this->domainNode->domainName.'_acl_tuser';
    }


    if ($params->append) {

      Debug::console( 'IN APPEND' );

      $listObj->setAppendMode( true );
      $listObj->buildAjax();

      $jsCode = <<<WGTJS

  \$S('table#{$listObj->id}-table').grid('renderRowLayout').grid('syncColWidth');

WGTJS;

      $this->view->addJsCode($jsCode );

    } else {
      // if this is an ajax request and we replace the body, we need also
      // to change the displayed found "X" entries in the footer
      if ($params->ajax) {
        $jsCode = <<<WGTJS

  \$S('table#{$listObj->id}-table').grid('setNumEntries',{$listObj->dataSize}).grid('renderRowLayout').grid('syncColWidth');

WGTJS;

        $this->view->addJsCode($jsCode );

      }

      $listObj->buildHtml();
    }

    return $listObj;

  }//end public function createListItem */

  /**
   * just deliver changed table rows per ajax interface
   *
   * @param int $userId
   * @param int $dsetId
   * @param array $params named parameters
   * @param boolean $insert
   * @return void
   */
  public function listBlockGroups($userId, $dsetId, $context )
  {

    //$className = $this->domainNode->domainAclMask.'_Qfdu_Treetable_Element';

    /**/
    $table = new AclMgmt_Qfdu_User_Treetable_Element
    (
      $this->domainNode,
      'listingQualifiedUsers',
      $this->view
    );

    // den access container dem listenelement übergeben
    $table->setAccess($context->access );
    $table->setAccessPath($context, $context->aclKey, $context->aclNode );

    $table->areaId = $context->areaId;
    $table->domainNode = $this->domainNode;

    $table->setGroupData($this->model->loadListByUser_Groups($userId, $dsetId, $context ) );

    // if a table id is given use it for the table
    if ($context->targetId )
      $table->id = $context->targetId;

    $table->setPagingId($context->searchFormId );

    // add the id to the form
    if (!$context->formId )
      $context->formId = 'wgt-form-'.$this->domainNode->domainName.'-acl-tuser-update';

    $table->setSaveForm($context->formId );

    $this->view->setPageFragment( 'groupUsersEntry', $table->renderGroupBlock($userId, $dsetId, $context ) );

    $jsCode = <<<WGTJS

  \$S('table#{$table->id}-table').grid('reColorize').grid('syncColWidth');

WGTJS;

    $this->view->addJsCode($jsCode );


  }//end public function listBlockGroups */

  /**
   * just deliver changed table rows per ajax interface
   *
   * @param int $userId
   * @param array $context named parameters
   * @param boolean $insert
   * @return void
   */
  public function listBlockDsets($userId, $context )
  {

    //$className = $this->domainNode->domainAclMask.'_Qfdu_Treetable_Element';

    $table = new AclMgmt_Qfdu_User_Treetable_Element
    (
      $this->domainNode,
      'listingQualifiedUsers',
      $this->view
    );

    // den access container dem listenelement übergeben
    $table->setAccess($context->access );
    $table->setAccessPath($context, $context->aclKey, $context->aclNode );

    $table->areaId = $context->areaId;
    $table->domainNode = $this->domainNode;

    $table->setDsetData($this->model->loadListByUser_Dset($userId, $context ) );

    // if a table id is given use it for the table
    if ($context->targetId )
      $table->id = $context->targetId;

    $table->setPagingId($context->searchFormId );

    // add the id to the form
    if (!$context->formId )
      $context->formId = 'wgt-form-'.$this->domainNode->domainName.'-acl-tuser-update';

    $table->setSaveForm($context->formId );

    $this->view->setPageFragment( 'groupUsersEntry', $table->renderDsetBlock($userId, $context ) );

    $jsCode = <<<WGTJS

  \$S('table#{$table->id}-table').grid('reColorize').grid('syncColWidth');

WGTJS;

    $this->view->addJsCode($jsCode );


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
  public function listEntry($areaId, $access, $params, $insert )
  {

    $className = $this->domainNode->domainAclMask.'_Qfdu_Treetable_Element';

    $table = new $className
    (
      $this->domainNode,
      'listingQualifiedUsers',
      $this->view
    );

    // den access container dem listenelement übergeben
    $table->setAccess($access );
    $table->setAccessPath($params, $params->aclKey, $params->aclNode );

    $table->areaId = $areaId;

    $assignEntity = $this->model->getEntityWbfsysGroupUsers();

    $data = $this->model->getEntryWbfsysGroupUsers(  $params );

    $table->setData($data );

    // if a table id is given use it for the table
    if ($params->targetId )
      $table->id = $params->targetId;

    $table->setPagingId($params->searchFormId );

    // add the id to the form
    if (!$params->formId )
      $params->formId = 'wgt-form-'.$this->domainNode->domainName.'-acl-update';

    $table->setSaveForm($params->formId );

    $this->view->setPageFragment( 'groupUsersEntry', $table->buildAjaxEntry( ) );

    if ($insert) {

      $jsCode = <<<WGTJS

  \$S('table#{$table->id}-table').grid('reColorize').grid('incEntries').grid('syncColWidth');

WGTJS;

    } else {

      $jsCode = <<<WGTJS

  \$S('table#{$table->id}-table').grid('reColorize').grid('syncColWidth');

WGTJS;

    }

    $this->view->addJsCode($jsCode );

    return $table;

  }//end public function listEntry */

/*//////////////////////////////////////////////////////////////////////////////
// Delete & Clean Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * method to remove a row from a table via ajax request
   *
   * @param string $key
   * @param string $itemId
   * @return void
   */
  public function removeGroupEntry($asgData )
  {

    $itemId = 'wgt-treetable-'.$this->domainNode->domainName.'-acl-tuser';

    $groupRowId  = "{$itemId}_row_{$asgData->userId}_{$asgData->dsetId}_{$asgData->groupId}";
    $userRowId   = "{$itemId}_row_{$asgData->userId}_{$asgData->dsetId}";
    $dsetRowId   = "{$itemId}_row_{$asgData->userId}";

    $code = <<<JSCODE

    \$S('#{$groupRowId}').fadeOut(100,function(){
      \$S('#{$groupRowId}').remove();
      if (!\$S('.c-{$userRowId}').length ) {
        \$S('#{$userRowId}').remove();
      }
      if (!\$S('.c-{$dsetRowId}').length ) {
        \$S('#{$dsetRowId}').remove();
      }
    });

JSCODE;

    $this->view->addJsCode($code );

  }//end public function removeGroupEntry */

  /**
   * method to remove a row from a table via ajax request
   *
   * @param int $groupId
   * @param int $userId
   * @param string $itemId
   * @return void
   */
  public function removeUserEntry($userId )
  {

    $itemId = 'wgt-treetable-'.$this->domainNode->domainName.'-acl-tuser';

    $userRowId = "{$itemId}_row_{$userId}";

    $code = <<<JSCODE

    \$S('#{$userRowId}').fadeOut(100,function(){
      \$S('#{$userRowId}').remove();
      \$S('.c-{$userRowId}').each(function(){
        \$S('.c-'+\$S(this).attr('id')).remove();
      });
      \$S('.c-{$userRowId}').remove();
    });

JSCODE;

    $this->view->addJsCode($code );

  }//end public function removeUserEntry */

  /**
   * method to remove a row from a table via ajax request
   *
   * @param TDataObject $asgData
   * @return void
   */
  public function removeDsetEntry($asgData  )
  {

    $itemId = 'wgt-treetable-'.$this->domainNode->domainName.'-acl-tuser';

    $userRowId   = "{$itemId}_row_{$asgData->userId}_{$asgData->dsetId}";
    $dsetRowId   = "{$itemId}_row_{$asgData->userId}";

    $code = <<<JSCODE

    \$S('#{$userRowId}').fadeOut(100,function(){
      \$S('#{$userRowId}').remove();
      \$S('.c-{$userRowId}').remove();
      if (!\$S('.c-{$dsetRowId}').length ) {
        \$S('#{$dsetRowId}').remove();
      }
    });

JSCODE;

    $this->view->addJsCode($code );

  }//end public function removeDsetEntry */

} // end class AclMgmt_Qfdu_Ui */

