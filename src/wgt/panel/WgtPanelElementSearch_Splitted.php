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
class WgtPanelElementSearch_Splitted extends WgtPanelElement
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
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

  /**
   * wenn true wird automatisch der focus auf das search field gelegt
   * @var string
   */
  public $focus = false;

  /**
   * Filterelement
   * @var WgtPanelElementFilter
   */
  public $filters = null;

  /**
   * Context des Filterelements
   * @var string
   */
  public $context = 'table';

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
    }

  }//end public function __construct */

  /**
   * @param WgtPanelElementFilter $filters
   */
  public function setFilter( WgtPanelElementFilter $filters )
  {

    $this->filters = $filters;

  }//end public function setFilter */

/*//////////////////////////////////////////////////////////////////////////////
// build method
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return string
   */
  public function render()
  {

    $this->setUp();

    $html = '';

    $html .= $this->renderSearchArea();

    return $html;

  }//end public function render */

/*//////////////////////////////////////////////////////////////////////////////
// panel methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param boolean $flagButtonText
   * @return string
   */
  public function renderSearchArea($flagButtonText = false )
  {

    $i18n = $this->getI18n();

    $html         = '';
    $panelClass   = '';

    if ($this->searchKey) {

      $iconReset    = $this->icon( 'control/reset.png', 'Reset' );
      $iconInfo     = $this->icon( 'control/info.png', 'Info' );

      $buttonAdvanced = '';
      $customButtons  = '';

      //if ($this->advancedSearch )
      if (false) {
        $iconAdvanced = $this->icon('control/show_advanced.png','Extended Search');

        $textAdvSearch = " {$i18n->l('Extended search','wbf.label')}";

        $buttonAdvanced = <<<HTML
      <li><a
        onclick="\$S('#wgt-search-{$this->context}-{$this->searchKey}-dcon').dropdown('close');\$S('#wgt-search-{$this->context}-{$this->searchKey}-advanced').toggle();\$UI.resetForm('{$this->searchForm}');return false;"
        class="wcm wcm_ui_docu_tip"
        wgt_doc_src="wgt-search-{$this->context}-{$this->searchKey}-control-ext_search-docu"
        wgt_doc_cnt="wgt-search-{$this->context}-{$this->searchKey}-control-docu_cont"
        >
        {$iconAdvanced} {$textAdvSearch}
      </a>
     </li>

HTML;
      }

      $textSearchUF = " {$i18n->l( 'Search &amp; Filter', 'wbf.label' )}";
      $textSearch   = " {$i18n->l( 'Search', 'wbf.label' )}";

      $setFocus = '';
      if ($this->focus )
        $setFocus = ' wcm_ui_focus';

      $htmlFilters = '';

      $codeFilter = '';
      if ($this->filters) {
        $htmlFilters = $this->filters->render();
        $codeFilter = "<span class=\"wcm wcm_ui_tip-top\" tooltip=\"numer of active filters / number of filters\" >"
          ."(<span id=\"wgt-search-{$this->context}-{$this->searchKey}-numfilter\" >{$this->filters->numFilterActive}</span>"
          ."/<span>{$this->filters->numFilter}</span>)</span>";

      }

      $html .= <<<HTML

      <div class="right" >

        <div class="left" >
          <strong>{$textSearchUF} {$codeFilter}</strong>
          <input
            type="text"
            name="free_search"
            style="margin-right:0px;"
            id="wgt-search-{$this->context}-{$this->searchKey}"
            class="{$this->searchFieldSize} wcm wcm_req_search{$setFocus} wgt-no-save fparam-{$this->searchForm}"
            wgt_drop_trigger="wgt-search-{$this->context}-{$this->searchKey}-dcon" />
        </div>

        <div
          id="wgt-search-{$this->context}-{$this->searchKey}-control"
          class="wcm wcm_control_split_button inline"  >

          <button
            onclick="\$S('#wgt-search-{$this->context}-{$this->searchKey}-dcon').dropdown('close');\$R.form('{$this->searchForm}',null,{search:true});return false;"
            title="Search"
            class="wgt-button splitted wcm wcm_ui_tip"
            tabindex="-1" >
            <i class="icon-search" ></i>
          </button><button
            class="wgt-button append ui-state-default"
            tabindex="-1"
            id="wgt-search-{$this->context}-{$this->searchKey}-dcon"
            wgt_drop_box="wgt-search-{$this->context}-{$this->searchKey}-dropbox" ><span class="ui-icon ui-icon-triangle-1-s" style="height:10px;" > </span></button>

        </div>

        <var id="wgt-search-{$this->context}-{$this->searchKey}-control-cfg-split"  >{"triggerEvent":"click","align":"right"}</var>
        <var id="wgt-search-{$this->context}-{$this->searchKey}-control-reset-docu" >Reset the search form</var>
        <var id="wgt-search-{$this->context}-{$this->searchKey}-control-ext_search-docu" >Open the advanced search</var>

      </div>

      <div
        class="wgt-dropdownbox"
        id="wgt-search-{$this->context}-{$this->searchKey}-dropbox"  >
        <ul>
          {$buttonAdvanced}
          <li><a
            onclick="\$S('#wgt-search-{$this->context}-{$this->searchKey}-dcon').dropdown('close');\$S('{$this->context}#{$this->tableId}-table').grid('cleanFilter');\$UI.resetForm('{$this->searchForm}');\$R.form('{$this->searchForm}');return false;"
            wgt_doc_src="wgt-search-{$this->context}-{$this->searchKey}-control-reset-docu"
            wgt_doc_cnt="wgt-search-{$this->context}-{$this->searchKey}-control-docu_cont"
            class="wcm wcm_ui_docu_tip" >
            {$iconReset} Reset search
          </a></li>
        </ul>
        {$htmlFilters}
        <ul>
          <li>
            <p id="wgt-search-{$this->context}-{$this->searchKey}-control-docu_cont" ></p>
          </li>
        </ul>
      </div>

HTML;

    }

    return $html;

  }//end public function renderSearchArea */

}//end class WgtPanelElementSearch_Splitted

