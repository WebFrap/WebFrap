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
class WebfrapMessage_Model
  extends Model
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @var object
   */
  protected $messageNode = null;
  
  /**
   * Conditions für die Query
   * @var array
   */
  public $conditions = array();
  
////////////////////////////////////////////////////////////////////////////////
// getter & setter
////////////////////////////////////////////////////////////////////////////////
  
  /**
   * @return 
   */
  public function getMessageNode()
  {
    return $this->messageNode;
  }//end public function getMessageNode */
  
////////////////////////////////////////////////////////////////////////////////
// Methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @param TFlag $params
   * @return WebfrapMessage_List_Access
   */
  public function loadTableAccess( $params )
  {
    
    $user = $this->getUser();
    
    // ok nun kommen wir zu der zugriffskontrolle
    $this->access = new WebfrapMessage_Table_Access( null, null, $this );
    $this->access->load( $user->getProfileName(), $params );
    
    $params->access = $this->access;
    
    return $this->access;
    
  }//end public function loadTableAccess */
  
  /**
   * @param TFlag $params
   * @return array
   */
  public function fetchMessages( $params )
  {
    
    $db = $this->getDb();
    
    // filter für die query konfigurieren
  
    if( !isset($this->conditions['filters']['mailbox']) )
      $this->conditions['filters']['mailbox'] = 'in';
      
    if( !isset($this->condition['filters']['archive']) )
      $this->conditions['filters']['archive'] = false;
      
    Debug::console( 'conditions', $this->conditions  );
    
    /* @var $query WebfrapMessage_Table_Query */
    $query = $db->newQuery( 'WebfrapMessage_Table' );

    $query->fetch
    (
      $this->conditions,
      $params
    );
    
    return $query;
    
  }//end public function fetchMessages */
    
  /**
   * @param int $msgId
   * @throws DataNotExists_Exception if the message not exists
   */
  public function loadMessage( $msgId )
  {
    
    $db = $this->getDb();
    
    $sql = <<<SQL
    
select
	msg.rowid as msg_id,
	msg.title,
	msg.message,
	msg.priority,
	msg.m_time_created,
	sender.fullname as sender_name,
	sender.wbfsys_role_user_rowid as sender_id
	
FROM
	wbfsys_message msg
	
JOIN
	view_person_role sender
		ON sender.wbfsys_role_user_rowid = msg.id_sender   
WHERE
	msg.rowid = {$msgId};

SQL;
    
    $node = $db->select(  $sql )->get();
    
    if( $node )
      $this->messageNode = new TDataObject( $node );
    
    if( !$this->messageNode )
      throw new DataNotExists_Exception('The requested message not exists.');
      
    return $this->messageNode;
    
  }//end public function loadMessage */
  
  /**
   * de:
   * datenquelle für einen autocomplete request
   * @param string $key
   * @param TArray $params
   */
  public function getUserListByKey( $key, $params )
  {

    $db     = $this->getDb();
    $query  = $db->newQuery( 'WebfrapMessage' );
    /* @var $query WebfrapMessage_Query  */

    $query->fetchAutocomplete
    (
      $key,
      $params
    );

    return $query->getAll();

  }//end public function getUserListByKey */
  
  /**
   * (non-PHPdoc)
   * @see BaseChild::getUser()
   */
  public function getUserData( $userId )
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
    return $db->select( $sql )->get();
    
  }//end public function getUserData */
  
  
  /**
   * @param string $groupKey
   * @param string $areaKey
   * @param int $vid
   * 
   * @return LibMessageReceiver
   */
  public function getGroupUsers( $groupKey, $areaKey = null, $vid = null )
  {
    
    $messages = new LibMessagePool( $this );
    
    return $messages->getGroupUsers
    ( 
      array( $groupKey ), 
      array('message'), 
      $areaKey, 
      $vid 
    );
    
  }//end public function getUserData */
  
  /**
   * @param string $groupKey
   * @param string $areaKey
   * @param int $vid
   * 
   * @return LibMessageReceiver
   */
  public function getDsetUsers( $vid, $areaKey = null )
  {
    
    $messages = new LibMessagePool( $this );
    
    return $messages->getGroupUsers
    ( 
      null, 
      array('message'), 
      $areaKey, 
      $vid 
    );
    
  }//end public function getDsetUsers */

  /**
   * Versenden der Nachricht an den Benutzer
   * @param int $userId
   * @param int $dataSrc
   * @param int $refId
   * @param TDataObject $mgsData
   */
  public function sendUserMessage( $userId, $dataSrc, $refId, $mgsData )
  {
    
    $message = new WebfrapContactForm_User_Message();  

    $message->addReceiver
    ( 
      new LibMessage_Receiver_User( $userId )
    );
    
    if( $dataSrc && $refId )
    {
      $domainNode = DomainNode::getNode( $dataSrc );
      
      $orm = $this->getOrm();
      
      $entity = $orm->get( $domainNode->srcKey, $refId  );
      $message->entity = $entity;
      
    }
    
    $message->setChannels( $mgsData->channels );
    $message->subject     = $mgsData->subject;
    $message->userContent  = $mgsData->message;


    $msgProvider = $this->getMessage();
    $msgProvider->send( $message );
    
  }//end public function sendUserMessage */
  
  /**
   * 
   * @param int $messageId
   * @throws Per
   */
  public function deleteMessage( $messageId  )
  {
    
    $orm = $this->getOrm();
    $user = $this->getUser();
    
    $msg = $orm->get( 'WbfsysMessage', $messageId  );
    
    if( $msg->id_receiver == $user->getId() )
    {
      $msg->flag_receiver_deleted = true;
    }
    elseif( $msg->id_sender == $user->getId() )
    {
      $msg->flag_sender_deleted = true;
    }
    
    // wenn sender und receiver löschen, dann brauchen wir die message nichtmehr
    if( $msg->flag_receiver_deleted && $msg->flag_sender_deleted )
    {
      $orm->delete( 'WbfsysMessage', $messageId );
    }
    
  }

} // end class WebfrapSearch_Model


