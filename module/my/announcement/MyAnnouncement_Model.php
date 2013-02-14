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
 * @copyright webfrap.net <contact@webfrap.net>
 */
class MyAnnouncement_Model extends Model
{
/*//////////////////////////////////////////////////////////////////////////////
// Get requestes Entity
//////////////////////////////////////////////////////////////////////////////*/
    
  /**
   * @param LibRequestHttp $request
   * @return WbfsysAnnouncement_Entity
   */
  public function getRequestedEntity($request)
  {
    
    $objid     = null;
    $accessKey = null;
    $uuid      = null;
    
    $orm = $this->getOrm();
    
    if ($val = $request->data( 'webfrap_announcement', Validator::EID, 'objid' ) )
    {
      $objid = $val;
    }
    elseif ($val = $request->param('objid', Validator::EID ) )
    {
      $objid = $val;
    }
    elseif ($val = $request->param('access_key', Validator::CNAME))
    {
      $accessKey = $val;
    }
    elseif ($val = $request->param('uuid', Validator::CNAME))
    {
      $uuid = $val;
    }
    
    $searchId = null;
    $keyType  = null;
    
    if ($objid )
    {
      $searchId = $objid;
      $keyType  = 'rowid';
      $entity   = $orm->get( 'WbfsysAnnouncement', $objid );
    }
    else if ($uuid )
    {
      $searchId = $uuid;
      $keyType  = 'uuid';
      $entity   = $orm->getByUuid( 'WbfsysAnnouncement', $uuid );
    }
    else if ($accessKey )
    {
      $searchId = $accessKey;
      $keyType  = 'access_key';
      $entity   = $orm->getByKey( 'WbfsysAnnouncement', $accessKey );
    } else {
      $response = $this->getResponse();
    
      // wenn keiner der 3 keys vorhanden ist, ist die Anfrage per Definition
      // invalid
      throw new InvalidRequest_Exception
      (
        $response->i18n->l
        (
          'There was no valid key in this request.',
          'wbf.message'
        ),
        Error::INVALID_REQUEST
      );
    }
    
    if ($entity )
    {
      $this->setEntityWebfrapAnnouncement($entity );
      return $entity;
    } else {
      $response = $this->getResponse();
    
      // wenn keine Entity gefunden wurde wird die Anfrage mit einer 
      // Not Found Fehlermeldung beantwortet
      throw new InvalidRequest_Exception
      (
        $this->getResponse()->i18n->l
        (
          'The requested {@resource@} for {@key_type@}: {@id@} not exists!',
          'wbf.message',
          array
          (
            'resource'  => $response->i18n->l( 'Announcement', 'wbfsys.announcement.label' ),
            'key_type'  => $keyType,
            'id'        => $searchId
          )
        ),
        Response::NOT_FOUND
      );
    }
 
    return null;
    
  }//end public function getRequestedEntity */

/*//////////////////////////////////////////////////////////////////////////////
// Getter for the Entities
//////////////////////////////////////////////////////////////////////////////*/
        
    
  /**
  * Erfragen der Haupt Entity unabhängig vom Maskenname
  * @param int $objid
  * @return WbfsysAnnouncement_Entity
  */
  public function getEntity($objid = null )
  {

    return $this->getEntityWebfrapAnnouncement($objid );

  }//end public function getEntity */
    
  /**
  * Setzen der Haupt Entity, unabhängig vom Maskenname
  * @param WbfsysAnnouncement_Entity $entity
  */
  public function setEntity($entity )
  {

    $this->setEntityWebfrapAnnouncement($entity );

  }//end public function setEntity */


