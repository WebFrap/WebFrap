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
 *
 */
class DaidalosSystem_Query extends LibSqlQuery
{

  /**
   * Loading the tabledata from the database
   *
   * @param string $key
   * @param TFlag $params
   * @return void
   *
   * @throws LibDb_Exception
   */
  public function fetchUsersByKey($key, $params = null )
  {

    if (!$params)
      $params = new TFlag();

    $this->sourceSize  = null;
    $db                = $this->getDb();

    $tmp = explode(',',$key);

    $wheres = array();

    foreach ($tmp as $value) {
      $wheres[] = " upper(wbfsys_role_user.name) like upper('{$key}%')
        or upper(core_person.lastname) like upper('{$key}%')
        or upper(core_person.firstname) like upper('{$key}%') ";
    }

    $sqlWhere = "(".implode(' or ',$wheres).")";

    $sql = <<<SQL
  SELECT
    wbfsys_role_user.name as id,
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
  LIMIT 10;
SQL;

    $this->result = $db->select($sql );

  }//end public function fetchUsersByKey */

} // end class DaidalosDb_Controller

