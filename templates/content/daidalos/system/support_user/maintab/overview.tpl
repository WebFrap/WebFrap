<?php 


$packageForm = new WgtFormBuilder
(
  'ajax.php?c=Daidalos.SupportUser.update', 
  'wgt-form-daidalos_support_user-update'
);

$packageForm->form();

?>


<div>

  <fieldset class="wgt-space bw61" >
    <legend>Support User</legend>
    
    <div class="bw3 left" >
      <?php $packageForm->input('Name','name'); ?>
      <?php $packageForm->input('Type','type'); ?>
    </div>
    <div class="bw3 inline" >
      <?php $packageForm->input('Start','start_time'); ?>
      <?php $packageForm->input('End','finish_time'); ?>
    </div>
    
  </fieldset>


</div>
 
  
