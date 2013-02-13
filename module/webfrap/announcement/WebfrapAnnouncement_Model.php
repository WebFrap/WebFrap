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
 *
 * @package WebFrap
 * @subpackage Core
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright webfrap.net <contact@webfrap.net>
 */
class WebfrapAnnouncement_Model
  extends Model
{
/*//////////////////////////////////////////////////////////////////////////////
// Search Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param User $user
   * @return WbfsysAnnouncementChannel_Entity
   */
  public function getUserChannel( $user )
  {

    $orm     = $this->getOrm();
    $channel = $orm->getByKey( 'WbfsysAnnouncementChannel', 'user_'.$user->getId()  );
    
    // wenn es den channel nicht gibt wird der automatisch angelegt
    if( !$channel )
    {
      $channel = $orm->newEntity( 'WbfsysAnnouncementChannel' );
      
      $channel->name = 'User '.$user->getId();
      $channel->access_key = 'user_'.$user->getId();
      $channel->description = "Message Channel for user ".$user->getFullName();
      
      $orm->save( $channel );
      
      // ok nun muss er noch subscribed werden
      $channelSubscription = $orm->newEntity( 'WbfsysAnnouncementChannel' );
      $channelSubscription->id_user = $user->getId();
      $channelSubscription->id_channel = $channel;
      
      $orm->save( $channelSubscription );
      
    }

    return $channel;

  }//end public function getUserChannel */
  
  /**
   * @param Entity $entity
   * @return WbfsysAnnouncementChannel_Entity
   */
  public function getEntityChannel( $entity )
  {
    
    if( is_object($entity) )
      $entity = $entity->getTable();
    
    $label = SParserString::subToCamelCase( $entity );
  
    $orm     = $this->getOrm();
    $channel = $orm->getByKey( 'WbfsysAnnouncementChannel', 'entity_'.$entity  );
  
    // wenn es den channel nicht gibt wird der automatisch angelegt
    if( !$channel )
    {
      $channel->name = SParserString::subToCamelCase( $label );
      $channel->access_key = $entity;
      $channel->description = "Message Channel for Entity ".$label;
  
      $orm->save( $channel );
    }
  
    return $channel;
  
  }//end public function getEntityChannel */

} // end class WebfrapAnnouncement_Model */

