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
   * Plain Text template
   * @var string
   */
  protected $plainText = null;

  /**
   * Html Text template
   * @var string
   */
  protected $htmlText = null;

  /**
   * Liste der anzuhängenden Dateien
   * @var array<string>
   */
  protected $attachment = array();

  /**
   * Liste der zu embededten Dateien
   * @var array<string>
   */
  protected $embedded = array();
  
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
  protected $mimeType = '1.0';

  /**
   * Die Absender Addresse
   * @var string
   */
  protected $sender = null;

  /**
   * @var string
   */
  protected $replyTo = null;

  /**
   * Enter description here...
   *
   * @var string
   */
  protected $contentType = 'text/html';

  /**
   * Mail Charset
   *
   * @var string
   */
  protected $charset = 'ISO-8859-1';

  /**
   * set the x Priority
   *
   * @var string
   */
  protected $xPriority = '3 (Normal)';

  /**
   * the return Path for the Mail
   * @var string
   */
  protected $returnPath = null;

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
  protected $importance = 'normal';

  /**
   * Message Logger..
   * @var LibMessageLogger
   */
  protected $logger = null;

/*//////////////////////////////////////////////////////////////////////////////
// Getter and Setter
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param String $address
   * @param String $sender
   * @param LibMessageLogger $logger
   */
  public function __construct(
    $sender = null,
    $logger = null
  ){


    if ($sender) {
      $this->sender = $this->encode($sender);
    } elseif ($defSender = Conf::status('app.sender')) {
      $this->sender = $defSender;
    } else {
      //todo no server name in cli... has to be maintained in the conf
      $this->sender = 'WebFrap Mail API <do_not_reply@'.$_SERVER['SERVER_NAME'].'>';
    }

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
   */
  protected function buildAttachement($fileName, $attach, $boundary  )
  {

    if (!is_readable($attach)) {
      Error::report(
        'Tried to send nonreadable file: '.$attach.' by mail'
      );

      return '';
    }

    $mimeType = SFiles::getMimeType($fileName);

    $attachment = '--'.$boundary.self::NLB;
    $attachment .= 'Content-Type: '.$mimeType.'; name="'.$fileName.'"'.self::NLB;
    $attachment .= 'Content-Transfer-Encoding: base64'.self::NLB;
    //$header .= 'Content-Disposition: attachment; filename="'.$fileName.'"'.self::NL.self::NL;
    $attachment .= 'Content-Disposition: attachment; filename="'.$fileName.'"'.self::NLB.self::NLB;
    $attachment .= chunk_split(base64_encode(SFiles::read($attach)));

    return $attachment;

  }//end protected function buildAttachement */

  /**
   * @param string $fileName
   * @param string $attach
   * @param string $boundary
   * @return string
   */
  protected function buildEmbeddedResource($fileName , $attach , $boundary  )
  {

    if (!is_readable($attach)) {
      Error::report(
        'Tried to send nonreadable file: '.$attach.' by mail'
      );
      return '';
    }

    $mimeType = SFiles::getMimeType($fileName);

    $attachment = '--'.$boundary.self::NLB;
    $attachment .= 'Content-Type: '.$mimeType.'; name="'.$fileName.'"'.self::NLB;
    $attachment .= 'Content-Transfer-Encoding: base64'.self::NLB;
    //$header .= 'Content-Disposition: attachment; filename="'.$fileName.'"'.self::NL.self::NL;
    //$attachment .= 'Content-ID: <embeded@'.$fileName.'>'.self::NLB.self::NLB;
    $attachment .= 'Content-ID: <embeded@'.$fileName.'>'.self::NLB.self::NLB;
    $attachment .= chunk_split(base64_encode(SFiles::read($attach)));

    //embedd with: <img src="cid:embeded@news" width="120" >
    return $attachment;

  }//end protected function buildAttachement */

  /**
   * 
   */
  public function prepareMail()
  {
      
  }// public function prepareMail */
  
  /**
   * Senden der Nachricht
   * @param string $address
   * @return boolean
   */
  public function send($receiverData)
  {
    // Variables
    if (!$address) {
      $address = $this->address;
    }

    // ohne adresse geht halt nix
    if (!$address) {
      throw new LibMessage_Exception('Missing E-Mail Address');
    }

    $boundary = 'boundary-'.strtoupper(md5(uniqid(time())));

    if ($this->view) {
      $message = utf8_decode($this->view->build());
    } else {
      $message = !is_null($this->htmlText)?$this->htmlText:$this->plainText;
    }

    if ($this->htmlText || $this->view) {
      $contentType = 'text/html';
    } else {
      $contentType = 'text/plain';
    }

    // Header
    $header = 'From: '.htmlspecialchars_decode($this->sender).self::NL;

    if ($this->replyTo) {
      $header .= 'Reply-To:'.htmlspecialchars_decode($this->replyTo).self::NL;
    }

    $header .= 'User-Agent: WebFrap'.self::NL;

    if ($this->returnPath) {
      $header .= 'Return-Path: <'.$this->returnPath.'>'.self::NL;
    }

    if ($this->importance) {
      $header .= 'Importance: '.$this->importance.self::NL;
    }

    if ($this->xPriority) {
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

    foreach ($this->attachment as $fileName => $attach) {
      $body .= $this->buildAttachement($fileName, $attach, $boundary).self::NL;
    }

    foreach ($this->embedded as $fileName => $attach) {
      $body .= $this->buildEmbeddedResource($fileName, $attach, $boundary).self::NL;
    }

    $body .= '--'.$boundary.'--';

    /*
    Message::addMessage
    (
      "Send Message to Address: {$address} Subject: ".utf8_encode($this->subject)
    );
    */

    if(
      !mail(
        $address,
        $this->subject,
        $body,
        $header
      )
    ) {
      
      Error::report(
        'Failed to send Mail to'.$address
      );

      return false;
    } else {

      $logger = $this->getLogger();
      $logger->logMessage($address, $this->subject);

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
    $this->plainText = null;
    $this->htmlText = null;

  }//end public function cleanData */

} // end class LibMessageMail

