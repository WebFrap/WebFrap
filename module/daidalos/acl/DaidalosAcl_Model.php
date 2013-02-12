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
 */
class DaidalosAcl_Model
  extends Model
{

  /**
   * Enter description here ...
   */
  public function getSecurityLevel()
  {

    $db = $this->getDb();

    $queryIdLevelListing = $db->newQuery('WbfsysSecurityLevel_Selectbox');
    $queryIdLevelListing->fetchSelectbox();

    return $queryIdLevelListing->getAll();
  }//end public function getSecurityLevel */

  /**
   * @param LibRequestHttp $request
   * @return array
   */
  public function updateArea( $request )
  {

    $orm = $this->getDb()->getOrm();

    $crit = $orm->newCriteria();

    $crit->table( 'wbfsys_security_area' );
    $crit->values( array(
      'id_level_listing' => $request->data( 'id_listing' , Validator::INT ),
      'id_level_access' => $request->data( 'id_access' , Validator::INT ),
      'id_level_insert' => $request->data( 'id_insert' , Validator::INT ),
      'id_level_update' => $request->data( 'id_update' , Validator::INT ),
      'id_level_delete' => $request->data( 'id_delete' , Validator::INT ),
      'id_level_admin' => $request->data( 'id_admin' , Validator::INT ),

      'id_ref_listing' => $request->data( 'ref_listing' , Validator::INT ),
      'id_ref_access' => $request->data( 'ref_access' , Validator::INT ),
      'id_ref_insert' => $request->data( 'ref_insert' , Validator::INT ),
      'id_ref_update' => $request->data( 'ref_update' , Validator::INT ),
      'id_ref_delete' => $request->data( 'ref_delete' , Validator::INT ),
      'id_ref_admin' => $request->data( 'ref_admin' , Validator::INT ),
    ) );

    $orm->update($crit);

  }//end public function getConnections */

  /**
   * @return array
   */
  public function dissableAllUsers(  )
  {

    $orm  = $this->getDb()->getOrm();
    $crit = $orm->newCriteria();

    $crit->table( 'wbfsys_role_user' );
    $crit->values( array(
      'inactive' => 1,
    ) );

    $orm->update($crit);

    // keep admin
    $critAdm = $orm->newCriteria();

    $critAdm->table( 'wbfsys_role_user' );
    $critAdm->values( array(
      'inactive' => 0,
    ) );
    $critAdm->where( " name='admin'  " );

    $orm->update( $critAdm );

  }//end public function dissableAllUsers */

}//end class DaidalosAcl_Model
