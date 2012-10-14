<div class="cms-body" >

  <div class="cms-header full" >
  <?php echo $ELEMENT->header ?>
  </div>
  
  
  <div class="cms-menu left" >
  <?php echo $ELEMENT->menu ?>
  </div>


  <div class="cms-content inline" >
  <?php echo ($CONTENT?$CONTENT:$this->buildMainContent($TEMPLATE)) ?>
  </div>


  <div class="cms-footer full" >
  <?php echo $ELEMENT->footer ?>
  </div>

</div>

<?php echo $this->includeTemplate( 'window.front' , 'index' ) ?>

