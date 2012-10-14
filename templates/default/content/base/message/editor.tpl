<div class="contentArea" >


  <div  class="wgt-clear medium">&nbsp;</div>

  <form id="wgt-form-radomid">

    <div class="left full" >

      <div class="wgt_box" >
        <label class="wgt-label" >recipient</label>
        <div class="wgt-input big" ><input type="text" class="huge" /></div>
      </div>
      <div class="wgt_box" >
        <label class="wgt-label" >title</label>
        <div class="wgt-input big" ><input type="text" class="huge" /></div>
      </div>

    </div>

    <div class="left full" >
      <textarea id="needed_id" class="full wcm wcm_ui_wysiwyg" style="height:400px;" ></textarea>
    </div>

  </form>

</div>

<div class="wgt-clear medium">&nbsp;</div>

<script type="text/javascript">
<% foreach( $this->jsItems as $jsItem ){ %>
  <%=$ITEM->$jsItem->jsCode%>
<% } %>
</script>