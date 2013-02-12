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
class MyMessage_Crud_Model
  extends Model
{

  /**
   * Liste mit den Receivern
   * @var array
   */
  public $receivers = array();

////////////////////////////////////////////////////////////////////////////////
// Get requestes Entity
////////////////////////////////////////////////////////////////////////////////

  /**
   * @param LibRequestHttp $request
   * @return WbfsysMessage_Entity
   */
  public function getRequestedEntity( $request )
  {

    $objid     = null;
    $accessKey = null;
    $uuid      = null;

    $orm = $this->getOrm();

    if ( $val = $request->data( 'my_message', Validator::EID, 'objid' ) ) {
      $objid = $val;
    } elseif ( $val = $request->param( 'objid', Validator::EID ) ) {
      $objid = $val;
    } elseif ( $val = $request->param( 'access_key', Validator::CNAME ) ) {
      $accessKey = $val;
    } elseif ( $val = $request->param( 'uuid', Validator::CNAME ) ) {
      $uuid = $val;
    }

    $searchId = null;
    $keyType  = null;

    if ($objid) {
      $searchId = $objid;
      $keyType  = 'rowid';
      $entity   = $orm->get( 'WbfsysMessage', $objid );
    } elseif ($uuid) {
      $searchId = $uuid;
      $keyType  = 'uuid';
      $entity   = $orm->getByUuid( 'WbfsysMessage', $uuid );
    } elseif ($accessKey) {
      $searchId = $accessKey;
      $keyType  = 'access_key';
      $entity   = $orm->getByKey( 'WbfsysMessage', $accessKey );
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
      $this->setEntityMyMessage( $entity );

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
            'resource'  => $response->i18n->l( 'Message', 'wbfsys.message.label' ),
            'key_type'  => $keyType,
            'id'        => $searchId
          )
        ),
        Response::NOT_FOUND
      );
    }

    return null;

  }//end public function getRequestedEntity */

////////////////////////////////////////////////////////////////////////////////
// Getter for the Entities
////////////////////////////////////////////////////////////////////////////////

  /**
  * Erfragen der Haupt Entity unabhängig vom Maskenname
  * @param int $objid
  * @return WbfsysMessage_Entity
  */
  public function getEntity( $objid = null )
  {
    return $this->getEntityMyMessage( $objid );

  }//end public function getEntity */

  /**
  * Setzen der Haupt Entity, unabhängig vom Maskenname
  * @param WbfsysMessage_Entity $entity
  */
  public function setEntity( $entity )
  {

    $this->setEntityMyMessage( $entity );

  }//end public function setEntity */

  /**
  * returns the activ main entity with data, or creates a empty one
  * and returns it instead
  * @param int $objid
  * @return WbfsysMessage_Entity
  */
  public function getEntityMyMessage( $objid = null )
  {

    $response = $this->getResponse();

    if( !$entityMyMessage = $this->getRegisterd( 'main_entity' ) )
      $entityMyMessage = $this->getRegisterd( 'entityMyMessage' );

    //entity wbfsys_message
    if (!$entityMyMessage) {

      if ( !is_null( $objid ) ) {
        $orm = $this->getOrm();

        if ( !$entityMyMessage = $orm->get( 'WbfsysMessage', $objid) ) {
          $response->addError
          (
            $response->i18n->l
            (
              'There is no wbfsysmessage with this id '.$objid,
              'wbfsys.message.message'
            )
          );

          return null;
        }

        $this->register( 'entityMyMessage', $entityMyMessage );
        $this->register( 'main_entity', $entityMyMessage);

      } else {
        $entityMyMessage   = new WbfsysMessage_Entity() ;
        $this->register( 'entityMyMessage', $entityMyMessage );
        $this->register( 'main_entity', $entityMyMessage);
      }

    } elseif ( $objid && $objid != $entityMyMessage->getId() ) {
      $orm = $this->getOrm();

      if ( !$entityMyMessage = $orm->get( 'WbfsysMessage', $objid) ) {
        $response->addError
        (
          $response->i18n->l
          (
            'There is no wbfsysmessage with this id '.$objid,
            'wbfsys.message.message'
          )
        );

        return null;
      }

      $this->register( 'entityMyMessage', $entityMyMessage);
      $this->register( 'main_entity', $entityMyMessage);
    }

    return $entityMyMessage;

  }//end public function getEntityMyMessage */

  /**
  * returns the activ main entity with data, or creates a empty one
  * and returns it instead
  * @param WbfsysMessage_Entity $entity
  */
  public function setEntityMyMessage( $entity )
  {

    $this->register( 'entityMyMessage', $entity );
    $this->register( 'main_entity', $entity );

  }//end public function setEntityMyMessage */

  /**
   * @param WbfsysMessage_Entity $message
   * @return WbfsysMessage_Entity
   */
  public function getRefer( $message )
  {

    $orm = $this->getOrm();

    if( !$message->id_refer )

      return null;

    return $orm->get( 'WbfsysMessage', $message->id_refer );

  }//end public function getRefer */

  /**
   * @return WbfsysMessageStatus_Entity
   */
  public function getMessageStatus( )
  {
    return $this->getRegisterd( 'messageStatus' );

  }//end public getMessageStatus getMessageStatus */

