<?php 

define( 'TPL_START', '<?php echo' );
define( 'TPL_END',   '?>'  );

?>

<div 
  class="box_template wgt-editlayer border" 
  contenteditable="true" 
  id="wgt-edit-field-text" ></div>
<div 
  class="box_template wgt-editlayer number border" 
  contenteditable="true" 
  id="wgt-edit-field-number"  ></div>
<div 
  class="box_template wgt-editlayer" 
  id="wgt-edit-field-select" ></div>
<div 
  class="box_template wgt-editlayer" 
  id="wgt-edit-field-window" ></div>
<div 
  class="box_template wgt-editlayer" 
  id="wgt-edit-field-check" ><input type="checkbox" /></div>
<div 
  class="box_template wgt-editlayer border" 
  contenteditable="true" 
  id="wgt-edit-field-date" ><input 
    type="text" 
    class="wcm wcm_list_date" 
    style="border:0px;width:100%;margin:0px;padding:0px;" 
    /></div>
<div class="box_template wgt-editlayer" contenteditable="true" id="wgt-edit-field-datetime" ><input 
  type="text" 
  class="wcm wcm_list_date_timepicker" 
  style="border:0px;width:100%;margin:0px;padding:0px;" 
  /></div>
<div class="box_template wgt-editlayer border" contenteditable="true" id="wgt-edit-field-money" ><input 
  type="text" 
  style="border:0px;width:100%;margin:0px;padding:0px;" 
  /><button
    class="wgt-button append just-annotate"
    tabindex="-1"  ><i 
      class="icon-money" ></i></button></div>


<div id="wgt_progress_bar" style="display:none;position:absolute;left:50%;top:400px;" >
  <?php echo Wgt::image('wgt/loader.gif',array('alt'=>'progress'),true); ?>
</div>

<div id="wgt_template_container" style="display:none;" class="meta" >

  <div id="wgt_template_tab_container"  >
    <div class="wgt-container-controls">
      <div class="wgt-container-buttons"></div>
      <div class="tab_outer_container">
        <div class="tab_scroll" >
          <div class="tab_container" >&nbsp;</div>
        </div>
      </div>
    </div>
  </div>

  <div id="wgt_template_tab_head" >
    <span class="tab ui-corner-top" >
      <span class="label" ><a></a></span>
    </span>
  </div>

  <div id="wgt-template-dialog" >
    <div title="{$title}" >
      <p>{$message}</p>
    </div>
  </div>

  <div id="dialogTemplate" class="template window ui-corner-all" >
    <div class="content"></div>
    <div class="wgt-container-buttons"><button class="standard template"></button></div>
    <button class="close" title="Close Window">X</button>
    <div class="wgt-window-layer inactive"></div>
  </div>

  <div id="wgtidFileUpload" class="meta" >
    <iframe id="wgtidFrameUpload" name="fileUpload" ></iframe>
  </div>

</div>

<div id="wgt_data_container" class="meta" ></div>
<div id="wgt_tmp_container" class="meta" ></div>
<div id="wgt-context-container" style="display:none;" ></div>


