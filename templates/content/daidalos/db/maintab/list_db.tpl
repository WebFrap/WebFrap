<h3>Databases</h3>


<table class="wgt-table" id="wgt-table_daidalos-databases" style="width:750px;" >
  <thead>
    <tr>
      <th class="pos" style="width:30px;" >Pos:</th>
      <th style="width:320px;" >Database</th>
      <th style="width:50px;" >Charset</th>
      <th style="width:75px;" >Collate</th>
      <th style="width:50px;" >Nav:</th>
    </tr>
  </thead>
  <tbody>
  <?php 
    
    $iconSchema  = $this->icon( 'daidalos/schema.png', 'Schema' );
    $iconProp    = $this->icon( 'daidalos/property.png', 'Property' );
    $iconBackup  = $this->icon( 'daidalos/backup.png', 'Backup' );
    $iconRestore = $this->icon( 'daidalos/restore.png', 'Restore' );
    $iconRights  = $this->icon( 'control/rights.png', 'Rights' );
    $iconDelete  = $this->icon( 'control/delete.png', 'Delete' );
  
    foreach( $VAR->databases as $pos => $db )
    {
      
      $col = ($pos % 2)+1;
      
      echo <<<TABLE
      <tr 
        class="wcm row{$col} wcm_control_context_menu wcm_ui_highlight" 
        wgt_context_menu="wgt-table_daidalos-databases-cmenu"
        wgt_eid="{$db['name']}"
        id="wgt-table_daidalos-databases-r-{$db['name']}"
        >
        
        <td class="col" >{$pos}</td>
        <td><a class="wcm wcm_req_mtab" href="maintab.php?c=Daidalos.Db.listSchema&amp;key={$db['name']}" >{$db['name']}</a></td>
        <td>{$db['charset']}</td>
        <td>{$db['collate']}</td>
        
        <td style="text-align:center;" >
        
          <button 
            class="wcm wcm_req_mtab wcm_ui_tip wgt-button" 
            title="Schemas"
            value="maintab.php?c=Daidalos.Db.listSchema&amp;key={$db['name']}" >{$iconSchema} 
          </button>
          
          <span> | </span>
          
          <button 
            class="wcm wcm_req_mtab wcm_ui_tip wgt-button" 
            title="Delete"
            value="maintab.php?c=Daidalos.Db.listRestore&amp;key={$db['name']}" ><i class="icon-remove" ></i> 
          </button>
          
        </td>
      </tr>
TABLE;
    }
  ?>
  </tbody>
</table>

<ul id="wgt-table_daidalos-databases-cmenu" class="wgt_context_menu" style="display:none;" >
  <li><?php echo $iconSchema ?><a href="#schemas">Schemas</a></li>
  <li><?php echo $iconProp ?><a href="#props">Properties</a></li>
  <li><?php echo $iconRights ?><a href="#rights">Rights</a></li>
  <li><?php echo $iconBackup ?><a href="#backup">Backup</a></li>
  <li><?php echo $iconRestore ?><a href="#restore">Restore</a></li>
  <li><?php echo $iconDelete ?><a href="#delete">Delete</a></li>
</ul>

<?php $this->addJsCode( <<<JS

\$S('#wgt-table_daidalos-databases-cmenu').data('wgt-context-action',{
  schemas: function( el, pos, id ){
    \$R.get( 'maintab.php?c=Daidalos.Db.listSchema&amp;key='+id );
    return false;
  },
  props: function( el, pos, id ){
    \$R.get( 'maintab.php?c=Daidalos.DbSchema.schemaProperties&db='+id );
    return false;
  },
  rights: function( el, pos, id ){
    \$R.get( 'maintab.php?c=Daidalos.Db.formBackup&amp;key='+id );
    return false;
  },
  backup: function( el, pos, id ){
    \$R.get( 'maintab.php?c=Daidalos.Db.formBackup&amp;key='+id );
    return false;
  },
  restore: function( el, pos, id ){
    \$R.get('maintab.php?c=Daidalos.Db.listRestore&amp;key='+id);
    return false;
  },
  delete: function( el, pos, id ){
    \$R.get( 'maintab.php?c=Project.Plan_Acl_Dset.listing&amp;objid='+id+'&amp;target_id=wgt_table-project_plan&a_root=mgmt-project_plan&a_root_id=&a_level=1&a_key=mgmt-project_plan&a_node=mgmt-project_plan' );
    return false;
  }
});

JS
 );?>
