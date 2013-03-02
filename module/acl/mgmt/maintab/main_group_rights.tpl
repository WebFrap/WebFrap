

  <!-- elements are assigned via class asgd-<?php echo $VAR->formId?> -->
  <form
    method="post"
    accept-charset="utf-8"
    id="<?php echo $VAR->formId?>"
    action="<?php echo $VAR->formAction?>" ></form>

    <div
      id="<?php echo $this->id?>-<?php echo $VAR->domain->aclDomainKey ?>-acl"
      style="position:relative;height:100%;overflow-y:hidden;"
      class="wcm wcm_ui_accordion_tab"  >

      <!-- Accordion Head -->
      <div style="position:absolute;width:220px;height:100%;top:0px:bottom:0px;"   >

        <div id="<?php echo $this->id?>-<?php echo $VAR->domain->aclDomainKey ?>-acl-head" style="height:600px;" >

          <h3><a tab="details" ><?php echo $I18N->l( 'Rolebased Access', 'wbf.label' ); ?></a></h3>
          <div>
          	<label>Access Levels:</label>
          	<p>
          		The "access levels" are the easiest way to grant access to the data.<br />
          		Every user has a specific "access level" like employee, admin e.g.<br />
          		To maintain the access to the datasource simply set the minimum required "access level"
          		to the required activity(ies).
          	</p>

          	<label>Grouprole Access:</label>
          	<p>
          		A more advanced method of access control can be implemented with the role access levels.
          		To gain access rights for a specific role, append it to the list and select the appropriate access level
          		from the "Access Level" dropdown in the list.
          	</p>
          	<p>
          		To provide these rights to a specific user, maintain her/his relationship(s) in the "Qualified Users" tab below.
          	</p>

          	<label>Inherit Rights:</label>
          	<p>
          		To inherit the dataset rights to form references, use the "Inherit Rights" mask which you can find
          		in the dataset menu of the assigned roles.
          	</p>

          	<label class="hint" >Hint:</label>
          	<p class="hint" >If you have to use this mask frequently create a bookmark with the "Bookmark" action in "Menu" above.</p>

          </div>

          <h3><a
            tab="qfd_users"
            wgt_src="ajax.php?c=Acl.Mgmt_Qfdu.tabUsers&area_id=<?php
              echo $VAR->entityWbfsysSecurityArea
            ?>&tabid=<?php
              echo $this->id?>-<?php echo $VAR->domain->aclDomainKey ?>-acl-content-qfd_users&dkey=<?php
              echo $VAR->domain->domainName
            ?>" ><?php
              echo $I18N->l( 'Qualified Users', 'wbf.label' ); ?></a></h3>
          <div>
            <p>
          		"Qualified Users" defines the relation(s) of users to the complete datasource ( the Project table ) and/or to a list of datasets.<br />
          	</p>
          	<label class="sub" >Example:</label>
          	<p>
          		Assumption: there's a role "Owner" with access level "Edit".<br />
          		If you assign a person in relation to the datasource (Projects) as "Owner" the person will be able to see and edit
          		all Projects in the list.<br />
          		As the "Owner" has only edit rights, the person is not allowed e.g. to delete Projects.
          	</p>
          	<p>
          		To better specify grant access rights, you can also assign the "Owner" relationship in relation
          		to either one or more Projects. The person will then only have edit rights for the assigned Projects.
          	</p>
          </div>

        </div>

      </div>

      <!-- Accordion Content Container -->
      <div
        id="<?php echo $this->id?>-<?php echo $VAR->domain->aclDomainKey ?>-acl-content"
        style="position:absolute;left:220px;right:0px;top:0px;bottom:0px;height:100%;overflow:hidden;overflow-y:auto;"  >

      <div
        class="container"
        id="<?php echo $this->id?>-<?php echo $VAR->domain->aclDomainKey ?>-acl-content-details"
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

        <div class="left bw25" >
          <h3><?php echo $I18N->l( 'Area Acecss', 'wbf.label' ); ?></h3>
          <?php echo $ELEMENT->inputWbfsysSecurityAreaIdLevelListing?>
          <?php echo $ELEMENT->inputWbfsysSecurityAreaIdLevelAccess?>
          <?php echo $ELEMENT->inputWbfsysSecurityAreaIdLevelInsert?>
          <?php echo $ELEMENT->inputWbfsysSecurityAreaIdLevelUpdate?>
          <?php echo $ELEMENT->inputWbfsysSecurityAreaIdLevelDelete?>
          <?php echo $ELEMENT->inputWbfsysSecurityAreaIdLevelAdmin?>
        </div>

        <div class="inline bw25" >
          <h3><?php echo $I18N->l( 'References Access', 'wbf.label' ); ?></h3>
          <?php echo $ELEMENT->inputWbfsysSecurityAreaIdRefListing?>
          <?php echo $ELEMENT->inputWbfsysSecurityAreaIdRefAccess?>
          <?php echo $ELEMENT->inputWbfsysSecurityAreaIdRefInsert?>
          <?php echo $ELEMENT->inputWbfsysSecurityAreaIdRefUpdate?>
          <?php echo $ELEMENT->inputWbfsysSecurityAreaIdRefDelete?>
          <?php echo $ELEMENT->inputWbfsysSecurityAreaIdRefAdmin?>
        </div>

        <div class="inline bw25" >
          <h3><?php echo $I18N->l( 'Description', 'wbf.label' ); ?></h3>
          <?php echo $ELEMENT->inputWbfsysSecurityAreaDescription->element(); ?>
        </div>

        <div class="meta" >
        <?php echo $ELEMENT->inputWbfsysSecurityAreaRowid?>
        </div>

        <div class="wgt-clear small">&nbsp;</div>

        </div>

        <form
          method="get"
          accept-charset="utf-8"
          id="<?php echo $VAR->searchFormId?>"
          action="<?php echo $VAR->searchFormAction?>&area_id=<?php echo $VAR->entityWbfsysSecurityArea ?>" ></form>

        <form
          method="post"
          accept-charset="utf-8"
          id="wgt-form-<?php echo $VAR->domain->aclDomainKey ?>-acl-append"
          action="ajax.php?c=Acl.Mgmt.appendGroup&dkey=<?php echo $VAR->domain->domainName ?>" ></form>

        <div class="wgt-panel" >

            <!-- Group Input -->
            <span><?php echo $I18N->l( 'Add group', 'wbf.label' ); ?></span>
            <input
              type="text"
              id="wgt-input-<?php echo $VAR->domain->aclDomainKey ?>-acl-id_group-tostring"
              name="key"
              class="large wcm wcm_ui_autocomplete wgt-no-save"
            />
            <var id="var-<?php echo $VAR->domain->aclDomainKey ?>-automcomplete" >{
                "url":"ajax.php?c=Acl.Mgmt.loadGroups&amp;area_id=<?php
                  echo $VAR->entityWbfsysSecurityArea
                ?>&amp;dkey=<?php
                  echo $VAR->domain->domainName
                ?>&amp;key=",
                "type":"entity"
              }</var>
            <input
              id="wgt-input-<?php echo $VAR->domain->aclDomainKey ?>-acl-id_group"
              class="asgd-wgt-form-<?php echo $VAR->domain->aclDomainKey ?>-acl-append valid_required"
              name="security_access[id_group]"
              type="hidden"
            />
            <button
              id="wgt-input-<?php echo $VAR->domain->aclDomainKey ?>-acl-id_group-append"
              class="wgt-button append wcm wcm_ui_tip"
              title="To assign a new role, just type the name of the role in the autocomplete field left to this infobox."
              onclick="$R.get('modal.php?c=Wbfsys.RoleGroup.selection&amp;target=<?php echo $VAR->searchFormId ?>');return false;"
            >
              <i class="icon-search" ></i>
            </button>

            <!-- area & button -->

            <input
              type="hidden"
              id="wgt-input-<?php echo $VAR->domain->aclDomainKey ?>-acl-id_area"
              name="security_access[id_area]"
              def_value="<?php echo $VAR->entityWbfsysSecurityArea?>"
              value="<?php echo $VAR->entityWbfsysSecurityArea?>"
              class="asgd-wgt-form-<?php echo $VAR->domain->aclDomainKey ?>-acl-append "
            />

            <button
              class="wgt-button"
              id="wgt-button-<?php echo $VAR->domain->aclDomainKey ?>-acl-form-append"  >
              <i class="icon-link" ></i> Append
            </button>

          </div><!-- end end panel -->



          <div class="wgt-clear tiny" >&nbsp;</div>

          <?php echo $ELEMENT->listingAclTable; ?>
          <div class="wgt-clear small" >&nbsp;</div>

        <div class="wgt-clear xsmall">&nbsp;</div>

      </div><!-- end tab -->

      <div
        class="container"
        id="<?php echo $this->id?>-<?php echo $VAR->domain->aclDomainKey ?>-acl-content-qfd_users" >

      </div><!-- end tab -->


    </div><!-- end tab body -->

  </div><!-- end maintab -->

  <script type="application/javascript" >

$S('#<?php echo $VAR->searchFormId?>').data('connect',function( objid ){
  $R.post(
    'ajax.php?c=Acl.Mgmt.appendGroup&dkey=<?php echo $VAR->domain->aclDomainKey ?>',{
      'security_access[id_area]':'<?php echo $VAR->entityWbfsysSecurityArea?>',
      'security_access[id_group]':objid
    }
  );
});

  <?php foreach( $this->jsItems as $jsItem ){ ?>
  <?php echo $ELEMENT->$jsItem->jsCode?>
  <?php } ?>
  </script>


