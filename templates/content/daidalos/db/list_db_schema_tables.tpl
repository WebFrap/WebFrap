<h3>Database: <strong><?php echo $VAR->dbName; ?></strong> Schema: <strong><?php echo $VAR->schemaName; ?></strong> Tables</h3>


<table class="wgt-table" style="width:500px;" >
  <thead>
    <tr>
      <th style="width:250px;" >Table</th>
      <th style="width:120px;" >Nav:</th>
    </tr>
  </thead>
  <tbody>
  <?php 
    
    $iconEdit = $this->icon( 'control/edit.png', 'Edit' );
    $iconBackup = $this->icon( 'daidalos/backup.png', 'Backup' );
    $iconRestore = $this->icon( 'daidalos/restore.png', 'Restore' );
  
    foreach( $VAR->tables as $pos => $table )
    {
      
      $col = ($pos % 2)+1;
      
      $urlPart = "&db={$VAR->dbName}&schema={$VAR->schemaName}&table={$table['table_name']}";
      
      echo <<<TABLE
      <tr class="row{$col}" >
        <td>
          <a 
            class="wcm wcm_req_mtab" 
            href="maintab.php?c=Daidalos.Db.listEnrties{$urlPart}" >
              {$table['table_name']}
          </a>
        </td>
        
        <td style="text-align:center;" >
        
          <button 
            class="wcm wcm_req_mtab wcm_ui_tip wgt-button" 
            title="Edit"
            value="maintab.php?c=Daidalos.Db.listSchemaTables{$urlPart}" ><i class="icon-edit" ></i> 
          </button>
          
          <button 
            class="wcm wcm_req_mtab wcm_ui_tip wgt-button" 
            title="Backup"
            value="maintab.php?c=Daidalos.DbSchemaTable.dumpTable{$urlPart}" >{$iconBackup} 
          </button>
          
          <button 
            class="wcm wcm_req_mtab wcm_ui_tip wgt-button" 
            title="Restore"
            value="maintab.php?c=Daidalos.DbSchemaTable.restoreTable{$urlPart}" >{$iconRestore} 
          </button>
          
        </td>
      </tr>
TABLE;
    }
  ?>
  </tbody>
</table>
