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
class WgtPanelTable
  extends WgtPanel
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
   * 
   * @var array
   */
  public $menuButtons = array();
  
  /**
   * @var array
   */
  public $filterButtons = array();
 
  /**
   * @var WgtPanel
   */
  public $filterPanel = null;
  
  /**
   * @var boolean
   */
  public $focus = false;

/*//////////////////////////////////////////////////////////////////////////////
// constructor
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * when a table object is given, the panel is automatically injected in the
   * table object
   *
   * @param WgtTable $table
   */
  public function __construct( $table = null )
  {

    if( $table )
    {
      $this->tableId    = $table->id;
      $this->searchForm = $table->searchForm;
      
      // das access objekt der table mit übernehmen
      if( $table->access )
        $this->access = $table->access;
      
      $table->setPanel( $this );
    }

  }//end public function __construct */
  
/*//////////////////////////////////////////////////////////////////////////////
// getter & setter
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param  $panel
   */
  public function setFilterPanel( $panel )
  {
    $this->filterPanel = $panel;
  }//end public function setFilterPanel */

  
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

    //$html .= $this->panelTitle();
    $html .= $this->panelMenu();
    $html .= $this->panelButtons();

    if( $this->subPannel )
    {
      foreach( $this->subPannel as $subPanel )
      {
        if( is_string($subPanel) )
          $html .= $subPanel;
        else 
          $html .= $subPanel->render();
      }
    }
    
    return $html;

  }//end public function render */

  /**
   * @return string
   */
  public function build()
  {
    
    return $this->render();

  }//end public function build */
  
  /**
   * set up the panel data
   */
  public function setUp()
  {
    
  }//end public function setUp */

/*//////////////////////////////////////////////////////////////////////////////
// panel methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @lang de:
   *
   * Hinzufügen eines Buttons
   * First add, first display
   *
   * @param string $key
   * @param array $buttonData
   * {
   *   0 => int, Button Type @see Wgt:: ACTION Constantes
   *   1 => string, Label des Buttons
   *   2 => string, URL oder Javascript Code, je nach Button Type
   *   3 => string, Icon
   *   4 => string, css classes ( optional )
   *   5 => string, i18n key für das label ( optional )
   *   6 => int,  das benötigtes zugriffslevel @see Acl::$accessLevels
   *   7 => int,  maximales zugriffslevel @see Acl::$accessLevels
   * }
   *
   */
  public function addMenuButton( $key, $buttonData )
  {
    
    $this->menuButtons[$key] = $buttonData;
    
  }//end public function addMenuButton */
  
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
      
      if( $this->advancedSearch )
      {
        $iconAdvanced = $this->icon('control/show_advanced.png','Search Advanced');
        
        //{$i18n->l('Advanced Search','wbf.label')}
        
        $buttonAdvanced = <<<HTML
      <button
        onclick="\$S('#wgt-search-table-{$this->searchKey}-advanced').toggle();\$UI.resetForm('{$this->searchForm}');return false;"
        class="wgt-button inline wcm wcm_ui_tip"
        title="Extended search"
        >
        {$iconAdvanced} 
      </button>

HTML;
      }
      
      if( $this->menuButtons )
      {
        $customButtons = $this->buildButtons( $this->menuButtons );
      }

      $html .= <<<HTML
      
      {$customButtons}
      <div class="right" >
        <strong>Search</strong>
        <input 
          type="text" 
          name="free_search" 
          id="wgt-search-table-{$this->searchKey}" 
          class="{$this->searchFieldSize} wcm wcm_req_search wgt-no-save fparam-{$this->searchForm}" />
  
        <button 
          onclick="\$R.form('{$this->searchForm}',null,{search:true});return false;" 
          title="Search"
          class="wgt-button inline wcm wcm_ui_tip" >
          {$iconSearch}
        </button>
{$buttonAdvanced}
        <button 
          onclick="\$S('table#{$this->tableId}-table').grid('cleanFilter');\$UI.resetForm('{$this->searchForm}');\$R.form('{$this->searchForm}');return false;" 
          title="Reset" 
          class="wgt-button right wcm wcm_ui_tip" >
          {$iconReset}
        </button>

      </div>
  
HTML;
      
      //$html .= '<div class="wgt-clear xxsmall" >&nbsp;</div>';
      $html .= '</div>';
    }

    return $html;

  }//end public function panelMenu */

  /**
   * @return string
   */
  public function panelButtons()
  {

    $html = '';

    if( $this->buttons || $this->filterButtons )
    {
      $html .= '<div class="wgt-panel" >';
      
      if( $this->buttons )
      {
        $html .= '<div class="left" >';
        $html .= $this->buildButtons();
        $html .= '</div>';
      }
      
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
      
      $html .= '</div>';
    }

    return $html;

  }//end public function panelButtons */


} // end class WgtPanelTable


