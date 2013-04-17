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
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 * @package WebFrap
 * @subpackage core/data/consistency
 */
class WebfrapSyncSystem_Mail_Action extends Action
{

  /**
   * Löschen aller möglicherweise vorhandenen vid links
   *
   * @param LibDbConnection $db
   * @param int $id
   */
  public function sync()
  {

    $mailConf = $this->getConf()->getResource('mail');

    if (!$mailConf || !isset($mailConf['connections']['default'])) {
      return;
    }

    $mailConnector = new LibConnector_Message_Ez( $mailConf['connections']['default'] );
    $mailConnector->open();

    $numMessages = $mailConnector->getNumMessages();

    for ( $pos = 1; $numMessages <= $pos; $pos += 10 ) {

      $messages = $mailConnector->getRange($pos,10);

      $msgIds   = array();

      foreach ($messages as /* @var $message ezcMail */ $message) {

        $msgIds[] = $message->messageId;
      }

    }


  }//end public function sync */


} // end class WebfrapSyncSystem_Mail_Action

