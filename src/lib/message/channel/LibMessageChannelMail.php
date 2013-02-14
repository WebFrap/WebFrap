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
class LibMessageChannelMail extends LibMessageChannel
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/
  
  public $type = 'mail';
  
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
  public function send($message, $receivers ) 
  {
    
    $renderer = $this->getRenderer( );
    
    $sender   = $message->getSender();
    
    if (!$sender )
      $sender = $this->getSender( );
    
    if ( defined( 'WBF_MESSAGE_SEND' ) && 'stub' == strtolower(WBF_MESSAGE_SEND)  )
    {
      $mailer = new LibMessageMail_Stub( );
    } else {
      $mailer = new LibMessageMail( );
    }
    
    
    $mailer->setPriority($message->getPriority( ) );

    if ($attachments = $message->getAttachments( ) )
    {
      foreach($attachments as $file => $path )
      {
        $mailer->addAttachment($file, $path );
      }
    }
    
    // jedem empfänger eine personalisierte Mail schicken
    foreach($receivers as $receiver )
    {
      
      $mailer->cleanData( );
      $mailer->setSubject($message->getSubject($receiver, $sender ) );
      $message->buildContent($receiver, $sender );
      
      if ($message->hasRichText( ) )
      {
        $mailer->setHtmlText($renderer->renderHtml($message, $receiver, $sender ) );
      }
      
      if ($message->hasPlainText( ) )
      {
        $mailer->setPlainText($renderer->renderPlain($message, $receiver, $sender ) );
      }
      
      $message->loadAttachments();
      $dmsAttachments = $message->getAttachments();
      
      foreach($dmsAttachments as $attachment )
      {
        $fileId   = $attachment->getId();
        $fullPath = PATH_GW.'data/uploads/wbfsys_file/name'.SParserString::idToPath($fileId).'/'.$fileId;
        
        $mailer->addAttachment($attachment->name , $fullPath );
      }
      
      $attachedFiles = $message->getAttachedFiles();
      foreach($attachedFiles as $fullPath => $fileName )
      {
        $mailer->addAttachment($fileName , PATH_GW.$fullPath );
      }
      
      $embededFiles = $message->getEmbededFiles();
      foreach($embededFiles as $fullPath => $fileName )
      {
        $mailer->addEmbedded($fileName , PATH_GW.$fullPath );
      }
      
      $embededLayouts = $message->getEmbededLayout();
      foreach($embededLayouts as $fullPath => $fileName )
      {
        $mailer->addEmbedded($fileName , PATH_THEME.'themes/default/images/'.$fullPath );
      }
      
      Debug::console
      ( 
        "try to send a mail: ".$message->getSubject($receiver )."  to ".$receiver->address, 
        $renderer->renderHtml($message, $receiver, $sender ) 
      );
      
      $mailer->send($receiver->address );
    }
    
  }//end public function send */

  
  /**
   * (non-PHPdoc)
   * @see LibMessageChannel::getRenderer()
   */
  public function getRenderer()
  {
    
    if (!$this->renderer )
    {
      $this->renderer = new LibMessageRendererMail();
    }
    
    return $this->renderer;
    
  }//end public function getRenderer */


} // end LibMessageChannelMail

