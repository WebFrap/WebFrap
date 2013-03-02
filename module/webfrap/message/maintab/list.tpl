<form
  method="get"
  accept-charset="utf-8"
  id="wgt-form-webfrap-groupware-search"
  action="ajax.php?c=Webfrap.Message.searchList" ></form>

<div
  class="wgt-border-right"
  style="position:absolute;width:200px;top:0px;bottom:0px;left:0px;" >
  <div class="wgt-panel" ><button class="wgt-button wgtac_refresh" ><i class="icon-filter" ></i> Filter</button></div>
  <div id="wgt-tree-message-navigation" >
    <ul id="wgt-tree-message-navigation-tree" class="wgt-tree wgt-space" >
      <li><input
        type="checkbox"
        checked="checked"
        name="channel[inbox]"
        class="fparam-wgt-form-webfrap-groupware-search" /> <a><strong>Inbox</strong></a> /
        <input
          type="checkbox"
          name="channel[outbox]"
          class="fparam-wgt-form-webfrap-groupware-search" /> <a><strong>Outbox</strong></a>
        <ul>
          <li><input
            type="checkbox"
            checked="checked" /> All Posts
            <ul>
              <li><input
                type="checkbox"
                name="status[new]"
                class="fparam-wgt-form-webfrap-groupware-search"  /> Only New Posts</li>
              <li><input
                type="checkbox"
                name="status[important]"
                class="fparam-wgt-form-webfrap-groupware-search" /> Only Important Posts</li>
              <li><input
                type="checkbox"
                name="status[urgent]"
                class="fparam-wgt-form-webfrap-groupware-search" /> Only Urgent Posts</li>
              <li><input
                type="checkbox"
                name="status[overdue]"
                class="fparam-wgt-form-webfrap-groupware-search" /> Only Overdue Posts</li>
            </ul>
          </li>

          <li><input
            type="checkbox"
            name="type[message]"
            class="fparam-wgt-form-webfrap-groupware-search" /> Messages</li>
          <li><input
            type="checkbox"
            name="type[notice]"
            class="fparam-wgt-form-webfrap-groupware-search" /> Notices</li>
          <li><input
            type="checkbox"
            name="type[memo]"
            class="fparam-wgt-form-webfrap-groupware-search" /> Memos</li>
          <li><input
            type="checkbox"
            name="type[appointment]"
            class="fparam-wgt-form-webfrap-groupware-search" /> Appointments</li>
          <li><input
            type="checkbox"
            name="type[shared_doc]"
            class="fparam-wgt-form-webfrap-groupware-search" /> Shared Docs</li>
          <li><input
            type="checkbox"
            name="type[task]"
            class="fparam-wgt-form-webfrap-groupware-search" /> Tasks
            <ul>
              <li><input
                type="checkbox" /> Action Required</li>
              <li><input
                type="checkbox" /> Completed</li>
            </ul>
          </li>
        </ul>
      </li>
      <li><a href="" ><strong>Drafts</strong></a></li>
      <li><a><strong>Templates</strong></a>
        <ul>
          <li><button class="wgt-button" ><i class="icon-plus-sign" ></i> Create Template</button></li>
        </ul>
      </li>
      <li><input
        type="checkbox"
        name="channel[archive]"
        class="fparam-wgt-form-webfrap-groupware-search" /> <a><strong>Archiv</strong></a></li>
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
