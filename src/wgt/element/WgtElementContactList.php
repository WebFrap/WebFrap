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
 * Item zum generieren einer Linkliste
 * @package WebFrap
 * @subpackage tech_core
 */
class WgtElementContactList extends WgtAbstract
{

  /**
   * @return string
   */
  public function render($params = null)
  {

    $codeEntr = '';

    /**
     * title:
     * content:
     */
    foreach ($this->data as $entry) {

      $codeEntr .= <<<HTML

  <li class="entry" >
    <h3>{$entry['title']} <span class="date" >[{$entry['created']}]</span></h3>
    <div>{$entry['content']}</div>
  </li>

HTML;

    }

    $id = $this->getId();

    $html = <<<HTML

<ul id="{$id}" class="wgt-news-list" >
{$codeEntr}
</ul>

HTML;

    return $html;

  } // end public function render */

} // end class WgtElementContactList

