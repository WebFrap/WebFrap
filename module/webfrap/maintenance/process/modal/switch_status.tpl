<?php 

$orm = $this->getOrm();
$uplForm = new WgtFormBuilder
(
  'ajax.php?c=Webfrap.Maintenance.changeProcessStatus',
  'wgt-form-wbf-process-stat-changer',
  'post'
);
$uplForm->form();


$nodeData = $uplForm->loadQuery( 'WebfrapMaintenance_ProcessNode_Selectbox' );
$nodeData->fetchSelectbox( $this->processNode );


?>


<fieldset>
  <legend>Change Status for Process: <strong><?php echo $this->processNode->name ?></strong></legend>
  
    <table style="width:100%" >
      <tr>
        <td colspan="2" >
          <?php $uplForm->input( 'Link', 'link', null, array(), array( 'size' => 'xlarge' )  ); ?>
        </td>
      </tr>
      <tr>
        <td valign="top" >
          <?php $uplForm->selectboxByKey( 'New Node', 'id_new', 'WgtSelectbox', $nodeData->getAll()  ); ?>
          <?php $uplForm->textarea( 'Comment', 'comment',null,array(),array( 'size' => 'xlarge_nl' ) ); ?>
        </td>
        <td valign="top" >
        </td>
      </td>
      <tr>
        <td>
        </td>
        <td valign="bottom" align="right" >
          <?php $uplForm->submit( 'Change Status', '$S.modal.close();' ); ?>
        </td>
      </tr>
    </table>

</fieldset>