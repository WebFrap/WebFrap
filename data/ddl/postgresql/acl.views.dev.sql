
-- Active Views

CREATE  OR REPLACE VIEW webfrap_acl_max_permission_view
AS
  SELECT
    max(acl_access.access_level)  as "acl-level",
    acl_area.access_key           as "acl-area",
    acl_area.rowid                as "acl-id_area",
    acl_gu.id_user                as "acl-user",
    acl_gu.vid                    as "acl-vid",
    min(acl_gu.partial)           as "assign-partial"
  FROM
    wbfsys_group_users acl_gu
  JOIN
    wbfsys_security_access acl_access
    ON
      acl_gu.id_group = acl_access.id_group
  JOIN
    wbfsys_security_area acl_area
    ON
      acl_gu.id_area = acl_area.rowid
  GROUP BY
    acl_gu.id_user,
    acl_area.access_key,
    acl_gu.vid,
    acl_area.rowid,
    acl_gu.partial 
;

CREATE  OR REPLACE VIEW webfrap_acl_assigned_view
AS
  SELECT
    max(acl_gu.partial)           as "assign-has-partial",
    min(acl_gu.partial)           as "assign-is-partial",
    acl_area.access_key           as "acl-area",
    acl_area.rowid                as "acl-id_area",
    acl_gu.id_user                as "acl-user",
    acl_gu.vid                    as "acl-vid"
  FROM
    wbfsys_group_users acl_gu
  JOIN
    wbfsys_security_area acl_area
    ON
      acl_gu.id_area = acl_area.rowid
  JOIN
    wbfsys_security_access acl_access
    ON
      acl_gu.id_group = acl_access.id_group
  WHERE
    acl_gu.vid is null
  GROUP BY
    acl_area.access_key,
    acl_gu.id_user,
    acl_area.rowid,
    acl_gu.vid 
;

CREATE  OR REPLACE VIEW webfrap_inject_acls_view
  AS 
  SELECT
    max(acl_access.access_level)  as "acl-level",
    acl_area.access_key           as "acl-area",
    acl_area.rowid                as "acl-id_area",
    acl_gu.vid                    as "acl-vid",
    acl_gu.id_user                as "acl-user",
    acl_gu.id_group               as "acl-group"
  FROM
    wbfsys_security_area acl_area
  JOIN
    wbfsys_group_users acl_gu
    ON
    (
      CASE WHEN
        acl_gu.id_area IS NOT NULL
      THEN
      (
        CASE WHEN
          acl_gu.vid IS NOT NULL
        THEN
          acl_access.id_group = acl_gu.id_group
            and acl_gu.id_area = acl_area.rowid
            and ( acl_gu.partial = 0 or acl_gu.partial is null )
        ELSE
          acl_access.id_group = acl_gu.id_group
            and acl_gu.id_area = acl_area.rowid
            and ( acl_gu.partial = 0 or acl_gu.partial is null )
            and acl_gu.vid is null
        END
      )
      ELSE
        acl_access.id_group = acl_gu.id_group
          and acl_gu.id_area is null
          and ( acl_gu.partial = 0 or acl_gu.partial is null )
          and acl_gu.vid is null
      END
    )
  JOIN
    wbfsys_security_access acl_access
    ON
      acl_gu.rowid = acl_access.id_area 
  where
    acl_access.partial = 0
    
  GROUP BY
    acl_gu.id_user,
    acl_area.access_key,
    acl_area.rowid,              
    acl_gu.vid,
    acl_gu.id_group
  order by
    "acl-level" desc
    
;


