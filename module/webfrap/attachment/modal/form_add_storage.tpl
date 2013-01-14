<?php

$orm = $this->getOrm();
$uplForm = new WgtFormBuilder
(
  $this,
  'ajax.php?c=Webfrap.Attachment.addStorage'.$VAR->preUrl,
  'wgt-form-wbf-attachment-add-storage',
  'post'
);
$uplForm->form();


$typeData = $uplForm->loadQuery( 'WbfsysFileStorageType_Selectbox' );
$typeData->fetchSelectbox();

$confidentialData = $uplForm->loadQuery( 'WbfsysConfidentialityLevel_Selectbox' );
$confidentialData->fetchSelectbox();

?>
<fieldset>
  <legend>Add Link</legend>

    <table style="width:100%" >
      <tr>
        <td colspan="2" >
          <?php $uplForm->input
          (
          		'Link',
          		'link',
            null,
            array(),
            array('size'=>'xlarge', 'required' => true  )
          ); ?>
        </td>
      </tr>
      <tr>
        <td valign="top" >
          <?php $uplForm->input
            (
            	'Name',
            	'name',
              null,
              array(),
              array( 'required' => true )
             ); ?>
          <?php $uplForm->selectboxByKey
          (
          	 'Type',
          	 'id_type',
          	 'WbfsysFileStorageType_Selectbox',
             $typeData->getAll()
          ); ?>
          <?php $uplForm->selectboxByKey
          (
          		'Confidentiality Level',
          		'id_confidentiality',
          		'WbfsysConfidentialityLevel_Selectbox',
            $confidentialData->getAll(),
            $orm->getIdByKey( 'WbfsysConfidentialityLevel', 'restricted' ),
            array(),
            array( 'required' => true )
          ); ?>
          <?php $uplForm->textarea
          (
          		'Description',
          		'description',
            null,
            array(),
            array( 'size' => 'xlarge_nl' )
          ); ?>
        </td>
        <td valign="top" >
        </td>
      </tr>
      <tr>
        <td>
        </td>
        <td valign="bottom" align="right" >
          <?php $uplForm->submit( 'Add Storage', '$S.modal.close();' ); ?>
        </td>
      </tr>
    </table>

</fieldset>