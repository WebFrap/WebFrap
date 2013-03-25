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
 */
class LibMessageRendererConsole extends LibTemplateHtml
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Type des Template objectes
   * @var string
   */
  public $type         = 'console';

/*//////////////////////////////////////////////////////////////////////////////
// getter + setter Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * build the page
   *
   * @param LibMessageStack $message
   * @param LibMessageReceiver $receiver
   * @param LibMessageSender $sender
   * @return string the assembled page
   */
  public function renderHtml($message, $receiver, $sender)
  {

    $CONTENT = null;

    if ($message->htmlDynContent) {
      if ($message->htmlMaster) {
        $masterTpl  = $message->htmlMaster;
        $CONTENT    = $message->htmlDynContent;
      } else {
        return $message->htmlDynContent;
      }
    } elseif ($message->htmlContent) {
      if ($message->htmlMaster) {
        $masterTpl  = $message->htmlMaster;
        $CONTENT    = $message->htmlContent;
      } else {
        return $message->htmlContent;
      }
    } elseif ($message->htmlMaster) {
      $masterTpl  = $message->htmlMaster;
      $TEMPLATE   = $message->htmlTemplate;
    } elseif ($message->htmlTemplate) {
      $masterTpl = $message->htmlTemplate;
      $TEMPLATE  = null;
    } else {
      throw new LibMessage_Exception('Message has no content');
    }

    if (!$filename = $this->templatePath($masterTpl, 'messages')) {
      throw new LibMessage_Exception('Template '.$masterTpl.' not exists ');
    }

    $VAR       = $this->var;
    $ELEMENT   = $this->object;
    $FUNC      = $this->funcs;

    $I18N      = $this->i18n;
    $USER      = $this->user;

    ob_start();
    include $filename;
    $content = ob_get_contents();
    ob_end_clean();

    return $content;

  } // end public function renderHtml */

  /**
   * build the page
   *
   * @param LibMessageStack $message
   * @param LibMessageReceiver $receiver
   * @param LibMessageSender $sender
   * @return string the assembled page
   */
  public function renderPlain($message, $receiver, $sender)
  {

    $CONTENT   = null;
    $TEMPLATE  = null;

    if ($message->plainDynContent) {
      if ($message->plainMaster) {
        $masterTpl  = $message->plainMaster;
        $CONTENT    = $message->plainDynContent;
      } else {
        return $message->plainDynContent;
      }
    } elseif ($message->plainContent) {
      if ($message->plainMaster) {
        $masterTpl  = $message->plainMaster;
        $CONTENT    = $message->plainContent;
      } else {
        return $message->plainContent;
      }
    } elseif ($message->plainMaster) {
      $masterTpl  = $message->plainMaster;
      $TEMPLATE   = $message->plainTemplate;
    } elseif ($message->plainTemplate) {
      $masterTpl = $message->plainTemplate;
      $TEMPLATE  = null;
    } else {
      throw new LibMessage_Exception('Message has no content');
    }

    if (!$filename = $this->templatePath($masterTpl, 'messages')) {
      throw new LibMessage_Exception('Template '.$masterTpl.' not exists ');
    }

    $VAR       = $this->var;
    $ELEMENT   = $this->object;
    $FUNC      = $this->funcs;

    $I18N      = $this->i18n;
    $USER      = $this->user;

    ob_start();
    include $filename;
    $content = ob_get_contents();
    ob_end_clean();

    return $content;

  } // end public function renderPlain */

  /**
   * @param string $key
   * @param string $image
   * @param string $path
   * @return string the assembled page
   */
  public function renderEmbeddedSrc($key, $image, $path)
  {
    return $path.'/'.$image;

  }//end public function renderEmbeddedSrc */

}//end class LibMessageRendererMail

