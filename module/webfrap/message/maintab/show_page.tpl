<?php 

$sForm = new WgtFormBuilderElements(
  $this,
  'ajax.php?c=Webfrap.Message.saveMessage&objid='.$VAR->msgNode->msg_id,
  'msg-show-save-'.$VAR->msgNode->msg_id,
  'put'
);


$selectMessageTaskStatus = new WebfrapMessageTaskStatus_Selectbox($this);
$selectMessageTaskStatus->addAttributes(array(
  'name' => 'task[status]',
  'class' => $sForm->dKey,
));

$apointCategory = $sForm->loadQuery( 'WbfsysAppointmentCategory_Selectbox' );
$apointCategory->fetchSelectbox();

// ausgabe

$sForm->form();

$sForm->hidden('task_id', $VAR->msgNode->task_id); 
$sForm->hidden('appoint_id', $VAR->msgNode->appoint_id); 
$sForm->hidden('receiver_id', $VAR->msgNode->receiver_id); 

?>

<div
  class="wgt-border-right"
  style="position:absolute;width:200px;top:0px;bottom:0px;left:0px;" >

  <div id="wgt-acc-show-msg-<?php echo $VAR->msgNode->msg_id; ?>"  >
  
    <h3><a href="data">Status</a></h3><!--0-->
    <div class="ac_body np"  >
      
      <ul class="wgt-list wgt-space" >
        <li><label>Status:</label> <span><?php echo EMessageStatus::label($VAR->msgNode->receiver_status); ?></span></li>
        <li><label>Priority:</label> <span><?php echo EMessagePriority::label($VAR->msgNode->priority/10); ?></span></li>
        <li><label>Confidential:</label> <span><?php echo EWbfsysConfidential::label($VAR->msgNode->confidential); ?></span></li>
      </ul>

      <div id="wgt-mox-show-msg-task-<?php echo $VAR->msgNode->msg_id; ?>" >
        <div class="wgt-clear small" >&nbsp;</div>
        <div class="wgt-panel" ><h2>Task</h2></div>
        <ul class="wgt-list kv wgt-space" >
          <li><label>Status:</label> <span><?php $sForm->selectboxByKey(null,
          		'task[status]', 
          		'WebfrapMessageTaskStatus_Selectbox', 
            EMessageTaskStatus::$labels,
            $VAR->msgNode->task_status
          ); ?></span></li>
          <li><label>Deadline:</label> <p><input 
            type="text" 
            name="task[deadline]"
            value="<?php echo $VAR->msgNode->task_deadline; ?>"
            class="wcm wcm_ui_date_timepicker medium <?php echo $sForm->dKey ?>" /></p></li>
          <li><label>Your Action required:</label> <span><input 
            type="checkbox"
            name="receiver[action_required]"
            <?php echo Wgt::checked('t', $VAR->msgNode->flag_action_required) ?>
            class="<?php echo $sForm->dKey ?>" /></span></li>
          <li><label>Urgent:</label> <span><input 
            type="checkbox"
            name="task[urgent]"
            <?php echo Wgt::checked('t', $VAR->msgNode->task_urgent) ?>
            class="<?php echo $sForm->dKey ?>" /></span></li>
        </ul>
      </div>
      
      <div id="wgt-box-show-msg-appoint-<?php echo $VAR->msgNode->msg_id; ?>" >
        <div class="wgt-clear small" >&nbsp;</div>
        <div class="wgt-panel" ><h2>Appointment</h2></div>
        <ul class="wgt-list kv wgt-space" >
          <li><label>Category:</label> <span><?php $sForm->selectboxByKey(null,
          		'appointment[category]', 
          		'WbfsysAppointmentCategory_Selectbox', 
            $apointCategory->getAll(),
            $VAR->msgNode->appoint_category
          ); ?></span></li>
          <li><label>Start:</label> <span><input 
            type="text" 
            name="appointment[start]"
            value="<?php echo $VAR->msgNode->appoint_start  ?>"
            class="wcm wcm_ui_date_timepicker small <?php echo $sForm->dKey ?>" /></span></li>
          <li><label>End:</label> <span><input 
            type="text" 
            name="appointment[end]"
            value="<?php echo $VAR->msgNode->appoint_end  ?>"
            class="wcm wcm_ui_date_timepicker small <?php echo $sForm->dKey ?>" /></span></li>
          <li><label>Full Day:</label> <span><input 
            type="checkbox" 
            name="appointment[all_day]"
            <?php echo Wgt::checked('t', $VAR->msgNode->appoint_all_day) ?>
            class="<?php echo $sForm->dKey ?>"
            /></span></li>
          <li><label>Part. required:</label> <span><input 
            type="checkbox"
            name="receiver[part_required]"
            <?php echo Wgt::checked('t', $VAR->msgNode->flag_participation_required) ?>
            class="<?php echo $sForm->dKey ?>"  /></span></li>
          <li><label>Location:</label><p><textarea 
            class="medium <?php echo $sForm->dKey ?>" 
            name="appointment[location]"
            style="width:190px;" ><?php echo htmlentities($VAR->msgNode->appoint_location); ?></textarea></p></li>
          
        </ul>
      </div>
      
    </div>
  
    <h3><a href="checklist"  >Checklist</a></h3><!--1-->
    <div class="ac_body np"  >
      <div id="wgt-kvl-msg-checklist-<?php echo $VAR->msgNode->msg_id; ?>" class="wcm wcm_widget_kvlist" >
        <var id="wgt-kvl-msg-checklist-<?php echo $VAR->msgNode->msg_id; ?>-kvl-cfg" >{
          "save_form":"<?php echo $sForm->id ?>",
          "edit_able":true,
          "allow_insert": false
        }</var>
        <ul class="wgt-list kv wgt-space editor" >
          <li><p><input 
            type="text"
            class="inp_label"
            style="width:165px;" 
            class="wgt-border" ></p><span><i 
              class="icon-plus-sign" ></i></span>
          </li>
          <li 
            id="wgt-kvl-msg-checklist-<?php echo $VAR->msgNode->msg_id; ?>-{$id}" 
            eid="" 
            class="template" ><p 
              class="kvlac_del" ><i class="icon-remove" ></i></p><span><input 
                name="checklist[{$id}][value]" type="checkbox" /></span><span 
                  style="width:145px;" 
                  name="checklist[{$id}][label]"
                  class="editable" ></span></li>
        </ul>
        <ul class="wgt-list kv wgt-space content" >
          <li 
            id="wgt-kvl-msg-checklist-<?php echo $VAR->msgNode->msg_id; ?>-1" 
            eid="1" ><p><input 
              name="checklist[1][value]" 
              type="checkbox" /></p><span
                class="kvlac_del"><i class="icon-remove" ></i></span><span 
                  style="width:145px;" 
                  name="checklist[1][label]"
                  class="editable" >Full Day</span></li>
        </ul>
      </div>
    </div>

    <h3 id="" ><a href="shared">Participants</a></h3><!--2-->
    <div class="ac_body np"  >
      <button class="wgt-button" ><i class="icon-plus-sign" ></i> Share</button>

      <ul class="wgt-list kv wgt-space">
        <li><label>Full Day:</label> <span><input type="checkbox" /></span></li>
      </ul>
    </div>
    
    <h3><a href="history">History</a></h3><!--3-->
    <div class="ac_body np"  >
      
    </div>
    

  </div>
  
