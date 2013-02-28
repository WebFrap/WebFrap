<form
  method="get"
  accept-charset="utf-8"
  id="wgt-form-my_message-search"
  action="ajax.php?c=Webfrap.Message.searchList" ></form>

<div
  class="wgt-border-right"
  style="position:absolute;width:200px;top:0px;bottom:0px;left:0px;" >
  <div class="wgt-panel" ><button class="wgt-button" ><i class="icon-filter" ></i> Auswahl anzeigen</button></div>
  <div id="wgt-tree-message-navigation" >
    <ul id="wgt-tree-message-navigation-tree" class="wgt-tree wgt-space" >
      <li><input
        type="checkbox"
        class="fparam-wgt-form-my_message-search" /> <a><strong>Inbox</strong></a>
        <ul>
          <li><input
            type="checkbox" /> All Messages</li>
          <li><input
            type="checkbox" /> New Messages</li>
          <li><input
            type="checkbox" /> Info Message</li>
          <li><input
            type="checkbox" /> Action Required</li>
          <li><input
            type="checkbox" /> Completed</li>
        </ul>
      </li>
      <li><input type="checkbox" /> <a><strong>Outbox</strong></a>
        <ul>
          <li><input type="checkbox" /> All Messages</li>
          <li><input type="checkbox" /> Not yet readed</li>
          <li><input type="checkbox" /> Info Message</li>
          <li><input type="checkbox" /> Awaiting Action</li>
          <li><input type="checkbox" /> Completed</li>
        </ul>
      </li>
      <li><a><strong>Drafts</strong></a></li>
      <li><a><strong>Templates</strong></a>
        <ul>
          <li><button class="wgt-button" ><i class="icon-plus-sign" ></i> Create Template</button></li>
        </ul>
      </li>
      <li><input type="checkbox" /> <a><strong>Archiv</strong></a></li>
    </ul>
  </div>
</div>

<div id="wgt-message-list-content" >

  <div id="wgt-message-list-message_list" style="position:absolute;top:0px;left:200px;right:0px;height:360px;" >
  	<?php echo $ELEMENT->messageList; ?>
  </div>

  <div
    id="wgt-message-list-show_messagebox" style="position:absolute;top:360px;bottom:0px;left:200px;right:0px;" >
    <?php if( $VAR->message ){ ?>
    <div class="wgt-panel" ><h2>Super duper</h2></div>
    <div class="wgt-panel hx2"  >
      Sender: <br />
      Date: <br />
      To: <br />
    </div>
    <div class="full" >
      Content
    </div>
    <?php } else { ?>
    <div class="wgt-panel" ><h2>No Message selected</h2></div>
    <div class="wgt-panel hx2"  >
    </div>
    <div class="full" >

    </div>
    <?php } ?>
  </div>

</div>
