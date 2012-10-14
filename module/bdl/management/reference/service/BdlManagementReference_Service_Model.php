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
class BdlManagementReference_Service_Model
  extends Model
{
////////////////////////////////////////////////////////////////////////////////
// Load Methodes
////////////////////////////////////////////////////////////////////////////////
    
  /**
   * de:
   * datenquelle für einen autocomplete request
   * @param string $key
   * @param TArray $params
   */
  public function getAutolistByKey( $key, $params )
  {

    $db       = $this->getDb();
    $orm      = $db->getOrm();
    $request  = $this->getRequest();
    
    $query  = $db->newQuery( 'BdlManagementReference_Service' );
    /* @var $query BdlManagementReference_Service_Query  */
    
    $refKey = $request->param( 'ref_key', Validator::SEARCH );
    
    if( $refKey )
    {
      $refArea = $orm->getByKey( 'BdlManagementReference', $refKey );
      
      if( $refArea )
      {
        
        if( $refArea->many_to_many )
        {
          $query->setParentNode( array( $refArea->id_target, $refArea->id_connection ) );
        }
        else 
        {
          $query->setParentNode( $refArea->id_target );
        }
        
      }
    }
    else
    {
      $parentKey = $request->param( 'parent_key', Validator::TEXT );
      
      $parentArea = $orm->getByKey( 'BdlManagement', $parentKey );
      
      if( $parentArea )
        $query->setParentNode( $parentArea->getId()  );
    }

    $query->fetchAutocomplete
    (
      $key,
      $params
    );

    return $query->getAll();

  }//end public function getAutolistByKey */

}//end class BdlManagementReference_Service_Model

