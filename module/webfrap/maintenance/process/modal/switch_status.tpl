<?php 

$orm = $this->getOrm();
$uplForm = new WgtFormBuilder
(
  'ajax.php?c=Webfrap.Maintenance_Process.changeStatus',
  'wgt-form-wbf-process-stat-changer',
  'post'
);
$uplForm->form();


$nodeData = $uplForm->loadQuery( 'WebfrapMaintenance_ProcessNode_Selectbox' );
$nodeData->fetchSelectbox( $this->model->process );


?>


<fieldset>
  <legend>Change Status for Process: <strong><?php echo $this->model->process->name ?></strong></legend>
  
    <p class="info" >Here you can change/correct the Status of the Process to every process status.</p>
    
    <?php $uplForm->hidden( 'vid', $this->model->entity->getId() ); ?>
    <?php $uplForm->hidden( 'id_status', $this->model->processStatus->getId() ); ?>
    <?php $uplForm->hidden( 'id_process', $this->model->process->getId() ); ?>
  
    <div class="wgt-layout-grid" >
      <div>
        <div>
          <?php $uplForm->decorateInput( $this->model->domainNode->label, 'dataset', "<strong>".$this->model->entity->text()."</strong>" ); ?>
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
      <div>
        <div valign="bottom" align="right" >
          <?php $uplForm->submit( 'Change Status', '$S.modal.close();' ); ?>
        </div>
      </div>
    </div>

</fieldset>