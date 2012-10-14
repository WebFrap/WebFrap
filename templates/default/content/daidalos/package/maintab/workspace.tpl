<?php 

$iconEdit = $this->icon( 'control/edit.png', 'Edit' );
$iconSync = $this->icon( 'control/sync.png', 'Sync' );
$iconList = $this->icon( 'control/mask_table.png', 'List' );

?>

<div class="wgt-panel title wgt-border-top" >
<h3>Module Packages</h3>
</div>

<table id="wgt-table-daidlos-packages" class="wcm wcm_ui_grid wgt-space wgt-table bw7" >
  <thead>
    <tr>
      <th class="pos" style="width:30px;" >Pos:</th>
      <th>Name</th>
      <th>Full Name</th>
      <th style="width:90px;" >Nav</th>
    </tr>
  </thead>
  <tbody>
  <?php $pos = 1; foreach( $VAR->packages as /* @var $package DaidalosPackage_File */ $package ){ ?>
    <tr class="row<?php echo 1+$pos%2; ?>" >
      <td><?php echo $pos ?></td>
      <td><?php echo $package->getName(); ?></td>
      <td><?php echo $package->getFullName(); ?></td>
      <td><button 
        class="wgt-button"
        onclick="$R.put('ajax.php?c=Daidalos.Package.syncPackageFiles&type=module&package=<?php echo $package->getName(); ?>');" ><?php echo $iconSync ?></button><button 
        
        class="wgt-button"
        onclick="$R.get('maintab.php?c=Daidalos.Package.edit&type=module&package=<?php echo $package->getName(); ?>');" ><?php echo $iconEdit ?></button><button 
        
        class="wgt-button"
        onclick="$R.get('modal.php?c=Daidalos.Package.listPackages&type=module&package=<?php echo $package->getName(); ?>');" ><?php echo $iconList ?></button></td>
    </tr>
  <?php ++$pos; } ?>
  </tbody>
</table>


<div class="wgt-panel title wgt-border-top" >
<h3>Application Packages</h3>
</div>

<table id="wgt-table-daidlos-app-packages" class="wcm wcm_ui_grid wgt-space wgt-table bw7" >
  <thead>
    <tr>
      <th class="pos" style="width:30px;" >Pos:</th>
      <th>Name</th>
      <th>Full Name</th>
      <th style="width:90px;" >Nav</th>
    </tr>
  </thead>
  <tbody>
  <?php $pos = 1; foreach( $VAR->appPackages as /* @var $package DaidalosPackage_File */ $package ){ ?>
    <tr class="row<?php echo 1+$pos%2; ?>" >
      <td><?php echo $pos ?></td>
      <td><?php echo $package->getName(); ?></td>
      <td><?php echo $package->getFullName(); ?></td>
      <td><button 
        class="wgt-button"
        onclick="$R.put('ajax.php?c=Daidalos.Package.syncPackageFiles&type=app&package=<?php echo $package->getName(); ?>');" ><?php echo $iconSync ?></button><button 
        
        class="wgt-button"
        onclick="$R.get('maintab.php?c=Daidalos.Package.edit&type=app&package=<?php echo $package->getName(); ?>');" ><?php echo $iconEdit ?></button><button 
        
        class="wgt-button"
        onclick="$R.get('modal.php?c=Daidalos.Package.listPackages&type=app&package=<?php echo $package->getName(); ?>');" ><?php echo $iconList ?></button></td>
    </tr>
  <?php ++$pos; } ?>
  </tbody>
</table>






