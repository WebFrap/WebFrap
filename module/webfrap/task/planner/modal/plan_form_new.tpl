<?php 

$orm = $this->getOrm();
$planForm = new WgtFormBuilder
(
  $this,
  'ajax.php?c=Webfrap.TaskPlanner.insert',
  'wgt-form-wbf-taskplanner-create',
  'post'
);
$planForm->form();



?>


<fieldset>
  <legend>Add Link</legend>
  
    <div class="wgt-layout-grid" >
      <div>
        <div>
          <?php $planForm->input( 'Link', 'link', null, array(), array( 'size' => 'xlarge' )  ); ?>
        </div>
      </div>
      <tr>
        <td valign="top" >
          <?php $planForm->textarea( 'Description', 'description',null,array(),array( 'size' => 'xlarge_nl' ) ); ?>
        </td>
        <td valign="top" >
        </td>
      </td>
      <tr>
        <td>
        </td>
        <td valign="bottom" align="right" >
          <?php $planForm->submit( 'Create Plan', '$S.modal.close();', 'controlls/add.png' ); ?>
        </td>
      </tr>
    </table>

</fieldset>