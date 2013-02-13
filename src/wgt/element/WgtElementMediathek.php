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
class WgtElementMediathek
  extends WgtAbstract
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/
  
  /**
   * Das Label für das UI Element der Mediathek
   * @var string
   */
  public $label = 'Mediathek';
  
  /**
   * Die ID der Mediathek
   * @var int
   */
  public $mediaId = null;
  
  /**
   * Die ID der Mediathek
   * @var int
   */
  public $mediaNode = null;
  
  /**
   * @var string
   */
  public $idKey = null;
  
  /**
   * @var WgtMenuBuilder
   */
  public $menuBuilder = null;
  
  /**
   * @var LibAclPermission
   */
  public $access = null;
  
  /**
   * @var array
   */
  public $icons = array();
  
  /**
   * @var array
   */
  public $urls = array
  (
    'image_search' => 'ajax.php?c=Webfrap.Mediathek_Image.search',
    'image_delete' => 'ajax.php?c=Webfrap.Mediathek_Image.delete',
    'image_edit'   => 'modal.php?c=Webfrap.Mediathek_Image.edit',
    'image_add'    => 'modal.php?c=Webfrap.Mediathek_Image.add',
  
    'audio_search' => 'ajax.php?c=Webfrap.Mediathek_Audio.search',
    'audio_delete' => 'ajax.php?c=Webfrap.Mediathek_Audio.delete',
    'audio_edit'   => 'modal.php?c=Webfrap.Mediathek_Audio.edit',
    'audio_add'    => 'modal.php?c=Webfrap.Mediathek_Audio.add',
  
    'video_search' => 'ajax.php?c=Webfrap.Mediathek_Video.search',
    'video_delete' => 'ajax.php?c=Webfrap.Mediathek_Video.delete',
    'video_edit'   => 'modal.php?c=Webfrap.Mediathek_Video.edit',
    'video_add'    => 'modal.php?c=Webfrap.Mediathek_Video.add',
  
    'document_search' => 'ajax.php?c=Webfrap.Mediathek_Document.search',
    'document_delete' => 'ajax.php?c=Webfrap.Mediathek_Document.delete',
    'document_edit'   => 'modal.php?c=Webfrap.Mediathek_Document.edit',
    'document_add'    => 'modal.php?c=Webfrap.Mediathek_Document.add',
  
    'file_search' => 'ajax.php?c=Webfrap.Mediathek_File.search',
    'file_delete' => 'ajax.php?c=Webfrap.Mediathek_File.delete',
    'file_edit'   => 'modal.php?c=Webfrap.Mediathek_File.edit',
    'file_add'    => 'modal.php?c=Webfrap.Mediathek_File.add',
  );
  
  /**
   * @var array
   */
  public $mediaTypes = array
  (
    'image' => true,
    'audio' => false,
    'video' => false,
    'document' => true,
    'file'  => true,
  );
  
  /**
   * @var int
   */
  public $width = 950;
  
  /**
   * @var int
   */
  public $height = 600;

  /**
   * @var array
   */
  public $dataImage = array();
  
  /**
   * @var array
   */
  public $dataAudio = array();
  
  /**
   * @var array
   */
  public $dataVideo = array();
  
  /**
   * @var array
   */
  public $dataDocument = array();
  
  /**
   * @var array
   */
  public $dataFile = array();

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
    $this->icons['add']    = $this->icon( 'control/add.png', 'Add' );
    $this->icons['search'] = $this->icon( 'control/search.png', 'Search' );
    
    
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
  
