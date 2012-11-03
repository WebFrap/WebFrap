<?php if( true ){ ?>

  <form
    method="get"
    accept-charset="utf-8"
    id="<?php echo $VAR->searchFormId?>"
    action="<?php echo $VAR->searchFormAction?>" ></form>

  <?php echo $ELEMENT->listingQualifiedUsers ?>

  <form
    method="post"
    accept-charset="utf-8"
    id="<?php echo $VAR->formIdAppend?>"
    action="<?php echo $VAR->formActionAppend?>" >

    <!-- Assignment Panel -->
    <div class="wgt-panel" style="height:190px;" >

      <h3><?php echo $I18N->l( 'Assign Users', 'wbf.label' ); ?></h3>

      <!-- formular -->
      <div class="left half" >

        <!-- group input -->
        <div class="left" >
          <label
            class="wgt-label"
            for="<?php echo $ELEMENT->selectboxGroups->id ?>" ><?php echo $I18N->l( 'Group', 'wbf.label' ); ?></label>
          <div class="wgt-input medium" >
            <?php echo $ELEMENT->selectboxGroups->niceElement() ?>
          </div>
        </div>

        <!-- user input -->
        <div class="left" >

          <label
            class="wgt-label"
            for="wgt-input-project_iteration-acl-qfdu-id_user" ><?php echo $I18N->l( 'User', 'wbf.label' ); ?></label>

          <div class="wgt-input medium" >
            <input
              type="text"
              id="wgt-input-project_iteration-acl-qfdu-id_user-tostring"
              name="key"
              title="Just type in the namen of the user, or klick on search for an extended search"
              class="medium wcm wcm_ui_autocomplete wgt-ignore wcm_ui_tip"  />
            <var class="wgt-settings" >
              {
                "url":"ajax.php?c=Project.Iteration_Acl.loadQfdUsers&amp;area_id=<?php
                  echo $VAR->areaId
                 ?>&amp;key=",
                "type":"entity"
              }
            </var>
            <input
              type="text"
              id="wgt-input-project_iteration-acl-qfdu-id_user"
              name="wbfsys_group_users[id_user]"
              class="meta valid_required"  />
            <button
              id="wgt-button-project_iteration-acl-advanced_search"
              class="wgt-button append"
              onclick="$R.get('subwindow.php?c=Wbfsys.RoleUser.selection&input=project_iteration-acl-qfdu-id_user');return false;"    >
              <img src="<?php echo View::$iconsWeb ?>xsmall/control/search.png" alt="search" />
            </button>
          </div>

        </div>

        <!-- Iteration Entity -->
        <div class="left"  >

          <label
            class="wgt-label"
            for="wgt-input-project_iteration-acl-qfdu-vid" >Iteration</label>

          <div class="wgt-input medium" >
            <input
              type="text"
              id="wgt-input-project_iteration-acl-qfdu-vid-tostring"
              title="Just type in the namen of the Iteration, or klick on search for an extended search"
              name="key"
              class="medium wcm wcm_ui_autocomplete wgt-ignore wcm_ui_tip"
            />
            <var class="wgt-settings" >
              {
                "url":"ajax.php?c=Project.Iteration_Acl.loadQfduEntity&amp;area_id=<?php echo $VAR->areaId ?>&amp;key=",
                "type":"entity"
              }
            </var>
            <input
              type="text"
              id="wgt-input-project_iteration-acl-qfdu-vid"
              name="wbfsys_group_users[vid]"
              class="meta valid_required"
            />
            <button
              id="wgt-input-project_iteration-acl-qfdu-vid-append"
              class="wgt-button append"
              onclick="$R.get('subwindow.php?c=Project.Iteration.selection&input=project_iteration-acl-qfdu-vid');return false;"
            >
              <img src="<?php echo View::$iconsWeb ?>xsmall/control/search.png" alt="search" />
            </button>
         </div>

         <!-- Assign Full -->
         <div class="left" >
           <label
             class="wgt-label"
             for="wgt-input-project_iteration-acl-qfdu-flagfull" ><?php echo $I18N->l( 'Assign Full', 'wbf.label') ?></label>

           <div class="wgt-input medium" >
            <input
              type="checkbox"
              id="wgt-input-project_iteration-acl-qfdu-flagfull"
              name="assign_full"
            />
          </div>
         </div>

       </div>


       <!-- buttons -->
       <div class="left" >

        <input
          type="text"
          id="wgt-input-project_iteration-acl-qfdu-id_area"
          name="wbfsys_group_users[id_area]"
          value="<?php echo $VAR->areaId?>"
          class="meta"
        />

        <button
          class="wgt-button"
          id="wgt-button-project_iteration-acl-qfdu-append"
          onclick="$R.form('wgt-form-project_iteration-acl-qfdu-append');$UI.form.reset('wgt-form-project_iteration-acl-qfdu-append');return false;" >
          <img src="<?php echo View::$iconsWeb ?>xsmall/control/connect.png" alt="connect" /> Append
        </button>

        &nbsp;&nbsp;|&nbsp;&nbsp;

        <button
          class="wgt-button"
          id="wgt-button-project_iteration-acl-qfdu-reload"
          onclick="$R.get('ajax.php?c=Project.Iteration_Acl.tabQualifiedUsers&area_id=<?php echo $VAR->areaId ?>&tabid=wgt_tab-project_iteration_acl_listing_tab_project_iteration-acl_qfd_users');return false;" >
          <img src="<?php echo View::$iconsWeb ?>xsmall/control/refresh.png" alt="Reload" /> Reload
        </button>

      </div>

    </form>

  </div>

<script type="application/javascript">

<?php foreach( $this->jsItems as $jsItem ){ ?>
  <?php echo $ELEMENT->$jsItem->jsCode?>
<?php } ?>
</script>

<?php }else{ ?>

  <p class="wgt-box error" >Sorry, an internal error occured. This resource is not loadable.</p>

<?php } ?>
