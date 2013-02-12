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
 * @subpackage Acl
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright webfrap.net <contact@webfrap.net>
 */
class AclMgmt_SyncAssignment_Query
  extends LibSqlQuery
{
////////////////////////////////////////////////////////////////////////////////
// methodes
////////////////////////////////////////////////////////////////////////////////

  /** build criteria, interpret conditions and load data
   *
   * @param int $areaId
   *
   * @return void
   *
   * @throws LibDb_Exception
   */
  public function fetch( $areaId )
  {

    $this->sourceSize  = null;
    $db                = $this->getDb();

    if (!$this->criteria) {
      $criteria = $db->orm->newCriteria();
    } else {
      $criteria = $this->criteria;
    }

    $cols = array
    (
      'wbfsys_group_users.rowid as "wbfsys_group_users_rowid"',
      'wbfsys_group_users.vid as "wbfsys_group_users_vid"',
      'wbfsys_group_users.id_user as "wbfsys_group_users_id_user"',
      'wbfsys_group_users.id_group as "wbfsys_group_users_id_group"',
      'wbfsys_group_users.date_start as "wbfsys_group_users_date_start"',
      'wbfsys_group_users.date_end as "wbfsys_group_users_date_end"'
    );

    $criteria->select( $cols );

    $criteria->from( 'wbfsys_group_users' );

    $criteria->where
    (
      "wbfsys_group_users.id_area={$areaId} and wbfsys_group_users.partial = 0"
    );

    // Run Query und save the result
    $this->result  = $db->orm->select( $criteria );

  }//end public function fetch */

} // end class AclMgmt_SyncAssignment_Query */
