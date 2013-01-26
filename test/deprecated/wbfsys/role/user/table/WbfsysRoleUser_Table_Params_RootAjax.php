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
class WbfsysRoleUser_Table_Params_RootAjax
  extends TFlag
{    
  /**
   * Befüllen der Flag Variante Root HTML
   * Es wird ein Zugriff auf über Access Root auf das Element simuliert
   * Rückgabe soll reines HTML sein
   *
   */
  public function __construct()
  {
			
    // importieren der daten
    $this->content = array
    (
    	'ltype' 			=> 'table',
    	//'append'		=> false,
      'isAclRoot'   => true,
      'aclRoot'     => 'mgmt-wbfsys_role_user',
      'aclRootId'   => null,
      'aclKey'      => 'mgmt-wbfsys_role_user',
      'aclNode'     => 'mgmt-wbfsys_role_user',
      'aclLevel'    => 1,
			'categories' 	=> array(),
			'start' 			=> 0,
			'qsize' 			=> Wgt::$defListSize,
			'fullLoad' 		=> true,
    );

  }//end protected function __construct */
    
}//end class WbfsysRoleUser_Table_ParamsVarRootAjax */
