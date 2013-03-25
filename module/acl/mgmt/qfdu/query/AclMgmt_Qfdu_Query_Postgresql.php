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
class AclMgmt_Qfdu_Query_Postgresql extends LibSqlQuery
{
/*//////////////////////////////////////////////////////////////////////////////
// fetch methodes
//////////////////////////////////////////////////////////////////////////////*/

 /**
   * Loading the tabledata from the database
   * @param int $areaId
   * @param TFlag $params
   * @return void
   *
   * @throws LibDb_Exception
   */
  public function fetchAreaGroups($areaId, $params = null)
  {

    if (!$params)
      $params = new TFlag();

    $this->sourceSize  = null;
    $db                = $this->getDb();

    $sql = <<<SQL
  SELECT
    distinct wbfsys_role_group.rowid as id,
    wbfsys_role_group.name as value

  FROM
    wbfsys_role_group

  JOIN
    wbfsys_security_access
      ON
        wbfsys_role_group.rowid = wbfsys_security_access.id_group

  WHERE
    wbfsys_security_access.id_area = {$areaId}
    and
      (wbfsys_security_access.partial = 0 or wbfsys_security_access.partial is null)
SQL;

    $this->result = $db->select($sql);

  }//end public function fetchAreaGroups */

  /**
   * Loading the tabledata from the database
   *
   * @param int $areaId
   * @param string $key
   * @param TFlag $params
   * @return void
   *
   * @throws LibDb_Exception
   */
  public function fetchUsersByKey($areaId, $key, $params = null)
  {

    if (!$params)
      $params = new TFlag();

    $this->sourceSize  = null;
    $db                = $this->getDb();

    $tmp = explode(',', $key);

    $wheres = array();

    foreach ($tmp as $value) {

      $safeVal = $db->addSlashes(trim($value));

      if ('' == $safeVal)
        continue;

      $wheres[] = " upper(wbfsys_role_user.name) like upper('{$safeVal}%')
        or upper(core_person.lastname) like upper('{$safeVal}%')
        or upper(core_person.firstname) like upper('{$safeVal}%') ";
    }

    $sqlWhere = "(".implode(' or ',$wheres).")";

    $sql = <<<SQL
  SELECT
    wbfsys_role_user.rowid as id,
    COALESCE ('('||wbfsys_role_user.name||') ', '') || COALESCE (core_person.lastname || ', ' || core_person.firstname, core_person.lastname, core_person.firstname, '') as value,
    COALESCE ('('||wbfsys_role_user.name||') ', '') || COALESCE (core_person.lastname || ', ' || core_person.firstname, core_person.lastname, core_person.firstname, '') as label
  FROM
    wbfsys_role_user
  JOIN
    core_person
    ON
      core_person.rowid = wbfsys_role_user.id_person
  WHERE
    {$sqlWhere}
    AND NOT wbfsys_role_user.rowid IN
    (
      SELECT
        wbfsys_group_users.rowid
          FROM
            wbfsys_group_users
          WHERE
            (
              (
                wbfsys_group_users.id_area = {$areaId}
                  AND wbfsys_group_users.vid IS null
              )
              OR
                wbfsys_group_users.id_area IS null
            )
            AND
              (wbfsys_group_users.partial = 0 OR wbfsys_group_users.partial IS null)
    )
  LIMIT 10;
SQL;

    $this->result = $db->select($sql);

  }//end public function fetchUsersByKey */

  /**
   * @lang de
   * Laden der Autoload Daten für die Entity Search Box
   *
   * @param int $areaId
   * @param string $key
   * @param TFlag $params
   * @return void
   *
   * @throws LibDb_Exception
   */
  public function fetchTargetEntityByKey($areaId, $key, $params = null)
  {

    if (!$params)
      $params = new TFlag();

    $this->sourceSize  = null;
    $db                = $this->getDb();

    $tmp = explode(',', $key);

    $wheres = array();

    foreach ($tmp as $value) {
      $safeVal = $db->addSlashes(trim($value));

      if ('' == trim($safeVal))
        continue;

      $wheres[] = " upper(enterprise_employee.rowid) like upper('{$safeVal}%') ";
    }

    $sqlWhere = "(".implode(' or ',$wheres).")";

    $sql = <<<SQL
  SELECT
    enterprise_employee.rowid as id,
    enterprise_employee.rowid as value,
    enterprise_employee.rowid as label
  FROM
    enterprise_employee
  WHERE
    {$sqlWhere}
  LIMIT 10;
SQL;

    $this->result = $db->select($sql);

  }//end public function fetchTargetEntityByKey */

} // end class AclMgmt_Qfdu_Query_Postgresql */

