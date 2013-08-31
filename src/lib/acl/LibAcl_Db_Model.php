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
 *
 *
 * @package WebFrap
 * @subpackage tech_core
 */
class LibAcl_Db_Model extends Model
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var array
   */
  protected $rolesCache = array();

  /**
   * Cache für varianten
   * @var array
   */
  protected $varCache = array();

  /**
   * Cache objekt für die ACLs
   * @var array
   */
  protected $aclCache = null;

  /**
   * Cache für die acl keys
   * @var array
   */
  protected $keyCache = array();

  /**
   * @param $cache
   */
  public function setAclCache($cache)
  {
    $this->aclCache = $cache;
  }//end public function setAclCache */

/*//////////////////////////////////////////////////////////////////////////////
// Zugriff auf Gruppen Rollen Daten
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @lang de:
   * Laden aller Gruppen zu denen eine Person in relation zu einem gegebenen
   * Datensatz zugehörig ist
   *
   * @param array $areas array of areas
   * @param Entity|int $id
   * @return array
   *  Alle Gruppen die in irgendeiner form dem User in Relation zu den
   *  den angegebenen Daten sind
   *
   * @throws LibAcl_Exception
   */
  public function loadUserRoles($areas = null, $id = null)
  {

    $user = $this->getUser();

    if (!$userId = $user->getId())
      throw new LibAcl_Exception('Got no User');

    $cacheKey = $this->createCacheKey('user_roles', null, $areas, $id);

    if ($this->aclCache) {
      $cached = $this->aclCache->get($cacheKey);

      if ($cached)
        return $cached;
    }

    $joins = '';
    $wheres = '';

    // wenn keine Area übergeben wurde dann brauchen wir nur die
    // globalen assignments
    if (is_null($areas)) {

      $joins = <<<SQL

  JOIN
    wbfsys_group_users
    ON
      wbfsys_group_users.id_group = wbfsys_role_group.rowid
        AND wbfsys_group_users.id_area  is null
        AND wbfsys_group_users.vid      is null
        AND (wbfsys_group_users.partial = 0 )
SQL;

    } elseif (is_null($id) || (is_object($id) && !$id->getId())  ) {

      if (is_string($areas)) {
        $areaKeys = " upper(wbfsys_security_area.access_key) = upper('{$areas}') " ;
      } else {
        $areaKeys = " upper(wbfsys_security_area.access_key)  IN(upper('".implode($areas,"'),upper('")."'))" ;
      }

      $joins = <<<SQL

  JOIN
    wbfsys_group_users
    ON
      wbfsys_group_users.id_group = wbfsys_role_group.rowid
        AND (wbfsys_group_users.partial = 0 )

  LEFT JOIN
    wbfsys_security_area
    ON
      wbfsys_group_users.id_area = wbfsys_security_area.rowid

SQL;


      $wheres = <<<SQL
AND
(
  (
    {$areaKeys}
      and wbfsys_group_users.vid is null
   )
   OR
   (
      wbfsys_group_users.id_area is null
       and wbfsys_group_users.vid is null
   )
)
SQL;

      // wbfsys_security_area.rowid = wbfsys_role_group.id_area


    } else {

      if (is_string($areas)) {
        $areaKeys = " upper(wbfsys_security_area.access_key) = upper('{$areas}') " ;
      } else {
        $areaKeys = " upper(wbfsys_security_area.access_key)  IN(upper('".implode($areas,"'),upper('")."')) " ;
      }

      $joins = <<<SQL

  JOIN
    wbfsys_group_users
    ON
      wbfsys_group_users.id_group = wbfsys_role_group.rowid
        AND (wbfsys_group_users.partial = 0 )

  LEFT JOIN
    wbfsys_security_area
    ON
      wbfsys_group_users.id_area = wbfsys_security_area.rowid

SQL;

      $wheres = <<<SQL
AND
(
  (
    {$areaKeys}
      AND wbfsys_group_users.vid = {$id}
   )
   OR
   (
      {$areaKeys}
        AND wbfsys_group_users.vid is null
   )
   OR
   (
      wbfsys_group_users.id_area is null
       and wbfsys_group_users.vid is null
   )
)
SQL;

    }


    $query = <<<SQL
  SELECT
    distinct wbfsys_role_group.rowid,
    wbfsys_role_group.access_key
  FROM
    wbfsys_role_group
{$joins}
  WHERE
    wbfsys_group_users.id_user = {$userId}
 {$wheres}

SQL;

    /// FIXME so umschreiben das nur noch partielle permissions gefunden werden
    // and wbfsys_group_users.partial = 0


    $groups = array();

    $db = $this->getDb();
    $tmp = $db->select($query)->getAll();

    foreach ($tmp as $group) {
      $groups[$group['rowid']] = $group['access_key'];
    }

    // wenn ein cache vorhanden ist cachen
    if ($this->aclCache) {
      $this->aclCache->add($cacheKey, $groups);
    }

    if (DEBUG)
      Debug::console
      (
        'Load Roles'.__METHOD__.' areas'
          .(is_array($areas)?implode(',', $areas):$areas)
        , $groups
      );

    return $groups;

  }//end public function loadUserRoles */


  /**
   * @param string $role the name of the requested role
   * @param array $area array of areas
   * @param int $id
   *
   * @return int
   */
  public function loadRole($role, $area = null, $id = null, $loadAllRoles = false)
  {

    $user = $this->getUser();
    $cache = $this->getCache()->getLevel1();


    if (!$userId = $user->getId())
      throw new LibAcl_Exception('Got no User');

    $joins = '';
    $condition = '';
    $loadKey = array();

    if (is_array($role)) {
      foreach ($role as $roleKey) {
        $loadKey[$roleKey] = $this->createCacheKey('role', $roleKey, $area, $id);
      }
    } else {
      $loadKey = $this->createCacheKey('role', $role, $area, $id);
    }

    $allKey = $allKey = $this->createCacheKey('all_roles', null, $area, $id);

    // laden aus dem cache
    if ($this->aclCache) {
      Debug::console('using cache');
      $data = $this->aclCache->get($allKey);

      if ($data) {
        Debug::console('loaded cachedata '.$allKey, $data  );
        $this->rolesCache = array_merge($data, $this->rolesCache);
      }

    } else {
      Debug::console('no cache');
    }

    // check ob bereits alle geladen wurden
    // wenn ja brauchen wir den single check nichtmehr auch wenn
    // all nicht explizit verlangt wurde
    if (!$loadAllRoles) {
      if (isset($this->varCache[$allKey])  )
        $loadAllRoles = true;
    }

    if ($loadAllRoles) {
      // wenn bereits gechecked
      if (isset($this->varCache[$allKey])) {
        // wenn nicht vorhanden setzen wir es einfach auf false

        if (is_array($loadKey)) {
          foreach ($loadKey as $key) {
            // füllt zwar auf aber nur bis zum ersten gefundenen
            if (!array_key_exists($loadKey, $this->rolesCache))
              $this->rolesCache[$key] = false;

            if ($this->rolesCache[$key])
              return true;

          }

          return false;
        } else {
          if (!array_key_exists($loadKey, $this->rolesCache))
            $this->rolesCache[$loadKey] = false;

          return $this->rolesCache[$loadKey];
        }

      }
    }

    if (is_null($area)) {

      $areaKeys = null;

      $joins = <<<SQL

  JOIN
    wbfsys_group_users
    ON
      wbfsys_group_users.id_group = wbfsys_role_group.rowid
        and wbfsys_group_users.id_area is null
        and wbfsys_group_users.vid is null
        and (wbfsys_group_users.partial = 0 )
SQL;

    } elseif (is_null($id)) {

      $areaKeys = " upper('".implode("'), upper('",$area)."') " ;

      $joins = <<<SQL

  JOIN
    wbfsys_group_users
    ON
      wbfsys_group_users.id_group = wbfsys_role_group.rowid
        AND (wbfsys_group_users.partial = 0 )

  LEFT JOIN
    wbfsys_security_area
    ON
      wbfsys_group_users.id_area = wbfsys_security_area.rowid

SQL;
      // wbfsys_security_area.rowid = wbfsys_role_group.id_area

      $condition = <<<SQL
    AND
    (
      (
        upper(wbfsys_security_area.access_key) IN({$areaKeys})
          and wbfsys_group_users.vid is null
      )
      OR
      (
        wbfsys_group_users.id_area is null
           and wbfsys_group_users.vid is null
      )
    )

SQL;


    } else {

      $areaKeys = " upper('".implode("'), upper('",$area)."') " ;

      if (is_array($id)) {
        $whereVid = " IN(".implode(', ', $id).") ";
      } else {
        $whereVid = " = {$id} ";
      }

      $joins = <<<SQL

  JOIN
    wbfsys_group_users
    ON
      wbfsys_group_users.id_group = wbfsys_role_group.rowid
        AND (wbfsys_group_users.partial = 0 )

  LEFT JOIN
    wbfsys_security_area
    ON
      wbfsys_group_users.id_area = wbfsys_security_area.rowid

SQL;

      $condition = <<<SQL
    AND
    (
      (
        upper(wbfsys_security_area.access_key) IN({$areaKeys})
          AND wbfsys_group_users.vid {$whereVid}
      )
      OR
      (
        upper(wbfsys_security_area.access_key) IN({$areaKeys})
          and wbfsys_group_users.vid is null
      )
      OR
      (
        wbfsys_group_users.id_area is null
           and wbfsys_group_users.vid is null
      )
    )

SQL;


    }



    /*
    ON
      (
        CASE
        WHEN
          wbfsys_group_users.id_area IS NOT NULL
          THEN
          {$condition2}
          ELSE
            wbfsys_group_users.id_group = wbfsys_role_group.rowid
        END
      )
     *
     */

    if ($loadAllRoles) {
      $roleCheck = '';
    } else {
      if (is_array($role)) {
        $roleCheck = "AND upper(wbfsys_role_group.access_key) IN(upper('".implode("'), upper('", $role). "'))";
      } else {
        $roleCheck = "AND upper(wbfsys_role_group.access_key) = upper('{$role}')";
      }
    }

    $query = <<<SQL
  SELECT
    count(wbfsys_role_group.rowid) as num,
    wbfsys_role_group.access_key as key
  FROM
    wbfsys_role_group
{$joins}
  WHERE
    wbfsys_group_users.id_user = {$userId}
      {$roleCheck}
{$condition}
  GROUP BY
    key; -- loadUserRoles
SQL;

    $db = $this->getDb();

    $rows = $db->select($query)->getAll();


    $cacheData = array();

    foreach ($rows as $row) {

      $tmpRole = (boolean) $row['num'];

      $cacheKey = $this->createCacheKey('role', $row['key'], $area, $id);

      $cacheData[$cacheKey] = $tmpRole;

      $this->rolesCache[$cacheKey] = $tmpRole;
    }

    if ($this->aclCache)
      $this->aclCache->add($allKey, $cacheData);

    if (is_array($role)) {
      foreach ($role as $roleKey) {
        if (isset($this->rolesCache[$loadKey[$roleKey]]) && $this->rolesCache[$loadKey[$roleKey]])
          return true;
      }
    } else {

      if (isset($this->rolesCache[$loadKey]) && $this->rolesCache[$loadKey]) {
        return true;
      }

    }

    return false;

  }//end public function loadRole */


  /**
   * Zählen wieviele User Assignments es zu einer Rolle geben kann
   *
   * @param array $area array of areas
   * @param int|Entity|[int] $id
   * @param string|[string] $role Name der Gruppenrolle
   * @param boolean $global Sollen Rechte auch von nicht explizit zugewiesenen Personen geladen werden
   *
   * @return [int:rowid][string:acces_key][int:amount]|[string:acces_key][int:amount]
   */
  public function countAreaRoles($area, $id = null, $role = null, $global = false)
  {

    $joins = '';
    $condition = '';

    // in dem fall gibt es so oder so nur global
    if (is_null($id)) {
      // wir haben eine area aber kein

      $areaKeys = " upper('".implode("'), upper('", $area)."') " ;

      if ($global) {
        $joins = <<<SQL

  JOIN
    wbfsys_group_users
    ON
      wbfsys_group_users.id_group = wbfsys_role_group.rowid

  LEFT JOIN
    wbfsys_security_area
    ON
      wbfsys_group_users.id_area = wbfsys_security_area.rowid

SQL;

        $condition = <<<SQL

    AND
    (
      (
        upper(wbfsys_security_area.access_key) IN({$areaKeys})
          and wbfsys_group_users.vid is null
      )
      OR
      (
        wbfsys_group_users.id_area is null
           and wbfsys_group_users.vid is null
      )
    )

SQL;


      } else {

        // wir haben eine area aber keine id und wollen exklusive assignments

        $joins = <<<SQL

  JOIN
    wbfsys_group_users
    ON
      wbfsys_group_users.id_group = wbfsys_role_group.rowid

  JOIN
    wbfsys_security_area
    ON
     wbfsys_group_users.id_area = wbfsys_security_area.rowid
      AND upper(wbfsys_security_area.access_key) IN({$areaKeys})
      AND wbfsys_group_users.vid is null

SQL;

      }

    } else {

      // area und vid
      $areaKeys = " upper('".implode("'), upper('", $area)."') " ;

      if (is_array($id)) {
        $whereVid = " IN(".implode(', ', $id).") ";
      } else {
        $whereVid = " = {$id} ";
      }

      if ($global) {

        $joins = <<<SQL

  JOIN
    wbfsys_group_users
    ON
      wbfsys_group_users.id_group = wbfsys_role_group.rowid

  LEFT JOIN
    wbfsys_security_area
    ON
      wbfsys_group_users.id_area = wbfsys_security_area.rowid


SQL;

        $condition = <<<SQL

    AND
    (
      (
        upper(wbfsys_security_area.access_key) IN({$areaKeys})
          and wbfsys_group_users.vid {$whereVid}
      )
      OR
      (
        upper(wbfsys_security_area.access_key) IN({$areaKeys})
          and wbfsys_group_users.vid is null
      )
      OR
      (
        wbfsys_group_users.id_area is null
           and wbfsys_group_users.vid is null
      )
    )

SQL;

      } else {

        $joins = <<<SQL

  JOIN
    wbfsys_group_users
    ON
      wbfsys_group_users.id_group = wbfsys_role_group.rowid

  JOIN
    wbfsys_security_area
    ON
      wbfsys_group_users.id_area = wbfsys_security_area.rowid
        AND UPPER(wbfsys_security_area.access_key) IN({$areaKeys})
        AND wbfsys_group_users.vid {$whereVid}

SQL;
      }

    }

    // prüfen ob wir auf eine oder mehrere rollen checken müssen
    if (is_array($role)) {
      $roleCheck = "IN(UPPER('".implode("'), UPPER('", $role). "'))";
    } else {
      $roleCheck = "= UPPER('{$role}')";
    }

    ///TODO prüfen was bei global qureries rauskommt

    // wenn nicht leer und ein array
    if ($id && is_array($id)) {

      $query = <<<SQL
  SELECT
    COUNT(wbfsys_role_group.rowid) as num,
    wbfsys_role_group.access_key,
    wbfsys_group_users.vid
  FROM
    wbfsys_role_group
{$joins}
  WHERE
    wbfsys_group_users.partial = 0
      AND UPPER(wbfsys_role_group.access_key) {$roleCheck}
{$condition}
  GROUP BY
    wbfsys_role_group.access_key,
    wbfsys_group_users.vid;
SQL;

      if (DEBUG)
        Debug::console('COUNT AREA ROLES '.$query);

      $db = $this->getDb();

      $result = $db->select($query)->getAll();

      $data = array();

      foreach ($result as $row) {
        $data[$row['vid']][$row['access_key']] = $row['num'];
      }

    } else {

      $query = <<<SQL
  SELECT
    COUNT(wbfsys_role_group.rowid) as num,
    wbfsys_role_group.access_key
  FROM
    wbfsys_role_group
{$joins}
  WHERE
    wbfsys_group_users.partial = 0
      AND UPPER(wbfsys_role_group.access_key) {$roleCheck}
{$condition}
  GROUP BY
    wbfsys_role_group.access_key;
SQL;

      if (DEBUG)
        Debug::console('COUNT AREA ROLES '.$query);

      $db = $this->getDb();

      $result = $db->select($query)->getAll();

      $data = array();

      foreach ($result as $row) {
        $data[$row['access_key']] = $row['num'];
      }

    }

    return $data;

  }//end public function countAreaRoles */


  /**
   * Zählen wieviele User Assignments es zu einer Rolle geben kann
   *
   * @param string $role Name der Gruppenrolle
   * @param array $area array of areas
   * @param int $id
   * @param boolean $global Sollen Rechte auch von nicht explizit zugewiesenen Personen geladen werden
   *
   * @return int
   */
  public function countGroupAssignment($role, $area = null, $id = null, $global = false)
  {

    $joins = '';
    $condition = '';

    // in dem fall gibt es so oder so nur global
    if (is_null($area)) {

      $joins = <<<SQL

  JOIN
    wbfsys_group_users
    ON
      wbfsys_group_users.id_group = wbfsys_role_group.rowid
        AND wbfsys_group_users.id_area is null
        AND wbfsys_group_users.vid is null
SQL;

    } elseif (is_null($id)) {
      // wir haben eine area aber kein

      $areaKeys = " upper('".implode("'), upper('",$area)."') " ;

      if ($global) {
        $joins = <<<SQL

  JOIN
    wbfsys_group_users
    ON
      wbfsys_group_users.id_group = wbfsys_role_group.rowid

  LEFT JOIN
    wbfsys_security_area
    ON
      wbfsys_group_users.id_area = wbfsys_security_area.rowid

SQL;

        $condition = <<<SQL

    AND
    (
      (
        upper(wbfsys_security_area.access_key) IN({$areaKeys})
          and wbfsys_group_users.vid is null
      )
      OR
      (
        wbfsys_group_users.id_area is null
           and wbfsys_group_users.vid is null
      )
    )

SQL;


      } else {

        // wir haben eine area aber keine id und wollen exklusive assignments

        $joins = <<<SQL

  JOIN
    wbfsys_group_users
    ON
      wbfsys_group_users.id_group = wbfsys_role_group.rowid

  JOIN
    wbfsys_security_area
    ON
     wbfsys_group_users.id_area = wbfsys_security_area.rowid
      AND upper(wbfsys_security_area.access_key) IN({$areaKeys})
      AND wbfsys_group_users.vid is null

SQL;

      }

    } else {

      // area und vid

      $areaKeys = " upper('".implode("'), upper('",$area)."') " ;

      if (is_array($id)) {
        $whereVid = " IN(".implode(', ', $id).") ";
      } else {
        $whereVid = " = {$id} ";
      }

      if ($global) {

        $joins = <<<SQL

  JOIN
    wbfsys_group_users
    ON
      wbfsys_group_users.id_group = wbfsys_role_group.rowid

  LEFT JOIN
    wbfsys_security_area
    ON
      wbfsys_group_users.id_area = wbfsys_security_area.rowid


SQL;

        $condition = <<<SQL

    AND
    (
      (
        upper(wbfsys_security_area.access_key) IN({$areaKeys})
          and wbfsys_group_users.vid {$whereVid}
      )
      OR
      (
        upper(wbfsys_security_area.access_key) IN({$areaKeys})
          and wbfsys_group_users.vid is null
      )
      OR
      (
        wbfsys_group_users.id_area is null
           and wbfsys_group_users.vid is null
      )
    )

SQL;

      } else {

        $joins = <<<SQL

  JOIN
    wbfsys_group_users
    ON
      wbfsys_group_users.id_group = wbfsys_role_group.rowid

  JOIN
    wbfsys_security_area
    ON
      wbfsys_group_users.id_area = wbfsys_security_area.rowid
        AND UPPER(wbfsys_security_area.access_key) IN({$areaKeys})
        AND wbfsys_group_users.vid {$whereVid}

SQL;
      }

    }

    // prüfen ob wir auf eine oder mehrere rollen checken müssen
    if (is_array($role)) {
      $roleCheck = "IN(UPPER('".implode("'), UPPER('", $role). "'))";
    } else {
      $roleCheck = "= UPPER('{$role}')";
    }


    $query = <<<SQL
  SELECT
    count(wbfsys_role_group.rowid) as num
  FROM
    wbfsys_role_group
{$joins}
  WHERE
    wbfsys_group_users.partial = 0
      AND upper(wbfsys_role_group.access_key) {$roleCheck}
{$condition}

SQL;

    $db = $this->getDb();

    $num = $db->select($query)->getField('num');

    return $num;

  }//end public function countGroupAssignment */

  /**
   * @param string $role the name of the requested role
   * @param array $area array of areas
   * @param int $id
   */
  public function loadRoleSomewhere($role, $keyData = array())
  {

    $user = $this->getUser();

    if (!$userId = $user->getId())
      throw new LibAcl_Exception('Got no User');

    if (is_array($role)) {
      $roleCheck = "IN(upper('".implode("'), upper('", $role). "'))";
    } else {
      $roleCheck = "= upper('{$role}')";
    }

    if ($keyData) {

      $areaKeys = "IN(upper('".implode("'), upper('", $keyData). "'))";

      $areaCheck = <<<SQL

  JOIN
    wbfsys_security_area
      ON
        wbfsys_group_users.id_area = wbfsys_security_area.rowid
          AND UPPER(wbfsys_security_area.access_key) {$areaKeys}

SQL;

    } else {
      $areaCheck = " ";
    }

    $query = <<<SQL
  SELECT
    count(wbfsys_role_group.rowid) as num
  FROM
    wbfsys_role_group
  JOIN
    wbfsys_group_users
    ON
      wbfsys_group_users.id_group = wbfsys_role_group.rowid
        AND (wbfsys_group_users.partial = 0 )
{$areaCheck}
  WHERE
    wbfsys_group_users.id_user = {$userId}
      AND upper(wbfsys_role_group.access_key) {$roleCheck}

SQL;

    $db = $this->getDb();

    return $db->select($query)->getField('num');

  }//end public function loadRoleSomewhere */

  /**
   * Explizite Rollenzugehörigkeiten auslesen
   *
   * Wird eine oder mehrere Ids angegeben, so muss die Rollen in Relation zur
   * Area und der der ID sein
   *
   * Ansonsten muss die zugehörigkeit in relation zur kompletten area sein
   *
   * @param string $role the name of the requested role
   * @param array $area array of areas
   * @param int $id
   *
   * @return int
   */
  public function hasRoleExplicit($role, $area, $id = null)
  {

    $user = $this->getUser();

    if (!$userId = $user->getId())
      throw new LibAcl_Exception('Got no User');

    $joins = '';
    $condition = '';

    $areaKeys = " upper('".implode("'), upper('",$area)."') " ;

    if (is_null($id)) {

      $joins = <<<SQL

  JOIN
    wbfsys_group_users
    ON
      wbfsys_group_users.id_group = wbfsys_role_group.rowid
        AND (wbfsys_group_users.partial = 0 )

  JOIN
    wbfsys_security_area
    ON
      wbfsys_group_users.id_group = wbfsys_role_group.rowid
        and wbfsys_group_users.id_area = wbfsys_security_area.rowid
        and upper(wbfsys_security_area.access_key) IN({$areaKeys})
        and wbfsys_group_users.vid is null

SQL;


    } else {

      if (is_array($id)) {
        $whereVid = " IN(".implode(', ', $id).") ";
      } else {
        $whereVid = " = {$id} ";
      }

      $joins = <<<SQL

  JOIN
    wbfsys_group_users
    ON
      wbfsys_group_users.id_group = wbfsys_role_group.rowid
        and (wbfsys_group_users.partial = 0 )

  JOIN
    wbfsys_security_area
    ON
      wbfsys_group_users.id_group = wbfsys_role_group.rowid
        and wbfsys_group_users.id_area = wbfsys_security_area.rowid
        and upper(wbfsys_security_area.access_key) IN({$areaKeys})
        and wbfsys_group_users.vid {$whereVid}

SQL;

    }


    if (is_array($role)) {
      $roleCheck = "IN(upper('".implode("'), upper('", $role). "'))";
    } else {
      $roleCheck = "= upper('{$role}')";
    }

    $query = <<<SQL
  SELECT
    count(wbfsys_role_group.rowid) as num
  FROM
    wbfsys_role_group
{$joins}
  WHERE
    wbfsys_group_users.id_user = {$userId}
      and upper(wbfsys_role_group.access_key) {$roleCheck}
{$condition}

SQL;

    $db = $this->getDb();

    $num = $db->select($query)->getField('num');

    if (DEBUG)
      Debug::console("hasRoleExplicit found num {$num}", $query  );

    return $num;

  }//end public function hasRoleExplicit */

  /**
   * Explizite Rollenzugehörigkeiten auslesen
   *
   * Wird eine oder mehrere Ids angegeben, so muss die Rollen in Relation zur
   * Area und der der ID sein
   *
   * Ansonsten muss die zugehörigkeit in relation zur kompletten area sein
   *
   * @param string $role the name of the requested role
   * @param array $area array of areas
   * @param int $id
   *
   * @return int
   */
  public function loadRoleExplicit($role, $area, $id = null)
  {

    $user = $this->getUser();

    if (!$userId = $user->getId())
      throw new LibAcl_Exception('Got no User');

    $joins = '';
    $condition = '';

    $areaKeys = " upper('".implode("'), upper('",$area)."') " ;

    if (is_null($id)) {

      $joins = <<<SQL

  JOIN
    wbfsys_group_users
    ON
      wbfsys_group_users.id_group = wbfsys_role_group.rowid
        and (wbfsys_group_users.partial = 0 )

  JOIN
    wbfsys_security_area
    ON
      wbfsys_group_users.id_group = wbfsys_role_group.rowid
        and wbfsys_group_users.id_area = wbfsys_security_area.rowid
        and upper(wbfsys_security_area.access_key) IN({$areaKeys})
        and wbfsys_group_users.vid is null

SQL;


    } else {

      if (is_array($id)) {
        $whereVid = " IN(".implode(', ', $id).") ";
      } else {
        $whereVid = " = {$id} ";
      }

      $joins = <<<SQL

  JOIN
    wbfsys_group_users
    ON
      wbfsys_group_users.id_group = wbfsys_role_group.rowid
        and (wbfsys_group_users.partial = 0 )

  JOIN
    wbfsys_security_area
    ON
      wbfsys_group_users.id_group = wbfsys_role_group.rowid
        and wbfsys_group_users.id_area = wbfsys_security_area.rowid
        and upper(wbfsys_security_area.access_key) IN({$areaKeys})
        and wbfsys_group_users.vid {$whereVid}

SQL;

    }


    if (is_array($role)) {
      $roleCheck = "IN(upper('".implode("'), upper('", $role). "'))";
    } else {
      $roleCheck = "= upper('{$role}')";
    }

    $query = <<<SQL
  SELECT
    wbfsys_role_group.access_key as role_name,
    wbfsys_role_group.rowid as role_id,
    wbfsys_security_area.access_key as area_name,
    wbfsys_security_area.rowid as area_id,
    wbfsys_group_users.vid as entity_id
  FROM
    wbfsys_role_group
{$joins}
  WHERE
    wbfsys_group_users.id_user = {$userId}
      and upper(wbfsys_role_group.access_key) {$roleCheck}
{$condition}

SQL;

    $db = $this->getDb();

    return $db->select($query);

  }//end public function loadRoleExplicit */

  /**
   * @lang de:
   * Laden aller Gruppen zu denen eine Person in relation zu einem gegebenen
   * Datensatz zugehörig ist
   *
   * @param array $areas array of areas
   * @param $datasets
   * @return array
   *  Alle Gruppen die in irgendeiner form dem User in Relation zu den
   *  den angegebenen Daten sind
   *
   * @throws LibAcl_Exception
   */
  public function loadUserDsetRoles($areas, array $datasets  )
  {

    $user = $this->getUser();

    if (!$userId = $user->getId())
      throw new LibAcl_Exception('Got no User');

    $joins = '';

    if (is_string($areas)) {
      $areaKeys = " upper(wbfsys_security_area.access_key) = upper('{$areas}') " ;
    } else {
      $areaKeys = " upper(wbfsys_security_area.access_key)  IN(upper('".implode($areas,"'),upper('")."'))" ;
    }

    $checkKeys = implode(',',  $datasets);

    $joins = <<<SQL

  JOIN
    wbfsys_group_users
    ON
      wbfsys_group_users.id_group = wbfsys_role_group.rowid
        AND (wbfsys_group_users.partial = 0 )

  LEFT JOIN
    wbfsys_security_area
    ON
      wbfsys_group_users.id_area = wbfsys_security_area.rowid


SQL;

    $where = <<<SQL

AND
(
  (
    {$areaKeys}
      AND wbfsys_group_users.vid IN({$checkKeys})
  )
  OR
  (
    {$areaKeys}
      AND wbfsys_group_users.vid is null
  )
  OR
  (
    wbfsys_group_users.id_area is null
      and wbfsys_group_users.vid is null
  )
)


SQL;

    $query = <<<SQL
  SELECT
    wbfsys_group_users.vid as dataset,
    wbfsys_role_group.rowid,
    wbfsys_role_group.access_key
  FROM
    wbfsys_role_group
{$joins}
  WHERE
    wbfsys_group_users.id_user = {$userId}
{$where}

SQL;

    /// FIXME so umschreiben das nur noch partielle permissions gefunden werden
    // and wbfsys_group_users.partial = 0

    $groups = array();

    $db = $this->getDb();
    $tmp = $db->select($query)->getAll();

    foreach ($tmp as $group) {

      // wenn der datensatz leer ist dann gillt die gruppenzugehörigkeit
      // für alle angefragten ids
      if (is_null($group['dataset']) || trim($group['dataset']) == '') {
        foreach ($datasets as $dataset) {
          $groups[$dataset][$group['rowid']] = $group['access_key'];
        }
      } else {
        $groups[$group['dataset']][$group['rowid']] = $group['access_key'];
      }

    }

    return $groups;

  }//end public function loadUserDsetRoles */

  /**
   * @lang de:
   * Laden aller Gruppen zu denen eine Person in relation zu einem gegebenen
   * Datensatz zugehörig ist
   *
   * @param array $areas array of areas
   * @param $datasets
   * @return array
   *  Alle Gruppen die in irgendeiner form dem User in Relation zu den
   *  den angegebenen Daten sind
   *
   * @throws LibAcl_Exception
   */
  public function loadUserDsetExplicitRoles($areas, array $datasets, array $roles = array()  )
  {

    $user = $this->getUser();

    if (!$userId = $user->getId())
      throw new LibAcl_Exception('Got no User');

     // wenn keine ids übergeben wurden einen leeren array zurückgeben
    if (!$datasets)
      return array();

    $joins = '';

    if (is_string($areas)) {
      $areaKeys = " UPPER(wbfsys_security_area.access_key) = UPPER('{$areas}') " ;
    } else {

      $areaKeys = " UPPER(wbfsys_security_area.access_key)  IN(UPPER('".implode($areas,"'),UPPER('")."'))" ;
    }

    $checkRoles = '';
    if ($roles) {

      $checkRoles = " AND UPPER(wbfsys_role_group.access_key)  IN(UPPER('".implode($roles,"'),UPPER('")."'))" ;
    }

    $checkKeys = implode(',',  $datasets);

    $joins = <<<SQL

  JOIN
    wbfsys_group_users
    ON
      wbfsys_group_users.id_group = wbfsys_role_group.rowid
        AND wbfsys_group_users.partial = 0

  JOIN
    wbfsys_security_area
    ON
      wbfsys_group_users.id_group = wbfsys_role_group.rowid
        and wbfsys_group_users.id_area = wbfsys_security_area.rowid
        and {$areaKeys}
        and wbfsys_group_users.vid IN({$checkKeys})

SQL;

    $query = <<<SQL
  SELECT
    wbfsys_group_users.vid as dataset,
    wbfsys_role_group.rowid,
    wbfsys_role_group.access_key
  FROM
    wbfsys_role_group
{$joins}
  WHERE
    wbfsys_group_users.id_user = {$userId}{$checkRoles}

SQL;

    /// FIXME so umschreiben das nur noch partielle permissions gefunden werden
    // and wbfsys_group_users.partial = 0

    $groups = array();

    $db = $this->getDb();
    $tmp = $db->select($query)->getAll();

    foreach ($tmp as $group) {

      // wenn der datensatz leer ist dann gillt die gruppenzugehörigkeit
      // für alle angefragten ids
      if (is_null($group['dataset']) || trim($group['dataset']) == '') {
        foreach ($datasets as $dataset) {
          $groups[$dataset][$group['rowid']] = $group['access_key'];
        }
      } else {
        $groups[$group['dataset']][$group['rowid']] = $group['access_key'];
      }

    }

    return $groups;

  }//end public function loadUserDsetExplicitRoles */

  /**
   * Zählen wieviele User eine Rollenzugehörigkeit zu einem Datensatz haben
   *
   * @param array $areas array of areas
   * @param $datasets
   * @return array Nach Datensätzen und Gruppen sortierte Anzahl von Benutzern
   *
   * @throws LibAcl_Exception
   */
  public function loadNumUserExplicit($areas, array $datasets, array $roles = array()  )
  {

     // wenn keine ids übergeben wurden einen leeren array zurückgeben
    if (!$datasets)
      return array();

    $joins = '';

    if (is_string($areas)) {
      $areaKeys = " UPPER(wbfsys_security_area.access_key) = UPPER('{$areas}') " ;
    } else {
      $areaKeys = " UPPER(wbfsys_security_area.access_key)  IN(UPPER('".implode($areas,"'),UPPER('")."'))" ;
    }

    $checkRoles = '';
    if ($roles) {
      $checkRoles = " WHERE UPPER(wbfsys_role_group.access_key)  IN(UPPER('".implode($roles,"'),UPPER('")."'))" ;
    }

    $checkKeys = implode(',',  $datasets);

    $joins = <<<SQL

  JOIN
    wbfsys_group_users
    ON
      wbfsys_group_users.id_group = wbfsys_role_group.rowid

  JOIN
    wbfsys_security_area
    ON
      wbfsys_group_users.id_group = wbfsys_role_group.rowid
        and wbfsys_group_users.id_area = wbfsys_security_area.rowid
        and {$areaKeys}
        and wbfsys_group_users.vid IN({$checkKeys})
        and (wbfsys_group_users.partial = 0 )

SQL;

    $query = <<<SQL
  SELECT
    count(wbfsys_group_users.id_user) as num_user,
    wbfsys_group_users.vid as dataset,
    wbfsys_role_group.access_key as group
  FROM
    wbfsys_role_group
{$joins}
{$checkRoles}
    GROUP BY
      wbfsys_group_users.vid,
      wbfsys_role_group.access_key

SQL;

    /// FIXME so umschreiben das nur noch partielle permissions gefunden werden
    // and wbfsys_group_users.partial = 0

    $groups = array();

    $db = $this->getDb();
    $tmp = $db->select($query)->getAll();

    foreach ($tmp as $group) {
      $groups[$group['dataset']][$group['group']] = $group['num_user'];
    }

    return $groups;

  }//end public function loadNumUserExplicit */

  /**
   * Zählen wieviele User eine Rollenzugehörigkeit zu einem Datensatz haben
   *
   * @param array $areas array of areas
   * @param $datasets
   * @return array Nach Datensätzen und Gruppen sortierte Anzahl von Benutzern
   *
   * @throws LibAcl_Exception
   */
  public function loadExplicitUsers($areas, array $datasets, array $roles = array(), $groupType = null  )
  {

     // wenn keine ids übergeben wurden einen leeren array zurückgeben
    if (!$datasets)
      return array();

    $joins = '';

    if (is_string($areas)) {

      $areaKeys = " UPPER(wbfsys_security_area.access_key) = UPPER('{$areas}') " ;
    } else {

      $areaKeys = " UPPER(wbfsys_security_area.access_key) IN(UPPER('".implode($areas,"'),UPPER('")."'))" ;
    }

    $checkRoles = '';
    if ($roles) {

      $checkRoles = " WHERE UPPER(wbfsys_role_group.access_key) IN(UPPER('".implode($roles,"'),UPPER('")."'))" ;
    }

    $checkKeys = implode(',',  $datasets);

    $joins = <<<SQL

  JOIN
    wbfsys_group_users
    ON
      wbfsys_group_users.id_group = wbfsys_role_group.rowid
        and (wbfsys_group_users.partial = 0 )

  JOIN
    wbfsys_security_area
    ON
      wbfsys_group_users.id_group = wbfsys_role_group.rowid
        and wbfsys_group_users.id_area = wbfsys_security_area.rowid
        and {$areaKeys}
        and wbfsys_group_users.vid IN({$checkKeys})

SQL;


    if ('full' === $groupType) {

      $query = <<<SQL
  SELECT
    distinct wbfsys_group_users.id_user as user_id,
    wbfsys_group_users.vid as dataset,
    wbfsys_role_group.access_key as group
  FROM
    wbfsys_role_group
{$joins}
{$checkRoles}

SQL;

      $users = array();

      $db = $this->getDb();
      $tmp = $db->select($query)->getAll();

      foreach ($tmp as $userNode) {
        $users[$userNode['dataset']][$userNode['group']][$userNode['user_id']] = $userNode['user_id'];
      }

    } elseif ('dataset' === $groupType) {
      $query = <<<SQL
  SELECT
    distinct wbfsys_group_users.id_user as user_id,
    wbfsys_group_users.vid as dataset
  FROM
    wbfsys_role_group
{$joins}
{$checkRoles}

SQL;


      $users = array();

      $db = $this->getDb();
      $tmp = $db->select($query)->getAll();

      foreach ($tmp as $userNode) {
        $users[$userNode['dataset']][$userNode['user_id']] = $userNode['user_id'];
      }

    } else {

      $query = <<<SQL
  SELECT
    distinct wbfsys_group_users.id_user as user_id
  FROM
    wbfsys_role_group
{$joins}
{$checkRoles}

SQL;

      $users = array();

      $db = $this->getDb();
      $tmp = $db->select($query)->getAll();

      foreach ($tmp as $userNode) {
        $users[] = $userNode['user_id'];
      }
    }

    return $users;

  }//end public function loadExplicitUsers */

