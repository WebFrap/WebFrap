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
class LibMessageInternalMessage extends LibMessageAdapter
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Das New Line Format das in den Messages verwendet wird   *
   */
  const NL = "\n";


/*//////////////////////////////////////////////////////////////////////////////
// Getter and Setter
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param String $address
   * @param String $sender
   */
  public function __construct($address = null, $sender = null)
  {

    if ($address) {
      $this->address = $address;
    }

    if ($sender) {

      $this->sender = $sender;

    } else {

      $db = $this->getDb();
      $orm = $db->getOrm();

      $this->sender = $orm->get( 'WbfsysRoleUser', Webfrap::$env->getUser()->getid());
    }

  }//end public function __construct */


/*//////////////////////////////////////////////////////////////////////////////
// Logic
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Senden der Nachricht
   * @param string $address
   * @return boolean
   */
  public function send($address = null)
  {

    $db   = $this->getDb();
    $orm  = $db->getOrm();

    // Variables
    if (!$address) {
      $address = $this->address;
    }

    // ohne adresse geht halt nix
    if (!$address) {
      throw new LibMessage_Exception( 'Missing User Message ID');
    }

    $messageObj = $orm->newEntity( 'WbfsysMessage');
    $channelObj = $orm->newEntity( 'WbfsysMessageChannel');

    // den content setzen
    if ($this->view) {
      $messageObj->message = $this->view->build();

      if($this->plainText)
        $this->text_message = $this->plainText;

    } else {

      // text mappen
      if ($this->htmlText){

        $messageObj->message = $this->htmlText;

        if($this->plainText)
          $this->text_message = $this->plainText;
      } else {
        $messageObj->message = $this->plainText;
      }

    }

    $messageObj->title = $this->subject;

    // Header
    $messageObj->id_sender = $this->sender->getId();
    $messageObj->flag_sender_deleted   = 0;

    if ($this->replyTo) {
      $messageObj->id_answer_to = $this->replyTo;
    }

    if ($this->priority) {
      $messageObj->priority = $this->priority;
    } else {
      $messageObj->priority = EPriority::MEDIUM;
    }

    $messageObj->message_id = Webfrap::uuid();

    $db->begin();

    // speichern der Nachricht, und damit verschicken
    $orm->save($messageObj);

    $channelObj->id_message = $messageObj;
    $channelObj->status = EMessageStatus::IS_NEW;
    $channelObj->vid = $address;
    $channelObj->flag_hidden = false;
    $orm->save($channelObj);


    if ($this->attachment || $this->embedded) {
      $entityObj = $orm->getByKey( 'WbfsysEntity', 'wbfsys_message');
    }

    foreach ($this->attachment as $attachment) {
      $attachmentObj = $orm->newEntity( 'WbfsysEntityAttachment');

      $attachmentObj->vid       = $messageObj;
      $attachmentObj->id_file   = $attachment;
      $attachmentObj->id_entity = $entityObj;
      $orm->save($attachmentObj);
    }

    foreach ($this->cc as $sendAlsoCC) {
      $receiverAlso = $orm->copy($channelObj);
      $receiverAlso->vid = $sendAlsoCC;
      $orm->save($receiverAlso);
    }

    foreach ($this->bbc as $sendAlsoBBC) {
      $receiverAlso = $orm->copy($channelObj);
      $receiverAlso->flag_hidden = true;
      $receiverAlso->vid = $sendAlsoCC;
      $orm->save($receiverAlso);
    }

    $db->commit();

  }//end protected function send */


} // end class LibMessageInternalMessage

