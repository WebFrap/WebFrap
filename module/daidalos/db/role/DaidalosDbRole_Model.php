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
class DaidalosDbRole_Model extends Model
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

/*//////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return array liste der Views
   */
  public function getLoginRoles()
  {

    $db = $this->getDb();

    $sql = <<<SQL
SELECT
  oid,
  *,
  pg_catalog.shobj_description(oid, 'pg_authid') AS description
FROM
  pg_authid
WHERE rolcanlogin
ORDER BY rolname

SQL;

    $sql .= ";";

    return $db->select($sql)->getAll();

  }//end public function getLoginRoles */

  /**
   * @return array liste der Views
   */
  public function getRoles()
  {

    $db = $this->getDb();

    $sql = <<<SQL
SELECT
  oid,
  *,
  pg_catalog.shobj_description(oid, 'pg_authid') AS description
FROM
  pg_authid
WHERE NOT rolcanlogin
ORDER BY rolname

SQL;

    $sql .= ";";

    return $db->select($sql)->getAll();

  }//end public function getRoles */



  /**
   * @param string $roleName
   */
  public function createRole($roleName)
  {

    $db = $this->getDb();

    $sql = <<<SQL
CREATE ROLE {$roleName}
 VALID UNTIL 'infinity';

SQL;

    $sql .= ";";

    return $db->exec($sql);

  }//end public function createRole */

}//end class DaidalosDbView_Model

