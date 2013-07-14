<?php

$uplForm = new WgtFormBuilder
(
  $this,
  'ajax.php?c=Webfrap.Attachment.saveFile&amp;attachid='.$VAR->attachmentId.$VAR->preUrl.$VAR->paramTypeFilter,
  'wgt-form-wbf-attachment-edit-file',
  'post'
);
$uplForm->form();

$typeData = $uplForm->loadQuery( 'WebfrapFileType_Selectbox' );
$typeData->fetchSelectbox( $VAR->typeFilter );

$confidentialData = $uplForm->loadQuery( 'WbfsysConfidentialityLevel_Selectbox' );
$confidentialData->fetchSelectbox();

$simpleTabDesc = new WgtSimpleTabContainer($this,'wbf-attachment-edit-file-type');
$simpleTabDesc->data = $typeData->getAll();


?>


<fieldset>
  <legend>Upload File</legend>

  <?php $uplForm->hidden
    (
      'objid',
     $VAR->file->getId()
    ); ?>

  <table style="width:100%;" >
    <tr>
      <td colspan="2" >
        <?php $uplForm->upload( 'File', 'file', $VAR->file->name,  array(), array('size'=>'large') ); ?>

      </td>
    </tr>
    <tr>
      <td valign="top" style="width:330px;" >
        <?php $uplForm->selectboxByKey
        (
        	'Type',
        	'type',
        	'WebfrapFileType_Selectbox',
         $typeData->getAll(),
         $VAR->file->id_type,
         array('class'=>'wcm wcm_ui_selection_tab','wgt_body'=>'wbf-attachment-edit-file-type')
        ); ?>

        <?php $uplForm->selectboxByKey
        (
        		'Confidentiality Level',
        		'id_confidentiality',
        		'WbfsysConfidentialityLevel_Selectbox',
          $confidentialData->getAll()  ,
           $VAR->file->id_confidentiality
        ); ?>
      </td>
      <td valign="top" >
       	<?php echo $simpleTabDesc->render() ?>
      </td>
    </tr>
    <tr>
      <td colspan="2" >
        <?php $uplForm->textarea
        (
        	 'Description',
        	 'description',
          $VAR->file->getSecure('description'),
          array(),array( 'size' => 'xlarge_nl' )
        ); ?>
      </td>
    </tr>
    <tr>
    	<td></td>
      <td valign="bottom" align="right" >
      	<br />
        <?php $uplForm->submit( 'Upload', '$S.modal.close();' ); ?>
      </td>
    </tr>
  </table>


</fieldset>