////////////////////////////////////////////////////////////////////////////////
// Crud Methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @return WbfsysMessage_Entity
   */
  public function readMessage()
  {

    $orm  = $this->getOrm();
    $user = $this->getUser();

    $message = $this->getEntity();

    $messageStatus = $orm->get( 'WbfsysMessageReceiver', "id_message=".$message." and id_receiver=".$user->getId() );

    if (!$messageStatus) {
      if ( $message->id_sender != $user->getId() ) {
        throw new RequestDenied_Exception
        (
          "This Message was not send to you, but we've noticed the sender and receivers that you are interested in the message content. Have a nice day."
        );
      } else {
        // passiert wenn der sender die mail zum lesen öffnet
        $message->id_status    = EMessageStatus::OPEN;
        $orm->save( $message );

      }

    } else {

      if (!$messageStatus->id_status || EMessageStatus::IS_NEW == $messageStatus->id_status || $messageStatus->id_status > EMessageStatus::ARCHIVED) {
        $messageStatus->id_status = EMessageStatus::OPEN;
        $messageStatus->opened = date('Y-m-d');
        $orm->save( $messageStatus );
      }
    }

    $this->register( 'messageStatus', $messageStatus );

    return $message;

  }//end public function readMessage */

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
  public function send( $params )
  {

    // laden der resourcen
    $view     = $this->getView();
    $response = $this->getResponse();
    $db       = $this->getDb();
    $orm      = $db->getOrm();
    $user     = $this->getUser();

    try {
      if ( !$entityMyMessage = $this->getRegisterd( 'entityMyMessage' ) ) {
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
            array( 'key' => 'entityMyMessage' )
          )
        );
      }

      $entityMyMessage->id_sender = $user->getId();
      $entityMyMessage->id_sender_status = EMessageStatus::IS_NEW;

      if ( !$orm->insert( $entityMyMessage ) ) {

        throw new InternalError_Exception
        (
          "Sorry failed to send this message",
          "ORM returned false"
        );
      } else {
        $entityText  = $entityMyMessage->text();

        $response->addMessage
        (
          $response->i18n->l
          (
            'Successfully created Message {@label@}',
            'wbfsys.message.message',
            array( 'label' => $entityText )
          )
        );

        // die Nachrichten den Empfängern zuordnen
        ///TODO errorhandling für nicht existierende empfänger
        foreach ($this->receivers as $receiver) {
          $entityReceiver = $orm->newEntity( 'WbfsysMessageReceiver' );
          $entityReceiver->id_message   = $entityMyMessage;
          $entityReceiver->id_receiver  = $receiver;
          $entityReceiver->id_status    = EMessageStatus::IS_NEW;
          $entityReceiver->visible      = true;
          $orm->save( $entityReceiver );
        }

        $this->protocol
        (
          'Send message: '.$entityText,
          'create',
          $entityMyMessage
        );

      }

    } catch ( LibDb_Exception $e ) {
      // Datenbank exception in einen Request Exeption packen
      throw new InternalError_Exception
      (
        "Sorry failed to send this message",
        $e->getMessage()
      );
    }

  }//end public function send */

  /**
   * the update method of the model
   * @param TFlag $params named parameters
   * @return boolean
   */
  public function archive( $params )
  {

    // laden der resourcen
    $view     = $this->getView();
    $response = $this->getResponse();
    $db       = $this->getDb();
    $orm      = $db->getOrm();
    $user     = $this->getUser();

    try {
      if ( !$entityMyMessage = $this->getRegisterd( 'entityMyMessage' ) ) {
        // Datenbank exception in einen Request Exeption packen
        throw new InternalError_Exception
        (
          "Sorry failed to archive this message",
          "Entity was not in the registry, shure you called the fetch routine?"
        );
      }

      if ( $entityMyMessage->id_sender = $user->getId() ) {
        $entityMyMessage->id_sender_status = EMessageStatus::ARCHIVED;

        try {
          $orm->save( $entityMyMessage );
        } catch ( LibDb_Exception $e ) {
          throw new InternalError_Exception
          (
            "Sorry failed to archive this message",
            $e->getMessage()
          );
        }

        return;
      }

      $messageStatus = $orm->get( 'WbfsysMessageReceiver', "id_message=".$entityMyMessage." and id_receiver=".$user->getId() );

      if (!$messageStatus) {
        throw new RequestDenied_Exception( "You are not allowed to archive this message" );
      } else {
        $messageStatus->id_status = EMessageStatus::ARCHIVED;
      }

      if ( !$orm->save( $messageStatus ) ) {
        $entityText = $entityMyMessage->text();

        throw new InternalError_Exception
        (
          "Sorry failed to archive this message",
          "ORM Save returned false, looks like an ORM problem"
        );

      } else {
        $entityText = $entityMyMessage->text();

        $response->addMessage
        (
          $response->i18n->l
          (
            'Successfully archived Message {@label@}',
            'wbfsys.message.message',
            array
            (
              'label' =>  $entityText
            )
          )
        );

        $this->protocol
        (
          'Archived Message: '.$entityText,
          'archive',
          $entityMyMessage
        );

      }
    } catch ( LibDb_Exception $e ) {
      throw new InternalError_Exception
      (
        "Sorry failed to archive this message",
        $e->getMessage()
      );
    }

  }//end public function archive */

