<h2>Editable Grid</h2>

<?php 

$datas = array(
  array( 
  	'c1' => "C1.1",
  	'c2' => 'C1.2',
  	'c3' => 'C1.3',
  	'c4' => 'C1.4',
  ),array( 
  	'c1' => "C2.1",
  	'c2' => 'C2.2',
  	'c3' => 'C2.3',
  	'c4' => 'C2.4',
  ),array( 
  	'c1' => "C3.1",
  	'c2' => 'C3.2',
  	'c3' => 'C3.3',
  	'c4' => 'C3.4',
  ),array( 
  	'c1' => "C4.1",
  	'c2' => 'C4.2',
  	'c3' => 'C4.3',
  	'c4' => 'C4.4',
  ),array( 
  	'c1' => "C5.1",
  	'c2' => 'C5.2',
  	'c3' => 'C5.3',
  	'c4' => 'C5.4',
  ),
);

?>

<form 
  method="post"
  id="wgt-form-save-grid-example"
	action="area.php?c=Example.Wgt.dump" ></form>


<div class="wgt-panel" >
	<button class="wgt-button" onclick="$S('#wgt-grid-example-table').grid('save');" >Save</button>
</div>

<div id="wgt-grid-example" class="wgt-grid editable" style="position:relative;" >
  <var id="wgt-grid-example-table-cfg-grid" >{
    "height":"medium",
    "search_form":"",
    "save_form":"wgt-form-save-grid-example",
    "edit_able":"true"
  }</var>
  
  <script id="wgt-select-data-table-testdata-22" type="text/html" >
		<select id="select-fubar22" >
			<option value="" selected="selected" ></option>
			<option value="1" >Val 1</option>
			<option value="2" >Val 2</option>
			<option value="3" >Val 3</option>
			<option value="4" >Val 4</option>
		</select>
  </script>
  
  <table 
  	id="wgt-grid-example-table" 
  	class="wgt-grid wcm wcm_widget_grid hide-head" >

    <var id="wgt-slctbx-data-table-testdata-22" >[
      {"i":"1","v":"Val 1"},
      {"i":"2","v":"Val 2"},
      {"i":"3","v":"Val 3"},
      {"i":"4","v":"Val 4"}
    ]</var>

    <thead>
      <tr>
        <th class="pos" >Pos:</th>
        <th style="width:100px;" >Text</th>
        <th style="width:100px;" >Date</th>
        <th style="width:100px;" >Select</th>
        <th style="width:100px;" >Number</th>
      </tr>
    </thead>
    <tbody>
    	<?php foreach( $datas as $key => $data ){?>
    		<tr>
    			<td class="pos" ><?php echo $key ?></td>
    			<td name="col[<?php echo $key ?>][c1]"  ><?php echo $data['c1'] ?></td>
          <td class="type_date" name="col[<?php echo $key ?>][c2]"  ><?php echo $data['c2'] ?></td>
          <td 
            name="col[<?php echo $key ?>][c3]"  
            class="type_select" 
            value="1"
            data_source="wgt-select-data-table-testdata-22"
            ><?php echo $data['c3'] ?></td>
          <td class="type_number" name="col[<?php echo $key ?>][c4]"  ><?php echo $data['c4'] ?></td>
    		</tr>
    	<?php } ?>
    </tbody>
    <tbody class="editor" >
			<tr class="new ini" >
        <td class="pos" ><i class="icon-plus-sign" ></i></td>
        <td></td>
        <td class="type_date" ></td>
        <td 
          class="type_select" 
          value="1"
          data_source="wgt-select-data-table-testdata-22"
          default="" ><!-- <select
          class="wcm wcm_widget_selectbox"
          data_source="wgt-slctbx-data-table-testdata-22"
          id="wgt-editor-col3"  ><option value="" selected="selected" ></option></select> --></td>
        <td class="type_number" ></td>
      </tr>
      <tr class="template" >
        <td class="pos" ></td>
        <td name="col[{$new}][c1]" ></td>
        <td 
          name="col[{$new}][c2]"
          class="type_date" ></td>
        <td 
          name="col[{$new}][c3]"
          value="1"
          class="type_select" 
          data_source="wgt-select-data-table-testdata-22" ></td>
        <td class="type_number" name="col[{$new}][c4]" ></td>
      </tr>
    </tbody>
  </table>
</div>