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
 * @subpackage Groupware
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class WebfrapMessage_Model extends Model
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var object
   */
  protected $messageNode = null;

  /**
   * Conditions für die Query
   * @var array
   */
  public $conditions = array();

/*//////////////////////////////////////////////////////////////////////////////
// getter & setter
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return
   */
  public function getMessageNode()
  {
    return $this->messageNode;
  }//end public function getMessageNode */

/*//////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param TFlag $params
   * @return WebfrapMessage_List_Access
   */
  public function loadTableAccess($params)
  {

    $user = $this->getUser();

    // ok nun kommen wir zu der zugriffskontrolle
    $this->access = new WebfrapMessage_Table_Access(null, null, $this);
    $this->access->load($user->getProfileName(), $params);

    $params->access = $this->access;

    return $this->access;

  }//end public function loadTableAccess */

  /**
   * @param TFlag $params
   * @return array
   */
  public function fetchMessages($params)
  {

    $db = $this->getDb();


    /* @var $query WebfrapMessage_Table_Query */
    $query = $db->newQuery('WebfrapMessage_Table');

    $query->fetch(
      $this->params->conditions,
      $params
    );

    return $query;

  }//end public function fetchMessages */

  /**
   * @param int $msgId
   * @throws DataNotExists_Exception if the message not exists
   */
  public function loadMessage($msgId, $setOpen = true)
  {

    $db = $this->getDb();
    $user = $this->getUser();

    $sql = <<<SQL

select
  msg.rowid as msg_id,
  msg.title,
  msg.message,
  msg.priority,
  msg.m_time_created,
  msg.id_sender_status,
  msg.confidential,
  receiver.status as receiver_status,
  receiver.rowid as receiver_id,
  sender.fullname as sender_name,
  sender.core_person_rowid as sender_pid,
  sender.wbfsys_role_user_rowid as sender_id

FROM
  wbfsys_message msg
JOIN
	wbfsys_message_receiver receiver
		ON receiver.id_message = msg.rowid

JOIN
  view_person_role sender
    ON sender.wbfsys_role_user_rowid = msg.id_sender
WHERE
  msg.rowid = {$msgId};

SQL;


    $node = $db->select($sql)->get();

    if ($node) {

      // auf open setzen wenn noch closed
      if ($setOpen && EMessageStatus::IS_NEW == $node['receiver_status'] ){
        $db->update("UPDATE wbfsys_message_receiver set status =".EMessageStatus::OPEN." WHERE rowid = ".$node['receiver_id'] );
        $node['receiver_status'] = EMessageStatus::OPEN;
      }
  
      $this->messageNode = new TDataObject($node);
          
    }
    
    if (!$this->messageNode)
      throw new DataNotExists_Exception('The requested message not exists.');
      
    $this->loadMessageAspects($msgId);

    return $this->messageNode;

  }//end public function loadMessage */

  
  /**
   * @param int $msgId
   * @throws DataNotExists_Exception if the message not exists
   */
  public function loadMessageAspects($msgId)
  {

    $db = $this->getDb();
    $user = $this->getUser();

    $sql = <<<SQL

select
  aspect
FROM
  wbfsys_message_aspect asp
WHERE
  asp.id_receiver = {$user->getId()}
  	AND asp.id_message = {$msgId};

SQL;

    $aspects = $db->select($sql)->getAll();

    if (!$this->messageNode)
      throw new DataNotExists_Exception('You have to load a message first');
      
    $aspStack = array();
    
    foreach ($aspects as $aspect) {
      $aspStack[$aspect['aspect']] = true;
    }

    $this->messageNode->aspects = $aspStack;
    
  }//end public function loadMessageAspects */

  /**
   * @param int $msgId
   * @throws DataNotExists_Exception if the message not exists
   */
  public function loadMessageAttachments($msgId)
  {

    $db = $this->getDb();

    $sql = <<<SQL

SELECT
  attach.rowid as attach_id,
  file.rowid  as file_id,
  file.name as file_name,
  file.file_size as file_size,
  file.mimetype as mimetype,
  file.description as description

FROM
  wbfsys_entity_attachment attach

JOIN
  wbfsys_file file
    on file.rowid = attach.id_file

WHERE
	vid = {$msgId}
ORDER BY
  file.name desc;

SQL;

    $attachments = $db->select($sql)->getAll();

    return $attachments;

  }//end public function loadMessageAttachments */


  /**
   * de:
   * datenquelle für einen autocomplete request
   * @param string $key
   * @param TArray $params
   */
  public function getUserListByKey($key, $params)
  {

    $db     = $this->getDb();
    $query  = $db->newQuery('WebfrapMessage');
    /* @var $query WebfrapMessage_Query  */

    $query->fetchAutocomplete(
      $key,
      $params
    );

    return $query->getAll();

  }//end public function getUserListByKey */

  /**
   * (non-PHPdoc)
   * @see BaseChild::getUser()
   */
  public function getUserData($userId)
  {

    $db = $this->getDb();

    $sql = <<<SQL
SELECT
  core_person_rowid as person_id,
  core_person_firstname as firstname,
  core_person_lastname as lastname,
  wbfsys_role_user_name as user_name
FROM
  view_person_role
WHERE
  wbfsys_role_user_rowid = {$userId}

SQL;

    // gleich den Datensatz zurückgeben
    return $db->select($sql)->get();

  }//end public function getUserData */


  /**
   * @param string $groupKey
   * @param string $areaKey
   * @param int $vid
   *
   * @return LibMessageReceiver
   */
  public function getGroupUsers($groupKey, $areaKey = null, $vid = null)
  {

    $messages = new LibMessagePool($this);

    return $messages->getGroupUsers(
      array($groupKey),
      array('message'),
      $areaKey,
      $vid,
      true
    );

  }//end public function getUserData */

  /**
   * @param string $groupKey
   * @param string $areaKey
   * @param int $vid
   *
   * @return LibMessageReceiver
   */
  public function getDsetUsers($vid, $areaKey = null)
  {

    $messages = new LibMessagePool($this);

    return $messages->getGroupUsers(
      null,
      array('message'),
      $areaKey,
      $vid,
      true
    );

  }//end public function getDsetUsers */

  /**
   * Versenden der Nachricht an den Benutzer
   * @param int $userId
   * @param int $dataSrc
   * @param int $refId
   * @param TDataObject $mgsData
   */
  public function sendUserMessage($userId, $dataSrc, $refId, $mgsData)
  {

    $message = new WebfrapContactForm_User_Message();

    $message->addReceiver(
      new LibMessage_Receiver_User($userId)
    );

    if ($dataSrc && $refId) {

      $domainNode = DomainNode::getNode($dataSrc);

      $orm = $this->getOrm();

      $entity = $orm->get($domainNode->srcKey, $refId  );
      $message->entity = $entity;

    }

    $message->setChannels($mgsData->channels);
    $message->subject = $mgsData->subject;
    $message->userContent = $mgsData->message;

    $msgProvider = $this->getMessage();
    $msgProvider->send($message);

  }//end public function sendUserMessage */
  
  /**
   * @param int $messageId
   * @param WebfrapMessage_Save_Request $rqtData
   * @throws Per
   */
  public function saveMessage($messageId, $rqtData)
  {

    $orm = $this->getOrm();
    $user = $this->getUser();
    
    foreach($rqtData->aspects as $aspect){
      $msgAspect = $orm->newEntity('WbfsysMessageAspect');
      $msgAspect->id_receiver = $user->getId();
      $msgAspect->id_message = $messageId;
      $msgAspect->aspect = $aspect;
      $orm->insertIfNotExists($msgAspect, array('id_receiver','id_message','aspect'));
    }
    
    // die anderen löschen
    $orm->deleteWhere(
    	'WbfsysMessageAspect', 
    	" id_receiver={$user->getId()} AND id_message={$messageId} AND NOT aspect IN(".implode(', ',$rqtData->aspects).") " 
    );
    

  }//ebnd public function saveMessage 

  /**
   *
   * @param int $messageId
   * @throws Per
   */
  public function deleteMessage($messageId)
  {

    $orm = $this->getOrm();
    $user = $this->getUser();

    $msg = $orm->get('WbfsysMessage', $messageId  );

    if ($msg->id_receiver == $user->getId()) {
      $msg->flag_receiver_deleted = true;
    } elseif ($msg->id_sender == $user->getId()) {
      $msg->flag_sender_deleted = true;
    }

    // wenn sender und receiver löschen, dann brauchen wir die message nichtmehr
    if ($msg->flag_receiver_deleted && $msg->flag_sender_deleted) {
      $orm->delete('WbfsysMessage', $messageId);
    }
    
    // aspects leeren
    $orm->deleteWhere('WbfsysMessageAspect', 'id_message='.$messageId);
    //$orm->deleteWhere('WbfsysMessageAspect', 'id_message='.$messageId);

  }//ebnd public function deleteMessage 

  /**
   *
   * @param int $messageId
   * @throws Per
   */
  public function deleteAllMessage()
  {

    $db = $this->getDb();
    $user = $this->getUser();
    $userID = $user->getId();

    $queries = array();
    $queries[] = 'UPDATE wbfsys_message set flag_receiver_deleted = true WHERE id_receiver = '.$userID;
    $queries[] = 'UPDATE wbfsys_message set flag_sender_deleted = true WHERE id_sender = '.$userID;
    $queries[] = 'DELETE FROM wbfsys_message WHERE id_sender = '.$userID.' OR id_receiver = '.$userID;

    foreach ($queries as $query){
      $db->exec($query);
    }

  }//end public function deleteAllMessage */

  /**
   *
   * @param int $messageId
   * @throws Per
   */
  public function deleteSelection($msgIds)
  {

    $db = $this->getDb();
    $user = $this->getUser();
    $userID = $user->getId();

    if (!$msgIds)
      return;

    $sqlIds = implode(', ', $msgIds);

    $queries = array();
    $queries[] = 'UPDATE wbfsys_message set flag_receiver_deleted = true WHERE id_receiver = '.$userID.' AND rowid IN('.$sqlIds.')';
    $queries[] = 'UPDATE wbfsys_message set flag_sender_deleted = true WHERE id_sender = '.$userID.' AND rowid IN('.$sqlIds.')';
    $queries[] = 'DELETE FROM wbfsys_message WHERE (id_sender = '.$userID.' OR id_receiver = '.$userID.') AND rowid IN('.$sqlIds.')';

    foreach ($queries as $query) {
      $db->exec($query);
    }

  }//end public function deleteSelection */

  /**
   *
   * @param User $user
   * @return int
   */
  public function countNewMessages($user)
  {

    $status = EMessageStatus::IS_NEW;

    $sql = <<<SQL

  select count(wbfsys_message.rowid) as num_new
    FROM wbfsys_message
    JOIN wbfsys_message_receiver ON wbfsys_message.rowid = wbfsys_message_receiver.id_message
    WHERE wbfsys_message_receiver.vid = {$user->getId()} AND wbfsys_message_receiver.status = {$status};

SQL;

    $value = (int) $this->getDb()->select($sql)->getField('num_new');

    if (0 === $value)
      $value = '0';
    elseif (99 < $value)
      $value = '99+';

    return $value;

  }//end public function countNewMessages */

  /**
   *
   * @param User $user
   * @return WebfrapMessage_Table_Search_Settings
   */
  public function loadSettings()
  {

    $db     = $this->getDb();
    $user   = $this->getUser();
    $cache  = $this->getL1Cache();

    $settingsLoader = new LibUserSettings($db, $user, $cache);

    return $settingsLoader->getSetting(EUserSettingType::MESSAGES);

  }//end public function countNewMessages */

  /**
   * @param WebfrapMessage_Table_Search_Settings $settings
   */
  public function saveSettings($settings)
  {

    $db     = $this->getDb();
    $user   = $this->getUser();
    $cache  = $this->getL1Cache();

    $settingsLoader = new LibUserSettings($db, $user, $cache);
    $settingsLoader->saveSetting(EUserSettingType::MESSAGES, $settings);

  }//end public function countNewMessages */

