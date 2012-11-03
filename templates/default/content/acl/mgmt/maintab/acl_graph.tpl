<div class="wgt-panel" style="z-index:5;" >
  <div class="wgt-fake-input xxlarge" ><?php echo $I18N->l( 'Group {@label@}: / root /', 'wbf.label', array( 'label' => $VAR->group->name ) ); ?> </div>
</div>

<div style="width:100%;position:relative;" >

  <div 
    class="behind" 
    id="wgt-box-<?php echo $VAR->domain->domainName ?>-acl-path" 
    style="width:100%;height:650px;z-index:1" >
    
    <div
      class="wcm wcm_chart_<?php echo $VAR->graphType ?>"
      id="wgt-graph-<?php echo $VAR->domain->domainName ?>-acl-path"
      style="width:100%;height:650px;z-index:1" >
      <var class="data" ><?php echo $VAR->treeData; ?></var>
      <div
        class="container inline"
        id="wgt-graph-<?php echo $VAR->domain->domainName ?>-acl-path_container"
        style="width:100%;height:650px;z-index:1" ></div>
    </div>
  </div>

  <div class="wgt-bgbox" style="position:absolute;top:0px;left:50%;width:270px;z-index:5;margin-left:-135px;" >
    <ul class="ui-corner-top wgt-bg-controll wgt-border wgt-padding menu"  >
      <li>
        <input 
          type="radio" 
          class="key_graphtype" <?php echo $this->isChecked( 'spacetree', $VAR->graphType );  ?> 
          name="graphtype" 
          value="spacetree" /> <?php echo $I18N->l( 'Spacetree', 'wbf.label' ); ?>
      </li>
      <li>
        <input 
          type="radio" 
          class="key_graphtype" <?php echo $this->isChecked( 'hypertree', $VAR->graphType );  ?> 
          name="graphtype" 
          value="hypertree" /> <?php echo $I18N->l( 'Hypertree', 'wbf.label' ); ?>
      </li>
      <li>
        <input 
          type="radio" 
          class="key_graphtype" <?php echo $this->isChecked( 'rgraph', $VAR->graphType );  ?> 
          name="graphtype" 
          value="rgraph" /> <?php echo $I18N->l( 'RGraph', 'wbf.label' ); ?>
      </li>
    </ul>
  </div>

  <div class="wgt-bgbox" style="position:absolute;top:0px;left:0px;width:170px;z-index:5;" >
    <ul class="ui-corner-top wgt-bg-controll wgt-border wgt-padding"  >
      <?php foreach( $VAR->groups as $group ){ ?>
      <li
        class="wgt-selectable <?php echo $this->isActive( $VAR->groupId, $group['id'] ); ?>" ><a
            class="wcm wcm_req_ajax"
            href="maintab.php?c=Acl.Mgmt_Path.showGraph&group_id=<?php echo $group['id'] ?>&graph_type=<?php echo $VAR->graphType; ?>&dkey=<?php echo $VAR->domain->domainName; ?>" 
            ><?php echo $group['value'] ?></a></li>
      <?php } ?>
    </ul>
  </div>

  <div class="wgt-bgbox" style="position:absolute;top:0px;right:0px;width:244px;z-index:5;" >


    <div class="ui-corner-top wgt-bg-controll wgt-border-bopen wgt-padding"  >
      <form
        method="post"
        accept-charset="utf-8"
        id="wgt-form-<?php echo $VAR->domain->domainName ?>-acl-path"
        action="maintab.php?c=Acl.Mgmt_Path.savePath&graph_type=<?php echo $VAR->graphType; ?>&dkey=<?php echo $VAR->domain->domainName ?>" >

      <input
        type="hidden"
        id="wgt-input-<?php echo $VAR->domain->domainName ?>-acl-path-id_group"
        name="wbfsys_security_path[id_group]"
        value="<?php echo $VAR->groupId ?>" />

      <input
        type="hidden"
        id="wgt-input-<?php echo $VAR->domain->domainName ?>-acl-path-id_reference"
        name="wbfsys_security_path[id_reference]"
        value="" />

      <input
        type="hidden"
        id="wgt-input-<?php echo $VAR->domain->domainName ?>-acl-path-id_area"
        name="wbfsys_security_path[id_area]"
        value="" />

      <input
        type="hidden"
        id="wgt-input-<?php echo $VAR->domain->domainName ?>-acl-path-m_parent"
        name="wbfsys_security_path[m_parent]"
        value="" />

      <input
        type="hidden"
        id="wgt-input-<?php echo $VAR->domain->domainName ?>-acl-path-rowid"
        name="objid"
        value="" />

        <div>
          <label 
            for="wgt-input-<?php echo $VAR->domain->domainName ?>-acl-path-name" 
            class="wgt-label" ><?php echo $I18N->l( 'Name', 'wbf.label' ); ?></label>
          <input 
            name="ignored" 
            id="wgt-input-<?php echo $VAR->domain->domainName ?>-acl-path-name" 
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
            for="wgt-input-<?php echo $VAR->domain->domainName ?>-acl-path-description" 
            class="wgt-label" ><?php echo $I18N->l( 'Description', 'wbf.label' ); ?></label>
          <textarea
            class="large large-height"
            name="wbfsys_security_path[description]"
            id="wgt-input-<?php echo $VAR->domain->domainName ?>-acl-path-description" ></textarea>
        </div>
        <div class="wgt-clear small" ></div>

      </form>

      <div>
        <button class="wcm wcm_ui_button" id="wgt-button-<?php echo $VAR->domain->domainName ?>-acl-path-send" >
          <?php echo $this->icon('control/save.png','Save') ?> <?php echo $I18N->l( 'Save', 'wbf.label' ); ?>
        </button>

        <button class="wcm wcm_ui_button" id="wgt-button-<?php echo $VAR->domain->domainName ?>-acl-path-drop" >
          <?php echo $this->icon('control/delete.png','Drop') ?> <?php echo $I18N->l( 'Drop Path', 'wbf.label' ); ?>
        </button>
      </div>

    </div>
  </div>

