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
class WgtPanelListing extends WgtPanel
{
/*//////////////////////////////////////////////////////////////////////////////
//
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * the search key is used to prevent naming conflicts in the user backend
   * @var string
   */
  public $searchKey = null;

  /**
   * the paging form is used to interact with the listing element
   * @var string
   */
  public $searchForm = null;

  /**
   * flag if the advanced search button should be added to the panel
   * @var boolean
   */
  public $advancedSearch = null;

  /**
   * the html id of the table object
   * @var string
   */
  public $tableId = null;

  /**
   * the html id of the table object
   * @var string
   */
  public $searchFieldSize = 'large';

/*//////////////////////////////////////////////////////////////////////////////
// constructor
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * when a table object is given, the panel is automatically injected in the
   * table object
   *
   * @param WgtTable $table
   */
  public function __construct($table = null )
  {

    if ($table) {
      $this->tableId    = $table->id;
      $this->searchForm = $table->searchForm;
      $table->setPanel($this);
    }

  }//end public function __construct */

/*//////////////////////////////////////////////////////////////////////////////
// build method
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return string
   */
  public function build()
  {

    $html = '';

    $html .= $this->panelTitle();
    $html .= $this->panelMenu();
    $html .= $this->panelButtons();

    return $html;

  }//end public function build */

/*//////////////////////////////////////////////////////////////////////////////
// panel methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   */
  public function panelMenu()
  {

    $html = '';

    if ($this->searchKey) {
      $html .= '<div class="wgt-panel" >';

      $iconInfo     = $this->icon('control/info.png','Info');

      $buttonAdvanced = '';

      if ($this->advancedSearch) {
// Advanced Search
        $buttonAdvanced = <<<HTML
      <button
        onclick="\$S('#wgt-search-listing-{$this->searchKey}-advanced').toggle();\$UI.resetForm('{$this->searchForm}');return false;"
        class="wgt-button inline wcm wcm_ui_tip"
        tabindex="-1"
        title="Extend Search"
        >
        <i class="icon-filter" ></i>
      </button>

HTML;
      }

      $html .= <<<HTML

      <input
        type="text"
        name="free_search"
        id="wgt-search-listing-{$this->searchKey}"
        class="{$this->searchFieldSize} wcm wcm_req_search wgt-no-save fparam-{$this->searchForm}" />

      <button
        onclick="\$R.form('{$this->searchForm}',null,{search:true});return false;"
        class="wgt-button inline"
        tabindex="-1" >
        <i class="icon-search" ></i> Search
      </button>
{$buttonAdvanced}
      <button
        onclick="\$S('table#{$this->tableId}-listing').grid('cleanFilter');\$UI.resetForm('{$this->searchForm}');\$R.form('{$this->searchForm}');return false;"
        title="With this button, you can reset the search, and load the original table."
        class="wgt-button right"
        tabindex="-1" >
        <i class="icon-minus-sign"></i> Reset
      </button>

HTML;

      $html .= '</div>';
    }

    return $html;

  }//end public function panelMenu */

} // end class WgtPanelTable

