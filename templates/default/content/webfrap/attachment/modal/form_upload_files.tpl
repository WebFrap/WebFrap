<?php 

$orm = $this->getOrm();
$uplForm = new WgtFormBuilder
(
  'ajax.php?c=Webfrap.Attachment.uploadFile'.$VAR->preUrl.$VAR->paramTypeFilter,
  'wgt-form-wbf-attachment-add-file',
  'post'
);
$uplForm->form();


$typeData = $uplForm->loadQuery( 'WebfrapFileType_Selectbox' );
$typeData->fetchSelectbox( $VAR->typeFilter );

$confidentialData = $uplForm->loadQuery( 'WbfsysConfidentialityLevel_Selectbox' );
$confidentialData->fetchSelectbox();

?>

<fieldset>
  <legend>Upload File</legend>
  
  <table style="width:100%;" >
    <tr>
      <td colspan="2" ><?php $uplForm->upload( 'File', 'file' ); ?></td>
    </tr>
    <tr>
      <td valign="top" >
        <?php $uplForm->selectboxByKey
        ( 
        		'Type', 
        		'type', 
        		'WebfrapFileType_Selectbox', 
          $typeData->getAll()  
        ); ?>
        <?php $uplForm->selectboxByKey
        ( 
        		'Confidentiality Level', 
        		'id_confidentiality', 
        		'WbfsysConfidentialityLevel_Selectbox', 
          $confidentialData->getAll(),
          $orm->getIdByKey( 'WbfsysConfidentialityLevel', 'restricted' )   
        ); ?>
      </td>
      <td valign="top" >
        <?php $uplForm->checkbox( 'Versioning', 'version', 'false' ); ?>
      </td>
    </tr>
    <tr>
      <td>
        <?php $uplForm->textarea( 'Description', 'description', null, array(), array( 'size' => 'xlarge_nl' ) ); ?>
      </td>
      <td valign="bottom" >
        <?php $uplForm->submit( 'Upload', '$S.modal.close();' ); ?>
      </td>
    </tr>
  </table>

  
</fieldset>