////////////////////////////////////////////////////////////////////////////////
// Fetch Methodes
////////////////////////////////////////////////////////////////////////////////

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
  public function fetchInsertData(  $params )
  {

    $httpRequest = $this->getRequest();
    $orm         = $this->getOrm();

    try {

      $state       = new State();
      $fields      = $this->getInsertFields();

      //management  wbfsys_message source wbfsys_message
      $entityMyMessage = $orm->newEntity( 'WbfsysMessage' );

      // if the validation fails report
      $httpRequest->validateInsert
      (
        $entityMyMessage,
        'my_message',
        $fields['my_message'],
        array(),
        $state
      );

      // register the entity in the mode registry
      $this->register( 'entityMyMessage', $entityMyMessage );

      if ( $state->hasErrors() ) {
        $response->addError( $state->errors );
      }

      $this->receivers = $httpRequest->data( 'receiver', Validator::EID );

      return $state->status;
    } catch ( InvalidInput_Exception $e ) {
      return State::ERROR;
    }

  }//end public function fetchInsertData */

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
      $entityMyMessage = new WbfsysMessage_Entity;
    } else {

      $orm = $this->getOrm();

      if (!$entityMyMessage = $orm->get( 'WbfsysMessage',  $id )) {
        $response->addError
        (
          $response->i18n->l
          (
            'There is no Message with the id: {@id@}',
            'wbfsys.message.message',
            array
            (
              'id' => $id
            )
          )
        );
        $entityMyMessage = new WbfsysMessage_Entity;
      }
    }

    if( !$params->categories )
      $params->categories = array();

    if( !$params->fieldsWbfsysMessage )
      $params->fieldsWbfsysMessage  = $entityMyMessage->getCols
      (
        $params->categories
      );

    $httpRequest->validate
    (
      $entityMyMessage,
      'my_message',
      $params->fieldsWbfsysMessage
    );
    $this->register( 'entityMyMessage', $entityMyMessage );

    return !$response->hasErrors();

  }//end public function fetchPostData */

////////////////////////////////////////////////////////////////////////////////
// Get Fields
////////////////////////////////////////////////////////////////////////////////

  /**
   * just fetch the post data without any required validation
   * @return array
   */
  public function getInsertFields()
  {
    return array
    (
      'my_message' => array
      (
        'id_refer',
        'priority',
        'title',
        'message'
      ),

    );

  }//end public function getInsertFields */

  /**
   * just fetch the post data without any required validation
   * @return array
   */
  public function getCreateRoFields( )
  {
    return array
    (

    );

  }//end public function getCreateRoFields */

}//end WbfsysMessage_Crud_Model
