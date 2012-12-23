<?php 

$orm = $this->getOrm();
$uplForm = new WgtFormBuilder
(
  $this,
  'ajax.php?c=Webfrap.Mediathek_File.insert&amp;media='.$VAR->mediaId.'&amp;element='.$VAR->elementKey,
  'wgt-form-mediathek-file-add',
  'post'
);
$uplForm->form();


$confidentialData = $uplForm->loadQuery( 'WbfsysConfidentialityLevel_Selectbox' );
$confidentialData->fetchSelectbox();

$licenceData = $uplForm->loadQuery( 'WbfsysContentLicence_Selectbox' );
$licenceData->fetchSelectbox();

?>

<fieldset>
  <legend>Upload File</legend>
  
  <table style="width:100%;" >
    <tr>
      <td colspan="2" ><?php $uplForm->upload( 'File', 'file', null, array(), array( 'size' => 'large' )  ); ?></td>
    </tr>
    <tr>
      <td valign="top" >
        <?php $uplForm->selectboxByKey
        ( 
            'Licence', 
            'licence', 
            'WbfsysContentLicence_Selectbox', 
            $licenceData->getAll()  
        ); ?>
        <?php $uplForm->selectboxByKey
        ( 
        		'Confidentiality Level', 
        		'confidential', 
        		'WbfsysConfidentialityLevel_Selectbox', 
          $confidentialData->getAll(),
          $orm->getIdByKey( 'WbfsysConfidentialityLevel', 'public' )   
        ); ?>
      </td>
      <td valign="top" >
      </td>
    </tr>
    <tr>
      <td>
        <?php $uplForm->textarea( 'Description', 'description' ); ?>
      </td>
      <td valign="bottom" >
        <?php $uplForm->submit( 'Add File', '$S.modal.close();' ); ?>
      </td>
    </tr>
  </table>

  
</fieldset>