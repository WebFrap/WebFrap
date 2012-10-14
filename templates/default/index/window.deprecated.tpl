<?php 

define( 'TPL_START', '<?php echo' );
define( 'TPL_END',   '?>'  );

?>

<?php /*
<div id="window_container" style="position:absolute;left:0;top:0;width:1px;height:1px;z-index:12;"></div>
*/?>

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

<?php /*
  <div id="defaultTemplate" class="wgt_window template window ui-corner-all" >
    <div class="wgt_middle window_scroll" >

      <div class="wgt_header header">
      <!-- ####### Start: Window Header ####### -->
        <h1 class="template move"></h1>

        <div style="white-space: nowrap" class="context_info">
          <h2 class="template"></h2>
          <span class="template"><span></span></span></div>

        <div class="template banner"></div>
        <div class="wgt_tab_container wgt_initialized">
        <div class="wgt-container-controls">
          <div class="wgt-container-buttons">
            <button class="standard template"></button>
          </div>
          <div class="tab_outer_container">
            <!--  <img class="tab_left" src="<?php echo View::$themeWeb?>images/wgt/tab_back.png" /> -->
            <div class="tab_scroll">
              <div class="tab_container">
              &nbsp;
                <span class="template tab ui-corner-top" >
                  <span class="label" ><a></a></span>
                </span>
              </div>
            </div>
            <!--  <img class="tab_right" src="<?php echo View::$themeWeb?>images/wgt/tab_forward.png" /> -->
          </div>
         </div>
        </div>
        <div class="tab_extender template"></div>

      <!-- #######  End: Window Header ####### -->
      </div>



      <div class="content">
      <!-- #######  Start: Window Content ####### -->

      <!-- #######  End: Window Content ####### -->
      </div>

      <div class="wgt_window wgt-window-layer loading"></div>
      <div class="wgt_frame_1 move dblclick_minmax ui-widget-header"></div>
      <div class="wgt_frame_0 resize_n"></div>
      <div class="wgt_frame_4 resize_s"><span class="status template" ></span></div>

    </div>

    <div class="wgt_left">
      <div class="wgt_frame_0 resize_w"></div>
      <div class="wgt_frame_2 resize_w"></div>
      <div class="wgt_frame_3 resize_w"></div>
      <div class="wgt_frame_1 resize_nw"></div>
      <div class="wgt_frame_4 resize_sw"></div>
    </div>

    <div class="wgt_right">
      <div class="wgt_frame_0 resize_e"></div>
      <div class="wgt_frame_2 resize_e"></div>
      <div class="wgt_frame_3 resize_e"></div>
      <div class="wgt_frame_1 resize_ne"></div>
      <div class="wgt_frame_4 resize_se"></div>
    </div>

    <div class="wgt_head_left" >
      <span class="title template" ></span>
    </div>

    <div class="wgt_head_right" >
      <img class="button wgtac_max"   src="<?php echo View::$themeWeb?>images/wgt/win_max.png"   alt="max" />
      <img class="button wgtac_close" src="<?php echo View::$themeWeb?>images/wgt/win_close.png" alt="close" />
    </div>

    <div class="wgt-window-layer inactive"></div>
  </div>
  */?>



  <!--
  <div id="wgt_template_tab_head" >
    <span class="tab" >
      <span>&nbsp;</span>
      <span class="label" ><a></a></span>
    </span>
  </div>
  -->

  <div id="wgtidFileUpload" class="meta" >
    <iframe id="wgtidFrameUpload" name="fileUpload" ></iframe>
  </div>
  <!--
    <img src="<?php echo View::$themeWeb ?>images/wgt/clipboard.png" class="meta" id="clipboardIcon"/>
  -->
  
  <script type="text/html" id="categorytemplate">
  <li id="<?php echo TPL_START  ?> id <?php echo TPL_END ?>" class="selectcategory"><button><?php echo TPL_START  ?> title <?php echo TPL_END ?> (<?php echo TPL_START  ?> amount <?php echo TPL_END ?>)</button></li>
  </script>
  
  
  <script type="text/html" id="widgettemplate">
  <div class="ui-widget ui-corner-all ui-widget-content widget" id="<?php echo TPL_START  ?> id <?php echo TPL_END ?>" title="<?php echo TPL_START  ?> title <?php echo TPL_END ?>">
    <div class="ui-widget-header ui-corner-all widgetheader">
      <span class="widgettitle"><?php echo TPL_START  ?> title <?php echo TPL_END ?></span>
      <span class="right icons hidden">
        <span class="ui-icon ui-icon-newwin widgetopenfullscreen"></span>
        <span class="ui-icon ui-icon-arrowthickstop-1-s menutrigger"></span>
        <span class="hiddenmenu">
          <ul style="top: 13px;" class="hidden controls ui-widget-header">
            <li class="widgetClose">
              <span class="ui-icon ui-icon-minus"></span>
              <a class="minimization" href="#">Minimize</a>
            </li>
            <li class="widgetOpen">
              <span class="ui-icon ui-icon-extlink"></span>
              <a class="minimization" href="#">Maximize</a>
            </li>
            <li class="widgetDelete">
              <span class="ui-icon ui-icon-close"></span>
              <a class="delete" href="#">Delete</a>
            </li>
            <!-- This could be implemented -->
            <!--
            <li class="widgetEdit">
              <span class="ui-icon ui-icon-tag"></span>
              <a class="no_target" href="#">Edit</a>
            </li>
            -->
            <li class="widgetRefresh">
              <span class="ui-icon ui-icon-arrowrefresh-1-w"></span>
              <a class="no_target" href="#">Refresh</a>
            </li>
          </ul>
        </span>
      </span>
    </div>
    <div class="widgetcontent">
    </div>
  </div>
  </script>
  
  <script type="text/html" id="selectlayouttemplate">
  <li class="layoutchoice" id="<?php echo TPL_START  ?> id <?php echo TPL_END ?>" style="background-image: url('<?php echo TPL_START  ?> image <?php echo TPL_END ?>')"></li>
  </script>
  
  <script type="text/html" id="addwidgettemplate">

  <li class="widgetitem">
    <img src="<?php echo TPL_START  ?> image <?php echo TPL_END ?>" alt="" height="60" width="120">
    <div class="add-button">
        <input class="macro-button-add addwidget" id="addwidget<?php echo TPL_START  ?> id <?php echo TPL_END ?>" value="Add it Now" type="button"><br>
        <input class="macro-hidden-uri" value="<?php echo TPL_START  ?> url <?php echo TPL_END ?>" type="hidden">
    </div>
    <!-- // .add-button -->
    <h3><a href=""><?php echo TPL_START  ?> title <?php echo TPL_END ?></a></h3>

    <p>By <?php echo TPL_START  ?> creator <?php echo TPL_END ?></p>
    <p><?php echo TPL_START  ?> description <?php echo TPL_END ?></p>
  </li>

  </script>

  <div class="dialog" id="addwidgetdialog" title="Widget Directory">
    <ul class="categories">
    </ul>
  
    <div class="panel-body">
      <ol id="category-all" class="widgets">
      </ol>
    </div>
  </div>
  
  
  <div class="dialog" id="editLayout" title="Edit layout">
    <div class="panel-body" id="layout-dialog">
        <p><strong>Choose dashboard layout</strong></p>
        <ul class="layoutselection">
        </ul>
    </div>
  </div>


</div>

<div id="wgt_data_container" class="meta" ></div>
<div id="wgt_tmp_container" class="meta" ></div>
<div id="wgt_context_container"  ></div>


