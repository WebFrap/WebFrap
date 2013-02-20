<?php

// view: assign_user_area_vid_idx
if ($this->viewExists($dbName, $schemaName, 'webfrap_acl_max_permission_view'  ) ) {
  $this->dropView($dbName, $schemaName, 'webfrap_acl_max_permission_view'  );
}

$sql = <<<SQL
CREATE VIEW {$schemaName}.webfrap_acl_max_permission_view
AS
  SELECT
    max(acl_access.access_level)  as "acl-level",
    acl_area.access_key           as "acl-area",
    acl_area.rowid                as "acl-id_area",
    acl_gu.id_user                as "acl-user",
    acl_gu.vid                    as "acl-vid",
    min(acl_gu.partial)           as "assign-partial"
  FROM
    {$schemaName}.wbfsys_group_users acl_gu
  JOIN
    {$schemaName}.wbfsys_security_access acl_access
    ON
      acl_gu.id_group = acl_access.id_group
      AND acl_gu.id_area = acl_access.id_area
      AND ( acl_access.partial = 0 OR acl_access.partial IS NULL )
  JOIN
    {$schemaName}.wbfsys_security_area acl_area
    ON
      acl_gu.id_area = acl_area.rowid
  GROUP BY
    acl_gu.id_user,
    acl_area.access_key,
    acl_gu.vid,
    acl_area.rowid,
    acl_gu.partial
;
SQL;
$this->ddl($sql );
$this->chownView(  $dbName, $schemaName, 'webfrap_acl_max_permission_view', $owner );

// view: assign_user_area_vid_idx
if ($this->viewExists($dbName, $schemaName, 'webfrap_acl_assigned_view'  ) ) {
  $this->dropView($dbName, $schemaName, 'webfrap_acl_assigned_view'  );
}
$sql = <<<SQL
CREATE  OR REPLACE VIEW {$schemaName}.webfrap_acl_assigned_view
AS
  SELECT
    max(acl_gu.partial)           as "assign-has-partial",
    min(acl_gu.partial)           as "assign-is-partial",
    acl_area.access_key           as "acl-area",
    acl_area.rowid                as "acl-id_area",
    acl_gu.id_user                as "acl-user",
    acl_gu.vid                    as "acl-vid"

  FROM
    {$schemaName}.wbfsys_group_users acl_gu

  JOIN
    {$schemaName}.wbfsys_security_area acl_area
    ON
      acl_gu.id_area = acl_area.rowid

  JOIN
    {$schemaName}.wbfsys_security_access acl_access
    ON
      acl_gu.id_group = acl_access.id_group
      AND acl_gu.id_area = acl_access.id_area
      AND ( acl_access.partial = 0 OR acl_access.partial IS NULL )
  WHERE
    acl_gu.vid is null
  GROUP BY
    acl_area.access_key,
    acl_gu.id_user,
    acl_area.rowid,
    acl_gu.vid
;

SQL;
$this->ddl($sql );
$this->chownView(  $dbName, $schemaName, 'webfrap_acl_assigned_view', $owner );

// view: assign_user_area_vid_idx
if ($this->viewExists($dbName, $schemaName, 'webfrap_inject_acls_view'  ) ) {
  $this->dropView($dbName, $schemaName, 'webfrap_inject_acls_view'  );
}

$sql = <<<SQL

CREATE OR REPLACE VIEW {$schemaName}.webfrap_inject_acls_view
  AS
  SELECT distinct
    max(acl_access.access_level)  as "acl-level",
    acl_area.access_key           as "acl-area",
    acl_area.rowid                as "acl-id_area",
    acl_gu.vid                    as "acl-vid",
    acl_gu.id_user                as "acl-user",
    acl_gu.id_group               as "acl-group"

  FROM
    {$schemaName}.wbfsys_security_area acl_area

  JOIN
    {$schemaName}.wbfsys_security_access acl_access
    ON
      acl_area.rowid = acl_access.id_area
      AND acl_access.partial = 0

  left JOIN
    {$schemaName}.wbfsys_group_users acl_gu
    ON
      ( acl_gu.partial = 0 or acl_gu.partial is null )

  WHERE
  (
    (
      acl_access.id_group = acl_gu.id_group
        and acl_gu.id_area = acl_area.rowid
    )
    OR
    (
      acl_access.id_group = acl_gu.id_group
        and acl_gu.id_area is null
        and acl_gu.vid is null
    )
  )

  GROUP BY
    acl_gu.id_user,
    acl_area.access_key,
    acl_area.rowid,
    acl_gu.vid,
    acl_gu.id_group
  ORDER BY
    "acl-level" desc

