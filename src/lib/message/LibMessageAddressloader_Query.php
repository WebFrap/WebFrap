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
class LibMessageAddressloader_Query extends LibSqlQuery
{
/*//////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////*/
  
  /**
   * @param LibMessage_Receiver_Group $group
   * @param string $type
   */
  public function fetchGroups( $group, $type, $direct = false )
  {

    $areas  = array();
    $id     = null;
    
    if( $group->area )
    {
      $areas = $this->extractWeightedKeys( $group->area );
    }
    
    if( $group->entity )
    {
      if( is_object($group->entity) )
      {
        $id = $group->entity->getId();
      } else {
        $id = $group->entity;
      }
    }
    
    $joins    = '';
    $wheres   = '';

    
    // wenn keine Area übergeben wurde dann brauchen wir nur die
    // globalen assignments
    if( $id )
    {
      $areaKeys = '';
      
      if( $areas )
        $areaKeys = "and UPPER(wbfsys_security_area.access_key)  IN( UPPER('".implode($areas,"'), UPPER('")."') ) " ;

      $joins = <<<SQL

  JOIN
    wbfsys_group_users
    ON
      wbfsys_group_users.id_user = wbfsys_role_user.rowid

  LEFT JOIN
    wbfsys_security_area
    ON
      wbfsys_group_users.id_area = wbfsys_security_area.rowid

SQL;
    
      
      if( $direct )
      {
        $wheres = <<<SQL
   
  (  
		wbfsys_group_users.id_area = wbfsys_security_area.rowid 
        {$areaKeys}
        and wbfsys_group_users.vid = {$id}
  ) AND
SQL;
      } else {
        $wheres = <<<SQL
   
  (  
    (
      wbfsys_group_users.id_area = wbfsys_security_area.rowid 
        {$areaKeys}
        and wbfsys_group_users.vid = {$id}
    )
    OR
    (
      wbfsys_group_users.id_area = wbfsys_security_area.rowid 
        {$areaKeys}
        and wbfsys_group_users.vid is null 
    )
    OR
    (
      wbfsys_group_users.id_area is null 
        and wbfsys_group_users.vid is null 
    )
  ) AND
SQL;
      }

    }
    else if( $areas )
    {
      $areaKeys = " UPPER(wbfsys_security_area.access_key)  IN( upper('".implode($areas,"'),upper('")."') )" ;

      $joins = <<<SQL

  JOIN
    wbfsys_group_users
    ON
      wbfsys_group_users.id_user = wbfsys_role_user.rowid

  LEFT JOIN
    wbfsys_security_area
    ON
      wbfsys_group_users.id_area = wbfsys_security_area.rowid

SQL;
    
      if( $direct )
      {
        $wheres = <<<SQL
   
  ( 
    wbfsys_group_users.id_user = wbfsys_role_user.rowid 
      and wbfsys_group_users.id_area = wbfsys_security_area.rowid 
      and {$areaKeys}
      and wbfsys_group_users.vid is null 
  )
  AND
SQL;
      } else {
        $wheres = <<<SQL
   
  ( 
    (
      wbfsys_group_users.id_user = wbfsys_role_user.rowid 
        and wbfsys_group_users.id_area = wbfsys_security_area.rowid 
        and {$areaKeys}
        and wbfsys_group_users.vid is null 
    )
    OR
    (
      wbfsys_group_users.id_user = wbfsys_role_user.rowid 
      and wbfsys_group_users.id_area is null 
      and wbfsys_group_users.vid is null 
    )
  )
  AND
SQL;
      }
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
    
    $groupRoles = '';
    if( $group->name )
    {
      if( is_array( $group->name ) )
      {
        $groupRoles = " UPPER(wbfsys_role_group.access_key)  IN( upper('".implode($group->name,"'),upper('")."') ) AND " ;
      } else {
        $groupRoles = " UPPER(wbfsys_role_group.access_key)  =  upper('{$group->name}') AND " ;
      }
    }
    
    // wenn kein type defniert wurde ist die id des users seine adresse
    if (!$type )
    {
      
      $valueAddress  = "wbfsys_role_user.rowid as address";
      $joinAddress   = '';

    } else {
      
      $valueAddress = <<<HTML

  wbfsys_address_item.address_value as address 

HTML;

      if( is_array( $type ) )
      {
        $codeType = " IN( UPPER('".implode( "'), UPPER('", $type  )."') ) ";
      } else {
        $codeType = "= UPPER('{$type}')";
      }
      
      $joinAddress = <<<HTML
      
JOIN
  wbfsys_address_item
  ON
    wbfsys_address_item.id_user = wbfsys_role_user.rowid
      
JOIN
  wbfsys_address_item_type
  ON
    wbfsys_address_item_type.rowid = wbfsys_address_item.id_type
    AND
      UPPER(wbfsys_address_item_type.access_key) {$codeType}
      
HTML;
      
    }
    


    $query = <<<SQL
  
SELECT
  distinct wbfsys_role_user.rowid as userid,
  wbfsys_role_user.name,
  core_person.firstname,
  core_person.lastname,
  core_person.academic_title,
  core_person.noblesse_title,
{$valueAddress}

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
    
{$joinAddress}
      
WHERE
{$groupRoles}
{$wheres} 
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
   * @param LibMessage_Receiver_Contact $contact
   * @param string $type
   * 
   * @return array
   */
  public function fetchContacts( $contact, $type )
  {

    return array( );
    
  }//end public function fetchContacts */
  
  /**
   * @param LibMessage_Receiver_List $list
   * @param string $type
   * 
   * @return array
   */
  public function fetchList( $list, $type )
  {

    return array( );
    
  }//end public function fetchList */

  /**
   * @param LibMessage_Receiver_User $user
   * @param string $type
   */
  public function fetchUser( $user, $type )
  {


    if( $user->user && is_object($user->user) )
    {

      if( $user->user instanceof User )
      {
        $userId = $user->user->getId();
      
        if( 1 == $userId )
        {
          throw new LibMessage_Exception( 'User is not logged in' );
        }
        
      } else {
        
        if (!$user->user->id_person )
        {
          throw new LibMessage_Exception( 'Invalid Userobject '. $user->user->name .', missing person ID' );
        }
        
        $userId = $user->user->getId();
      }

      $sql = <<<SQL
      
SELECT
  core_person.firstname,
  core_person.lastname,
  core_person.academic_title,
  core_person.noblesse_title,
  wbfsys_role_user.rowid as userid,
  wbfsys_role_user.name,
  wbfsys_address_item.address_value as address
  
FROM
  core_person
  
JOIN
  wbfsys_role_user
  ON
    wbfsys_role_user.id_person = core_person.rowid
    
JOIN
  wbfsys_address_item
  ON
    wbfsys_address_item.id_user = wbfsys_role_user.rowid
    
JOIN
  wbfsys_address_item_type
  ON
    wbfsys_address_item_type.rowid = wbfsys_address_item.id_type
    AND
      UPPER(wbfsys_address_item_type.access_key) = UPPER('{$type}')
WHERE
  ( wbfsys_role_user.inactive = FALSE or wbfsys_role_user.inactive is null )
    AND wbfsys_role_user.rowid = {$userId}
SQL;

    }
    elseif( '' != trim($user->id)  )
    {
      
      $sql = <<<SQL
      
SELECT
  core_person.firstname,
  core_person.lastname,
  core_person.academic_title,
  core_person.noblesse_title,
  wbfsys_role_user.rowid as userid,
  wbfsys_role_user.name,
  wbfsys_address_item.address_value as address
  
FROM
  core_person
  
JOIN
  wbfsys_role_user
  ON
    wbfsys_role_user.id_person = core_person.rowid
  
JOIN
  wbfsys_address_item
  ON
    wbfsys_address_item.id_user = wbfsys_role_user.rowid
    
JOIN
  wbfsys_address_item_type
  ON
    wbfsys_address_item_type.rowid = wbfsys_address_item.id_type
    AND
      UPPER(wbfsys_address_item_type.access_key) = UPPER('{$type}')

WHERE
  ( wbfsys_role_user.inactive = FALSE or wbfsys_role_user.inactive is null )
    AND wbfsys_role_user.rowid = {$user->id}
    
SQL;
      
    }
    elseif( '' != trim($user->name)  )
    {
      
      $sql = <<<SQL
      
SELECT
  core_person.firstname,
  core_person.lastname,
  core_person.academic_title,
  core_person.noblesse_title,
  wbfsys_role_user.rowid as userid,
  wbfsys_role_user.name,
  wbfsys_address_item.address_value as address
  
FROM
  core_person
  
JOIN
  wbfsys_role_user
  ON
    wbfsys_role_user.id_person = core_person.rowid
    
JOIN
  wbfsys_address_item
  ON
    wbfsys_address_item.id_user = wbfsys_role_user.rowid
      
    
JOIN
  wbfsys_address_item_type
  ON
    wbfsys_address_item_type.rowid = wbfsys_address_item.id_type
    AND
      UPPER(wbfsys_address_item_type.access_key) = UPPER( '{$type}' )
      
WHERE
  ( wbfsys_role_user.inactive = FALSE or wbfsys_role_user.inactive is null )
  AND
    UPPER(wbfsys_role_user.name) = UPPER( '{$user->name}' )
SQL;
      
    } else {
      throw new LibMessage_Exception( 'Receiver for User: '.$user->name.' '.$user->id.' was empty' );
    }
    
    $db       = $this->getDb();
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

