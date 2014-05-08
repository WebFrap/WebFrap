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
 * Der Massmailer ist dazu da um personalisierte E-Mails an Empfänger listen 
 * schicken zu können
 * 
 * @package WebFrap
 * @subpackage tech_core
 *
 */
class LibMessageMassMailer
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * the mail Subject
   *
   * @var string
   */
  protected $subject = null;

  /**
   * the mail Subject
   * @var string
   */
  protected $header = null;
  
  /**
   * Plain Text template
   * @var string
   */
  public $plainContent = null;

  /**
   * Html Text template
   * @var string
   */
  public $htmlContent = null;

  /**
   * Liste der anzuhängenden Dateien
   * @var array<string>
   */
  public $attachment = array();

  /**
   * Liste der zu embededten Dateien
   * @var array<string>
   */
  public $embedded = array();

  /**
   * Gecachte attachments
   * @var array<string>
   */
  protected $attachmentCache = array();

  /**
   * gecachte embdeded files
   * @var array<string>
   */
  protected $embeddedCache = array();
  
  /**
   * Mail boundary
   * @var string
   */
  protected $boundary = null;

/*//////////////////////////////////////////////////////////////////////////////
// Header Attributes
//////////////////////////////////////////////////////////////////////////////*/

   /**
   * Der mime Type der Message   *
   * @var string
   */
  public $mimeType = '1.0';

  /**
   * Die Absender Addresse
   * @var string
   */
  public $sender = null;

  /**
   * @var string
   */
  public $replyTo = null;

  /**
   * @var string
   */
  public $userAgent = 'Webfrap';

  /**
   * @var string
   */
  public $contentType = 'text/html';

  /**
   * Mail Charset
   *
   * @var string
   */
  public $charset = 'ISO-8859-1';

  /**
   * set the x Priority
   *
   * @var string
   */
  public $xPriority = '3 (Normal)';

  /**
   * the return Path for the Mail
   * @var string
   */
  public $returnPath = null;

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
  public $importance = 'normal';

  /**
   * Message Logger..
   * @var LibMessageLogger
   */
  public $logger = null;

  /**
   * Render Object
   * @var CmsRenderContent_Renderer
   */
  public $renderer = null;

/*//////////////////////////////////////////////////////////////////////////////
// Getter and Setter
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param String $address
   * @param String $sender
   * @param LibMessageLogger $logger
   */
  public function __construct(
    $logger = null
  ){




    $this->logger = $logger;

  }//end public function __construct */

/*//////////////////////////////////////////////////////////////////////////////
// Getter and Setter
//////////////////////////////////////////////////////////////////////////////*/


  /**
   * @return LibMessageLogger
   */
  public function getLogger()
  {

    if (!$this->logger)
      $this->logger = new LibMessageLogger(Webfrap::$env->getDb(), Webfrap::$env->getUser());

    return $this->logger;

  }//end public function getLogger */

  

