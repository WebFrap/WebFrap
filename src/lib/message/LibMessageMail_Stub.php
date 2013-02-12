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
 * @package WebFrap
 * @subpackage tech_core
 *
 * @todo Festlegen was passiert wenn sowohl mehrere Empfänger als auch
 * BBC und CC angegeben werden
 *
 */
class LibMessageMail_Stub
  extends LibMessageMail
{
  
  
 /**
   *
   * @param string $address
   * @return boolean
   */
  public function send( $address = null )
  {


    // Variables
    if( !$address )
    {
      $address = $this->address;
    }
    
    // ohne adresse geht halt nix
    if( !$address )
    {
      throw new LibMessage_Exception( 'Missing E-Mail Address' );
    }

    if( $this->view )
    {
      $message = utf8_decode($this->view->build());
    }
    else
    {
      $message = !is_null($this->htmlText)?$this->htmlText:$this->plainText;
    }


    $boundary = 'boundary-'.strtoupper(md5(uniqid(time())));
    if( $this->htmlText || $this->view )
    {
      $contentType = 'text/html';
    }
    else
    {
      $contentType = 'text/plain';
    }

    // Header
    $header = 'From: '.htmlspecialchars_decode($this->sender).self::NL;

    if( $this->replyTo )
    {
      $header .= 'Reply-To:'.htmlspecialchars_decode($this->replyTo).self::NL;
    }

    $header .= 'User-Agent: WebFrap'.self::NL;

    if( $this->returnPath )
    {
      $header .= 'Return-Path: <'.$this->returnPath.'>'.self::NL;
    }
    
    if( $this->importance )
    {
      $header .= 'Importance: '.$this->importance.self::NL;
    }
    
    if( $this->xPriority )
    {
      $header .= 'X-Priority: '.$this->xPriority.self::NL;
    }

    $header .= 'MIME-Version: '.$this->mimeType.self::NL;
    $header .= 'Content-Type: Multipart/Mixed; boundary="'.$boundary.'"'.self::NL;

    $body = 'This is a multi-part message in MIME format'.self::NL;
    $body .= '--'.$boundary.self::NL;
    $body .= 'Content-Type: '.$contentType.'; charset="'.$this->charset.'"'.self::NL;
    $body .= 'Content-Transfer-Encoding:  7bit'.self::NL;
    $body .= 'Content-Disposition: inline'.self::NL.self::NL;
    $body .= $message.self::NL.self::NL;

    foreach( $this->attachment as $fileName => $attach )
    {
      $body .= $this->buildAttachement( $fileName, $attach, $boundary ).self::NL;
    }

    foreach( $this->embedded as $fileName => $attach )
    {
      $body .= $this->buildEmbeddedResource( $fileName, $attach, $boundary ).self::NL;
    }

    $body .= '--'.$boundary.'--';
    
    
    $mail = <<<MAIL
<?xml version="1.0" encoding="UTF-8" ?>
<mail>
  <receiver>{$address}</receiver>
  <subject>{$this->subject}</subject>
  <body>{$body}</body>
  <header>{$header}</header>
</mail>

MAIL;
    
    SFiles::write
    ( 
      PATH_GW.'tmp/messages/'.Webfrap::getRunId().'/'.$address.'.txt' , 
      $mail 
    );
    
    $logger = $this->getLogger();
    $logger->logMessage( $address, $this->subject );


  }//end protected function send */

} // end class LibMessageMail_Stub

