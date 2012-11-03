

    <form
      method="get"
      accept-charset="utf-8"
      class="<?php echo $VAR->searchFormClass?>"
      id="<?php echo $VAR->searchFormId?>"
      action="<?php echo $VAR->searchFormAction?>" >

    <div id="wgt-search-table-webfrap_announcement-advanced"  style="display:none" >

    <div class="wgt-panel title" >
      <h2><?php echo $I18N->l( 'Advanced Search', 'wbf.label' )?></h2>
    </div>


      <div id="wgt_tab-table-webfrap_announcement-search" class="wcm wcm_ui_tab"  >
        <div id="wgt_tab-table-webfrap_announcement-search-head" class="wgt_tab_head" ></div>

        <div class="wgt_tab_body" >

          <div
          class="wgt_tab wgt_tab-table-webfrap_announcement-search"
          id="wgt_tab-webfrap_announcement-search-default"
          title="Default" >
           <div class="left full" >
          <?php echo $ITEM->inputWebfrapAnnouncementSearchTitle?>
        </div>
        <div class="left half" >
          <?php echo $ITEM->inputWebfrapAnnouncementSearchDateStart?>
        </div>
        <div class="inline half" >
          <?php echo $ITEM->inputWebfrapAnnouncementSearchIdType?>
          <?php echo $ITEM->inputWebfrapAnnouncementSearchDateEnd?>
        </div>
        <div class="left full" >
          <?php echo $ITEM->inputWebfrapAnnouncementSearchMessage?>
        </div>

          <div class="wgt-clear xxsmall">&nbsp;</div>
        </div>


          <div
            class="wgt_tab wgt_tab-table-webfrap_announcement-search"
            id="wgt_tab-table-webfrap_announcement-search-meta"
            title="Meta" >

            <div class="left half" >
              <?php echo $ITEM->inputWebfrapAnnouncementSearchMRoleCreate?>
              <?php echo $ITEM->inputWebfrapAnnouncementSearchMTimeCreatedBefore?>
              <?php echo $ITEM->inputWebfrapAnnouncementSearchMTimeCreatedAfter?>
              <div class="box_border" >&nbsp;</div>
            </div>

            <div class="inline half" >
              <?php echo $ITEM->inputWebfrapAnnouncementSearchMRoleChange?>
              <?php echo $ITEM->inputWebfrapAnnouncementSearchMTimeChangedBefore?>
              <?php echo $ITEM->inputWebfrapAnnouncementSearchMTimeChangedAfter?>
            </div>

            <div class="left half" >&nbsp;</div>

            <div class="inline half" >
              <?php echo $ITEM->inputWebfrapAnnouncementSearchMUuid?>
              <?php echo $ITEM->inputWebfrapAnnouncementSearchMRowid?>
            </div>

          </div>

        </div>

      </div>

      <div class="wgt-clear xxsmall">&nbsp;</div>

    </div>

  </form>




  <?php echo $ITEM->tableWebfrapAnnouncement; ?>

  <div class="wgt-clear xsmall">&nbsp;</div>


<script type="application/javascript">
<?php foreach( $this->jsItems as $jsItem ){ ?>
  <?php echo $ITEM->$jsItem->jsCode?>
<?php } ?>
</script>
