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

/*
* Mail Header:
*
* To                                      (X)
* Subject                                 (X)
* User-Agent                              (X)
* MIME-Version                            (X)
* Content-Type                            (X)
* From                                    (X)
* Cc
* Bcc
* X-Priority                              (X)
* Importance                              (X)
* Content-Class
* Content-Transfer-Encoding               (X)
* Content-Disposition                     (X)
* Content-Description (bei Anhaengen)     (X)
* Reply-To                                (X)
* Return-Path                             (X)
*
* Received
* Delivered-To
* Message-ID
*
*/


/**
 * @package WebFrap
 * @subpackage tech_core
 *
 * @todo Festlegen was passiert wenn sowohl mehrere Empfänger als auch
 * BBC und CC angegeben werden
 *
 */
class LibMessageInternalMessage
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Das New Line Format das in den Messages verwendet wird   *
   */
  const NL = "\n";

  /**
   * @var string
   */
  protected $address  = null;

  /**
   * the mail Subject
   *
   * @var string
   */
  protected $subject  = null;

  /**
   * Plain Text
   *
   * @var string
   */
  protected $plainText  = null;

  /**
   * html text
   *
   * @var string
   */
  protected $htmlText   = null;

  /**
   * list of files to attach
   *
   * @var array<string>
   */
  protected $attachment = array();

  /**
   * list of files to attach
   *
   * @var array<string>
   */
  protected $embedded = array();


/*//////////////////////////////////////////////////////////////////////////////
// Header Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Die Absender Addresse
   * @var string
   */
  protected $sender   = null;

  /**
   * @var string
   */
  protected $replyTo  = null;

    /**
   * Enter description here...
   *
   * @var array
   */
  protected $bbc   = array();

  /**
   * Enter description here...
   *
   * @var array
   */
  protected $cc   = array();

  /**
   * the importance of the mail
   *
   * <ul>
   * <li>high</li>
   * <li>normal</li>
   * <li>low</li>
   * </ul>
   *
   * @var string
   */
  protected $priority = 'normal';
  
/*//////////////////////////////////////////////////////////////////////////////
// Header Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Die View
   * @var LibTemplateMail
   */
  public $view = null;

  /**
   * Das Datenbank Objekt
   * @var LibDbConnection
   */
  public $db = null;  

/*//////////////////////////////////////////////////////////////////////////////
// Getter and Setter
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param String $address
   * @param String $sender
   */
  public function __construct($address = null, $sender = null )
  {

    if ($address )
    {
      $this->address = $address;
    }

    if ($sender )
    {
      $this->sender = $sender;
    } else {
      
      $db = $this->getDb();
      $orm = $db->getOrm();
      
      $this->sender = $orm->get( 'WbfsysRoleUser', Webfrap::$env->getUser()->getid() );
    }

  }//end public function __construct */

/*//////////////////////////////////////////////////////////////////////////////
// Resource Getter and Setter
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param boolean $create
   * @return LibTemplateMail
   */
  public function getView($create = true )
  {

    if ($create && !$this->view )
      $this->view = new LibTemplateMail();

    return $this->view;

  }//end public function getView */
  
  /**
   * Setter for the view
   */
  public function setView( LibTemplate $view )
  {
    $this->view = $view;
  }//end public function setView */
  
  /**
   * @return LibDbConnection
   */
  public function getDb()
  {

    if (!$this->db )
      $this->db = Webfrap::$env->getDb();

    return $this->db;

  }//end public function getDb */
  
  /**
   * @param LibDbConnection $db
   */
  public function setDb($db )
  {
    $this->db = $db;
  }//end public function setDb */

