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
 * @subpackage Core
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 * @licence BSD
 */
class WebfrapContactForm_User_Message extends LibMessageEnvelop
{
/*//////////////////////////////////////////////////////////////////////////////
// attributes
//////////////////////////////////////////////////////////////////////////////*/
    
  /**
   * Die Kannäle über welcher die Nachricht verschickt werden soll
   * @var array
   */
  public $channels = array( 'message', 'mail' );
  
  /**
   * Die Entity zu der die Nachricht in Relation steht
   * @var ProjectActivity_Entity
   */
  public $entity = null;
  
  /**
   * Pfad zum Master Template der Nachricht
   * @var string
   */
  public $htmlMaster = 'index_user_message';
  
  /**
   * Pfad zum Master Template der Nachricht
   * @var string
   */
  public $userContent = null;

/*//////////////////////////////////////////////////////////////////////////////
// Setter & Getter
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param ProjectActivity_Entity $entity
   */
  public function setEntity($entity )
  {
    
    $this->entity = $entity;
    
  }//end public function setEntity */

/*//////////////////////////////////////////////////////////////////////////////
// Logic
//////////////////////////////////////////////////////////////////////////////*/

  
  /**
   * Subject der Nachricht
   * @param LibMessageReceiver $receiver = null
   * @return string
   */
  public function getSubject($receiver = null, $sender = null )
  {

    return <<<SUBJECT
{$this->info->getAppName()}: {$this->subject}
SUBJECT;
    
  }//end public function getSubject */
  
  /**
   * Erstellen des Contents, soweit dynamisch nötig
   * 
   * @param LibMessageReceiver $receiver = null
   * @param LibMessageSender $sender = null
   * @return string
   */
  public function buildContent($receiver = null, $sender = null )
  {
    
    Debug::console( 'userContent', $this->userContent );
    
    $this->htmlDynContent = <<<HTML
    
{$this->userContent}
    
HTML;
    
    return $this->htmlDynContent;    

  }//end public function buildContent */
          
  /**
   * laden der Attachments für die Nachricht
   * @return void
   */
  public function loadAttachments()
  {
  

    
  }//end public function loadAttachments */
  
} // end class WebfrapContactForm_User_Message */

