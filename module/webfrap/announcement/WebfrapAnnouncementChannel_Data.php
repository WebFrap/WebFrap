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
class WebfrapAnnouncementChannel_Data extends DataContainer
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/
  
  /**
   * Liste mit den Ids aller user
   * @var array
   */
  protected $sysUsers = array();
  
/*//////////////////////////////////////////////////////////////////////////////
// Methoden
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return void
   */
  public function run(  )
  {
    
    $orm = $this->getOrm();
    $this->sysUsers   = $orm->getIds( "WbfsysRoleUser", "rowid>0" ); 
    
    $this->createGlobal();
    $this->createUserChannel();
    $this->createGroupChannel();
    $this->createEntityChannel();
    

  }//end public function run */
  
  /**
   * 
   */
  protected function createGlobal()
  {
    
    $orm = $this->getOrm();
    
    // master message Channel erstellen
    $channel = $orm->getByKey( 'WbfsysAnnouncementChannel', 'wbf_global' );
    if (!$channel )
    {
      $channel = $orm->newEntity( 'WbfsysAnnouncementChannel' );
      $channel->name = 'Global';
      $channel->access_key = 'wbf_global';
      $channel->flag_public = true;
      $channel->description = 'The Global Data Channel';
      $orm->save( $channel );
    }
    
    $channelId  = $channel->getId(); // performance... lol
    
    foreach( $this->sysUsers as $sysUser )
    {
      if (!$subscription = $orm->get( 'WbfsysAnnouncementChannelSubscription', 'id_channel = '.$channelId.' and id_role = '.$sysUser ) )
      {
        $subscription = $orm->newEntity( 'WbfsysAnnouncementChannelSubscription' );
        $subscription->id_channel  = $channelId;
        $subscription->id_role     = $sysUser;
        $orm->save( $subscription );
      }
    }
    
  }//end protected function createGlobal */
  
  /**
   * 
   */
  protected function createUserChannel()
  {
    
    $orm = $this->getOrm();
    
    foreach( $this->sysUsers as $sysUser )
    {

      if (!$userChannel = $orm->getByKey( 'WbfsysAnnouncementChannel', 'user_'.$sysUser ) )
      {
        // Private Channel für den User erstellen
        $userChannel = $orm->newEntity( 'WbfsysAnnouncementChannel' );
        $userChannel->name = 'Private Channel '.$sysUser;
        $userChannel->access_key = 'user_'.$sysUser;
        $userChannel->flag_public = false;
        $userChannel->description = 'Private Channel for User '.$sysUser;
        $orm->save( $userChannel );
        
        // den eigenen Message Channel Subscriben
        $uCSubscription = $orm->newEntity( 'WbfsysAnnouncementChannelSubscription' );
        $uCSubscription->id_channel  = $userChannel->getId();
        $uCSubscription->id_role     = $sysUser;
        $orm->save( $uCSubscription );
      }
      
    }
    
  }//end protected function createEntityChannel */

  /**
   * 
   */
  protected function createEntityChannel()
  {
    
    $orm = $this->getOrm();
    
    // Announcement Channel für alle Entities erstellen
    $sysEntities   = $orm->getAll( "WbfsysEntity", "rowid>0" );
    
    foreach( $sysEntities as $sysEntity )
    {
      if (!$entityChannel = $orm->getByKey( 'WbfsysAnnouncementChannel', 'entity_'.$sysEntity->access_key ) )
      {
        $entityChannel = $orm->newEntity( 'WbfsysAnnouncementChannel' );
        $entityChannel->name = 'Entity '.$sysEntity->name;
        $entityChannel->access_key = 'entity_'.$sysEntity->access_key;
        $entityChannel->flag_public = false;
        $entityChannel->description = 'Announcement Channel for Entity '.$sysEntity->name;
        $orm->save( $entityChannel );
      }
    }
    
  }//end protected function createEntityChannel */
  
  /**
   * 
   */
  protected function createGroupChannel()
  {
    
    $orm = $this->getOrm();
    
    // Announcement Channel für alle Entities erstellen
    $sysRoles   = $orm->getAll( "WbfsysRoleGroup", "rowid>0" );
    
    foreach( $sysRoles as $sysRole )
    {
      if (!$groupChannel = $orm->getByKey( 'WbfsysAnnouncementChannel', 'group_'.$sysRole->access_key ) )
      {
        $groupChannel = $orm->newEntity( 'WbfsysAnnouncementChannel' );
        $groupChannel->name = 'Group '.$sysRole->name;
        $groupChannel->access_key = 'group_'.$sysRole->access_key;
        $groupChannel->flag_public = false;
        $groupChannel->description = 'Announcement Channel for Group '.$sysRole->name;
        $orm->save( $groupChannel );
      }
    }
    
  }//end protected function createRoleChannel */
  
}//end class WebfrapMessageChannel_Data

