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
class WgtElementAttachmentList extends WgtAbstract
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

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
   * Steuerflags zum customizen des elements
   * - attachments  bool: support für attachements
   * -- a_create bool: neue attachments erstellen
   * -- a_update bool: vorhandene attachments ändern
   * -- a_delete bool: attachments löschen
   * - files
   * - links
   * -- l_storage bool: storage support
   * - storages  bool: support für storages
   * -- s_create bool: neue storages erstellen
   * -- s_update bool: vorhandene storages ändern
   * -- s_delete bool: storages löschen
   * @var TArray
   */
  public $flags = null;

  /**
   *
   * @var string
   */
  public $width        = 850;

  /**
   *
   * @var string
   */
  public $height        = 590;

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

  /**
   * @var WebfrapAttachment_Context
   */
  public $context = null;

/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * default constructor
   *
   * @param int $name the name of the wgt object
   * @param WebfrapAttachment_Context $context
   * @param LibTemplate $view
   * @param array $flags
   */
  public function __construct($name, $context, $view = null, $flags = array() )
  {

    $this->texts  = new TArray();
    $this->flags  = new TArray($flags ); // here we use flags
    $this->context = $context;

    if ($context->element )
      $this->idKey = $context->element;

    $this->name   = $name;
    $this->init();

    if ($view )
      $view->addElement($name, $this );

    // setup der icons
    $this->icons['link']   = $this->icon( 'control/attachment_link.png', 'Link' );
    $this->icons['file']   = $this->icon( 'control/attachment_file.png', 'File' );
    $this->icons['delete'] = $this->icon( 'control/delete.png', 'Delete' );
    $this->icons['edit'] = $this->icon( 'control/edit.png', 'Edit' );

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

    if (is_null($this->idKey ) )
      $this->idKey = Webfrap::uniqKey();

    return $this->idKey;

  }//end public function getIdKey */

  /**
   * (non-PHPdoc)
   * @see WgtAbstract::setId()
   */
  public function setId($id )
  {

    $this->idKey = $id;
    $this->context->element = $id;

  }//end public function setId */

  /**
   * @param array $dataStorage
   */
  public function setStorageData( array $dataStorage )
  {
    $this->dataStorage = $dataStorage;
  }//end public function setStorageData */

