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
class ProcessBase_Query
  extends LibSqlQuery
{
  
  /**
   * @param int $processId
   */
  public function fetchProcessEdges( $processId )
  {

    $sql = <<<SQL

SELECT
  step.rowid,
  step.id_from,
  node_from.label as node_from_name,
  step.id_to,
  node_to.label as node_to_name,
  step.comment,
  step.rate,
  step.m_time_created,
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

SQL;

    $this->result = $this->getDb()->select( $sql );

  }//end public function fetchProcessEdges */


} // end class ProcessBase_Query


