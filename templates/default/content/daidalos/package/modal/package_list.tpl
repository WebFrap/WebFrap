<?php 
$iconDel     = $this->icon( 'control/delete.png', 'Delete' );
$iconUpload  = $this->icon( 'control/upload.png', 'Upload' );

$uploadForm = new WgtRenderForm
(
  'ajax.php?c=Daidalos.Package.uploadPackage&type'.$VAR->type.'&package='.$VAR->packageKey, 
  'daidalos_package_upload-'.$VAR->packageKey,
  'post'
);


?>


<div class="wgt-space" style="width:550px;"  >

  <?php $uploadForm->form(); ?>

    
    <div style="padding-top:10px;padding-bottom:20px;" >
    
      <?php 
      
      $uploadForm->upload
      ( 
        'Dump',
        'dump',
        null,
        array(),
        true  
      );
      
      $uploadForm->submit
      ( 
        'Upload',
        'control/upload.png',
        array( 'style'=> 'margin-top:4px;z-index:20;' )
      );
      
      /*
      <button
        class="wgt-button"
        style="margin-top:4px;z-index:20;"
        onclick="$R.form('wgt-form-upload-dump-<?php echo $VAR->dbName ?>-<?php echo $VAR->schemaName ?>');"
        id="wgt-button-upload-dump-<?php echo $VAR->dbName ?>-<?php echo $VAR->schemaName ?>" >Upload <?php echo $iconUpload ?></button>
      
       */
        
      ?>
      

    </div>
  
</div>


<table 
  id="wgt-table-daidalos-packages-<?php echo $VAR->packageKey ?>" 
  class="wgt-space wgt-table" 
  style="width:550px;" >
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
  <?php $pos = 1; foreach( $VAR->packages as $package ){ $pFile = new IoFile( $package ); ?>
    <tr id="wgt-row-<?php echo $VAR->packageKey ?>-<?php echo md5($package); ?>" >
      <td><?php echo $pos ?></td>
      <td><a href="protected.php?file=package/<?php echo $VAR->type ?>/<?php echo $VAR->packageKey ?>/<?php echo $pFile->getName(false) ?>" ><?php echo $pFile->getName(false) ?></a></td>
      <td><?php echo date('Y-m-d H:i:s', $pFile->getTimeCreated() ); ?></td>
      <td><?php echo $pFile->getSize('mb'); ?> MB</td>
      <td><button 
        onclick="$R.del('ajax.php?c=Daidalos.DbSchema.deletePackage&type=<?php echo $VAR->type ?>&package=<?php echo $VAR->packageKey ?>&file=<?php echo $package ?>');"
        class="wgt-button" ><?php echo $iconDel ?></button></td>
    </tr>
  <?php ++$pos; } ?>
  </tbody>
</table>

