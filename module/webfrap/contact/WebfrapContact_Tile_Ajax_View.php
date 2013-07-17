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
 * @subpackage webfrap/groupware
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class WebfrapContact_Tile_Ajax_View extends LibTemplateAjaxView
{
/*//////////////////////////////////////////////////////////////////////////////
// display methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param Context $params
   * @param boolean $insert
   */
  public function displayEntry( $params, $entry, $insert = true )
  {

    $tpl = $this->getTplEngine();

    $pageFragment = new WgtAjaxArea();

    if ($insert) {
      $pageFragment->selector = '#wgt-tiles-contact';
      $pageFragment->action = 'prepend';
    } else {
      $pageFragment->selector = '#wgt-tiles-contact-tile-';
      $pageFragment->action = 'replace';
    }

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


  }//end public function displayEntry */


  /**
   * @param int $delId
   */
  public function displayDelete($delId)
  {

    $tpl = $this->getTplEngine();

    $tpl->addJsCode( <<<JSCODE
	\$S('#wgt-tiles-contact-tile-{$delId}').remove();
JSCODE
    );

  }//end public function displayDelete */

} // end class WebfrapContact_Tile_Ajax_View */

