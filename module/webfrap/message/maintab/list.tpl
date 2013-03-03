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
        <?php echo Wgt::checked(true, isset($VAR->settings->channels->inbox) )?>
        name="channel[inbox]"
        class="fparam-wgt-form-webfrap-groupware-search" /> <a><strong>Inbox</strong></a> /
        <input
          type="checkbox"
          <?php echo Wgt::checked(true, isset($VAR->settings->channels->outbox) )?>
          name="channel[outbox]"
          class="fparam-wgt-form-webfrap-groupware-search" /> <a><strong>Outbox</strong></a>
        <ul>
          <li><input
            type="checkbox" /> All Posts
            <ul>
              <li><input
                type="checkbox"
                name="status[new]"
                <?php echo Wgt::checked(true, isset($VAR->settings->status->new) )?>
                class="fparam-wgt-form-webfrap-groupware-search"  /> Only New Posts</li>
              <li><input
                type="checkbox"
                name="status[important]"
                <?php echo Wgt::checked(true, isset($VAR->settings->status->important) )?>
                class="fparam-wgt-form-webfrap-groupware-search" /> Only Important Posts</li>
              <li><input
                type="checkbox"
                name="status[urgent]"
                <?php echo Wgt::checked(true, isset($VAR->settings->status->urgent) )?>
                class="fparam-wgt-form-webfrap-groupware-search" /> Only Urgent Posts</li>
              <li><input
                type="checkbox"
                name="status[overdue]"
                <?php echo Wgt::checked(true, isset($VAR->settings->status->overdue) )?>
                class="fparam-wgt-form-webfrap-groupware-search" /> Only Overdue Posts</li>
            </ul>
          </li>

          <li><input
            type="checkbox"
            name="aspect[]"
            value="<?php echo EMessageAspect::MESSAGE ?>"
            <?php echo Wgt::checked(true, in_array( EMessageAspect::MESSAGE,$VAR->settings->aspects) )?>
            class="fparam-wgt-form-webfrap-groupware-search"
            /> Messages <a class="wgt-mini-button" ><i class="icon-plus-sign" ></i> add</a></li>
          <li><input
            type="checkbox"
            name="aspect[]"
            value="<?php echo EMessageAspect::NOTICE ?>"
            <?php echo Wgt::checked(true, in_array( EMessageAspect::NOTICE,$VAR->settings->aspects) )?>
            class="fparam-wgt-form-webfrap-groupware-search"
            /> Notices <a class="wgt-mini-button" ><i class="icon-plus-sign" ></i> add</a></li>
          <li><input
            type="checkbox"
            name="aspect[]"
            value="<?php echo EMessageAspect::MEMO ?>"
            <?php echo Wgt::checked(true, in_array( EMessageAspect::MEMO,$VAR->settings->aspects) )?>
            class="fparam-wgt-form-webfrap-groupware-search"
            /> Memos <a class="wgt-mini-button" ><i class="icon-plus-sign" ></i> add</a></li>
          <li><input
            type="checkbox"
            name="aspect[]"
            value="<?php echo EMessageAspect::APPOINTMENT ?>"
            <?php echo Wgt::checked(true, in_array( EMessageAspect::APPOINTMENT,$VAR->settings->aspects) )?>
            class="fparam-wgt-form-webfrap-groupware-search"
            /> Appointments <a class="wgt-mini-button" ><i class="icon-plus-sign" ></i> add</a></li>
          <li><input
            type="checkbox"
            name="aspect[]"
            value="<?php echo EMessageAspect::SHARED_DOC ?>"
            <?php echo Wgt::checked(true, in_array( EMessageAspect::SHARED_DOC,$VAR->settings->aspects) )?>
            class="fparam-wgt-form-webfrap-groupware-search"
            /> Shared Docs <a class="wgt-mini-button" ><i class="icon-plus-sign" ></i> add</a></li>
          <li><input
            type="checkbox"
            name="aspect[]"
            value="<?php echo EMessageAspect::TASK ?>"
            <?php echo Wgt::checked(true, in_array( EMessageAspect::TASK,$VAR->settings->aspects) )?>
            class="fparam-wgt-form-webfrap-groupware-search"
            /> Tasks <a class="wgt-mini-button" ><i class="icon-plus-sign" ></i> add</a>
            <ul>
              <li><input
                type="checkbox"
                name="task_action[required]"
                <?php echo Wgt::checked(true, isset($VAR->settings->taskAction->required) )?>
                class="fparam-wgt-form-webfrap-groupware-search"
                /> Action Required</li>
              <li><input
                type="checkbox"
                name="task_action[completed]"
                <?php echo Wgt::checked(true, isset($VAR->settings->taskAction->completed) )?>
                class="fparam-wgt-form-webfrap-groupware-search"
                 /> Completed</li>
            </ul>
          </li>
        </ul>
      </li>
      <li><a href="#" ><strong>Drafts</strong></a></li>
      <li><a href="#" ><strong>Templates</strong></a>
        <ul>
          <li><button class="wgt-button" ><i class="icon-plus-sign" ></i> Create Template</button></li>
        </ul>
      </li>
      <li><input
        type="checkbox"
        <?php echo Wgt::checked(true, isset($VAR->settings->channels->archive) )?>
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
      <?php var_dump( $VAR->settings->channel )?>
    </div>
    <?php } ?>
  </div>

</div>
