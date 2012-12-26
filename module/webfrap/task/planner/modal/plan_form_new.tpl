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

$iconDel = $this->icon( 'control/delete.png', "Delete" );

?>
<div class="wgt-panel" >
  <h2>New Plan</h2>
</div>

<div class="wgt-clear small" >&nbsp;</div>

<div class="wgt-layout-grid bw62" >
  
  <div>
	  <?php $planForm->input
	  ( 
	  	'Title', 
	  	'plan[title]', 
	    null, 
	    array(), 
	    array( 
	    	'size' => 'xlarge',
	      'required' => true 
	    )  
	  ); ?>
  </div>
  
  <div>
    <div class="left" >
      <?php $planForm->checkbox
      ( 
      	'Series', 
      	'plan[flag-series]', 
        false, 
        array( 
        	'class' => 'wcm wcm_control_toggle',
        	'wgt_target' => '.wgt-box-dateplanner-series' 
      )); ?>
    </div>
    <div class="inline wgt-box-dateplanner-series" >
      <div class="left" >
        <?php $planForm->checkbox
        ( 
          'Advanced', 
          'plan[flag-advanced]', 
          false, 
          array( 
            'class' => 'wcm wcm_control_toggle',
            'wgt_target' => '.wgt-box-dateplanner-advanced' 
        )); ?>
      </div>
      <div class="inline wgt-box-dateplanner-list" wgt_hidden="true" >
        <div class="wgt-box-dateplanner-advanced" >
        <?php $planForm->checkbox
          ( 
            'By week day', 
            'plan[flag-by_day]', 
            false, 
            array( 
              'class' => 'wcm wcm_control_toggle',
              'wgt_target' => '.wgt-box-dateplanner-by_day' 
          )); ?>
        </div>
      </div>
      <div class="inline wgt-box-dateplanner-advanced" >
        <?php $planForm->checkbox
          ( 
            'Liste', 
            'plan[flag-is_list]', 
            false, 
            array( 
              'class' => 'wcm wcm_control_toggle',
              'wgt_target' => '.wgt-box-dateplanner-list' 
          )); ?>
      </div>
    </div>
  </div>
  