/*//////////////////////////////////////////////////////////////////////////////
// Getter & Setter
//////////////////////////////////////////////////////////////////////////////*/

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
   * @param string $idKey
   */
  public function setIdKey( $idKey )
  {
    $this->idKey = $idKey;
  }//end public function setIdKey */
  
  /**
   * (non-PHPdoc)
   * @see WgtAbstract::setId()
   */
  public function setId( $id )
  {
    $this->idKey = $id;
  }//end public function setId */
  
  /**
   * @param WbfsysMedia_Entity $mediaNode
   */
  public function setMediaNode( $mediaNode )
  {
    
    $this->mediaNode = $mediaNode;
    $this->mediaId   = $mediaNode->getId();
    
  }//end public function setMediaNode */
  
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

    $htmlImgTab = '';

    if( $this->mediaTypes['image'] )
     $htmlImgTab = $this->renderImageTab( $idKey );

    if( $this->mediaTypes['file'] )
     $htmlFileTab = $this->renderFileTab( $idKey );

    if( $this->mediaTypes['document'] )
     $htmlDocumentTab = $this->renderDocumentTab( $idKey );
    
    $htmlHead = $this->renderMediathekHead( $idKey );
    
    $html = <<<HTML

<div 
  class="wgt-content_box wgt-mediathek" 
  id="wgt-mediathek-{$idKey}" 
  style="width:{$this->width}px;height:{$this->height}px;" >

	{$htmlHead}
  
  <div id="wgt-tab-mediathek-{$idKey}-content" class="wgt-content-box" style="height:530px;"  >
  	{$htmlImgTab}
  	{$htmlDocumentTab}
  	{$htmlFileTab}
  </div><!-- end tab Container -->
  
</div><!-- end widget -->

