
<fieldset class="nearly_full" >
  <legend>Bookmarks</legend>
  <?php echo$ITEM->tableWbfsysBookmark; ?>
</fieldset>

<div class="wgt-clear medium">&nbsp;</div>

<script type="application/javascript">
<?php foreach( $this->jsItems as $jsItem ){ ?>
  <?php echo$ITEM->$jsItem->jsCode?>
<?php } ?>
</script>
