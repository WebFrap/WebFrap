<div
  class="wgt-border-right"
  style="position:absolute;width:200px;top:0px;bottom:0px;left:0px;" >

<h2>Attachments</h2>

<h2>References</h2>

</div>

<div
  style="position:absolute;top:0px;left:200px;right:0px;" class="wgt-panel hx2" >
  <label>Sender:</label> <span><?php echo $VAR->msgNode->sender_name; ?></span><br />
  <label>Priority:</label> <?php echo $VAR->msgNode->priority; ?><br />
  <label>Sended:</label> <?php echo $this->i18n->timestamp( $VAR->msgNode->m_time_created );  ?><br />
</div>

<div style="position:absolute;top:60px;left:200px;right:0px;bottom:0px;" >
  <iframe
    src="plain.php?c=Webfrap.Message.showMailContent&objid=<?php echo $VAR->msgNode->msg_id; ?>"
    style="width:100%;min-height:500px;padding:0px;margin:0px;border:0px;" ></iframe>
</div>
