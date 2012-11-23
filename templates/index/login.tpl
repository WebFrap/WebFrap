<div id="wbf-body" style="width:100%;height:100%" >

  <div id="wbf-main_content" style="width:100%;height:100%" >

    <!-- messages -->
    <div id="wbf-messages"><?php echo $MESSAGES ?></div>
    <!-- end messages -->

    <!-- page -->
    <?php echo ($CONTENT?$CONTENT:$this->buildMainContent($TEMPLATE))?>
    <!-- end page -->

  </div>

</div>


<?php echo $this->includeTemplate( 'window' , 'index' ) ?>