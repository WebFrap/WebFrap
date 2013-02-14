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
class WgtElementContactItemList extends WgtElement
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/
  
  /**
   * @var string
   */
  public $label = 'Contact Item';
  
  /**
   * @var array
   */
  public $urls = array
  (
    'item_delete' => 'ajax.php?c=Webfrap.Mediathek_Image.delete',
    'item_edit'   => 'modal.php?c=Webfrap.Mediathek_Image.edit',
    'item_add'    => 'modal.php?c=Webfrap.Mediathek_Image.add',

    'address_delete' => 'ajax.php?c=Webfrap.Mediathek_Audio.delete',
    'address_edit'   => 'modal.php?c=Webfrap.Mediathek_Audio.edit',
    'address_add'    => 'modal.php?c=Webfrap.Mediathek_Audio.add',
  );

  
  /**
   * @var array
   */
  public $addressData = array();
  
  /**
   * @var array
   */
  public $typeData = array();

/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * default constructor
   *
   * @param int $name the name of the wgt object
   */
  public function __construct( $name = null, $view = null )
  {

    $this->texts  = new TArray();

    $this->name   = $name;
    $this->init();

    if( $view )
      $view->addElement( $name, $this );
      
    // setup der icons
    $this->icons['delete'] = $this->icon( 'control/delete.png', 'Delete' );
    
    
    $this->icons['use_contact'] = $this->icon( 'control/use_for_contact.png', 'Use for Contact' );
    $this->icons['not_use_contact'] = $this->icon( 'control/use_not_for_contact.png', 'Don\'t use for Contact' );
    
    $this->icons['private'] = $this->icon( 'control/private.png', 'Private' );
    $this->icons['public'] = $this->icon( 'control/public.png', 'Public' );

  }//end public function __construct */
  
/*//////////////////////////////////////////////////////////////////////////////
// Getter & Setter
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param array $addressData
   */
  public function setAddressData( array $addressData )
  {
    $this->addressData = $addressData;
  }//end public function setAddressData */
  
