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
class LibMessageChannelMessage
  extends LibMessageChannel
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
   * @param LibMessageEnvelop $message
   * @param array<array<key:value>,string address> $receivers
   * 
   * @throws LibMessage_Exception
   */
  public function send( $message, $receivers ) 
  {
    
    $renderer = $this->getRenderer( );
    
    $sender   = $message->getSender();
    
    if( !$sender )
      $sender = $this->getSender( );

    $mailer = new LibMessageInternalMessage( );

    $mailer->setPriority( $message->getPriority( ) );

    if( $attachments = $message->getAttachments( ) )
    {
      foreach( $attachments as $file => $path )
      {
        $mailer->addAttachment( $file, $path );
      }
    }
    
    // jedem empfänger eine personalisierte Mail schicken
    foreach( $receivers as $receiver )
    {
      
      $mailer->cleanData( );
      $mailer->setSubject( $message->getSubject( $receiver, $sender ) );
      $message->buildContent( $receiver, $sender );
      
      if( $message->hasRichText( ) )
      {
        $mailer->setHtmlText( $renderer->renderHtml( $message, $receiver, $sender ) );
      }
      
      if( $message->hasPlainText( ) )
      {
        $mailer->setPlainText( $renderer->renderPlain( $message, $receiver, $sender ) );
      }
      
      $message->loadAttachments();
      
      $dmsAttachments = $message->getAttachments();
      
      foreach( $dmsAttachments as $attachment )
      {
        $mailer->addAttachment( $attachment );
      }
      
      /*
      $attachedFiles = $message->getAttachedFiles();
      foreach( $attachedFiles as $fullPath => $fileName )
      {
        $mailer->addAttachment( $fileName , PATH_GW.$fullPath );
      }
      
      $embededFiles = $message->getEmbededFiles();
      foreach( $embededFiles as $fullPath => $fileName )
      {
        $mailer->addEmbedded( $fileName , PATH_GW.$fullPath );
      }
      */
      
      Debug::console
      ( 
        "try to send a mail: ".$message->getSubject( $receiver )."  to ".$receiver->id, 
        $renderer->renderHtml( $message, $receiver, $sender ) 
      );
      
      //Message::addMessage(  "send to {$receiver->userId}" );
      
      $mailer->send( $receiver->id );
    }
    
  }//end public function send */

  
  /**
   * (non-PHPdoc)
   * @see LibMessageChannel::getRenderer()
   */
  public function getRenderer()
  {
    
    if( !$this->renderer )
    {
      $this->renderer = new LibMessageRendererMessage();
    }
    
    return $this->renderer;
    
  }//end public function getRenderer */


} // end LibMessageChannelMessage

