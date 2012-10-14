<fieldset class="wgt-space bw62" >
  <legend>Backup Database <?php echo $VAR->dbKey ?></legend>
  
  <form 
    method="PUT" 
    id="wgt-form-daidalos_db_backup-<?php echo $VAR->dbKey ?>"
    action="maintab.php?c=Daidalos.Db.backup"  />
    
   <div class="bw3 left" >
     <?php echo WgtForm::input
     ( 
       'Prefix', 
       'prefix', 
       date( 'YmdHis-' ),
       array
       ( 
       ),
       'wgt-form-daidalos_db_backup-'.$VAR->dbKey
     ); ?>
   </div>
  
  <div class="bw3 right" >
     <?php echo WgtForm::checkbox
     ( 
       'With Rights', 
       'rights', 
       false,
       array
       ( 
       ),
       'wgt-form-daidalos_db_backup-'.$VAR->dbKey
     ); ?>
  </div>
  
</fieldset>