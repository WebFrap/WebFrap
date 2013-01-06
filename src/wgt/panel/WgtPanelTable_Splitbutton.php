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
class WgtPanelTable_Splitbutton
  extends WgtPanelTable
{
/*//////////////////////////////////////////////////////////////////////////////
// panel methodes
//////////////////////////////////////////////////////////////////////////////*/


  /**
   *
   */
  public function panelMenu( )
  {

    $i18n = $this->getI18n();

    $html = '';
    $panelClass = '';
    $title = '';

    if( $this->title )
    {
      $panelClass = ' title';
      $title = '<div class="left" style="width:40%"  ><h2 style="margin-bottom:0px;" >'.$this->title.'</h2></div>';
    }


    if( $this->searchKey )
    {
      $html .= '<div class="wgt-panel'.$panelClass.'" >';

      $html .= $title;

      $iconSearch   = $this->icon( 'control/search.png', 'Search' );
      $iconReset    = $this->icon( 'control/reset.png', 'Reset' );
      $iconInfo     = $this->icon( 'control/info.png', 'Info' );

      $buttonAdvanced = '';
      $customButtons  = '';

      //if( $this->advancedSearch )
      if( false )
      {
        $iconAdvanced = $this->icon('control/show_advanced.png','Search Advanced');

        //{$i18n->l('Advanced Search','wbf.label')}

        $buttonAdvanced = <<<HTML
      <li><button
        onclick="\$S('#wgt-search-table-{$this->searchKey}-advanced').toggle();\$UI.resetForm('{$this->searchForm}');return false;"
        class="wgt-button inline wcm wcm_ui_tip"
        tabindex="-1"
        title="Extended search"
        >
        {$iconAdvanced}
      </button>
      </li>

HTML;
      }


      $textSearchUF = " {$i18n->l( 'Search &amp; Filter', 'wbf.label' )}";
      $textSearch   = " {$i18n->l( 'Search', 'wbf.label' )}";

      $setFocus = '';
      if( $this->focus )
        $setFocus = ' wcm_ui_focus';

      $htmlFilters = '';
      if( $this->filterButtons )
        $htmlFilters .= $this->buildButtons( $this->filterButtons );

      $codeFilter = '';

      if( $this->filterPanel )
      {
        $htmlFilters .= $this->filterPanel->render(  );
        $codeFilter = "<span class=\"wcm wcm_ui_tip-top\" tooltip=\"numer of active filters / number of filters\" >(<span id=\"wgt-search-table-{$this->searchKey}-numfilter\" >{$this->filterPanel->numFilterActive}</span>/<span>{$this->filterPanel->numFilter}</span>)</span>";
      }

      $html .= <<<HTML

      <div class="right" >

        <div class="left" >
          <strong>{$textSearchUF} {$codeFilter}</strong>
          <input
            type="text"
            name="free_search"
            style="margin-right:0px;"
            id="wgt-search-table-{$this->searchKey}"
            class="{$this->searchFieldSize} wcm wcm_req_search{$setFocus} wgt-no-save fparam-{$this->searchForm}"
            wgt_drop_trigger="wgt-search-table-{$this->searchKey}-dcon" />
         </div>

        <div
          id="wgt-search-table-{$this->searchKey}-control"
          class="wcm wcm_control_split_button inline"  >

          <button
            onclick="\$S('#wgt-search-table-{$this->searchKey}-dcon').dropdown('close');\$R.form('{$this->searchForm}',null,{search:true});return false;"
            title="Search"
            class="wgt-button splitted wcm wcm_ui_tip"
            tabindex="-1" >
            {$iconSearch}
          </button><button
            class="wgt-button append ui-state-default"
            tabindex="-1"
            id="wgt-search-table-{$this->searchKey}-dcon"
            wgt_drop_box="wgt-search-table-{$this->searchKey}-dropbox" ><span class="ui-icon ui-icon-triangle-1-s" style="height:10px;" > </span></button>

        </div>

        <var id="wgt-search-table-{$this->searchKey}-control-cfg-split"  >{"triggerEvent":"click","align":"right"}</var>
        <var id="wgt-search-table-{$this->searchKey}-control-reset-docu" >Reset the search form</var>
        <var id="wgt-search-table-{$this->searchKey}-control-ext_search-docu" >Open the advanced search</var>

      </div>

      <div class="wgt-dropdownbox" id="wgt-search-table-{$this->searchKey}-dropbox"  >
        <ul>
          {$buttonAdvanced}
          <li><a
            onclick="\$S('#wgt-search-table-{$this->searchKey}-dcon').dropdown('close');\$S('table#{$this->tableId}-table').grid('cleanFilter');\$UI.resetForm('{$this->searchForm}');\$R.form('{$this->searchForm}');return false;"
            wgt_doc_src="wgt-search-table-{$this->searchKey}-control-reset-docu"
            wgt_doc_cnt="wgt-search-table-{$this->searchKey}-control-docu_cont"
            class="wcm wcm_ui_docu_tip" >
            {$iconReset} Reset search
          </a></li>
        </ul>
        {$htmlFilters}
        <ul>
          <li>
            <p id="wgt-search-table-{$this->searchKey}-control-docu_cont" ></p>
          </li>
        </ul>
    	</div><!-- end wgt-dropdownbox -->

	  </div><!-- end wgt-panel -->

HTML;

    }
    elseif( $this->title )
    {

      $iconInfo     = $this->icon( 'control/info.png', 'Info' );

      $html .= '<div class="wgt-panel'.$panelClass.'" >';
      $html .= $title;

     if( $this->buttons )
      {
        $html .= '<div class="right" >';
        $html .= $this->buildButtons();
        $html .= '</div>';
      }

      $html .= <<<HTML

    </div>

HTML;

    }

    return $html;

  }//end public function panelMenu */

  /**
   * @return string
   */
  public function panelButtons()
  {


    if( !$this->searchKey )
      return '';

    $html = '';

    if( $this->buttons )
    {
      $html .= '<div class="wgt-panel" >';

      if( $this->buttons )
      {
        $html .= '<div class="left" >';
        $html .= $this->buildButtons();
        $html .= '</div>';
      }

      /*
      if( $this->filterButtons )
      {
        $html .= '<div class="right" ><div class="left" ><strong>Filters&nbsp;|&nbsp;</strong></div>';
        $html .= $this->buildButtons( $this->filterButtons );
        $html .= '</div>';
      }

      if( $this->filterPanel )
      {
        $html .= $this->filterPanel->render(  );
      }
      */

      $html .= '</div>';
    }

    return $html;

  }//end public function panelButtons */


} // end class WgtPanelTable_Splitbutton