</div>

<div
  style="position:absolute;top:0px;left:200px;right:0px;" class="wgt-panel hx2" >
  <div class="left bw3" >
    <div class="left" style="width:55px;" >
      <img 
        style="max-width:48px;max-height:48px;" 
        alt="Sender Photo" 
        src="thumb.php?f=core_person-photo-<?php  echo $VAR->msgNode->sender_pid ?>&amp;s=xxsmall">
    </div>
    <div class="inline" >
      <label class="cl text" >Sender:</label> <div class="inline"><?php echo $VAR->msgNode->sender_name; ?></div>
      <label class="cl text" >Priority:</label> <div class="inline"><?php echo $VAR->msgNode->priority; ?></div>
      <label class="cl text" >Sended:</label> <div class="inline"><?php echo $this->i18n->timestamp( $VAR->msgNode->m_time_created );  ?></div>
    </div>
  </div>
  <div class="inline bw12" >
    <div class="left"><input 
      type="radio"
      class="asgd-wgt-form-msg-show-save-<?php echo $VAR->msgNode->msg_id; ?> radio-msg-type-<?php echo $VAR->msgNode->msg_id; ?>"
      id="wgt-inp-show-msg-asp-msg-<?php echo $VAR->msgNode->msg_id; ?>"
      <?php echo Wgt::checked(true, isset($VAR->msgNode->aspects[EMessageAspect::MESSAGE]));?>
      name="paspect"
      value="<?php echo EMessageAspect::MESSAGE ?>" /></div> <label class="inline text" >&nbsp;Message/Notice</label>
    <div class="left"><input 
      type="radio"
      class="asgd-wgt-form-msg-show-save-<?php echo $VAR->msgNode->msg_id; ?> radio-msg-type-<?php echo $VAR->msgNode->msg_id; ?>"
      id="wgt-inp-show-msg-asp-document-<?php echo $VAR->msgNode->msg_id; ?>"
      <?php echo Wgt::checked(true, isset($VAR->msgNode->aspects[EMessageAspect::DOCUMENT]));?>
      name="paspect"
      value="<?php echo EMessageAspect::DOCUMENT ?>" /></div> <label class="inline text" >&nbsp;Document</label> 
    <div class="left"><input 
      type="radio"
      class="asgd-wgt-form-msg-show-save-<?php echo $VAR->msgNode->msg_id; ?> radio-msg-type-<?php echo $VAR->msgNode->msg_id; ?>"
      id="wgt-inp-show-msg-asp-disc-<?php echo $VAR->msgNode->msg_id; ?>"
      <?php echo Wgt::checked(true, isset($VAR->msgNode->aspects[EMessageAspect::DISCUSSION]));?>
      name="paspect"
      value="<?php echo EMessageAspect::DISCUSSION ?>" /></div> <label class="inline text" >&nbsp;Discussion</label> 
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
      id="wgt-inp-show-msg-asp-shared-<?php echo $VAR->msgNode->msg_id; ?>"
      <?php echo Wgt::checked(true, isset($VAR->msgNode->aspects[EMessageAspect::SHARED]));?>
      name="aspect[]"
      value="<?php echo EMessageAspect::SHARED ?>" /></div> <label class="inline text" >&nbsp;Is Shared</label> 
  </div>
  
