<?php 

// view: view_person_role
if ($this->viewExists($dbName, $schemaName, 'view_person_role'  ) )
{
  $this->dropView($dbName, $schemaName, 'view_person_role'  );
}

$sql = <<<SQL
CREATE VIEW {$schemaName}.view_person_role AS 
 SELECT 
  core_person.rowid AS core_person_rowid, 
  core_person.firstname AS core_person_firstname, 
  core_person.lastname AS core_person_lastname, 
  core_person.academic_title AS core_person_academic_title, 
  core_person.noblesse_title AS core_person_noblesse_title, 
  wbfsys_role_user.rowid AS wbfsys_role_user_rowid, 
  wbfsys_role_user.name AS wbfsys_role_user_name
   FROM 
    {$schemaName}.wbfsys_role_user
   JOIN 
    {$schemaName}.core_person 
      ON core_person.rowid = wbfsys_role_user.id_person
  WHERE (wbfsys_role_user.inactive = FALSE OR wbfsys_role_user.inactive IS NULL );

SQL;
$this->ddl($sql );
$this->chownView(  $dbName, $schemaName, 'view_person_role', $owner );

// view: view_employee_person_role
if ($this->viewExists($dbName, $schemaName, 'view_employee_person_role'  ) )
{
  $this->dropView($dbName, $schemaName, 'view_employee_person_role'  );
}
$sql = <<<SQL
CREATE VIEW {$schemaName}.view_employee_person_role as
select
  hr_employee.rowid as empl_rowid,
  hr_employee.empl_number as empl_number,
  core_person.rowid     as person_rowid,
  core_person.firstname as firstname,
  core_person.lastname  as lastname,
  wbfsys_role_user.rowid as role_rowid,
  wbfsys_role_user.name  as role_name,
  wbfsys_role_user.email as email
  
from
  {$schemaName}.wbfsys_role_user
join 
  {$schemaName}.core_person
    on  core_person.rowid = wbfsys_role_user.id_person
join 
  {$schemaName}.hr_employee
    on  core_person.rowid = hr_employee.id_person;

SQL;
$this->ddl($sql );
$this->chownView(  $dbName, $schemaName, 'view_employee_person_role', $owner );

// view: view_user_role_contact_item
if ($this->viewExists($dbName, $schemaName, 'view_user_role_contact_item'  ) )
{
  $this->dropView($dbName, $schemaName, 'view_user_role_contact_item'  );
}
$sql = <<<SQL
CREATE VIEW {$schemaName}.view_user_role_contact_item AS 
 SELECT 
  core_person.rowid AS core_person_rowid, 
  core_person.firstname AS core_person_firstname, 
  core_person.lastname AS core_person_lastname, 
  core_person.academic_title AS core_person_academic_title, 
  core_person.noblesse_title AS core_person_noblesse_title, 
  wbfsys_role_user.rowid AS wbfsys_role_user_rowid, 
  wbfsys_role_user.name AS wbfsys_role_user_name,
  wbfsys_address_item.address_value AS wbfsys_address_item_address_value, 
  wbfsys_address_item_type.name AS wbfsys_address_item_type_name
  FROM 
    {$schemaName}.wbfsys_role_user
  JOIN 
    {$schemaName}.core_person 
      ON core_person.rowid = wbfsys_role_user.id_person
  JOIN
    {$schemaName}.wbfsys_address_item
      ON wbfsys_role_user.rowid = wbfsys_address_item.id_user
  JOIN
    {$schemaName}.wbfsys_address_item_type
      ON wbfsys_address_item_type.rowid = wbfsys_address_item.id_type
  WHERE
    wbfsys_address_item.use_for_contact = true

SQL;
$this->ddl($sql );
$this->chownView(  $dbName, $schemaName, 'view_user_role_contact_item', $owner );