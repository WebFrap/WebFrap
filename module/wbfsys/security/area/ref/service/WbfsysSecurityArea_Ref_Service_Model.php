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
 * @copyright webfrap.net <contact@webfrap.net>
 */
class WbfsysSecurityArea_Ref_Service_Model
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
    $orm       = $db->getOrm();
    $request  = $this->getRequest();
    
    $query  = $db->newQuery( 'WbfsysSecurityArea_Ref_Service' );
    /* @var $query WbfsysSecurityArea_Service_Query  */
    
    $query->setType( $request->param( 'type', Validator::SEARCH ) );
    
    $refKey = $request->param( 'ref_key', Validator::SEARCH );
    
    if( $refKey )
    {
      $refArea = $orm->getByKey( 'WbfsysSecurityArea', $refKey );
      
      if( $refArea )
      {
        if( 'S-' == substr($refArea->label, 0, 2 ) )
        {
          $query->setParentNode( $refArea->id_target  );
        }
        else 
        {
          $nextRefArea = $orm->get( 'WbfsysSecurityArea', $refArea->id_target );
          
          if( $nextRefArea )
            $query->setParentNode( $nextRefArea->id_target  );
        }
        
      }
    }
    else
    {
      $parentKey = $request->param( 'parent_key', Validator::TEXT );
      $parentArea = $orm->getByKey( 'WbfsysSecurityArea', $parentKey );
      
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

}//end class WbfsysSecurityArea_Ref_Service_Model

