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
class AclMgmt_Dset_Query extends LibSqlQuery
{/*//////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Loading the tabledata from the database
   * @param int $areaId
   * @param TFlag $params
   * @return void
   *
   * @throws LibDb_Exception
   */
  public function fetchGroups($areaid, $params = null )
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
      ON wbfsys_security_access.id_group =  wbfsys_role_group.rowid
  WHERE
    wbfsys_security_access.id_area = {$areaid}

  ORDER BY
    wbfsys_role_group.name

SQL;

    $this->data = $db->select($sql )->getAll();

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
  public function fetchUsersByKey($areaId, $key, $params = null )
  {

    if (!$params)
      $params = new TFlag();

    $this->sourceSize  = null;
    $db                = $this->getDb();

    $tmp = explode(',',$key);

    $wheres = array();

    foreach($tmp as $value )
    {
    
      $safeVal = $db->addSlashes( trim($value ) );
      
      if ( '' == $safeVal )
        continue;
    
      $wheres[] = " upper(wbfsys_role_user.name) like upper('{$safeVal}%')
        or upper(core_person.lastname) like upper('{$safeVal}%')
        or upper(core_person.firstname) like upper('{$safeVal}%') ";
    }

    $sqlWhere = "(".implode(' or ',$wheres).")";

    $sql = <<<SQL
  SELECT
    wbfsys_role_user.rowid as id,
    COALESCE ( '('||wbfsys_role_user.name||') ', '' ) || COALESCE ( core_person.lastname || ', ' || core_person.firstname, core_person.lastname, core_person.firstname, '' ) as value,
    COALESCE ( '('||wbfsys_role_user.name||') ', '' ) || COALESCE ( core_person.lastname || ', ' || core_person.firstname, core_person.lastname, core_person.firstname, '' ) as label

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
            wbfsys_group_users.id_area = {$areaId}
              AND wbfsys_group_users.vid is null
          )
            OR wbfsys_group_users.id_area is null
    )
  LIMIT 10;
SQL;

    $this->result = $db->select($sql );

  }//end public function fetchUsersByKey */

} // end class AclMgmt_Dset_Query */

