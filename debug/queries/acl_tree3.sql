set search_path = production;

WITH RECURSIVE sec_tree 
 ( 
 rowid, access_key, m_parent, real_parent, target, path_area, path_real_area, depth, access_level 
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
 1 as depth, 
 0 as access_level 
 FROM wbfsys_security_area root 
 WHERE root.rowid = 141392 
 UNION ALL 
 SELECT 
 child.rowid, 
 child.access_key, 
 child.m_parent, 
 child.id_real_parent as real_parent, 
 child.id_target as target, 
 path.id_area as path_area, 
 path.id_real_area as path_real_area, 
 tree.depth + 1 as depth, 
 path.access_level as access_level 
 FROM wbfsys_security_area child 
 JOIN sec_tree tree 
   ON child.m_parent in( tree.path_area, tree.path_real_area ) 
 JOIN wbfsys_security_path path 
   ON child.rowid = path.id_reference AND path.id_group in ( 21115 ) AND path.id_root = 141392 
 WHERE 
  depth <= 3 
    AND upper(child.type_key) IN( upper('entity_reference'), upper('mgmt_reference') ) 
 ) 
 SELECT max(access_level) as level, access_key as area 
 FROM sec_tree 
 WHERE m_parent IN( 141645, 141371 ) AND depth = 3 
 GROUP BY access_key ; 