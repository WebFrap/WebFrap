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
class WebfrapAnnouncement_Crud_Model extends Model
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

    if ($val = $request->data('webfrap_announcement', Validator::EID, 'objid')) {
      $objid = $val;
    } elseif ($val = $request->param('objid', Validator::EID)) {
      $objid = $val;
    } elseif ($val = $request->param('access_key', Validator::CNAME)) {
      $accessKey = $val;
    } elseif ($val = $request->param('uuid', Validator::CNAME)) {
      $uuid = $val;
    }

    $searchId = null;
    $keyType  = null;

    if ($objid) {
      $searchId = $objid;
      $keyType  = 'rowid';
      $entity   = $orm->get('WbfsysAnnouncement', $objid);
    } elseif ($uuid) {
      $searchId = $uuid;
      $keyType  = 'uuid';
      $entity   = $orm->getByUuid('WbfsysAnnouncement', $uuid);
    } elseif ($accessKey) {
      $searchId = $accessKey;
      $keyType  = 'access_key';
      $entity   = $orm->getByKey('WbfsysAnnouncement', $accessKey);
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

    if ($entity) {
      $this->setEntityWebfrapAnnouncement($entity);

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
            'resource'  => $response->i18n->l('Announcement', 'wbfsys.announcement.label'),
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
  public function getEntity($objid = null)
  {
    return $this->getEntityWebfrapAnnouncement($objid);

  }//end public function getEntity */

  /**
  * Setzen der Haupt Entity, unabhängig vom Maskenname
  * @param WbfsysAnnouncement_Entity $entity
  */
  public function setEntity($entity)
  {

    $this->setEntityWebfrapAnnouncement($entity);

  }//end public function setEntity */

  /**
  * returns the activ main entity with data, or creates a empty one
  * and returns it instead
  * @param int $objid
  * @return WbfsysAnnouncement_Entity
  */
  public function getEntityWebfrapAnnouncement($objid = null)
  {

    $response = $this->getResponse();

    if (!$entityWebfrapAnnouncement = $this->getRegisterd('main_entity'))
      $entityWebfrapAnnouncement = $this->getRegisterd('entityWebfrapAnnouncement');

    //entity wbfsys_announcement
    if (!$entityWebfrapAnnouncement) {

      if (!is_null($objid)) {
        $orm = $this->getOrm();

        if (!$entityWebfrapAnnouncement = $orm->get('WbfsysAnnouncement', $objid)) {
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

        $this->register('entityWebfrapAnnouncement', $entityWebfrapAnnouncement);
        $this->register('main_entity', $entityWebfrapAnnouncement);

      } else {
        $entityWebfrapAnnouncement   = new WbfsysAnnouncement_Entity() ;
        $this->register('entityWebfrapAnnouncement', $entityWebfrapAnnouncement);
        $this->register('main_entity', $entityWebfrapAnnouncement);
      }

    } elseif ($objid && $objid != $entityWebfrapAnnouncement->getId()) {
      $orm = $this->getOrm();

      if (!$entityWebfrapAnnouncement = $orm->get('WbfsysAnnouncement', $objid)) {
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

      $this->register('entityWebfrapAnnouncement', $entityWebfrapAnnouncement);
      $this->register('main_entity', $entityWebfrapAnnouncement);
    }

    return $entityWebfrapAnnouncement;

  }//end public function getEntityWebfrapAnnouncement */

  /**
  * returns the activ main entity with data, or creates a empty one
  * and returns it instead
  * @param WbfsysAnnouncement_Entity $entity
  */
  public function setEntityWebfrapAnnouncement($entity)
  {

    $this->register('entityWebfrapAnnouncement', $entity);
    $this->register('main_entity', $entity);

  }//end public function setEntityWebfrapAnnouncement */

/*//////////////////////////////////////////////////////////////////////////////
// Crud Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @lang en:
   * insert an entity
   * this method fetchs the activ entity from the registry an tries to
   * insert it at the database
   * all connected entities will be added too
   *
   * @lang de:
   * Methode zum erstellen eines neuen Datensatzes.
   * Die Methode geht davon aus, dass sich das zu speichernde Entity Objekt
   * in der Model Registry befindet
   *
   * @param TFlag $params named parameters
   * @return null|Error im Fehlerfall
   */
  public function insert($params)
  {

    // laden der resourcen
    $view     = $this->getView();
    $response = $this->getResponse();
    $db       = $this->getDb();
    $orm      = $db->getOrm();

    try {
      if (!$entityWebfrapAnnouncement = $this->getRegisterd('entityWebfrapAnnouncement')) {
        return new Error
        (
          $response->i18n->l
          (
            'Sorry, something went wrong!',
            'wbfsys.message'
          ),
          Response::INTERNAL_ERROR,
          $response->i18n->l
          (
            'The expected Entity with the key {@key@} was not in the registry',
            'wbf.message',
            array('key' => 'entityWebfrapAnnouncement')
          )
        );
      }

      $entityWebfrapAnnouncement->id_channel = $orm->getByKey('WbfsysAnnouncementChannel', 'wbf_global');

      if (!$orm->insert($entityWebfrapAnnouncement)) {
        // hier wird erst mal nur eine meldung gemacht,
        // die rückgabe des fehlers passiert am ende der methode, wo
        // geprüft wird ob ein fehler in der queue existiert
        $entityText = $entityWebfrapAnnouncement->text();
        $response->addError
        (
          $response->i18n->l
          (
            'Failed to create Announcement {@label@}',
            'wbfsys.announcement.message',
            array
            (
              'label' => $entityText
            )
          )
        );

      } else {
        $entityText  = $entityWebfrapAnnouncement->text();

        $response->addMessage
        (
          $response->i18n->l
          (
            'Successfully created Announcement {@label@}',
            'wbfsys.announcement.message',
            array('label' => $entityText)
          )
        );
        $saveSrc = false;

        $this->protocol
        (
          'Created New Announcement: '.$entityText,
          'create',
          $entityWebfrapAnnouncement
        );

        if ($saveSrc)
          $orm->update($entityWebfrapAnnouncement);
      }

    } catch (LibDb_Exception $e) {
      return new Error($e, Response::INTERNAL_ERROR);
    }

    if ($response->hasErrors()) {
      return new Error
      (
        $response->i18n->l
        (
          'Sorry, something went wrong!',
          'wbf.message'
        ),
        Response::INTERNAL_ERROR
      );
    } else {
      return null;
    }

  }//end public function insert */

  /**
   * the update method of the model
   * @param TFlag $params named parameters
   * @return boolean
   */
  public function update($params)
  {

    // laden der resourcen
    $view     = $this->getView();
    $response = $this->getResponse();
    $db       = $this->getDb();
    $orm      = $db->getOrm();

    try {
      if (!$entityWebfrapAnnouncement = $this->getRegisterd('entityWebfrapAnnouncement')) {
        return new Error
        (
          $response->i18n->l
          (
            'Sorry, something went wrong!',
            'wbf.message'
          ),
          Response::INTERNAL_ERROR,
          $response->i18n->l
          (
            'The expected Entity with the key {@key@} was not in the registry',
            'wbf.message',
            array('key' => 'entityWebfrapAnnouncement')
          )
        );
      }

      if (!$orm->update($entityWebfrapAnnouncement)) {
        $entityText = $entityWebfrapAnnouncement->text();

        // hier wird erst mal nur eine meldung gemacht,
        // die rückgabe des fehlers passiert am ende der methode, wo
        // geprüft wird ob ein fehler in der queue existiert
        $response->addError
        (
          $response->i18n->l
          (
            'Failed to update Announcement {@label@}',
            'wbfsys.announcement.message',
            array
            (
              'label' =>  $entityText
            )
          )
        );

      } else {
        $entityText = $entityWebfrapAnnouncement->text();

        $response->addMessage
        (
          $response->i18n->l
          (
            'Successfully updated Announcement {@label@}',
            'wbfsys.announcement.message',
            array
            (
              'label' =>  $entityText
            )
          )
        );

        $saveSrc = false;

        $this->protocol
        (
          'edited Announcement: '.$entityText,
          'edit',
          $entityWebfrapAnnouncement
        );

        if ($saveSrc)
          $orm->update($entityWebfrapAnnouncement);

      }
    } catch (LibDb_Exception $e) {
      return new Error($e, Response::INTERNAL_ERROR);
    }

    // prüfen ob fehler in der message queue gelandet sind
    if ($response->hasErrors()) {
      // wenn ja geben wir dem controller ein Fehlerojekt zurück
      // das er behandeln soll
      return new Error
      (
        $response->i18n->l
        (
          'Sorry, something went wrong!',
          'wbf.message'
        ),
        Response::INTERNAL_ERROR
      );
    } else {
      return null;
    }

  }//end public function update */

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
  public function delete($entityWebfrapAnnouncement, $params  )
  {

    // laden der benötigten resource
    $response  = $this->getResponse();
    $db        = $this->getDb();
    $orm       = $db->getOrm();
    $acl       = $this->getAcl();

    $delId = $entityWebfrapAnnouncement->getId();

    try {
      $db->begin();

      // delete wirft eine exception wenn etwas schief geht
      $orm->delete($entityWebfrapAnnouncement);

      $response->addMessage
      (
        $response->i18n->l
        (
          'Successfully deleted Announcement {@label@}',
          'wbfsys.announcement.message',
          array('label' => $entityWebfrapAnnouncement->text())
        )
      );

        $this->protocol
        (
          'deleted Announcement: '.$entityWebfrapAnnouncement,
          'delete',
          array('WebfrapAnnouncement',$entityWebfrapAnnouncement)
        );

      // alle Relationen von Personen auf diesen Datensatz löschen
      $acl->getManager()->cleanDatasetRelations($delId);

      $db->commit();

      return null;
    } catch (LibDb_Exception $e) {
      $db->rollback();
      $response->addError
      (
        $response->i18n->l
        (
          'Failed to delete {@label@}',
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

  }//end public function delete */

  /**
   * Archivieren von Systemmeldungen
   *
   * @param WbfsysAnnouncement_Entity $entityWebfrapAnnouncement
   * @param TFlag $params named parameters
   *
   * @return void|Error im Fehlerfall
   */
  public function archiveEntry($user, $entityWebfrapAnnouncement)
  {

    // acls werden keine benötigt der user kann immer nur seine eigene messages
    // weg klicken

    // laden der benötigten resource
    $response  = $this->getResponse();
    $db        = $this->getDb();
    $orm       = $db->getOrm();

    $delId  = $entityWebfrapAnnouncement->getId();
    $userId = $user->getId();

    $entStatus = $orm->get('WbfsysUserAnnouncement', "id_user='{$userId}' AND id_announcement='{$delId}' ");

    if (!$entStatus){
      $entStatus = $orm->newEntity('WbfsysUserAnnouncement');
      $entStatus->id_user = $userId;
      $entStatus->id_announcement = $delId;
    }

    $entStatus->visited = '2';

    $orm->save($entStatus);


  }//end public function archiveEntry */

/*//////////////////////////////////////////////////////////////////////////////
// Fetch Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * de:
   * Laden aller POST key=>value paare aus dem request
   * Die Daten werden direkt validiert und in neue entity objekte passende
   * zur zieltabelle gepackt.
   * Bei invaliden werten werden die Fehlermeldungen direkt in die
   * Message Queue geschrieben.
   *
   * @param TFlag $params named parameters
   * @return boolean
   */
  public function fetchInsertData( $params)
  {

    $httpRequest = $this->getRequest();
    $orm         = $this->getOrm();

    try {

      $fields = $this->getInsertFields();
      $params->fieldsWebfrapAnnouncement  = $fields['webfrap_announcement'];

      //management  wbfsys_announcement source wbfsys_announcement
      $entityWebfrapAnnouncement = $orm->newEntity('WbfsysAnnouncement');

      // if the validation fails report
      $httpRequest->validateInsert
      (
        $entityWebfrapAnnouncement,
        'webfrap_announcement',
        $fields['webfrap_announcement']
      );

      // register the entity in the mode registry
      $this->register('entityWebfrapAnnouncement', $entityWebfrapAnnouncement);

      Debug::console('$entityWebfrapAnnouncement', $entityWebfrapAnnouncement);

      return !$this->getResponse()->hasErrors();
    } catch (InvalidInput_Exception $e) {
      return null;
    }

  }//end public function fetchInsertData */

  /**
   * fetch the update data from the http request object
   *
   * @param WbfsysAnnouncement_Entity $entityWebfrapAnnouncement
   * @param TFlag $params named parameters
   * @return boolean
   */
  public function fetchUpdateData($entityWebfrapAnnouncement, $params)
  {

    $view        = $this->getView();
    $httpRequest = $this->getRequest();
    $response    = $this->getResponse();
    $orm         = $this->getOrm();

    $fields      = $this->getUpdateFields();

    //entity WebfrapAnnouncement
    if (!$params->fieldsWebfrapAnnouncement) {
      if (isset($fields['webfrap_announcement']))
        $params->fieldsWebfrapAnnouncement = $fields['webfrap_announcement'];
      else
        $params->fieldsWebfrapAnnouncement = array();
    }

    $httpRequest->validateUpdate
    (
      $entityWebfrapAnnouncement,
      'webfrap_announcement',
      $params->fieldsWebfrapAnnouncement
    );
    $this->register('entityWebfrapAnnouncement',$entityWebfrapAnnouncement);

    // check if there where any errors if not fine
    return !$response->hasErrors();

  }//end public function fetchUpdateData */

  /**
   * just fetch the post data without any required validation
   *
   * @param TFlag $params named parameters
   * @param int $id the id for the entity
   *
   * @return boolean
   */
  public function fetchPostData($params, $id = null  )
  {

    $httpRequest = $this->getRequest();
    $response    = $this->getResponse();

    if (!$id) {
      $entityWebfrapAnnouncement = new WbfsysAnnouncement_Entity;
    } else {

      $orm = $this->getOrm();

      if (!$entityWebfrapAnnouncement = $orm->get('WbfsysAnnouncement',  $id)) {
        $response->addError
        (
          $response->i18n->l
          (
            'There is no Announcement with the id: {@id@}',
            'wbfsys.announcement.message',
            array
            (
              'id' => $id
            )
          )
        );
        $entityWebfrapAnnouncement = new WbfsysAnnouncement_Entity;
      }
    }

    if (!$params->categories)
      $params->categories = array();

    if (!$params->fieldsWebfrapAnnouncement)
      $params->fieldsWebfrapAnnouncement  = $entityWebfrapAnnouncement->getCols
      (
        $params->categories
      );

    $httpRequest->validate
    (
      $entityWebfrapAnnouncement,
      'webfrap_announcement',
      $params->fieldsWebfrapAnnouncement
    );
    $this->register('entityWebfrapAnnouncement', $entityWebfrapAnnouncement);

    return !$response->hasErrors();

  }//end public function fetchPostData */

/*//////////////////////////////////////////////////////////////////////////////
// Get Fields
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * just fetch the post data without any required validation
   * @return array
   */
  public function getCreateFields()
  {
    return array
    (
      'webfrap_announcement' => array
      (
        'title',
        'date_start',
        'vid',
        'id_user',
        'id_channel',
        'id_process_status',
        'type',
        'importance',
        'message',
        'date_end',
        'id_vid_entity',
        'm_version',
      ),

    );

  }//end public function getCreateFields */

  /**
   * just fetch the post data without any required validation
   * @return array
   */
  public function getInsertFields()
  {
    return array
    (
      'webfrap_announcement' => array
      (
        'title',
        'date_start',
        'date_end',
        'type',
        'importance',
        'message',
        'm_version',
      ),

    );

  }//end public function getInsertFields */

  /**
   * just fetch the post data without any required validation
   * @return array
   */
  public function getCreateRoFields()
  {
    return array
    (

    );

  }//end public function getCreateRoFields */

  /**
   * request all fields that have to be fetched from the request
   * @return array
   */
  public function getEditFields()
  {
    return array
    (
      'webfrap_announcement' => array
      (
        'title',
        'date_start',
        'vid',
        'id_user',
        'id_channel',
        'id_process_status',
        'type',
        'importance',
        'message',
        'date_end',
        'id_vid_entity',
        'rowid',
        'm_time_created',
        'm_role_create',
        'm_time_changed',
        'm_role_change',
        'm_version',
        'm_uuid',
      ),

    );

  }//end public function getEditFields */

  /**
   * request all fields that have to be fetched from the request
   * @return array
   */
  public function getUpdateFields()
  {
    return array
    (
      'webfrap_announcement' => array
      (
        'title',
        'date_start',
        'vid',
        'id_user',
        'id_channel',
        'id_process_status',
        'type',
        'importance',
        'message',
        'date_end',
        'id_vid_entity',
        'm_version',
      ),

    );

  }//end public function getUpdateFields */

  /**
   * request all fields that have to be fetched from the request
   * @return array
   */
  public function getEditRoFields()
  {
    return array
    (

    );

  }//end public function getEditRoFields */

}//end WebfrapAnnouncement_Crud_Model

