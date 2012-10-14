
-- View to simplify the access to the acls


-- View zum auslesen eines aktuellen Prozess Status
CREATE  OR REPLACE VIEW webfrap_process_status_view
  AS 
  SELECT
    process.name    as "process_name",
    process.rowid   as "process_id",
    status.id_start_node    as "start_node",
    status.id_actual_node   as "actual_nod",
    status.value_highest_node  as "highest_node",
    status.vid              as "dataset_id"
  FROM
    wbfsys_process process
  JOIN
    wbfsys_process_status status
    ON
      status.id_process = process.rowid

;

-- index für das schnelle updaten eines Prozesstatus
CREATE INDEX update_process_status_idx 
  ON wbfsys_process_status 
  (
    vid,
    id_process
  );