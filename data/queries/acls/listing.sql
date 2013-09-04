set search_path = production;

SELECT 
  inner_acl.rowid, 
  inner_acl."acl-level", 
  inner_acl."acl-area"
  FROM (
   SELECT 
    project_activity.rowid as rowid, 
    greatest ( 0, acls."acl-level", back_path.access_level ) as "acl-level" , 
    acls."acl-area"
FROM project_activity 
  LEFT JOIN project_activity_category project_activity_category 
    ON project_activity.id_category = project_activity_category.rowid 
  LEFT JOIN project_activity_type project_activity_type 
    ON project_activity.id_type = project_activity_type.rowid 
  LEFT JOIN wbfsys_process_node wbfsys_process_node 
    ON project_activity.id_status = wbfsys_process_node.rowid 
  LEFT JOIN project_activity_profile_software 
    ON project_activity.rowid = project_activity_profile_software.id_project 
  LEFT JOIN project_task 
    ON project_activity.id_task = project_task.rowid 

  LEFT JOIN webfrap_area_user_level_view  acls ON  
    acls."acl-user" = 189423 
    AND acls."acl-area" IN('mgmt-project_activity') 
    AND ( acls."acl-vid" = project_activity.rowid OR acls."acl-vid" is null ) 

  LEFT JOIN wbfsys_security_backpath back_path
    ON back_path.id_area = (select rowid from wbfsys_security_area where access_key = 'mgmt-project_activity')

  LEFT JOIN webfrap_area_user_level_view as back_acls ON  
    back_path.id_target_area = back_acls."acl-id_area"
    AND back_acls."acl-user" = 189423
    AND(
      ( 
        back_acls."acl-area" IN('mod-enterprise', 'mgmt-enterprise_org_unit') 
        AND ( back_acls."acl-vid" = project_activity.id_org_unit OR back_acls."acl-vid" is null ) 
      )
    )


  ) inner_acl


LIMIT 20
  
WHERE "acl-level" > 0 ;


