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
 *
 * @package WebFrap
 * @subpackage tech_core
 */
class LibMessageChannelMessage extends LibMessageChannel
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @var string
   */
  public $type = 'message';

/*//////////////////////////////////////////////////////////////////////////////
//  Send Logic
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Senden der Nachricht
   *
   * @param LibMessageStack $message
   * @param array<array<key:value>,string address> $receivers
   *
   * @throws LibMessage_Exception
   */
  public function send($message, $receivers)
  {

    $renderer = $this->getRenderer();

    $sender   = $message->getSender();

    if (!$sender)
      $sender = $this->getSender();

    $mailer = new LibMessageInternalMessage();

    $attachments = $message->loadAttachments();

    /*
    foreach ($attachments as $attachment) {
      $envelop->addAttachment($attachment);
    }

    $attachedFiles = $message->getAttachedFiles();
    foreach ($attachedFiles as $fullPath => $fileName) {
      $mailer->addAttachment($fileName , PATH_GW.$fullPath);
    }

    $embededFiles = $message->getEmbededFiles();
    foreach ($embededFiles as $fullPath => $fileName) {
      $mailer->addEmbedded($fileName , PATH_GW.$fullPath);
    }
    */

    // jedem empfänger eine personalisierte Mail schicken
    foreach ($receivers as $receiver) {

      $envelop = new LibMessageEnvelop($message);

      $envelop->subject = $message->getSubject($receiver, $sender);
      $message->buildContent($receiver, $sender);

      if ($message->hasRichText()) {
        $envelop->htmlContent = $renderer->renderHtml($message, $receiver, $sender);
      }

      if ($message->hasPlainText()) {
        $envelop->textContent = $renderer->renderPlain($message, $receiver, $sender);
      }


      Debug::console(
        "try to send a mail: ".$envelop->subject."  to ".$receiver->id,
        $envelop->htmlContent
      );

      //Message::addMessage(  "send to {$receiver->userId}");

      $mailer->send($envelop);
    }

  }//end public function send */

  /**
   * (non-PHPdoc)
   * @see LibMessageChannel::getRenderer()
   */
  public function getRenderer()
  {

    if (!$this->renderer) {
      $this->renderer = new LibMessageRendererMessage();
    }

    return $this->renderer;

  }//end public function getRenderer */

} // end LibMessageChannelMessage

