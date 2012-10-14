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
 * @copyright webfrap.net <contact@webfrap.net>
 */
class WebfrapCoredata_Acl_Masks_Subwindow_View
  extends WgtWindowTemplate
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

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
  public function displayListing( $params )
  {
  
    $access = $params->access;

    // set the default table template
    $this->setTemplate( 'project/iteration/subwindow/acl/list_masks' );

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
      'WebfrapCoredata_Acl_Masks'
    );
    $menu->id = $this->id.'_dropmenu';
    $menu->buildMenu( $objid, $params );

    $menu->addMenuLogic( $this, $objid, $params );

    return true;

  }//end public function createWindowMenu */

} // end class WebfrapCoredata_Acl_Masks_Subwindow_View */

