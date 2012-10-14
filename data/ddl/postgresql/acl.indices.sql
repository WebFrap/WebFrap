
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
    upper(access_key)
  );