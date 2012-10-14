<h3>DB: <strong><?php echo $this->model->dbName; ?></strong> Schema: <strong><?php echo $this->model->schemaName; ?></strong> Views</h3>




<table 
  class="wgt-table" 
  id="wgt-table_daidalos-db-<?php echo $this->model->dbName ?>-s-<?php echo $this->model->schemaName; ?>-views" 
  style="width:750px;" >
  <thead>
    <tr>
      <th class="pos" style="width:30px;" >Pos:</th>
      <th style="width:120px;" >Name</th>
      <th style="width:120px;" >Owner</th>
      <th style="width:150px;" >Acl</th>
      <th style="width:250px;" >Description</th>
      <th style="width:150px;" >Nav:</th>
    </tr>
  </thead>
  <tbody>
  <?php 

    $iconProperties  = $this->icon( 'daidalos/property.png', 'Properties' );
    $iconRights      = $this->icon( 'control/rights.png', 'Rights' );
    $iconDelete      = $this->icon( 'control/delete.png', 'Delete' );

  
    foreach( $VAR->views as $pos => $schema )
    {
      
      $col = ($pos % 2)+1;

      echo <<<TABLE
      <tr 
        class="wcm row{$col} wcm_control_context_menu wcm_ui_highlight" 
        wgt_context_menu="wgt-table_daidalos-db-{$this->model->dbName}-s-{$this->model->schemaName}-views-cmenu"
        wgt_eid="{$this->model->schemaName}"
        id="wgt-table_daidalos-db-{$this->model->dbName}-s-{$this->model->schemaName}-r-{$schema['view_name']}"
        >
        
        <td class="col" >{$pos}</td>
        <td>{$schema['view_name']}</td>
        <td>{$schema['viewowner']}</td>
        <td>{$schema['relacl']}</td>
        <td>{$schema['description']}</td>
        
        <td style="text-align:center;" >

          <button 
            class="wcm wcm_req_mtab wcm_ui_tip wgt-button" 
            title="Restore"
            value="maintab.php?c=Daidalos.DbSchema.restoreSchema&db={$this->model->dbName}&schema={$this->model->schemaName}" >{$iconProperties} 
          </button>
          
          <span> | </span>
          
          <button 
            class="wcm wcm_req_mtab wcm_ui_tip wgt-button" 
            title="Restore"
            value="maintab.php?c=Daidalos.DbSchema.restoreSchema&db={$this->model->dbName}&schema={$this->model->schemaName}" >{$iconDelete} 
          </button>
          
        </td>
      </tr>
TABLE;
    }
  ?>
  </tbody>
</table>



<ul 
  id="wgt-table_daidalos-db-schemas-<?php echo $this->model->dbName ?>-cmenu" 
  class="wgt_context_menu" 
  style="display:none;" >
  <li><?php echo $iconProperties ?><a href="#rights">Properties</a></li>
  <li><?php echo $iconRights ?><a href="#rights">Rights</a></li>
  <li><?php echo $iconDelete ?><a href="#delete">Delete</a></li>
</ul>

<?php $this->addJsCode( <<<JS

\$S('#wgt-table_daidalos-db-schemas-{$this->model->dbName}-cmenu').data('wgt-context-action',{
  rights: function( el, pos, id ){
    \$R.get( 'maintab.php?c=Daidalos.DbSchema.listTables&db={$this->model->dbName}&schema='+id );
    return false;
  },
  properties: function( el, pos, id ){
    \$R.get( 'maintab.php?c=Daidalos.DbSchema.listTables&db={$this->model->dbName}&schema='+id );
    return false;
  },
  delete: function( el, pos, id ){
    \$R.get( '' );
    return false;
  }
});

JS
 );?>
