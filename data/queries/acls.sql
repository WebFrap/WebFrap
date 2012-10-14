

select 
  wbfsys_security_area.access_key,
  wbfsys_security_area.id_level,
  wbfsys_security_area.id_management,
  
	wbfsys_security_access.has_read,
	wbfsys_security_access.has_insert,
	wbfsys_security_access.has_update,
	wbfsys_security_access.has_delete,
	wbfsys_security_access.has_admin,
	
	wbfsys_security_access.has_read_own,
	wbfsys_security_access.has_insert_own,
	wbfsys_security_access.has_update_own,
	wbfsys_security_access.has_delete_own,
	wbfsys_security_access.has_admin_own

from 
  wbfsys_security_access 
  
join
  wbfsys_security_area
  on 
    wbfsys_security_access.id_area = wbfsys_security_area.rowid
  
join
  wbfsys_role_group
  on 
    wbfsys_security_access.id_group = wbfsys_role_group.rowid
    
    
    