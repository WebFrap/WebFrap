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
   * @param boolean $deleteFromServer sollen die Mails vom Server gelöscht werden
   * @return array
   */
  public function getAllMessages($deleteFromServer = false)
  {

    $set = $this->resource->fetchAll($deleteFromServer);

    $parser = new ezcMailParser();
    return $parser->parseMail( $set );

  }//end public function getAllMessages */


  /**
   * @param int $offset
   * @param int $limit
   * @param boolean $deleteFromServer sollen die Mails vom Server gelöscht werden
   * @return array
   */
  public function getRange( $offset, $limit, $deleteFromServer = false)
  {

    $set = $this->resource->fetchFromOffset($offset, $limit, $deleteFromServer);

    $parser = new ezcMailParser();
    return $parser->parseMail( $set );

  }//end public function getRange */

  /**
   * @param int $idx
   * @param boolean $deleteFromServer sollen die Mails vom Server gelöscht werden
   * @return array
   */
  public function getMessageByIndex( $idx, $deleteFromServer = false)
  {

    $set = $this->resource->fetchByMessageNr($idx, $deleteFromServer);

    $parser = new ezcMailParser();
    return $parser->parseMail( $set );

  }//end public function getMessageByIndex */


}//end class LibConnector_Message_Ez

