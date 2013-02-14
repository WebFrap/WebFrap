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
 * Basisklasse für Table Panels
 *
 * @package WebFrap
 * @subpackage tech_core
 */
class WgtPanelButtonLine_Dset extends WgtPanelButtonLine
{
/*//////////////////////////////////////////////////////////////////////////////
// build method
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var TArray
   */
  public $flags = null;



  /**
   * @var Base $env
   */
  public function __construct($env )
  {
    $this->env = $env;

    $this->flags = new TArray();

  }//end public function __construct */



  /**
   * @return string
   */
  public function render()
  {


    $this->dKey = 'project_project';

    $this->setUp();
    $html = '';

    if ($this->flags->comments )
    {
      $html .= $this->renderComment();
    }

    if ($this->flags->tags )
    {
      $html .= $this->renderTags();
    }

    if ($this->flags->attachments )
    {
      $html .= $this->renderAttachments();

    }

    if ($this->flags->messages )
    {
      $iconMessage = $this->icon( 'message/email.png', 'Messages' );

      $html .= <<<HTML
<button class="wgt-button" >{$iconMessage}</button>
HTML;

    }

    if ($this->flags->history )
    {
      $html .= $this->renderHistory();
    }

    return $html;

  }//end public function render */

  /**
   * @return
   */
  protected function renderHistory()
  {

    $iconHistory = $this->icon( 'control/history.png', 'History' );

    $html = <<<HTML
<button
  id="{$this->id}-history"
  class="wgt-button wcm wcm_ui_dropform wcm_ui_tip"
  tooltip="Show the action history for this dataset"
  tabindex="-1" >{$iconHistory}
  <var>{"url":"ajax.php?c=Webfrap.Protocol.overlayDset&amp;objid={$this->entity}&amp;dkey={$this->dKey}{$this->accessPath}","size":"big"}</var>
</button>
HTML;

    return $html;

  }//end protected function renderHistory */


  /**
   * @return
   */
  protected function renderTags()
  {

    $iconHistory = $this->icon( 'control/tag_blue.png', 'Tags' );

    $html = <<<HTML
<button
  id="{$this->id}-tags"
  class="wgt-button wcm wcm_ui_dropform wcm_ui_tip"
  tooltip="Show and edit the tags for this dataset"
  tabindex="-1" >{$iconHistory}
  <var>{"url":"ajax.php?c=Webfrap.Tag.overlayDset&amp;objid={$this->entity}{$this->accessPath}","size":"medium"}</var>
</button>
HTML;

    return $html;

  }//end protected function renderHistory */

  /**
   * @return
   */
  protected function renderComment()
  {

    $iconComment = $this->icon( 'control/comment.png', 'Comments' );

    $html = <<<HTML
<button
  id="{$this->id}-comments"
  class="wgt-button wcm wcm_ui_dropform wcm_ui_tip"
  tooltip="Show and edit the comments for this dataset"
  tabindex="-1" >{$iconComment}
  <var>{"url":"ajax.php?c=Webfrap.Comment.overlayDset&amp;objid={$this->entity}&amp;dkey={$this->dKey}{$this->accessPath}","size":"big"}</var>
</button>
HTML;

    return $html;

  }//end protected function renderComment */

  /**
   * @return
   */
  protected function renderAttachments()
  {

    $iconAttachment = $this->icon( 'control/attachments.png', 'Attachments' );

    $html = <<<HTML
<button
  id="{$this->id}-attachments"
  class="wgt-button wcm wcm_ui_dropform wcm_ui_tip"
  tooltip="Show and edit the attachments for this dataset"
  tabindex="-1" >{$iconAttachment}
  <var>{"url":"ajax.php?c=Webfrap.Attachment.overlayDset&amp;objid={$this->entity}&amp;dkey={$this->dKey}{$this->accessPath}","size":"big"}</var>
</button>
HTML;

    return $html;

  }//end protected function renderComment */

}//end class WgtPanelButtonLine


