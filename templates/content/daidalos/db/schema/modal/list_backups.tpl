<?php 
$iconRestore = $this->icon( 'control/restore.png', 'Restore' );
$iconDel     = $this->icon( 'control/delete.png', 'Delete' );
$iconUpload  = $this->icon( 'control/upload.png', 'Upload' );
?>

<div class="wgt-space" style="width:550px;"  >
  
  <form
    method="post"
    id="wgt-form-upload-dump-<?php echo $VAR->dbName ?>-<?php echo $VAR->schemaName ?>"
    action="ajax.php?c=Daidalos.DbSchema.uploadDump&db=<?php echo $VAR->dbName ?>&schema=<?php echo $VAR->schemaName ?>" ></form>
    
    <div style="padding-top:10px;padding-bottom:20px;" >
    
      <?php echo WgtForm::upload
        ( 
          'Dump',
          'dump',
          null,
          array(),
          'wgt-form-upload-dump-'.$VAR->dbName.'-'.$VAR->schemaName,
          true  
        );?>
  
      <button
        class="wgt-button"
        style="margin-top:4px;z-index:20;"
        onclick="$R.form('wgt-form-upload-dump-<?php echo $VAR->dbName ?>-<?php echo $VAR->schemaName ?>');"
        id="wgt-button-upload-dump-<?php echo $VAR->dbName ?>-<?php echo $VAR->schemaName ?>" >Upload <?php echo $iconUpload ?></button>
      
    </div>
  
</div>


<table id="wgt-table-db_dumps-<?php echo $VAR->dbName ?>-<?php echo $VAR->schemaName ?>" class="wgt-space wgt-table" style="width:550px;" >
  <thead>
    <tr>
      <th class="col" >Col</th>
      <th>Name</th>
      <th>Created</th>
      <th>Size</th>
      <th>Nav.</th>
    </tr>
  </thead>
  <tbody>
  <?php $pos = 1; foreach( $VAR->dumps as /* @var $dump IoFIle */ $dump ){ ?>
    <tr id="wgt-row-<?php echo $VAR->dbName ?>-<?php echo $VAR->schemaName ?>-<?php echo md5($dump->getName()); ?>" >
      <td><?php echo $pos ?></td>
      <td><a href="protected?file=backups/db/<?php echo $VAR->dbName ?>/schemas/<?php echo $VAR->schemaName ?>/<?php echo $dump->getName() ?>" ><?php echo $dump->getName() ?></a></td>
      <td><?php echo date('Y-m-d H:i:s', $dump->getTimeCreated()) ?></td>
      <td><?php echo $dump->getSize('mb'); ?> MB</td>
      <td><button 
        class="wgt-button"
        onclick="$R.put('ajax.php?c=Daidalos.DbSchema.restoreDump&db=<?php echo $VAR->dbName ?>&schema=<?php echo $VAR->schemaName ?>&dump=<?php echo $dump->getName() ?>');" ><?php echo $iconRestore ?></button> | <button 
        
        onclick="$R.del('ajax.php?c=Daidalos.DbSchema.deleteDump&db=<?php echo $VAR->dbName ?>&schema=<?php echo $VAR->schemaName ?>&dump=<?php echo $dump->getName() ?>');"
        class="wgt-button" ><?php echo $iconDel ?></button></td>
    </tr>
  <?php ++$pos; } ?>
  </tbody>
</table>

<!--  
<wgt:for each="narf" as="fuu" >
  <wgt:out var="fuu.bar()" />
</wgt:for>
-->