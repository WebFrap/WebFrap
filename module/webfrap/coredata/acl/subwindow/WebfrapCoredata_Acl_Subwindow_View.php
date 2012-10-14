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
class WebfrapCoredata_Acl_Subwindow_View
  extends Webfrap_Acl_Subwindow_View
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

    /**
    * @var WebfrapCoredata_Acl_Model
    */
    public $model = null;

    /**
    * @var WebfrapCoredata_Acl_Ui
    */
    public $ui = null;

////////////////////////////////////////////////////////////////////////////////
// Methodes
////////////////////////////////////////////////////////////////////////////////

 /**
  * add the table item
  * add the search field elements
  *
  * @param TFlag $params
  * @return boolean
  */
  public function display( $params )
  {
  
    $access = $params->access;

    // create the form action
    if( !$params->searchFormAction )
      $params->searchFormAction = 'index.php?c=Project.Iteration_Acl.search';

    // add the id to the form
    if( !$params->searchFormId )
      $params->searchFormId = 'wgt-form-table-project_iteration-acl-search';

    // fill the relevant data for the search form
    $this->setSearchFormData( $params );

    // create the form action
    if( !$params->formAction )
      $params->formAction = 'index.php?c=Project.Iteration_Acl.updateArea';

    // add the id to the form
    if( !$params->formId )
      $params->formId = 'wgt-form-project_iteration-acl-update';

    // set a namespace for the elements in the browser
    if( !$params->namespace )
      $params->namespace = 'project_iteration-acl-update';

    // append form actions
    $this->setSaveFormData( $params );

    // set the default table template
    $this->setTemplate( 'project/iteration/subwindow/acl/overview' );

    // fetch the i18n text only one time
    $i18nText = $this->i18n->l
    (
      'ACL Iteration',
      'project.iteration.label'
    );

    // set the window title
    $this->setTitle( $i18nText );
    $this->setStatus( $i18nText );

    $objid = $this->model->getAreaId();

    // append the table buttons
    $this->createWindowMenu( $objid, $params );

    $ui = $this->loadUi( 'WebfrapCoredata_Acl' );
    $ui->setModel( $this->model );

    // inject the table item in the template system
    $ui->createListItem
    (
      $this->model->search( $objid, $this, \access, $params ),
      \access,
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
   * @param TFlag $params the named parameter object that was created in
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
      'WebfrapCoredata_Acl'
    );
    $menu->id = $this->id.'_dropmenu';
    $menu->buildMenu( $objid, $params );

    $menu->addMenuLogic( $this, $objid, $params );

    return true;

  }//end public function createWindowMenu */

} // end class WebfrapCoredata_Acl_Subwindow_View */