/*//////////////////////////////////////////////////////////////////////////////
// Area Access
//////////////////////////////////////////////////////////////////////////////*/



 /**
  *  Beschreibung der Felder in der Rekursion:
  *
  *  child ist eine wbfsys_security_area vom type mgmt-ref, also eine Area welche
  *  eine Referenz auf Management Ebene beschreibt
  *
  *    child.rowid
  *      Die rowid des Security-Area Zielknotens vom Pfad
  *      (wird benötigt um den Graph zu erstellen)
  *
  *      child.access_key
  *        Der Access Key des Security-Area Zielknotens vom Pfad
  *
  *     child.m_parent
  *     Referenz auf die Security Area welche auf die aktuelle Security-Area verweißt
  *
  *    tree.depth + 1 as depth
  *      Die aktuelle Pfadtiefe in der Rekursion
  *
  *    path.access_level as access_level
  *      Die Berechtigung welche der Pfad dem Benutzer auf den Zielknoten zuweist
  *      (Wird im Pfad Form angezeigt und ist editierbar)
  *
  *    path.rowid as assign_id
  *      Rowid des Pfades, wir benötigt um den Pfad direkt zu adressieren
  *      (Wird zum updaten und löschen des Pfades benötigt)
  *
  *    child.id_target as target
  *      Die Ziel Security Area der Referenz Security Area
  *
  *    path.id_area as path_area
  *      Verweißt vom Pfad auf den Rootknoten des Rechtebaumes
  *
  *
  * @param array $rootArea
  * @param array $actualArea
  * @param array $roles
  * @param int $level
  */
  public function loadAccessPathChildren($rootArea, $actualArea, $roles, $level)
  {

    if (DEBUG)
      Debug::console("loadAccessPathChildren(roles: ".implode(', ',$roles).", level: $level)");

    // der user muss mitglied in einer gruppe in relation zur secarea sein
    if (empty($roles)) {

      if (DEBUG)
        Debug::console("User scheint in keiner gruppe mitglied zu sein?");

      return array();
    }

    if (!$rootId = $this->getAreaNode($rootArea)) {
      if (DEBUG)
        Debug::console("Keine Id für Area {$rootArea} bekommen");

      return array();
    }

    if (!$areaId = $this->getAreaNode($actualArea)) {
      if (DEBUG)
        Debug::console("Keine Id für Area {$actualArea} bekommen" , $actualArea);

      return array();
    }

    $db = $this->getDb();

    $groupIds = implode(',', array_keys($roles));

    $whereRootId = '';
    $whereAreaId = '';

    if (is_array($rootId)) {
      $whereRootId = " IN(".implode(',', $rootId).")";
    } else {
      if ('mgmt' == substr($rootId->parent_key,0,4))
        $whereRootId = " IN({$rootId}, {$rootId->m_parent})";
      else
        $whereRootId = " = {$rootId}";
    }

    if (is_array($areaId)) {
      $whereAreaId = " IN(".implode(',', $areaId).")";
    } else {

      if ($level >= 3) {

        $srcAreaId = null;
        $areaRowid = $areaId->getId();
        $areaSrcId = $areaId->id_source;

        if ($areaSrcId && $areaSrcId != $areaRowid)
          $srcAreaId = $this->getAreaNode($areaSrcId);

        if (!$srcAreaId = $this->getAreaNode($areaId->id_source)) {
          $whereAreaId = " IN({$areaId->id_target}, parent_path_real_area) ";
        } else {
          if ($areaId->id_target != $srcAreaId->id_target)
            $whereAreaId = " IN({$areaId->id_target}, {$srcAreaId->id_target}, parent_path_real_area)";
          else
            $whereAreaId = " IN({$areaId->id_target}, parent_path_real_area)";
        }

      } else {
        /*
        if ('mgmt' == substr($parentId->parent_key,0,4) && $parentId->m_parent)
          $whereAreaId = " IN({$parentId}, {$parentId->m_parent}, parent_path_real_area)";
        else
          $whereAreaId = " IN({$parentId}, parent_path_real_area)";
        */

        $whereAreaId = " IN({$areaId->id_target}, parent_path_real_area)";

      }

    }

     // diese Query trägt den schönen namen Ilse, weil keiner willse...
     // mit speziellem Dank an Malte Schirmacher
    $sql = <<<SQL
WITH RECURSIVE sec_tree
(
  rowid,
  access_key,
  m_parent,
  real_parent,
  target,
  path_area,
  path_real_area,
  parent_path_real_area,
  depth,
  access_level
)
AS
(
  SELECT
    root.rowid,
    root.access_key,
    root.m_parent,
    null::bigint as real_parent,
    root.rowid as target,
    root.rowid as path_area,
    null::bigint as path_real_area,
    null::bigint as parent_path_real_area,
    1 as depth,
    0 as access_level

  FROM
    wbfsys_security_area root

  WHERE
    root.rowid {$whereRootId}

  UNION ALL

  SELECT
    child.rowid,
    child.access_key,
    child.m_parent,
    child.id_real_parent as real_parent,
    child.id_target as target,
    path.id_area as path_area,
    path.id_real_area as path_real_area,
    tree.path_real_area as parent_path_real_area,
    tree.depth + 1 as depth,
    path.access_level as access_level

  FROM
    wbfsys_security_area child

  JOIN
    sec_tree tree
      ON
        child.m_parent in(tree.path_area, tree.path_real_area)
  JOIN
    wbfsys_security_path path
      ON
        child.rowid = path.id_reference
          AND path.id_group in ({$groupIds})
          AND path.id_root {$whereRootId}

  WHERE
    depth <= {$level}
    AND
      upper(child.type_key) IN(upper('entity_reference'), upper('mgmt_reference'))
)

  SELECT
    max(access_level) as level,
    access_key as area

  FROM
    sec_tree

  WHERE
    m_parent {$whereAreaId}
      OR path_real_area {$whereAreaId}
      AND depth = {$level}

  GROUP BY
    access_key
  ;

SQL;

    //

    $data = $db->select($sql)->getAll();

    $paths = array();

    foreach ($data as $node) {
      $paths[$node['area']] = $node['level'];
    }

    return $paths;

  }//end public function loadAccessPathChildren */

