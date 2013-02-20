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
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class WebfrapSetup_Container extends DataContainer
{
/*//////////////////////////////////////////////////////////////////////////////
// Methoden
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return void
   */
  public function run(  )
  {

    $db = Db::connection( 'admin' );

    $conf    = Conf::get('db','connection');
    $defCon  = $conf['default'];

    $dbAdmin = $db->getManager();
    $dbAdmin->setOwner($defCon['dbuser'] );

    $this->checkSequences($dbAdmin, $defCon );
    $this->checkAclViews($dbAdmin, $defCon );
    $this->checkPersonViews($dbAdmin, $defCon );

  }//end public function run */

  /**
   * @param LibDbAdminPostgresql $dbAdmin
   * @param array $defCon
   */
  public function checkSequences($dbAdmin, $defCon )
  {

    if (!$dbAdmin->sequenceExists('entity_oid_seq') ) {
      $dbAdmin->createSequence('entity_oid_seq');
    }

    if (!$dbAdmin->sequenceExists('wbf_deploy_revision') ) {
      $dbAdmin->createSequence('wbf_deploy_revision');
    }

  }//end public function checkSequences */

  /**
   * @param LibDbAdminPostgresql $dbAdmin
   * @param array $defCon
   */
  public function checkAclViews($dbAdmin, $defCon )
  {

    if (!$dbAdmin->viewExists( 'webfrap_acl_max_permission_view' ) ) {

      $ddl = <<<DDL
CREATE OR REPLACE VIEW webfrap_acl_max_permission_view
AS
  SELECT
    max(acl_access.access_level)  as "acl-level",
    acl_area.access_key           as "acl-area",
    acl_area.rowid                as "acl-id_area",
    acl_gu.id_user                as "acl-user",
    acl_gu.vid                    as "acl-vid",
    min(acl_gu.partial)           as "assign-partial"
  FROM
    wbfsys_security_access acl_access
  JOIN
    wbfsys_security_area acl_area
    ON
      acl_access.id_area = acl_area.rowid
  JOIN
    wbfsys_group_users acl_gu
    ON
      acl_access.id_group = acl_gu.id_group
  GROUP BY
    acl_gu.id_user,
    acl_area.access_key,
    acl_gu.vid,
    acl_area.rowid,
    acl_gu.partial
;
DDL;

      $dbAdmin->ddl($ddl );
      $dbAdmin->setViewOwner( 'webfrap_acl_max_permission_view' );

    }//end webfrap_acl_max_permission_view

    if (!$dbAdmin->viewExists( 'webfrap_inject_acls_view' ) ) {

      $ddl = <<<DDL
CREATE  OR REPLACE VIEW webfrap_inject_acls_view
  AS
  SELECT
    max(acl_access.access_level)  as "acl-level",
    acl_area.access_key           as "acl-area",
    acl_area.rowid                as "acl-id_area",
    acl_gu.vid                    as "acl-vid",
    acl_gu.id_user                as "acl-user",
    acl_gu.id_group               as "acl-group"
  FROM
    wbfsys_security_area acl_area
  JOIN
    wbfsys_security_access acl_access
    ON
      acl_access.id_area = acl_area.rowid
  JOIN
    wbfsys_group_users acl_gu
    ON
    (
      CASE WHEN
        acl_gu.id_area IS NOT NULL
      THEN
      (
        CASE WHEN
          acl_gu.vid IS NOT NULL
        THEN
          acl_access.id_group = acl_gu.id_group
            and acl_gu.id_area = acl_area.rowid
            and ( acl_gu.partial = 0 or acl_gu.partial is null )
        ELSE
          acl_access.id_group = acl_gu.id_group
            and acl_gu.id_area = acl_area.rowid
            and ( acl_gu.partial = 0 or acl_gu.partial is null )
            and acl_gu.vid is null
        END
      )
      ELSE
        acl_access.id_group = acl_gu.id_group
          and acl_gu.id_area is null
          and ( acl_gu.partial = 0 or acl_gu.partial is null )
          and acl_gu.vid is null
      END
    )
  where
    acl_access.partial = 0

  GROUP BY
    acl_gu.id_user,
    acl_area.access_key,
    acl_area.rowid,
    acl_gu.vid,
    acl_gu.id_group
;
DDL;

      $dbAdmin->ddl($ddl );
      $dbAdmin->setViewOwner( 'webfrap_inject_acls_view' );

    }//end webfrap_inject_acls_view

    if (!$dbAdmin->viewExists( 'webfrap_acl_assigned_view' ) ) {

      $ddl = <<<DDL
CREATE  OR REPLACE VIEW webfrap_acl_assigned_view
AS
  SELECT
    max(acl_gu.partial)           as "assign-has-partial",
    min(acl_gu.partial)           as "assign-is-partial",
    acl_area.access_key           as "acl-area",
    acl_area.rowid                as "acl-id_area",
    acl_gu.id_user                as "acl-user",
    acl_gu.vid                    as "acl-vid"
  FROM
    wbfsys_security_access acl_access
  JOIN
    wbfsys_security_area acl_area
    ON
      acl_access.id_area = acl_area.rowid
  JOIN
    wbfsys_group_users acl_gu
    ON
      acl_access.id_group = acl_gu.id_group
  WHERE
    acl_gu.vid is null
  GROUP BY
    acl_area.access_key,
    acl_gu.id_user,
    acl_area.rowid,
    acl_gu.vid
;
DDL;

      $dbAdmin->ddl($ddl );
      $dbAdmin->setViewOwner( 'webfrap_acl_assigned_view' );

    }//end webfrap_acl_assigned_view

  }//end public function checkAclViews */

  /**
   * @param LibDbAdminPostgresql $dbAdmin
   * @param array $defCon
   */
  public function checkPersonViews($dbAdmin, $defCon )
  {

    if (!$dbAdmin->viewExists( 'view_person_role' ) ) {

      $ddl = <<<DDL
CREATE OR REPLACE VIEW view_person_role AS
 SELECT
  core_person.rowid AS core_person_rowid,
  core_person.firstname AS core_person_firstname,
  core_person.lastname AS core_person_lastname,
  core_person.academic_title AS core_person_academic_title,
  core_person.noblesse_title AS core_person_noblesse_title,
  wbfsys_role_user.rowid AS wbfsys_role_user_rowid,
  wbfsys_role_user.name AS wbfsys_role_user_name
   FROM
    wbfsys_role_user
   JOIN
    core_person
      ON core_person.rowid = wbfsys_role_user.id_person;
DDL;

      $dbAdmin->ddl($ddl );
      $dbAdmin->setViewOwner( 'view_person_role' );

    }//end view_person_role

    if (!$dbAdmin->viewExists( 'view_user_role_contact_item' ) ) {

      $ddl = <<<DDL
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
    wbfsys_address_item.use_for_contact = true;
DDL;

      $dbAdmin->ddl($ddl );
      $dbAdmin->setViewOwner( 'view_user_role_contact_item' );

    }//end view_person_role

  }//end public function checkPersonViews */

}//end class WebfrapSetup_Container

