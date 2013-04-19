<?php 

$uplForm = new WgtFormBuilder(
  $this,
  'ajax.php?c=Webfrap.Attachment_Connector.insert'.$VAR->preUrl.'&amp;'.$VAR->paramTypeFilter,
  'wgt-form-wbf-attachment-con-create',
  'post'
);
$uplForm->form();


$typeData = $uplForm->loadQuery( 'WebfrapFileType_Selectbox' );
$typeData->fetchSelectbox( $VAR->typeFilter );

?>


<fieldset>
  <legend>Add Attachment</legend>
  
    <table style="width:100%" >
      <tr>
        <td colspan="2" ><?php $uplForm->upload( 'File', 'file' ); ?></td>
      </tr>
      <tr>
        <td valign="top" >
          
           <?php $uplForm->selectboxByKey( 
          	'Type', 
          	'id_type', 
          	'WebfrapFileType_Selectbox', 
            $typeData->getAll() 
          ); ?>
          
          <?php $uplForm->textarea( 
          	 'Description',
          	 'description',
            ''  ,
            array(),array( 'size' => 'xlarge_nl' )
          ); ?>
          
        </td>
        <td valign="top" >
        </td>
      </tr>
      <tr>
        <td>
        </td>
        <td valign="bottom" align="right" >
          <?php $uplForm->submit( 'Add Attachement', '$S.modal.close();' ); ?>
        </td>
      </tr>
    </table>

</fieldset>