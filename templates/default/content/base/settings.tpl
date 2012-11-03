<div class="contentArea" >

    <!-- Tab Details -->
    <div class="window_tab" id="wgt_window_tab_wbfprofile_settings" title="settings"  >

      <fieldset class="nearly_full" >
        <legend>private settings</legend>


        <div class="wgt-clear small">&nbsp;</div>
      </fieldset>

    </div>


    <div class="window_tab" id="wgt_window_tab_wbfprofile_desktop" title="desktop"  >

      <fieldset class="nearly_full" >
        <legend>desktop settings</legend>


        <div class="wgt-clear small">&nbsp;</div>
      </fieldset>

    </div>


    <div class="window_tab" id="wgt_window_tab_wbfprofile_project_colors" title="colors"  >

      <fieldset class="nearly_full" >
        <legend>color scheme</legend>

        <div class="wgt-clear small">&nbsp;</div>
      </fieldset>

    </div>


    <div class="wgt-clear medium">&nbsp;</div>

</div>

<div class="wgt-clear medium">&nbsp;</div>

<script type="application/javascript">
<% foreach( $this->jsItems as $jsItem ){ %>
  <%=$ITEM->$jsItem->jsCode%>
<% } %>
</script>