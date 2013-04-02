<?php 

$orm = $this->getOrm();
$uplForm = new WgtFormBuilder(
  $this,
  'ajax.php?c=Webfrap.Message_Attachment.insert',
  'wbf-msg-attach-add',
  'post'
);
$uplForm->form();


$typeData = $uplForm->loadQuery( 'WebfrapFileType_Selectbox' );
$typeData->fetchSelectbox( );

$confidentialData = $uplForm->loadQuery( 'WbfsysConfidentialityLevel_Selectbox' );
$confidentialData->fetchSelectbox();

$uplForm->hidden('msg', $VAR->msgId);

?>

<fieldset>
  <legend>Attach File</legend>
  
  <table style="width:100%;" >
    <tr>
      <td colspan="2" ><?php $uplForm->upload( 'File', 'file' ); ?></td>
    </tr>
    <tr>
      <td valign="top" >
        <?php 
        $uplForm->selectboxByKey( 
      		'Type', 
      		'type', 
      		'WebfrapFileType_Selectbox', 
          $typeData->getAll()  
        );
        
        $uplForm->selectboxByKey( 
      		'Confidentiality Level', 
      		'id_confidentiality', 
      		'WbfsysConfidentialityLevel_Selectbox', 
          $confidentialData->getAll(),
          $orm->getIdByKey( 'WbfsysConfidentialityLevel', 'public' )   
        ); ?>
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