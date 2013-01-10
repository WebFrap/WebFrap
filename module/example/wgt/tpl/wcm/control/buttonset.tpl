<?php 

$iconUser        = $this->icon( 'control/user.png'      , 'User' );
$iconGroup       = $this->icon( 'control/group.png'     , 'Group' );
$iconDset        = $this->icon( 'control/dset.png'      , 'Dset' );


?>

<h2>Buttonset</h2>


    <div 
    	class="wcm wcm_control_buttonset wcm_ui_radio_tab wgt-button-set" 
    	wgt_body="tab-box-radio_tabhead-content"
    	id="wgt-example-buttonset-boxtype" >
      <input 
      	type="radio" 
      	class="wgt-example-buttonset-boxtype" 
      	id="wgt-example-buttonset-boxtype-group"
      	value="box1"
      	name="grouping" 
      	checked="checked" /><label 
      		for="wgt-example-buttonset-boxtype-group" 
      		class="wcm wcm_ui_tip-top"  
      		tooltip="Group by group"  ><?php echo $iconGroup ?></label>
      <input 
      	type="radio" 
      	class="wgt-example-buttonset-boxtype" 
      	id="wgt-example-buttonset-boxtype-user" 
      	value="box2"
      	name="grouping"  /><label 
      		for="wgt-example-buttonset-boxtype-user" 
      		class="wcm wcm_ui_tip-top" 
      		tooltip="Group by user" ><?php echo $iconUser ?></label>
      <input 
      	type="radio"
      	class="wgt-example-buttonset-boxtype" 
      	id="wgt-example-buttonset-boxtype-dset" 
      	value="box3"
      	name="grouping" /><label 
      		for="wgt-example-buttonset-boxtype-dset" 
      		class="wcm wcm_ui_tip-top" 
      		tooltip="Group by Example" ><?php echo $iconDset ?></label>
    </div>
    
<div id="tab-box-radio_tabhead-content" class="bw6 clear wgt-content-box" >

  <div 
    class="container" 
    wgt_key="box1" 
    id="tab-box-radio_tabhead-content-box1" >
    <h3>Box 1</h3>
  </div>
  
  <div 
    class="container" 
    style="display:none;"
    wgt_key="box2" 
    id="tab-box-radio_tabhead-content-box2" >
    <h3>Box 2</h3>
  </div>
  
  <div 
    class="container" 
    style="display:none;" 
    wgt_key="box3" 
    id="tab-box-radio_tabhead-content-box3" >
    <h3>Box 3</h3>
  </div>
</div>
  	
  	