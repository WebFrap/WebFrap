<div id="wbf-body">

  <div id="wbf-lineup">
    <?php echo $this->includeTemplate('topmenu','menu')?>
  </div>

  <div id="wbf-menu">

    <!-- menu -->
    <?php if(is_string($this->menu)){ ?>
      <?php echo $this->includeTemplate( $this->menu , 'menu' )?>
    <?php } elseif(is_object($this->menu)) { ?>
      <?php echo $this->menu?>
    <?php } ?>
    <!-- end menu -->

  </div>

  <div id="wbf-main_content">

    <!-- messages -->
    <div id="wbf-messages"><?php echo $MESSAGES?></div>
    <!-- end messages -->

    <!-- page -->
    <div  id="wbf-content" >
    <?php echo ($CONTENT?$CONTENT:$this->buildMainContent($TEMPLATE))?>
    </div>
    <!-- end page -->

  </div>

</div>

<?php echo $this->includeTemplate( 'window' , 'index' ) ?>