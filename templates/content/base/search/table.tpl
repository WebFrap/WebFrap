<div class="contentArea" >

  <?php echo $ITEM->searchTable ?>

</div>

<div class="wgt-clear medium">&nbsp;</div>

<script type="application/javascript">
  <?php foreach( $this->jsItems as $jsItem ){ ?>
  <?php echo $ITEM->$jsItem->jsCode ?>
  <?php } ?>
</script>