CREATE  OR REPLACE VIEW webfrap_has_arearole_view
  AS 
  SELECT
    acl_area.access_key           as "acl-area",
    acl_gu.id_area                as "acl-id_area",
    acl_gu.vid                    as "acl-vid",
    acl_gu.id_user                as "acl-user",
    acl_gu.id_group               as "acl-id_group",
    group_role.access_key         as "acl-group"
    
  FROM
    wbfsys_security_area acl_area
    
  JOIN
    wbfsys_group_users acl_gu
    ON
    (
      CASE WHEN
        acl_gu.id_area IS NOT NULL
      THEN
      (
        CASE WHEN
          acl_gu.vid IS NOT NULL
        THEN
          acl_access.id_group = acl_gu.id_group
            and acl_gu.id_area = acl_area.rowid
        ELSE
          acl_access.id_group = acl_gu.id_group
            and acl_gu.id_area = acl_area.rowid
            and acl_gu.vid is null
        END
      )
      ELSE
        acl_access.id_group = acl_gu.id_group
          and acl_gu.id_area is null
          and acl_gu.vid is null
      END
    )
  
  JOIN
    wbfsys_security_access acl_access
    ON
      acl_access.id_area = acl_area.rowid

  JOIN
    wbfsys_role_group group_role
    ON
      acl_gu.id_group = group_role.rowid
      
 where
   ( acl_gu.partial = 0 or acl_gu.partial is null )
    and
     ( acl_access.partial = 0 or acl_access.partial is null )
;



-- INACTIV VIEWS --


-- View to simplify the access to the acls



-- View to simplify the access to the acls

CREATE  OR REPLACE VIEW webfrap_inject_acls_by_group_view
  AS 
  SELECT
    max(acl_access.access_level)  as "acl-level",
    acl_area.access_key           as "acl-area",
    acl_area.rowid                as "acl-id_area",
    acl_gu.vid                    as "acl-vid",
    acl_gu.id_user                as "acl-user",
    acl_gu.id_group               as "acl-group"
  FROM
    wbfsys_security_area acl_area
  JOIN
    wbfsys_security_access acl_access
    ON
      acl_access.id_area = acl_area.rowid
  JOIN
    wbfsys_group_users acl_gu
    ON
    (
      CASE WHEN
        acl_gu.id_area IS NOT NULL
      THEN
      (
        CASE WHEN
          acl_gu.vid IS NOT NULL
        THEN
          acl_access.id_group = acl_gu.id_group
            and acl_gu.id_area = acl_area.rowid
            and acl_gu.partial = 0
        ELSE
          acl_access.id_group = acl_gu.id_group
            and acl_gu.id_area = acl_area.rowid
            and acl_gu.partial = 0
            and acl_gu.vid is null
        END
      )
      ELSE
        acl_access.id_group = acl_gu.id_group
          and acl_gu.id_area is null
          and acl_gu.partial = 0
          and acl_gu.vid is null
      END
    )
  where
    acl_gu.partial = 0
    
  GROUP BY
    acl_gu.id_user,
    acl_area.access_key,
    acl_area.rowid,                 
    acl_gu.vid,           
    acl_gu.id_group
;






























-- Diese View wird verwendet um die Permissions einer Person relativ
-- zu einer Security Area lesen zu können
-- anhand von user-is-partial and user-has-partial  

CREATE  OR REPLACE VIEW webfrap_load_area_permission_view
  AS 
  SELECT
    max(acl_access.access_level)  as "acl-level",
    min(acl_access.partial)       as "access-is-partial",
    max(acl_access.partial)       as "access-has-partial",
    min(acl_gu.partial)           as "assign-is-partial",
    max(acl_gu.partial)           as "assign-has-partial",
    acl_area.access_key           as "acl-area",
    acl_gu.id_area                as "acl-id_area",
    acl_gu.vid                    as "acl-vid",
    acl_gu.id_user                as "acl-user",
    acl_gu.id_group               as "acl-group"
  FROM
    wbfsys_security_area acl_area
  JOIN
    wbfsys_security_access acl_access
    ON
      acl_access.id_area = acl_area.rowid
  JOIN
    wbfsys_group_users acl_gu
    ON
    (
      CASE WHEN
        acl_gu.id_area IS NOT NULL
      THEN
        acl_access.id_group = acl_gu.id_group
          and acl_gu.id_area = acl_access.rowid
          and acl_gu.vid is null
      ELSE
        acl_access.id_group = acl_gu.id_group
          and acl_gu.id_area is null
          and acl_gu.vid is null
      END
    )
  GROUP BY
    acl_gu.id_user,
    acl_area.access_key,
    acl_gu.id_area,              
    acl_gu.vid,              
    acl_gu.id_group
