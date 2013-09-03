set search_path = production;

  SELECT 
  inner_acl.rowid, max(inner_acl."acl-level") as "acl-level"
  FROM (
   SELECT 
    project_activity.rowid as rowid, 
    greatest ( 0, acls."acl-level", back_acls."acl-level" ) as "acl-level" , 
    wbfsys_process_node.m_order as "wbfsys_process_node-m_order-order" 
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
    AND acls."acl-area" IN('mod-project', 'mgmt-project_activity') 
    AND ( acls."acl-vid" = project_activity.rowid OR acls."acl-vid" is null ) 

  LEFT JOIN wbfsys_security_backpath back_path
    ON back_path.id_area = acls."acl-area_id"

  LEFT JOIN webfrap_area_user_level_view as back_acls ON  
    back_path.id_target_area =  back_acls."acl-area_id"
    AND acls."acl-user" = 189423
    AND(
      ( 
		
      )
    )

  )