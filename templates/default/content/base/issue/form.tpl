<div class="contentArea" >

  <form
    method="post"
    class="<?php echo $VAR->formClass?>"
    id="<?php echo $VAR->formId?>"
    accept-charset="utf-8"
    action="<?php echo $VAR->formAction?>" >


    <fieldset class="nearly_full" >
      <legend>issue</legend>
      <div id="wgt-fieldset-content-issue_issue__default" >

        <div class="left full" >
          <?php echo $ITEM->inputIssueIssueTitle?>
        </div>

        <div class="left half" >
          <?php echo $ITEM->inputIssueIssueIdFinishVersion?>
          <?php echo $ITEM->inputIssueIssueIdVersion?>
          <?php echo $ITEM->inputIssueIssueIdOs?>
          <?php echo $ITEM->inputIssueIssueIdImpact?>
          <?php echo $ITEM->inputIssueIssueIdType?>
        </div>
        <div class="inline half" >
          <?php echo $ITEM->inputIssueIssueFlagHidden?>
          <?php echo $ITEM->inputIssueIssueFinishTill?>
          <?php echo $ITEM->inputIssueIssueIdPlattform?>
          <?php echo $ITEM->inputIssueIssueIdPriority?>
          <?php echo $ITEM->inputIssueIssueIdStatus?>
          <?php echo $ITEM->inputIssueIssueIdCategory?>
        </div>


        <div class="wgt-clear small">&nbsp;</div>
      </div>
    </fieldset>


  </form>

  <div class="wgt-clear medium">&nbsp;</div>

</div>

<div class="wgt-clear medium">&nbsp;</div>

<script type="text/javascript">
<?php foreach( $this->jsItems as $jsItem ){ ?>
  <?php echo $ITEM->$jsItem->jsCode?>
<?php } ?>
</script>
