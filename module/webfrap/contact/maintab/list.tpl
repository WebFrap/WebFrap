<?php 

$menuBuilder = new WebfrapContact_List_Menu($this);
$menuBuilder->parentId = $this->id;
$menuBuilder->access = $this->model->access;
$menuBuilder->setup();

?>
<div 
  style="position:absolute;top:0px;left:0px;right:0px;bottom:200px;padding:15px;overflow:auto;" 
  class="wgt-border-bottom" >

  <?php for( $i = 0; $i < 10; ++ $i ){ ?>
    <div 
      class="wcm wcm_control_access_dataset wgt-border ui-corner-all bh1 wgt-ispace wgt-space inline"
      wgt_url="modal.php?c=Webfrap.Contact.edit&amp;objid=<?php echo $i ?>" 
      style="width:290px;" >
      <div class="wgt-border-bottom" >
        <div class="left" style="overflow:hidden;width:235px;" >
          <a>Sir Dr. Hans von Wurst Bezwinger der Schlei (superdidi)</a>
        </div>
        <div class="right" >
          <?php echo $menuBuilder->buildRowMenu(
            array(),
            $i,
            null
          ); ?>
        </div>
        <div class="wgt-clear" >&nbsp;</div>
      </div>
      <div class="wgt-clear small" >&nbsp;</div>
      <div class="left" style="width:55px;" >
        <img alt="Thumb" style="max-width:48px;max-height:48px;" src="thumb.php?f=core_person-photo-149311&s=xxsmall" />
      </div>
      <div class="inline" >
        <label><i class="icon-user" ></i> Role: </label><a>Project Manager</a><br />
        <label><i class="icon-star" ></i> BuizNode: </label><a>superdidi</a><br />
        <label><i class="icon-envelope" ></i> E-Mail: </label><a>hans@wurst.de</a><br />
        <label><i class="icon-phone" ></i> Phone: </label><a>0177/23423</a><br />     
        
      </div>
    </div>
  <?php } ?>

</div>