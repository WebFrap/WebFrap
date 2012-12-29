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
 * @subpackage maintenance/process
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class WebfrapMaintenance_Metadata_Model
  extends Model
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////
  
  /**
   * @var array
   */
  public $tableList = array(
    "wbfsys_desktop" => array( false ),
    "wbfsys_entity_alias" => array( false ),
    "wbfsys_entity_attribute" => array( false ),
    "wbfsys_entity_category" => array( false ),
    "wbfsys_entity_reference" => array( false ),
    "wbfsys_item" => array( false ),
    "wbfsys_management_element" => array( false ),
    "wbfsys_management_reference" => array( false ),
    "wbfsys_management" => array( false ),
    "wbfsys_mask_form_settings" => array( true ),
    "wbfsys_mask_list_settings" => array( true ),
    "wbfsys_mask" => array( false ),
    "wbfsys_module_category" => array( false ),
    "wbfsys_module" => array( false ),
    "wbfsys_service" => array( false ),
    "wbfsys_widget" => array( false ),
  );

  /**
   * @var array
   */
  public $statsData = array();
  
////////////////////////////////////////////////////////////////////////////////
// Methoden
////////////////////////////////////////////////////////////////////////////////

  /**
   * @return void
   */
  public function loadStats(  )
  {
    
    /* @var $db LibDbPostgresql */
    $db = $this->getDb();
    
    $this->statsData = array();
    
    
    $deplVal = $db->sequenceValue('wbf_deploy_revision');
    
    
    foreach( $this->tableList as $key => $data )
    {
      
      $sql = <<<SQL
SELECT
	count( rowid ) as num_old,
  "{$key}" as id,
	label,
	access_key,
	FROM {$key}
	WHERE 
		revision < {$deplVal}
 
SQL;
      $this->statsData[] = $db->select($sql)->get();
      
    }
    
  }//end public function getProcesses */
  

  
}//end class WebfrapMaintenance_Metadata_Model */

