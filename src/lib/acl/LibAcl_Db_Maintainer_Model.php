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
 * Standard Query Objekt zum laden der Benutzer anhand der Rolle
 *
 * @package WebFrap
 * @subpackage tech_core
 */
class LibAcl_Db_Maintainer_Model extends LibAcl_Db_Model
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Zählen wieviele direkte Assignments es von einem User
   * zu einer Rolle gibt.
   * Kann relativ zu einer Area sein, muss aber nicht
   *
   * Diese Information wird benötigt um zu entscheiden ob Partial 1
   * zuweisungen mitgelöscht werden müssen
   *
   * @param int $userId
   * @param int $groupId
   * @param int $areaId
   *
   * @return int
   */
  public function hasUserRoleAssignmentsSingleArea($userId, $groupId, $areaId = null )
  {

    $condition  = '';

    if ($areaId) {

      $condition .= <<<SQL
      AND wbfsys_group_users.id_area = {$areaId}
SQL;

    }

    $query = <<<SQL
  SELECT
    count( wbfsys_group_users.rowid ) as num
  FROM
    wbfsys_group_users
  WHERE
    wbfsys_group_users.id_user = {$userId}
      AND wbfsys_group_users.id_group = {$groupId}
      AND ( wbfsys_group_users.partial = 0 OR wbfsys_group_users.partial IS NULL )
{$condition}

SQL;

    $db = $this->getDb();

    return (boolean) $db->select($query )->getField( 'num' );

  }//end public function hasRoleAssignmentsSingleArea */

  /**
   * Alle Assignments eines Users auf eine Grouppe löschen
   * Wenn areaId vorhanden werden diese nur in Relation zur Area gelöscht
   *
   * @param int $userId
   * @param int $groupId
   * @param int $areaId
   *
   * @throws LibDb_Exception wenn bei der Datenbank etwas schief geht
   */
  public function cleanUserRoleAssignmentsSingleArea($userId, $groupId, $areaId = null )
  {

    $this->getOrm()->deleteWhere
    (
      'WbfsysGroupUsers',
      " id_user={$userId} and id_group = {$groupId} ".($areaId ? " and id_area = {$areaId} ":'' )
    );

  }//end public function cleanUserRoleAssignmentsSingleArea */

  /**
   * Alle Assignments eines Users auf einen Datensatz löschen
   * Wenn areaId vorhanden werden diese nur in Relation zur Area gelöscht
   *
   * @param int $userId
   * @param int $dsetId
   * @param int $areaId
   *
   * @throws LibDb_Exception wenn bei der Datenbank etwas schief geht
   */
  public function cleanUserDsetAssignmentsSingleArea($userId, $dsetId, $areaId = null )
  {

    $this->getOrm()->deleteWhere
    (
      'WbfsysGroupUsers',
      " id_user={$userId} and vid = {$dsetId} ".($areaId ? " and id_area = {$areaId} ":'' )
    );

  }//end public function cleanUserDsetAssignmentsSingleArea */

  /**
   * Alle Assignments eines Users löschen
   * Wenn areaId vorhanden werden diese nur in Relation zur Area gelöscht
   *
   * @param int $userId
   * @param int $dsetId
   * @param int $areaId
   *
   * @throws LibDb_Exception wenn bei der Datenbank etwas schief geht
   */
  public function cleanUserAssignmentsSingleArea($userId, $areaId = null )
  {

    $this->getOrm()->deleteWhere
    (
      'WbfsysGroupUsers',
      " id_user={$userId} ".($areaId ? " and id_area = {$areaId} ":'' )
    );

  }//end public function cleanUserAssignmentsSingleArea */

  /**
   * Alle Assignments eines Users löschen
   * Wenn areaId vorhanden werden diese nur in Relation zur Area gelöscht
   *
   * @param int $userId
   * @param int $dsetId
   * @param int $areaId
   *
   * @throws LibDb_Exception wenn bei der Datenbank etwas schief geht
   */
  public function cleanGroupAssignmentsSingleArea($groupId, $areaId = null )
  {

    $this->getOrm()->deleteWhere
    (
      'WbfsysGroupUsers',
      " id_group={$groupId} ".($areaId ? " and id_area = {$areaId} ":'' )
    );

  }//end public function cleanGroupAssignmentsSingleArea */

  /**
   * delete a dataset from the database
   * @param int $objid
   * @return void
   *
   * @throws LibDb_Exception wenn bei der Datenbank etwas schief geht
   */
  public function deleteRoleAssignmentById($objid )
  {

    $this->getOrm()->delete( 'WbfsysGroupUsers', $objid );

  }//end public function deleteRoleAssignmentById */

} // end class LibAcl_Db_Cleaner_Model

