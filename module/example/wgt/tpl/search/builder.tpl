<div class="wcm wcm_ui_search_builder wgt-space" >
  <h3>Advanced search</h3>
  
	<div style="max-height:250px;">
		<table class="search-container" >
			<thead>
				<tr>
					<th style="width:100px;">And/Or</th>
					<th style="width:120px;">Field</th>
					<th style="width:40px;">Not</th>
          <th style="width:40px;">Cs</th>
					<th style="width:120px;">Condition</th>
					<th style="width:150px;">Value</th>
					<th style="width:75px;">Menu</th>
				</tr>
			</thead>
      <tbody>
      
			</tbody>
    </table>
	</div>

  <div class="left">
    <div class="inline">
      <select class="wd-fields wcm wcm_widget_selectbox">
        <option></option>
        <optgroup label="Message">
          <option value="title" type="text" >Title</option>
          <option value="sender" type="text" >Sender</option>
          <option value="receiver" type="text" >Receiver</option>
          <option value="date_received"  type="date" >Date Receiver</option>
          <option value="date_updated" type="date" >Date Updated</option>
        </optgroup>
        <optgroup label="Appointment">
          <option value="appoint_deadline" type="date" >Deadline</option>
          <option value="sender" type="text" >Sender</option>
          <option value="receiver" type="text" >Receiver</option>
          <option value="date_received" type="date" >Date receiver</option>
          <option value="date_updated" type="date" >Date updated</option>
          <option value="full_day" type="boolean" >Full day</option>
          <option value="part_required" type="boolean" >Participation required</option>
        </optgroup>
        <optgroup label="Task">
          <option value="task_start" type="date" >Task Start</option>
          <option value="task_end" type="date" >Task End</option>
          <option value="action_required" type="boolean" >Action required</option>
        </optgroup>
      </select>
    </div>
  </div>
  
  <div class="inline">&nbsp;&nbsp; <button class="wa_add_line wgt-button" ><i class="icon-plus-sign"></i></button></div>

  <div class="wgt-clear small">&nbsp;</div>

</div>


<!-- 

                    <tr>
                      <td>
                        <select>
                          <option>AND</option>
                          <option>OR</option>
                        </select>
                      </td>
                      <td style="text-align:right;">
                        <div class="inline" style="position:relative;"><select class="wgt-behind" style="width: 165px;"><optgroup label="Message"><option value="title">Title</option><option value="sender">Sender</option><option value="receiver">Receiver</option><option value="date_received">Date Receiver</option><option value="date_updated">Date Updated</option></optgroup><optgroup label="Appointment"><option value="appoint_deadline">Deadline</option><option value="sender">Sender</option><option value="receiver">Receiver</option><option value="date_received">Date receiver</option><option value="date_updated">Date updated</option><option value="full_day">Full day</option><option value="part_required">Participation required</option></optgroup><optgroup label="Task"><option value="task_start">Task Start</option><option value="task_end">Task End</option><option value="action_required">Action required</option></optgroup></select><input type="text" id="display-undefined" name="display-undefined" value="Title" class="wgt-overlay embed medium wgt-ignore"><button class="wgt-button append wgt-overlay embed medium" id="trigger-undefined"><i class="icon-angle-down"></i></button></div>
                      </td>
                      <td style="text-align:center;">
                        <input type="checkbox">
                      </td>
                      <td style="text-align:center;">
                        <div class="inline" style="position:relative;"><select id="wgt-input-51601c7070e71" class="small wgt-behind" style="width: 105px;">
<option value="1">equals</option>
<option value="2">starts with</option>
<option value="3">contains</option>
<option value="4">ends with</option>
<option value="5">is empty</option>
<option value="6">is not empty</option>
</select><input type="text" id="display-wgt-input-51601c7070e71" name="display-undefined" value="equals" class="wgt-overlay embed small wgt-ignore"><button class="wgt-button append wgt-overlay embed small" id="trigger-wgt-input-51601c7070e71"><i class="icon-angle-down"></i></button></div><var>{"width":"small"}</var>

                      </td>
                      <td style="text-align:left;">
                        <input type="text">
                      </td>
                      <td style="text-align:right;">
                        <button class="wgt-button"><i class="icon-plus-sign"></i></button><button class="wgt-button"><i class="icon-remove-sign"></i></button>
                      </td>
                    </tr>
                    <tr>
                      <td style="padding-left:10px;">
                        <i class="icon-double-angle-right"></i> <select>
                          <option>AND</option>
                          <option>OR</option>
                        </select>
                      </td>
                      <td style="text-align:right;">
                        <div class="inline" style="position:relative;"><select class="wgt-behind" style="width: 165px;"><optgroup label="Message"><option value="title">Title</option><option value="sender">Sender</option><option value="receiver">Receiver</option><option value="date_received">Date Receiver</option><option value="date_updated">Date Updated</option></optgroup><optgroup label="Appointment"><option value="appoint_deadline">Deadline</option><option value="sender">Sender</option><option value="receiver">Receiver</option><option value="date_received">Date receiver</option><option value="date_updated">Date updated</option><option value="full_day">Full day</option><option value="part_required">Participation required</option></optgroup><optgroup label="Task"><option value="task_start">Task Start</option><option value="task_end">Task End</option><option value="action_required">Action required</option></optgroup></select><input type="text" id="display-undefined" name="display-undefined" value="Title" class="wgt-overlay embed medium wgt-ignore"><button class="wgt-button append wgt-overlay embed medium" id="trigger-undefined"><i class="icon-angle-down"></i></button></div>
                      </td>
                      <td style="text-align:center;">
                        <input type="checkbox">
                      </td>
                      <td style="text-align:center;">
                        <div class="inline" style="position:relative;"><select id="wgt-input-51601c7070edb" type="" class="small small wgt-behind" style="width: 105px;">