HTML;
    
    $this->html = $html;

    return $html;

  }// end public function render */
  
  /**
   * @param string $idKey
   * @return string
   */
  public function renderMediathekHead( $idKey )
  {
    
    $htmlSearch   = '';
    $htmlTabs     = '';
    $htmlControls = '';
    

    if( $this->mediaTypes['image'] )
    {

      $htmlSearch .= <<<HTML
      	<div class="wgt-tab-mediathek-{$idKey}-content box-image" >
        	<input 
        		type="text"
        		name="skey"
        		class="fparam-wgt-form-mediathek-{$idKey}-image-search large" /><button 
        		onclick="\$R.form('wgt-form-mediathek-{$idKey}-image-search');" 
        		class="wgt-button append"
        		tabindex="-1" >{$this->icons['search']}</button>
        </div>

HTML;

      $htmlTabs .= <<<HTML
      	<a wgt_key="image" class="tab wgt-corner-top" >Images</a>

HTML;

      $htmlControls .= <<<HTML
      <div class="wgt-tab-mediathek-{$idKey}-content box-image"  >
        <button 
        	onclick="\$R.get('{$this->urls['image_add']}&amp;media={$this->mediaId}&amp;element={$idKey}');" 
        	class="wgt-button"
        	tabindex="-1" >{$this->icons['add']} Add Image</button> 
      </div>

HTML;

    }
    
    if( $this->mediaTypes['video'] )
    {

      $htmlSearch .= <<<HTML
      	<div class="wgt-tab-mediathek-{$idKey}-content box-video" >
        	<input 
        		type="text"
        		name="skey"
        		class="fparam-wgt-form-mediathek-{$idKey}-video-search large" /><button 
        		onclick="\$R.form('wgt-form-mediathek-{$idKey}-video-search');" 
        		class="wgt-button append"
        		tabindex="-1" >{$this->icons['search']}</button>
        </div>

HTML;

      $htmlTabs .= <<<HTML
      	<a wgt_key="video" class="tab wgt-corner-top" >Videos</a>

HTML;

      $htmlControls .= <<<HTML
      <div class="wgt-tab-mediathek-{$idKey}-content box-video"  >
        <button 
        	onclick="\$R.get('{$this->urls['video_add']}&amp;media={$this->mediaId}&amp;element={$idKey}');" 
        	class="wgt-button"
        	tabindex="-1" >{$this->icons['add']} Add Video</button> 
      </div>

HTML;

    }
    
    if( $this->mediaTypes['audio'] )
    {
      
      $htmlSearch .= <<<HTML
      	<div class="wgt-tab-mediathek-{$idKey}-content box-audio" >
        	<input 
        		type="text"
        		name="skey"
        		class="fparam-wgt-form-mediathek-{$idKey}-audio-search large" /><button 
        		onclick="\$R.form('wgt-form-mediathek-{$idKey}-audio-search');" 
        		class="wgt-button append"
        		tabindex="-1" >{$this->icons['search']}</button>
        </div>

HTML;

      $htmlTabs .= <<<HTML
      	<a wgt_key="audio" class="tab wgt-corner-top" >Audios</a>

HTML;

      $htmlControls .= <<<HTML
      <div class="wgt-tab-mediathek-{$idKey}-content box-audio"  >
        <button 
        	onclick="\$R.get('{$this->urls['audio_add']}&amp;media={$this->mediaId}&amp;element={$idKey}');" 
        	class="wgt-button"
        	tabindex="-1" >{$this->icons['add']} Add Audio</button> 
      </div>

HTML;

    }
    
    if( $this->mediaTypes['document'] )
    {
      
      $htmlSearch .= <<<HTML
      	<div class="wgt-tab-mediathek-{$idKey}-content box-document" >
        	<input 
        		type="text"
        		name="skey"
        		class="fparam-wgt-form-mediathek-{$idKey}-document-search large" /><button 
        		onclick="\$R.form('wgt-form-mediathek-{$idKey}-document-search');" 
        		class="wgt-button append"
        		tabindex="-1" >{$this->icons['search']}</button>
        </div>

HTML;

      $htmlTabs .= <<<HTML
      	<a wgt_key="document" class="tab wgt-corner-top" >Documents</a>

HTML;

      $htmlControls .= <<<HTML
      <div class="wgt-tab-mediathek-{$idKey}-content box-document"  >
        <button 
        	onclick="\$R.get('{$this->urls['document_add']}&amp;media={$this->mediaId}&amp;element={$idKey}');" 
        	class="wgt-button"
        	tabindex="-1" >{$this->icons['add']} Add Document</button> 
      </div>

HTML;

    }
    
    if( $this->mediaTypes['file'] )
    {
      
      $htmlSearch .= <<<HTML
      	<div class="wgt-tab-mediathek-{$idKey}-content box-file" >
        	<input 
        		type="text"
        		name="skey"
        		class="fparam-wgt-form-mediathek-{$idKey}-file-search large" /><button 
        		onclick="\$R.form('wgt-form-mediathek-{$idKey}-file-search');" 
        		class="wgt-button append"
        		tabindex="-1" >{$this->icons['search']}</button>
        </div>

HTML;

      $htmlTabs .= <<<HTML
      	<a wgt_key="file" class="tab wgt-corner-top" >Files</a>

HTML;

      $htmlControls .= <<<HTML
      <div class="wgt-tab-mediathek-{$idKey}-content box-file"  >
        <button 
        	onclick="\$R.get('{$this->urls['file_add']}&amp;media={$this->mediaId}&amp;element={$idKey}');" 
        	class="wgt-button"
        	tabindex="-1" >{$this->icons['add']} Add File</button> 
      </div>

HTML;

    }
    
    $html = <<<HTML

  <div class="head" style="width:{$this->width}px;"  >
    <table border="0" cellspacing="0" cellpadding="0" width="100%" >
      <tr>
        <td width="*" ><h2>{$this->label}</h2></td>
        <td width="320px;" class="search" align="right" >
        	{$htmlSearch}
        </td>
      </tr>
    </table>
  </div>
  
  <!-- Das Panel mit den Control Elementen und dem Tab Head -->
  <div class="wgt-panel" >
  	<div class="left" >
  		{$htmlControls}
   	</div>
   	<div 
   		class="wcm wcm_ui_tab_head wgt-tab-head ar right" 
   		id="wgt-tab-mediathek-{$idKey}-head"
   		style="width:550px;border:0px;"
   		wgt_body="wgt-tab-mediathek-{$idKey}-content" >
   		<div class="tab_head" >
     		{$htmlTabs}
   		</div>
   	</div>
  </div>

HTML;
    
    
    return $html;
    
  }//end public function renderMediathekHead */
  
  