  /**
  * returns the activ main entity with data, or creates a empty one
  * and returns it instead
  * @param int $objid
  * @return WbfsysAnnouncement_Entity
  */
  public function getEntityWebfrapAnnouncement($objid = null )
  {

    $response = $this->getResponse();
  
    if (!$entityWebfrapAnnouncement = $this->getRegisterd( 'main_entity' ) )
      $entityWebfrapAnnouncement = $this->getRegisterd( 'entityWebfrapAnnouncement' );

    //entity wbfsys_announcement
    if (!$entityWebfrapAnnouncement )
    {

      if (!is_null($objid ) )
      {
        $orm = $this->getOrm();

        if (!$entityWebfrapAnnouncement = $orm->get( 'WbfsysAnnouncement', $objid) )
        {
          $response->addError
          (
            $response->i18n->l
            (
              'There is no wbfsysannouncement with this id '.$objid,
              'wbfsys.announcement.message'
            )
          );
          return null;
        }

        $this->register( 'entityWebfrapAnnouncement', $entityWebfrapAnnouncement );
        $this->register( 'main_entity', $entityWebfrapAnnouncement);

      } else {
        $entityWebfrapAnnouncement   = new WbfsysAnnouncement_Entity() ;
        $this->register( 'entityWebfrapAnnouncement', $entityWebfrapAnnouncement );
        $this->register( 'main_entity', $entityWebfrapAnnouncement);
      }

    }
    elseif ($objid && $objid != $entityWebfrapAnnouncement->getId() )
    {
      $orm = $this->getOrm();

      if (!$entityWebfrapAnnouncement = $orm->get( 'WbfsysAnnouncement', $objid) )
      {
        $response->addError
        (
          $response->i18n->l
          (
            'There is no wbfsysannouncement with this id '.$objid,
            'wbfsys.announcement.message'
          )
        );
        return null;
      }

      $this->register( 'entityWebfrapAnnouncement', $entityWebfrapAnnouncement);
      $this->register( 'main_entity', $entityWebfrapAnnouncement);
    }

    return $entityWebfrapAnnouncement;

  }//end public function getEntityWebfrapAnnouncement */


  /**
  * returns the activ main entity with data, or creates a empty one
  * and returns it instead
  * @param WbfsysAnnouncement_Entity $entity
  */
  public function setEntityWebfrapAnnouncement($entity )
  {

    $this->register( 'entityWebfrapAnnouncement', $entity );
    $this->register( 'main_entity', $entity );

  }//end public function setEntityWebfrapAnnouncement */



  /**
   * en:
   * delete a dataset from the database
   *
   * de:
   * Löschen eines Datensatzes von der Datenbank
   *
   * @param WbfsysAnnouncement_Entity $entityWebfrapAnnouncement
   * @param TFlag $params named parameters
   *
   * @return void|Error im Fehlerfall
   */
  public function archive($entityWebfrapAnnouncement, $params  )
  {

    // laden der benötigten resource
    $response  = $this->getResponse();
    $user      = $this->getUser();
    $orm       = $this->getOrm();
    $acl       = $this->getAcl();
    
    $userId = $user->getId();
    $anounceId  = $entityWebfrapAnnouncement->getId();
    
    $announcementStatus = $orm->get( 'WbfsysAnnouncementAccessStatus', "id_user={$userId} and id_announcement={$anounceId}" );
    
    if (!$announcementStatus )
    {
      $announcementStatus = $orm->newEntity( 'WbfsysAnnouncementAccessStatus' );
      $announcementStatus->id_user = $userId;
      $announcementStatus->id_announcement = $anounceId;
    }
    
    $announcementStatus->value = EUserAnnouncementStatus::ARCHIVED;
      
    try
    {

      // delete wirft eine exception wenn etwas schief geht
      $orm->save($announcementStatus );

      $response->addMessage
      (
        $response->i18n->l
        (
          'Archived Announcement {@label@}',
          'wbf.label',
          array( 'label' => $entityWebfrapAnnouncement->text() )
        )
      );

      return null;
    }
    catch( LibDb_Exception $e )
    {

      $response->addError
      (
        $response->i18n->l
        (
          'Failed to archive {@label@}',
          'wbfsys.msg',
          array
          (
            'label'=> $entityWebfrapAnnouncement->text()
          )
        )
      );

      return new Error
      (
        $response->i18n->l
        (
          'Sorry, something went wrong!',
          'wbf.message'
        ),
        Response::INTERNAL_ERROR
      );

    }

  }//end public function archive */


}//end MyAnnouncement_Model