<div class="wgt-clear small sep-bottom" >&nbsp;</div>
<div class="wgt-clear small" >&nbsp;</div>
  
  <div class="wgt-box-dateplanner-series  bw6" >
  
    <div class="wgt-box-dateplanner-list" wgt_hidden="true"  >
      <div class="left" >
        <?php $planForm->richInput
        ( 
        	'date_timepicker', 
        	'Start', 
        	'plan[timestamp_start]',
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
        	'plan[timestamp_end]',
          null,
          array(),
          array(
          	'size' => 'medium',
            'button' => 'control/calendar.png' 
          ) 
        ); ?>
      </div>
    </div>
    
    <div class="wgt-box-dateplanner-advanced left bw62" >
      
      <!-- list of dates -->
      <div class="wgt-box-dateplanner-list left bw62" >
      
        <div class=" left bw2" >
          <h3>List of events</h3>
          <ul id="wgt-inplist-taskp-list" class="wcm wcm_widget_inputlist" >

          </ul>
          <var id="wgt-inplist-taskp-list-cfg-inplist" >
          {"input":"wgt-input-select_task_time"}
          </var>
        </div>
        
        <div class="inline" >
          <?php $planForm->richInput
          ( 
            'date_timepicker', 
            'Select', 
            'select_task_time',
            null,
            array(
             // "onChange" => ""
            ),
            array(
              'size' => 'medium',
              'button' => 'control/calendar.png' 
            ) 
          ); ?>
        </div>
      </div>
  
      <div class="wgt-box-dateplanner-list left bw62" wgt_hidden="true" >

        <h3>Month</h3>
        <div class="wgt-space-bottom" style="width:590px;" >
        <?php echo WgtTplCheckboxMatrix::render
        (
          $this,
          'wgt-chm-months',
          $planForm->asgd(), 
          'plan[series_rule-months]', 
          array(
            array(
              "id" => "jan",
              "value" => "jan",
              "label" => "januar",
            ),
            array(
              "id" => "feb",
              "value" => "feb",
              "label" => "february",
            ),
            array(
              "id" => "mar",
              "value" => "mar",
              "label" => "march",
            ),
            array(
              "id" => "apr",
              "value" => "apr",
              "label" => "april",
            ),
            array(
              "id" => "may",
              "value" => "may",
              "label" => "may",
            ),
            array(
              "id" => "jun",
              "value" => "jun",
              "label" => "june",
            ),
            array(
              "id" => "jul",
              "value" => "jul",
              "label" => "july",
            ),
            array(
              "id" => "aug",
              "value" => "aug",
              "label" => "aug",
            ),
            array(
              "id" => "sep",
              "value" => "sep",
              "label" => "september",
            ),
            array(
              "id" => "oct",
              "value" => "oct",
              "label" => "october",
            ),
            array(
              "id" => "nov",
              "value" => "nov",
              "label" => "november",
            ),
            array(
              "id" => "dec",
              "value" => "dec",
              "label" => "december",
            ),
          )
        ); ?>
        </div>
        
        <div class="wgt-box-dateplanner-by_day" >
          <h3>Week</h3>
          <div class="wgt-space-bottom" >
          <?php echo WgtTplCheckboxMatrix::render
          (
            $this,
            'wgt-chm-occurrence',
            $planForm->asgd(), 
            'plan[series_rule-month_weeks]', 
            array(
              array(
                "id" => "1",
                "value" => "1",
                "label" => "1",
              ),
              array(
                "id" => "2",
                "value" => "2",
                "label" => "2",
              ),
              array(
                "id" => "3",
                "value" => "3",
                "label" => "3",
              ),
              array(
                "id" => "4",
                "value" => "4",
                "label" => "4",
              )
            )
          ); ?>
          </div>
        </div>
        
        <div class="wgt-box-dateplanner-by_day" >
          <h3>Days</h3>
          <div class="wgt-space-bottom" >
          <?php echo WgtTplCheckboxMatrix::render
          (
            $this,
            'wgt-chm-days',
            $planForm->asgd(), 
            'plan[series_rule-week_days]', 
            array(
              array(
                "id" => "mo",
                "value" => "mo",
                "label" => "monday",
              ),
              array(
                "id" => "tu",
                "value" => "tu",
                "label" => "tuesday",
              ),
              array(
                "id" => "we",
                "value" => "we",
                "label" => "wednesday",
              ),
              array(
                "id" => "th",
                "value" => "th",
                "label" => "thursday",
              ),
              array(
                "id" => "fr",
                "value" => "fr",
                "label" => "friday",
              ),
              array(
                "id" => "sa",
                "value" => "sa",
                "label" => "saturday",
              ),
              array(
                "id" => "su",
                "value" => "su",
                "label" => "sunday",
              ),
            )
          ); ?>
          </div>
        </div>

        <div class="bw62 wgt-space-bottom" >
          <div class="left bw2 wgt-box-dateplanner-by_day" wgt_hidden="true" >
            <h3>Days</h3>
            <div style="width:200px;" >
            <?php echo WgtTplRangeMatrix::render( 
              $this, 
              1,31,1,
              'wgt-mtrx-month_day-taskplanner', 
              'plan[series_rule-days]', 
              $planForm->asgd() ) 
            ?>
            </div>
          </div>
          <div class="inline bw2" >
            <h3>Hours</h3>
            <div style="width:180px;" >
            <?php echo WgtTplRangeMatrix::render( 
              $this, 
              1,24,1,
              'wgt-mtrx-month_day-taskplanner', 
              'plan[series_rule-hours]', 
              $planForm->asgd() ) 
            ?>
            </div>
          </div>
          <div class="inline bw2" >
            <h3>Minutes</h3>
            <div style="width:300px;" >
            <?php echo WgtTplRangeMatrix::render( 
              $this, 
              1,60,1,
              'wgt-mtrx-hour_min-taskplanner', 
              'plan[series_rule-minutes]', 
              $planForm->asgd() ) 
            ?>
            </div>
          </div>
        </div>
        
      </div>
    </div>

    <div class="wgt-box-dateplanner-advanced left bw62" wgt_hidden="true" >
      <?php $planForm->selectboxByKey
      ( 
      	'Type', 
      	'plan[series_rule-id_type]', 
      	'WebfrapTaskPlanner_Type_Selectbox', 
        ETaskType::$labels 
      ); ?>
    </div>
    
  </div>
  
  <div class="wgt-box-dateplanner-series bw6"  wgt_hidden="true" >
    <?php $planForm->richInput
      ( 
        'date_timepicker', 
        'Time', 
        'plan[series_rule-trigger_time]',
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
      'plan[actions]',
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
      'plan[description]',
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

