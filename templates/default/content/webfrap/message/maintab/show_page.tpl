<div class="wgt-space bw62" >

  <div class="left bw6" >
    <div class="wgt_box">
      <label class="wgt-label" >Sender:</label>
      <div class="wgt-input wgt-fake-input xxlarge" ><?php echo $VAR->msgNode->sender_name; ?></div>
    </div>
  </div>
  
  <div class="left bw6" >
    <div class="wgt_box">
      <label class="wgt-label" >Priority:</label>
      <div class="wgt-input" ><?php echo $VAR->msgNode->priority; ?></div>
    </div>
  </div>
  
  <div class="left bw6" >
    <div class="wgt_box">
      <label class="wgt-label" >Sended:</label>
      <div class="wgt-input wgt-fake-input" ><?php echo $this->i18n->timestamp( $VAR->msgNode->m_time_created );  ?></div>
    </div>
  </div>
  
  <div class="wgt-clear medium" >&nbsp;</div>

  <div class="wgt-content_box bw6 wgt-space">
    <div class="head" ><?php echo $VAR->msgNode->title; ?></div>
    <div class="content" style="background:white;min-height:200px;" >
  <?php echo $VAR->msgNode->message; ?>
    </div>
  </div>

  
  <div class="wgt-clear medium" >&nbsp;</div>

</div>