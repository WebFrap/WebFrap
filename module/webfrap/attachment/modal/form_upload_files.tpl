<?php

$orm = $this->getOrm();
$uplForm = new WgtFormBuilder
(
  $this,
  'ajax.php?c=Webfrap.Attachment.uploadFile'.$VAR->preUrl.$VAR->paramTypeFilter,
  'wgt-form-wbf-attachment-add-file',
  'post'
);
$uplForm->form();


$typeData = $uplForm->loadQuery( 'WebfrapFileType_Selectbox' );
$typeData->fetchSelectbox( $VAR->typeFilter );

$confidentialData = $uplForm->loadQuery( 'WbfsysConfidentialityLevel_Selectbox' );
$confidentialData->fetchSelectbox();

$simpleTabDesc = new WgtSimpleTabContainer($this,'wbf-attachment-add-file-type');
$simpleTabDesc->data = $typeData->getAll();

?>

<fieldset>
  <legend>Upload File</legend>

  <table style="width:100%;" >
    <tr>
      <td colspan="2" ><?php $uplForm->upload( 'File', 'file' ); ?></td>
    </tr>
    <tr>
      <td valign="top" style="width:330px;" >
        <?php $uplForm->selectboxByKey(
          'Type',
          'type',
          'WebfrapFileType_Selectbox',
          $typeData->getAll(),
          null,
          array('class'=>'wcm wcm_ui_selection_tab','wgt_body'=>'wbf-attachment-add-file-type')
        ); ?>
        <?php $uplForm->selectboxByKey(
          'Confidentiality Level',
          'id_confidentiality',
          'WbfsysConfidentialityLevel_Selectbox',
          $confidentialData->getAll(),
          $orm->getIdByKey( 'WbfsysConfidentialityLevel', 'restricted' )
        ); ?>
      </td>
      <td valign="top" >
        <?php echo $simpleTabDesc->render() ?>
      </td>
    </tr>
    <tr>
      <td colspan="2" >
        <?php $uplForm->textarea( 'Description', 'description', null, array(), array( 'size' => 'xlarge_nl' ) ); ?>
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