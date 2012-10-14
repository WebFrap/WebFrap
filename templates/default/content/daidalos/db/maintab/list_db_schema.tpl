<h3>Database: <strong><?php echo $VAR->dbName; ?></strong> Schemas</h3>


<table 
  class="wgt-table" 
  id="wgt-table_daidalos-db-schemas-<?php echo $VAR->dbName ?>" 
  style="width:750px;" >
  <thead>
    <tr>
      <th class="pos" style="width:30px;" >Pos:</th>
      <th style="width:250px;" >Schema</th>
      <th style="width:150px;" >Owner</th>
      <th style="width:150px;" >Nav:</th>
    </tr>
  </thead>
  <tbody>
  <?php 

    $iconTables    = $this->icon( 'daidalos/table.png', 'Tables' );
    $iconViews     = $this->icon( 'daidalos/db_view.png', 'Views' );
    $iconSequences = $this->icon( 'daidalos/sequence.png', 'Sequences' );
    $iconProperties  = $this->icon( 'daidalos/property.png', 'Properties' );
    $iconRights    = $this->icon( 'control/rights.png', 'Rights' );
     $iconBackup    = $this->icon( 'daidalos/backup.png', 'Backup' );
    $iconRestore   = $this->icon( 'daidalos/restore.png', 'Restore' );
    $iconDelete    = $this->icon( 'control/delete.png', 'Delete' );
    $iconRename    = $this->icon( 'control/rename.png', 'Rename' );

  
    foreach( $VAR->schemas as $pos => $schema )
    {
      
      $col     = ($pos % 2)+1;
      $colPos  = $pos +1;
      
      
      echo <<<TABLE
      <tr 
        class="wcm row{$col} wcm_ui_highlight" 
        wgt_context_menu="wgt-table_daidalos-db-schemas-{$VAR->dbName}-cmenu"
        wgt_eid="{$schema['schema_name']}"
        id="wgt-table_daidalos-databases-r-{$schema['schema_name']}" >
        
        <td class="col" >{$colPos}</td>
        <td>{$schema['schema_name']}</td>
        <td>{$schema['owner']}</td>
        
        <td style="text-align:center;" >
        
          <button 
            class="wcm wcm_control_dropmenu wgt-button" 
            id="wgt-table_daidalos-databases-r-{$schema['schema_name']}-cntrl"
            style="width:65px;" 
            wgt_drop_box="wgt-table_daidalos-databases-r-{$schema['schema_name']}-menu" >
            <span class="left">Menu</span>
            <span class="ui-icon ui-icon-triangle-1-s right" />
          </button>
          <div />
          <div class="wgt-dropdownbox" id="wgt-table_daidalos-databases-r-{$schema['schema_name']}-menu">
          
            <ul>
              <li>
                <a onclick="\$R.get( 'maintab.php?c=Daidalos.DbTable.listing&db={$VAR->dbName}&schema={$schema['schema_name']}' );" >
                  {$iconTables} Tables
                </a>
              </li>
              <li>
                <a onclick="\$R.get( 'maintab.php?c=Daidalos.DbView.listing&db={$VAR->dbName}&schema={$schema['schema_name']}' );" >
                  {$iconViews} Views
                </a>
              </li>
              <li>
                <a onclick="\$R.get( 'maintab.php?c=Daidalos.DbSequence.listing&db={$VAR->dbName}&schema={$schema['schema_name']}' );" >
                  {$iconSequences} Sequences
                </a>
              </li>
              <li>
                <a onclick="\$R.get( 'maintab.php?c=Daidalos.DbSchema.props&db={$VAR->dbName}&schema={$schema['schema_name']}' );" >
                  {$iconProperties} Properties
                </a>
              </li>
            </ul>
            
            <ul>
              <li>
                <a onclick="\$R.post( 'modal.php?c=Daidalos.DbSchema.dumpSchema&db={$schema['db_name']}&schema={$schema['schema_name']}' );" >
                  {$iconBackup} Backup
                </a>
              </li>              
              <li>
                <a onclick="\$R.get( 'modal.php?c=Daidalos.DbSchema.listBackups&db={$schema['db_name']}&schema={$schema['schema_name']}' );" >
                  {$iconRestore} Restore
                </a>
              </li>
            </ul>
            
            <ul>
              <li>
                <a onclick="\$R.del( 'ajax.php?c=Daidalos.DbSchema.drop&db={$schema['db_name']}&schema={$schema['schema_name']}' );" >
                  {$iconDelete} Restore
                </a>
              </li>
            </ul>
            
          </div>
          
          <var id="wgt-table_daidalos-databases-r-{$schema['schema_name']}-cntrl-cfg-dropmenu">
            {"triggerEvent":"mouseover","closeOnLeave":"true","align":"right"}
          </var>

        </td>
      </tr>
TABLE;
    }
  ?>
  </tbody>
