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
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 *
 */
class WgtTreeMessage
  extends WgtTree
{
////////////////////////////////////////////////////////////////////////////////
// attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   *
   * @var int
   */
  public $width = 650;

////////////////////////////////////////////////////////////////////////////////
// methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @param array $entry
   */
  protected function buildTreeNode( $entry )
  {

    $title        = $entry['title'];
    $senderName   = $entry['sender_name'];
    $senderId     = $entry['sender_id'];
    $date         = $entry['date'];

    $html = <<<HTML
  <div style="width:{$this->width}px;" >
    <span class="date" >{$date}</span>
    <span class="title" >{$title}</span>
    <span class="name" >{$from}</span>
  </div>
HTML;

    return $html;

  }//end protected function buildTreeNode */

}//end class WgtTreeMessage
