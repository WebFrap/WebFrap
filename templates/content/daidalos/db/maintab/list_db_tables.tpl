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

    $iconTables = $this->icon( 'daidalos/table.png', 'Tables' );
    $iconViews = $this->icon( 'daidalos/db_view.png', 'Views' );
    $iconSequences = $this->icon( 'daidalos/sequence.png', 'Sequences' );
    $iconProperties = $this->icon( 'daidalos/property.png', 'Properties' );
    $iconRights = $this->icon( 'control/rights.png', 'Rights' );
     $iconBackup = $this->icon( 'daidalos/backup.png', 'Backup' );
    $iconRestore = $this->icon( 'daidalos/restore.png', 'Restore' );
    $iconDelete = $this->icon( 'control/delete.png', 'Delete' );


    foreach( $VAR->schemas as $pos => $schema )
    {

      $col = ($pos % 2)+1;


      echo <<<TABLE
      <tr
        class="wcm row{$col} wcm_control_context_menu wcm_ui_highlight"
        wgt_context_menu="wgt-table_daidalos-db-schemas-{$VAR->dbName}-cmenu"
        wgt_eid="{$schema['schema_name']}"
        id="wgt-table_daidalos-databases-r-{$schema['schema_name']}"
        >

        <td class="col" >{$pos}</td>
        <td>{$schema['schema_name']}</td>
        <td>{$schema['owner']}</td>

        <td style="text-align:center;" >

          <button
            class="wcm wcm_req_mtab wcm_ui_tip wgt-button"
            title="Restore"
            value="maintab.php?c=Daidalos.DbSchema.restoreSchema&db={$schema['db_name']}&schema={$schema['schema_name']}" >{$iconRestore}
          </button>

          <span> | </span>

          <button
            class="wcm wcm_req_mtab wcm_ui_tip wgt-button"
            title="Restore"
            value="maintab.php?c=Daidalos.DbSchema.restoreSchema&db={$schema['db_name']}&schema={$schema['schema_name']}" ><i class="icon-remove" ></i>
          </button>

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
  <li><?php echo $iconTables ?><a href="#schemas">Tables</a></li>
  <li><?php echo $iconViews ?><a href="#props">Views</a></li>
  <li><?php echo $iconSequences ?><a href="#rights">Sequences</a></li>
  <li><?php echo $iconProperties ?><a href="#rights">Properties</a></li>
  <li><i class="icon-shield" ></i><a href="#rights">Rights</a></li>
  <li><?php echo $iconBackup ?><a href="#backup">Backup</a></li>
  <li><?php echo $iconRestore ?><a href="#restore">Restore</a></li>
  <li><?php echo $iconDelete ?><a href="#delete">Delete</a></li>
</ul>

<?php $this->addJsCode( <<<JS

\$S('#wgt-table_daidalos-db-schemas-{$VAR->dbName}-cmenu').data('wgt-context-action',{
  tables: function( el, pos, id ){
    \$R.get( 'maintab.php?c=Daidalos.DbSchema.listTables&db={$VAR->dbName}&schema='+id );
    return false;
  },
  views: function( el, pos, id ){
    \$R.get( 'maintab.php?c=Daidalos.DbSchema.listTables&db={$VAR->dbName}&schema='+id );
    return false;
  },
  sequences: function( el, pos, id ){
    \$R.get( 'maintab.php?c=Daidalos.DbSchema.listTables&db={$VAR->dbName}&schema='+id );
    return false;
  },
  properties: function( el, pos, id ){
    \$R.get( 'maintab.php?c=Daidalos.DbSchema.listTables&db={$VAR->dbName}&schema='+id );
    return false;
  },
  backup: function( el, pos, id ){
    \$R.get( 'maintab.php?c=Daidalos.DbSchema.listTables&db={$VAR->dbName}&schema='+id );
    return false;
  },
  restore: function( el, pos, id ){
    \$R.get( 'maintab.php?c=Daidalos.DbSchema.listTables&db={$VAR->dbName}&schema='+id );
    return false;
  },
  delete: function( el, pos, id ){
    \$R.get( '' );
    return false;
  }
});

JS
 );?>
