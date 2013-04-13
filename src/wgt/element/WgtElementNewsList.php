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
   * @param TFlag $params
   * @return string
   */
  public function render($params = null)
  {

    $id = $this->getId();

    $importance = array
    (
      10 => array('Min',  'wgt-prio-min', $this->icon('priority/min.png', 'min')),
      20 => array('Low',  'wgt-prio-low', $this->icon('priority/low.png', 'low')),
      30 => array('Normal',  'wgt-prio-normal', $this->icon('priority/normal.png', 'normal')),
      40 => array('High',  'wgt-prio-high', $this->icon('priority/high.png', 'high')),
      50 => array('Max',  'wgt-prio-max', $this->icon('priority/max.png', 'max')),
    );

    $codeEntr = '';

    /**
     * title:
     * content:
     */
    foreach ($this->data as $entry) {

      if (!$entry['importance'])
        $entry['importance'] = 30;

      $codeEntr .= <<<HTML

  <li id="{$id}-entry-{$entry['rowid']}" class="entry wgt-border wgt-space" >
  	<div class="head {$importance[$entry['importance']][1]} wgt-border-bottom ui-corner-all"  >
  		<div class="left" >
        <h3
          class="wcm wcm_ui_tip-top"
          tooltip="With Priority {$importance[$entry['importance']][0]}, by {$entry['creator']}"
        >{$entry['title']} <span class="date" >[{$entry['created']}]</span></h3>
      </div>
      <div class="right" style="padding:3px;" >
				<button
					class="wgt-button wgac_remove"
					wgt_eid="{$entry['rowid']}" ><i class="icon-remove" ></i></button>
      </div>
    	<div class="wgt-clear" >&nbsp;</div>
    </div>
    <div class="full content wgt-space" >{$entry['content']}</div>
    <div class="wgt-clear" >&nbsp;</div>
  </li>

HTML;

    }

    $html = <<<HTML

<ul id="{$id}" class="wgt-news-list" >
{$codeEntr}
</ul>

HTML;

    return $html;

  } // end public function render */


  /**
   * Methode zum bauen des Javascript codes für das UI Element.
   *
   * Dieser kann / soll in die aktuelle view injected werden
   *
   * @return string
   */
  public function buildJsCode()
  {

    $id = $this->getId();

    $this->jsCode = <<<JCODE
\$S('#{$id} .wgac_remove').each(function() {
	\$S(this).bind('click', function() {
		var eid = \$S(this).attr('wgt_eid');
		\$R.del('ajax.php?c=Webfrap.Announcement.archiveEntry&objid='+eid,{'success':function() {
			\$S('#{$id}-entry-'+eid).remove();
  	}});
	});
});

JCODE;


  }//end public function buildJsCode */

} // end class WgtElementNewsList