</table>



<ul 
  id="wgt-table_daidalos-db-schemas-<?php echo $VAR->dbName ?>-cmenu" 
  class="wgt_context_menu" 
  style="display:none;" >
  <li><?php echo $iconRename ?><a href="#rename">Rename</a></li>
  <li class="separator" ><?php echo $iconTables ?><a href="#tables">Tables</a></li>
  <li><?php echo $iconViews ?><a href="#views">Views</a></li>
  <li><?php echo $iconSequences ?><a href="#sequences">Sequences</a></li>
  <li class="separator" ><?php echo $iconProperties ?><a href="#properties">Properties</a></li>
  <li><?php echo $iconRights ?><a href="#rights">Rights</a></li>
  <li class="separator" ><?php echo $iconBackup ?><a href="#backup">Backup</a></li>
  <li><?php echo $iconRestore ?><a href="#restore">Restore</a></li>
  <li class="separator" ><?php echo $iconDelete ?><a href="#delete">Delete</a></li>
</ul>

<div id="wgt-dialog-maintenance-rename-schema" class="template" >
  <div class="wgt-space" >
  <?php
    $uplForm = new WgtFormBuilder
    (
      'ajax.php?c=Daidalos.DbSchema.rename&db='.$VAR->dbName.'&schema=',
      'wgt-form-daiadlos-db-'.$VAR->dbName.'-rename',
      'put'
    );
    $uplForm->form();
    $uplForm->input( 'New Name', 'name' );
  ?>
  </div>
</div>

<div id="wgt-dialog-maintenance-create-schema" class="template" >
  <div class="wgt-space" >
  <?php
    $uplForm = new WgtFormBuilder
    (
      'ajax.php?c=Daidalos.DbSchema.create&db='.$VAR->dbName,
      'wgt-form-daiadlos-db-'.$VAR->dbName.'-create',
      'put'
    );
    $uplForm->form();
    $uplForm->input( 'Name', 'name' );
    $uplForm->input( 'Owner', 'owner' );
    $uplForm->input( 'Encoding', 'encoding', 'UTF-8' );
  ?>
  </div>
</div>

<?php $this->addJsCode( <<<JS

\$S('#wgt-table_daidalos-db-schemas-{$VAR->dbName}-cmenu').data('wgt-context-action',{
  rename: function( el, pos, id ){
    \$S('#wgt-dialog-maintenance-rename-schema').dialog({
      height : '120',
      width : '350',
      buttons: {
        "Rename": function() {
          \$R.form( 'wgt-form-daiadlos-db-{$VAR->dbName}-rename', id, {append:true} );
          \$S( this ).dialog( "close" );
        },
        Cancel: function() {
          \$S( this ).dialog( "close" );
        }
      }
    });
    return false;
  },
  tables: function( el, pos, id ){
    \$R.get( 'maintab.php?c=Daidalos.DbTable.listing&db={$VAR->dbName}&schema='+id );
    return false;
  },
  views: function( el, pos, id ){
    \$R.get( 'maintab.php?c=Daidalos.DbView.listing&db={$VAR->dbName}&schema='+id );
    return false;
  },
  sequences: function( el, pos, id ){
    \$R.get( 'maintab.php?c=Daidalos.DbSequence.listing&db={$VAR->dbName}&schema='+id );
    return false;
  },
  properties: function( el, pos, id ){
    \$R.get( 'maintab.php?c=Daidalos.DbSchema.props&db={$VAR->dbName}&schema='+id );
    return false;
  },
  backup: function( el, pos, id ){
    \$R.post( 'modal.php?c=Daidalos.DbSchema.listBackups&db={$VAR->dbName}&schema='+id );
    return false;
  },
  restore: function( el, pos, id ){
    \$R.get( 'modal.php?c=Daidalos.DbSchema.listBackups&db={$VAR->dbName}&schema='+id );
    return false;
  },
  delete: function( el, pos, id ){
    \$R.del( 'ajax.php?c=Daidalos.DbSchema.drop&db={$VAR->dbName}&schema='+id  );
    return false;
  }
});

JS
 );?>
