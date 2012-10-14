
<form
  method="post"
  accept-charset="utf-8"
  class="<?php echo $VAR->searchFormClass?>"
  id="<?php echo $VAR->searchFormId?>"
  action="<?php echo $VAR->searchFormAction?>" ></form>


<?php echo $ELEMENT->tableProtocol ?>

<div class="wgt-clear xxsmall">&nbsp;</div>


<script type="text/javascript">
<?php foreach( $this->jsItems as $jsItem ){ ?>
  <?php echo $ELEMENT->$jsItem->jsCode?>
<?php } ?>
</script>