/*//////////////////////////////////////////////////////////////////////////////
// Images
//////////////////////////////////////////////////////////////////////////////*/
  
  /**
   * @param string $idKey
   * @return string
   */
  protected function renderImageTab( $idKey )
  {
    
    /**
     */
    $codeEntr = '';
    
    $counter = 1;
    
    if( $this->dataImage )
    {
      foreach( $this->dataImage as $entry )
      {

        $codeEntr .= $this->renderImageEntry( $this->idKey, $entry, $counter );
        ++$counter;

      }
    }
    
    $dataSize = count( $this->dataImage );
    
    $html = <<<HTML
    <div class="container" wgt_key="image" id="wgt-tab-mediathek-{$idKey}-content-image" >
  
      <div class="content" style="height:530px;" >
      
        <form 
          method="get" 
          action="{$this->urls['image_search']}&amp;media={$this->mediaId}&amp;element={$this->idKey}" 
          id="wgt-form-mediathek-{$idKey}-image-search" />
    
        <div id="wgt-grid-mediathek-{$idKey}-image" class="wgt-grid" >
        
          <var id="wgt-grid-mediathek-{$idKey}-image-cfg-grid" >{
          "height":"large",
          "search_form":"wgt-form-mediathek-{$idKey}-image-search",
          "search_able":"true"}</var>
        
          <table id="wgt-grid-mediathek-{$idKey}-image-table" class="wgt-grid wcm wcm_widget_grid hide-head" >
          
            <thead>
            
              <tr>
                <th class="pos" style="width:30px"  >&nbsp;</th>
                <th style="width:120px" >Img</th>
                <th 
                  style="width:340px" 
                  wgt_sort_name="img[title]" 
                  wgt_sort="asc" 
                  wgt_search="input:img[title]"  >Name/Title</th>
                <th 
                  style="width:120px"  >Img Data</th>
                <th 
                  style="width:150px" 
                  wgt_sort_name="file[created]" >Meta Data</th>
                <th 
                  style="width:50px;" >Nav.</th>
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
      
    </div><!-- end tab files -->

HTML;

    return $html;
    
  }//end protected function renderImageTab */

  

  /**
   * @param string $elemId
   * @param array $entry
   * @param int $counter
   * @return string
   */
  public function renderImageEntry( $elemId, $entry, $counter = null )
  {

    $fileSize    = '';

    $fileName = trim( $entry['img_file'] );
    $fileSize = SFormatNumber::formatFileSize( $entry['img_size'] );
    $b64Name  = base64_encode($fileName);
    $link = "<a href=\"image.php?f=wbfsys_image-file-{$entry['img_id']}&amp;s=medium&amp;n={$b64Name}&amp;version={$entry['img_version']}\" target=\"wgt_dms\" rel=\"nofollow\" >"
        ."<img style=\"max-width:100px;max-height:100px;\" src=\"thumb.php?f=wbfsys_image-file-{$entry['img_id']}&amp;s=medium&amp;n={$b64Name}&amp;version={$entry['img_version']}\" alt=\"{$fileName}\" />"
      ."</a>";
      
    $linkDownload = "<a href=\"image.php?f=wbfsys_image-file-{$entry['img_id']}&amp;s=medium&amp;n={$b64Name}&amp;version={$entry['img_version']}\" target=\"wgt_dms\" rel=\"nofollow\" >"
      .$fileName." (download)"."</a>";
  
    $timeCreated  = date( 'Y-m-d - H:i',  strtotime($entry['img_created'])  );
    $menuCode     = $this->renderImageMenu( $entry );
    
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
    	class="wcm wcm_control_access_dataset {$rowClass} node-{$entry['img_id']}" 
    	id="wgt-grid-mediathek-{$elemId}-image_row_{$entry['img_id']}-1"
    	wgt_url="{$this->urls['image_edit']}&amp;media={$this->mediaId}&amp;element={$elemId}&amp;objid={$entry['img_id']}" >
      <td class="pos" rowspan="3" valign="top" >{$counter}</td>
      <td rowspan="3" valign="top" >{$link}</td>
      <td>{$linkDownload}</td>
      <td>
      	{$entry['img_mimetype']}<br />
      	{$entry['img_width']} x {$entry['img_height']}<br />
        {$fileSize}
      </td>
      <td class="no_oflw" rowspan="2" valign="top" >
				u: <span 
          class="wcm wcm_control_contact_user" 
          wgt_eid="{$entry['user_id']}"
          title="{$entry['lastname']}, {$entry['firstname']}" >{$entry['user_name']}</span><br />
        t: {$timeCreated}<br />
      	c: {$entry['confidential_label']}<br />
      	l: {$entry['licence_name']}
      </td>
      <td class="nav" rowspan="3" valign="top" align="center" >{$menuCode}</td>
    </tr>
    <tr
    	class="wcm wcm_control_access_dataset {$rowClass} node-{$entry['img_id']}" 
    	id="wgt-grid-mediathek-{$elemId}-image_row_{$entry['img_id']}-2"
    	wgt_url="{$this->urls['image_edit']}&amp;media={$this->mediaId}&amp;element={$elemId}&amp;objid={$entry['img_id']}" >
    	<td colspan="2" >{$entry['img_title']}</td>
    </tr>
    <tr
    	class="wcm wcm_control_access_dataset {$rowClass} node-{$entry['img_id']}" 
    	id="wgt-grid-mediathek-{$elemId}-image_row_{$entry['img_id']}-3"
    	wgt_url="{$this->urls['image_edit']}&amp;media={$this->mediaId}&amp;element={$elemId}&amp;objid={$entry['img_id']}" >
    	<td colspan="3" ><a href="#">1024x768 (original)</a> | <a href="#">1024x768</a> | <a href="#">800x600</a></td>
    </tr>
        
HTML;

    return $codeEntr;
    
  }//end public function renderImageEntry */
  
  /**
   * @param string $elementId
   * @param array $data
   * @return string
   */
  public function renderImageSearch( $elementId, $data )
  {
    
    if( $this->html )
      return $this->html;

    $counter = 1;
    
    $html = '';
    
    if( $this->dataImage )
    {
      foreach( $this->dataImage as $entry )
      {
        $html .= $this->renderImageEntry( $this->idKey, $entry, $counter );
        ++$counter;
      }
    }
    
    $this->html = $html;


    return $html;

  }// end public function renderImageSearch */

  /**
   * @param array $entry
   * @return string
   */
  protected function renderImageMenu( $entry )
  {
    
    $html = <<<CODE
	<button 
		onclick="\$R.del('{$this->urls['image_delete']}&media={$this->mediaId}&element={$this->idKey}&objid={$entry['img_id']}');" 
		class="wgt-button"
		tabindex="-1" >{$this->icons['delete']}</button>
CODE;

    return $html;
    
    
  }//end protected function renderImageMenu */
  
  
