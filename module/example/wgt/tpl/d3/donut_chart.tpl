<h2>Donut Chart</h2>

<?php 

$data = array(
"lx"=>"",
"ly"=>"",
"values"=>"key,value
<5,2704659
5-13,4499890
14-17,2159981
18-24,3853788
25-44,14106543
45-64,8819342
≥65,612463"
);

?>

<style>

.arc path {
  stroke: #fff;
}

#wgt-donut-chart svg
{
  font: 10px sans-serif;
}

</style>

<div
  class="wcm wcm_donut_chart"
  id="wgt-donut-chart"
  style="width:400px;height:400px;border:1px solid silver;" ><var><?php echo json_encode($data) ?></var></div>