;

SQL;
$this->ddl($sql );
$this->chownView(  $dbName, $schemaName, 'webfrap_inject_acls_view', $owner );

// view: assign_user_area_vid_idx
if ($this->viewExists($dbName, $schemaName, 'webfrap_has_arearole_view'  ) ) {
  $this->dropView($dbName, $schemaName, 'webfrap_has_arearole_view'  );
}

$sql = <<<SQL

CREATE  OR REPLACE VIEW {$schemaName}.webfrap_has_arearole_view
  AS
  SELECT
    acl_area.access_key           as "acl-area",
    acl_gu.id_area                as "acl-id_area",
    acl_gu.vid                    as "acl-vid",
    acl_gu.id_user                as "acl-user",
    acl_gu.id_group               as "acl-id_group",
    group_role.access_key         as "acl-group"
  FROM
    {$schemaName}.wbfsys_security_area acl_area
  JOIN
    {$schemaName}.wbfsys_security_access acl_access
    ON
      acl_access.id_area = acl_area.rowid
        and ( acl_access.partial = 0 or acl_access.partial is null )
  JOIN
    {$schemaName}.wbfsys_group_users acl_gu
    ON
      ( acl_gu.partial = 0 or acl_gu.partial is null )

  JOIN
    {$schemaName}.wbfsys_role_group group_role
    ON
      acl_gu.id_group = group_role.rowid

 where
 (
    (
      acl_access.id_group = acl_gu.id_group
        and acl_gu.id_area = acl_area.rowid
    )
    OR
    (
      acl_access.id_group = acl_gu.id_group
        and acl_gu.id_area is null
        and acl_gu.vid is null
    )
  )
;


SQL;
$this->ddl($sql );
$this->chownView(  $dbName, $schemaName, 'webfrap_has_arearole_view', $owner );

// view: assign_user_area_vid_idx
if ($this->viewExists($dbName, $schemaName, 'webfrap_acl_level_global_asgd_view'  ) ) {
  $this->dropView($dbName, $schemaName, 'webfrap_acl_level_global_asgd_view'  );
}

/*
-- View zum laden von Rechten welche global einer Rolle zugeordnet sind
-- Wird benötigt, da in diesem Fall keine relation zwischen group_user
-- und der area besteht, daher muss die relation über den access_aufgebaut werden
 */

$sql = <<<SQL
CREATE  OR REPLACE VIEW {$schemaName}.webfrap_acl_level_global_asgd_view
AS
  SELECT
    max(acl_access.access_level)  as "acl-level",
    acl_area.access_key           as "acl-area",
    acl_area.rowid                as "acl-id_area",
    acl_gu.id_user                as "acl-user"
  FROM
    {$schemaName}.wbfsys_group_users acl_gu
  JOIN
    {$schemaName}.wbfsys_security_access acl_access
    ON
      acl_gu.id_group = acl_access.id_group
      AND
      (
        acl_access.partial = 0
          OR acl_access.partial IS NULL
       )
  JOIN
    {$schemaName}.wbfsys_security_area acl_area
    ON
      acl_access.id_area = acl_area.rowid
  WHERE
    acl_gu.id_area is null
      AND acl_gu.vid is null
      AND ( acl_gu.partial = 0 OR acl_gu.partial IS NULL )
  GROUP BY
    acl_gu.id_user,
    acl_area.access_key,
    acl_area.rowid
;

SQL;
$this->ddl($sql );
$this->chownView(  $dbName, $schemaName, 'webfrap_acl_level_global_asgd_view', $owner );

