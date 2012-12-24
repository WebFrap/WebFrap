<?php 

$orm = $this->getOrm();
$planForm = new WgtFormBuilder
(
  $this,
  'ajax.php?c=Webfrap.TaskPlanner.insertPlan',
  'wgt-form-wbf-taskplanner-create',
  'post'
);
$planForm->form();

?>
<div class="wgt-panel" >
  <h2>New Plan</h2>
</div>

<div class="wgt-clear small" >&nbsp;</div>

<div class="wgt-layout-grid bw62" >
  
  <div>
	  <?php $planForm->input( 'Title', 'title', null, array(), array( 'size' => 'xlarge' )  ); ?>
  </div>
  
  <div>
    <div class="left" >
      <?php $planForm->checkbox
      ( 
      	'Series', 
      	'flag_series', 
        false, 
        array( 
        	'class' => 'wcm wcm_control_toggle',
        	'wgt_target' => '.wgt-box-dateplanner-series' 
      )); ?>
    </div>
    <div class="inline wgt-box-dateplanner-series" >
      <?php $planForm->checkbox
      ( 
        'Advanced', 
        'advanced', 
        false, 
        array( 
          'class' => 'wcm wcm_control_toggle',
          'wgt_target' => '.wgt-box-dateplanner-advanced' 
      )); ?>
    </div>
  <div>
  
  <div class="wgt-box-dateplanner-series"  class="bw6" >
      
    <div>
    <div class="left" >
      <?php $planForm->richInput
      ( 
      	'date_timepicker', 
      	'Start', 
      	'timestamp_start',
        null,
        array(),
        array(
          'size' => 'medium',
          'button' => 'control/calendar.png' 
        ) 
      ); ?>
    </div>
    <div class="inline" >
      <?php $planForm->richInput
      ( 
      	'date_timepicker', 
      	'End', 
      	'timestamp_end',
        null,
        array(),
        array(
        	'size' => 'medium',
          'button' => 'control/calendar.png' 
        ) 
      ); ?>
    </div>
    </div>
    

    
  </div>
  <div class="wgt-box-dateplanner-series"  class="bw6" wgt_hidden="true" >
    <?php $planForm->richInput
      ( 
        'date_timepicker', 
        'Time', 
        'trigger_time',
        null,
        array(),
        array(
          'size' => 'medium',
          'button' => 'control/calendar.png' 
        ) 
      ); ?>
  </div>
  
</div>
    

<div class="wgt-clear small sep-bottom" >&nbsp;</div>
<div class="wgt-clear small" >&nbsp;</div>
<h3>Actions</h3>

<div class="wgt-box bw62"  >
<?php $planForm->textarea
    ( 
      'Actions', 
      'actions',
      null,
      array(),
      array( 'size' => 'xxlarge' 
    )); ?>
</div>

<div class="wgt-clear small sep-bottom" >&nbsp;</div>
<div class="wgt-clear small" >&nbsp;</div>
<h3>Description</h3>
  <div class="left" >
    <?php $planForm->textarea
    ( 
      'Description', 
      'description',
      null,
      array(),
      array( 'size' => 'xxlarge' 
    )); ?>
  </div>

<div class="wgt-clear small sep-bottom" >&nbsp;</div>
<div class="wgt-clear small" >&nbsp;</div>

<div>
  <?php $planForm->submit( 'Create Plan', '$S.modal.close();', 'control/save.png' ); ?>
  or <span onclick="$S.modal.close();" class="wgt-clickable" >Chancel</span>
</div>

