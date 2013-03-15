<h2>Shiw Reel</h2>

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

.line {
  fill: none;
  stroke: #000;
  stroke-width: 2px;
}

</style>

<div
  class="wcm wcm_show_reel_chart"
  id="wgt-show-reel-chart"
  style="width:800px;height:500px;border:1px solid silver;" ><var><?php echo json_encode($data) ?></var></div>