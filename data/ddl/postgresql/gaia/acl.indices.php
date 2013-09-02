<?php

// index: assign_user_area_vid_idx
if ($this->tableIndexExists($dbName, $schemaName, 'wbfsys_group_users', 'assign_user_area_vid_idx'  )) {
  $this->dropTableIndex($dbName, $schemaName, 'assign_user_area_vid_idx'  );
}

$sql = <<<SQL
CREATE INDEX assign_user_area_vid_idx
  ON {$schemaName}.wbfsys_group_users
  (
    id_group,
    id_user,
    id_area,
    partial,
    vid
  );

SQL;
$this->ddl($sql);

// index: acl_load_dataset_permission_idx
if ($this->tableIndexExists($dbName, $schemaName, 'wbfsys_group_users', 'acl_load_dataset_permission_idx'  )) {
  $this->dropTableIndex($dbName, $schemaName, 'acl_load_dataset_permission_idx'  );
}
$sql = <<<SQL
CREATE INDEX acl_load_dataset_permission_idx
  ON {$schemaName}.wbfsys_group_users
  (
    id_group,
    id_area,
    vid
  );

SQL;
$this->ddl($sql);


// index: search_wbfsys_security_access_access_level_idx
if ($this->tableIndexExists($dbName, $schemaName, 'wbfsys_security_access', 'search_wbfsys_security_access_access_level_idx'  )) {
  $this->dropTableIndex($dbName, $schemaName, 'search_wbfsys_security_access_access_level_idx'  );
}
$sql = <<<SQL
CREATE INDEX search_wbfsys_security_access_access_level_idx
  ON {$schemaName}.wbfsys_security_access
  (
    access_level
  );

SQL;
$this->ddl($sql);


// index: search_wbfsys_security_area_access_key_idx
if ($this->tableIndexExists($dbName, $schemaName, 'wbfsys_security_area', 'search_wbfsys_security_area_access_key_idx'  )) {
  $this->dropTableIndex($dbName, $schemaName, 'search_wbfsys_security_area_access_key_idx'  );
}
$sql = <<<SQL
CREATE INDEX search_wbfsys_security_area_access_key_idx
  ON {$schemaName}.wbfsys_security_area
  (
    access_key
  );

SQL;
$this->ddl($sql);
