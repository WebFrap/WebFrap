<div id="wgt-tab-webfrap_coredata_acl_listing" class="wcm wcm_ui_tab" >
  <div class="wgt_tab_body" >

    <!-- elements are assigned via class asgd-<?php echo $VAR->formId?> -->
    <form
      method="post"
      accept-charset="utf-8"
      id="<?php echo $VAR->formId?>"
      action="<?php echo $VAR->formAction?>" ></form>

    <div
      class="wgt_tab <?php echo $this->tabId?>"
      id="<?php echo $this->id?>_tab_webfrap_coredata-acl_details"
      title="<?php echo $I18N->l( 'Rolebased Access', 'wbf.label' ); ?>"
    >

    <div class="full wgt-border-bottom" >
       <div class="wgt-panel title" >
        <h2><?php 
          echo $I18N->l( 'Access Levels for Sec-Area:', 'wbf.label' ); 
           ?> <?php 
           echo $VAR->entityWbfsysSecurityArea->getSecure('label'); 
         ?></h2>
      </div>

      <div class="left third" >
        <h3><?php echo $I18N->l( 'Area Acecss', 'wbf.label' ); ?></h3>
        <?php echo $ITEM->inputWbfsysSecurityAreaIdLevelListing?>
        <?php echo $ITEM->inputWbfsysSecurityAreaIdLevelAccess?>
        <?php echo $ITEM->inputWbfsysSecurityAreaIdLevelInsert?>
        <?php echo $ITEM->inputWbfsysSecurityAreaIdLevelUpdate?>
        <?php echo $ITEM->inputWbfsysSecurityAreaIdLevelDelete?>
        <?php echo $ITEM->inputWbfsysSecurityAreaIdLevelAdmin?>
      </div>

      <div class="inline third" >
        <h3><?php echo $I18N->l( 'References Access', 'wbf.label' ); ?></h3>
        <?php echo $ITEM->inputWbfsysSecurityAreaIdRefListing?>
        <?php echo $ITEM->inputWbfsysSecurityAreaIdRefAccess?>
        <?php echo $ITEM->inputWbfsysSecurityAreaIdRefInsert?>
        <?php echo $ITEM->inputWbfsysSecurityAreaIdRefUpdate?>
        <?php echo $ITEM->inputWbfsysSecurityAreaIdRefDelete?>
        <?php echo $ITEM->inputWbfsysSecurityAreaIdRefAdmin?>
      </div>

      <div class="inline third" >
        <h3><?php echo $I18N->l( 'Description', 'wbf.label' ); ?></h3>
        <?php echo $ITEM->inputWbfsysSecurityAreaDescription->element(); ?>
      </div>

      <div class="meta" >
      <?php echo $ITEM->inputWbfsysSecurityAreaRowid?>
      </div>

      <div class="wgt-clear small">&nbsp;</div>

      </div>

      <form
        method="get"
        accept-charset="utf-8"
        id="<?php echo $VAR->searchFormId?>"
        action="<?php echo $VAR->searchFormAction?>&area_id=<?php echo $VAR->entityWbfsysSecurityArea ?>" ></form>

      <?php echo $ELEMENT->listingAclTable; ?>
      <form
        method="post"
        accept-charset="utf-8"
        id="wgt-form-webfrap_coredata-acl-append"
        action="ajax.php?c=Webfrap.Coredata_Acl.appendGroup" >

        <div class="wgt-panel" >

          <!-- Group Input -->
          <span><?php echo $I18N->l( 'Group', 'wbf.label' ); ?></span>
          <input
            type="text"
            id="wgt-input-webfrap_coredata-acl-id_group-tostring"
            name="key"
            class="medium wcm wcm_ui_autocomplete wgt-no-save"
          />
          <var id="var-webfrap_coredata-automcomplete" >
            {
              "url":"ajax.php?c=Webfrap.Coredata_Acl.loadGroups&amp;area_id=<?php 
                echo $VAR->entityWbfsysSecurityArea 
              ?>&amp;key=",
              "type":"entity"
            }
          </var>
          <input
            id="wgt-input-webfrap_coredata-acl-id_group"
            class="meta valid_required"
            name="wbfsys_security_access[id_group]"
            type="text"
          />
          <button
            id="wgt-input-webfrap_coredata-acl-id_group-append"
            class="wgt-button append wcm wcm_ui_tip"
            title="To assign a new role, just type the name of the role in the autocomplete field left to this infobox."
            onclick="$R.get('subwindow.php?c=Wbfsys.RoleGroup.selection&amp;target=<?php echo $VAR->searchFormId ?>');return false;"
          >
            <img src="<?php echo View::$iconsWeb ?>xsmall/control/search.png" alt="search" />
          </button>

          <!-- area & button -->

          <input
            type="text"
            id="wgt-input-webfrap_coredata-acl-id_area"
            name="wbfsys_security_access[id_area]"
            value="<?php echo $VAR->entityWbfsysSecurityArea?>"
            class="meta"
          />

          <button
            class="wcm wcm_ui_button"
            id="wgt-button-webfrap_coredata-acl-form-append"
            onclick="return false;" >
            <img src="<?php echo View::$iconsWeb ?>xsmall/control/connect.png" alt="connect" /> Append
          </button>

        </div><!-- end end panel -->

        <div class="wgt-pannel height-medium" >

        </div>

      </form>

      <div class="wgt-clear xsmall">&nbsp;</div>

    </div><!-- end tab -->

    <div
      class="wgt_tab <?php echo $this->tabId?>"
      id="<?php echo $this->id?>_tab_webfrap_coredata-acl_qfd_users"
      title="<?php echo $I18N->l( 'Qualified Users', 'wbf.label' ); ?>" >
      <a
        class="meta wgt_ref"
        href="ajax.php?c=Webfrap.Coredata_Acl.tabQualifiedUsers&area_id=<?php 
          echo $VAR->entityWbfsysSecurityArea 
          ?>&tabid=<?php 
          echo $this->id 
          ?>_tab_webfrap_coredata-acl_qfd_users" ></a>
      <div class="wgt-clear xsmall">&nbsp;</div>
    </div><!-- end tab -->


  </div><!-- end tab body -->
</div><!-- end maintab -->

<script type="text/javascript">

$S('#<?php echo $VAR->searchFormId?>').data('connect',function( objid ){
  $R.post(
    'ajax.php?c=Webfrap.Coredata_Acl.appendGroup',{
      'wbfsys_security_access[id_area]':'<?php echo $VAR->entityWbfsysSecurityArea?>',
      'wbfsys_security_access[id_group]':objid
    }
  );
});

<?php foreach( $this->jsItems as $jsItem ){ ?>
  <?php echo $ELEMENT->$jsItem->jsCode?>
<?php } ?>
</script>