/*//////////////////////////////////////////////////////////////////////////////
// Render Logic
//////////////////////////////////////////////////////////////////////////////*/
  
  /**
   * @param TFlag $params
   * @return string
   */
  public function render( $params = null )
  {
    
    if( $this->html )
      return $this->html;

    $idKey    = $this->getIdKey();

    $htmlItemTab =  $this->renderItemTab( $idKey );
    //$htmlRepoTab       = $this->renderAddressTab( $idKey );
    
    
    $html = <<<HTML

<div 
  class="wgt-content_box wgt-contact_item" 
  id="wgt-contact_item-{$idKey}" 
  style="width:850px;height:490px;" >
  
  <div class="head" style="width:840px;"  >
    <table border="0" cellspacing="0" cellpadding="0" width="100%" >
      <tr>
        <td width="480px;" ><h2>{$this->label}</h2>
        	<div></div>
        </td>
        <td width="320px;" align="right" >
        	<div 
           		class="wcm wcm_ui_tab_head wgt-tab-head ar right trans" 
           		id="wgt-tab-contact_item-{$idKey}-head"
           		style="width:250px;border:0px;"
           		wgt_body="wgt-tab-contact_item-{$idKey}-content" >
         		<div class="tab_head" >
           		<a wgt_key="item" class="tab wgt-corner-top" >Item</a>
           		<a wgt_key="address" class="tab wgt-corner-top" >Address</a>
         		</div>
         	</div>
        </td>
      </tr>
    </table>
  </div>
  
  <div id="wgt-tab-contact_item-{$idKey}-content" class="wgt-content-box" style="height:430px;"  >
  	{$htmlItemTab}
  </div><!-- end tab Container -->
  
</div><!-- end widget -->

HTML;


    return $html;

  }// end public function render */
  
  /**
   * @param string $idKey
   * @return string
   */
  protected function renderItemTab( $idKey )
  {
    
    $codeEntr = '';
    
    $counter = 1;
    
    if( $this->data )
    {
      foreach( $this->data as $entry )
      {

        $codeEntr .= $this->renderItemAjaxEntry( $this->idKey, $entry, $counter );
        ++$counter;

      }
    }
    
    $dataSize = count( $this->data );
    
    $html = <<<HTML
    <div class="container" wgt_key="files" id="wgt-tab-contact_item-{$idKey}-content-item" >
  
    <div class="wgt-panel" >
    	<button>Save</button>
    	<button>Add</button>
    </div>
    
      <div class="content" style="height:430px;" >

        <div id="wgt-grid-contact_item-{$idKey}" class="wgt-grid" >
        
          <var id="wgt-grid-contact_item-{$idKey}-cfg-grid" >{
          	"height":"medium"}</var>
        
          <table 
          	id="wgt-grid-contact_item-{$idKey}-table" 
          	class="wgt-grid wcm wcm_widget_grid hide-head" >
          
            <thead>
              <tr>
                <th class="pos" style="width:30px" >&nbsp;</th>
                <th style="width:60px" >T/P</th>
                <th 
                  style="width:150px"  >Name</th>
                <th 
                  style="width:270px" >Value</th>
                <th 
                  style="width:270px"  >Comment</th>
                <th 
                  style="width:50px;">Nav.</th>
              </tr>
            </thead>
            
            <tbody>
              {$codeEntr}
            </tbody>
    
          </table>

        </div><!-- end grid -->
        
      </div><!-- end content -->
      
    </div><!-- end tab files -->

HTML;

    return $html;
    
  }//end protected function renderAddressTab */

  

  /**
   * @param string $elemId
   * @param array $entry
   * @param int $counter
   * @return string
   */
  public function renderItemAjaxEntry( $elemId, $entry, $counter = null )
  {

    $menuCode     = $this->renderItemRowMenu( $entry );
    
    if( $counter )
    {
      $rowClass = 'row_'.($counter%2);
    } else {
      $rowClass = 'row_1';
      $counter  = 1;
    }

    /*
 			item_id,
			item_address_value,
  		item_name,
 			item_use_for_contact,
  		item_description,
  		item_flag_private,
  
  		type_id,
  		type_name,
  		type_access_key
     */

    if( $entry['item_use_for_contact'] )
    {
      $iconContact = $this->icons['use_contact'];
    } else {
      $iconContact = $this->icons['not_use_contact'];
    }
    
    if( $entry['item_flag_private'] )
    {
      $iconPrivate = $this->icons['private'];
    } else {
      $iconPrivate = $this->icons['public'];
    }
    
    $iconType = $this->renderItemTypeSelector( $entry );

    $codeEntr = <<<HTML

    <tr 
    	class="{$rowClass} node-{$entry['item_id']}" 
    	id="wgt-grid-contact_item-{$elemId}_row_{$entry['item_id']}" >
      <td class="pos" >{$counter}</td>
      <td>{$iconContact}&nbsp;{$iconPrivate}&nbsp;{$iconType}</td>
      <td>{$entry['item_name']}</td>
      <td>{$entry['item_address_value']}</td>
      <td>{$entry['item_description']}</td>
      <td class="nav" >{$menuCode}</td>
    </tr>
        
HTML;

    return $codeEntr;
    
  }//end public function renderItemAjaxEntry */
  
  /**
   * @param string $elementId
   * @param array $data
   * @return string
   */
  public function renderItemAjaxBody( $elementId, $data )
  {
    
    if( $this->html )
      return $this->html;

    $counter = 1;
    
    $html = '';
    
    if( $this->data )
    {
      foreach( $this->data as $entry )
      {

        $html .= $this->renderItemAjaxEntry( $this->idKey, $entry, $counter );
        ++$counter;

      }
    }
    
    $this->html = $html;


    return $html;

  }// end public function renderItemAjaxBody */

  /**
   * @param array $entry
   * @return string
   */
  public function renderItemRowMenu( $entry )
  {
    
    $html = <<<CODE
	<button 
		onclick="\$R.del('{$this->urls['item_delete']}&refid={$this->refId}&element={$this->idKey}&objid={$entry['item_id']}');" 
		class="wgt-button"
    tabindex="-1" >{$this->icons['delete']}</button>
CODE;

    return $html;
    
    
  }//end public function renderItemRowMenu */
  
  
  /**
   * @param array $entry
   * @return string
   */
  public function renderItemTypeSelector( $entry )
  {
    
    $menuId = 'wgt-contact_item-'.$this->idKey.'-typeselect-'.$entry['item_id'];
    
    $html = '<span id="'.$menuId.'" >';
    $html .= '<span 
    	class="wcm wcm_control_dropmenu" 
    	id="'.$menuId.'-cntrl" 
    	style="width:65px;" 
    	wgt_drop_box="'.$menuId.'-menu" ><img src="'.$this->iconUrl($entry['type_icon']).'" alt="'.$entry['type_name'].'" /></span></div>
  <div class="wgt-dropdownbox" id="'.$menuId.'-menu" >
    <ul>'.NL;
      
    foreach( $this->typeData as $data  )
    {
      $active = '';
      if( $data['type_id'] == $entry['type_id'] )
        $active = ' class="wgt-active" ';
      
      $html .= '<li'.$active.'><a><img src="'.$this->iconUrl($data['type_icon']).'" alt="'.$data['type_name'].'" /> '.$data['type_name'].'</a></li>';
    }
    
    $html .= '</ul></span>';
    
    $html .= '<var id="'.$menuId.'-cntrl-cfg-dropmenu"  >{"closeOnLeave":"true","align":"left"}</var>';

    return $html;
    
  }//end public function renderItemTypeSelector */
  

  
