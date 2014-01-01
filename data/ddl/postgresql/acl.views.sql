
-- Activ Views

CREATE OR REPLACE VIEW webfrap_acl_max_permission_view
AS
  SELECT
    max(acl_access.access_level) as "acl-level",
    max(acl_access.ref_access_level) as "ref-level",
    min(acl_gu.partial) as "assign-partial",
    acl_area.access_key as "acl-area",
    acl_area.rowid as "acl-id_area",
    acl_gu.id_user as "acl-user",
    acl_gu.vid as "acl-vid"
  FROM
    wbfsys_group_users acl_gu
  JOIN
    wbfsys_security_access acl_access
    ON
      acl_gu.id_group = acl_access.id_group
      AND acl_gu.id_area = acl_access.id_area
      AND ( acl_access.partial = 0 OR acl_access.partial IS NULL )
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



CREATE OR REPLACE VIEW webfrap_inject_acls_view
  AS 
  SELECT distinct
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
      acl_area.rowid = acl_access.id_area
      AND acl_access.partial = 0
    
  left JOIN
    wbfsys_group_users acl_gu
    ON
      acl_gu.partial = 0

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
    wbfsys_security_access acl_access
    ON
      acl_access.id_area = acl_area.rowid
        and ( acl_access.partial = 0 or acl_access.partial is null )
  JOIN
    wbfsys_group_users acl_gu
    ON
      acl_gu.partial = 0

  JOIN
    wbfsys_role_group group_role
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


-- View zum laden von Rechten welche global einer Rolle zugeordnet sind
-- Wird benötigt, da in diesem Fall keine relation zwischen group_user
-- und der area besteht, daher muss die relation über den access_aufgebaut werden

CREATE  OR REPLACE VIEW webfrap_acl_level_global_asgd_view
AS
  SELECT
    max(acl_access.access_level)  as "acl-level",
    acl_area.access_key           as "acl-area",
    acl_area.rowid                as "acl-id_area",
    acl_gu.id_user                as "acl-user"
  FROM
    wbfsys_group_users acl_gu
  JOIN
    wbfsys_security_access acl_access
    ON
      acl_gu.id_group = acl_access.id_group
      AND acl_access.partial = 0
  JOIN
    wbfsys_security_area acl_area
    ON
      acl_access.id_area = acl_area.rowid
  WHERE
    acl_gu.id_area is null
      AND acl_gu.vid is null
      AND acl_gu.partial = 0
  GROUP BY
    acl_gu.id_user,
    acl_area.access_key,
    acl_area.rowid
;

CREATE  OR REPLACE VIEW webfrap_area_group_level_view
AS
  SELECT
	  max(acl_access.access_level) AS "acl-level", 
	  max(acl_access.ref_access_level) AS "ref-level",
	  acl_area.access_key AS area_key, 
	  acl_area.rowid AS id_area, 
	  acl_access.id_group AS id_group, 
	  acl_group.access_key AS group_key
  FROM wbfsys_security_access acl_access 
  JOIN wbfsys_security_area acl_area ON acl_access.id_area = acl_area.rowid
  JOIN wbfsys_role_group acl_group ON acl_access.id_group = acl_group.rowid
  WHERE
	  acl_access.partial = 0
  GROUP BY 
	  acl_access.id_group, 
	  acl_group.access_key,
	  acl_area.access_key, 
	  acl_area.rowid;
	  
	  
CREATE OR REPLACE VIEW webfrap_area_user_level_view
  AS 
  SELECT distinct
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
      acl_area.rowid = acl_access.id_area
      AND acl_access.partial = 0
    
  left JOIN
    wbfsys_group_users acl_gu
    ON
      acl_gu.partial = 0

  AND
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
;


CREATE OR REPLACE VIEW webfrap_area_gruser_level_view
  AS 
  SELECT distinct
    max(acl_access.access_level)  as "acl-level",
    acl_area.access_key           as "acl-area",
    acl_area.rowid                as "acl-id_area",
    acl_gu.vid                    as "acl-vid",
    acl_gu.id_user                as "acl-user",
    acl_gu.id_group               as "acl-group",
    acl_group.access_key          as "acl-group_key"
    
  FROM
    wbfsys_security_area acl_area
    
  JOIN
    wbfsys_security_access acl_access
    ON
      acl_area.rowid = acl_access.id_area
      AND acl_access.partial = 0
    
  left JOIN
    wbfsys_group_users acl_gu
    ON
      acl_gu.partial = 0
    
  JOIN
    wbfsys_role_group acl_group
    ON
      acl_group.rowid = acl_gu.id_group

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
    acl_gu.id_group,
    acl_group.access_key
;

-- view welche das maximale level eines users in relation
-- von ihm direkt zugewiesenen gruppen / area relations zurückgibt

CREATE OR REPLACE VIEW webfrap_area_level_by_user_view
  AS 
  SELECT distinct
    max(acl_access.access_level) as max_level,
    acl_area.rowid as id_area,
    acl_gu.vid as vid,
    acl_gu.id_user as id_user,
    acl_gu.id_group as id_group
    
  FROM
    wbfsys_security_area acl_area
    
  JOIN
    wbfsys_security_access acl_access
    ON
      acl_area.rowid = acl_access.id_area
      AND acl_access.partial = 0
    
  left JOIN
    wbfsys_group_users acl_gu
    ON
      acl_gu.partial = 0

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
    acl_area.rowid,              
    acl_gu.vid,
    acl_gu.id_group
;