/*//////////////////////////////////////////////////////////////////////////////
// Files
//////////////////////////////////////////////////////////////////////////////*/
  
  /**
   * @param string $idKey
   * @return string
   */
  protected function renderFileTab( $idKey )
  {
    
    /**
     */
    $codeEntr = '';
    
    $counter = 1;
    
    if( $this->dataFile )
    {
      foreach( $this->dataFile as $entry )
      {

        $codeEntr .= $this->renderFileEntry( $this->idKey, $entry, $counter );
        ++$counter;

      }
    }
    
    $dataSize = count( $this->dataFile );
    
    $html = <<<HTML
    <div class="container" wgt_key="file" id="wgt-tab-mediathek-{$idKey}-content-file" >
  
      <div class="content" style="height:530px;" >
      
        <form 
          method="get" 
          action="{$this->urls['file_search']}&amp;media={$this->mediaId}&amp;element={$this->idKey}" 
          id="wgt-form-mediathek-{$idKey}-file-search" />
    
        <div id="wgt-grid-mediathek-{$idKey}-file" class="wgt-grid" >
        
          <var id="wgt-grid-mediathek-{$idKey}-file-cfg-grid" >{
          "height":"large",
          "search_form":"wgt-form-mediathek-{$idKey}-file-search",
          "search_able":"true"}</var>
        
          <table id="wgt-grid-mediathek-{$idKey}-file-table" class="wgt-grid wcm wcm_widget_grid hide-head" >
          
            <thead>
            
              <tr>
                <th class="pos" style="width:30px"  >&nbsp;</th>
                <th style="width:50px" >File</th>
                <th 
                  style="width:340px" 
                  wgt_sort_name="img[title]" 
                  wgt_sort="asc" 
                  wgt_search="input:img[title]"  >Name/Title</th>
                <th 
                  style="width:120px"  >File Data</th>
                <th 
                  style="width:150px" 
                  wgt_sort_name="file[created]" >Meta Data</th>
                <th 
                  style="width:50px;" >Nav.</th>
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
      
    </div><!-- end tab files -->

HTML;

    return $html;
    
  }//end protected function renderFileTab */

  

  /**
   * @param string $elemId
   * @param array $entry
   * @param int $counter
   * @return string
   */
  public function renderFileEntry( $elemId, $entry, $counter = null )
  {

    $fileSize    = '';

    //application-octet-stream
    $iconType = 'application-octet-stream';
    $keyType  = 'application/octet-stream';
    
    if( $entry['file_mimetype'] )
    {
      $iconType = str_replace( '/', '-', $entry['file_mimetype'] );
      $keyType  = $entry['file_mimetype'];
    }
      
    $entryIcon = $this->icon( 'mimetype/'.$iconType.'.png', $keyType, 'medium' );
    
    $fileName = trim( $entry['file_name'] );
    $fileSize = SFormatNumber::formatFileSize( $entry['file_size'] );
    $b64Name  = base64_encode( $fileName );
    
    $link = "<a href=\"file.php?f=wbfsys_file-file-{$entry['file_id']}&amp;n={$b64Name}&amp;version={$entry['file_version']}\" target=\"wgt_dms\" rel=\"nofollow\" >"
        .$entryIcon
      ."</a>";
      
    $linkDownload = "<a href=\"file.php?f=wbfsys_image-file-{$entry['file_id']}&amp;n={$b64Name}&amp;version={$entry['file_version']}\" target=\"wgt_dms\" rel=\"nofollow\" >"
      .$fileName.""."</a>";
  
    $timeCreated  = date( 'Y-m-d - H:i',  strtotime($entry['file_created'])  );
    $menuCode     = $this->renderFileMenu( $entry );
    
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
    	class="wcm wcm_control_access_dataset {$rowClass} node-{$entry['file_id']}" 
    	id="wgt-grid-mediathek-{$elemId}-file_row_{$entry['file_id']}-1"
    	wgt_url="{$this->urls['file_edit']}&amp;media={$this->mediaId}&amp;element={$elemId}&amp;objid={$entry['file_id']}" >
      <td class="pos" rowspan="2" valign="top" >{$counter}</td>
      <td rowspan="2" valign="top" >{$link}</td>
      <td>{$linkDownload}</td>
      <td>
      	{$entry['file_mimetype']}<br />
        {$fileSize}
      </td>
      <td class="no_oflw" rowspan="2" valign="top" >
				u: <span 
          class="wcm wcm_control_contact_user" 
          wgt_eid="{$entry['user_id']}"
          title="{$entry['lastname']}, {$entry['firstname']}" >{$entry['user_name']}</span><br />
        t: {$timeCreated}<br />
      	c: {$entry['confidential_label']}<br />
      	l: {$entry['licence_name']}
      </td>
      <td class="nav" rowspan="2" valign="top" align="center" >{$menuCode}</td>
    </tr>
    <tr
    	class="wcm wcm_control_access_dataset {$rowClass} node-{$entry['file_id']}" 
    	id="wgt-grid-mediathek-{$elemId}-file_row_{$entry['file_id']}-2"
    	wgt_url="{$this->urls['image_edit']}&amp;media={$this->mediaId}&amp;element={$elemId}&amp;objid={$entry['file_id']}" >
    	<td colspan="2" >{$entry['file_description']}&nbsp;</td>
    </tr>
        
HTML;

    return $codeEntr;
    
  }//end public function renderFileEntry */
  
  /**
   * @param string $elementId
   * @param array $data
   * @return string
   */
  public function renderFileSearch( $elementId )
  {
    
    if( $this->html )
      return $this->html;

    $counter = 1;
    
    $html = '';
    
    if( $this->dataFile )
    {
      foreach( $this->dataFile as $entry )
      {
        $html .= $this->renderFileEntry( $this->idKey, $entry, $counter );
        ++$counter;
      }
    }
    
    $this->html = $html;


    return $html;

  }// end public function renderFileSearch */

  /**
   * @param array $entry
   * @return string
   */
  protected function renderFileMenu( $entry )
  {
    
    $html = <<<CODE
	<button 
		onclick="\$R.del('{$this->urls['file_delete']}&media={$this->mediaId}&element={$this->idKey}&objid={$entry['file_id']}');" 
		class="wgt-button"
		tabindex="-1" >{$this->icons['delete']}</button>
CODE;

    return $html;
    
    
  }//end protected function renderFileMenu */
  
