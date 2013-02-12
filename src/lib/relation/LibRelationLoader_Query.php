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
 * Standard Query Objekt zum laden der Benutzer anhand der Rolle
 *
 * @package WebFrap
 * @subpackage tech_core
 */
class LibRelationLoader_Query
  extends LibSqlQuery
{
////////////////////////////////////////////////////////////////////////////////
// Methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @param LibMessage_Receiver_Group $group
   * @param string $type
   */
  public function fetchGroups( $group  )
  {

    $areas  = array();
    $id     = null;

    if ($group->area) {
      $areas = $this->extractWeightedKeys( $group->area );
    }

    if ($group->entity) {
      if ( is_object($group->entity) ) {
        $id = $group->entity->getId();
      } else {
        $id = $group->entity;
      }
    }

    $joins    = '';

    // wenn keine Area übergeben wurde dann brauchen wir nur die
    // globalen assignments
    if ($id) {
      $areaKeys = " UPPER(wbfsys_security_area.access_key)  IN( UPPER('".implode($areas,"'), UPPER('")."') ) " ;

      $joins = <<<SQL

  JOIN
    wbfsys_group_users
    ON
      wbfsys_group_users.id_user = wbfsys_role_user.rowid

  JOIN
    wbfsys_security_area
    ON
    (
      CASE WHEN
       wbfsys_group_users.id_area IS NOT NULL
       THEN
       (
         CASE WHEN
          wbfsys_group_users.vid IS NOT NULL
           THEN
             wbfsys_group_users.id_user = wbfsys_role_user.rowid
               and wbfsys_group_users.id_area = wbfsys_security_area.rowid
               and {$areaKeys}
               and wbfsys_group_users.vid = {$id}
           ELSE
             wbfsys_group_users.id_user = wbfsys_role_user.rowid
               and wbfsys_group_users.id_area = wbfsys_security_area.rowid
               and {$areaKeys}
               and wbfsys_group_users.vid is null
         END
       )
       ELSE
         wbfsys_group_users.id_user = wbfsys_role_user.rowid
           and wbfsys_group_users.id_area is null
           and wbfsys_group_users.vid is null
       END
    )

SQL;


    } elseif ($areas) {
      $areaKeys = " UPPER(wbfsys_security_area.access_key)  IN( upper('".implode($areas,"'),upper('")."') )" ;

      $joins = <<<SQL

  JOIN
    wbfsys_group_users
    ON
      wbfsys_group_users.id_user = wbfsys_role_user.rowid

  JOIN
    wbfsys_security_area
    ON
    (
      CASE
      WHEN
       wbfsys_group_users.id_area IS NOT NULL
        THEN
          wbfsys_group_users.id_user = wbfsys_role_user.rowid
            and wbfsys_group_users.id_area = wbfsys_security_area.rowid
            and {$areaKeys}
            and wbfsys_group_users.vid is null
        ELSE
         wbfsys_group_users.id_user = wbfsys_role_user.rowid
           and wbfsys_group_users.id_area is null
           and wbfsys_group_users.vid is null
      END
    )

SQL;


    } else {

      // wbfsys_security_area.rowid = wbfsys_role_group.id_area
      $joins = <<<SQL

  JOIN
    wbfsys_group_users
    ON
      wbfsys_group_users.id_user       = wbfsys_role_user.rowid
        and wbfsys_group_users.id_area  is null
        and wbfsys_group_users.vid      is null
SQL;

    }

    if ( is_array( $group->name ) ) {
      $groupRoles = " IN( upper('".implode($group->name,"'),upper('")."') )" ;
    } else {
      $groupRoles = " =  upper('{$group->name}') " ;
    }


    $query = <<<SQL

SELECT
  distinct wbfsys_role_user.rowid as userid,
  wbfsys_role_user.name,
  core_person.firstname,
  core_person.lastname,
  core_person.academic_title,
  core_person.noblesse_title

FROM
  wbfsys_role_user

{$joins}
  JOIN
    wbfsys_role_group
      ON wbfsys_role_group.rowid = wbfsys_group_users.id_group

  JOIN
    core_person
    ON
      wbfsys_role_user.id_person = core_person.rowid

WHERE
  UPPER(wbfsys_role_group.access_key) {$groupRoles}
    AND
    (
      wbfsys_group_users.partial = 0
        OR
          wbfsys_group_users.partial IS NULL
    )
    AND
      NOT wbfsys_role_user.inactive = TRUE

SQL;


    $db   = $this->getDb();

    return $db->select( $query )->getAll();

  }//end public function fetchGroups */

  /**
   * @param LibMessage_Receiver_User $user
   * @param string $type
   */
  public function fetchUser( $user )
  {

    if ($user->user) {

      if (!$user->user->id_person) {
        throw new LibMessage_Exception( 'Invalid Userobject '. $user->user->name .', missing person ID' );
      }

      $sql = <<<SQL

SELECT
  core_person.firstname,
  core_person.lastname,
  core_person.academic_title,
  core_person.noblesse_title,
  wbfsys_role_user.name

FROM
  core_person

JOIN
  wbfsys_role_user
  ON
    wbfsys_role_user.id_person = core_person.rowid

JOIN
  wbfsys_address_item
  ON
    wbfsys_address_item.id_user = {$user->user}

JOIN
  wbfsys_address_item_type
  ON
    wbfsys_address_item_type.rowid = wbfsys_address_item.id_type
    AND
      UPPER(wbfsys_address_item_type.access_key) = UPPER('{$type}')
    AND
      NOT wbfsys_role_user.inactive = TRUE

SQL;

    } elseif ($user->id) {

      $sql = <<<SQL

SELECT
  core_person.firstname,
  core_person.lastname,
  core_person.academic_title,
  core_person.noblesse_title,
  wbfsys_role_user.name

FROM
  core_person

JOIN
  wbfsys_role_user
  ON
    wbfsys_role_user.id_person = core_person.rowid

JOIN
  wbfsys_address_item
  ON
    wbfsys_address_item.id_user = {$user->id}

JOIN
  wbfsys_address_item_type
  ON
    wbfsys_address_item_type.rowid = wbfsys_address_item.id_type
    AND
      UPPER(wbfsys_address_item_type.access_key) = UPPER('{$type}')
    AND
      NOT wbfsys_role_user.inactive = TRUE

SQL;

    } elseif ($user->name) {

      $sql = <<<SQL

SELECT
  core_person.firstname,
  core_person.lastname,
  core_person.academic_title,
  core_person.noblesse_title,
  wbfsys_role_user.name

FROM
  core_person

JOIN
  wbfsys_role_user
  ON
    wbfsys_role_user.id_person = core_person.rowid

WHERE
  UPPER(wbfsys_role_user.name) = UPPER( '{$user->name}' )
  AND  NOT wbfsys_role_user.inactive = TRUE

SQL;

    } else {
      Debug::console( 'Receiver for User: '.$user->name.' '.$user->id.' was empty',$user );
      throw new LibRelation_Exception( 'Receiver for User: '.$user->name.' '.$user->id.' was empty' );
    }

    $db   = $this->getDb();

    $userData = $db->select( $sql )->get();

    Debug::console( $sql, $userData );

    return $userData;

  }//end public function fetchUser */

  /**
   * Hilfsfunktion zum auftrennen der keychain in area tokens
   *
   * @param array/string $keys
   * @return array
   */
  protected function extractWeightedKeys( $keys )
  {

    $keysData = array();

    $tmp    = explode( '>', $keys );

    $areas  = explode( '/', $tmp[0] );

    $wAreas = array();
    if( isset($tmp[1]) )
      $wAreas = explode( '/', $tmp[1] );;

    $keysData = array_merge( $areas, $wAreas );

    return $keysData;

  }//end protected function extractWeightedKeys */

} // end class LibMessageGrouploader_Query