</div>

<!-- Mail Content -->
<div 
  class="wgt-border-bottom"
  id="wgt-box-show-msg-content-<?php echo $VAR->msgNode->msg_id; ?>"
  style="position:absolute;top:60px;left:200px;right:200px;bottom:230px;" >
  <iframe
    src="plain.php?c=Webfrap.Message.showMailContent&objid=<?php echo $VAR->msgNode->msg_id; ?>"
    style="width:100%;min-height:400px;padding:0px;margin:0px;border:0px;" ></iframe>
</div>

<!-- Attchments & References -->
<div 
  class="wgt-border-left wgt-border-bottom" 
  id="wgt-box-show-msg-links-<?php echo $VAR->msgNode->msg_id; ?>"
  style="position:absolute;width:200px;top:60px;right:0px;bottom:230px;" >
  <div class="wgt-panel" >
    <div class="left" ><h2>Attachments</h2></div>
    <div class="right" ><button 
      class="wgt-button wgac_add_attachment" ><i class="icon-plus-sign" ></i></button></div>
  </div>
  <div class="content hr15_25x wgt-space" >
    <ul 
      id="wgt-list-show-msg-attach-<?php echo $VAR->msgNode->msg_id; ?>"
      class="wgt-list" >
     <?php foreach( $VAR->attachments as $attach ){  ?>
        <li id="wgt-entry-msg-attach-<?php echo $attach['attach_id']; ?>" ><a 
          target="attach"
          href="file.php?f=wbfsys_file-name-<?php echo $attach['file_id']; ?>&n=<?php echo base64_encode($attach['file_name'])  ?>" 
          ><?php echo $attach['file_name']; ?></a><a 
          class="wcm wcm_req_del" 
          title="Please confirm you want to delete this Attachment"
          href="ajax.php?c=Webfrap.Message_Attachment.delete&delid=<?php echo $attach['attach_id']; ?>"  ><i class="icon-remove" ></i></a></li>
      <?php } ?>
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
  id="wgt-box-show-msg-disc-<?php echo $VAR->msgNode->msg_id; ?>"
  style="position:absolute;height:230px;left:200px;right:200px;bottom:0px;" >

<div class="wgt-clear small" >&nbsp;</div>
  <textarea 
    id="wgt-wysiwyg-show-msg-post-<?php echo $VAR->msgNode->msg_id; ?>" 
    name="epost" 
    class="wcm wcm_ui_wysiwyg"  ></textarea>
  <var id="wgt-wysiwyg-show-msg-post-<?php echo $VAR->msgNode->msg_id; ?>-cfg-wysiwyg" >{"width":"750","height":"170"}</var>
  <button class="wgt-button" ><i class="icon-message" ></i> Send</button>
</div>

<?php $this->openJs(); ?><script>

$S('#wgt-button-message-addref-<?php echo $VAR->msgNode->msg_id; ?>').on('connect',function(event,id){
  $R.put('ajax.php?c=Webfrap.Message.addRef&msg=<?php echo $VAR->msgNode->msg_id; ?>&ref='+id);
});