/*//////////////////////////////////////////////////////////////////////////////
// Area Metadaten
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @lang de
   *
   * Hilfsfunktion zum auftrennen der keychain in area tokens
   *
   * @param array/string $areas
   * @return int
   */
  public function extractAreaAccessLevel($areas)
  {

    $cacheKey = null;
    if ($this->aclCache) {
      $user = $this->getUser();
      $cacheKey = 'u:'.$user->getId().'al-a:'.(is_array($areas)?implode(',', $areas):$areas);

      Debug::console($cacheKey);

      $levels = $this->aclCache->get($cacheKey);

      if ($levels)
        return $levels;
    }

    $areaPerm = $this->loadAreaAccesslevel($areas);


    if (DEBUG)
      Debug::console("extractAreaAccessLevel ".implode(', ', $areas  ));

    if (!$areaPerm)
      return null;

    $userLevel = $this->getUser()->getLevel();

    $accessLevel = null;

    if (DEBUG)
      Debug::console("GOT USER LEVEL ".$userLevel, $areaPerm  );

    if ($userLevel >= $areaPerm['level_admin']) {
      $accessLevel = Acl::ADMIN;
    } elseif ($userLevel >= $areaPerm['level_delete']) {
      $accessLevel = Acl::DELETE;
    } elseif ($userLevel >= $areaPerm['level_update']) {
      $accessLevel = Acl::UPDATE;
    } elseif ($userLevel >= $areaPerm['level_insert']) {
      $accessLevel = Acl::INSERT;
    } elseif ($userLevel >= $areaPerm['level_access']) {
      $accessLevel = Acl::ACCESS;
    } elseif ($userLevel >= $areaPerm['level_listing']) {
      $accessLevel = Acl::LISTING;
    } else {
      $accessLevel = 0;
    }

    if (DEBUG)
      Debug::console("area access Level  $accessLevel");

    if ($this->aclCache) {
      $this->aclCache->add($cacheKey, $accessLevel);
    }

    return $accessLevel;

  }//end public function extractAreaAccessLevel */

  /**
   * @lang de
   *
   * Hilfsfunktion zum auftrennen der keychain in area tokens
   *
   * @param array/string $areas
   * @return int
   */
  public function extractAreaRefAccessLevel($areas)
  {

    $areaPerm = $this->loadAreaAccesslevel($areas);
    $userLevel = $this->getUser()->getLevel();

    $accessLevel = null;

    if ($userLevel >= $areaPerm['ref_admin']) {
      $accessLevel = Acl::ADMIN;
    } elseif ($userLevel >= $areaPerm['ref_delete']) {
      $accessLevel = Acl::DELETE;
    } elseif ($userLevel >= $areaPerm['ref_update']) {
      $accessLevel = Acl::UPDATE;
    } elseif ($userLevel >= $areaPerm['ref_insert']) {
      $accessLevel = Acl::INSERT;
    } elseif ($userLevel >= $areaPerm['ref_access']) {
      $accessLevel = Acl::ACCESS;
    } elseif ($userLevel >= $areaPerm['ref_listing']) {
      $accessLevel = Acl::LISTING;
    }

    if (DEBUG)
      Debug::console("area ref access Level  $accessLevel");

    return $accessLevel;

  }//end public function extractAreaRefAccessLevel */

  /**
   * @lang de:
   * Mit dieser Query werden ausschlieslich teilzugriffsreche ausgelesen
   *
   * @param string $areas
   */
  public function loadAreaAccesslevel($areas)
  {

    if (!$areas)
      throw new LibAcl_Exception("Tried to load rights without area");

    $cacheKey = null;
    if ($this->aclCache) {
      $user = $this->getUser();
      $cacheKey = 'u:'.$user->getId().'aal-a:'.(is_array($areas)?implode(',', $areas):$areas);

      Debug::console($cacheKey);

      $levels = $this->aclCache->get($cacheKey);

      if ($levels)
        return $levels;
    }


    if (is_array($areas)) {
      $areaKeys = "IN(upper('".implode($areas,"'),upper('")."'))" ;
    } else {
      $areaKeys = "= upper('{$areas}')" ;
    }


    $query = <<<SQL
  SELECT
    COALESCE(min(id_ref_listing),100)   as ref_listing,
    COALESCE(min(id_ref_access),100)    as ref_access,
    COALESCE(min(id_ref_insert),100)    as ref_insert,
    COALESCE(min(id_ref_update),100)    as ref_update,
    COALESCE(min(id_ref_delete),100)    as ref_delete,
    COALESCE(min(id_ref_admin),100)     as ref_admin,

    COALESCE(min(id_level_listing),100)   as level_listing,
    COALESCE(min(id_level_access),100)    as level_access,
    COALESCE(min(id_level_insert),100)    as level_insert,
    COALESCE(min(id_level_update),100)    as level_update,
    COALESCE(min(id_level_delete),100)    as level_delete,
    COALESCE(min(id_level_admin),100)     as level_admin

  FROM
    wbfsys_security_area

  WHERE
    UPPER(access_key) {$areaKeys}

SQL;

    $db = $this->getDb();
    $levels = $db->select($query)->get();

    if ($this->aclCache) {
      $this->aclCache->add($cacheKey, $levels);
    }

    return $levels;

  }//end public function loadAreaAccesslevel */


