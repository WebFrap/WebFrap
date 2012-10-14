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
 * @package WebFrapUnit
 * @subpackage WebFrap
 */
class WbfsysRoleUser_Table_Access_RootHtml
  extends LibAclPermission
{
  
  /**
   * @param TFlag $params
   * @param WbfsysRoleUser_Entity $entity
   */
  public function loadDefault( $params, $entity = null )
  {

    $params->isAclRoot     = true;
    $params->aclRoot       = 'mgmt-wbfsys_role_user';
    $params->aclRootId     = null;
    $params->aclKey        = 'mgmt-wbfsys_role_user';
    $params->aclNode       = 'mgmt-wbfsys_role_user';
    $params->aclLevel      = 1;

		$this->defLevel 				= Acl::LISTING;
		$this->setPermission( Acl::LISTING );

  }//end public function loadDefault */

}//end class WbfsysRoleUser_Table_Access_RootHtml