<option value="1">equals</option>
<option value="2">starts with</option>
<option value="3">contains</option>
<option value="4">ends with</option>
<option value="5">is empty</option>
<option value="6">is not empty</option>
</select><input type="text" id="display-wgt-input-51601c7070edb" name="display-undefined" value="equals" class="wgt-overlay embed small wgt-ignore"><button class="wgt-button append wgt-overlay embed small" id="trigger-wgt-input-51601c7070edb"><i class="icon-angle-down"></i></button></div><var>{"width":"small"}</var>

                      </td>
                      <td style="text-align:left;">
                        <input type="text">
                      </td>
                      <td style="text-align:right;">
                        <button class="wgt-button"><i class="icon-plus-sign"></i></button><button class="wgt-button"><i class="icon-remove-sign"></i></button>
                      </td>
                    </tr>
                    <tr>
                      <td style="padding-left:30px;">
                        <i class="icon-double-angle-right"></i> <select>
                          <option>AND</option>
                          <option>OR</option>
                        </select>
                      </td>
                      <td style="text-align:right;">
                        <div class="inline" style="position:relative;"><select class="wgt-behind" style="width: 165px;"><optgroup label="Message"><option value="title">Title</option><option value="sender">Sender</option><option value="receiver">Receiver</option><option value="date_received">Date Receiver</option><option value="date_updated">Date Updated</option></optgroup><optgroup label="Appointment"><option value="appoint_deadline">Deadline</option><option value="sender">Sender</option><option value="receiver">Receiver</option><option value="date_received">Date receiver</option><option value="date_updated">Date updated</option><option value="full_day">Full day</option><option value="part_required">Participation required</option></optgroup><optgroup label="Task"><option value="task_start">Task Start</option><option value="task_end">Task End</option><option value="action_required">Action required</option></optgroup></select><input type="text" id="display-undefined" name="display-undefined" value="Title" class="wgt-overlay embed medium wgt-ignore"><button class="wgt-button append wgt-overlay embed medium" id="trigger-undefined"><i class="icon-angle-down"></i></button></div>
                      </td>
                      <td style="text-align:center;">
                        <input type="checkbox">
                      </td>
                      <td style="text-align:center;">
                        <div class="inline" style="position:relative;"><select id="wgt-input-51601c7070f4f" type="" class="small small small wgt-behind" style="width: 105px;">
<option value="1">equals</option>
<option value="2">starts with</option>
<option value="3">contains</option>
<option value="4">ends with</option>
<option value="5">is empty</option>
<option value="6">is not empty</option>
</select><input type="text" id="display-wgt-input-51601c7070f4f" name="display-undefined" value="equals" class="wgt-overlay embed small wgt-ignore"><button class="wgt-button append wgt-overlay embed small" id="trigger-wgt-input-51601c7070f4f"><i class="icon-angle-down"></i></button></div><var>{"width":"small"}</var>

                      </td>
                      <td style="text-align:left;">
                        <input type="text">
                      </td>
                      <td style="text-align:right;">
                        <button class="wgt-button"><i class="icon-remove-sign"></i></button>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <select>
                          <option>AND</option>
                          <option>OR</option>
                        </select>
                      </td>
                      <td style="text-align:right;">
                        <div class="inline" style="position:relative;"><select class="wgt-behind" style="width: 165px;"><optgroup label="Message"><option value="title">Title</option><option value="sender">Sender</option><option value="receiver">Receiver</option><option value="date_received">Date Receiver</option><option value="date_updated">Date Updated</option></optgroup><optgroup label="Appointment"><option value="appoint_deadline">Deadline</option><option value="sender">Sender</option><option value="receiver">Receiver</option><option value="date_received">Date receiver</option><option value="date_updated">Date updated</option><option value="full_day">Full day</option><option value="part_required">Participation required</option></optgroup><optgroup label="Task"><option value="task_start">Task Start</option><option value="task_end">Task End</option><option value="action_required">Action required</option></optgroup></select><input type="text" id="display-undefined" name="display-undefined" value="Title" class="wgt-overlay embed medium wgt-ignore"><button class="wgt-button append wgt-overlay embed medium" id="trigger-undefined"><i class="icon-angle-down"></i></button></div>
                      </td>
                      <td style="text-align:center;">
                        <input type="checkbox">
                      </td>
                      <td style="text-align:center;">
                        <div class="inline" style="position:relative;"><select id="wgt-input-51601c7070fdf" type="" class="small small small small wgt-behind" style="width: 105px;">
<option value="1">equals</option>
<option value="2">starts with</option>
<option value="3">contains</option>
<option value="4">ends with</option>
<option value="5">is empty</option>
<option value="6">is not empty</option>
</select><input type="text" id="display-wgt-input-51601c7070fdf" name="display-undefined" value="equals" class="wgt-overlay embed small wgt-ignore"><button class="wgt-button append wgt-overlay embed small" id="trigger-wgt-input-51601c7070fdf"><i class="icon-angle-down"></i></button></div><var>{"width":"small"}</var>

          </td>
          <td style="text-align:left;">
            <input type="text">
          </td>
          <td style="text-align:right;">
            <button class="wgt-button"><i class="icon-plus-sign"></i></button><button class="wgt-button"><i class="icon-remove-sign"></i></button>
          </td>
        </tr>

 -->