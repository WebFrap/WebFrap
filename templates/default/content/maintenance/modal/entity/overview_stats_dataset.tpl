
<?php echo $VAR->widgetEnterpriseCompanyStat
  ? $VAR->widgetEnterpriseCompanyStat->embed('widget-enterprise_company-stat','widget-enterprise_company-stat','full')
  : '<!-- failed to parse widget: EnterpriseCompany  -->';
?>

<div class="wgt-clear small">&nbsp;</div>


<script type="application/javascript">
<?php foreach( $this->jsItems as $jsItem ){ ?>
  <?php echo $ELEMENT->$jsItem->jsCode?>
<?php } ?>
</script>
