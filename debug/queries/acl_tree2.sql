set search_path = production;


WITH RECURSIVE sec_tree 
( 
  rowid, 
  label, 
  access_key, 
  m_parent, 
  real_parent, 
  target, 
  area_description, 
  depth, 
  access_level, 
  assign_id, 
  path_area, 
  path_real_area, 
  description 
) 
AS 
( 
  SELECT 
	  root.rowid, 
	  root.label, 
	  root.access_key, 
	  root.m_parent, 
	  null::bigint as real_parent, 
	  root.rowid as target, 
	  root.description as area_description, 
	  1 as depth, 0 as access_level, 
	  0::bigint as assign_id, 
	  root.rowid as path_area, 
	  null::bigint as path_real_area, 
	  '' as description 
  FROM wbfsys_security_area root 
  WHERE root.rowid = 141392 
  UNION ALL 
  
  SELECT 
	  child.rowid, 
	  child.label, 
	  child.access_key, 
	  child.m_parent, 
	  child.id_real_parent as real_parent, 
	  child.id_target as target, 
	  child.description as area_description, 
	  tree.depth + 1 as depth, 
	  path.access_level as access_level, 
	  path.rowid as assign_id, 
	  path.id_area as path_area, 
	  path.id_real_area as path_real_area, 
	  path.description as description 
  FROM 
	wbfsys_security_area child 
  JOIN
    sec_tree tree
    	ON child.m_parent in( tree.path_area, tree.real_parent )
  JOIN 
	wbfsys_security_area_type 
		ON wbfsys_security_area_type.rowid = child.id_type  
			and upper(wbfsys_security_area_type.access_key) IN( upper('mgmt_reference'), upper('mgmt_element') ) 
  LEFT JOIN wbfsys_security_path path 
	ON child.rowid = path.id_reference 
		AND path.id_group = 66740 
		AND path.id_root = 141392 
  WHERE depth < 10 
) 
  SELECT 
	sec_tree.rowid, 
	sec_tree.access_key,
	sec_ac.access_key as real_parent, 
	sec_tree.m_parent, 
	real_parent, 
	target, 
	depth, 
	access_level, 
	assign_id, 
	COALESCE(path_area,sec_tree.rowid) as id_parent
  FROM sec_tree 
  left JOIN wbfsys_security_area sec_ac
	ON sec_tree.real_parent = sec_ac.m_parent; 