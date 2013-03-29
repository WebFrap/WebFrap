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
 * @subpackage Groupware
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class WebfrapMessage_Attachment_Ajax_View extends LibTemplateAjaxView
{
/*//////////////////////////////////////////////////////////////////////////////
// display methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param Context $params
   */
  public function displayInsert( $params )
  {

    $tpl = $this->getTplEngine();

    $pageFragment = new WgtAjaxArea();
    $pageFragment->selector = '#wgt-list-show-msg-attach-'.$params->msgId;
    $pageFragment->action = 'prepend';
    
    $encName = base64_encode($this->model->file->name);

    $pageFragment->setContent(<<<HTML
  <li id="wgt-entry-msg-attach-{$this->model->attachment->getId()}" ><a 
      target="attach"
      href="file.php?f=wbfsys_file-name-{$this->model->file->getId()}&n={$encName}" 
      >{$this->model->file->name}</a><a 
      class="wcm wcm_req_del" 
      title="Please confirm you want to delete this Attachment"
      href="ajax.php?c=Webfrap.Message_Attachment.delete&delid={$this->model->attachment->getId()}"  ><i class="icon-remove" ></i></a></li>
HTML
    );

    $tpl->setArea('attachment', $pageFragment);


  }//end public function displayInsert */
  
  /**
   * @param Context $params
   */
  public function displayUpdate($params)
  {

    $tpl = $this->getTplEngine();

    $pageFragment = new WgtAjaxArea();
    $pageFragment->selector = 'wgt-entry-msg-attach-'.$this->model->attachment->getId();
    $pageFragment->action = 'replace';
    
    $encName = base64_encode($this->model->file->name);

    $pageFragment->setContent(<<<HTML
  <li id="wgt-entry-msg-attach-{$this->model->attachment->getId()}" ><a 
      target="attach"
      href="file.php?f=wbfsys_file-name-{$this->model->file->getId()}&n={$encName}" 
      >{$this->model->file->name}</a><a 
      class="wcm wcm_req_del" 
      title="Please confirm you want to delete this Attachment"
      href="ajax.php?c=Webfrap.Message_Attachment.delete&delid={$this->model->attachment->getId()}"  ><i class="icon-remove" ></i></a></li>
HTML
    );

    $tpl->setArea('attachment', $pageFragment);

  }//end public function displayUpdate */
  
  /**
   * @param int $delId
   */
  public function displayDelete($delId)
  {

    $tpl = $this->getTplEngine();
    
    $tpl->addJsCode( <<<JSCODE
	\$S('#wgt-entry-msg-attach-{$delId}').remove();
JSCODE
    );
 
  }//end public function displayDelete */

} // end class WebfrapMessage_Attachment_Ajax_View */

