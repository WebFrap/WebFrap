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
class WgtElementDesktopSearch
  extends WgtAbstract
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////
  
  /**
   * @var string
   */
  public $label = 'Search';

  /**
   * @var string
   */
  public $action = 'ajax.php?c=Webfrap.Search.search';
  
  /**
   * @var string
   */
  public $id = 'desktop_search';
  
////////////////////////////////////////////////////////////////////////////////
// Getter + Setter
////////////////////////////////////////////////////////////////////////////////

  /**
   * @param string $id
   */
  public function setId( $id )
  {
    $this->id = $id;
  }//end public function setId */
  
  /**
   * @return string
   */
  public function getId()
  {
    return $this->id;
  }//end public function getId */
  
////////////////////////////////////////////////////////////////////////////////
// Render Methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @return string
   */
  public function render( $params = null )
  {

    
    $id       = $this->getId();
    $formId   = "wgt_form-{$id}";
    $tableId  = "wgt_table-{$id}";
    
    $iconSearch = $this->icon( 'control/search.png', 'Search' );
    
    $html = <<<HTML
    
<form 
  action="{$this->action}&amp;element={$id}" 
  id="{$formId}"
  accept-charset="utf-8"
  method="get" ></form>

<div style="width:770px;" class="wgt-content_box wgt-widget wgt-space">
  <div class="head">
    <label>{$this->label}</label>
    <input type="text" id="wgt-input-{$id}-search_field" name="search" class="xlarge fparam-{$formId}"  /><button id="{$id}-control" class="wcm wcm_req_form wgt-button append" wgt_form="{$formId}" >{$iconSearch}</button>
    <div class="right">
      <button class="wgt-button ui-state-default controls hidden" style="display: none;"><span class="ui-icon ui-icon-gear"></span></button>
      <button class="wgt-button ui-state-default controls hidden" style="display: none;"><span class="ui-icon ui-icon-help"></span></button>
    </div>
  </div>
  <div class="content">
    <ul id="{$tableId}" class="nearly_full" >
      
    </ul>
  </div>
</div>

HTML;


    return $html;

  } // end public function render */
  
  /**
   * Das Search Result rendern
   * @param array $data
   * @return string
   */
  public function renderResult( $data )
  {
    
    $id       = $this->getId();
    $tableId  = "wgt_table-{$id}";
    
    
    $htmlEntry = '';
    
    foreach( $data as $pos => $entry )
    {
      
      $cPos = $pos +1;
      
      $htmlEntry .= <<<ENTRY

  <li>
    <a class="wcm wcm_req_ajax" href="maintab.php?c={$entry['mask']}.edit&amp;objid={$entry['vid']}" >{$cPos}) {$entry['name']} ({$entry['entity_label']})</a><br />
    <span>{$entry['title']}</span>
    <div>{$entry['description']}</div>
  </li>

ENTRY;

    }
    
    $html = <<<HTML
    
    <ul id="{$tableId}" class="wgt_search_list nearly_full"  >
{$htmlEntry}
    </ul>
    
HTML;
    
    return $html;
    
  }//end public function renderResult */

} // end class WgtElementNewsList


