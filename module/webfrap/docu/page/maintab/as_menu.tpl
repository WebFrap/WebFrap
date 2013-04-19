
<?php foreach( $VAR->pageData->slices as $slice ){ ?>
  <div
    class="wgt-text-container wgt-space bw3 inline wgt-cursor-pointer"
    onclick="$R.get('maintab.php?c=Webfrap.Docu.page&page=<?php echo $slice->access_key ?>');" >
    <h3 class="ui-corner-top wgt-bg-head" ><?php echo $slice->title ?></h3>
    <div class="content wgt-border" >
      <?php echo $slice->short_desc ?>
    </div>
  </div>
<?php  } ?>