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
        id="wgt-input-project_iteration-acl-dset-id_user-tostring"
        name="key"
        class="medium wcm wcm_ui_autocomplete wgt-ignore"  />
      <var class="wgt-settings" >
        {
          "url":"ajax.php?c=Project.Iteration_Acl_Dset.autocompleteUsers&amp;key=",
          "type":"entity"
        }
      </var>
      <input
        type="text"
        id="wgt-input-project_iteration-acl-dset-id_user"
        name="wbfsys_group_users[id_user]"
        class="meta valid_required"  />
      <button
        id="wgt-button-project_iteration-acl-advanced_search"
        class="wgt-button append"
        onclick="$R.get('subwindow.php?c=Wbfsys.RoleUser.selection&input=project_iteration-acl-dset-id_user');return false;"    >
        <img src="<?php echo View::$iconsWeb ?>xsmall/control/search.png" alt="search" />
      </button>
     </div>

     <div class="inline" style="margin-left:20px;" >
      <input
        type="hidden"
        id="wgt-input-project_iteration-acl-dset-vid"
        name="wbfsys_group_users[vid]"
        value="<?php echo $VAR->entityObj?>"
      />

      <button
        class="wgt-button"
        id="wgt-button-project_iteration-acl-dset-append"
        onclick="$R.form('wgt-form-project_iteration-acl-dset-append');$UI.form.reset('wgt-form-project_iteration-acl-dset-append');return false;" >
        <img src="<?php echo View::$iconsWeb ?>xsmall/control/connect.png" alt="connect" /> <?php echo $I18N->l( 'Append', 'wbf.label' );?>
      </button>
    </div>

  </form>

</div>

<script type="text/javascript">

<?php foreach( $this->jsItems as $jsItem ){ ?>
  <?php echo $ELEMENT->$jsItem->jsCode?>
<?php } ?>
</script>
