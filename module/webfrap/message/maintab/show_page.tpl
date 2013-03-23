<form 
  method="put"
  id="wgt-form-msg-show-save-<?php echo $VAR->msgNode->msg_id; ?>"
  action="ajax.php?c=Webfrap.Message.saveMessage&objid=<?php echo $VAR->msgNode->msg_id; ?>" ></form>

<div
  class="wgt-border-right"
  style="position:absolute;width:200px;top:0px;bottom:0px;left:0px;" >

  <div id="wgt-acc-show-msg-<?php echo $VAR->msgNode->msg_id; ?>"  >
  
    <h3><a href="data">Status</a></h3><!--0-->
    <div class="ac_body"  >
      
      <ul>
        <li>Status: </li>
        <li>Priority: </li>
        <li>Confidential: </li>
      </ul>
      
      <div id="wgt-mox-show-msg-task-<?php echo $VAR->msgNode->msg_id; ?>" >
        <div class="wgt-clear medium" >&nbsp;</div>
        <label class="topic" >Task</label>
        <ul>
          <li><label>Action Required?</label> <span>no</span></li>
          <li><label>Deadline?</label> <span>no</span></li>
          <li><label>Urgent?</label> <span>no</span></li>
          <li><label>Completed?</label> <span>yes</span></li>
        </ul>
      </div>
      
      <div id="wgt-mox-show-msg-appoint-<?php echo $VAR->msgNode->msg_id; ?>" >
        <div class="wgt-clear medium" >&nbsp;</div>
        <label class="topic" >Appointment</label>
        <ul>
          <li><label>Start</label> <span>no</span></li>
          <li><label>End</label> <span>no</span></li>
          <li><label>Location</label> <span>no</span></li>
        </ul>
      </div>
      
    </div>
  
    <h3><a href="checklist"  >Checklist</a></h3><!--1-->
    <div class="ac_body"  >
      <button class="wgt-button" ><i class="icon-plus-sign" ></i> Add Entry</button>
      <ul>
        <li></li>
      </ul>
    </div>

    <h3 id="" ><a href="shared">Shared</a></h3><!--2-->
    <div class="ac_body"  >
      <button class="wgt-button" ><i class="icon-plus-sign" ></i> Share</button>
      <ul>
        <li></li>
      </ul>
    </div>
    
    <h3><a href="history">History</a></h3><!--3-->
    <div class="ac_body"  >
      
    </div>
    

  </div>
  
</div>

