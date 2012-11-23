<?php 

$uplForm = new WgtFormBuilder
(
  'ajax.php?c=Webfrap.Mediathek_Image.update&amp;media='.$VAR->mediaId.'&amp;element='.$VAR->elementId,
  'wgt-form-mediathek-image-edit',
  'post'
);
$uplForm->form();

$confidentialData = $uplForm->loadQuery( 'WbfsysConfidentialityLevel_Selectbox' );
$confidentialData->fetchSelectbox();

$licenceData = $uplForm->loadQuery( 'WbfsysContentLicence_Selectbox' );
$licenceData->fetchSelectbox();

?>


<fieldset>
  <legend>Edit Image</legend>
  
  <?php $uplForm->hidden
    ( 
      'objid', 
     $VAR->image->getId()
    ); ?>
  
  <table style="width:100%;" >
    <tr>
      <td colspan="2" >
        <?php $uplForm->input( 'Title', 'title', $VAR->image->title, array(), array( 'size' => 'xlarge' ) ); ?>
      </td>
    </tr>
    <tr>
      <td colspan="2" >
        <?php $uplForm->upload( 'File', 'file', $VAR->image->file, array(), array( 'size' => 'large' ) ); ?>
      </td>
    </tr>
    <tr>
      <td valign="top" >
        <?php $uplForm->selectboxByKey
        ( 
        	'Licence', 
        	'licence', 
        	'WbfsysContentLicence_Selectbox', 
         $licenceData->getAll(),
         $VAR->image->id_licence  
        ); ?>
        
        <?php $uplForm->selectboxByKey
        ( 
        		'Confidentiality Level', 
        		'confidential', 
        		'WbfsysConfidentialityLevel_Selectbox', 
          $confidentialData->getAll()  ,
           $VAR->image->id_confidentiality  
        ); ?>
      </td>
      <td valign="top" >
      </td>
    </tr>
    <tr>
      <td>
        <?php $uplForm->textarea
        ( 
        	 'Description', 
        	 'description',
          $VAR->image->getSecure('description')
        ); ?>
      </td>
      <td valign="bottom" >
        <?php $uplForm->submit( 'Save Image', '$S.modal.close();' ); ?>
      </td>
    </tr>
  </table>

  
</fieldset>