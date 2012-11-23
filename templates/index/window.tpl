<?php 

define( 'TPL_START', '<?php echo' );
define( 'TPL_END',   '?>'  );

?>



<div id="wgt_progress_bar" style="display:none;position:absolute;left:50%;top:400px;" >
  <?php echo Wgt::image('wgt/loader.gif',array('alt'=>'progress'),true); ?>
</div>

<div id="wgt_template_container" style="display:none;" class="meta" >

  <div id="wgt_template_tab_container"  >
    <div class="wgt-container-controls">
      <div class="wgt-container-buttons"></div>
      <div class="tab_outer_container">
        <img class="tab_left" src="<?php echo View::$themeWeb?>images/wgt/tab_back.png" />
        <div class="tab_scroll" >
          <div class="tab_container" >&nbsp;</div>
        </div>
        <img class="tab_right" src="<?php echo View::$themeWeb?>images/wgt/tab_forward.png" />
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


