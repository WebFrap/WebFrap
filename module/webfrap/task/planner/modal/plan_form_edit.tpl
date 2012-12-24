<?php 
$orm = $this->getOrm();

$planForm = new WgtFormBuilder
(
  $this,
  'ajax.php?c=Webfrap.TaskPlanner.updatePlan&objid='.$this->plan,
  'wgt-form-wbf-taskplanner-edit-'.$this->plan,
  'put'
);
$planForm->form();

?>
<div class="wgt-panel" >
  <h2>Edit Plan: "<?php echo $this->plan->title ?>"</h2>
</div>

<div class="wgt-clear small" >&nbsp;</div>

<div class="wgt-layout-grid bw62" >
  
  <div>
	  <?php $planForm->input( 'Title', 'title', $this->plan->title, array(), array( 'size' => 'xlarge' )  ); ?>
  </div>
  
  <div>
    <?php $planForm->checkbox
    ( 
    	'Series', 
    	'flag_series', 
      $this->plan->flag_series, 
      array( 
      	'class' => 'wcm wcm_control_toggle',
      	'wgt_target' => '#wgt-box-dateplanner-series2' 
    )); ?>
  </div>
  
  <div id="wgt-box-dateplanner-series2" class="bw6" >
  
    <div class="left" >
      <?php $planForm->richInput
      ( 
      	'date_timepicker', 
      	'Start', 
      	'timestamp_start',
        $this->plan->timestamp_start,
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
        $this->plan->timestamp_end,
        array(),
        array(
        	'size' => 'medium',
          'button' => 'control/calendar.png' 
        ) 
      ); ?>
    </div>
    
  </div>
  
  <div class="left" >
    <?php $planForm->textarea
    ( 
    	'Description', 
    	'description',
      $this->plan->description,
      array(),
      array( 'size' => 'xlarge_nl' 
    )); ?>
  </div>
  
</div>
    

<div class="wgt-clear small sep-bottom" >&nbsp;</div>
<div class="wgt-clear small" >&nbsp;</div>
<h3>Actions</h3>

<div class="wgt-box bw62" style="height:190px;" >

</div>

<div class="wgt-clear small sep-bottom" >&nbsp;</div>
<div class="wgt-clear small" >&nbsp;</div>

<div>
  <?php $planForm->submit( 'Update Plan', '$S.modal.close();', 'control/save.png' ); ?>
  or <span class="wgt-clickable" onclick="$S.modal.close();" >Chancel</span>
</div>

