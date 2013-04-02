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
class WgtPanelElementSearch_Overlay extends WgtPanelElement
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
  
  /**
   * @var SearchData
   */
  public $searchData = null;

/*//////////////////////////////////////////////////////////////////////////////
// constructor
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * when a table object is given, the panel is automatically injected in the
   * table object
   *
   * @param WgtTable $table
   */
  public function __construct($table = null)
  {

    if ($table) {
      $this->tableId    = $table->id;
      $this->searchForm = $table->searchForm;
    }

  }//end public function __construct */

  /**
   * @param WgtPanelElementFilter $filters
   */
  public function setFilter(WgtPanelElementFilter $filters)
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
  public function renderSearchArea($flagButtonText = false)
  {

    $i18n = $this->getI18n();
    
    $iconClose   = $this->icon('control/close_overlay.png', 'Close', 'small');

    $html         = '';
    $panelClass   = '';

    if ($this->searchKey) {

      $iconInfo     = $this->icon('control/info.png', 'Info');

      $buttonAdvanced = '';
      $customButtons  = '';

      //if ($this->advancedSearch)
      if (false) {

        $textAdvSearch = " {$i18n->l('Extended search','wbf.label')}";

        $buttonAdvanced = <<<HTML
      <li><a
        onclick="\$S('#wgt-search-{$this->context}-{$this->searchKey}-dcon').dropdown('close');\$S('#wgt-search-{$this->context}-{$this->searchKey}-advanced').toggle();\$UI.resetForm('{$this->searchForm}');return false;"
        class="wcm wcm_ui_docu_tip"
        wgt_doc_src="wgt-search-{$this->context}-{$this->searchKey}-control-ext_search-docu"
        wgt_doc_cnt="wgt-search-{$this->context}-{$this->searchKey}-control-docu_cont"
        >
				<i class="icon-filter" ></i> {$textAdvSearch}
      </a>
     </li>

HTML;
      }

      $textSearchUF = " {$i18n->l('Search &amp; Filter', 'wbf.label')}";
      $textSearch   = " {$i18n->l('Search', 'wbf.label')}";

      $setFocus = '';
      if ($this->focus)
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
            class="{$this->searchFieldSize} wcm wcm_req_search{$setFocus} wgt-no-save fparam-{$this->searchForm}" />
        </div>

        <button
            class="wcm wcm_ui_dropform wcm_ui_tip-top ui-state-default wgt-button"
            id="wgt-search-{$this->context}-{$this->searchKey}-con"
            title="Click to Change the Status"
          ><i class="icon-search" ></i> <i class="icon-angle-down" ></i><var>{"size":"big"}</var></button>
    
      	<div class="wgt-search-{$this->context}-{$this->searchKey}-con hidden" >

          <div>
      			<div
              class="wcm wcm_ui_tip-top wgt-panel title"
              tooltip="Nice and fancy search" >
              <h2>Search</h2>
              <div class="right" ><a class="wgtac_close_overlay" href="#close-search" >{$iconClose}</a></div>
            </div>
            
            <div class="wgt-space" style="height:150px;" >
            
              <div class="left half" >   
              	<h3>Filter</h3>
              </div>            
              
              <div class="half right" >
              	<h3>Custom Filter</h3>
              </div>

    				</div>
    				
            <div class="wgt-clear small wgt-border-bottom" >&nbsp;</div>
            
            <div class="wgt-space" >
            	<h3>Advanced search</h3>
            	
            	<div style="height:250px;" >
            	
            	</div>

    				</div>
    				
          </div>

        </div>
        
      </div>

HTML;

    }

    return $html;

  }//end public function renderSearchArea */

}//end class WgtPanelElementSearch_Splitted

