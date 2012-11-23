<!-- elements are assigned via class asgd-<?php echo $VAR->formId?> -->
<form
  method="post"
  accept-charset="utf-8"
  class="<?php echo $VAR->formClass?>"
  id="<?php echo $VAR->formId?>"
  action="<?php echo $VAR->formAction?>" ></form>

<fieldset class="wgt-space bw61" >
  <legend>
    <span onclick="$S('#wgt-box-webfrap_announcement-default').iconToggle(this);">
      <?php echo Wgt::icon('control/opened.png','xsmall',$I18N->l('Open','wbf.label'))?>
    </span>
    Announcement
  </legend>
  <div id="wgt-box-webfrap_announcement-default" >

    <div class="left bw6" >
      <?php echo $ITEM->inputWebfrapAnnouncementTitle?>
    </div>
    <div class="left bw3" >
      <?php echo $ITEM->inputWebfrapAnnouncementIdType?>
      <?php echo $ITEM->inputWebfrapAnnouncementImportance?>
    </div>
    <div class="inline bw3" >
      <?php echo $ITEM->inputWebfrapAnnouncementDateStart?>
      <?php echo $ITEM->inputWebfrapAnnouncementDateEnd?>
    </div>
    <div class="left bw6" >
      <?php echo $ITEM->inputWebfrapAnnouncementMessage?>
    </div>
    
    <div class="wgt-clear small">&nbsp;</div>
    
    <div class="left bw6" >
      <button class="wgt-button" onclick="$R.form('<?php echo $VAR->formId?>');" >Edit</button>
    </div>

    <div class="wgt-clear small">&nbsp;</div>
  </div>
</fieldset>

<div id="wgt-box-webfrap_announcement-meta" class="bw61" style="display:none" >
  <div class="left bw3" >
    <?php echo $ITEM->inputWebfrapAnnouncementRowid?>
    <?php echo $ITEM->inputWebfrapAnnouncementMUuid?>
    <?php echo $ITEM->inputWebfrapAnnouncementMVersion?>
  </div>
</div>