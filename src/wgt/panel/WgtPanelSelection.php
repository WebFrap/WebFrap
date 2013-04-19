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
 * @subpackage tech_core
 */
class WgtPanelSelection extends WgtPanelTable
{

  /**
   *
   */
  public function panelMenu()
  {

    $i18n = $this->getI18n();

    $html = '';
    $panelClass = '';
    $title = '';

    if ($this->title) {
      $panelClass = ' title';
      $title = '<div class="left" style="width:40%"  ><h2 style="margin-bottom:0px;" >'.$this->title.'</h2></div>';
    }

    if ($this->searchKey) {
      $html .= '<div class="wgt-panel'.$panelClass.'" >';

      $html .= $title;

      $iconInfo     = $this->icon('control/info.png', 'Info');

      $buttonAdvanced = '';
      $customButtons  = '';

      if ($this->advancedSearch) {
// {$i18n->l('Advanced Search','wbf.label')}
        $buttonAdvanced = <<<HTML
      <button
        onclick="\$S('#wgt-search-selection-{$this->searchKey}-advanced').toggle();\$UI.resetForm('{$this->searchForm}');return false;"
        class="wgt-button inline wcm wcm_ui_tip"
        tabindex="-1"
        title="Extend Search"
        >
        <i class="icon-filter" ></i>
      </button>

HTML;
      }

      if ($this->menuButtons) {
        $customButtons = $this->buildButtons($this->menuButtons);
      }

      $html .= <<<HTML

      {$customButtons}
      <div class="right" >
        <strong>Search</strong>
        <input
          type="text"
          name="free_search"
          id="wgt-search-selection-{$this->searchKey}"
          class="{$this->searchFieldSize} wcm wcm_req_search wgt-no-save fparam-{$this->searchForm}" />

        <button
          onclick="\$R.form('{$this->searchForm}',null,{search:true});return false;"
          title="Search"
          class="wgt-button inline wcm wcm_ui_tip"
          tabindex="-1" >
          <i class="icon-search" ></i>
        </button>
{$buttonAdvanced}
        <button
          onclick="\$S('table#{$this->tableId}-selection').grid('cleanFilter');\$UI.resetForm('{$this->searchForm}');\$R.form('{$this->searchForm}');return false;"
          title="Reset"
          class="wgt-button right wcm wcm_ui_tip"
          tabindex="-1" >
          <i class="icon-minus-sign"></i>
        </button>
      </div>

HTML;

      //$html .= '<div class="wgt-clear xxsmall" >&nbsp;</div>';
      $html .= '</div>';
    }

    return $html;

  }//end public function panelMenu */

} // end class WgtPanelSelection

