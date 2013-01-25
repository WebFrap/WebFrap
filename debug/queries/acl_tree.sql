set search_path = production;

WITH RECURSIVE sec_tree ( rowid, label, access_key, m_parent, depth, access_level, assign_id, target, the_parent, area_description, description ) 
AS ( 
	SELECT root.rowid, root.label, root.access_key, root.m_parent, 1 as depth, 0 as access_level, 0::bigint as assign_id, root.rowid as target, 
	root.rowid as the_parent, root.description as area_description, '' as description 
	FROM wbfsys_security_area root WHERE root.rowid = 141392 
	UNION ALL 
	SELECT 
	child.rowid, child.label, child.access_key, child.m_parent, tree.depth + 1 as depth, path.access_level as access_level, 
	path.rowid as assign_id, child.id_target as target, path.id_area as the_parent, child.description as area_description, 
	path.description as description 
	FROM wbfsys_security_area child 
	JOIN sec_tree tree ON tree.the_parent = child.m_parent 
	JOIN wbfsys_security_area_type on wbfsys_security_area_type.rowid = child.id_type and upper(wbfsys_security_area_type.access_key) 
	IN( upper('mgmt_reference'), upper('mgmt_element') ) 
	LEFT JOIN wbfsys_security_path path ON child.rowid = path.id_reference AND path.id_group = 153139 AND path.id_root = 141392 
	WHERE depth < 10 ) 
SELECT 
sec_tree.rowid, 
sec_tree.access_key,
sac.access_key as parent_mask, 
sac2.access_key as parent_mask2, 
sec_tree.m_parent, sec_tree.depth, sec_tree.access_level, sec_tree.assign_id, sec_tree.target, 
COALESCE(the_parent,sec_tree.rowid) as id_parent
FROM sec_tree
JOIN wbfsys_security_area sac on sec_tree.m_parent = sac.rowid
JOIN wbfsys_security_area sac2 on sac.m_parent = sac2.rowid; 