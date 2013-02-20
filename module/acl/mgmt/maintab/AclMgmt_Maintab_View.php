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
 * @subpackage Core
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright webfrap.net <contact@webfrap.net>
 */
class AclMgmt_Maintab_View extends WgtMaintab
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
  * @var AclMgmt_Model
  */
  public $model = null;

  /**
  * @var AclMgmt_Ui
  */
  public $ui = null;

  /**
  * @var DomainNode
  */
  public $domainNode = null;

/*//////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////*/

 /**
  * add the table item
  * add the search field elements
  *
  * @param TFlag $params
  * @return null / Error im Fehlerfall
  */
  public function displayListing($params )
  {

    $access = $params->access;

    // for paging use the default search form, to enshure to keep the order
    // and to page in search results if there was any search
    $params->searchFormAction = 'index.php?c=Acl.Mgmt.search&dkey='.$this->domainNode->domainName;
    $params->searchFormId = 'wgt-form-table-'.$this->domainNode->aclDomainKey.'-acl-search';

    // fill the relevant data for the search form
    $this->setSearchFormData($params );

    // create the form action
    $params->formAction = 'index.php?c=Acl.Mgmt.updateArea&dkey='.$this->domainNode->domainName;

    // add the id to the form
    $params->formId = 'wgt-form-'.$this->domainNode->aclDomainKey.'-acl-update';

    // set a namespace for the elements in the browser
    $params->namespace = ''.$this->domainNode->aclDomainKey.'-acl-update';

    // append form actions
    $this->setSaveFormData($params );

    $this->addVar( 'domain', $this->domainNode );

    // set the path to the template
    // the system search in all modules for the template
    // the tpl ending is assigned automatically
    $this->setTemplate( 'acl/mgmt/maintab/main_group_rights', true );

    // fetch the i18n text only one time
    $i18nText = $this->i18n->l
    (
      'ACL Entity {@label@}',
      'wbf.label',
      array
      (
        'label' => $this->i18n->l($this->domainNode->label, $this->domainNode->domainI18n.'.label' )
      )
    );

    // set browser title
    $this->setTitle($i18nText );

    // the label is displayed in the maintab as text
    $this->setLabel($i18nText );

    $params->viewType = 'maintab';

    // the tabid that is used in the template
    // this tabid has to be placed in the class attribute of all subtasks
    //$this->setTabId( 'wgt-tab-'.$this->domainNode.'_acl_listing' );

    $areaId = $this->model->getAreaId();
    $params->areaId = $areaId;
    $params->dKey   = $this->domainNode->domainName;

    // inject the menu in the view object
    $this->createMenu($areaId, $params );

    // create the ui helper object
    $ui = $this->loadUi( 'AclMgmt' );
    $ui->setModel($this->model );
    $ui->domainNode = $this->domainNode;

    // inject the table item in the template system
    $ui->createListItem
    (
      $this->model->search($areaId, $access, $params ),
      $access,
      $params
    );

    // create the form elements and inject them in the templatesystem
    $ui->editForm
    (
      $areaId,
      $params
    );

    // alles ok
    return null;

  }//end public function displayListing */

  /** inject the menu in the activ view object
   *
   *
   * @param int $objid
   * @param TFlag $params the named parameter object that was created in
   *   the controller
   * {
   *   string formId: the id of the form;
   * }
   */
  public function createMenu($objid, $params )
  {

    $menu     = $this->newMenu
    (
      $this->id.'_dropmenu',
      $this->domainNode->domainAclMask
    );
    $menu->domainNode = $this->domainNode;
    $menu->id = $this->id.'_dropmenu';
    $menu->buildMenu($objid, $params );

    $menu->injectMenuLogic($this, $objid, $params );

    return true;

  }//end public function createMenu */

} // end class AclMgmt_Maintab_View */

