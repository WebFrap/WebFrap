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
 * Read before change:
 * It's not recommended to change this file inside a Mod or App Project.
 * If you want to change it copy it to a custom project.

 *
 * @package WebFrap
 * @subpackage ModEnterprise
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright webfrap.net <contact@webfrap.net>
 */
class MaintenanceEntity_Model
  extends Model
{
////////////////////////////////////////////////////////////////////////////////
// protocol
////////////////////////////////////////////////////////////////////////////////

  /**
   * create a table item for the entity
   *
   * @param DomainNode $domainNode
   * @param TFlag $params named parameters
   * @return WebfrapProtocol_Query
   */
  public function getEntityProtocol( $domainNode, $params  )
  {

    $db = $this->getDb();

    // if not create a default method an just fetch
    $query = $db->newQuery( 'WebfrapProtocol' );
    $query->fetchEntityProtocol( $domainNode->domainKey, $params );

    return $query;

  }//end public function getEntityProtocol */

  /**
   *
   * @param DomainNode $domainNode
   * @param int $objid
   * @param TFlag $params named parameters
   * @return WebfrapProtocol_Query
   */
  public function getDatasetProtocol( $domainNode, $objid, $params  )
  {

    $db = $this->getDb();

    // if not create a default method an just fetch
    $query = $db->newQuery( 'WebfrapProtocol' );
    $query->fetchDatasetProtocol( $domainNode->domainKey, $objid, $params );

    return $query;

  }//end public function getDatasetProtocol */

}//end class MaintenanceEntity_Model
