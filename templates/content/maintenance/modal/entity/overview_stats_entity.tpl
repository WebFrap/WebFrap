

<?php echo $VAR->widgetStats
  ? $VAR->widgetStats->embed('widget-maintenance-stat','widget-maintenance-stat','full')
  : '<!-- failed to parse widget: Stats  -->';
?>

<div class="wgt-clear small">&nbsp;</div>


<script type="application/javascript">
<?php foreach( $this->jsItems as $jsItem ){ ?>
  <?php echo $ELEMENT->$jsItem->jsCode?>
<?php } ?>
</script>
