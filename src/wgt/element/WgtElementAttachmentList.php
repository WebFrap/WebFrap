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
 * @subpackage Wgt
 */
class WgtElementAttachmentList
  extends WgtAbstract
{
////////////////////////////////////////////////////////////////////////////////
// Constanes
////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////
  
  /**
   * @var string
   */
  public $label = 'Attachments';
  
  /**
   * @var string
   */
  public $urlSearch = 'ajax.php?c=Webfrap.Attachment.search';

  /**
   * @var string
   */
  public $urlDelete = 'ajax.php?c=Webfrap.Attachment.delete';

  /**
   * @var string
   */
  public $urlEdit = 'modal.php?c=Webfrap.Attachment.edit';
  
  /**
   * @var string
   */
  public $urlStorageSearch = 'ajax.php?c=Webfrap.Attachment.searchStorage';

  /**
   * @var string
   */
  public $urlStorageDelete = 'ajax.php?c=Webfrap.Attachment.deleteStorage';

  /**
   * @var string
   */
  public $urlStorageEdit = 'modal.php?c=Webfrap.Attachment.editStorage';
  
  /**
   * Die ID des Datensatzes der getaggt werden soll
   * @var int
   */
  public $refId = null;
  
  /**
   * Die Maske in der die acls embeded wurden
   * @var string
   */
  public $refMask = null;
  
  /**
   * Die Maske in der die acls embeded wurden
   * @var string
   */
  public $refField = null;
  
  /**
   * @var string
   */
  public $idKey = null;
  
  /**
   * @var WgtMenuBuilder
   */
  public $menuBuilder = null;
  
  /**
   * @var array
   */
  public $icons = array();

  
  /**
   * @var array
   */
  public $dataStorage = array();

  /**
   * Wenn vorhanden wird der type über diese maske gefiltert
   * @var string
   */
  public $maskFilter = null;
  
  /**
   * Definiert eine absolute liste von filtertypen
   * @var string
   */
  public $typeFilter = null;

  /**
   * Steuerflags zum customizen des elements
   * - attachments  bool: support für attachements
   * -- a_create bool: neue attachments erstellen
   * -- a_update bool: vorhandene attachments ändern
   * -- a_delete bool: attachments löschen
   * - files
   * -- f_create bool: neue files erstellen
   * -- f_update bool: vorhandene files ändern
   * -- f_delete bool: files löschen
   * - links
   * -- l_create bool: neue links erstellen
   * -- l_update bool: vorhandene links ändern
   * -- l_delete bool: links löschen
   * -- l_storage bool: storage support
   * - storage  bool: support für storages
   * -- s_create bool: neue storages erstellen
   * -- s_update bool: vorhandene storages ändern
   * -- s_delete bool: storages löschen
   * @var TArray
   */
  public $flags = null;
  
  /**
   * Standard url extension
   * @var string
   */
  protected $defUrl = '';
  
  /**
   * Standard url extension
   * @var string
   */
  protected $defAction = '';
  
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * default constructor
   *
   * @param int $name the name of the wgt object
   * @param LibTemplate $view
   * @param array $flags
   */
  public function __construct( $name = null, $view = null, $flags = array() )
  {

    $this->texts  = new TArray();
    $this->flags  = new TArray( $flags ); // here we use flags

    $this->name   = $name;
    $this->init();

    if( $view )
      $view->addElement( $name, $this );
      
    // setup der icons
    $this->icons['link']   = $this->icon( 'control/attachment_link.png', 'Link' );
    $this->icons['file']   = $this->icon( 'control/attachment_file.png', 'File' );
    $this->icons['delete'] = $this->icon( 'control/delete.png', 'Delete' );
    
    
    $this->icons['level_public'] = $this->icon
    ( 
    	'confidentiality/public.png', 
    	'Public',
      'xsmall',
      array( 'class' => 'wcm wcm_ui_tip', 'tooltip'=>"Confidentiality Level Public" )
    );
    $this->icons['level_customer'] = $this->icon
    ( 
    	'confidentiality/customer.png', 
    	'Customer',
      'xsmall',
      array( 'class' => 'wcm wcm_ui_tip', 'tooltip'=>"Public" ) 
     );
    $this->icons['level_restricted'] = $this->icon
    ( 
    	'confidentiality/restricted.png', 
    	'Restricted',
      'xsmall',
      array( 'class' => 'wcm wcm_ui_tip', 'tooltip'=>"Restricted" ) 
     );
    $this->icons['level_confidential'] = $this->icon
    ( 
    	'confidentiality/confidential.png', 
    	'Confidential',
      'xsmall',
      array( 'class' => 'wcm wcm_ui_tip', 'tooltip'=>"Confidential" ) 
     );
    $this->icons['level_secret'] = $this->icon
    ( 
    	'confidentiality/secret.png', 
    	'Secret',
      'xsmall',
      array( 'class' => 'wcm wcm_ui_tip', 'tooltip'=>"Secret" )  
     );
    $this->icons['level_top_secret'] = $this->icon
    ( 
    	'confidentiality/top_secret.png', 
    	'Top Secret',
      'xsmall',
      array( 'class' => 'wcm wcm_ui_tip', 'tooltip'=>"Top Secret" ) 
     );


  }//end public function __construct */
  
////////////////////////////////////////////////////////////////////////////////
// Getter & Setter
////////////////////////////////////////////////////////////////////////////////

  /**
   * @return string
   */
  public function getIdKey()
  {
    
    if( is_null( $this->idKey ) )
      $this->idKey = Webfrap::uniqKey();
      
    return $this->idKey;
    
  }//end public function getIdKey */
  
  /**
   * (non-PHPdoc)
   * @see WgtAbstract::setId()
   */
  public function setId( $id )
  {
    $this->idKey = $id;
  }//end public function setId */
  
  /**
   * @param array $dataStorage
   */
  public function setStorageData( array $dataStorage )
  {
    $this->dataStorage = $dataStorage;
  }//end public function setStorageData */
  
////////////////////////////////////////////////////////////////////////////////
// Render Logic
////////////////////////////////////////////////////////////////////////////////

  /**
   * 
   */
  public function preRenderUrl()
  {
    
    $idKey    = $this->getIdKey();

    $this->defUrl = "&amp;refid={$this->refId}&amp;element={$idKey}";
    $this->defAction = "&refid={$this->refId}&element={$idKey}";
    
    if( $this->refMask )
    {
      $this->defUrl .= '&amp;ref_mask='.$this->refMask;
      $this->defAction .= '&ref_mask='.$this->refMask;
    }
    
    if( $this->refField )
    {
      $this->defUrl .= '&amp;ref_field='.$this->refField;
      $this->defAction .= '&ref_field='.$this->refField;
    }
    
  }//end public function preRenderUrl */
  
  /**
   * @param TFlag $params
   * @return string
   */
  public function render( $params = null )
  {
    
    if( $this->html )
      return $this->html;

    if( !$this->defUrl )
      $this->preRenderUrl();
      
    $idKey    = $this->getIdKey();
    $iconAddLink  = $this->icon( 'control/add.png', 'Add Link' );
    $iconAddFile  = $this->icon( 'control/add.png', 'Add File' );
    $iconAddRepo  = $this->icon( 'control/add.png', 'Add Storage' );
    $iconSearch   = $this->icon( 'control/search.png', 'Search' );
    $iconInfo   = $this->icon( 'control/info.png', 'Info' );

    $paramMaskFilter = '';
    
    if( $this->maskFilter )
    {
       $paramMaskFilter = '&amp;mask_filter='.$this->maskFilter;
    }
    else if( $this->typeFilter )
    {
      $paramMaskFilter = '&amp;type_filter[]='.implode( '&amp;type_filter[]=', $this->typeFilter  );
    }
    
    $htmlAttachmentTab = $this->renderAttachmentTab( $idKey, $paramMaskFilter );
    $htmlRepoTab = $this->renderRepoTab( $idKey );
    
    $codeButtonsAttach = '';
    $codeButtonsStorage = '';
    
    if( !($this->access && !$this->access->update ) && false !== $this->flags->a_create )
    {
      
      $codeButtonsAttach = <<<HTML
        <button 
        	onclick="\$R.get('modal.php?c=Webfrap.Attachment.formAddLink{$this->defUrl}{$paramMaskFilter}');" 
        	class="wgtac-add_link wgt-button"
      		tabindex="-1" >{$iconAddLink} Add Link</button> 
        <button 
        	onclick="\$R.get('modal.php?c=Webfrap.Attachment.formUploadFiles{$this->defUrl}{$paramMaskFilter}');"
      		tabindex="-1" 
        	class="wgtac-add_file wgt-button" >{$iconAddFile} Add File</button>
HTML;
      
      $codeButtonsStorage = <<<HTML
        <button 
        	onclick="\$R.get('modal.php?c=Webfrap.Attachment.formAddStorage{$this->defUrl}');" 
        	class="wgtac-add_repo wgt-button"
      		tabindex="-1" >{$iconAddRepo} Add Storage</button> 
HTML;


    }
    


    $html = <<<HTML

<div 
  class="wgt-content_box wgt-attchment_list" 
  id="wgt-attachment-{$idKey}" 
  style="width:850px;height:590px;" >

  <div class="head" style="width:840px;"  >
    <table border="0" cellspacing="0" cellpadding="0" width="100%" >
      <tr>
        <td width="480px;" ><h2>{$this->label}</h2></td>
        <td width="320px;" class="search" align="right" >
        	<input 
        		type="text"
        		name="skey"
        		class="fparam-wgt-form-attachment-{$idKey}-search large" /><button 
        		onclick="\$R.form('wgt-form-attachment-{$idKey}-search');" 
        		class="wgt-button append"
      			tabindex="-1" >{$iconSearch}</button>
        </td>
      </tr>
    </table>
  </div>
  
  <!-- Das Panel mit den Control Elementen und dem Tab Head -->
  <div class="wgt-panel" >
  	<div class="left" >
  		<div class="wgt-tab-attachment-{$idKey}-content box-files" >
{$codeButtonsAttach}
        <button
            class="wcm wcm_ui_dropform wcm_ui_tip-top wgt-button ui-state-default"
      			tabindex="-1" 
            id="wgt-tab-attachment-{$idKey}-help"
            tooltip="How to deal with nonworking links?"
          >Links not working? {$iconInfo}</button>
          
        <div class="wgt-tab-attachment-{$idKey}-help hidden" >
         	
        	<div class="wgt-space" >
        		
        		<p>
        		If you click on a link and you get an error page from the browser, the link is either wrong
        		or the targeted file was deleted / moved.
        		</p>
        		<p>
          		In some browsers like Firefox it could happen, that you click on a link and nothing happens
          		at all.<br />
              This is <strong>NOT a bug!</strong> Browsers have <strong>security restrictions</strong> 
              which prevent the browser from open local file links or links to file shares.
            </p>
            <p>
            To open the file just <strong>copy the Link</strong> in a <strong>new Tab</strong> of your browser, 
            or your <strong>file explorer</strong>.
            </p>
            
					</div>

    		</div>
    		
      </div>
      <div class="wgt-tab-attachment-{$idKey}-content box-repos" style="display:none;" >
{$codeButtonsStorage}
      </div>
   	</div>
   	<div 
   		class="wcm wcm_ui_tab_head wgt-tab-head ar right" 
   		id="wgt-tab-attachment-{$idKey}-head"
   		style="width:250px;border:0px;"
   		wgt_body="wgt-tab-attachment-{$idKey}-content" >
   		<div 
   			class="tab_head" >
     		<a wgt_key="files" class="tab wgt-corner-top" >Files</a>
     		<a wgt_key="repos" class="tab wgt-corner-top" >Storages</a>
   		</div>
   	</div>
  </div>
  
  <div id="wgt-tab-attachment-{$idKey}-content" class="wgt-content-box" style="height:530px;"  >
  	{$htmlAttachmentTab}
		{$htmlRepoTab}
  </div><!-- end tab Container -->
  
</div><!-- end widget -->

HTML;


    return $html;

  }// end public function render */
  
  /**
   * @param string $idKey
   * @return string
   */
  protected function renderAttachmentTab( $idKey, $paramMaskFilter )
  {
    
    /**
     * attach_id
     * file_id,
     * file_name,
     * file_link,
     * file_size,
     * mimetype,
     * description,
     * file_type,
     * firstname,
     * lastname,
     * user_name,
     * user_id
     */
    $codeEntr = '';
    
    $counter = 1;
    
    if( $this->data )
    {
      foreach( $this->data as $entry )
      {

        $codeEntr .= $this->renderAjaxEntry( $this->idKey, $entry, $paramMaskFilter, $counter );
        ++$counter;

      }
    }

    
    $dataSize = count( $this->data );
    
    $html = <<<HTML
    <div class="container" wgt_key="files" id="wgt-tab-attachment-{$idKey}-content-files" >
  
      <div class="content" style="height:530px;" >
      
        <form 
          method="get" 
          action="{$this->urlSearch}{$this->defUrl}{$paramMaskFilter}" 
          id="wgt-form-attachment-{$idKey}-search" ></form>
    
        <div id="wgt-grid-attachment-{$idKey}" class="wgt-grid" >
        
          <var id="wgt-grid-attachment-{$idKey}-cfg-grid" >{
          "height":"large",
          "search_form":"wgt-form-attachment-{$idKey}-search",
          "search_able":"true"}</var>
        
          <table 
            id="wgt-grid-attachment-{$idKey}-table" 
            class="wgt-grid wcm wcm_widget_grid hide-head" >
          
            <thead>
              <tr>
                <th class="pos" style="width:30px"  >&nbsp;</th>
                <th style="width:50px" >T/C</th>
                <th 
                  style="width:270px" 
                  wgt_sort_name="file[name]" 
                  wgt_sort="asc" 
                  wgt_search="input:file[name]"  >Name</th>
                <th 
                  style="width:100px" 
                  wgt_sort_name="file[id_type]" 
                  wgt_search="input:file[id_type]" >File Type</th>
                <th 
                  style="width:100px" 
                  wgt_sort_name="file[size]" >Size</th>
                <th 
                  style="width:120px" 
                  wgt_sort_name="file[owner]" 
                  wgt_search="input:file[owner]" >Owner</th>
                <th 
                  style="width:120px" 
                  wgt_sort_name="file[created]" >Created</th>
                <th 
                  style="width:50px;">Nav.</th>
              </tr>
            </thead>
            
            <tbody>
              {$codeEntr}
            </tbody>
    
          </table>
        
          <div class="wgt-panel wgt-border-top" >
            <div 
              class="right menu"  ><span>found <strong class="wgt-num-entry" >{$dataSize}</strong> Entries</span> </div> 
          </div>
          
        </div><!-- end grid -->
        
      </div><!-- end content -->
      
    </div><!-- end tab files -->

HTML;

    return $html;
    
  }//end protected function renderRepoTab */

  

  /**
   * @param string $elemId
   * @param array $entry
   * @param int $counter
   * @return string
   */
  public function renderAjaxEntry( $elemId, $entry, $paramMaskFilter, $counter = null )
  {

    $fileSize    = '';

    if( '' != trim( $entry['file_name'] ) )
    {
      
      $fileIcon = $this->icons['file'];
      $fileName = trim( $entry['file_name'] );
      $fileSize = SFormatNumber::formatFileSize( $entry['file_size'] );
      $b64Name     = base64_encode($fileName);
      
      $link = "<a href=\"file.php?f=wbfsys_file-name-{$entry['file_id']}&amp;n={$b64Name}\" target=\"wgt_dms\" rel=\"nofollow\" >{$fileName}</a>";

    }
    else 
    {
      $storageLink = 'file:\\\\\\'.trim( $entry['storage_link'] ) ;
      
      $lastChar = substr($storageLink, -1) ;
      
      if( $lastChar != '\\' && $lastChar != '/' )
        $storageLink .= '\\';
      
      $fileIcon = $this->icons['link'];
      $fileName = str_replace('\\\\', '\\', trim( $entry['file_link'] )) ;
      
      // FUCK YOU BASTARD IE NOOBS DIE!!!! DIIIEEEEEE! DIIIIIIEEEEEEE!!!!!!! FUCKERS!
      $firstChar = substr($fileName, 0, 1) ;
      
      if( $firstChar == '\\' )
        $fileName = substr($fileName,1 ) ;
      
      //$fileName = str_replace('//', '/', $fileName) ;
      
      $link = "<a href=\"{$storageLink}{$fileName}\" target=\"wgt_dms\" rel=\"nofollow\" >{$storageLink}{$fileName}</a>";
      
    }
    
    $timeCreated  = date( 'Y-m-d - H:i',  strtotime($entry['time_created'])  );
    $menuCode     = $this->renderRowMenu( $entry );
    
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

    if( !($this->access && !$this->access->update ) && false !== $this->flags->a_update )
    {

      $codeEntr = <<<HTML

    <tr 
    	class="wcm wcm_control_access_dataset {$rowClass} node-{$entry['attach_id']}" 
    	id="wgt-grid-attachment-{$elemId}_row_{$entry['attach_id']}"
    	wgt_url="{$this->urlEdit}{$this->defUrl}&amp;objid={$entry['attach_id']}{$paramMaskFilter}" >
HTML;

    }
    else
    {

      $codeEntr = <<<HTML

    <tr 
    	class="{$rowClass} node-{$entry['attach_id']}" 
    	id="wgt-grid-attachment-{$elemId}_row_{$entry['attach_id']}" >
HTML;

    }
    
    
    $codeEntr .= <<<HTML

      <td class="pos" >{$counter}</td>
      <td>{$fileIcon} {$confidentialIcon}</td>
      <td>{$link}</td>
      <td>{$entry['file_type']}</td>
      <td>{$fileSize}</td>
      <td><span 
        class="wcm wcm_control_contact_user" 
        wgt_eid="{$entry['user_id']}"
        title="{$entry['lastname']}, {$entry['firstname']}" >{$entry['user_name']}</span></td>
      <td class="no_oflw" >{$timeCreated}</td>
      <td class="nav" >{$menuCode}</td>
    </tr>
        
HTML;

    return $codeEntr;
    
  }//end public function renderAjaxEntry */
  
  /**
   * @param string $elementId
   * @param array $data
   * @return string
   */
  public function renderAjaxBody( $elementId, $data )
  {
    
    if( $this->html )
      return $this->html;

    $counter = 1;
    
    $html = '';
    
    $paramMaskFilter = '';
    
    if( $this->maskFilter )
    {
       $paramMaskFilter = '&amp;mask_filter='.$this->maskFilter;
    }
    else if( $this->typeFilter )
    {
      $paramMaskFilter = '&amp;type_filter[]='.implode( '&amp;type_filter[]=', $this->typeFilter  );
    }
    
    if( $this->data )
    {
      foreach( $this->data as $entry )
      {

        $html .= $this->renderAjaxEntry( $this->idKey, $entry, $paramMaskFilter, $counter );
        ++$counter;

      }
    }
    
    $this->html = $html;


    return $html;

  }// end public function renderAjaxBody */

  /**
   * @param array $entry
   * @return string
   */
  public function renderRowMenu( $entry )
  {
    
    if( $this->access && !$this->access->update )
      return '';
    
    $html = <<<CODE
	<button 
		onclick="\$R.del('{$this->urlDelete}{$this->defAction}&objid={$entry['attach_id']}',{confirm:'Confirm to delete.'});" 
		class="wgt-button"
    tabindex="-1" >{$this->icons['delete']}</button>
CODE;

    return $html;
    
    
  }//end public function renderRowMenu */
  
  
////////////////////////////////////////////////////////////////////////////////
// title
////////////////////////////////////////////////////////////////////////////////
  
  /**
   * @param string $idKey
   * @return string
   */
  protected function renderRepoTab( $idKey )
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
    
    if( $this->dataStorage )
    {
      foreach( $this->dataStorage as $entry )
      {
        $codeEntr .= $this->renderAjaxStorageEntry( $this->idKey, $entry, $counter );
        ++$counter;
      }
    }
    
    $dataSize = count( $this->dataStorage );
    
    $code = <<<HTML
    <div class="container" wgt_key="files" id="wgt-tab-attachment-{$idKey}-content-repos" >

      <div class="content" style="height:530px;" >
      
        <form 
          method="get" 
          action="{$this->urlStorageSearch}{$this->defUrl}" 
          id="wgt-form-attachment-{$idKey}-search" />
    
        <div id="wgt-grid-attachment-{$idKey}" class="wgt-grid" >
        
          <var id="wgt-grid-attachment-{$idKey}-storage-cfg-grid" >{
          "height":"large",
          "search_form":"wgt-form-attachment-{$idKey}-storage-search",
          "search_able":"true"}</var>
        
          <table id="wgt-grid-attachment-{$idKey}-storage-table" class="wgt-grid wcm wcm_widget_grid hide-head" >
          
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
    
  }//end protected function renderRepoTab */
  
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
    	id="wgt-grid-attachment-{$elemId}-storage_row_{$entry['storage_id']}"
    	wgt_url="{$this->urlStorageEdit}{$this->defUrl}&amp;objid={$entry['storage_id']}" >
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
    
    if( $this->access && !$this->access->update )
      return '';
    
    $html = <<<CODE
	<button 
		onclick="\$R.del('{$this->urlStorageDelete}{$this->defAction}&objid={$entry['storage_id']}',{confirm:'Confirm to delete.'});" 
		class="wgt-button"
    tabindex="-1" >{$this->icons['delete']}</button>
CODE;

    return $html;
    
    
  }//end public function renderRowMenuStorage */

} // end class WgtElementAttachmentList


