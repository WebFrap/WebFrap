<?php 

$iconDel     = $this->icon( 'control/delete.png', 'Delete' );
$iconUpload  = $this->icon( 'control/upload.png', 'Upload' );

$packageForm = new WgtRenderForm
(
  'ajax.php?c=Daidalos.Package.update&type='.$VAR->type.'&package='.$VAR->packageKey, 
  'wgt-form-daidalos_package_edit-'.$VAR->packageKey
);

$packageForm->form();

?>

<div id="<?php echo $this->tabId?>" class="wcm wcm_ui_tab" >
  <div class="wgt_tab_body" >

  <div
    class="wgt_tab <?php echo $this->tabId ?>"
    id="<?php echo $this->tabId ?>-tab-base_data"
    title="Form"
     >

    <fieldset class="wgt-space bw61" >
      <legend>Base data</legend>
      
      <div class="bw3 left" >
        <?php $packageForm->input('Name','name',$VAR->package->getName()); ?>
        <?php $packageForm->input('Label','label',$VAR->package->getLabel()); ?>
        <?php $packageForm->input('Full Name','full_name',$VAR->package->getFullname()); ?>
      </div>
      <div class="bw3 inline" >
        <?php $packageForm->input('Type','type',$VAR->package->getType()); ?>
        <?php $packageForm->input('Version','version',$VAR->package->getVersion()); ?>
        <?php $packageForm->input('Revision','revision',$VAR->package->getRevision()); ?>
      </div>
      
    </fieldset>

    <fieldset class="wgt-space bw61" >
      <legend>Licence & Author</legend>
      
      <div class="bw6 left" >
        <?php $packageForm->input('Author','author',$VAR->package->getAuthor(),'xlarge'); ?>
        <?php $packageForm->input('Project Manager','project_manager',$VAR->package->getProjectManager(),'xlarge'); ?>
        <?php $packageForm->input('Copyright','copyright',$VAR->package->getCopyright(),'xlarge'); ?>
      </div>
      
    </fieldset>

     </div>
     
     <div
      class="wgt_tab <?php echo $this->tabId ?>"
      id="<?php echo $this->tabId ?>-tab-packages"
      title="Packages"
       >

      <table 
        id="wgt-table-daidalos-package-<?php echo $VAR->packageKey ?>-packages" 
        class="wgt-space wgt-table bw6"  >
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
          <tr id="wgt-row-daidalos-package-<?php echo $VAR->packageKey ?>-<?php echo md5($pFile->getName(false)); ?>" >
            <td><?php echo $pos ?></td>
            <td><a href="protected.php?file=package/<?php echo $VAR->type ?>/<?php echo $VAR->packageKey ?>/<?php echo $pFile->getName(false) ?>" ><?php echo $pFile->getName(false) ?></a></td>
            <td><?php echo date('Y-m-d H:i:s', $pFile->getTimeCreated() ); ?></td>
            <td><?php echo $pFile->getSize('mb'); ?> MB</td>
            <td><button 
              onclick="$R.del('ajax.php?c=Daidalos.Package.deletePackage&type=<?php echo $VAR->type ?>&package=<?php echo $VAR->packageKey ?>&file=<?php echo $pFile->getName(false) ?>');"
              class="wgt-button" ><?php echo $iconDel ?></button></td>
          </tr>
        <?php ++$pos; } ?>
        </tbody>
      </table>

     </div>
     
    </div>
  </div>
  
  
  
<?php
WgtTplModal::start(); 
 
$buildForm = new WgtRenderForm
(
  'ajax.php?c=Daidalos.Package.build&type='.$VAR->type.'&package='.$VAR->packageKey, 
  'wgt-form-daidalos_package_build-'.$VAR->packageKey,
  'put'
);
$buildForm->form();
?> 

<fieldset class="wgt-space bw4" >
  <legend>Build</legend>
  
  <div class="bw4 left" >
    <?php $buildForm->input('Key','key',time()); ?>
  </div>

<?php $buildForm->submit( 'Build Package', 'daidalos/build.png',array(),'$S.modal.close();' ); ?>
  
</fieldset>

<?php WgtTplModal::render( 'daidalos-package-'.$VAR->packageKey );?>