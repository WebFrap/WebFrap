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
 * Basisklasse für System Nachrichten
 *
 * Diese Klasse enthält nur die nötigsten Information welche zum versenden
 * einer Nachricht benötigt werden.
 *
 * Alle andere Informationen sind direkt im Versandweg oder dem Message Provider
 * zu entnehmen
 *
 * @package WebFrap
 * @subpackage tech_core
 */
class LibMessageStack extends PBase
{

  /**
   * Die Person welche die Nachricht geschickt hat
   *
   * @var WbfsysRoleUser_Entity
   */
  public $sender = null;

  /**
   * Antwort Adresse
   *
   * @var string
   */
  public $replyTo = null;

  /**
   * Array mit direkt addressierten Benutzern / Empfängern
   * @var array<IReceiver>
   */
  public $receivers = array();

  /**
   * Array mit Gruppen an welche die Nachricht gehen soll
   * @var array<WbfsysRoleGroup_Entity>
   * /
  public $receiverGroups = array();

  /**
   * Array mit Plain Addressen. Wird benötigt wenn die Empfänger nicht im
   * System gepflegt sind
   * @var array<string type: array<string address>>
   * /
  public $addresses = array();

  /**
   * Das Subjekt der Nachricht
   * @var string
   */
  public $subject = null;

  /**
   * Inhalt der Nachricht
   * @var string
   */
  public $content = null;

  /**
   * Dateien die der Nachricht angehängt werden sollen
   * @var array<name:WbfsysFile_Entity>
   */
  public $attachments = array();

  /**
   * Dateien die der Nachricht angehängt werden sollen
   * @var array<string{path}:string{key}>
   */
  public $attachedFiles = array();

  /**
   * Dateien die der Nachricht eingebunden werden sollen ( zb layout bilder )
   * @var array<string{path}:string{key}>
   */
  public $embededFiles = array();

  /**
   * Dateien die der Nachricht eingebunden werden sollen ( zb layout bilder )
   * @var array<string{path}:string{key}>
   */
  public $embededLayout = array();
  
  /**
   * Referenzen auf Entities im Globalen Index
   * @var array<int:VID, int:Entity>
   */
  public $indexRefs = array();

  /**
   * Nachrichten Kanäle über welche die Nachricht versandt wird
   * Eine Nachricht kann paralle durch mehrer Channels geschickt werden
   * Relevant sind die hier gelisteten Channel.
   *
   * Abhängig von den gepflegten Benutzerdaten werden dann jeweils Nachrichten
   * verschickt
   *
   * @var array<string>
   */
  public $channels = array();
  
  /**
   * Aspekte der Nachricht
   * @var array<int>
   */
  public $aspects = array( EMessageAspect::MESSAGE );

  /**
   * Der Type der Nachricht,
   * - plain  Plaintext
   * - html   Rich Text Format mit (X)HTML
   * - both   Sowohl als Rich als auch als Plain verschicken, wenn der Channel nur
   *          ein Format unterstützt wird die Nachricht als html verschickt.
   *          Both findet nur in Mail Anwendung
   *
   * Standardmäßig werden Nachrichten im Rich Text Format versendet
   *
   * @var string
   */
  public $type = 'html';

  /**
   * Pfad zum Master Template der Nachricht
   * @var string
   */
  public $htmlMaster = null;

  /**
   * Pfad zum Template für die Nachricht
   * @var string
   */
  public $htmlTemplate = null;

  /**
   * Html Content
   * @var string
   */
  public $htmlContent = null;

  /**
   * Html Dynamischer Content
   * @var string
   */
  public $htmlDynContent = null;

  /**
   * Pfad zum Master Template der Nachricht
   * @var string
   */
  public $plainMaster = null;

  /**
   * Pfad zum Template für die Nachricht
   * @var string
   */
  public $plainTemplate = null;

  /**
   * Plaintext Content
   * @var string
   */
  public $plainContent = null;

  /**
   * Plaintext Dynamischer Content
   * @var string
   */
  public $plainDynContent = null;

  /**
   * Priorität der Nachricht
   * @var int
   */
  public $priority = 3;

  /**
   * Die Entity zu der die Nachricht in Relation steht
   * @var Entity
   */
  public $entity = null;

  /**
   * Security area zum zum auslesen der Gruppenrelation
   * @var string
   */
  public $area = null;

  /**
   * The Server Address
   * @var string
   */
  public $serverAddress = null;

  /**
   * @var WebfrapInfo
   */
  public $info = null;

  /**
   * Die ID des Stacks um später zusammengehörende Personalisierte Mails
   * besser gruppieren zu können
   * @var string
   */
  public $stackId = null;

  /**
   * Flag ob eine Action Required ist
   * @var boolean
   */
  public $actionRequired = false;

/*//////////////////////////////////////////////////////////////////////////////
// Construct
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   */
  public function __construct()
  {

    $this->info = WebfrapInfo::getDefault();

    $this->stackId = Webfrap::uuid();

  }//end public function __construct */

/*//////////////////////////////////////////////////////////////////////////////
// Content
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param LibMessageSender $sender = null
   * @return string
   */
  public function setSender($sender )
  {

    if ($sender instanceof WbfsysRoleUser_Entity )
      $this->sender = new LibMessageSender($sender );
    else
      $this->sender = $sender;

  }//end public function setSender */

  /**
   * @param LibMessageSender $sender = null
   * @return string
   */
  public function getSender( )
  {
    return $this->sender;

  }//end public function getSender */