/*//////////////////////////////////////////////////////////////////////////////
// title
//////////////////////////////////////////////////////////////////////////////*/
  
  /**
   * @param string $idKey
   * @return string
   */
  protected function renderAddressTab( $idKey )
  {
    
    /**
  	 * storage_id,
     * storage_name,
     * storage_link,
     * storage_description,
	   * type_name
     */
    $codeEntr = '';
    
    $counter = 1;
    
    if( $this->addressData )
    {
      foreach( $this->addressData as $entry )
      {
        $codeEntr .= $this->renderAjaxStorageEntry( $this->idKey, $entry, $counter );
        ++$counter;
      }
    }
    
    $dataSize = count( $this->addressData );
    
    $code = <<<HTML
    <div class="container" wgt_key="files" id="wgt-tab-contact_item-{$idKey}-content-repos" >

      <div class="content" style="height:430px;" >
      
        <form 
          method="get" 
          action="{$this->urlStorageSearch}&amp;refid={$this->refId}&amp;element={$this->idKey}" 
          id="wgt-form-contact_item-{$idKey}-search" />
    
        <div id="wgt-grid-contact_item-{$idKey}" class="wgt-grid" >
        
          <var id="wgt-grid-contact_item-{$idKey}-storage-cfg-grid" >{
          "height":"large",
          "search_form":"wgt-form-contact_item-{$idKey}-storage-search",
          "search_able":"true"}</var>
        
          <table id="wgt-grid-contact_item-{$idKey}-storage-table" class="wgt-grid wcm wcm_widget_grid hide-head" >
          
            <thead>
              <tr>
                <th class="pos" style="width:30px"  >&nbsp;</th>
                <th style="width:30px" >C</th>
                <th 
                  style="width:120px" 
                  wgt_sort_name="storage[name]" 
                  wgt_sort="asc" 
                  wgt_search="input:storage[name]"  >Name</th>
                <th 
                  style="width:270px" 
                  wgt_sort_name="storage[link]" 
                  wgt_sort="asc" 
                  wgt_search="input:storage[link]"  >Address</th>
                <th 
                  style="width:100px" 
                  wgt_sort_name="storage[id_type]" 
                  wgt_search="input:storage[id_type]" >Type</th>
                <th 
                  style="width:250px" 
                  >Description</th>
                <th 
                  style="width:50px;">Nav.</th>
              </tr>
            </thead>
            
            <tbody>
              {$codeEntr}
            </tbody>
    
          </table>
        
          <div class="wgt-panel wgt-border-top" >
            <div class="right menu"  ><span>found <strong class="wgt-num-entry" >{$dataSize}</strong> Entries</span> </div> 
          </div>
          
        </div><!-- end grid -->
        
      </div><!-- end content -->
    
    </div><!-- end tab repos -->
HTML;

    return $code;
    
  }//end protected function renderAddressTab */
  
  /**
   * @param string $elemId
   * @param array $entry
   * @param int $counter
   * @return string
   */
  public function renderAjaxStorageEntry( $elemId, $entry, $counter = null )
  {


    $menuCode     = $this->renderRowStorageMenu( $entry );
    
    if( $counter )
      $rowClass = 'row_'.($counter%2);
    else 
    {
      $rowClass = 'row_1';
      $counter = 1;
    }
    
    $confidentialIcon = '';
    
    if( $entry['confidential_level'] )
    {
      $confidentialIcon = isset($this->icons['level_'.$entry['confidential_level']])
        ? $this->icons['level_'.$entry['confidential_level']]
        : '';
    }

    $codeEntr = <<<HTML

    <tr 
    	class="wcm wcm_control_access_dataset {$rowClass} node-{$entry['storage_id']}" 
    	id="wgt-grid-contact_item-{$elemId}-storage_row_{$entry['storage_id']}"
    	wgt_url="{$this->urlStorageEdit}&amp;element={$elemId}&amp;objid={$entry['storage_id']}" >
      <td class="pos" >{$counter}</td>
      <td>{$confidentialIcon}</td>
      <td>{$entry['storage_name']}</td>
      <td>{$entry['storage_link']}</td>
      <td>{$entry['type_name']}</td>
      <td class="no_oflw" >{$entry['storage_description']}</td>
      <td class="nav" >{$menuCode}</td>
    </tr>
        
HTML;

    return $codeEntr;
    
  }//end public function renderAjaxStorageEntry */
  
  /**
   * @param array $entry
   * @return string
   */
  public function renderRowStorageMenu( $entry )
  {
    
    $html = <<<CODE
	<button 
		onclick="\$R.del('{$this->urlStorageDelete}&element={$this->idKey}&objid={$entry['storage_id']}');" 
		class="wgt-button"
		tabindex="-1" >{$this->icons['delete']}</button>
CODE;

    return $html;
    
    
  }//end public function renderRowStorageMenu */

} // end class WgtElementContactItemList