<div
  style="position:absolute;top:0px;left:200px;right:0px;" class="wgt-panel hx2" >
  <div class="left bw3" >
    <label class="cl text" >Sender:</label> <div class="inline"><?php echo $VAR->msgNode->sender_name; ?></div>
    <label class="cl text" >Priority:</label> <div class="inline"><?php echo $VAR->msgNode->priority; ?></div>
    <label class="cl text" >Sended:</label> <div class="inline"><?php echo $this->i18n->timestamp( $VAR->msgNode->m_time_created );  ?></div>
  </div>
  <div class="inline bw12" >
    <div class="left"><input 
      type="radio"
      class="asgd-wgt-form-msg-show-save-<?php echo $VAR->msgNode->msg_id; ?>"
      id="wgt-inp-show-msg-asp-msg-<?php echo $VAR->msgNode->msg_id; ?>"
      <?php echo Wgt::checked(true, isset($VAR->msgNode->aspects[EMessageAspect::MESSAGE]));?>
      name="paspect"
      value="<?php echo EMessageAspect::MESSAGE ?>" /></div> <label class="inline text" >&nbsp;Message</label>
    <div class="left"><input 
      type="radio"
      class="asgd-wgt-form-msg-show-save-<?php echo $VAR->msgNode->msg_id; ?>"
      id="wgt-inp-show-msg-asp-notice-<?php echo $VAR->msgNode->msg_id; ?>"
      <?php echo Wgt::checked(true, isset($VAR->msgNode->aspects[EMessageAspect::NOTICE]));?>
      name="paspect"
      value="<?php echo EMessageAspect::NOTICE ?>" /></div> <label class="inline text" >&nbsp;Notice</label> 
    <div class="left"><input 
      type="radio"
      class="asgd-wgt-form-msg-show-save-<?php echo $VAR->msgNode->msg_id; ?>"
      id="wgt-inp-show-msg-asp-memo-<?php echo $VAR->msgNode->msg_id; ?>"
      <?php echo Wgt::checked(true, isset($VAR->msgNode->aspects[EMessageAspect::MEMO]));?>
      name="paspect"
      value="<?php echo EMessageAspect::MEMO ?>" /></div> <label class="inline text" >&nbsp;Memo</label> 
  </div>
  <div class="inline bw12" >
    <div class="left"><input 
      type="checkbox"
      class="asgd-wgt-form-msg-show-save-<?php echo $VAR->msgNode->msg_id; ?>"
      id="wgt-inp-show-msg-asp-appoint-<?php echo $VAR->msgNode->msg_id; ?>"
      <?php echo Wgt::checked(true, isset($VAR->msgNode->aspects[EMessageAspect::APPOINTMENT]));?>
      name="aspect[]"
      value="<?php echo EMessageAspect::APPOINTMENT ?>" /></div> <label class="inline text" >&nbsp;Appointment</label>
    <div class="left"><input 
      type="checkbox"
      class="asgd-wgt-form-msg-show-save-<?php echo $VAR->msgNode->msg_id; ?>"
      id="wgt-inp-show-msg-asp-task-<?php echo $VAR->msgNode->msg_id; ?>"
      <?php echo Wgt::checked(true, isset($VAR->msgNode->aspects[EMessageAspect::TASK]));?>
      name="aspect[]"
      value="<?php echo EMessageAspect::TASK ?>" /></div> <label class="inline text" >&nbsp;Task</label> 
    <div class="left"><input 
      type="checkbox"
      class="asgd-wgt-form-msg-show-save-<?php echo $VAR->msgNode->msg_id; ?>"
      id="wgt-inp-show-msg-asp-check-<?php echo $VAR->msgNode->msg_id; ?>"
      <?php echo Wgt::checked(true, isset($VAR->msgNode->aspects[EMessageAspect::CHECKLIST]));?>
      name="aspect[]"
      value="<?php echo EMessageAspect::CHECKLIST ?>" /></div> <label class="inline text" >&nbsp;Checklist</label> 
  </div>
  <div class="inline bw12" >
    <div class="left"><input 
      type="checkbox"
      class="asgd-wgt-form-msg-show-save-<?php echo $VAR->msgNode->msg_id; ?>"
      id="wgt-inp-show-msg-asp-disc-<?php echo $VAR->msgNode->msg_id; ?>"
      <?php echo Wgt::checked(true, isset($VAR->msgNode->aspects[EMessageAspect::DISCUSSION]));?>
      name="aspect[]"
      value="<?php echo EMessageAspect::DISCUSSION ?>" /></div> <label class="inline text" >&nbsp;Discussion</label> 
    <div class="left"><input 
      type="checkbox"
      class="asgd-wgt-form-msg-show-save-<?php echo $VAR->msgNode->msg_id; ?>"
      id="wgt-inp-show-msg-asp-shared-<?php echo $VAR->msgNode->msg_id; ?>"
      <?php echo Wgt::checked(true, isset($VAR->msgNode->aspects[EMessageAspect::SHARED_DOC]));?>
      name="aspect[]"
      value="<?php echo EMessageAspect::SHARED_DOC ?>" /></div> <label class="inline text" >&nbsp;Is Shared</label> 
  </div>
  
</div>

<!-- Mail Content -->
<div 
  class="wgt-border-bottom"
  style="position:absolute;top:60px;left:200px;right:200px;bottom:200px;" >
  <iframe
    src="plain.php?c=Webfrap.Message.showMailContent&objid=<?php echo $VAR->msgNode->msg_id; ?>"
    style="width:100%;min-height:400px;padding:0px;margin:0px;border:0px;" ></iframe>
</div>

<!-- Attchments & References -->
<div 
  class="wgt-border-left wgt-border-bottom" 
  style="position:absolute;width:200px;top:60px;right:0px;bottom:200px;" >
  <div class="wgt-panel" >
    <div class="left" ><h2>Attachments</h2></div>
    <div class="right" ><button 
      class="wgt-button wgac_add_attachment" ><i class="icon-plus-sign" ></i></button></div>
  </div>
  <div class="content hr15_25x wgt-space" >
    <ul 
      id="wgt-list-show-msg-attach-<?php echo $VAR->msgNode->msg_id; ?>"
      class="wgt-list" >
      
    </ul>
  </div>
  
  <div class="wgt-panel" >
    <div class="left" ><h2>References</h2></div>
    <div class="right" ><button 
      class="wgt-button wgac_add_reference"
      id="wgt-button-message-addref-<?php echo $VAR->msgNode->msg_id; ?>" ><i class="icon-plus-sign" ></i></button></div>
  </div>
  <div class="content hr15_25x wgt-space" >
    <ul 
      id="wgt-list-show-msg-ref-<?php echo $VAR->msgNode->msg_id; ?>"
      class="wgt-list" >
      <?php foreach( $VAR->refs as $ref ){  ?>
        <li id="wgt-entry-msg-ref-<?php echo $ref['link_id']; ?>" ><a 
          class="wcm wcm_req_ajax" 
          href="maintab.php?c=<?php echo $ref['edit_link']; ?>&objid=<?php echo $ref['vid']; ?>" 
          ><?php echo $ref['name']; ?>:<?php echo $ref['title']; ?></a><a 
          class="wcm wcm_req_del" 
          title="Please confirm you want to delete this reference."
          href="ajax.php?c=Webfrap.Message.delRef&delid=<?php echo $ref['link_id']; ?>"  ><i class="icon-remove" ></i></a></li>
      <?php } ?>
    </ul>
  </div>
