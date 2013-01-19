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
class WgtPanelButtonLine_Dset
  extends WgtPanelButtonLine
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
  public function __construct( $env )
  {
    $this->env = $env;

    $this->flags = new TArray();

  }//end public function __construct */



  /**
   * @return string
   */
  public function render()
  {

    $this->setUp();
    $html = '';

    if( $this->flags->comments )
    {
      $iconComment = $this->icon( 'control/comment.png', 'Comment' );

      $html .= <<<HTML
<button class="wgt-button" >{$iconComment}</button>
HTML;


    }

    if( $this->flags->tags )
    {
      $iconTag = $this->icon( 'control/tab_blue.png', 'Tags' );

      $html .= <<<HTML
<button class="wgt-button" >{$iconTag}</button>
HTML;


    }

    if( $this->flags->attachments )
    {
      $iconAttachment = $this->icon( 'control/attachments.png', 'Attachment' );

      $html .= <<<HTML
<button class="wgt-button" >{$iconAttachment}</button>
HTML;


    }

    if( $this->flags->messages )
    {
      $iconMessage = $this->icon( 'message/email.png', 'Messages' );

      $html .= <<<HTML
<button class="wgt-button" >{$iconMessage}</button>
HTML;


    }

    if( $this->flags->history )
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
  class="wgt-button wcm wcm_ui_dropform"
  tabindex="-1" >{$iconHistory}
  <var>{"url":"ajax.php?c=Webfrap.History.embed&amp;objid={$this->entity}&amp;dkey={$this->dkey}{$this->accessPath}"}</var>
</button>

HTML;

    return $html;

  }//end protected function renderHistory */


}//end class WgtPanelButtonLine