/*//////////////////////////////////////////////////////////////////////////////
// Logic
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $fileName
   * @param string $attach
   * @param string $boundary
   * @throws LibMessage_Exception
   * 
   * @return string
   */
  protected function buildAttachement($fileName, $attach, $boundary)
  {

    if (isset($this->attachmentCache[$fileName])) {
      return $this->attachmentCache[$fileName];
    }
      
    if (!is_readable($attach)) {
      throw new LibMessage_Exception(
        'Tried to send nonreadable file: '.$attach.' by mail'
      );
    }

    $mimeType = SFiles::getMimeType($fileName);

    $attachment = '--'.$boundary.NLB;
    $attachment .= 'Content-Type: '.$mimeType.'; name="'.$fileName.'"'.NLB;
    $attachment .= 'Content-Transfer-Encoding: base64'.NLB;
    //$header .= 'Content-Disposition: attachment; filename="'.$fileName.'"'.NL.NL;
    $attachment .= 'Content-Disposition: attachment; filename="'.$fileName.'"'.NLB.NLB;
    $attachment .= chunk_split(base64_encode(SFiles::read($attach)));

    $this->attachmentCache[$fileName] = $attachment;
    return $this->attachmentCache[$fileName];

  }//end protected function buildAttachement */

  /**
   * @param string $fileName
   * @param string $attach
   * @param string $boundary
   * @throws LibMessage_Exception
   * @return string
   */
  protected function buildEmbeddedResource($fileName , $attach , $boundary)
  {

    if(isset($this->embeddedCache[$fileName])){
      return $this->embeddedCache[$fileName];
    }
      
    if (!is_readable($attach)) {
      throw new LibMessage_Exception(
        'Tried to send nonreadable file: '.$attach.' by mail'
      );
      return '';
    }

    $mimeType = SFiles::getMimeType($fileName);

    $attachment = '--'.$boundary.NLB;
    $attachment .= 'Content-Type: '.$mimeType.'; name="'.$fileName.'"'.NLB;
    $attachment .= 'Content-Transfer-Encoding: base64'.NLB;
    //$header .= 'Content-Disposition: attachment; filename="'.$fileName.'"'.NL.NL;
    //$attachment .= 'Content-ID: <embeded@'.$fileName.'>'.NLB.NLB;
    $attachment .= 'Content-ID: <embeded@'.$fileName.'>'.NLB.NLB;
    $attachment .= chunk_split(base64_encode(SFiles::read($attach)));

    //embedd with: <img src="cid:embeded@news" width="120" >
    $this->embeddedCache[$fileName] =$attachment;
    return $this->embeddedCache[$fileName];

  }//end protected function buildAttachement */

  /**
   * @param string $sender
   * @param string $subject
   * @param string $htmlContent
   * @param string $plainContent
   * @param array $attachments
   * @param array $embeds
   * @throws LibMessage_Exception
   */
  public function prepareMail(
      $sender,
      $subject,
      $htmlContent,
      $plainContent = null,
      $attachments = array(),
      $embeds = array()
  ){
      
      if ($sender) {
          $this->sender = $this->encode($sender);
      } elseif ($defSender = Conf::status('app.sender')) {
          $this->sender = $defSender;
      } else {
          //todo no server name in cli... has to be maintained in the conf
          $this->sender = 'WebFrap Mail API <do_not_reply@'.$_SERVER['SERVER_NAME'].'>';
      }
      
      $this->subject = $subject;
      $this->htmlContent = $htmlContent;
      $this->plainContent = $plainContent;
      $this->attachment = $attachments;
      $this->embedded = $embeds;
      
      // unique boundary definieren
      $this->boundary = 'boundary-'.strtoupper(md5(uniqid(time())));
      
      // vorladen der attachments
      // so können wir init exceptions abfangen
      foreach ($this->attachment as $fileName => $attach) {
          $this->buildAttachement($fileName, $attach, $this->boundary);
      }
      
      foreach ($this->embedded as $fileName => $attach) {
          $this->buildEmbeddedResource($fileName, $attach, $this->boundary);
      }
      
      
      // Header
      $this->header = 'From: '.htmlspecialchars_decode($this->sender).NL;
      
      if ($this->replyTo) {
          $this->header .= 'Reply-To:'.htmlspecialchars_decode($this->replyTo).NL;
      }
      
      $this->header .= 'User-Agent: '.$this->userAgent.NL;
      
      if ($this->returnPath) {
          $this->header .= 'Return-Path: <'.$this->returnPath.'>'.NL;
      }
      
      if ($this->importance) {
          $this->header .= 'Importance: '.$this->importance.NL;
      }
      
      if ($this->xPriority) {
          $this->header .= 'X-Priority: '.$this->xPriority.NL;
      }
      
      $this->header .= 'MIME-Version: '.$this->mimeType.NL;
      $this->header .= 'Content-Type: Multipart/Mixed; boundary="'.$this->boundary.'"'.NL;
      
  }// public function prepareMail */
  
  /**
   * Senden der Nachricht
   * @param LibMessageReceiver $receiver
   * @return boolean
   */
  public function send($receiver)
  {
    // ohne adresse geht halt nix
    if (!$receiver->address) {
      // das sollte eigentlich nicht passieren
      throw new LibMessage_Exception('Missing E-Mail Address');
    }

    $body = 'This is a multi-part message in MIME format'.NL;
    
    if($this->plainContent){
        $body .= '--'.$this->boundary.NL;
        $body .= 'Content-Type: text/plain; charset="'.$this->charset.'"'.NL;
        $body .= 'Content-Transfer-Encoding:  7bit'.NL;
        $body .= 'Content-Disposition: inline'.NL.NL;
        $body .= $this->renderer->compile($this->plainContent,$receiver->vars).NL.NL;
    }
    
    if($this->htmlContent){
        $body .= '--'.$this->boundary.NL;
        $body .= 'Content-Type: text/html; charset="'.$this->charset.'"'.NL;
        $body .= 'Content-Transfer-Encoding:  7bit'.NL;
        $body .= 'Content-Disposition: inline'.NL.NL;
        $body .= $this->renderer->compile($this->htmlContent,$receiver->vars).NL.NL;
    }
    
    foreach ($this->attachment as $fileName => $attach) {
      $body .= $this->buildAttachement($fileName, $attach, $this->boundary).NL;
    }

    foreach ($this->embedded as $fileName => $attach) {
      $body .= $this->buildEmbeddedResource($fileName, $attach, $this->boundary).NL;
    }

    $body .= '--'.$this->boundary.'--';

    /*
    Message::addMessage
    (
      "Send Message to Address: {$address} Subject: ".utf8_encode($this->subject)
    );
    */

    if(
      !mail(
        $address,
        $receiver->subject,
        $body,
        $header
      )
    ) {
      
        $logger = $this->getLogger();
        $logger->logMessage($address, $receiver->subject, false);
        
      throw new LibMessage_Exception(
        'Failed to send Mail to '.$address
      );

    } else {

      $logger = $this->getLogger();
      $logger->logMessage($address, $receiver->subject);

      return true;
    }

  }//end protected function send */

  /**
   * Strings richtig encodieren
   *
   * @param string $data
   * @return string
   */
  protected function encode($data)
  {
    return utf8_decode($data);
  }//end protected function encode */

  /**
   * inhalt der nachricht leeren
   */
  public function cleanData()
  {

    $this->subject = null;
    $this->plainContent = null;
    $this->htmlContent = null;

  }//end public function cleanData */

} // end class LibMessageMail

