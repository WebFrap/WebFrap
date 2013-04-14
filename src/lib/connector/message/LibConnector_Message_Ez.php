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
class LibConnector_Message_Ez extends LibConnector_Adapter
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Type der Mailbox POP3 oder IMAP
   * @var string
   */
  public $type   = null;

  /**
   * Resource
   * @var ezcMailPop3Transport
   */
  protected $resource = null;

  /**
   * @param array $conf
   */
  public function __construct($conf)
  {

    $this->useSsl = true;

    $this->server = $conf['server'];
    $this->port = $conf['port'];
    $this->userName = $conf['user'];
    $this->password = $conf['password'];

  }//end public function __construct */

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

    LibVendorEz::load();

    if (!$this->server)
      $this->addError('Server Address is missing');

    if (!$this->port)
      $this->addError('Server Port is missing');

    if (!$this->userName)
      $this->addError('Username for the Server is missing');

    if (!$this->password)
      $this->addError('Password for the Server is missing');

    if ($this->hasError())
      throw new LibConnector_Exception($this->getError());

    $options = new ezcMailPop3TransportOptions();
    $options->ssl = true;
    $options->timeout = 10;

    try {

      $this->resource = new ezcMailPop3Transport(
        $this->server,
        $this->port,
        $options
      );

      $this->resource->authenticate( $this->userName, $this->password );

    } catch( ezcMailTransportException $exc ) {

      throw new LibConnector_Exception(
          'Failed to open the connection to server '.$this->server,
          'Failed to open the connection to server '.$this->server.', Error:'.$exc->getMessage()
      );
    }

  }//end public function open */

  /**
   * schliesen der verbindung
   */
  public function close()
  {

    if ($this->resource)
      $this->resource->disconnect();

  }//end public function close */

/*//////////////////////////////////////////////////////////////////////////////
// Zugriff auf die Nachrichten
//////////////////////////////////////////////////////////////////////////////*/


  /**
   * Anzahl der vorhandenen Nachrichten Abfragen
   * @return int
   */
  public function getNumMessages()
  {
    return count($this->resource->listUniqueIdentifiers());
  }//end public function getNumMessages */

  /**
   * @return array
   */
  public function listMessages()
  {

    return $this->resource->listMessages();

  }//end public function listMessages */

  /**
   * @return array
   */
  public function listUniqueIdentifiers()
  {

    return $this->resource->listUniqueIdentifiers();

  }//end public function listUniqueIdentifiers */


  /**
   * Informationen für die Mailbox abrufen
   *
   * @param boolean $msgInfo wenn true werden Informationen über die Nachrichten
   *     zurückgegeben, wenn false Informationen zur Mailbox
   *
   * @return object
   */
  public function getMailboxInfo($msgInfo = false)
  {

    if ($msgInfo) {
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

      return imap_mailboxmsginfo($this->resource);
    } else {
      /*
       * Date - Aktuelle Serverzeit, formatiert gemäß » RFC2822
       * Driver - Protokoll des Postfachs: POP3, IMAP, NNTP
       * Mailbox - Name des Postfachs
       * Nmsgs - Anzahl der Nachrichten im Postfach
       * Recent - Anzahl kürzlich eingetroffener Nachrichten im Postfach
       */

      return imap_check($this->resource);
    }

  }//end public function getMailboxInfo */



  /**
   * @param int $msgNo
   * @return object
   */
  public function getMessageHead($msgNo  )
  {
    return imap_headerinfo($this->resource, $msgNo);;

  }//end public function getMessageHeads */

  /**
   * @return string
   */
  public function getMessageBody($number)
  {

  }//end public function getMessageBody */

  /**
   * @return string
   */
  public function getFullMessage($number)
  {

  }//end public function getFullMessage */


}//end class LibConnector_Message_Adapter

