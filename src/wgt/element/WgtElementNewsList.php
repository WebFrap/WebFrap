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
class WgtElementNewsList extends WgtAbstract
{

  /**
   * @return string
   */
  public function render($params = null )
  {

    $importance = array
    (
      10 => array( 'Min',  '#DDE4EA', $this->icon('priority/min.png', 'min') ),
      20 => array( 'Low',  '#D3F0E7', $this->icon('priority/low.png', 'low') ),
      30 => array( 'Normal',  '#CBE4C8', $this->icon('priority/normal.png', 'normal') ),
      40 => array( 'High',  '#FFB2AD', $this->icon('priority/high.png', 'high') ),
      50 => array( 'Max',  '#FFD3F9', $this->icon('priority/max.png', 'max') ),
    );

    $codeEntr = '';

    /**
     * title:
     * content:
     */
    foreach ($this->data as $entry) {

      if (!$entry['importance'] )
        $entry['importance'] = 30;

      $codeEntr .= <<<HTML

  <li class="entry" >
    <h3
      class="wcm wcm_ui_tip-top"
      style="background-color:{$importance[$entry['importance']][1]};"
      tooltip="With Priority {$importance[$entry['importance']][0]}, by {$entry['creator']}" >{$entry['title']} <span class="date" >[{$entry['created']}]</span></h3>
    <div class="content" >{$entry['content']}</div>
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

} // end class WgtElementNewsList

