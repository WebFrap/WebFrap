
<!-- elements are assigned via class asgd-<?php echo $VAR->formId?> -->
<form
  method="post"
  accept-charset="utf-8"
  id="<?php echo $VAR->formId?>"
  action="<?php echo $VAR->formAction?>" ></form>
      
  <div 
    id="<?php echo $this->id?>-webfrap_coredata-acl" 
    style="position:relative;height:100%;overflow-y:hidden;" 
    class="wcm wcm_ui_accordion_tab"  >
    
    <!-- Accordion Head -->
    <div style="position:absolute;width:200px;height:100%;top:0px:bottom:0px;"   >
    
      <div id="<?php echo $this->id?>-webfrap_coredata-acl-head" style="height:600px;" >
          
        <h3><a tab="details" ><?php echo $I18N->l( 'Rolebased Access', 'wbf.label' ); ?></a></h3>
        <div>
        	<label>Access Levels:</label>
        	<p>
        		The "Access Levels" are the easiest way to grant access to the data.<br />
        		Every user has a specific Access level like Employee e.g.<br />
        		To Manage the access to this datasource just set the minimum required "Access Level"
        		to the described Action.
        	</p>
        	
        	<label>Grouprole Access:</label>
        	<p>
        		A more advanced method for the access controll, are the role acess levels.
        		To gain access rights for a specific role append it to the list and define an access level
        		with the "Access Level" dropdown.
        	</p>
        	<p>
        		To provide this rights ro a specific user maintain his relationships in the "Qualified Users" tab.
        	</p>
        	
        	<label>Inherit Rights:</label>
        	<p>
        		To inherit the dataset rights to the form references use the "Inherit Rights" mask wich you can find
        		in the dataset menu of the assigned roles.
        	</p>
        	
        	<label class="hint" >Hint:</label>
        	<p class="hint" >If you have to use this mask frequently create a bookmark with the Bookmark action the form "Menu" on top
        	of this text.</p>
        	
        </div>
        
        <h3><a 
          tab="qfd_users" 
          wgt_src="ajax.php?c=Webfrap.Coredata_Acl.tabQualifiedUsers&amp;area_id=<?php 
          echo $VAR->entityWbfsysSecurityArea 
          ?>&amp;tabid=<?php 
            echo $this->id?>-webfrap_coredata-acl-content-qfd_users" ><?php 
            echo $I18N->l( 'Qualified Users', 'wbf.label' ); ?></a></h3>
        <div>
        	
        	<p>
        		Qualified users define relation of users to the complete datasource or to a list of datasets.<br />
        	</p>
        	<label class="sub" >Example:</label>
        	<p>
        		Lets asume there's a role "Owner" with Access Level "Edit".<br />
        		If you assign a person in relation to the datasource as "Owner" the person will be able to see and edit
        		all datasets in the datasource.<br />
        		As the role "Owner" has just edit rights the person ist not allowed to delete datasets.
        	</p>
        	<p>
        		To grant access rights in a more specific way you can also assign the "Owner" relationship just in relation
        		of one oder more datasets. Then the person will only have edit rights for the assigned datasets.
        	</p>
        
        </div>
        
      </div>
      
    </div>
    
    <!-- Accordion Content Container -->
    <div 
      id="<?php echo $this->id?>-webfrap_coredata-acl-content" 
      style="position:absolute;left:200px;right:0px;top:0px;bottom:0px;height:100%;overflow:hidden;overflow-y:auto;"  >

    <div
      class="container"
      id="<?php echo $this->id?>-webfrap_coredata-acl-content-details"
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
          <?php echo $ELEMENT->inputWbfsysSecurityAreaIdLevelListing?>
          <?php echo $ELEMENT->inputWbfsysSecurityAreaIdLevelAccess?>
          <?php echo $ELEMENT->inputWbfsysSecurityAreaIdLevelInsert?>
          <?php echo $ELEMENT->inputWbfsysSecurityAreaIdLevelUpdate?>
          <?php echo $ELEMENT->inputWbfsysSecurityAreaIdLevelDelete?>
          <?php echo $ELEMENT->inputWbfsysSecurityAreaIdLevelAdmin?>
        </div>
  
        <div class="inline third" >
          <h3><?php echo $I18N->l( 'References Access', 'wbf.label' ); ?></h3>
          <?php echo $ELEMENT->inputWbfsysSecurityAreaIdRefListing?>
          <?php echo $ELEMENT->inputWbfsysSecurityAreaIdRefAccess?>
          <?php echo $ELEMENT->inputWbfsysSecurityAreaIdRefInsert?>
          <?php echo $ELEMENT->inputWbfsysSecurityAreaIdRefUpdate?>
          <?php echo $ELEMENT->inputWbfsysSecurityAreaIdRefDelete?>
          <?php echo $ELEMENT->inputWbfsysSecurityAreaIdRefAdmin?>
        </div>
  
        <div class="inline third" >
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
        action="<?php echo $VAR->searchFormAction?>&amp;area_id=<?php echo $VAR->entityWbfsysSecurityArea ?>" ></form>

      <?php echo $ELEMENT->listingAclTable; ?>
      
      <form
        method="post"
        accept-charset="utf-8"
        id="wgt-form-webfrap_coredata-acl-append"
        action="ajax.php?c=Webfrap.Coredata_Acl.appendGroup" >

        <div class="wgt-panel" >

          <!-- Group Input -->
          <span><?php echo $I18N->l( 'Grouprole', 'wbf.label' ); ?></span>
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
            onclick="$R.get('modal.php?c=Wbfsys.RoleGroup.selection&amp;target=<?php echo $VAR->searchFormId ?>');return false;"
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
      class="container"
      id="<?php echo $this->id?>-webfrap_coredata-acl-content-qfd_users" >

    </div><!-- end tab -->


  </div><!-- end tab body -->
  
</div><!-- end maintab -->

<script type="application/javascript">

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
