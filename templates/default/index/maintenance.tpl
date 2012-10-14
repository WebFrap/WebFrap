<div id="wbf-body">

  <?php echo $VAR->desktopPanel ?>

  <div id="wbf-full_content" >

    <!-- messages -->
    <div id="wbf-messages"><?php echo $MESSAGES?></div>
    <!-- end messages -->

    <?php echo ($CONTENT?$CONTENT:$this->buildMainContent($TEMPLATE))?>

  </div>



</div>


<?php echo $this->includeTemplate( 'window' , 'index' ) ?>