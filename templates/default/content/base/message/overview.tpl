<div class="contentArea" >


  <!-- Tab Inbox -->
  <div class="window_tab" id="wgt_window_tab_wbfmessage_inbox" title="Inbox"  >

    <fieldset class="nearly_full" >
      <legend>Inbox</legend>

      <%=$ITEM->messageInbox%>

    </fieldset>

  </div>

  <!-- Tab Outbox -->
  <div class="window_tab" id="wgt_window_tab_wbfmessage_outbox" title="Outbox"  >

    <fieldset class="nearly_full" >
      <legend>Outbox</legend>

      <%=$ITEM->messageOutbox%>

    </fieldset>

  </div>

</div>

  <div class="wgt-clear medium">&nbsp;</div>

<script type="text/javascript">
<% foreach( $this->jsItems as $jsItem ){ %>
  <%=$ITEM->$jsItem->jsCode%>
<% } %>
</script>