</div>

<div
  class="wgt-panel"
  id="wgt-box-<?php echo $VAR->domain->domainName ?>-acl-path-info"
  style="height:32px;position:absolute;bottom:0px;right:0px;width:100%;z-index:5;" >

</div>


<script type="application/javascript">

  <?php foreach( $this->jsItems as $jsItem ){ ?>
    <?php echo $ELEMENT->$jsItem->jsCode?>
  <?php } ?>

  $S('#wgt-box-<?php echo $VAR->domain->domainName ?>-acl-path').data( 'nodeClick', function( data ){
    $S('#wgt-input-<?php echo $VAR->domain->domainName ?>-acl-path-name').val(data.label);
    $S('#wgt-input-<?php echo $VAR->domain->domainName ?>-acl-path-description').val(data.description);
    $S('#wgt-input-<?php echo $VAR->domain->domainName ?>-acl-path-access_level').niceValue(data.access_level);
    $S('#wgt-input-<?php echo $VAR->domain->domainName ?>-acl-path-id_reference').val(data.id);
    $S('#wgt-input-<?php echo $VAR->domain->domainName ?>-acl-path-id_area').val(data.target);
    $S('#wgt-input-<?php echo $VAR->domain->domainName ?>-acl-path-rowid').val(data.assign);
    $S('#wgt-input-<?php echo $VAR->domain->domainName ?>-acl-path-m_parent').val(data.parent);
  });

  $S('#wgt-button-<?php echo $VAR->domain->domainName ?>-acl-path-send').click(function(){
    
    if( $S('#wgt-input-<?php echo $VAR->domain->domainName ?>-acl-path-id_reference').val() == '' ){
      
      $D.errorWindow('Error','<?php echo $I18N->l( 'Please Select and Edit a Node before Saving', 'wbf.message' ); ?>');
      return false;
    }
    else{
      
      $R.form('wgt-form-<?php echo $VAR->domain->domainName ?>-acl-path');
      $UI.form.reset('wgt-form-<?php echo $VAR->domain->domainName ?>-acl-path');
    }
  });

  $S('#wgt-button-<?php echo $VAR->domain->domainName ?>-acl-path-drop').click(function(){

    if( $S('#wgt-input-<?php echo $VAR->domain->domainName ?>-acl-path-rowid').val() == '' ){

      $D.errorWindow('Error','<?php echo $I18N->l( 'You need to select a Path first, to delete it.', 'wbf.message' ); ?>');
      return false;
    }
    else{
      
      $R.del(
        'ajax.php?c=Acl.Mgmt_Path.dropPath'
          +'&delid='+$S('#wgt-input-<?php echo $VAR->domain->domainName ?>-acl-path-rowid').val()
          +'&group_id=<?php echo $VAR->groupId ?>'
          +'&graph_type=<?php echo $VAR->graphType ?>'
          +'&dkey=<?php $VAR->domain->domainName ?>'
      );
    }
  });

  $S('#wgt-box-<?php echo $VAR->domain->domainName ?>-acl-path').data( 'nodeHover', function( data ){
    var infoBox = $S('#wgt-box-<?php echo $VAR->domain->domainName ?>-acl-path-info');
    infoBox.html('<p style="padding-left:20px;margin:0px;white-space: nowrap;overflow:hidden;" >'+data.area_description.replace("\n",'<br />')+'</p>');

    if( undefined !== $C.colorCodes['access'][data.access_level] ){
      infoBox.css('background-color',$C.colorCodes['access'][data.access_level]);
    }
    else{
      infoBox.css('background-color',$C.colorCodes['system']['defbg']);
    }
  });

  $S('input.key_graphtype').click( function(  ){
    $R.get(
      'maintab.php?c=Acl.Mgmt_Path.reloadGraph'
        +'&group_id=<?php echo $VAR->groupId ?>'
        +'&graph_type='+$S(this).val()
        +'&dkey=<?php echo $VAR->domain->domainName ?>'
    );

  });

</script>

