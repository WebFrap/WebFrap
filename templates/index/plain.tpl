<div id="wbf-body">

  <!-- messages -->
  <div id="wbf-messages"><?php echo $MESSAGES?></div>
  <!-- end messages -->

  <!-- page -->
  <?php echo ($CONTENT?$CONTENT:$this->buildMainContent($TEMPLATE))?>
  <!-- end page -->

</div>
<?php echo $this->includeTemplate( 'window' , 'index' ) ?>