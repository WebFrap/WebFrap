SET search_path = sdb;

create view view_person_role as
select

  core_person.rowid     as core_person_rowid,
  core_person.firstname as core_person_firstname,
  core_person.lastname  as core_person_lastname,
  wbfsys_role_user.rowid as wbfsys_role_user_rowid,
  wbfsys_role_user.name  as wbfsys_role_user_name,
  wbfsys_role_user.email as wbfsys_role_user_email
  
from
  wbfsys_role_user
  
join 
  core_person
    on  core_person.rowid = wbfsys_role_user.id_person;
    
    
create view view_employee_person_role as
select
  enterprise_employee.rowid as empl_rowid,
  enterprise_employee.empl_number as empl_number,
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
  enterprise_employee
    on  core_person.rowid = enterprise_employee.id_person;
    
    


    