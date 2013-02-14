<?php
/*******************************************************************************
*
* @author      : Malte Schirmacher <malte.schirmacher@webfrap.net>
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
class LibConnector_Message_Mail extends LibConnector_Message_Adapter
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/
  
  /**
   * Type der Mailbox POP3 oder IMAP
   * @var string
   */
  public $type   = null;
  
/*//////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////*/

  
  /**
   * Verbindung zum Mailserver erstellen
   * 
   * @return boolean
   * @throws new LibConnector_Exception
   */
  public function open()
  {
    
    if (!$this->server )
      $this->addError( 'Server Address is missing' );
    
    if (!$this->port )
      $this->addError( 'Server Port is missing' );
    
    if (!$this->userName )
      $this->addError( 'Username for the Server is missing' );
      
    if (!$this->password )
      $this->addError( 'Password for the Server is missing' );
      
    if( $this->hasError() )
      throw new LibConnector_Exception( $this->getError() );
      
    $connectionString = $this->buildConnectionAddress();
      
    $this->resource = imap_open
    ( 
      $connectionString, 
      $this->userName, 
      $this->password,
      null,
      $this->tries // anzahl der versuche
    );
    
    if (!$this->resource )
    {
      throw new LibConnector_Exception
      ( 
        'Failed to open the connection to server '.$this->server,
        'Failed to open the connection to server '.$this->server.', Error:'.imap_last_error()
      );
    }
    
  }//end public function open */
  
  /**
   * schliesen der verbindung
   */
  public function close()
  {
    
    if( $this->resource )
      imap_close( $this->resource );
      
  }//end public function close */
  
/*//////////////////////////////////////////////////////////////////////////////
// Zugriff auf die Nachrichten
//////////////////////////////////////////////////////////////////////////////*/

  
  /**
   * Informationen für die Mailbox abrufen
   * 
   * @param boolean $msgInfo wenn true werden Informationen über die Nachrichten
   *     zurückgegeben, wenn false Informationen zur Mailbox
   * 
   * @return object
   */
  public function getMailboxInfo( $msgInfo = false )
  {
    
    if( $msgInfo )
    {
       /*
        Date:   Zeitpunkt der letzten Änderung (aktuelle Zeit)
        Driver:   Treiber
        Mailbox:   Name des Postfachs
        Nmsgs:   Anzahl der Nachrichten
        Recent:   Anzahl der kürzlich eingetroffenen Nachrichten
        Unread:   Anzal der ungelesenen Nachrichten
        Deleted:   Anzahl der gelöschten Nachrichten
        Size:   Gesamtgröße des Postfachs in Bytes
       */
      
      return imap_mailboxmsginfo( $this->resource );
    } else {
      /*
       * Date - Aktuelle Serverzeit, formatiert gemäß » RFC2822
       * Driver - Protokoll des Postfachs: POP3, IMAP, NNTP
       * Mailbox - Name des Postfachs
       * Nmsgs - Anzahl der Nachrichten im Postfach
       * Recent - Anzahl kürzlich eingetroffener Nachrichten im Postfach 
       */
      return imap_check( $this->resource );
    }
    
    
  }//end public function getMailboxInfo */
  
  /**
   * Anzahl der vorhandenen Nachrichten Abfragen
   * @return int
   */
  public function getNumMessages()
  {
    return imap_num_msg( $this->resource );
  }//end public function getNumMessages */
  
  /**
   * @return string
   */
  public function getMessageHeads(  )
  {
    
    $headers = imap_headers( $this->resource );
    
    return $headers;
    
  }//end public function getMessageHeads */
  
  /**
   * @param int $msgNo
   * @return object
   */
  public function getMessageHead( $msgNo  )
  {

    return imap_headerinfo( $this->resource, $msgNo );;
    
  }//end public function getMessageHeads */
  
  /**
   * @return string
   */
  public function getMessageBody( $number )
  {
    
  }//end public function getMessageBody */
  
  
  /**
   * @return string
   */
  public function getFullMessage( $number )
  {
    
  }//end public function getFullMessage */
  
/*//////////////////////////////////////////////////////////////////////////////
// address builder
//////////////////////////////////////////////////////////////////////////////*/
  
  /**
   * Zusammenbauen eines connection strings
   * 
   * @param string the address
   */
  public function buildConnectionAddress() 
  {
    
    /*
    // Verbindung zu einem IMAP server auf Port 143 des lokalen Rechners 
    $mbox = imap_open("{localhost:143}INBOX", "user_id", "password");
    
    // Verbindung zu einem POP3 server auf Port 110 des lokalen Rechners 
    $mbox = imap_open ("{localhost:110/pop3}INBOX", "user_id", "password");
    
    // Für SSL verschlüsselte Verbindungen wird /ssl an die 
    // Protokollspezifikation angefügt
    $mbox = imap_open ("{localhost:993/imap/ssl}INBOX", "user_id", "password");
    
    // Zur SSL Verbindung mit Servern mit selbstsignierten Zertifikaten 
    // muss zusätzlich /novalidate-cert angefügt werden
    $mbox = imap_open ("{localhost:995/pop3/ssl/novalidate-cert}", "user_id", "password");
    
    // Verbindung zu einem NNTP server auf Port 119 des lokalen Rechners 
    $nntp = imap_open ("{localhost:119/nntp}comp.test", "", "");
     */
    
    $conString = "{{$this->server}:{$this->port}/{$this->type}";
    
    if( $this->useSsl )
    {
      $conString .= "/ssl";
      
      if( $this->allowPrivateSigned )
      {
        $conString .= "/novalidate-cert";
      } else {
        $conString .= "/validate-cert";
      }
    }
    
    if( $this->useTls )
    {
      $conString .= "/tls";
    } else {
      $conString .= "/notls";
    }
    
    $conString .= "}INBOX";
    
    return $conString;
    
    
  }//end public function buildConnectionAddress */
  
}//end class LibConnector_Message_Adapter