/*//////////////////////////////////////////////////////////////////////////////
// Render Logic
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   */
  public function preRenderUrl()
  {

    if (!$this->context->element )
      $this->context->element = $this->getIdKey();

    $this->defUrl   = $this->context->toUrlExt();
    $this->defAction = $this->context->toActionExt();

  }//end public function preRenderUrl */

  /**
   *
   */
  public function preCalculateFlags()
  {

    if (false === $this->flags->attachments) {
      $this->flags->files = false;
      $this->flags->links = false;
      $this->flags->a_delete = false;
      $this->flags->a_create = false;
      $this->flags->a_edit = false;
    }

    if (false === $this->flags->storages) {
      $this->flags->s_delete = false;
      $this->flags->s_create = false;
      $this->flags->s_edit = false;
    }

    if ($this->access) {

      if (!$this->access->update) {
        $this->flags->a_delete = false;
        $this->flags->a_create = false;
        $this->flags->a_edit = false;

        $this->flags->s_delete = false;
        $this->flags->s_create = false;
        $this->flags->s_edit = false;
      }

    }

  }//end public function preCalculateFlags */

  /**
   * @param TFlag $params
   * @return string
   */
  public function render($params = null )
  {

    if ($this->html )
      return $this->html;

    if (!$this->defUrl )
      $this->preRenderUrl();

    $this->preCalculateFlags();

    $idKey    = $this->getIdKey();

    // content

    $headAttachmentTab  = '';
    $headRepoTab        = '';
    $htmlAttachmentTab  = '';
    $htmlRepoTab        = '';
    $codeButtonsAttach  = '';
    $codeButtonsStorage = '';

    if ( false !== $this->flags->attachments )
      $htmlAttachmentTab = $this->renderAttachmentTab($idKey );

    if ( false !== $this->flags->storages )
      $htmlRepoTab = $this->renderRepoTab($idKey );

    if (false !== $this->flags->attachments) {
      $headAttachmentTab  = '<a wgt_key="files" class="tab ui-corner-top" >Files</a>';
    }

    // nur wenn create nicht false
    if (false !== $this->flags->a_create) {

      // checken ob wir links wollen
      if (false !== $this->flags->links) {

        $codeButtonsAttach .= <<<HTML
        <button
          onclick="\$R.get('modal.php?c=Webfrap.Attachment.formAddLink{$this->defUrl}');"
          class="wgtac-add_link wgt-button"
          tabindex="-1" ><i class="icon-plus-sign" ></i> Add Link</button>
HTML;

      }

      // checken ob wir files wollen
      if (false !== $this->flags->files) {

        $codeButtonsAttach .= <<<HTML
        <button
          onclick="\$R.get('modal.php?c=Webfrap.Attachment.formUploadFiles{$this->defUrl}');"
          tabindex="-1"
          class="wgtac-add_file wgt-button" ><i class="icon-plus-sign" ></i> Add File</button>
HTML;

      }

    }

    // checken ob wir storages wollen
    if (false !== $this->flags->links) {

      $codeButtonsAttach .= <<<HTML

        <button
            class="wcm wcm_ui_dropform wcm_ui_tip-top wgt-button ui-state-default"
            tabindex="-1"
            id="wgt-tab-attachment-{$idKey}-help"
            tooltip="How to deal with nonworking links?"
          >Links not working? <i class="icon-info-sign" ></i></button>

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
        <!-- end help -->

HTML;


    }

    // checken ob wir storages wollen
    if (false !== $this->flags->s_create) {

      $headRepoTab = '<a wgt_key="repos" class="tab ui-corner-top" >Storages</a>';

      $codeButtonsStorage = <<<HTML
        <button
          onclick="\$R.get('modal.php?c=Webfrap.Attachment.formAddStorage{$this->defUrl}');"
          class="wgtac-add_repo wgt-button"
          tabindex="-1" ><i class="icon-plus-sign" ></i> Add Storage</button>
HTML;


    }

    // todo lösung für storages only mit einbauen

    $html = <<<HTML

<!-- start attachment list widget -->
<div
  class="wgt-content_box wgt-attchment_list"
  id="wgt-attachment-{$idKey}"
  style="width:850px;height:590px;" >

  <!-- start head -->
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
            tabindex="-1" ><i class="icon-search" ></i></button>
        </td>
      </tr>
    </table>
  </div><!-- end head -->

  <!-- Das Panel mit den Control Elementen und dem Tab Head -->
  <div class="wgt-panel" >
    <div class="left" >
      <div class="wgt-tab-attachment-{$idKey}-content box-files" >
{$codeButtonsAttach}
      </div>
      <div class="wgt-tab-attachment-{$idKey}-content box-repos" style="display:none;" >
{$codeButtonsStorage}
      </div>
     </div>

     <!-- tab buttons -->
     <div
       class="wcm wcm_ui_tab_head wgt-tab-head ar right"
       id="wgt-tab-attachment-{$idKey}-head"
       style="width:250px;border:0px;"
       wgt_body="wgt-tab-attachment-{$idKey}-content" >
       <div
         class="tab_head" >
         {$headAttachmentTab}
         {$headRepoTab}
       </div>
     </div>

  </div><!-- end panel -->

  <!-- start tab Container -->
  <div
    id="wgt-tab-attachment-{$idKey}-content"
    class="wgt-content-box"
    style="height:530px;"  >
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
  protected function renderAttachmentTab($idKey )
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

    if ($this->data) {
      foreach ($this->data as $entry) {

        $codeEntr .= $this->renderAjaxEntry($idKey, $entry, $counter );
        ++$counter;

      }
    }


    $dataSize = count($this->data );

    $html = <<<HTML
    <div class="container" wgt_key="files" id="wgt-tab-attachment-{$idKey}-content-files" >

      <div class="content" style="height:530px;" >

        <form
          method="get"
          action="{$this->urlSearch}{$this->defUrl}"
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
  public function renderAjaxEntry($elemId, $entry, $counter = null )
  {

    $fileSize    = '';

    if ( '' != trim($entry['file_name'] ) ) {

      $fileIcon = '<i class="icon-file"></i>';
      $fileName = trim($entry['file_name'] );
      $fileSize = SFormatNumber::formatFileSize($entry['file_size'] );
      $b64Name     = base64_encode($fileName);

      $link = "<a href=\"file.php?f=wbfsys_file-name-{$entry['file_id']}&amp;n={$b64Name}\" "
        ." target=\"wgt_dms\" rel=\"nofollow\" >{$fileName}</a>";

    } else {

      if( '' != trim($entry['storage_link']) ){
        $storageLink = 'file:\\\\\\'.trim($entry['storage_link'] ) ;
      } else {
        $storageLink = '';
      }

      $lastChar = substr($storageLink, -1) ;

      if ($lastChar != '\\' && $lastChar != '/' )
        $storageLink .= '\\';

      $fileIcon = '<i class="icon-link"></i>';
      $fileName = str_replace('\\\\', '\\', trim($entry['file_link'] )) ;

      // FUCK YOU BASTARD IE NOOBS DIE!!!! DIIIEEEEEE! DIIIIIIEEEEEEE!!!!!!! FUCKERS!
      $firstChar = substr($fileName, 0, 1) ;

      if ($firstChar == '\\' )
        $fileName = substr($fileName,1 ) ;

      //$fileName = str_replace('//', '/', $fileName) ;

      $link = "<a href=\"{$storageLink}{$fileName}\" target=\"wgt_dms\" rel=\"nofollow\" >{$storageLink}{$fileName}</a>";

    }

    $timeCreated  = date( 'Y-m-d - H:i',  strtotime($entry['time_created'])  );
    $menuCode     = $this->renderRowMenu($entry, $elemId );

    if ($counter) {
      $rowClass = 'row_'.($counter%2);
    } else {
      $rowClass = 'row_1';
      $counter = 1;
    }

    $confidentialIcon = '';

    if ($entry['confidential_level']) {
      $confidentialIcon = isset($this->icons['level_'.$entry['confidential_level']])
        ? $this->icons['level_'.$entry['confidential_level']]
        : '';
    }

    if (!($this->access && !$this->access->update ) && false !== $this->flags->a_update ) {

      $codeEntr = <<<HTML

    <tr
      class="wcm wcm_control_access_dataset {$rowClass} node-{$entry['attach_id']}"
      id="wgt-grid-attachment-{$elemId}_row_{$entry['attach_id']}"
      wgt_url="{$this->urlEdit}{$this->defUrl}&amp;objid={$entry['attach_id']}" >
HTML;

    } else {

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
  public function renderAjaxBody($elementId, $data )
  {

    if ($this->html )
      return $this->html;

    $counter = 1;
    $html    = '';

    if ($this->data) {

      foreach ($this->data as $entry) {

        $html .= $this->renderAjaxEntry($this->idKey, $entry, $counter );
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
  public function renderRowMenu($entry, $elementId )
  {

    if ($this->access && !$this->access->update )
      return '';

    $menuId = 'wgt-cntrl-'.$elementId.'-file-'.$entry['attach_id'];

    $html = <<<HTML
  <div id="{$menuId}" class="wgt-grid_menu" >
    <button
      class="wcm wcm_control_dropmenu wgt-button ui-state-default"
      tabindex="-1"
      id="{$menuId}-cntrl"
      style="width:40px;" wgt_drop_box="{$menuId}-menu" >
      <i class="icon-cog" ></i>
      <i class="icon-angle-down" ></i>
    </button>
  </div>
  <div class="wgt-dropdownbox al_right" id="{$menuId}-menu" >
    <ul>
      <li>
        <a
          href="{$this->urlEdit}{$this->defAction}&objid={$entry['attach_id']}"
          class="wcm wcm_req_ajax"
          tabindex="-1" ><i class="icon-edit" ></i> Edit</a>
      </li>
    </ul>
    <ul>
      <li>
        <a
          onclick="\$R.del('{$this->urlDelete}{$this->defAction}&objid={$entry['attach_id']}',{confirm:'Confirm to delete.'});"
          tabindex="-1" ><i class="icon-remove" ></i> delete</a>
      </li>
    </ul>
  </div>
  <var id="{$menuId}-cntrl-cfg-dropmenu"  >{"align":"right"}</var>
HTML;

    return $html;


  }//end public function renderRowMenu */


/*//////////////////////////////////////////////////////////////////////////////
// title
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $idKey
   * @return string
   */
  protected function renderRepoTab($idKey )
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

    if ($this->dataStorage) {
      foreach ($this->dataStorage as $entry) {
        $codeEntr .= $this->renderAjaxStorageEntry($this->idKey, $entry, $counter );
        ++$counter;
      }
    }

    $dataSize = count($this->dataStorage );

    $code = <<<HTML
    <div class="container" wgt_key="files" id="wgt-tab-attachment-{$idKey}-content-repos" >

      <div class="content" style="height:530px;" >

        <form
          method="get"
          action="{$this->urlStorageSearch}{$this->defUrl}"
          id="wgt-form-attachment-{$idKey}-search" ></form>

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
  public function renderAjaxStorageEntry($elemId, $entry, $counter = null )
  {


    $menuCode     = $this->renderRowStorageMenu($entry );

    if ($counter )
      $rowClass = 'row_'.($counter%2);
    else {
      $rowClass = 'row_1';
      $counter = 1;
    }

    $confidentialIcon = '';

    if ($entry['confidential_level']) {
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
  public function renderRowStorageMenu($entry )
  {

    if ( false === $this->flags->s_delete )
      return '';

    $html = <<<CODE
  <button
    onclick="\$R.del('{$this->urlStorageDelete}{$this->defAction}&objid={$entry['storage_id']}',{confirm:'Confirm to delete.'});"
    class="wgt-button"
    tabindex="-1" ><i class="icon-remove" ></i></button>
CODE;

    return $html;

  }//end public function renderRowMenuStorage */

} // end class WgtElementAttachmentList

