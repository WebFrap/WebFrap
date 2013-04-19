<?php
/*******************************************************************************
*
* @author      : Malte Schirmacher <malte.schirmacher@webfrap.net>
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

if (!LibVendorEz::isLoaded ()) {
  LibVendorEz::load ();
}

/**
 * @package WebFrap
 * @subpackage Daidalos
 * @author Malte Schirmacher <malte.schirmacher@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class DaidalosMail_Ajax_View extends LibTemplateAjaxView
{
  /**
   *
   * @var LibMailConnector
   */
  private $imapConnection;

  private $parser;

  //////////////////////////////////////////////////////////////////////////////*/
  // Methoden
  //////////////////////////////////////////////////////////////////////////////*/

  public function __construct ()
  {
    $this->parser = new ezcMailParser ();
  }

  public function setConnection ($con)
  {
    $this->imapConnection = $con;
  }

  /**
   *
   * @param TFlag $params
   * @return void
   */
  public function displayMailbox ($params)
  {
    $mails = $this->imapConnection->getSlice(1, 10);

    $content = '<htmlArea selector="div#imap_mails>table>tbody" action="replace" ><![CDATA[<tbody>';

    foreach ($mails as $mail) {
      $link = sprintf ('href="ajax.php?c=Daidalos.Mail.displayMail&mid=%s" class="wcm wcm_req_ajax"', $mail->getMsgNumber());
      $content .= sprintf ('<tr><td>%s</td><td><a %s>%s</a></td><td>%s</td></tr>', $mail->getSender(), $link,
          $mail->getSubject(), $mail->getSize());
    }

    $content .= '</tbody>]]></htmlArea>';
    $this->setAreaContent ('childNode', $content);
  }

  /**
   *
   * @param int $msgNr
   * @return void
   */
  public function displayMail ($msgNr)
  {
    $content = '<htmlArea selector="div#imap_body>div" action="replace" ><![CDATA[<div>';

    $mail = $this->imapConnection->getMessageById ($msgNr);

    $content .= '<h1>html<h1>';
    foreach ($mail->getHtmlParts () as $htmlPart) {
      $content .= $htmlPart;
    }
    $content .= '<h1>text<h1>';
    foreach ($mail->getTextParts () as $textPart) {
      $content .= $textPart;
    }
    $content .= '<h1>-------<h1>';
    $content .= '</div>]]></htmlArea>';
    $this->setAreaContent ('childNode', $content);
  }
}//end class DaidalosBdlProject_Maintab_View