/*//////////////////////////////////////////////////////////////////////////////
// Data Getter and Setter
//////////////////////////////////////////////////////////////////////////////*/
  
  /**
   * the address to send the mail
   *
   * @param string $address
   */
  public function setAddress($address )
  {
    $this->address = $address;
  }//end public function setAddress */

  /**
   * the address to send the mail
   *
   * @param string $address
   */
  public function addAddress($address )
  {

    if ( is_array($address) )
    {
      if (!$this->address)
      {
        if ($addr = array_pop($address))
        {
          $this->address = $this->encode($addr);
        }
      }

      foreach($address as $addr )
      {
        $this->address .= ', '. $this->encode($addr );
      }
    } else {
      if (is_null($this->address) )
      {
        $this->address = $this->encode($address );
      } else {
        $this->address .= ', '. $this->encode($address );
      }
    }

  }//end public function setAddress */

  /**
   * @param string $subject
   */
  public function setSubject($subject )
  {
    $this->subject = $subject;
  }//end public function setSubject */

  /**
   * @param string $priority
   */
  public function setPriority($priority )
  {

    $possible = array
    (
      1 => 50, //very high
      2 => 40,
      3 => 30,
      4 => 20,
      5 => 10, //very low
      50 => 50, //very high
      40 => 40,
      30 => 30,
      20 => 20,
      10 => 10, //very low
    );

    if ( isset($possible[$priority]) )
    {
      $this->priority = $possible[$priority];
    }

  }//end public function setPriority */


  /**
   * set the reply address for the mail
   *
   * @param string $replyTo
   */
  public function setReplyTo($replyTo )
  {
    $this->replyTo = $replyTo;
  }//end public function setSubject */

  /**
   * Absender setzen
   *
   * @param string $sender
   */
  public function setSender($sender , $name = null )
  {
    
    $this->sender = $sender;

  }//end public function setSubject */

  /**
   * Common Copy Empfänger hinzufügen
   * 
   * @param string $bbc
   * @param string $name
   */
  public function addBbc($bbc, $name = null )
  {

    if ($name )
    {
      $this->bbc[] = $this->encode($name.' <'.$bbc.'>' );
    } else {
      $this->bbc[] = $this->encode($bbc );
    }

  }//end public function addBbc */

  /**
   * Common Copy Empfänger hinzufügen
   * @param string $cc
   * @param string $name
   */
  public function addCc($cc  , $name = null )
  {

    if ($name )
    {
      $this->cc[] = $this->encode($name.' <'.$cc.'>' );
    } else {
      $this->cc[] = $this->encode($cc );
    }

  }//end public function addCc */

  /**
   * Plaintext Content der Mail setzen
   * @param string $plainText
   */
  public function setPlainText($plainText )
  {
    
    $this->plainText = $plainText;
  }//end public function setPlainText */

  /**
   * Html Content der Mail setzen
   * @param string $htmlText
   */
  public function setHtmlText($htmlText )
  {
    
    $this->htmlText = $htmlText;
  }//end public function setHtmlText */


  /**
   * @param string $charset
   */
  public function addAttachment($fileName , $fullPath )
  {
    
    $this->attachment[$fileName] = $fullPath;
  }//end public function addAttachment */

  /**
   * @param string $fileName
   * @param string $fullPath
   */
  public function addEmbedded($fileName , $fullPath )
  {
    
    $this->embedded[$fileName] = $fullPath;
  }//end public function addEmbedded */

/*//////////////////////////////////////////////////////////////////////////////
// Logic
//////////////////////////////////////////////////////////////////////////////*/


  /**
   * Senden der Nachricht
   * @param string $address
   * @return boolean
   */
  public function send($address = null )
  {
    
    $db   = $this->getDb();
    $orm  = $db->getOrm();

    // Variables
    if (!$address )
    {
      $address = $this->address;
    }
    
    // ohne adresse geht halt nix
    if (!$address )
    {
      throw new LibMessage_Exception( 'Missing User Message ID' );
    }

    $messageObj = $orm->newEntity( 'WbfsysMessage' );
    
    // den content setzen
    if ($this->view )
    {
      $messageObj->message = $this->view->build();
    } else {
      $messageObj->message = !is_null($this->htmlText)?$this->htmlText:$this->plainText;
    }
    
    $messageObj->title = $this->subject;

    // Header
    $messageObj->id_sender = $this->sender;
    $messageObj->id_receiver = $address;
    
    $messageObj->id_sender_status   = EMessageStatus::IS_NEW;
    $messageObj->id_receiver_status = EMessageStatus::IS_NEW;
    
    $messageObj->flag_sender_deleted   = 0;
    $messageObj->flag_receiver_deleted = 0;

    if ($this->replyTo )
    {
      $messageObj->id_answer_to = $this->replyTo;
    }

    if ($this->priority )
    {
      $messageObj->priority = $this->priority;
    } else {
      $messageObj->priority = EPriority::MEDIUM;
    }
    
    $messageObj->message_id = Webfrap::uuid();
    
    $db->begin();
    
    // speichern der Nachricht, und damit verschicken
    $orm->save($messageObj );

    if ($this->attachment || $this->embedded )
    {
      $entityObj = $orm->getByKey( 'WbfsysEntity', 'wbfsys_message' );
    }
    
    foreach($this->attachment as $attachment )
    {
      $attachmentObj = $orm->newEntity( 'WbfsysEntityAttachment' );
      
      $attachmentObj->vid      = $messageObj;
      $attachmentObj->id_file   = $attachment;
      $attachmentObj->id_entity = $entityObj;
      $orm->save($attachmentObj );
    }

    foreach($this->cc as $sendAlsoCC )
    {
      $receiverAlso = $orm->copy($messageObj );
      $receiverAlso->id_receiver = $sendAlsoCC;
      $orm->save($receiverAlso );
    }
    
    foreach($this->bbc as $sendAlsoBBC )
    {
      $receiverAlso = $orm->copy($messageObj );
      $receiverAlso->id_receiver = $sendAlsoCC;
      $orm->save($receiverAlso );
    }

    $db->commit();
    
  }//end protected function send */

  /**
   * Strings richtig encodieren
   * 
   * @param string $data
   * @return string
   */
  protected function encode($data )
  {
    return $data;
  }//end protected function encode */

  
  /**
   * inhalt der nachricht leeren
   */
  public function cleanData()
  {
    
    $this->subject     = null; 
    $this->plainText   = null;
    $this->htmlText    = null;
    
  }//end public function cleanData */

} // end class LibMessageMail

