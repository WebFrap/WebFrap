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
            type="checkbox"
            name="aspect[]"
            value="<?php echo EMessageAspect::MESSAGE ?>"
            <?php echo Wgt::checked(true, in_array( EMessageAspect::MESSAGE,$VAR->settings->aspects) )?>
            class="fparam-wgt-form-webfrap-groupware-search"
            /> Messages <a class="wgt-mini-button" ><i class="icon-plus-sign" ></i> add</a></li>
          <li><input
            type="checkbox"
            name="aspect[]"
            value="<?php echo EMessageAspect::DOCUMENT ?>"
            <?php echo Wgt::checked(true, in_array( EMessageAspect::DOCUMENT,$VAR->settings->aspects) )?>
            class="fparam-wgt-form-webfrap-groupware-search"
            /> Document <a class="wgt-mini-button" ><i class="icon-plus-sign" ></i> add</a></li>
          <li><input
            type="checkbox"
            name="aspect[]"
            value="<?php echo EMessageAspect::DISCUSSION ?>"
            <?php echo Wgt::checked(true, in_array( EMessageAspect::DISCUSSION,$VAR->settings->aspects) )?>
            class="fparam-wgt-form-webfrap-groupware-search"
            /> Discussion <a class="wgt-mini-button" ><i class="icon-plus-sign" ></i> add</a></li>
          <li><input
            type="checkbox"
            name="aspect[]"
            value="<?php echo EMessageAspect::APPOINTMENT ?>"
            <?php echo Wgt::checked(true, in_array( EMessageAspect::APPOINTMENT,$VAR->settings->aspects) )?>
            class="fparam-wgt-form-webfrap-groupware-search"
            /> Appointments</li>
          <li><input
            type="checkbox"
            name="aspect[]"
            value="<?php echo EMessageAspect::SHARED ?>"
            <?php echo Wgt::checked(true, in_array( EMessageAspect::SHARED,$VAR->settings->aspects) )?>
            class="fparam-wgt-form-webfrap-groupware-search"
            /> Shared</li>
          <li><input
            type="checkbox"
            name="aspect[]"
            value="<?php echo EMessageAspect::CHECKLIST ?>"
            <?php echo Wgt::checked(true, in_array( EMessageAspect::CHECKLIST,$VAR->settings->aspects) )?>
            class="fparam-wgt-form-webfrap-groupware-search"
            /> Checklist</li>
          <li><input
            type="checkbox"
            name="aspect[]"
            value="<?php echo EMessageAspect::TASK ?>"
            <?php echo Wgt::checked(true, in_array( EMessageAspect::TASK,$VAR->settings->aspects) )?>
            class="fparam-wgt-form-webfrap-groupware-search"
            /> Tasks </li>
            
        </ul>
      </li>
      
      <li><input
        type="checkbox"
        <?php echo Wgt::checked(true, isset($VAR->settings->channels->unsolicited) )?>
        name="channel[unsolicited]"
        class="fparam-wgt-form-webfrap-groupware-search" /> <a><strong>Unsolicited</strong></a></li>
      <li><input
        type="checkbox"
        <?php echo Wgt::checked(true, isset($VAR->settings->channels->draft) )?>
        name="channel[draft]"
        class="fparam-wgt-form-webfrap-groupware-search" /> <a><strong>Drafts</strong></a></li>
        <!--  
      <li><a href="#" ><strong>Templates</strong></a>
        <ul>
          <li><button class="wgt-button" ><i class="icon-plus-sign" ></i> Create Template</button></li>
        </ul>
      </li>-->
      <li><input
        type="checkbox"
        <?php echo Wgt::checked(true, isset($VAR->settings->channels->archive) )?>
        name="channel[archive]"
        class="fparam-wgt-form-webfrap-groupware-search" /> <a><strong>Archiv</strong></a>
      </li>
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
    <div class="wgt-panel" ><h2><?php $VAR->message->title ?></h2></div>
    <div class="wgt-panel hx2"  >
      Sender: <?php $VAR->message->sender_name ?><br />
      Date: <?php $VAR->message->receiver_name ?><br />
      To: <?php $VAR->message->receiver_name ?><br />
    </div>
    <div class="full" >
      <iframe
        src="plain.php?c=Webfrap.Message.showMailContent&objid=<?php echo $VAR->message->msg_id; ?>"
        style="width:100%;min-height:300px;padding:0px;margin:0px;border:0px;" ></iframe>
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
