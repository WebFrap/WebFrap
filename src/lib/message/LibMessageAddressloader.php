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
 * Klasse zum laden der Benutzer die den Gruppen die Adressiert wurde angehören
 *
 * @package WebFrap
 * @subpackage tech_core
 */
class LibMessageAddressloader extends PBase
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var LibMessageAddressloader_Query
   */
  public $addressLoader = null;
  
/*//////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return LibMessageGrouploader_Query
   */
  public function getAddressLoader()
  {
    
    if (!$this->addressLoader )
    {
      $db                 = $this->getDb();
      $this->addressLoader  = $db->newQuery( 'LibMessageAddressloader' );
    }
    
    return $this->addressLoader;
    
  }//end public function getAddressLoader */
  
  /**
   * Mit dieser Methoden werden alle relevanten Adressdaten für die Empfänger
   * einer Nachricht geladen
   * 
   * Welche genau das sind kann den Nachrichten Umschlag entnommen werden
   *  
   * @param array<IReceiver> $receivers
   * @param string $type
   * 
   * @return [LibMessageReceiver]
   */
  public function getReceivers($receivers, $type )
  {
    
    //$receivers    = $message->getReceivers();
    $contacts     = array();
    
    foreach($receivers as $receiver )
    {
      
      try
      {
        switch ($receiver->type )
        {
          
          case 'address':
          {
            $contacts = $this->loadAddress($receiver, $type, $contacts );
            break;
          }
          case 'contact':
          {
            $contacts = $this->loadContact($receiver, $type, $contacts );
            break;
          }
          case 'group':
          {
            $contacts = $this->loadGroup($receiver, $type, $contacts );
            break;
          }
          case 'user':
          {
            $contacts = $this->loadUser($receiver, $type, $contacts );
            break;
          }
          
        }
      }
      catch( LibMessage_Exception $exc )
      {
        
      }
      
    }
    
    return $contacts;
    
  }//end public function getReceivers */
  
  /**
   * Laden eines einfachen Receivers
   * 
   * @param IReceiver $receiver
   * @param string $type
   * @param array<IReceiver> $contacts
   * 
   * @return array<IReceiver>
   */
  public function getReceiver($receiver, $type, $contacts )
  {

    switch ($receiver->type )
    {
      
      case 'address':
      {
        $contacts = $this->loadAddress($receiver, $type, $contacts );
        break;
      }
      case 'contact':
      {
        $contacts = $this->loadContact($receiver, $type, $contacts );
        break;
      }
      case 'group':
      {
        $contacts = $this->loadGroup($receiver, $type, $contacts );
        break;
      }
      case 'user':
      {
        $contacts = $this->loadUser($receiver, $type, $contacts );
        break;
      }
      
    }
    
    return $contacts;
    
  }//end public function getReceiver */
  
  /**
   *  
   * @param LibMessageEnvelop $message
   * @param string $type
   * 
   */
  public function getGroupUsers($receiver, $type = null, $direct = false )
  {

    return $this->loadGroup($receiver, $type, array(), $direct );
    
  }//end public function getGroupUsers */
  
  /**
   * @param LibMessage_Receiver_Address $receiver
   * @param string $type
   * @param array $contacts
   * 
   * @return array
   */
  public function loadAddress($receiver, $type, $contacts )
  {
    
    if (!isset($receiver->address[$type] ) )
    {
      return $contacts;
    }
    
    if ( isset($contacts[$receiver->address[$type]] ) )
    {
      return $contacts;
    }
    
    $contact = new LibMessageReceiver($receiver, $receiver->address[$type]  );
    $contacts[$contact->address] = $contact;
    
    return $contacts;
    
  }//end public function loadAddress */
  
  /**
   * @param LibMessage_Receiver_Contact $receiver
   * @param string $type
   * @param array $contacts
   * 
   * @return array
   */
  public function loadContact($receiver, $type, $contacts )
  {
    
    $addressLoader = $this->getAddressLoader();
    
    if (!$users = $addressLoader->fetchContacts($receiver, $type ) )
    {
      if ($receiver->else )
      {
        foreach($receiver->else as $elseReceiver )
        {
          $contacts = $this->getReceiver($receiver, $type, $contacts);
        }
      }
      
      return $contacts;
    }
    
    foreach($users as $userData )
    {
      $contact = new LibMessageReceiver($userData );
      $contacts[$contact->address] = $contact;
    }
    
    return $contacts;
    
  }//end public function loadContact */
  
  /**
   * @param LibMessage_Receiver_Group $receiver
   * @param string $type
   * @param [LibMessageReceiver] $contacts
   * 
   * @return [LibMessageReceiver]
   */
  public function loadGroup($receiver, $type, $contacts, $direct = false )
  {

    $addressLoader = $this->getAddressLoader();
    
    if (!$users = $addressLoader->fetchGroups($receiver, $type, $direct ) )
    {
      
      if ($receiver->else )
      {
        foreach($receiver->else as $elseReceiver )
        {
          $contacts = $this->getReceiver($elseReceiver, $type, $contacts );
        }
      }
      
      return $contacts;
    }
    
    foreach($users as $userData )
    {
      $contact = new LibMessageReceiver($userData );
      
      // jede adresse nur einmal zulassen, doppelte werden einfach 
      // überschrieben
      $contacts[$contact->address] = $contact;
    }
    
    return $contacts;
    
  }//end public function loadGroup */
  
  /**
   * @param LibMessage_Receiver_User $receiver
   * @param string $type
   * @param array $contacts
   * 
   * @return array
   */
  public function loadUser($receiver, $type, $contacts )
  {
    
    $addressLoader = $this->getAddressLoader();
    
    if (!$userData = $addressLoader->fetchUser($receiver, $type ) )
    {
      if ($receiver->else )
      {
        foreach($receiver->else as $elseReceiver )
        {
          $contacts = $this->getReceiver($receiver, $type, $contacts);
        }
      }
      
      return $contacts;
    }
    
    $contact = new LibMessageReceiver($userData );
    $contacts[$contact->address] = $contact;
    
    return $contacts;
    
  }//end public function loadUser */
  
} // end class LibMessageGrouploader

