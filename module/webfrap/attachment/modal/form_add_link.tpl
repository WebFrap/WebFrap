<?php 

$orm = $this->getOrm();
$uplForm = new WgtFormBuilder
(
  $this,
  'ajax.php?c=Webfrap.Attachment.addLink'.$VAR->preUrl.$VAR->paramTypeFilter,
  'wgt-form-wbf-attachment-add-link',
  'post'
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
  <legend>Add Link</legend>
  
    <table style="width:100%" >
      <tr>
        <td colspan="2" >
          <?php $uplForm->input( 'Link', 'link', null, array(), array( 'size' => 'xlarge' )  ); ?>
        </td>
      </tr>
      <tr>
        <td valign="top" >
          <?php $uplForm->selectboxByKey( 'Type', 'id_type', 'WebfrapFileType_Selectbox', $typeData->getAll()  ); ?>
          <?php $uplForm->selectboxByKey( 'Storage', 'id_storage', 'WbfsysFileStorage_Selectbox', $storageData->getAll()  ); ?>
          <?php $uplForm->selectboxByKey
          ( 
          		'Confidentiality Level', 
          		'id_confidentiality', 
          		'WbfsysConfidentialityLevel_Selectbox', 
            $confidentialData->getAll(),
            $orm->getIdByKey( 'WbfsysConfidentialityLevel', 'restricted' ) 
          ); ?>
          <?php $uplForm->textarea( 'Description', 'description',null,array(),array( 'size' => 'xlarge_nl' ) ); ?>
        </td>
        <td valign="top" >
        </td>
      </td>
      <tr>
        <td>
        </td>
        <td valign="bottom" align="right" >
          <?php $uplForm->submit( 'Add Link', '$S.modal.close();' ); ?>
        </td>
      </tr>
    </table>

</fieldset>