////////////////////////////////////////////////////////////////////////////////
// References
////////////////////////////////////////////////////////////////////////////////

  /**
   * @param int $msgId
   * @throws DataNotExists_Exception if the message not exists
   */
  public function loadMessageReferences($msgId)
  {

    $db = $this->getDb();

    $sql = <<<SQL

select
  link.rowid as link_id,
  idx.vid,
  idx.title,
  ent.name,
  ent.default_edit as edit_link

FROM
  wbfsys_data_link link
  
JOIN
	wbfsys_data_index idx
		ON idx.vid = link.id_link

JOIN
	wbfsys_entity ent
		ON ent.rowid = idx.id_vid_entity

WHERE
  link.vid = {$msgId};

SQL;

    //$references = $db->select($sql)->getAll();

    return $db->select($sql);

  }//end public function loadMessageReferences */
  
  /**
   * @param int $linkId
   * @throws DataNotExists_Exception if the message not exists
   */
  public function loadRefById($linkId)
  {

    $db = $this->getDb();

    $sql = <<<SQL

select
  link.rowid as link_id,
  idx.vid,
  idx.title,
  ent.name,
  ent.default_edit as edit_link

FROM
  wbfsys_data_link link
  
JOIN
	wbfsys_data_index idx
		ON idx.vid = link.id_link

JOIN
	wbfsys_entity ent
		ON ent.rowid = idx.id_vid_entity

WHERE
  link.rowid = {$linkId};

SQL;

    return $db->select($sql)->get();

  }//end public function loadRefById */
  
  
  /**
   * @param int $msgId
   * @param int $refId
   * @throws DataNotExists_Exception if the message not exists
   */
  public function addRef($msgId, $refId)
  {

    $orm = $this->getOrm();
    
    $link = $orm->newEntity('WbfsysDataLink');
    $link->vid = $msgId;
    $link->id_link = $refId;

    $orm->save($link);

    return $link;
    
  }//end public function loadMessageReferences */
  
  /**
   * @param int $linkId
   */
  public function delRef($linkId)
  {
    
    $this->getOrm()->delete('WbfsysDataLink',$linkId);

  }//end public function delRef */
  
} // end class WebfrapSearch_Model

