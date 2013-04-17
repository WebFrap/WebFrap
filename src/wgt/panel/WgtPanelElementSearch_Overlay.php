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
   * Service mit dem eine aktuelle Filter / Suchkonfiguration gespeichert werden kann
   * @var string
   */
  public $saveService = 'ajax.php?c=Webfrap.Settings_Search.save';

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
  public $searchFields = null;

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
  
  /**
   * @param string|array $fields
   * @param boolean $isJson
   */
  public function setSearchFields( $fields, $isJson = false )
  {

    if ($isJson)
      $this->searchFields = json_decode($fields);
    else
      $this->searchFields = $fields;
      
  }//end public function setSearchFields */

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
      
      $selectboxFields = $this->renderAdvancedSearchFieldsSelectbox();
  
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

        <button class="wgt-button splitted wgtac_search" ><i class="icon-search" ></i></button><button
            class="wcm wcm_ui_dropform ui-state-default wgt-button append"
            id="wgt-search-{$this->context}-{$this->searchKey}-con"
            title="Open the extended search"
          ><i class="icon-angle-down" ></i><var>{"size":"big"}</var></button>
    
      	<div class="wgt-search-{$this->context}-{$this->searchKey}-con hidden" >

          <div>
      			<div
              class="wcm wcm_ui_tip-top wgt-panel title"
              tooltip="Nice and fancy search" >
              <h2>Search</h2>
              <div class="right" ><a class="wgtac_close_overlay" href="#close-search" >{$iconClose}</a></div>
            </div>
            
            <div class="wgt-space" style="min-height:150px;max-height:250px;" >
            
              <div class="left half" >   
              	<h3>Filter</h3>
{$htmlFilters}
              	<div class="wgt-clear" ></div>
              </div>            
              
              <div class="half right" >
              	<h3 style="width:150px;float:left;" >Custom Filter</h3>

              	<div class="wgt-clear" >&nbsp;</div>
              	
              	<ul class="wgt-tree" >
              		<li>
              			<button class="wgt-button" ><i class="icon-filter" ></i> Urgent</button> 
              			| <button class="wgt-button" ><i class="icon-remove" ></i></button>
              		</li>
              		<li><button class="wgt-button ui-state-active" ><i class="icon-filter" ></i> Send by Joe</button> 
              			| <button class="wgt-button" ><i class="icon-remove" ></i></button>
              		</li>
              		<li><button class="wgt-button" ><i class="icon-filter" ></i> Project X 2012</button>
              			| <button class="wgt-button" ><i class="icon-remove" ></i></button>
              		</li>
              	</ul>
              </div>

    				</div>
    				
            <div class="wgt-clear small wgt-border-bottom" >&nbsp;</div>
            
            <div id="wgt-box-extsrch-{$this->context}-{$this->searchKey}" class="wcm wcm_ui_search_builder wgt-space" style="height:300px;" >
            	<var id="wgt-box-extsrch-{$this->context}-{$this->searchKey}-cfg-sb" >
							{"dkey":"{$this->context}-{$this->searchKey}","search_form":"{$this->searchForm}","save_service":"{$this->saveService}"}
            	</var>
            	
            	<div class="wgt-panel" >
            	  <div class="left bw15" >
            	    <h3>Extended search</h3>
            	  </div>
            	  <div class="inline bw25" >
            	    <label>Filter Name:</label> <input 
            	      type="text" 
            	      name="filter_name" 
            	      class="filter_name asgd-{$this->searchForm}" 
            	      value="Send by Joe" /><button 
            	        class="wgt-button append wa_reset_filter" ><i class="icon-trash" ></i></button>
            	  </div>
              	<div class="right" >
              		<button class="wgt-button wa_save_filter" ><i class="icon-save" ></i> Save filter</button>
              	</div>
            	</div>
            	
          		<div style="max-height:250px;">
        				<table class="search-container" >
            			<thead>
            				<tr>
            					<th style="width:100px;">And/Or</th>
            					<th style="width:120px;">Field</th>
            					<th style="width:40px;">Not</th>
                      <th style="width:40px;">Cs</th>
            					<th style="width:120px;">Condition</th>
            					<th style="width:150px;">Value</th>
            					<th style="width:75px;">Menu</th>
            				</tr>
            			</thead>
                  <tbody>
                  
            			</tbody>
                </table>
            	</div>
            	
    				
      				<div class="wgt-clear small" >&nbsp;</div>
  
            	<div class="left" >{$selectboxFields}</div>
              <div class="inline">&nbsp;&nbsp; <button class="wa_add_line wgt-button" ><i class="icon-plus-sign"></i></button></div>
            
              <div class="wgt-clear small">&nbsp;</div>

    				</div>

            	
    				
          </div>
          
          <div class="wgt-clear small wgt-border-bottom" >&nbsp;</div>
          <div class="wgt-clear tiny" >&nbsp;</div>
          
          <div class="full wgt-space" style="text-align:right" >
          	<button class="wgt button wgtac_search" ><i class="icon-search" ></i> Search</button>
          </div>

        </div> <!-- end dropdown -->
        
      </div><!-- end panel right ->

HTML;

    }

    return $html;

  }//end public function renderSearchArea */
  
  
  /**
   * @return string
   */
  protected function renderAdvancedSearchFieldsSelectbox()
  {
    
    $select = '<select class="wd-fields wcm wcm_widget_selectbox" >';
    
    // first free
    $select .= '<option></option>';
    
    foreach ( $this->searchFields as $category => $catFields ) {
      
      $select .= '<optgroup label="'.$category.'">';
      
      foreach ( $catFields as $catKey => $catData ) {
        $select .= '<option value="'.$catKey.'" type="'.strtolower($catData[1]).'" >'.$catData[0].'</option>';
      }
      
      $select .= '</optgroup>';
    }
    
    $select .= '</select>';
    
    return $select;
    
  }//end protected function renderAdvancedSearchFieldsSelectbox */

}//end class WgtPanelElementSearch_Splitted

