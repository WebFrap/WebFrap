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
class WbfsysSecurityArea_Service_Query_Postgresql
  extends LibSqlQuery
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////
        
   /**
    * Filter Variable type
    * @var $type
    */
    public $type = null;
      
////////////////////////////////////////////////////////////////////////////////
// Getter & Setter
////////////////////////////////////////////////////////////////////////////////
        
   /**
    * filter by type
    * @param string $type
    */
    public function setType( $type )
    {
    
      $this->type = $type;
      
    }//end public function settype */
      
////////////////////////////////////////////////////////////////////////////////
// Query Logic
////////////////////////////////////////////////////////////////////////////////
    
  /**
   * Loading the tabledata from the database
   * @param string $key
   * @return void
   *
   * @throws LibDb_Exception
   */
  public function fetchAutocomplete( $key )
  {

    $this->sourceSize  = null;
    $db                = $this->getDb();

    $criteria = $db->orm->newCriteria();

    
    // wenn der parameter  nicht vorhanden ist
    // bleibt das result per definition leer
    if( !$this->type )
    {
      $this->data = array();
      return;
    }
      
    
    $criteria->select( array
    (
      'wbfsys_security_area.access_key as id',
      'wbfsys_security_area.access_key as value',
    'wbfsys_security_area.access_key as label'
    ));
    $criteria->from( 'wbfsys_security_area' );
    $criteria->joinOn
    ( 
      'wbfsys_security_area', 
      'id_type',
      'wbfsys_security_area_type', 
      'rowid'
    );
    
    $criteria->limit( 20 );
    $criteria->where( "upper(wbfsys_security_area.access_key) like upper('{$db->addSlashes( $key )}%')" );

    $criteria->filter
    ("
       wbfsys_security_area_type.access_key        = '".$this->type."'    ");

    
    // Run Query und save the result
    $this->result = $db->orm->select( $criteria );

  }//end public function fetchAutocomplete */

}//end class WbfsysSecurityArea_Service_Query_Postgresql

