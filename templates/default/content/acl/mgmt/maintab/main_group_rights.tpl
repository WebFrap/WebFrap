
<!-- elements are assigned via class asgd-<?php echo $VAR->formId?> -->
<form
  method="post"
  accept-charset="utf-8"
  id="<?php echo $VAR->formId?>"
  action="<?php echo $VAR->formAction?>" ></form>
      
  <div 
    id="<?php echo $this->id?>-<?php echo $VAR->domain->domainName ?>-acl" 
    style="position:relative;height:100%;overflow-y:hidden;" 
    class="wcm wcm_ui_accordion_tab"  >
    
    <!-- Accordion Head -->
    <div style="position:absolute;width:220px;height:100%;top:0px:bottom:0px;"   >
    
      <div id="<?php echo $this->id?>-<?php echo $VAR->domain->domainName ?>-acl-head" style="height:600px;" >
          
        <h3><a tab="details" ><?php echo $I18N->l( 'Rolebased Access', 'wbf.label' ); ?></a></h3>
        <div></div>
        
        <h3><a 
          tab="qfd_users" 
          wgt_src="ajax.php?c=Acl.Mgmt.tabQualifiedUsers&area_id=<?php 
            echo $VAR->entityWbfsysSecurityArea 
          ?>&tabid=<?php 
            echo $this->id?>-<?php echo $VAR->domain->domainName ?>-acl-content-qfd_users&dkey=<?php 
            echo $VAR->domain->domainName 
          ?>" ><?php 
            echo $I18N->l( 'Qualified Users', 'wbf.label' ); ?></a></h3>
        <div></div>
        
      </div>
      
    </div>
    
    <!-- Accordion Content Container -->
    <div 
      id="<?php echo $this->id?>-<?php echo $VAR->domain->domainName ?>-acl-content" 
      style="position:absolute;left:220px;right:0px;top:0px;bottom:0px;height:100%;overflow:hidden;overflow-y:auto;"  >

    <div
      class="container"
      id="<?php echo $this->id?>-<?php echo $VAR->domain->domainName ?>-acl-content-details"
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
        action="<?php echo $VAR->searchFormAction?>&area_id=<?php echo $VAR->entityWbfsysSecurityArea ?>" ></form>

      <?php echo $ELEMENT->listingAclTable; ?>
      <form
        method="post"
        accept-charset="utf-8"
        id="wgt-form-<?php echo $VAR->domain->domainName ?>-acl-append"
        action="ajax.php?c=Acl.Mgmt.appendGroup&dkey=<?php echo $VAR->domain->domainName ?>" >

        <div class="wgt-panel" >

          <!-- Group Input -->
          <span><?php echo $I18N->l( 'Group', 'wbf.label' ); ?></span>
          <input
            type="text"
            id="wgt-input-<?php echo $VAR->domain->domainName ?>-acl-id_group-tostring"
            name="key"
            class="medium wcm wcm_ui_autocomplete wgt-no-save"
          />
          <var id="var-<?php echo $VAR->domain->domainName ?>-automcomplete" >{
              "url":"ajax.php?c=Acl.Mgmt.loadGroups&amp;area_id=<?php 
                echo $VAR->entityWbfsysSecurityArea 
              ?>&amp;dkey=<?php 
                echo $VAR->domain->domainName 
              ?>&amp;key=",
              "type":"entity"
            }</var>
          <input
            id="wgt-input-<?php echo $VAR->domain->domainName ?>-acl-id_group"
            class="meta valid_required"
            name="wbfsys_security_access[id_group]"
            type="text"
          />
          <button
            id="wgt-input-<?php echo $VAR->domain->domainName ?>-acl-id_group-append"
            class="wgt-button append wcm wcm_ui_tip"
            title="To assign a new role, just type the name of the role in the autocomplete field left to this infobox."
            onclick="$R.get('modal.php?c=Wbfsys.RoleGroup.selection&amp;target=<?php echo $VAR->searchFormId ?>');return false;"
          >
            <img src="<?php echo View::$iconsWeb ?>xsmall/control/search.png" alt="search" />
          </button>

          <!-- area & button -->

          <input
            type="text"
            id="wgt-input-<?php echo $VAR->domain->domainName ?>-acl-id_area"
            name="wbfsys_security_access[id_area]"
            value="<?php echo $VAR->entityWbfsysSecurityArea?>"
            class="meta"
          />

          <button
            class="wcm wcm_ui_button"
            id="wgt-button-<?php echo $VAR->domain->domainName ?>-acl-form-append"
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
      id="<?php echo $this->id?>-<?php echo $VAR->domain->domainName ?>-acl-content-qfd_users" >

    </div><!-- end tab -->


  </div><!-- end tab body -->
  
</div><!-- end maintab -->

<script type="text/javascript" >

$S('#<?php echo $VAR->searchFormId?>').data('connect',function( objid ){
  $R.post(
    'ajax.php?c=Acl.Mgmt.appendGroup&dkey=<?php echo $VAR->domain->domainName ?>',{
      'wbfsys_security_access[id_area]':'<?php echo $VAR->entityWbfsysSecurityArea?>',
      'wbfsys_security_access[id_group]':objid
    }
  );
});

<?php foreach( $this->jsItems as $jsItem ){ ?>
  <?php echo $ELEMENT->$jsItem->jsCode?>
<?php } ?>
</script>
