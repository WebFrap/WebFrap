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
class AclMgmt_SyncGroup_Query extends LibSqlQuery
{
/*//////////////////////////////////////////////////////////////////////////////
// methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Laden aller assignten Gruppen
   *
   * @param int $areaId
   * @return void
   *
   * @throws LibDb_Exception
   */
  public function fetch($areaId)
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
      'wbfsys_security_access.rowid as "wbfsys_security_access_rowid"',
      'wbfsys_security_access.access_level as "wbfsys_security_access_access_level"',
      'wbfsys_security_access.date_start as "wbfsys_security_access_date_start"',
      'wbfsys_security_access.date_end as "wbfsys_security_access_date_end"',
      'wbfsys_security_access.id_group as "wbfsys_security_access_id_group"'
    );
    $criteria->select($cols);

    $criteria->from('wbfsys_security_access');

    $criteria->where("id_area={$areaId} and partial = 0");

    // Run Query und save the result
    $this->result    = $db->orm->select($criteria);

  }//end public function fetch */

} // end class AclMgmt_SyncGroup_Query */

