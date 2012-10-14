<?php 

$iconDel = Wgt::icon('control/delete.png', 'xsmall', 'Delete' );

$modIcons = array
(
  'actions' => array( $this->icon( 'daidalos/bdl/actions.png' , 'Actions'   ),'Action'),
  'charts' => array( $this->icon( 'daidalos/bdl/charts.png' , 'Charts'   ),'Chart'),
  'components' => array( $this->icon( 'daidalos/bdl/components.png' , 'Components'   ),'Component'),
  'data' => array( $this->icon( 'daidalos/bdl/data.png' , 'Data'   ),'Data'),
  'desktops' => array( $this->icon( 'daidalos/bdl/desktops.png' , 'Desktops'   ),'Desktop'),
  'documents' => array( $this->icon( 'daidalos/bdl/documents.png' , 'Documents'   ),'Document'),
  'docus' => array( $this->icon( 'daidalos/bdl/docu.png' , 'Docu'   ),'Docu'),
  'entities' => array( $this->icon( 'daidalos/bdl/entities.png' , 'Entities'   ),'Entity'),
  'enums' => array( $this->icon( 'daidalos/bdl/enums.png' , 'Enums'   ),'Enum'),
  'items' => array( $this->icon( 'daidalos/bdl/items.png' , 'Items'   ),'Item'),
  'managements' => array( $this->icon( 'daidalos/bdl/managements.png' , 'Managements'   ),'Management'),
  'menus' => array( $this->icon( 'daidalos/bdl/menus.png' , 'Menus'   ),'Menu'),
  'modules' => array( $this->icon( 'daidalos/bdl/modules.png' , 'Modules'   ),'Module'),
  'processes' => array( $this->icon( 'daidalos/bdl/processes.png' , 'Processes'   ),'Process'),
  'profiles' => array( $this->icon( 'daidalos/bdl/profiles.png' , 'Profiles'   ),'Profile'),
  'roles' => array( $this->icon( 'daidalos/bdl/roles.png' , 'Roles'   ),'Role'),
  'users' => array( $this->icon( 'daidalos/bdl/users.png' , 'Users'   ),'User'),
  'messages' => array( $this->icon( 'daidalos/bdl/messages.png' , 'Messages'   ),'Message'),
  'services' => array( $this->icon( 'daidalos/bdl/services.png' , 'Services'   ),'Service'),
  'widgets' => array( $this->icon( 'daidalos/bdl/widgets.png' , 'Widgets'   ),'Widget'),
);

?>

  <div class="wgt-space" >
    <div class="wgt-head bw8" >
      <span>Area</span>
      <div class="right" style="width:50px;" >Nav</div>
      <div class="right bw3" >Description</div>
      <div class="wgt-clear small" >&nbsp;</div>
    </div>

<ul id="wgt-tree-module-<?php echo $VAR->key; ?>" class="wcm wcm_ui_tree bw8" >
<var id="wgt-tree-module-<?php echo $VAR->key; ?>-cfg-tree" >{
"url":"ajax.php?c=Daidalos.BdlModules.loadChildren&amp;key=<?php echo $VAR->key; ?>"
}</var>
<?php 
  foreach( $VAR->modules as $module  )
  {
    
    echo <<<HTML
      <li 
        id="wgt-tree-bdl-modules-{$module}"
        wgt_key="{$module}" 
        style="border-bottom:1px solid silver;" 
        class="wcm wcm_control_context_menu closed"
        wgt_context_menu="wgt-context-bdl-module-tree" >
        <span>{$module}</span>
        <div class="right" style="width:50px;" >
          <button 
            class="wgt-button wgtac_delete_module"
            wgt_idx="{$module}" >{$iconDel}</button>
        </div>
        <div class="right bw3" ></div>
        <div class="wgt-clear tiny" >&nbsp;</div>
        <ul>
          <li 
            wgt_node_key="{$module}" 
            id="wgt-tree-module-{$VAR->key}-{$module}" 
            class="load_children" ><span class="placeholder">&nbsp;</span></li>
        </ul>
      </li>

HTML;

  }
?>
</ul>

</div>

<ul id="wgt-context-bdl-module-tree" style="width:200px;" class="wgt_context_menu meta">
  <?php 
    foreach( $modIcons as $key => $icon )
    {
      echo <<<CODE
  <li><a href="#{$key}" >{$icon[0]} Add {$icon[1]}</a></li>
CODE;
    }
  ?>
</ul>
