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
 * @subpackage tech_core
 */
class LibUser extends BaseChild
{
/*//////////////////////////////////////////////////////////////////////////////
// Default Object
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var LibUser
   */
  protected static $default = null;
  
  /**
   * @return LibUser
   */
  public static function getDefault()
  {
    
    if (!self::$default )
      self::$default = new LibUser( Webfrap::$env );
      
    return self::$default;
    
  }//end public static function getDefault */
  
/*//////////////////////////////////////////////////////////////////////////////
// getter + setter
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param BaseChild $env
   */
  public function __construct($env )
  {
    $this->env = $env;
  }//end public function __construct */

  /**
   * @param LibEnvelopUser $user
   */
  public function createUser($user )
  {
    
    $orm = $this->getOrm();
    
    $userObj = $orm->get( 'WbfsysRoleUser', "UPPER(name)=UPPER('{$user->userName}')" );
    
    if ($userObj )
    {
      return null;
    }
    
    $userObj     = $orm->newEntity( 'WbfsysRoleUser' );
    $personObj   = $orm->newEntity( 'CorePerson' );
    $userObj->id_person = $personObj;
    
    $personObj->firstname = $user->firstName;
    $personObj->lastname  = $user->lastName;
    
    $userObj->name      = $user->userName;
    $userObj->password  = SEncrypt::passwordHash($user->passwd );
    $userObj->profile   = $user->profile;
    $userObj->level     = $user->level;
    
    $userObj->non_cert_login  = $user->nonCertLogin;
    $userObj->inactive        = $user->inactive;
    $userObj->description     = $user->description;
    
    $orm->save($userObj );
    
    // groups
    foreach($user->roles as $role )
    {
      
      $group    = $orm->getByKey( 'WbfsysRoleGroup', $role );
      if (!$group )
        continue;
      
      $userGroupObj  = $orm->newEntity( 'WbfsysGroupUsers', "id_user={$userObj} and id_group={$group}" );
      if (!$userGroupObj )
      {
        $userGroupObj = $orm->newEntity( 'WbfsysGroupUsers' );
        $userGroupObj->id_user = $userObj;
        $userGroupObj->id_group = $group;
        $userGroupObj->partial = 0;
        $orm->save($userGroupObj );
      }
      
    }
    
    // profiles
    foreach($user->profiles as $profile )
    {
      
      $profileNode    = $orm->getByKey( 'WbfsysProfile', $profile );
      if (!$profileNode )
        continue;
      
      $userGroupProfile  = $orm->newEntity( 'WbfsysUserProfiles', "id_user={$userObj} and id_profile={$profile}" );
      if (!$userGroupProfile )
      {
        $userGroupProfile = $orm->newEntity( 'WbfsysUserProfiles' );
        $userGroupProfile->id_user = $userObj;
        $userGroupProfile->id_profile = $profile;
        $orm->save($userGroupProfile );
      }
      
    }
    
    // address items
    foreach($user->addressItems as $addressItem )
    {
      
      $type = $orm->getByKey( 'WbfsysAddressItemType', $addressItem[0] );
      
      if (!$type )
        continue;
      
      $addrItem  = $orm->newEntity( 'WbfsysAddressItem', "id_user={$userObj} and id_type={$type}" );
      if (!$addrItem )
      {
        $addrItem = $orm->newEntity( 'WbfsysAddressItem' );
        $addrItem->id_user = $userObj;
        $addrItem->id_profile = $type;
        $addrItem->address_value = $addressItem[1];
        $orm->save($addrItem );
      }
      
    }
    
    // msg type
    $type = $orm->getByKey( 'WbfsysAddressItemType', 'message' );
    
    if (!$type )
    {
      $addrItem  = $orm->newEntity( 'WbfsysAddressItem', "id_user={$userObj} and id_type={$type}" );
      if (!$addrItem )
      {
        $addrItem = $orm->newEntity( 'WbfsysAddressItem' );
        $addrItem->id_user = $userObj;
        $addrItem->id_profile = $type;
        $addrItem->address_value = $userObj->getId();
        $orm->save($addrItem );
      }
    }
    
    
  }//end public function createUser */
  
  /**
   * @param int $id
   * @return LibEnvelopUser
   */
  public function getUserData($id )
  {
    
    $orm      = $this->getOrm();
    
    $envelop  = new LibEnvelopUser();
    $userObj  = $orm->get( 'WbfsysRoleUser', $id );
    
    if (!$userObj )
      return null;
    
    $personObj  = $userObj->followLink( 'id_person' );
    
    $envelop->fullName   = "({$userObj->name}) {$personObj->lastname}, {$personObj->firstname}";
    $envelop->id_user    = $userObj->getId();
    $envelop->userName   = $userObj->name;
    $envelop->firstName  = $personObj->firstname;
    $envelop->lastName   = $personObj->lastname;
    
    return $envelop;
    
  }//end public function getUserData */

} // end class LibUser

