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
 * Manager Class zum bearbeiten der ACLs
 *
 * @package WebFrap
 * @subpackage tech_core
 *
 * @todo die queries müssen noch in query objekte ausgelagert werden
 *
 */
class LibAclReader_Db extends LibAclReader
{
/*//////////////////////////////////////////////////////////////////////////////
// public interface
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param LibAclAdapter_Db $adapter
   */
  public function __construct($adapter)
  {

    $this->env    = $adapter;
    $this->model  = $adapter->getModel();

  }//end public function __construct */

  
  /**
   * @param array $roles
   * @param Entity $entity
   * @param array $areas
   */
  public function getUserIdsByRolesOnEntity( $roles, $entity, $areas = array() )
  {
    
    if( !$areas ){
      $dNode = $entity->getDomainNode();
      $areas = array(   );
    }

    return $this->model->loadExplicitUsers($areas, array($entity->getId()), $roles );

  }//end public function __construct */

  /**
   * de:
   * Debug Daten in die Console pushen
   */
  public function debug( )
  {

  }//end public function debug */

}//end class LibAclReader_Db