self.getObject().find(".wgac_add_attachment").click( function(){
  $R.get( 'modal.php?c=Webfrap.Message_Attachment.formNew&msg=<?php echo $VAR->msgNode->msg_id; ?>' );
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
  $S('#ui-accordion-wgt-acc-show-msg-<?php echo $VAR->msgNode->msg_id; ?>-header-2').toggle();
  if($S(this).is(':checked')){
    accConts.subHeight(28);
  } else {
    accConts.addHeight(28);
  }
}).is(':checked')){
  self.getObject().find('#ui-accordion-wgt-acc-show-msg-<?php echo $VAR->msgNode->msg_id; ?>-header-2').hide();
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
  $S('#wgt-box-show-msg-appoint-<?php echo $VAR->msgNode->msg_id; ?>').toggle();
 
}).is(':checked')){
  self.getObject().find('#wgt-box-show-msg-appoint-<?php echo $VAR->msgNode->msg_id; ?>').hide();
};

/* IS Discussion */
self.getObject().find(".radio-msg-type-<?php echo $VAR->msgNode->msg_id; ?>").change( function(){

  console.log("val "+$S(this).val());
  if( $S(this).val() == <?php echo EMessageAspect::DISCUSSION ?> ){
    self.getObject().find('#wgt-box-show-msg-links-<?php echo $VAR->msgNode->msg_id; ?>').css('bottom','230px');
    self.getObject().find('#wgt-box-show-msg-content-<?php echo $VAR->msgNode->msg_id; ?>').css('bottom','230px');
    $S('#wgt-box-show-msg-disc-<?php echo $VAR->msgNode->msg_id; ?>').show();

    if( $S('#ui-accordion-wgt-acc-show-msg-<?php echo $VAR->msgNode->msg_id; ?>-header-3').is(':visible') ){
      $S('#ui-accordion-wgt-acc-show-msg-<?php echo $VAR->msgNode->msg_id; ?>-header-3').hide();
      accConts.addHeight(28);
    }
    
  } else if( $S(this).val() == <?php echo EMessageAspect::DOCUMENT ?> ){

    $S('#ui-accordion-wgt-acc-show-msg-<?php echo $VAR->msgNode->msg_id; ?>-header-3').show();
    accConts.subHeight(28);
    
    self.getObject().find('#wgt-box-show-msg-links-<?php echo $VAR->msgNode->msg_id; ?>').css('bottom','0px');
    self.getObject().find('#wgt-box-show-msg-content-<?php echo $VAR->msgNode->msg_id; ?>').css('bottom','0px');
    self.getObject().find('#wgt-box-show-msg-disc-<?php echo $VAR->msgNode->msg_id; ?>').hide();
  } else {

    if( $S('#ui-accordion-wgt-acc-show-msg-<?php echo $VAR->msgNode->msg_id; ?>-header-3').is(':visible') ){
      $S('#ui-accordion-wgt-acc-show-msg-<?php echo $VAR->msgNode->msg_id; ?>-header-3').hide();
      accConts.addHeight(28);
    }
    
    self.getObject().find('#wgt-box-show-msg-links-<?php echo $VAR->msgNode->msg_id; ?>').css('bottom','0px');
    self.getObject().find('#wgt-box-show-msg-content-<?php echo $VAR->msgNode->msg_id; ?>').css('bottom','0px');
    self.getObject().find('#wgt-box-show-msg-disc-<?php echo $VAR->msgNode->msg_id; ?>').hide();
  }

});


/* IS Discussion */
if( !self.getObject().find("#wgt-inp-show-msg-asp-disc-<?php echo $VAR->msgNode->msg_id; ?>").is(':checked') ){
  console.log( "no discussion value "+self.getObject().find(".radio-msg-type-<?php echo $VAR->msgNode->msg_id; ?>").val()  );
  
  self.getObject().find('#wgt-box-show-msg-disc-<?php echo $VAR->msgNode->msg_id; ?>').hide();
  self.getObject().find('#wgt-box-show-msg-links-<?php echo $VAR->msgNode->msg_id; ?>').css('bottom','0px');
  self.getObject().find('#wgt-box-show-msg-content-<?php echo $VAR->msgNode->msg_id; ?>').css('bottom','0px');
}

/* IS Document */
if( !self.getObject().find("#wgt-inp-show-msg-asp-document-<?php echo $VAR->msgNode->msg_id; ?>").is(':checked') ){
  self.getObject().find('#ui-accordion-wgt-acc-show-msg-<?php echo $VAR->msgNode->msg_id; ?>-header-3').hide();
  accConts.addHeight(28);
}

</script><?php $this->closeJs(); ?>
