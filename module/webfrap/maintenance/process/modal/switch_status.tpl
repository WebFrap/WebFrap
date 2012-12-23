<?php 

$orm = $this->getOrm();
$uplForm = new WgtFormBuilder
(
  $this,
  'ajax.php?c=Webfrap.Maintenance_Process.changeStatus',
  'wgt-form-wbf-process-stat-changer',
  'put'
);
$uplForm->form();


$nodeData = $uplForm->loadQuery( 'WebfrapMaintenance_ProcessNode_Selectbox' );
$nodeData->fetchSelectbox( $this->model->process );


?>

<fieldset>
  <legend>Proecss: <strong><?php echo $this->model->process->name ?></strong></legend>
  
    <div class="wgt-box info" >
      Here you can change/correct the Status of the Process to every process status.<br />
      This mask can overwrite the process internal edges.<br />
      Using this mask <strong>none</strong> of the constraints will be checked and <strong>none</strong> of the actions will be triggert.<br />
      This is a maintenance feature. <strong>Do NOT use</strong>  this mask for your daily work.
    </div>
    
    <?php $uplForm->hidden( 'id_status', $this->model->processStatus->getId() ); ?>
    <?php $uplForm->hidden( 'dkey', $this->model->domainNode->domainName ); ?>
  
    <div class="wgt-layout-grid" >
      <div>
        <div>
          <?php $uplForm->decorateInput
          ( 
            $this->model->domainNode->label, 
            'dataset', 
            "<strong>".$this->model->entity->text()."</strong>",
            array( "size"=> "big" )
          ); ?>
        </div>
      </div>
      <div>
        <div>
          <?php $uplForm->decorateInput( 'Actual Status', 'status', "<strong>".$this->model->processNode->label."</strong>" ); ?>
        </div>
      </div>
      <div>
        <div valign="top" >
          <?php $uplForm->selectboxByKey( 'Change To', 'id_new', 'WgtSelectbox', $nodeData->getAll()  ); ?>
          <?php $uplForm->textarea( 'Change Comment', 'comment', null, array(), array( 'size' => 'xlarge_nl' ) ); ?>
        </div>
      </div>
      <div style="margin-top:20px;" >
        <div valign="bottom" align="right" >
          <?php $uplForm->submit( 'Change Status', '$S.modal.close();' ); ?>
        </div>
      </div>
    </div>

</fieldset>