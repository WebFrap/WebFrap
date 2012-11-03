<form
  method="get"
  accept-charset="utf-8"
  id="<?php echo $VAR->searchFormId?>"
  action="<?php echo $VAR->searchFormAction?>" ></form>

<?php echo $ELEMENT->listingDsetUsers ?>

<form
  method="post"
  accept-charset="utf-8"
  id="<?php echo $VAR->formIdAppend?>"
  action="<?php echo $VAR->formActionAppend?>" >

  <div class="wgt-panel" >
    <div class="left" ><?php echo $I18N->l( 'Group', 'wbf.label' );?>&nbsp;&nbsp;</div>
    <?php echo $ELEMENT->selectboxGroups->niceElement() ?>

    <div class="inline" style="margin-left:20px;" >
      <span><?php echo $I18N->l( 'User', 'wbf.label' );?>&nbsp;</span>
      <input
        type="text"
        id="wgt-input-<?php echo $VAR->domain->domainName ?>-acl-dset-id_user-tostring"
        name="key"
        class="medium wcm wcm_ui_autocomplete wgt-ignore"  />
      <var class="wgt-settings" >
        {
          "url":"ajax.php?c=Acl.Mgmt_Dset.autocompleteUsers&amp;dkey=<?php echo $VAR->domain->domainName ?>&amp;key=",
          "type":"entity"
        }
      </var>
      <input
        type="text"
        id="wgt-input-<?php echo $VAR->domain->domainName ?>-acl-dset-id_user"
        name="wbfsys_group_users[id_user]"
        class="meta valid_required"  />
      <button
        id="wgt-button-<?php echo $VAR->domain->domainName ?>-acl-advanced_search"
        class="wgt-button append"
        onclick="$R.get('modal.php?c=Wbfsys.RoleUser.selection&input=<?php echo $VAR->domain->domainName ?>-acl-dset-id_user');return false;"    >
        <img src="<?php echo View::$iconsWeb ?>xsmall/control/search.png" alt="search" />
      </button>
     </div>

     <div class="inline" style="margin-left:20px;" >
      <input
        type="hidden"
        id="wgt-input-<?php echo $VAR->domain->domainName ?>-acl-dset-vid"
        name="wbfsys_group_users[vid]"
        value="<?php echo $VAR->entityObj?>"
      />

      <button
        class="wgt-button"
        id="wgt-button-<?php echo $VAR->domain->domainName ?>-acl-dset-append"
        onclick="$R.form('wgt-form-<?php echo $VAR->domain->domainName ?>-acl-dset-append');$UI.form.reset('wgt-form-<?php echo $VAR->domain->domainName ?>-acl-dset-append');return false;" >
        <img src="<?php echo View::$iconsWeb ?>xsmall/control/connect.png" alt="connect" /> <?php echo $I18N->l( 'Append', 'wbf.label' );?>
      </button>
    </div>

  </form>

</div>

<script type="application/javascript">

<?php foreach( $this->jsItems as $jsItem ){ ?>
  <?php echo $ELEMENT->$jsItem->jsCode?>
<?php } ?>
</script>
