<?php 

$iconPrio = array();

$iconPrio[10] = $this->icon( 'priority/min.png', 'Very Low' );
$iconPrio[20] = $this->icon( 'priority/low.png', 'Low' );
$iconPrio[30] = $this->icon( 'priority/normal.png', 'Normal' );
$iconPrio[40] = $this->icon( 'priority/high.png', 'High' );
$iconPrio[50] = $this->icon( 'priority/max.png', 'Very Heigh' );

?>
<div class="wgt-panel title" ><h2><?php echo $VAR->message->priority ? $iconPrio[$VAR->message->priority]: $iconPrio[30]; ?> Title: <?php echo $VAR->message->title ?></h2></div>

<div class="wgt-space full" >
  <div class="left bw5" >
    
    <div class="wgt_box input">
      <label for="wgt-input-my_message_title" class="wgt-label" >Sender: </label>
      <div class="wgt-input xxlarge" >
        <div 
          class="wgt-fake-input xxlarge"
          id="wgt-input-my_message_title" ><?php echo $VAR->sender?$VAR->sender->fullName:''; ?></div>
      </div>
    </div>
    
    <?php if( '' != trim($VAR->refer) ){ ?>
    <div class="wgt_box input">
      <label for="wgt-input-my_message_date" class="wgt-label" >Refer: </label>
      <div class="wgt-input xxlarge" >
        <div 
          class="wgt-fake-input xlarge" 
          id="wgt-input-my_message_refer" ><?php echo $VAR->refer ?></div>
      </div>
    </div>
    <?php } ?>
    
    <div class="full" >
    
      <div class="left"  >
        <label for="wgt-input-my_message_date" class="wgt-label" >Created: </label>
        <div class="wgt-input small" >
          <div 
            class="wgt-fake-input small" 
            id="wgt-input-my_message_date" ><?php echo $this->i18n->date( $VAR->message->m_time_created ) ?></div>
        </div>
      </div>
      
      <div class="inline"  >
        <label for="wgt-input-my_message_date_open" class="wgt-label small" >Opened: </label>
        <div class="wgt-input small" >
          <div 
            class="wgt-fake-input small" 
            id="wgt-input-my_message_date_open" ><?php 
              echo $VAR->messageStatus ? $this->i18n->date( $VAR->messageStatus->opened ):'' 
            ?></div>
        </div>
      </div>
      
      
      
      <div class="left"  >
        <label for="wgt-input-my_message_id" class="wgt-label" >Msg ID: </label>
        <div class="wgt-input xxlarge" >
          <div 
            class="wgt-fake-input xxlarge" 
            id="wgt-input-my_message_id" ><?php echo $VAR->message->m_uuid; ?></div>
        </div>
      </div>
      
      <div class="wgt-clear tiny">&nbsp;</div>
      
    </div>

    <div class="wgt-clear tiny">&nbsp;</div>
  </div>
  
  <div class="inline"  >
    <!--
    <h3>Tags</h3>
    <h3>Links</h3>
    <h3>Attachments</h3>
    -->
  </div>
  
  <div class="wgt-clear tiny">&nbsp;</div>
</div>

<div class="wgt-clear">&nbsp;</div>

<div class="wgt-space nearly-full wgt-border box-message" >
  <div><?php echo $VAR->message->message ?></div>
</div>
 
 
 <?php /*

        <div class="left half" >
          <?php echo $ITEM->inputMyMessageDeliverDate?>
          <?php echo $ITEM->inputMyMessagePriority?>
          <?php echo $ITEM->inputMyMessageIdSender?>
        </div>
        <div class="inline half" >
          <?php echo $ITEM->inputMyMessageDeliverTime?>
          <?php echo $ITEM->inputMyMessageIdRefer?>
          <?php echo $ITEM->inputMyMessageMessageId?>
        </div>
        <div class="left full" >
          <?php echo $ITEM->inputMyMessageMessage?>
        </div>

          <div class="wgt-clear small">&nbsp;</div>
        </div>
      </fieldset>

      <fieldset class="wgt-space" >
        <legend>
          <span onclick="$S('#wgt-box-wbfsys_message-meta-<?php echo $VAR->entityMyMessage; ?>').iconToggle(this);">
            <?php echo Wgt::icon('control/opened.png','xsmall',$I18N->l('Open','wbf.label'))?>
          </span>
          Meta
        </legend>
        <div id="wgt-box-wbfsys_message-meta-<?php echo $VAR->entityMyMessage; ?>" style="display:none" >
<div class="full" >
  Link: <strong>maintab.php?c=Wbfsys.Message.edit&amp;objid=<?php echo $VAR->entity ?></strong>
</div>        <div class="left half" >
          <?php echo $ITEM->inputMyMessageMRoleChange?>
          <?php echo $ITEM->inputMyMessageMTimeChanged?>
          <?php echo $ITEM->inputMyMessageRowid?>
        </div>
        <div class="inline half" >
          <?php echo $ITEM->inputMyMessageMUuid?>
          <?php echo $ITEM->inputMyMessageMVersion?>
          <?php echo $ITEM->inputMyMessageMRoleCreate?>
          <?php echo $ITEM->inputMyMessageMTimeCreated?>
        </div>

          <div class="wgt-clear small">&nbsp;</div>
        </div>
      </fieldset>
*/?>
