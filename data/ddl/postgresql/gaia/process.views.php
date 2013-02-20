<?php

// view: assign_user_area_vid_idx
if ($this->viewExists($dbName, $schemaName, 'webfrap_process_status_view'  ) ) {
  $this->dropView($dbName, $schemaName, 'webfrap_process_status_view'  );
}
$sql = <<<SQL
CREATE VIEW {$schemaName}.webfrap_process_status_view
  AS
  SELECT
    process.name    as "process_name",
    process.rowid   as "process_id",
    status.id_start_node    as "start_node",
    status.id_actual_node   as "actual_nod",
    status.value_highest_node  as "highest_node",
    status.vid              as "dataset_id"
  FROM
    {$schemaName}.wbfsys_process process
  JOIN
    {$schemaName}.wbfsys_process_status status
    ON
      status.id_process = process.rowid
;
SQL;
$this->ddl($sql );
$this->chownView(  $dbName, $schemaName, 'webfrap_process_status_view', $owner );


// index: webfrap_acl_assigned_view
if ($this->tableIndexExists($dbName, $schemaName, 'wbfsys_process_status', 'update_process_status_idx'  ) ) {
  $this->dropTableIndex($dbName, $schemaName, 'update_process_status_idx'  );
}
// -- index für das schnelle updaten eines Prozesstatus
$sql = <<<SQL
CREATE INDEX update_process_status_idx
  ON {$schemaName}.wbfsys_process_status
  (
    vid,
    id_process
  );
SQL;

$this->ddl($sql );
