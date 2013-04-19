<h2>Date Picker</h2>

<p>Simple Datepicker</p>

<input type="text" class="wcm wcm_ui_date" />

<p>Datepicker Multi Month</p>

<input id="wgt-inp-example-dp-mm" type="text" class="wcm wcm_ui_date wgt_multi" />


<p>Datepicker Absolute Constraints</p>

<input id="wgt-inp-example-dp-minmax" type="text" class="wcm wcm_ui_date" /><var>{ "minDate": "2013-03-05", "maxDate": "2013-04-30", "numberOfMonths": 3 }</var>

<p>Datepicker Relativ Constraints</p>
<input id="wgt-inp-example-dp-minmax1" type="text" class="wcm wcm_ui_date" /><var>{ "minDate": -20, "maxDate": "+1M +10D", "numberOfMonths": 3 }</var>


<p>Date Range</p>

<span>Start</span>
<input 
	id="wgt-inp-example-dr-mm"
	wgt_end_node="wgt-inp-example-dr-end" 
	type="text" 
	class="wcm wcm_ui_date_range" /><button class="wgt-button append" id="wgt-inp-example-dr-mm-ap-button" ><i class="icon-calendar" ></i></button>
	
<span>End</span>
<input 
	id="wgt-inp-example-dr-end"
	type="text" /><button class="wgt-button append" id="wgt-inp-example-dr-end-ap-button" ><i class="icon-calendar" ></i></button>
	
	
<p>Embeded Calendar</p>

<div class="wcm wcm_ui_date" id="wgt-inp-example-dr-embed" ><var class="opt_options" >{ "altField": "#wgt-inp-example-dr-embed-val" }</var></div>
<input type="text" id="wgt-inp-example-dr-embed-val"   />