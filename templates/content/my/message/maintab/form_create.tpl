<?php

$iconReceiver = $this->icon( 'control/receiver.png', 'Receiver' );
$iconDelete = $this->icon( 'control/delete.png', 'Delete' );

?>


<!-- elements are assigned via class asgd-<?php echo $VAR->formId?> -->
<form
  method="post"
  accept-charset="utf-8"
  class="<?php echo $VAR->formClass?>"
  id="<?php echo $VAR->formId?>"
  action="<?php echo $VAR->formAction?>" ></form>

<div id="wgt-box-my_message-default" >

  <div class="left full" >
    <div class="wgt-receiver-box" >
      <div id="wgt_box-my_message-receivers"  >
        <label for="wgt-input-message-receivers" class="wgt-label">Receiver </label>
        <div class="wgt-input large" style="width:450px;" >
          <input
            type="text"
            id="wgt-input-my_message-receivers-tostring"
            name="key"
            class="xxlarge wcm wcm_ui_autocomplete wgt-ignore"  />
          <var class="wgt-settings" >
            {
              "url":"ajax.php?c=Webfrap.People.search&amp;key=",
              "type":"callback",
              "callback":"appendPerson",
              "clear":true
            }
          </var>
          <button
            id="wgt-button-my_message-receivers-advanced_search"
            class="wgt-button append"
            onclick="$R.get('subwindow.php?c=Webfrap.People.selection&callback=appendPersonSelection');return false;"    >
            <?php echo $iconReceiver ?>
          </button>

           <ul id="wgt-value-box" class="wgt-value-box" >

           </ul>

        </div>
       </div>
    </div>

    <?php // echo $ITEM->inputMyMessagePriority?>
  </div>

  <div class="left full" >
    <?php echo $ITEM->inputMyMessageTitle ?>
  </div>
  <div class="left full" >
    <?php echo $ITEM->inputMyMessageMessage ?>
  </div>

  <div class="wgt-clear small">&nbsp;</div>
</div>


<div id="wgt-box-my_message-meta" style="display:none" >
  <?php echo $ITEM->inputMyMessageIdRefer?>
</div>

<div class="wgt-clear small">&nbsp;</div>

<script type="application/javascript" >

(function(window){

  $S('#wgt-input-my_message-receivers-tostring').data( 'appendPerson', function( event, ui ){

    var theId = 'wgt-value-box-entry-'+ui.item.id;

    var listElement = '<li id="'+theId+'" class="ui-corner" >'
     + ui.item.label+'&nbsp;&nbsp;'
     + '<button class="wgt-button" onclick="$S(\'#'+theId+'\').remove();" ><?php echo $iconDelete ?></button>'
     + '<input name="receiver[]" id="wgt-input-list-of-receiver-entry-'+ui.item.id+'" '
     +' type="hidden" value="'+ui.item.id+'" class="asgd-<?php echo $VAR->formId?>" />'
     +'</li>';

    $S('#wgt-value-box').append( listElement );

  });

})(window);

</script>


