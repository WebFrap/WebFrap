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
      <i class="icon-folder-open-alt" ></i>
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
      <button class="wgt-button" onclick="$R.form('<?php echo $VAR->formId?>');" >Create</button>
    </div>

    <div class="wgt-clear small">&nbsp;</div>
  </div>
</fieldset>

<div id="wgt-box-webfrap_announcement-meta"  class="bw6" style="display:none" >
  <div class="left bw3" >
    <?php echo $ITEM->inputWebfrapAnnouncementMUuid?>
  </div>
</div>