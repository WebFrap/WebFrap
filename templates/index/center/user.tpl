<?php
  if( !defined('CMS_URL') )
    define('CMS_URL','index.php?page=');
?>
<div class="wgtl_nav_outer_bg" >
  <div class="wgtl_nav_inner_bg" >
    <img alt="lb" style="float:left;" src="<?php echo WEB_THEME?>themes/default/images/layout/center/nav_lcl.jpg" />
    <div style="width:925px;float:left;" >
    <?php echo $this->includeTemplate('topmenu','menu')?>
    </div>
    <img alt="lb" style="float:right;padding:top:4px;" src="<?php echo WEB_THEME?>themes/default/images/layout/center/nav_rcl.jpg" />
  </div>
</div>

<div class="wgtl_content"  style="padding-bottom:10px;" >

  <!-- messages -->
  <div id="wgtl_messages"><?php echo $MESSAGES?></div>
  <!-- end messages -->

  <!-- page -->
  <div class="wgtl_body">
  <?php echo ($CONTENT?$CONTENT:$this->buildMainContent($TEMPLATE))?>
  </div>
  <!-- end page -->


  <!-- menu -->
  <?php if( !is_null($this->menu) ){ ?>
    <?php echo $this->includeTemplate( $this->menu , 'menu' )?>
  <?php } ?>
  <!-- end menu -->

</div>


<?php echo $this->includeTemplate( 'window' , 'index' ) ?>