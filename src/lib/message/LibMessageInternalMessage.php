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
   * @param LibMessageEnvelop $envelop
   * @return boolean
   */
  public function send($envelop)
  {

    $db   = $this->getDb();
    $orm  = $db->getOrm();

    // Variables
    if (!$envelop) {
      throw new LibMessage_Exception( 'Missing User Message ID');
    }

    if (!$envelop->receiver) {
      throw new LibMessage_Exception( 'Missing a receiver!');
    }

    $messageObj = $orm->newEntity( 'WbfsysMessage');
    $msgAspect = $orm->newEntity( 'WbfsysMessageAspect');

    $messageObj->title = $envelop->subject;

    if($envelop->htmlContent)
      $messageObj->message = $envelop->htmlContent;

    if($envelop->textContent)
      $messageObj->text_message = $envelop->htmlContent;

    // Header
    $messageObj->id_sender = $envelop->stack->sender->userId;
    $messageObj->flag_sender_deleted   = 0;

    $messageObj->priority = $envelop->stack->priority
      ? $envelop->stack->priority
      : EPriority::MEDIUM;

    if( $messageObj->priority && 10 > $messageObj->priority )
      $messageObj->priority = $messageObj->priority * 10;


    $messageObj->stack_id = $envelop->stack->stackId;

    $messageObj->message_id = Webfrap::uuid();

    $db->begin();

    // speichern der Nachricht, und damit verschicken
    $orm->save($messageObj);

    $msgAspect->id_message = $messageObj;
    $msgAspect->status = EMessageStatus::IS_NEW;
    $msgAspect->vid = $envelop->receiver->id;
    $msgAspect->flag_hidden = false;
    $msgAspect->channel = EMessageAspect::MESSAGE;
    $orm->save($msgAspect);


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
      $receiverAlso = $orm->copy($msgAspect);
      $receiverAlso->vid = $sendAlsoCC;
      $orm->save($receiverAlso);
    }

    foreach ($this->bbc as $sendAlsoBBC) {
      $receiverAlso = $orm->copy($msgAspect);
      $receiverAlso->flag_hidden = true;
      $receiverAlso->vid = $sendAlsoCC;
      $orm->save($receiverAlso);
    }

    $db->commit();

  }//end protected function send */


} // end class LibMessageInternalMessage

