<div class="wgt-panel" style="z-index:5;" >
  <div class="wgt-fake-input xxlarge" ><?php echo $I18N->l( 'Group {@label@}: / root /', 'wbf.label', array( 'label' => $VAR->group->name ) ); ?> </div>
</div>

<div style="padding:0px;margin:0px;" >

  <div 
    class="wgt-bgbox" 
    style="position:absolute;width:250px;left:0px;top:30px;bottom:0px;"  >
    <ul class="ui-corner-top wgt-bg-control wgt-border wgt-padding"  >
      <?php foreach( $VAR->groups as $group ){ ?>
      <li
        class="wgt-selectable <?php echo $this->isActive( $VAR->groupId, $group['id'] ); ?>" ><a
            class="wcm wcm_req_ajax"
            href="maintab.php?c=Acl.Mgmt_Tree.showGraph&group_id=<?php echo $group['id'] ?>&graph_type=<?php echo $VAR->graphType; ?>&dkey=<?php echo $VAR->domain->domainName; ?>" 
            ><?php echo $group['value'] ?></a></li>
      <?php } ?>
    </ul>
  </div>

  <div 
    id="wgt-box-<?php echo $VAR->domain->aclDomainKey ?>-acl-tree" 
    class="wgt-corner"
    style="position:absolute;left:250px;right:245px;top:30px;bottom:0px;" >

  </div>

  <div 
    class="wgt-bgbox" 
    style="position:absolute;top:30px;right:0px;width:244px;z-index:5;" >


    <div class="ui-corner-top wgt-bg-control wgt-border-bopen wgt-padding wgt-label-left"  >
      <form
        method="post"
        accept-charset="utf-8"
        id="wgt-form-<?php echo $VAR->domain->aclDomainKey ?>-acl-path"
        action="maintab.php?c=Acl.Mgmt_Tree.savePath&graph_type=<?php echo $VAR->graphType; ?>&dkey=<?php echo $VAR->domain->domainName ?>" >

      <input
        type="hidden"
        id="wgt-input-<?php echo $VAR->domain->aclDomainKey ?>-acl-path-id_group"
        name="security_path[id_group]"
        value="<?php echo $VAR->groupId ?>" />

      <input
        type="hidden"
        id="wgt-input-<?php echo $VAR->domain->aclDomainKey ?>-acl-path-id_reference"
        name="security_path[id_reference]"
        value="" />

      <input
        type="hidden"
        id="wgt-input-<?php echo $VAR->domain->aclDomainKey ?>-acl-path-id_area"
        name="security_path[id_area]"
        value="" />

      <input
        type="hidden"
        id="wgt-input-<?php echo $VAR->domain->aclDomainKey ?>-acl-path-m_parent"
        name="security_path[m_parent]"
        value="" />

      <input
        type="hidden"
        id="wgt-input-<?php echo $VAR->domain->aclDomainKey ?>-acl-path-rowid"
        name="objid"
        value="" />

        <div>
          <label 
            for="wgt-input-<?php echo $VAR->domain->aclDomainKey ?>-acl-path-name" 
            class="wgt-label" ><?php echo $I18N->l( 'Name', 'wbf.label' ); ?></label>
          <input 
            name="ignored" 
            id="wgt-input-<?php echo $VAR->domain->aclDomainKey ?>-acl-path-name" 
            readonly="readonly" 
            class="large" />
        </div>
        <div>
          <label 
            for="<?php echo $ELEMENT->inputAccess->id ?>" 
            class="wgt-label" ><?php echo $I18N->l( 'Access', 'wbf.label' ); ?></label>
          <?php echo $ELEMENT->inputAccess->niceElement() ?>
        </div>
        <div>
          <label 
            for="wgt-input-<?php echo $VAR->domain->aclDomainKey ?>-acl-path-description" 
            class="wgt-label" ><?php echo $I18N->l( 'Description', 'wbf.label' ); ?></label>
          <textarea
            class="large large-height"
            name="security_path[description]"
            id="wgt-input-<?php echo $VAR->domain->aclDomainKey ?>-acl-path-description" ></textarea>
        </div>
        <div class="wgt-clear small" ></div>

      </form>

      <div>
        <button class="wcm wcm_ui_button" id="wgt-button-<?php echo $VAR->domain->aclDomainKey ?>-acl-path-send" >
          <?php echo $this->icon('control/save.png','Save') ?> <?php echo $I18N->l( 'Save', 'wbf.label' ); ?>
        </button>

        <button class="wcm wcm_ui_button" id="wgt-button-<?php echo $VAR->domain->aclDomainKey ?>-acl-path-drop" >
          <?php echo $this->icon('control/delete.png','Drop') ?> <?php echo $I18N->l( 'Drop Path', 'wbf.label' ); ?>
        </button>
      </div>

    </div>
  </div>

</div>

<div
  class="wgt-panel"
  id="wgt-box-<?php echo $VAR->domain->aclDomainKey ?>-acl-tree-info"
  style="height:38px;position:absolute;bottom:0px;right:0px;width:100%;z-index:5;" >

</div>

