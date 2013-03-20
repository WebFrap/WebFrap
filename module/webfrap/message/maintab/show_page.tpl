<div
  class="wgt-border-right"
  style="position:absolute;width:200px;top:0px;bottom:0px;left:0px;" >

  <div class="wgt-panel" >
    <div class="left" ><h2>Attachments</h2></div>
    <div class="right" ><button 
      class="wgt-button wgac_add_attachment" ><i class="icon-plus-sign" ></i></button></div>
  </div>
  <div class="content hr2_3x" >
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
  <div class="content hr2_3x" >
    <ul 
      id="wgt-list-show-msg-ref-<?php echo $VAR->msgNode->msg_id; ?>"
      class="wgt-list" >
      <?php foreach(){ ?>
        <li></li>
      <?php } ?>
    </ul>
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
      type="checkbox"
      name="aspect[]"
      value="<?php echo EMessageAspect::MESSAGE ?>" /></div> <label class="inline text" >&nbsp;Message</label>
    <div class="left"><input 
      type="checkbox"
      name="aspect[]"
      value="<?php echo EMessageAspect::NOTICE ?>" /></div> <label class="inline text" >&nbsp;Notice</label> 
    <div class="left"><input 
      type="checkbox"
      name="aspect[]"
      value="<?php echo EMessageAspect::MEMO ?>" /></div> <label class="inline text" >&nbsp;Memo</label> 
  </div>
  <div class="inline bw12" >
    <div class="left"><input 
      type="checkbox"
      name="aspect[]"
      value="<?php echo EMessageAspect::APPOINTMENT ?>" /></div> <label class="inline text" >&nbsp;Appointmnet</label>
    <div class="left"><input 
      type="checkbox"
      name="aspect[]"
      value="<?php echo EMessageAspect::SHARED_DOC ?>" /></div> <label class="inline text" >&nbsp;Shared Doc</label> 
    <div class="left"><input 
      type="checkbox"
      name="aspect[]"
      value="<?php echo EMessageAspect::TASK ?>" /></div> <label class="inline text" >&nbsp;Task</label> 
  </div>
  
</div>

<div style="position:absolute;top:60px;left:200px;right:0px;bottom:0px;" >
  <iframe
    src="plain.php?c=Webfrap.Message.showMailContent&objid=<?php echo $VAR->msgNode->msg_id; ?>"
    style="width:100%;min-height:500px;padding:0px;margin:0px;border:0px;" ></iframe>
</div>


<?php $this->openJs(); ?><script>

$S('#wgt-button-message-addref-<?php echo $VAR->msgNode->msg_id; ?>').on('connect',function(event,id){
  $R.put('ajax.php?c=Webfrap.Message.addRef&msg=<?php echo $VAR->msgNode->msg_id; ?>&ref='+id);
});

self.getObject().find(".wgac_add_reference").click( function(){
  $R.get( 'modal.php?c=Webfrap.DataConnector.selection&con=Webfrap.Message.connectDset&cbe=wgt-button-message-addref-<?php echo $VAR->msgNode->msg_id; ?>&dset=<?php echo $VAR->msgNode->msg_id; ?>' );
});

</script><?php $this->closeJs(); ?>
