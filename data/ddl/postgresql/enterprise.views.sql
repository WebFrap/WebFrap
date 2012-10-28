-- View: view_enterprise_participants

-- DROP VIEW view_enterprise_participants;

CREATE OR REPLACE VIEW view_enterprise_participants AS 
 SELECT 
  enterprise_participant.rowid AS part_id, 
  COALESCE
	( 
	  pers.lastname || ', ' || pers.firstname, 
	  pers.lastname,
	  pers.firstname,
	  ''
	)
	||
  COALESCE
  ( 
    comp.shortname || ', ' || comp.name, 
    comp.name,
    ''
  )
  ||
  COALESCE
  ( 
    consortium.name
    ''
  ) as display_name,
  enterprise_participant.id_type,
  COALESCE
  ( 
    pers.rowid,
    comp.rowid,
    consortium.rowid,
    0
  ) as vid
  
  FROM 
    enterprise_participant
    
  LEFT JOIN 
    core_person 
      ON core_person.rowid = enterprise_participant.id_person
      
  LEFT JOIN
    enterprise_company
      ON enterprise_company.rowid = enterprise_participant.id_company
      
  JOIN
    enterprise_consortium
      ON enterprise_consortium.rowid = enterprise_participant.id_consortium

      
-- ALTER TABLE view_enterprise_participants OWNER TO owner;