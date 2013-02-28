<form
  method="get"
  accept-charset="utf-8"
  id="wgt-form-my_message-search"
  action="ajax.php?c=Webfrap.Message.searchList" ></form>

<div
  class="wgt-border-right"
  style="position:absolute;width:200px;top:0px;bottom:0px;left:0px;" >
  <div class="wgt-panel" ><h2>Menu</h2></div>

</div>

<div style="position:absolute;top:0px;left:200px;right:0px;height:360px;" >
	<?php echo $ELEMENT->messageList; ?>
</div>

<div style="position:absolute;top:360px;bottom:0px;left:200px;right:0px;" >
  <div class="wgt-panel" ><h2>Super duper</h2></div>
  <div class="wgt-panel hx2"  >
    Sender: <br />
    Date: <br />
    To: <br />
  </div>
  <div class="full" >
    Content
  </div>
</div>
