<div class="wgt-panel" ><h2><?php echo $VAR->message->title ?></h2></div>
<div class="wgt-panel hx2"  >
  Sender: <?php echo $VAR->message->sender_name ?><br />
  Date: <?php echo $VAR->message->receiver_name ?><br />
  To: <?php echo $VAR->message->receiver_name ?><br />
</div>
<div class="full" >
  <iframe
    src="plain.php?c=Webfrap.Message.showMailContent&objid=<?php echo $VAR->message->msg_id; ?>"
    style="width:100%;height:100%;min-height:360px;padding:0px;margin:0px;border:0px;" ></iframe>
</div>

