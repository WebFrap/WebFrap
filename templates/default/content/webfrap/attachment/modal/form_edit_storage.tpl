<?php 

$uplForm = new WgtFormBuilder
(
  'ajax.php?c=Webfrap.Attachment.saveStorage&amp;element='.$VAR->elementKey,
  'wgt-form-wbf-attachment-edit-storage',
  'put'
);
$uplForm->form();


$typeData = $uplForm->loadQuery( 'WbfsysFileStorageType_Selectbox' );
$typeData->fetchSelectbox();


$confidentialData = $uplForm->loadQuery( 'WbfsysConfidentialityLevel_Selectbox' );
$confidentialData->fetchSelectbox();

?>


<fieldset>
  <legend>Edit Storage Location</legend>
  
  <?php $uplForm->hidden
    ( 
    	'objid', 
     $VAR->storage->getId()
    ); ?>
  
    <table style="width:100%" >
      <tr>
        <td colspan="2" >
          <?php $uplForm->input
          ( 
          	'Link', 
          	'link', 
           $VAR->storage->link, 
           array(), 
           array( 'size' => 'xlarge' ) 
           ); ?>
        </td>
      </tr>
      <tr>
        <td valign="top" >
          
           <?php $uplForm->input
          ( 
            'Name', 
            'name', 
             $VAR->storage->name
          ); ?>
          
           <?php $uplForm->selectboxByKey
          ( 
          	'Type', 
          	'id_type', 
          	'WbfsysFileStorageType_Selectbox', 
           $typeData->getAll(), 
           $VAR->storage->id_type  
          ); ?>
          
          <?php $uplForm->selectboxByKey
          ( 
              'Confidentiality Level', 
              'id_confidentiality', 
              'WbfsysConfidentialityLevel_Selectbox', 
              $confidentialData->getAll(), 
              $VAR->storage->id_confidentiality   
          ); ?>
          
          <?php $uplForm->textarea
          ( 
          	 'Description',
          	 'description',
            $VAR->storage->description,
            array(),array( 'size' => 'xlarge_nl' )  
          ); ?>
          
        </td>
        <td valign="top" >
        </td>
      </td>
      <tr>
        <td>
        </td>
        <td valign="bottom" align="right" >
          <?php $uplForm->submit( 'Save Storage', '$S.modal.close();' ); ?>
        </td>
      </tr>
    </table>

</fieldset>