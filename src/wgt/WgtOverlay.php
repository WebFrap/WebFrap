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
 * @subpackage wgt
 */
class WgtOverlay
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  public $id = null;

  public $content = null;

  public $tooltip = null;

  public $icon = null;

  public $label = null;

  /**
   * Render des Javascripts
   * @param WgtMaintab $view
   * @param WgtDropmenu $menu
   */
  public function render($view, $showLabel = true, $menu = null )
  {

    $icon = '';
    if ($this->icon )
      $icon = $view->icon($this->icon, $this->label );

    $label = '';
    if ($this->label && $showLabel )
      $label = $this->label;

    $html = <<<HTML

    <button
        class="wcm wcm_ui_dropform wcm_ui_tip-top wgt-button ui-state-default"
        tabindex="-1"
        id="{$this->id}"
        tooltip="{$this->tooltip}"
      >{$icon}{$label}</button>

    <div class="{$this->id} hidden" >
      {$this->content}
    </div>

HTML;

    return $html;

  }//end public function renderActions */


} // end class WgtControlOverlay


