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
 * @subpackage Taskplanner
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class WebfrapMaintenance_Metadata_List_Menu extends WgtSimpleListmenu
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/
  
  public $listActions = <<<JSON
[ 
	{  
		"type" : "request", 
		"label": "", 
		"icon": "control/delete.png", 
		"method": "del", 
		"service": "ajax.php?c=Webfrap.TaskPlanner.deletePlan&objid="  
	}
]
JSON;

}//end class WebfrapTaskPlanner_List_Ajax_View

