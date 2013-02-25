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
class WgtElementSystemMessage extends WgtAbstract
{

  /**
   * @param TFlag $params
   * @return string
   */
  public function render($params = null)
  {

    if( !$this->data )
      return '';

    $id = $this->getId();

    $html = <<<HTML
<div
	id="{$id}"
	class="wgt-dashboard-message ui-state-warn wgt-border ui-corner-all" >
	<div
		class="head wgt-border-bottom"  >
		<div class="left" >
      <h3
        class="wcm wcm_ui_tip-top"
        tooltip="Created by {$this->data['creator']}"
      >{$this->data['title']} <span class="date" >[{$this->data['created']}]</span></h3>
    </div>
    
  	<div class="wgt-clear" >&nbsp;</div>
  </div>
  <div class="full content wgt-space" >{$this->data['content']}</div>
  <div class="wgt-clear" >&nbsp;</div>
</div>
<div class="wgt-clear" >&nbsp;</div>

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
  public function buildJsCode( )
  {

    return '';

    $id = $this->getId();

    $this->jsCode = <<<JCODE
\$S('#{$id} .wgac_remove').each(function(){
	\$S(this).bind( 'click', function(){
		var eid = \$S(this).attr('wgt_eid');
		\$R.del('ajax.php?c=Webfrap.Announcement.archiveEntry&objid='+eid,{'success':function(){
			\$S('#{$id}').html('').hide();
  	}});
	});
});

JCODE;


  }//end public function buildJsCode */

} // end class WgtElementSystemMessage

