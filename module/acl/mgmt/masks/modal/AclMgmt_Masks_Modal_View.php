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
class AclMgmt_Masks_Modal_View
  extends WgtModal
{
/*//////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////*/

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
    $this->setTemplate( 'acl/mgmt/modal/list_masks' );

    // fetch the i18n text only one time
    $i18nText = $this->i18n->l
    (
      'ACL Employee',
      'enterprise.employee.label'
    );

    // set the window title
    $this->setTitle( $i18nText );
    $this->setStatus( $i18nText );

    $objid = $this->model->getAreaId();


    return true;

  }//end public function display */


} // end class AclMgmt_Masks_Modal_View */

