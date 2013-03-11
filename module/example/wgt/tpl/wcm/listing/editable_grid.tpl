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
  <table 
  	id="wgt-grid-example-table" 
  	class="wgt-grid wcm wcm_widget_grid hide-head" >
    <thead>
      <tr>
        <th class="pos" >Pos:</th>
        <th style="width:100px;" >Col 1</th>
        <th style="width:100px;" >Col 2</th>
        <th style="width:100px;" >Col 3</th>
        <th style="width:100px;" >Col 4</th>
      </tr>
    </thead>
    <tbody>
    	<?php foreach( $datas as $key => $data ){?>
    		<tr>
    			<td class="pos" ><?php echo $key ?></td>
    			<?php foreach( $data as $name => $value ){ ?>
    				<td name="col[<?php echo $key ?>][<?php echo $name ?>]"  ><?php echo $value ?></td>
    			<?php } ?>
    		</tr>
    	<?php } ?>
    </tbody>
    <tbody class="editor" >
			<tr class="new ini" >
        <td class="pos" ><i class="icon-plus-sign" ></i></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr class="template" >
        <td class="pos" ></td>
        <td name="col[{$new}][c1]" ></td>
        <td name="col[{$new}][c2]" ></td>
        <td name="col[{$new}][c3]" ></td>
        <td name="col[{$new}][c4]" ></td>
      </tr>
    </tbody>
  </table>
</div>