/*//////////////////////////////////////////////////////////////////////////////
// Document
//////////////////////////////////////////////////////////////////////////////*/
  
  /**
   * @param string $idKey
   * @return string
   */
  protected function renderDocumentTab( $idKey )
  {
    
    /**
     */
    $codeEntr = '';
    
    $counter = 1;
    
    if( $this->dataDocument )
    {
      foreach( $this->dataDocument as $entry )
      {

        $codeEntr .= $this->renderDocumentEntry( $this->idKey, $entry, $counter );
        ++$counter;

      }
    }
    
    $dataSize = count( $this->dataDocument );
    
    $html = <<<HTML
    <div class="container" wgt_key="image" id="wgt-tab-mediathek-{$idKey}-content-document" >
  
      <div class="content" style="height:530px;" >
      
        <form 
          method="get" 
          action="{$this->urls['document_search']}&amp;media={$this->mediaId}&amp;element={$this->idKey}" 
          id="wgt-form-mediathek-{$idKey}-document-search" />
    
        <div id="wgt-grid-mediathek-{$idKey}-document" class="wgt-grid" >
        
          <var id="wgt-grid-mediathek-{$idKey}-document-cfg-grid" >{
          "height":"large",
          "search_form":"wgt-form-mediathek-{$idKey}-document-search",
          "search_able":"true"}</var>
        
          <table id="wgt-grid-mediathek-{$idKey}-document-table" class="wgt-grid wcm wcm_widget_grid hide-head" >
          
            <thead>
            
              <tr>
                <th class="pos" style="width:30px"  >&nbsp;</th>
                <th style="width:120px" >File</th>
                <th 
                  style="width:340px" 
                  wgt_sort_name="img[title]" 
                  wgt_sort="asc" 
                  wgt_search="input:img[title]"  >Title</th>
                <th 
                  style="width:120px"  >Doc Data</th>
                <th 
                  style="width:150px" 
                  wgt_sort_name="file[created]" >Meta Data</th>
                <th 
                  style="width:50px;" >Nav.</th>
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
      
    </div><!-- end tab files -->

HTML;

    return $html;
    
  }//end protected function renderDocumentTab */

  

  /**
   * @param string $elemId
   * @param array $entry
   * @param int $counter
   * @return string
   */
  public function renderDocumentEntry( $elemId, $entry, $counter = null )
  {

    $fileSize    = '';

    $fileName = trim( $entry['doc_file'] );
    $fileSize = SFormatNumber::formatFileSize( $entry['doc_size'] );
    $b64Name  = base64_encode( $fileName );
    
    //application-octet-stream
    $iconType = 'application-octet-stream';
    $keyType  = 'application/octet-stream';
    
    if( $entry['file_mimetype'] )
    {
      $iconType = str_replace( '/', '-', $entry['file_mimetype'] );
      $keyType  = $entry['file_mimetype'];
    }
      
    $entryIcon = $this->icon( 'mimetype/'.$iconType.'.png', $keyType, 'medium' );
    
    $link = "<a href=\"file.php?f=wbfsys_document-file-{$entry['doc_id']}&amp;n={$b64Name}&amp;version={$entry['doc_version']}\" target=\"wgt_dms\" rel=\"nofollow\" >"
      .$entryIcon
      ."</a>";
      
    $linkDownload = "<a href=\"file.php?f=wbfsys_image-file-{$entry['doc_id']}&amp;s=medium&amp;n={$b64Name}&amp;version={$entry['doc_version']}\" target=\"wgt_dms\" rel=\"nofollow\" >"
      .$fileName."</a>";
  
    $timeCreated  = date( 'Y-m-d - H:i',  strtotime($entry['doc_created'])  );
    $menuCode     = $this->renderDocumentMenu( $entry );
    
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
    	class="wcm wcm_control_access_dataset {$rowClass} node-{$entry['doc_id']}" 
    	id="wgt-grid-mediathek-{$elemId}-document_row_{$entry['doc_id']}-1"
    	wgt_url="{$this->urls['document_edit']}&amp;media={$this->mediaId}&amp;element={$elemId}&amp;objid={$entry['doc_id']}" >
      <td class="pos" rowspan="2" valign="top" >{$counter}</td>
      <td rowspan="2" valign="top" >{$link}</td>
      <td>{$linkDownload}</td>
      <td>
      	{$keyType}<br />
        {$fileSize}
      </td>
      <td class="no_oflw" rowspan="2" valign="top" >
				u: <span 
          class="wcm wcm_control_contact_user" 
          wgt_eid="{$entry['user_id']}"
          title="{$entry['lastname']}, {$entry['firstname']}" >{$entry['user_name']}</span><br />
        t: {$timeCreated}<br />
      	c: {$entry['confidential_label']}<br />
      	l: {$entry['licence_name']}
      </td>
      <td class="nav" rowspan="3" valign="top" align="center" >{$menuCode}</td>
    </tr>
    <tr
    	class="wcm wcm_control_access_dataset {$rowClass} node-{$entry['doc_id']}" 
    	id="wgt-grid-mediathek-{$elemId}-document_row_{$entry['doc_id']}-2"
    	wgt_url="{$this->urls['document_edit']}&amp;media={$this->mediaId}&amp;element={$elemId}&amp;objid={$entry['doc_id']}" >
    	<td colspan="2" >{$entry['doc_description']}</td>
    </tr>
        
HTML;

    return $codeEntr;
    
  }//end public function renderDocumentEntry */
  
  /**
   * @param string $elementId
   * @param array $data
   * @return string
   */
  public function renderDocumentSearch( $elementId, $data )
  {
    
    if( $this->html )
      return $this->html;

    $counter = 1;
    
    $html = '';
    
    if( $this->dataImage )
    {
      foreach( $this->dataImage as $entry )
      {
        $html .= $this->renderDocumentEntry( $this->idKey, $entry, $counter );
        ++$counter;
      }
    }
    
    $this->html = $html;

    return $html;

  }// end public function renderDocumentSearch */

  /**
   * @param array $entry
   * @return string
   */
  protected function renderDocumentMenu( $entry )
  {
    
    $html = <<<CODE
	<button 
		onclick="\$R.del('{$this->urls['document_delete']}&media={$this->mediaId}&element={$this->idKey}&objid={$entry['img_id']}');" 
		class="wgt-button"
		tabindex="-1" >{$this->icons['delete']}</button>
CODE;

    return $html;
    
    
  }//end protected function renderDocumentMenu */


} // end class WgtElementMediathek


