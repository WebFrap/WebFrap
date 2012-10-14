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
class WbfsysSecurityArea_Service_Model
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
    $request  = $this->getRequest();
    
    $query  = $db->newQuery( 'WbfsysSecurityArea_Service' );
    /* @var $query WbfsysSecurityArea_Service_Query  */
    
    $query->setType( $request->param( 'type', Validator::SEARCH ) );

    $query->fetchAutocomplete
    (
      $key,
      $params
    );

    return $query->getAll();

  }//end public function getAutolistByKey */

}//end class WbfsysSecurityArea_Service_Model