<?php $this->openJs(); ?><script>

  <?php foreach( $this->jsItems as $jsItem ){ ?>
    <?php echo $ELEMENT->$jsItem->jsCode?>
  <?php } ?>

  $S('#wgt-box-<?php echo $VAR->domain->aclDomainKey ?>-acl-tree').dynatree({
    "idPrefix": "wgt-tree-<?php echo $VAR->domain->aclDomainKey ?>-acl-node-",
    "generateIds": true,
    "initId": "wgt-tree-<?php echo $VAR->domain->aclDomainKey ?>-acl",
    "minExpandLevel": 2,
    "onClick": function(node, event) { 
      if(node.getEventTargetType(event) === "title"){  
        
        $S('#wgt-input-<?php echo $VAR->domain->aclDomainKey ?>-acl-path-name').val(node.data.data.label);
        $S('#wgt-input-<?php echo $VAR->domain->aclDomainKey ?>-acl-path-description').val(node.data.data.description);
        $S('#wgt-input-<?php echo $VAR->domain->aclDomainKey ?>-acl-path-access_level').niceValue(node.data.data.access_level);
        $S('#wgt-input-<?php echo $VAR->domain->aclDomainKey ?>-acl-path-id_reference').val(node.data.data.id);
        $S('#wgt-input-<?php echo $VAR->domain->aclDomainKey ?>-acl-path-id_area').val(node.data.data.target);
        $S('#wgt-input-<?php echo $VAR->domain->aclDomainKey ?>-acl-path-rowid').val(node.data.data.assign);
        $S('#wgt-input-<?php echo $VAR->domain->aclDomainKey ?>-acl-path-m_parent').val(node.data.data.parent);

        var infoBox = $S('#wgt-box-<?php echo $VAR->domain->aclDomainKey ?>-acl-tree-info');
        infoBox.html(
          '<p style="padding-left:20px;margin:0px;white-space: nowrap;overflow:hidden;" >'
            +node.data.data.area_description.replace("\n",'<br />')+'</p>'
        );

        if( undefined !== $C.colorCodes['access'][node.data.data.access_level] ){
          infoBox.css( 'background-color', $C.colorCodes['access'][node.data.data.access_level]) ;
        }
        else{
          infoBox.css( 'background-color', $C.colorCodes['system']['defbg'] );
        }
        
        return false; 
      } 
    },
    "onFocus": function(node, event){
      
      var infoBox = $S('#wgt-box-<?php echo $VAR->domain->aclDomainKey ?>-acl-tree-info');
      infoBox.html(
        '<p style="padding-left:20px;margin:0px;white-space: nowrap;overflow:hidden;" >'
          +node.data.data.area_description.replace("\n",'<br />')+'</p>'
      );

      if( undefined !== $C.colorCodes['access'][node.data.data.access_level] ){
        infoBox.css( 'background-color', $C.colorCodes['access'][node.data.data.access_level]) ;
      }
      else{
        infoBox.css( 'background-color', $C.colorCodes['system']['defbg'] );
      }
      
    },
    "children":<?php echo $VAR->treeData; ?>
  });

  $S('#wgt-button-<?php echo $VAR->domain->aclDomainKey ?>-acl-path-send').click(function(){
    
    if( $S('#wgt-input-<?php echo $VAR->domain->aclDomainKey ?>-acl-path-id_reference').val() === '' ){
      
      $D.errorWindow('Error','<?php echo $I18N->l( 'Please Select and Edit a Node before Saving', 'wbf.message' ); ?>');
      return false;
    }
    else{
      
      $R.form('wgt-form-<?php echo $VAR->domain->aclDomainKey ?>-acl-path');
      $UI.form.reset('wgt-form-<?php echo $VAR->domain->aclDomainKey ?>-acl-path');
    }
  });

  $S('#wgt-button-<?php echo $VAR->domain->aclDomainKey ?>-acl-path-drop').click(function(){

    if( $S('#wgt-input-<?php echo $VAR->domain->aclDomainKey ?>-acl-path-rowid').val() === '' ){

      $D.errorWindow('Error','<?php echo $I18N->l( 'You need to select a Path first, to delete it.', 'wbf.message' ); ?>');
      return false;
    }
    else{
      
      $R.del(
        'ajax.php?c=Acl.Mgmt_Tree.dropPath'
          +'&delid='+$S('#wgt-input-<?php echo $VAR->domain->aclDomainKey ?>-acl-path-rowid').val()
          +'&group_id=<?php echo $VAR->groupId ?>'
          +'&dkey=<?php echo $VAR->domain->domainName ?>'
      );
    }
  });

  $S('#wgt-box-<?php echo $VAR->domain->aclDomainKey ?>-acl-path').data( 'nodeHover', function( data ){
    var infoBox = $S('#wgt-box-<?php echo $VAR->domain->aclDomainKey ?>-acl-tree-info');
    infoBox.html('<p style="padding-left:20px;margin:0px;white-space: nowrap;overflow:hidden;" >'+data.area_description.replace("\n",'<br />')+'</p>');

    if( undefined !== $C.colorCodes['access'][data.access_level] ){
      infoBox.css('background-color',$C.colorCodes['access'][data.access_level]);
    }
    else{
      infoBox.css('background-color',$C.colorCodes['system']['defbg']);
    }
  });

</script><?php $this->closeJs(); ?>

