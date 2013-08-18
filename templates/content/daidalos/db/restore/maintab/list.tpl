<h2>Restore Tables</h2>

<?php 

if( $VAR->importMsg )
{
  echo '<label>Restore</label>';
  echo '<pre>'.$VAR->importMsg.'</pre>';
}

?>

<table class="wgt-table" style="width:750px;" id="wgt-table-daidalos-restore-<?php echo $VAR->dbKey ?>" >
  <thead>
    <tr>
      <th style="width:350px;" >Database</th>
      <th style="width:120px;" >Size</th>
      <th style="width:190px;" >Date</th>
      <th style="width:150px;" >Nav:</th>
    </tr>
  </thead>
  <tbody>
  <?php 
    
    $iconDelete = $this->icon( 'control/delete.png', 'Delete' );
    $iconRestore = $this->icon( 'daidalos/restore.png', 'Restore' );
    
    $pos = 0;
  
    foreach( $VAR->files as $file => $path )
    {
      ++$pos;
      $col = ($pos % 2)+1;
      
      $fileSize = $path->getSize( 'mb' );
      $changed = date('Y-m-d H:i:s',$path->getLastchanged( ));
      
      echo <<<TABLE
      <tr class="row{$col}" id="wgt-table-daidalos-restore-{$VAR->dbKey}-{$pos}" >
        <td><a class="wcm wcm_req_mtab" href="maintab.php?c=Daidalos.Db.restore&amp;key={$VAR->dbKey}&dump={$file}" >{$file}</a></td>
        <td>{$fileSize} MB</td>
        <td>{$changed}</td>
        
        <td style="text-align:center;" >
          
          <button 
            class="wcm wcm_req_mtab wcm_ui_tip wgt-button" 
            title="Restore"
            value="maintab.php?c=Daidalos.Db.restore&amp;key={$VAR->dbKey}&dump={$file}" >{$iconRestore} 
          </button>
          
          <span> | </span>

          <button 
            class="wcm_ui_tip wgt-button" 
            title="Delete the dump"
            onclick="\$R.del('maintab.php?c=Daidalos.Db.deleteDump&amp;key={$VAR->dbKey}&dump={$file}&pos={$pos}',{confirm:'Please confirm to delete this entry.'});return false;"
             ><i class="icon-remove" ></i> 
          </button>

        </td>
      </tr>
TABLE;
    }
  ?>
  </tbody>
</table>

<div id="wgt-modal-daidalos-restore-upload-form-db-<?php echo $VAR->dbKey ?>" class="wgt-modal-container" >
  
  <fieldset>
    <legend>Upload</legend>
    
    <?php echo WgtForm::upload( 'Db Dump', 'dudu', null, array(), 'formid'  ); ?>
    
  </fieldset>

</div>