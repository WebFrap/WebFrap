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
class Webfrap_Acl_Subwindow
  extends WgtWindowTemplate
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

    // set the default table template
    $this->setTemplate( 'project/alias/subwindow/acl/overview' );

    // fetch the i18n text only one time
    $i18nText = $this->i18n->l
    (
      'ACL Project Aliases',
      'label.table'
    );

    // set the window title
    $this->setTitle($i18nText);
    $this->setStatus($i18nText);

    $objid = $this->model->getAreaId();

    // append the table buttons
    $this->createWindowMenu( $objid, $params );

    $ui = $this->loadUi('ProjectAlias_Acl');
    $ui->setModel($this->model);

    // inject the table item in the template system
    $ui->createListItem
    (
      $this->model->search( $objid, $this, $params ),
      $params
    );

    // inject the table item in the template system
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
   * @param TFlowFlag $params the named parameter object that was created in
   *   the controller
   * {
   *   string formId: the id of the form;
   * }
   */
  public function createWindowMenu( $objid, $params )
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

  }//end public function createWindowMenu */

} // end class WebFrap_Acl_Subwindow */

