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
class Webfrap_Acl_Maintab
  extends WgtMaintab
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

    /**
    * @var ProjectAlias_Acl_Model
    */
    public $model = null;

    /**
    * @var ProjectAlias_Acl_Ui
    */
    public $ui = null;

////////////////////////////////////////////////////////////////////////////////
// Methodes
////////////////////////////////////////////////////////////////////////////////

 /**
  * add the table item
  * add the search field elements
  *
  * @param TFlowFlag $params
  * @return boolean
  */
  public function display( $params )
  {

    // create the form action
    if( !$params->searchFormAction )
      $params->searchFormAction = 'index.php?c=Project.Alias_Acl.search';

    // add the id to the form
    if( !$params->searchFormId )
      $params->searchFormId = 'wgt-form-table-project_alias-acl-search';

    // fill the relevant data for the search form
    $this->setSearchFormData( $params );

    // create the form action
    if( !$params->formAction )
      $params->formAction = 'index.php?c=Project.Alias_Acl.updateArea';

    // add the id to the form
    if( !$params->formId )
      $params->formId = 'wgt-form-project_alias-acl-update';

    // set a namespace for the elements in the browser
    if( !$params->namespace )
      $params->namespace = 'project_alias-acl-update';

    // append form actions
    $this->setSaveFormData( $params );

    // set the path to the template
    // the system search in all modules for the template
    // the tpl ending is assigned automatically
    $this->setTemplate( 'project/alias/maintab/acl/overview' );

    // fetch the i18n text only one time
    $i18nText = $this->i18n->l
    (
      'ACL Project Aliases',
      'label.table'
    );

    // set browser title
    $this->setTitle($i18nText);
    // the label is displayed in the maintab as text
    $this->setLabel($i18nText);

    $params->viewType = 'maintab';

    // the tabid that is used in the template
    // this tabid has to be placed in the class attribute of all subtasks
    $this->setTabId( 'wgt-tab-project_alias_acl_listing');

    $objid = $this->model->getAreaId();

    // inject the menu in the view object
    $this->createMenu( $objid, $params );

    // create the ui helper object
    $ui = $this->loadUi('ProjectAlias_Acl');
    $ui->setModel( $this->model );

    // inject the table item in the template system
    $ui->createListItem
    (
      $this->model->search( $objid, $this, $params ),
      $params
    );

    // create the form elements and inject them in the templatesystem
    $ui->editForm
    (
      $objid,
      $params
    );

    return true;

  }//end public function display */

  /**
   * add a drop menu to the create window
   *
   * @param int $objid
   * @param TFlowFlag $params the named parameter object that was created in
   *   the controller
   * {
   *   string formId: the id of the form;
   * }
   */
  public function createMenu( $objid, $params )
  {

    $menu     = $this->newMenu
    (
      $this->id.'_dropmenu',
      'ProjectAlias_Acl'
    );
    $menu->id = $this->id.'_dropmenu';
    $menu->build( $objid, $params );

    $menu->addMenuLogic( $this, $objid, $params );

    return true;

  }//end public function createMenu */

} // end class WebFrap_Acl_Maintab */

