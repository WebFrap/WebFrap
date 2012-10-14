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
 * @subpackage ModBdl
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright webfrap.net <contact@webfrap.net>
 */
class BdlManagementReference_Service_Query_Postgresql
  extends LibSqlQuery
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

   /**
    * Filter Variable parentNode
    * @var $type
    */
    public $parentNode = null;
      
////////////////////////////////////////////////////////////////////////////////
// Getter & Setter
////////////////////////////////////////////////////////////////////////////////

 
   /**
    * filter by parentNode
    * @param string $parentNode
    */
    public function setParentNode( $parentNode )
    {
    
      $this->parentNode = $parentNode;
      
    }//end public function setParentNode */
  
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


    
    $criteria->select( array
    (
      'bdl_management_reference.access_key as id',
      'bdl_management_reference.access_key as value',
      'bdl_management_reference.access_key as label'
    ));
    $criteria->from( 'bdl_management_reference' );
    $criteria->limit( 20 );
    $criteria->where( "upper(bdl_management_reference.access_key) like upper('%{$db->addSlashes( $key )}%')" );

    if( $this->parentNode )
    {
      if( is_array($this->parentNode) )
      {
        $criteria->filter(" bdl_management_reference.id_source IN(".implode(', ', $this->parentNode).")   ");
      }
      else 
      {
        $criteria->filter(" bdl_management_reference.id_source = ".$this->parentNode."   ");
      }
      
    }
    
    // Run Query und save the result
    $this->result = $db->orm->select( $criteria );

  }//end public function fetchAutocomplete */

}//end class BdlManagementReference_Service_Query_Postgresql

