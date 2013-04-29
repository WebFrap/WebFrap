<h2>Sum Grid</h2>

<?php 

$datas = array(
  array( 
  	'c1' => "C1.1",
  	'c2' => '2013-03-21',
  	'c3' => 'Val 1',
  	'c4' => '42',
  	'c5' => '',
  ),array( 
  	'c1' => "C2.1",
  	'c2' => '2013-03-21',
  	'c3' => 'Val 1',
  	'c4' => '42',
  	'c5' => '2013-03-21 00:00',
  ),array( 
  	'c1' => "C3.1",
  	'c2' => '2013-03-21',
  	'c3' => 'Val 1',
  	'c4' => '22',
  	'c5' => '',
  ),array( 
  	'c1' => "C4.1",
  	'c2' => '2013-03-21',
  	'c3' => 'Val 1',
  	'c4' => '55',
  	'c5' => '2013-03-21 00:00',
  ),array( 
  	'c1' => "C5.1",
  	'c2' => '2013-03-21',
  	'c3' => 'Val 1',
  	'c4' => '66',
  	'c5' => '2013-03-21 00:00',
  ),array( 
  	'c1' => "C4.1",
  	'c2' => '2013-03-21',
  	'c3' => 'Val 1',
  	'c4' => '55',
  	'c5' => '2013-03-21 00:00',
  ),array( 
  	'c1' => "C5.1",
  	'c2' => '2013-03-21',
  	'c3' => 'Val 1',
  	'c4' => '66',
  	'c5' => '2013-03-21 00:00',
  ),array( 
  	'c1' => "C4.1",
  	'c2' => '2013-03-21',
  	'c3' => 'Val 1',
  	'c4' => '55',
  	'c5' => '2013-03-21 00:00',
  ),array( 
  	'c1' => "C5.1",
  	'c2' => '2013-03-21',
  	'c3' => 'Val 1',
  	'c4' => '66',
  	'c5' => '2013-03-21 00:00',
  ),array( 
  	'c1' => "C4.1",
  	'c2' => '2013-03-21',
  	'c3' => 'Val 1',
  	'c4' => '55',
  	'c5' => '2013-03-21 00:00',
  ),array( 
  	'c1' => "C5.1",
  	'c2' => '2013-03-21',
  	'c3' => 'Val 1',
  	'c4' => '66',
  	'c5' => '2013-03-21 00:00',
  ),
);

?>



<div id="wgt-grid-example" class="wgt-grid editable" style="position:relative;" >
  <var id="wgt-grid-example-table-cfg-grid" >{
    "height":"medium",
    "search_form":""
  }</var>

  <table 
  	id="wgt-grid-example-table" 
  	class="wgt-grid wcm wcm_widget_grid hide-head" >

    <thead>
      <tr>
        <th class="pos" >Pos:</th>
        <th style="width:100px;" >Text</th>
        <th style="width:100px;" >Date</th>
        <th style="width:100px;" >Select</th>
        <th style="width:100px;" >Number</th>
        <th style="width:100px;" >Date Time</th>
      </tr>
    </thead>
    <tbody>
    	<?php foreach( $datas as $key => $data ){?>
    		<tr>
    			<td class="pos" ><?php echo $key ?></td>
    			<td><?php echo $data['c1'] ?></td>
          <td><?php echo $data['c2'] ?></td>
          <td><?php echo $data['c3'] ?></td>
          <td><?php echo $data['c4'] ?></td>
          <td><?php echo $data['c5'] ?></td>
    		</tr>
    	<?php } ?>
    </tbody>
    <tbody class="sum" >
			<tr class="new ini" >
        <td class="pos" >∑</td>
        <td></td>
        <td></td>
        <td></td>
        <td>∑ 33</td>
        <td></td>
      </tr>
    </tbody>
  </table>
</div>