<?php 

$uplForm = new WgtFormBuilder
(
  'ajax.php?c=Webfrap.Attachment.saveLink'.$VAR->preUrl.'&amp;attachid='.$VAR->attachmentId.$VAR->paramTypeFilter,
  'wgt-form-wbf-attachment-edit-link',
  'put'
);
$uplForm->form();


$typeData = $uplForm->loadQuery( 'WebfrapFileType_Selectbox' );
$typeData->fetchSelectbox( $VAR->typeFilter );

$storageData = $uplForm->loadQuery( 'WebfrapAttachmentFileStorage_Selectbox' );
$storageData->fetchSelectbox( $VAR->refId );

$confidentialData = $uplForm->loadQuery( 'WbfsysConfidentialityLevel_Selectbox' );
$confidentialData->fetchSelectbox();

?>


<fieldset>
  <legend>Edit Link</legend>
  
  <?php $uplForm->hidden
    ( 
    	'objid', 
     $VAR->link->getId()
    ); ?>
  
    <table style="width:100%" >
      <tr>
        <td colspan="2" >
          <?php $uplForm->input
          ( 
          	'Link', 
          	'link', 
           $VAR->link->link, 
           array(), 
           array( 'size' => 'xlarge' ) 
           ); ?>
        </td>
      </tr>
      <tr>
        <td valign="top" >
          
           <?php $uplForm->selectboxByKey
          ( 
          	'Type', 
          	'id_type', 
          	'WebfrapFileType_Selectbox', 
           $typeData->getAll(), 
           $VAR->link->id_type  
          ); ?>
          
          <?php $uplForm->selectboxByKey
          ( 
          	 'Storage ', 
          	 'id_storage', 
          	 'WbfsysFileStorage_Selectbox', 
            $storageData->getAll(), 
            $VAR->link->id_storage  
          ); ?>
        
          <?php $uplForm->selectboxByKey
          ( 
              'Confidentiality Level', 
              'id_confidentiality', 
              'WbfsysConfidentialityLevel_Selectbox', 
              $confidentialData->getAll(), 
              $VAR->link->id_confidentiality   
          ); ?>
          
          <?php $uplForm->textarea
          ( 
          	 'Description',
          	 'description',
            $VAR->link->description  ,
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
          <?php $uplForm->submit( 'Save Link', '$S.modal.close();' ); ?>
        </td>
      </tr>
    </table>

</fieldset>