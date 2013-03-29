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
 * @subpackage Groupware
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class WebfrapMessage_Attachment_Modal_View extends WgtModal
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  
/*//////////////////////////////////////////////////////////////////////////////
// Methoden
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param TFlag $params
   * @return void
   */
  public function displayCreate( $params )
  {

    $this->setStatus('Upload Attachment');
    $this->setTitle('Upload Attachment');
    
    $this->addVar( 'msgId', $params->msgId );

    $this->setTemplate('webfrap/message/attachment/modal/create_form', true);

  }//end public function displayCreate */
  
  /**
   * @param TFlag $params
   * @return void
   */
  public function displayEdit( $params )
  {

    $this->setStatus('Upload Attachment');
    $this->setTitle('Upload Attachment');

    $this->setTemplate('webfrap/message/attachment/modal/edit_form', true);

  }//end public function displayEdit */

}//end class WebfrapMessage_Attachment_Modal_View