/*//////////////////////////////////////////////////////////////////////////////
// access logik:
// Wird für die Navigation benötigt, der schwerpunkt hierbei liegt auf einer
// direkten oder indirekten zuweisung der gruppe zu einer security area
//
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param array $areas Die zu prüfenden Security Areas
   * @param string $entity Der Relative Datensatz
   * @param boolean $partial genügt es partiellen zugriff zu haben oder wird
   *
   */
  public function loadParentAccess($areas, $entity = null, $partial = false)
  {

    $user = $this->getUser();

    if (!$userId = $user->getId())
      throw new LibAcl_Exception('Got no User');

    $areaKeys = "'".implode($areas,"','")."'" ;

    // wenn partial erlaub ist, dann
    if ($partial) {
      $checkPartial = '';
    } else {
      $checkPartial = ' AND (acl_access.partial = 0)';
    }


    if (is_null($entity)) {

      $query = <<<SQL
  SELECT
    max(acl_access.access_level)  as "acl-level"
  FROM
    wbfsys_security_access acl_access
  JOIN
    wbfsys_security_area acl_area
    ON
      acl_access.id_area = acl_area.rowid
  JOIN
    wbfsys_group_users acl_gu
    ON
      acl_access.id_group = acl_gu.id_group

  WHERE
    acl_area.access_key in({$areaKeys})
      and acl_gu.id_user = {$userId}
      {$checkPartial}
SQL;

    } else {

      $query = <<<SQL
  SELECT
    max(acl_access.access_level)  as "acl-level"

  FROM
    wbfsys_security_access acl_access

  JOIN
    wbfsys_security_area acl_area
    ON
      acl_access.id_area = acl_area.rowid

  JOIN
    wbfsys_group_users acl_gu
    ON
      acl_access.id_group = acl_gu.id_group

  WHERE
    acl_area.access_key in({$areaKeys})
      and acl_gu.id_user = {$userId}
      {$checkPartial}

      and
      (
        acl_gu.vid = {$entity}
          OR
        acl_gu.vid is NULL
      )

SQL;

    }

    $db = $this->getDb();

    return $db->select($query)->getField('acl-level');

  }//end public function loadParentAccess */

  /**
   * @param string $areas
   * @param string $access
   */
  public function loadAreaAccess($areas, $entity = null, $partial = false)
  {

    $user = $this->getUser();
    $cache = $this->getCache()->getLevel1();

    $cacheKey = $this->createCacheKey('area_access', null, $areas, $entity, ($partial?'p':'f'));

    if ($cache) {
      $cachedLevel = $cache->get($cacheKey);
      if (!is_null($cachedLevel))
        return $cachedLevel;
    }

    $areaKeys = "'".implode($areas,"','")."'" ;

    if (!$userId = $user->getId())
      throw new LibAcl_Exception('Got no User');

    // wenn partial erlaub ist, dann
    if ($partial) {
      $checkPartial = '';
      $checkUserPartial = '';
    } else {
      $checkPartial = ' AND (acl_access.partial = 0 )';
      $checkUserPartial = ' AND (acl_gu.partial = 0 )';
    }

    if (is_null($entity)) {

      $query = <<<SQL
  SELECT
    max(acl_access.access_level)  as "acl-level"
  FROM
    wbfsys_security_access acl_access
  JOIN
    wbfsys_security_area acl_area
    ON
      acl_access.id_area = acl_area.rowid
  JOIN
    wbfsys_group_users acl_gu
    ON
      acl_access.id_group = acl_gu.id_group
      {$checkUserPartial}
      AND acl_gu.vid is null

  WHERE
    acl_area.access_key in({$areaKeys})
      {$checkPartial}
      AND acl_gu.id_user = {$userId}

SQL;

    } else {

      $query = <<<SQL
  SELECT
    max(acl_access.access_level)  as "acl-level"
  FROM
    wbfsys_security_access acl_access
  JOIN
    wbfsys_security_area acl_area
    ON
      acl_access.id_area = acl_area.rowid
  JOIN
    wbfsys_group_users acl_gu
    ON
      acl_access.id_group = acl_gu.id_group
      {$checkUserPartial}

  WHERE
    acl_area.access_key in({$areaKeys})
      AND acl_gu.id_user = {$userId}
      {$checkPartial}
      AND
      (
        acl_gu.vid = {$entity}
          OR
        (acl_gu.vid is NULL  )
      )

SQL;

    }

    $db = $this->getDb();

    $level = $db->select($query)->getField('acl-level');

    if ($cache) {
      $cache->add($cacheKey, $level);
    }

    return $level;

  }//end public function loadAreaAccess */

  /**
   * @param string $areas
   * @param Entity $entity
   */
  public function loadAreaPermission($areas, $entity = null)
  {

    $user = $this->getUser();

    $cacheKey = null;
    if ($this->aclCache) {
      $cacheKey = 'u:'.$user->getId().'lap-a:'
        .(is_array($areas)?implode(',', $areas):$areas)
        .($entity?'e:'.$entity:'');

      Debug::console($cacheKey);

      $assign = $this->aclCache->get($cacheKey);

      if ($assign)
        return $assign;
    }

    $areaKeys = "upper('".implode($areas,"'),upper('")."')" ;

    if (!$userId = $user->getId())
      throw new LibAcl_Exception('Got no User');

    $sourceAssigned = ACL_ASSIGNED_SOURCE;
    $sourceMaxPerm = ACL_MAX_PERMISSION;

    if (is_null($entity)) {

      $query1 = <<<SQL
  SELECT
    max("acl-level") as "acl-level"
  FROM
    {$sourceMaxPerm}

  WHERE
    upper("acl-area") in({$areaKeys})
      and "acl-user" = {$userId}
      and "acl-vid" is null
      and ("assign-partial" = 0)

SQL;

      $query2 = <<<SQL
  SELECT
    "assign-is-partial",
    "assign-has-partial"
  FROM
    {$sourceAssigned}

  WHERE
    upper("acl-area") in({$areaKeys})
      and "acl-vid" is null
      and "acl-user" = {$userId}

SQL;

    } else {

      $query1 = <<<SQL
  SELECT
    max("acl-level") as "acl-level"
  FROM
    {$sourceMaxPerm}

  WHERE
    upper("acl-area") in({$areaKeys})
      and "acl-user" = {$userId}
      and ("assign-partial" = 0)
      and
      (
        "acl-vid" = {$entity}
          OR
        "acl-vid" is NULL
      )
SQL;

      $query2 = <<<SQL
  SELECT
    "assign-is-partial",
    "assign-has-partial"

  FROM
    {$sourceAssigned}

  WHERE
    upper("acl-area") in({$areaKeys})
      and "acl-user" = {$userId}
      and
      (
        "acl-vid" = {$entity}
          OR
        "acl-vid" is NULL
      )
SQL;
    }

    $db = $this->getDb();

    $level = $db->select($query1)->getField('acl-level');
    $assign = $db->select($query2)->get();

    if (DEBUG) {
      Debug::console('$level', $level);
      Debug::console('$assign', $assign);
    }

    $assign['acl-level'] = $level;

    if
    (
      isset($assign['assign-is-partial'])
        && 1 == $assign['assign-is-partial']
        && !$level
    )
    {
      $assign['acl-level'] = Acl::LISTING;

    }

    if ($this->aclCache) {
      $this->aclCache->add($cacheKey, $assign);
    }

    return $assign;

  }//end public function loadAreaPermission */

  /**
   * @param string $areas
   * @return int
   */
  public function loadGloalPermission($areas  )
  {

    $user = $this->getUser();

    $areaKeys = "upper('".implode($areas,"'),upper('")."')" ;

    if (!$userId = $user->getId())
      throw new LibAcl_Exception('Got no User');

      $query1 = <<<SQL
  SELECT
    max("acl-level") as "acl-level"
  FROM
    webfrap_acl_level_global_asgd_view

  WHERE
    upper("acl-area") in({$areaKeys})
      and "acl-user" = {$userId}
SQL;

    $db = $this->getDb();

    return $db->select($query1)->getField('acl-level');

  }//end public function loadGloalPermission */


  /**
   * @param string $areas
   * @param Entity $entity
   * @param array $roles
   */
  public function loadAreaLevel($areas, $entity = null, $roles = array())
  {

    $user = $this->getUser();

    $areaKeys = "upper('".implode($areas,"'),upper('")."')" ;

    if (!$userId = $user->getId())
      throw new LibAcl_Exception('Got no User');

    $sourceMaxPerm = ACL_MAX_PERMISSION;


    $joinGroup = '';
    $whereGroup = '';

    if ($roles) {

      $joinGroup = <<<SQL
JOIN
  wbfsys_role_group ro_group acl_gu ON acl_gu.id_group = ro_group.rowid
SQL;

      $whereGroup = " AND UPPER(ro_group.access_key) IN (upper('".implode($roles,"'),upper('")."')) ";

    }

    if ($entity) {
      $whereVid = <<<SQL
      AND
      (
        acl_gu.vid = {$entity}
          OR
        acl_gu.vid is NULL
      )
SQL;

    } else {
      $whereVid = " acl_gu.vid is null " ;
    }

    $query = <<<SQL

SELECT
  max(acl_access.access_level) AS "acl-level"

FROM
  wbfsys_security_access acl_access

JOIN
  wbfsys_security_area acl_area ON acl_access.id_area = acl_area.rowid

JOIN
  wbfsys_group_users acl_gu ON acl_access.id_group = acl_gu.id_group

{$joinGroup}

WHERE
    UPPER(wbfsys_security_area.access_key) in({$areaKeys})
      AND acl_gu.id_user = {$userId}
      AND (acl_gu.partial = 0)
      AND (acl_access.partial = 0)
      {$whereGroup}
      {$whereVid}

SQL;


    $db = $this->getDb();

    $level = $db->select($query)->getField('acl-level');

    return $level;

  }//end public function loadAreaLevel */


 /**
  *  Beschreibung der Felder in der Rekursion:
  *
  *  child ist eine wbfsys_security_area vom type mgmt-ref, also eine Area welche
  *  eine Referenz auf Management Ebene beschreibt
  *
  *    child.rowid
  *      Die rowid des Security-Area Zielknotens vom Pfad
  *      (wird benötigt um den Graph zu erstellen)
  *
  *      child.access_key
  *        Der Access Key des Security-Area Zielknotens vom Pfad
  *
  *     child.m_parent
  *     Referenz auf die Security Area welche auf die aktuelle Security-Area verweißt
  *
  *    tree.depth + 1 as depth
  *      Die aktuelle Pfadtiefe in der Rekursion
  *
  *    path.access_level as access_level
  *      Die Berechtigung welche der Pfad dem Benutzer auf den Zielknoten zuweist
  *      (Wird im Pfad Form angezeigt und ist editierbar)
  *
  *    path.rowid as assign_id
  *      Rowid des Pfades, wir benötigt um den Pfad direkt zu adressieren
  *      (Wird zum updaten und löschen des Pfades benötigt)
  *
  *    child.id_target as target
  *      Die Ziel Security Area der Referenz Security Area
  *
  *    path.id_area as path_area
  *      Verweißt vom Pfad auf den Rootknoten des Rechtebaumes
  *
  *
  * @param $root
  *   wird benötigt um den passenden startpunkt zu finden
  *
  * @param $rootId
  *   die id des root datensatzes
  *
  * @param $level
  *   das level in dem wir uns aktuell befinden
  *
  * @param $parentKey
  *   parent wird benötigt da es theoretisch auf dem gleichen level mehrere nodes des gleichen types geben kann
  *
  * @param $parentId
  *   die id des parent nodes
  *
  * @param $nodeKey
  *   der key des aktuellen reference node
  *
  * @param $roles
  *   gruppen rollen in denen der user sich relativ zum rootnode befinden
  */
  public function loadAccessPathNode
  (
    $root,      // wird benötigt um den passenden startpunkt zu finden
    $rootId,    // der access_key der root area
    $level,     // das level in dem wir uns aktuell befinden
    $parentKey, // parent wird benötigt da es theoretisch auf dem gleichen level mehrere nodes des gleichen types geben kann
    $parentId,  // die id des parent nodes
    $nodeKey,   // der key des aktuellen reference node
    $roles      // gruppen rollen in denen der user sich relativ zum rootnode befinden
  )
  {

    if (DEBUG)
      Debug::console("loadAccessPathNode root: {$root}, rootId: $rootId, level: $level, parentKey: $parentKey, parentId: $parentId, nodeKey: $nodeKey ");

    ///@todo fehler besser behandeln und i18n für das error handling

    if (empty($roles)) {
      if (DEBUG)
        Debug::console("User scheint in keiner Gruppe Mitglied zu sein?");

      return array();
    }

    if (!$rootId = $this->getAreaNode($root)) {
      if (DEBUG)
        Debug::console("Keine Id für Area {$root} bekommen");

      return array();
    }

    if (!$parentId = $this->getAreaNode($parentKey)) {
      if (DEBUG)
        Debug::console("Keine Id für Parent Area {$parentKey} bekommen");

      return array();
    }

    if (!$nodeId = $this->getAreaNode($nodeKey)) {
      if (DEBUG)
        Debug::console("Keine Id für Area {$nodeKey} bekommen");

      return array();
    }

    $groupIds = implode(',', array_keys($roles));

    $whereRootId = '';
    $whereAreaId = '';
    $whereNodeId = '';

    if (is_array($rootId)) {
      $whereRootId = " IN(".implode(',', $rootId).")";
    } else {

      if ('mgmt' == substr($rootId->parent_key,0,4))
        $whereRootId = " IN({$rootId}, {$rootId->m_parent})";
      else
        $whereRootId = " = {$rootId}";
    }

    if (is_array($parentId)) {
      $whereAreaId = " IN(".implode(',', $parentId).")";
    } else {

      // ab level 3 ist der parent eine referenz area
      // level 2 ist der parent eine management area
      if ($level >= 3) {
        $srcAreaId = null;
        $areaRowid = $parentId->getId();
        $areaSrcId = $parentId->id_source;

        if ($areaSrcId && $areaSrcId != $areaRowid)
          $srcAreaId = $this->getAreaNode($areaSrcId);

        if (!$srcAreaId) {

          if ('' == trim($parentId->id_target)) {
            if (DEBUG)
              Debug::console("No parentId->id_target 1 $parentKey", $parentId->getData(), true);

            return array();
          }

          $whereAreaId = " = {$parentId->id_target} ";
        } else {

          if ('' == trim($parentId->id_target)) {
            if (DEBUG)
              Debug::console("No parentId->id_target 2 $parentKey", $parentId);

            return array();
          }

          if ($parentId->id_target != $srcAreaId->id_target)
            $whereAreaId = " IN({$parentId->id_target}, {$srcAreaId->id_target})";
          else
            $whereAreaId = " = {$parentId->id_target} ";
        }
      } else {

        if ('' == trim($parentId->parent_key)) {
          if (DEBUG)
            Debug::console("No parentId->id_target 3 $parentKey", $parentId);

          return array();
        }


        if ('mgmt' == substr($parentId->parent_key,0,4))
          $whereAreaId = " IN({$parentId}, {$parentId->m_parent})";
        else
          $whereAreaId = " = {$parentId}";
      }


    }

    if (is_array($nodeId)) {
      $whereNodeId = " IN(".implode(',', $nodeId).") AND";
    } else {
      if ('' == trim($nodeId->source_key)) {
        if (DEBUG)
          Debug::console("Node Source Key war leer $nodeId");
        //return array();
        $whereNodeId = " UPPER(access_key) = UPPER('{$nodeKey}') AND "; // sicher stellen dass nur ein datensatz kommt
      }

      // der hauptknoten verweißt auf entity, damit verweisen alle mit mgmt
      // auf dern Hauptknoten und dieser muss dazugezogen werden um
      // den pfad zu vererben
      else if ('mgmt' == substr($nodeId->source_key,0,4) && $nodeId->id_source)
        $whereNodeId = "rowid  IN({$nodeId}, {$nodeId->id_source}) AND";
      else
        $whereNodeId = "rowid = {$nodeId} AND";
    }

     // diese Query trägt den schönen namen Ilse, weil keiner willse...
     // mit speziellem Dank an Malte Schirmacher
    $sql = <<<SQL
WITH RECURSIVE sec_tree
(
  rowid,
  access_key,
  m_parent,
  real_parent,
  parent_key,
  depth,
  access_level,
  target,
  path_area,
  path_real_area
)
AS
(
  SELECT
    root.rowid,
    root.access_key,
    root.m_parent,
    null::bigint real_parent,
    root.parent_key,
    1 as depth,
    0 as access_level,
    root.rowid as target,
    root.rowid as path_area,
    null::bigint as path_real_area

  FROM
    wbfsys_security_area root

  WHERE
    root.rowid {$whereRootId}

  UNION ALL

  SELECT
    child.rowid,
    child.access_key,
    child.m_parent,
    child.id_real_parent as real_parent,
    child.parent_key,
    tree.depth + 1 as depth,
    path.access_level as access_level,
    child.id_target as target,
    path.id_area as path_area,
    path.id_area as path_real_area

  FROM
    wbfsys_security_area child

  JOIN
    sec_tree tree
      ON
        child.m_parent in(tree.path_area, tree.real_parent)
  JOIN
    wbfsys_security_path path
      ON
        child.rowid = path.id_reference
          AND path.id_group in ({$groupIds})
          AND path.id_root {$whereRootId}

  WHERE
    depth <= {$level}
    and upper(child.type_key) IN(upper('mgmt_reference'), upper('mgmt_element'))
)

  SELECT
    max(access_level) as "acl-level",
    access_key as area

  FROM
    sec_tree

  WHERE
    {$whereNodeId}
         depth = {$level}

  GROUP BY
    access_key
  ;

SQL;

    //   m_parent {$whereAreaId} AND

    /// FIXME anstelle von id_target muss die rowid und die id des knotens geprüft werden

    // ok da sollte eigentlich nur noch eine reihe kommen
    // oder keine
    return $this->getDb()->select($sql)->get();


  }//end public function loadAccessPathNode */

  /**
   * @param string $areas
   */
  public function loadUserAreaPermissions($areas  )
  {

    $areaKeys = " upper('".implode("'), upper('", $areas)."') " ;

    $user = $this->getUser();

    if (!$userId = $user->getId())
      throw new LibAcl_Exception('Got no User');

    $condition = <<<SQL
  JOIN
    wbfsys_group_users
    ON
    (
      CASE WHEN
        wbfsys_group_users.id_area IS NOT NULL
      THEN
        wbfsys_security_access.id_group = wbfsys_group_users.id_group
          and wbfsys_group_users.id_area = wbfsys_security_area.rowid
          and wbfsys_group_users.vid is null
      ELSE
        wbfsys_security_access.id_group = wbfsys_group_users.id_group
          and wbfsys_group_users.id_area is null
          and wbfsys_group_users.vid is null
      END
    )

SQL;

    $query = <<<SQL
  SELECT
    max(wbfsys_security_access.access_level) as access_level,
    min(wbfsys_security_access.partial) as access_partial,
    min(wbfsys_group_users.partial) as assign_partial
  FROM
    wbfsys_security_access
  JOIN
    wbfsys_security_area
    ON
      wbfsys_security_access.id_area = wbfsys_security_area.rowid
  JOIN
    wbfsys_role_group
    ON
      wbfsys_security_access.id_group = wbfsys_role_group.rowid
{$condition}

  WHERE
    upper(wbfsys_security_area.access_key) in({$areaKeys})
      and wbfsys_group_users.id_user = {$userId}

SQL;

    return $this->db->select($query)->getField('access_level');

  }//end public function loadUserAreaPermissions */