</div>

<!-- Unten -->
<div 
  class="wgt-space" 
  style="position:absolute;height:400px;left:200px;right:200px;bottom:0px;" >
 
<div style="position:relative" >
  <textarea id="huba" name="bar" class="wcm wcm_ui_wysiwyg" style="width:500px;height:170px;" ></textarea>
</div>

</div>

<?php $this->openJs(); ?><script>

$S('#wgt-button-message-addref-<?php echo $VAR->msgNode->msg_id; ?>').on('connect',function(event,id){
  $R.put('ajax.php?c=Webfrap.Message.addRef&msg=<?php echo $VAR->msgNode->msg_id; ?>&ref='+id);
});

self.getObject().find(".wgac_add_attachment").click( function(){
  $R.get( 'modal.php?c=Webfrap.Attachment_Connector.create&con=Webfrap.Message.connectAttachment&cbe=wgt-button-message-addattch-<?php echo $VAR->msgNode->msg_id; ?>&refid=<?php echo $VAR->msgNode->msg_id; ?>' );
});

self.getObject().find(".wgac_add_reference").click( function(){
  $R.get( 'modal.php?c=Webfrap.DataConnector.selection&con=Webfrap.Message.connectDset&cbe=wgt-button-message-addref-<?php echo $VAR->msgNode->msg_id; ?>&dset=<?php echo $VAR->msgNode->msg_id; ?>' );
});

self.getObject().find("#wgt-acc-show-msg-<?php echo $VAR->msgNode->msg_id; ?>").accordion({autoHeight: true,fillSpace: true,animated: false, icons:null});

var accConts = self.getObject().find("#wgt-acc-show-msg-<?php echo $VAR->msgNode->msg_id; ?>" ).find('.ui-accordion-content');

/*Shared checklist*/
if(!self.getObject().find("#wgt-inp-show-msg-asp-check-<?php echo $VAR->msgNode->msg_id; ?>").change( function(){
  $S('#ui-accordion-wgt-acc-show-msg-<?php echo $VAR->msgNode->msg_id; ?>-header-1').toggle();
  if($S(this).is(':checked')){
    accConts.subHeight(28);
  } else {
    accConts.addHeight(28);
  }
}).is(':checked')){
  self.getObject().find('#ui-accordion-wgt-acc-show-msg-<?php echo $VAR->msgNode->msg_id; ?>-header-1').hide();
  accConts.addHeight(28);
};

/*Shared docs*/
if(!self.getObject().find("#wgt-inp-show-msg-asp-shared-<?php echo $VAR->msgNode->msg_id; ?>").change( function(){
  $S('#ui-accordion-wgt-acc-show-msg-<?php echo $VAR->msgNode->msg_id; ?>-header-3').toggle();
  if($S(this).is(':checked')){
    accConts.subHeight(28);
  } else {
    accConts.addHeight(28);
  }
}).is(':checked')){
  self.getObject().find('#ui-accordion-wgt-acc-show-msg-<?php echo $VAR->msgNode->msg_id; ?>-header-3').hide();
  accConts.addHeight(28);
};

/*IS Task*/
if(!self.getObject().find("#wgt-inp-show-msg-asp-task-<?php echo $VAR->msgNode->msg_id; ?>").change( function(){
  $S('#wgt-mox-show-msg-task-<?php echo $VAR->msgNode->msg_id; ?>').toggle();
 
}).is(':checked')){
  self.getObject().find('#wgt-mox-show-msg-task-<?php echo $VAR->msgNode->msg_id; ?>').hide();
};

/*IS Appointment*/
if(!self.getObject().find("#wgt-inp-show-msg-asp-appoint-<?php echo $VAR->msgNode->msg_id; ?>").change( function(){
  $S('#wgt-mox-show-msg-appoint-<?php echo $VAR->msgNode->msg_id; ?>').toggle();
 
}).is(':checked')){
  self.getObject().find('#wgt-mox-show-msg-appoint-<?php echo $VAR->msgNode->msg_id; ?>').hide();
};

</script><?php $this->closeJs(); ?>
