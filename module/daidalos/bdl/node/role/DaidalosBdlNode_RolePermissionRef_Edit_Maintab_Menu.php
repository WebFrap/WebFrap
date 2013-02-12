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
 * @subpackage Daidalos
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class DaidalosBdlNode_RolePermissionRef_Edit_Maintab_Menu
  extends DaidalosBdl_Mvcbase_PermissionRef_Edit_Maintab_Menu
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * Der domainkey
   * eg: profile
   * @var string
   */
  public $domainKey = 'role';

  /**
   * Domain Class Part
   * eg: Profile
   * @var string
   */
  public $domainClass = 'Role';

}//end class DaidalosBdlNode_ProfilePermissionRef_Edit_Maintab_Menu */
