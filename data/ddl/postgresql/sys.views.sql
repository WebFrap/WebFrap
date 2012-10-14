-- View: view_person_role

-- DROP VIEW view_person_role;

CREATE OR REPLACE VIEW view_person_role AS 
 SELECT 
  core_person.rowid AS core_person_rowid, 
  core_person.firstname AS core_person_firstname, 
  core_person.lastname AS core_person_lastname, 
  core_person.academic_title AS core_person_academic_title, 
  core_person.noblesse_title AS core_person_noblesse_title, 
  wbfsys_role_user.rowid AS wbfsys_role_user_rowid, 
  wbfsys_role_user.name AS wbfsys_role_user_name,
  
  COALESCE 
  ( 
    wbfsys_role_user.name, '' 
  ) || 
  COALESCE 
  ( 
    ' &lt;' || core_person.lastname || ', ' || core_person.firstname || '&gt;', 
    ' &lt;' || core_person.lastname || '&gt;', 
    ' &lt;' || core_person.firstname || '&gt;', 
    '' 
  ) as fullname
   FROM 
    wbfsys_role_user
   JOIN 
    core_person 
      ON core_person.rowid = wbfsys_role_user.id_person
  WHERE (wbfsys_role_user.inactive = FALSE OR wbfsys_role_user.inactive IS NULL );

-- ALTER TABLE view_person_role OWNER TO owner;

    
    
CREATE OR REPLACE VIEW view_employee_person_role as
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
  wbfsys_role_user
join 
  core_person
    on  core_person.rowid = wbfsys_role_user.id_person
join 
  hr_employee
    on  core_person.rowid = hr_employee.id_person;
      
      
-- View: view_person_role

-- DROP VIEW view_person_role;

CREATE OR REPLACE VIEW view_user_role_contact_item AS 
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
    wbfsys_role_user
  JOIN 
    core_person 
      ON core_person.rowid = wbfsys_role_user.id_person
  JOIN
    wbfsys_address_item
      ON wbfsys_role_user.rowid = wbfsys_address_item.id_user
  JOIN
    wbfsys_address_item_type
      ON wbfsys_address_item_type.rowid = wbfsys_address_item.id_type
  WHERE
    wbfsys_address_item.use_for_contact = true
      
-- ALTER TABLE view_person_role OWNER TO owner;