  /**
   * Subject der Nachricht
   *
   * @param LibMessageReceiver $receiver = null
   * @param LibMessageSender $sender = null
   * @return string
   */
  public function getSubject($receiver = null, $sender = null )
  {

    return $this->subject;

  }//end public function getSubject */

  /**
   * Erstellen des Contents, soweit dynamisch nötig
   *
   * @param LibMessageReceiver $receiver = null
   * @param LibMessageSender $sender = null
   * @return string
   */
  public function buildContent($receiver = null, $sender = null )
  {
  }//end public function buildContent */

  /**
   * @return boolean
   */
  public function hasRichText()
  {

    if ($this->htmlMaster || $this->htmlTemplate || $this->htmlContent || $this->htmlDynContent) {
      return true;
    } else {
      return false;
    }

  }//end public function hasRichText */

  /**
   * @return boolean
   */
  public function hasPlainText()
  {

    if ($this->plainMaster || $this->plainTemplate || $this->plainContent || $this->plainDynContent) {
      return true;
    } else {
      return false;
    }

  }//end public function hasPlainText */

/*//////////////////////////////////////////////////////////////////////////////
// Logic
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Anfragen der Channellist an welche die Nachricht geschickt werden soll
   * Eine Nachricht kann paralle durch mehrer Channels geschickt werden
   *
   * @return array<string>
   */
  public function getChannels()
  {
    return $this->channels;

  }//end public function getChannels */

  /**
   * @param array $channels
   */
  public function setChannels( array $channels )
  {
    $this->channels = $channels;
  }//end public function setChannels */

/*//////////////////////////////////////////////////////////////////////////////
// Priority
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @setter self::priority
   * @param int $priority
   */
  public function setPriority($priority )
  {

    $this->priority = $priority;

  }//end public function setPriority */

  /**
   * @getter self::priority
   * @return int
   */
  public function getPriority( )
  {
    return $this->priority;

  }//end public function getPriority */

/*//////////////////////////////////////////////////////////////////////////////
// Area
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @setter self::area
   * @param string $area
   */
  public function setArea($area )
  {

    $this->area = $area;

  }//end public function setArea */

  /**
   * @getter self::area
   * @return string
   */
  public function getArea( )
  {
    return $this->area;

  }//end public function getArea */

/*//////////////////////////////////////////////////////////////////////////////
// Entity
//////////////////////////////////////////////////////////////////////////////*/

   /**
    * @setter self::varName
    * @param varType $varName
    */
   public function setAttrKey($varName )
   {

     $this->varName = $varName;

   }//end public function setAttrKey */

   /**
    * @getter self::varName
    * @return varType
    */
   public function getAttrKey( )
   {
     return $this->varName;

   }//end public function getAttrKey */

/*//////////////////////////////////////////////////////////////////////////////
// Attachments
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @setter self::attachments
   * @param array $attachments
   */
  public function setAttachments($attachments )
  {

    $this->attachments = $attachments;

  }//end public function setAttachments */

  /**
   * @getter self::attachments
   * @return array
   */
  public function getAttachments( )
  {
    return $this->attachments;

  }//end public function getAttachments */

  /**
   * @param WbfsysFile_Entity
   */
  public function addAttachment($attachment )
  {

    $this->attachments[] = $attachment;

  }//end public function addAttachment */

  /**
   * @getter self::$attachedFiles
   * @return array
   */
  public function getAttachedFiles( )
  {
    return $this->attachedFiles;

  }//end public function getAttachedFiles */

  /**
   * @param string $fileName
   * @param string $fullPath
   */
  public function attachFile($fileName, $fullPath )
  {

    $this->attachedFiles[$fullPath] = $fileName;

  }//end public function addAttachment */

  /**
   * @getter self::$embededFiles
   * @return array
   */
  public function getEmbededFiles( )
  {
    return $this->embededFiles;

  }//end public function getEmbededFiles */

  /**
   * @getter self::$embededLayout
   * @return array
   */
  public function getEmbededLayout( )
  {
    return $this->embededLayout;

  }//end public function getEmbededLayout */

 /**
   * @param string $fileName
   * @param string $fullPath
   */
  public function embedFile($fileName, $fullPath )
  {

    $this->embededFiles[$fullPath] = $fileName;

  }//end public function embedFile */

 /**
   * @param string $fileName
   * @param string $fullPath
   */
  public function embedLayout($fileName, $fullPath )
  {

    $this->embededLayout[$fullPath] = $fileName;

  }//end public function embedFile */

  /**
   *
   */
  public function loadAttachments()
  {

  }//end public function loadAttachments */

/*//////////////////////////////////////////////////////////////////////////////
// Receiver
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param IReceiver $receiver
   */
  public function addReceiver($receiver )
  {

    $this->receivers[] = $receiver;

  }//end public function addReceiver */

  /**
   * @return array<IReceiver>
   */
  public function getReceivers()
  {
    return $this->receivers;

  }//end public function getReceivers */

/*//////////////////////////////////////////////////////////////////////////////
// Get Server Name
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param boolean $forceHttps
   * @return string
   */
  public function getServerAddress($forceHttps = false )
  {
    return Webfrap::$env->getRequest()->getServerAddress($forceHttps );

  }//end public function getServerAddress */

/*//////////////////////////////////////////////////////////////////////////////
// Clean
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Leeren des Content
   */
  public function clean()
  {

    $this->htmlDynContent   = null;
    $this->htmlContent      = null;

    $this->plainDynContent  = null;
    $this->plainContent  = null;

  }//end public function clean */

} // end class LibMessageStack