/*//////////////////////////////////////////////////////////////////////////////
//
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @lang de:
   * Die rowid einer bestimmten area erfragen
   *
   * @param string $key
   * @return int
   */
  public function getAreaId($key)
  {

    if ($this->aclCache) {
      $id = $this->aclCache->get('secarea-'.$key);
      if ($id)
        return $id;
    }

    $orm = $this->getDb()->getOrm();

    $area = $orm->get('WbfsysSecurityArea', "upper(access_key)=upper('{$key}')");

    // wenn keine area gefunden wurde wird null zurückgegeben
    if (!$area)
      return null;

    $areaId = $area->getid();

    if ($this->aclCache) {
      $this->aclCache->add('secarea-'.$key, $areaId);
    }

    return $areaId;

  }//end public function getAreaId */

  /**
   * @lang de:
   * Die rowid einer bestimmten area erfragen
   *
   * @param string $key
   * @return WbfsysSecurityArea_Entity
   */
  public function getAreaNode($key)
  {

    $orm = $this->getDb()->getOrm();

    if (is_array($key))
      $area = $orm->getByKeys('WbfsysSecurityArea', $key);
    else if (is_numeric($key))
      $area = $orm->get('WbfsysSecurityArea', $key);
    else
      $area = $orm->getByKey('WbfsysSecurityArea', $key);

    // wenn keine area gefunden wurde wird null zurückgegeben
    if (!$area)
      return null;

    return $area;

  }//end public function getAreaNode */

  /**
   * @lang de:
   * Die rowid einer bestimmten area erfragen
   *
   * @param string $key
   * @return WbfsysSecurityArea_Entity
   */
  public function getAreaNodes($key)
  {

    $orm = $this->getDb()->getOrm();

    if (is_array($key)) {
      $area = $orm->getByKeys('WbfsysSecurityArea', $key);
    } else {
      $area = $orm->getByKey('WbfsysSecurityArea', $key);
    }

    // wenn keine area gefunden wurde wird null zurückgegeben
    if (!$area)
      return null;

    return $area;

  }//end public function getAreaNode */

  /**
   * Erstellen eines neuen Gruppen / Secarea assignment
   *
   * @param string $areaKeys
   */
  public function getAreaIds($areaKeys)
  {

    if (is_string($areaKeys))
      $keys = $this->extractWeightedKeys($areaKeys);
    else
      $keys = $areaKeys;

    if (!$keys)
      return null;

    $cacheKey = null;
    if ($this->aclCache) {
      $cacheKey = 'secareas:'.implode("'-'", $keys);
      $ids = $this->aclCache->get($cacheKey);
      if ($ids)
        return $ids;
    }

    // laden der mvc/utils adapter Objekte
    $db = $this->getDb();
    $orm = $db->getOrm();

    $where = "UPPER('".implode("'), UPPER('", $keys)."')";

    $ids = $orm->getIds
    (
      "WbfsysSecurityArea",
      "UPPER(access_key) IN({$where})"
    );

    if ($this->aclCache) {
      $this->aclCache->add($cacheKey, $ids);
    }

    return $ids;

  }//end public function getAreaIds */

  /**
   * @lang de
   *
   * Hilfsfunktion zum auftrennen der keychain in area tokens
   *
   * @param array/string $keys
   * @return array
   */
  public function extractKeys($keys)
  {

    $keysData = array();

    if (is_array($keys)) {
      foreach ($keys as $subKey) {
        $tmp = explode(':', $subKey);

        $areas = explode('/', $tmp[0]);
        $access = $tmp[1];

        $keysData[] = array($areas, $access);
      }
    } else {
      $tmp = explode(':', $keys);

      $areas = explode('/', $tmp[0]);
      $access = $tmp[1];

      $keysData[] = array($areas, $access);

    }

    return $keysData;

  }//end public function extractKeys */

  /**
   * Erstellen eines eindeutigen cache keys
   *
   * Liste der key typen:
   * -
   *
   * @param string $key
   * @param string $role
   * @param string $area
   * @param string $id
   * @param string $post
   */
  protected function createCacheKey
  (
    $key,
    $role = null,
    $area = null,
    $id = null,
    $post = null
  ) {

    $user = $this->getUser();

    $loadKey = 'u:'.$user->getId().',k:'.$key.':';

    if ($role) {
      if (is_array($role))
        $loadKey .= 'r:'.implode(',r:', $role).',';
      else
        $loadKey .= 'r:'.$role.',';
    }

    if ($area) {
      if (is_array($area)) {
        $loadKey .= 'a:'.implode(',a:', $area).',';
      } else {
        $loadKey .= 'a:'.$area.',';
      }
    }

    if ($id) {
      if (is_array($id)) {
        $loadKey .= 'e:'.implode(',e:', $id).',';
      } else {
        $loadKey .= 'e:'.$id.',';
      }
    }

    if ($post)
      $loadKey .= ",{$post}";

    return $loadKey;

  }//end protected function createCacheKey */

  /**
   * @lang de
   *
   * Hilfsfunktion zum auftrennen der keychain in area tokens
   *
   * @param array/string $keys
   * @return array
   */
  public function extractWeightedKeys($keys)
  {

    if (isset($this->keyCache[$keys]))
      return $this->keyCache[$keys];

    $keysData = array();

    $tmp = explode('>', $keys);
    $areas = explode('/', $tmp[0]);

    $wAreas = array();
    if (isset($tmp[1]))
      $wAreas = explode('/', $tmp[1]);;

    $keysData = array_merge($areas, $wAreas);

    $this->keyCache[$keys] = $keysData;

    return $keysData;

  }//end public function extractWeightedKeys */

} // end class LibAcl_Db_Model