;




CREATE  OR REPLACE VIEW webfrap_load_dataset_permission_view
  AS 
  SELECT
    max(acl_access.access_level)  as "acl-level",
    min(acl_access.partial)       as "access-is-partial",
    max(acl_access.partial)       as "access-has-partial",
    min(acl_gu.partial)           as "assign-is-partial",
    max(acl_gu.partial)           as "assign-has-partial",
    acl_area.access_key           as "acl-area",
    acl_gu.vid                    as "acl-id_area",
    acl_gu.vid                    as "acl-vid",
    acl_gu.id_user                as "acl-user"
  FROM
    wbfsys_security_area acl_area
  JOIN
    wbfsys_security_access acl_access
    ON
      acl_access.id_area = acl_area.rowid
  JOIN
    wbfsys_group_users acl_gu
    ON
    (
      CASE WHEN
        acl_gu.id_area IS NOT NULL
      THEN
      (
        CASE WHEN
          acl_gu.vid IS NOT NULL
        THEN
          acl_access.id_group = acl_gu.id_group
            and acl_gu.id_area = acl_area.rowid
        ELSE
          acl_access.id_group = acl_gu.id_group
            and acl_gu.id_area = acl_area.rowid
            and acl_gu.vid is null
        END
      )
      ELSE
        acl_access.id_group = acl_gu.id_group
          and acl_gu.id_area is null
          and acl_gu.vid is null
      END
    )
  GROUP BY
    acl_gu.id_user,
    acl_area.access_key,
    acl_gu.id_area,              
    acl_gu.vid
;


CREATE  OR REPLACE VIEW webfrap_acl_area_access_view
AS
 SELECT
    max(acl_access.access_level)  as "acl-level",
    acl_area.access_key           as "acl-area",
    acl_area.rowid                as "acl-id_area",
    acl_gu.id_user                as "acl-user",
    acl_access.partial            as "access-partial",
    acl_gu.partial                as "assign-partial"
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

  GROUP BY
    acl_gu.id_user,
    acl_area.access_key,
    acl_area.rowid,
    acl_access.partial,
    acl_gu.partial

;





CREATE  OR REPLACE VIEW webfrap_acl_permission_view
AS
  SELECT
    m."acl-level"             as "acl-level",
    a."assign-has-partial"    as "assign-has-partial",
    a."assign-is-partial"     as "assign-is-partial",
    m."acl-area"              as "acl-area",
    m."acl-id_area",
    m."acl-user",
    m."acl-vid"
  FROM
    webfrap_acl_assigned_view a
  LEFT JOIN
    webfrap_acl_max_permission_view m
    ON
      m."acl-id_area" = a."acl-id_area"
      and m."acl-user" = a."acl-user"
;


CREATE  OR REPLACE VIEW webfrap_acl_role_assigned_view
AS
  SELECT
    max(acl_access.partial)           as "assign-has-partial",
    min(acl_access.partial)           as "assign-is-partial",
    acl_area.access_key           as "acl-area",
    acl_area.rowid                as "acl-id_area",
    g_role.access_key             as "acl-group"

  FROM wbfsys_security_area acl_area

  JOIN
    wbfsys_security_access acl_access
    ON
      acl_access.id_area = acl_area.rowid
      
  JOIN
    wbfsys_role_group g_role
    ON
      acl_access.id_group = g_role.rowid

  GROUP BY
    acl_area.access_key,
    acl_area.rowid,
    g_role.access_key 
;



-- index auf wbfsys_group_users
CREATE INDEX assign_user_area_vid_idx 
  ON wbfsys_group_users 
  (
    id_group,
    id_user,
    id_area,
    partial,
    vid
  );
  
CREATE INDEX acl_load_dataset_permission_idx 
  ON wbfsys_group_users 
  (
    id_group,
    id_area,
    vid
  );

  
  
CREATE INDEX search_wbfsys_security_access_access_level_idx 
  ON wbfsys_security_access 
  (
    access_level
  );
  
CREATE INDEX search_wbfsys_security_area_access_key_idx 
  ON wbfsys_security_area 
  (
    access_key
  );