<?php
/*******************************************************************************
*
* @author      : Dominik Bonsch <dominik.bonsch@webfrap.net>
* @date        :
* @copyright   : Webfrap Developer Network <contact@webfrap.net>
* @project     : Webfrap Web Frame Application
* @projectUrl  : http://webfrap.net
*
* @licence     : BSD License see: LICENCE/BSD Licence.txt
* 
* @version: @package_version@  Revision: @package_revision@
*
* Changes:
*
*******************************************************************************/


/**
 * @package WebFrap
 * @subpackage Core
 * @author Dominik Bonsch
 * @copyright Dominik Bonsch <dominik.bonsch@webfrap.net>
 */
class ProcessBase_Query_Postgresql
  extends ProcessBase_Query
{


  /*
CREATE TABLE production.wbfsys_process_step
(
  id_from integer,
  id_to integer,
  id_type integer,
  id_process integer,
  "comment" text,
  rowid integer NOT NULL DEFAULT nextval('webfrap.entity_oid_seq'::regclass),
  m_time_created timestamp without time zone,
  m_role_create integer,
  m_time_changed timestamp without time zone,
  m_role_change integer,
  m_version integer,
  m_uuid uuid,
  rate integer,
  CONSTRAINT wbfsys_process_step_pkey PRIMARY KEY (rowid)
)
WITH (
  OIDS=FALSE
);

CREATE OR REPLACE VIEW webfrap.view_person_role AS
  SELECT
    core_person.rowid AS core_person_rowid,
    core_person.firstname AS core_person_firstname,
    core_person.lastname AS core_person_lastname,
    wbfsys_role_user.rowid AS wbfsys_role_user_rowid,
    wbfsys_role_user.name AS wbfsys_role_user_name,
    wbfsys_role_user.email AS wbfsys_role_user_email
  FROM
    webfrap.wbfsys_role_user
  JOIN
    webfrap.core_person ON core_person.rowid = wbfsys_role_user.id_person;

   */


  /**
   * @param int $processId
   */
  public function fetchProcessEdges( $processId )
  {

    $sql = <<<SQL

SELECT
  step.rowid,
  step.id_from,
  step.id_to,
  step.comment,
  step.rate,
  step.m_time_created,
  node_from.label as node_from_name,
  node_to.label as node_to_name,
  role.wbfsys_role_user_rowid,
  role.core_person_firstname,
  role.core_person_lastname,
  role.wbfsys_role_user_name

  from
    wbfsys_process_step step

  LEFT JOIN
    wbfsys_process_node node_from
    ON
      node_from.rowid = step.id_from

  JOIN
    wbfsys_process_node node_to
    ON
      node_to.rowid = step.id_to

  JOIN
    view_person_role role
    ON
      role.wbfsys_role_user_rowid = step.m_role_create

  where
    step.id_process_instance = {$processId}
    
  ORDER BY 
    step.m_time_created asc;

SQL;

    $this->result = $this->getDb()->select( $sql );

  }//end public function fetchProcessEdges */


} // end class ProcessBase_Query_Postgresql


