<div id="wgt-page" >

  <div id="wgt-header" >
    <?php echo $VAR->header ?>
  </div>
  
  <div id="wgt-menu" >
    <?php echo $VAR->menu ?>
  </div>
  
  <div id="wgt-content" >
    <?php echo ($CONTENT?$CONTENT:$this->buildMainContent($TEMPLATE)) ?>
  </div>

  <div id="wgt-footer" >
    <?php echo $VAR->footer ?>
  </div>
  
  <div class="wgt-clear" ></div>

</div>

<?php echo $this->includeTemplate( 'window.front' , 'index' ) ?>