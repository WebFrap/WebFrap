<h2>Bar Chart</h2>

<?php 

$data = array(
"lx"=>"",
"ly"=>"",
"values"=>"letter,frequency
A,.08167
B,.01492
C,.02780
D,.04253
E,.12702
F,.02288
G,.02022
H,.06094"
);

?>

<style>

.axis path,
.axis line {
  fill: none;
  stroke: #000;
  shape-rendering: crispEdges;
}

.bar {
  fill: steelblue;
}

.x.axis path {
  display: none;
}

#wgt-bar-chart svg
{
  font: 10px sans-serif;
}

</style>

<div
  class="wcm wcm_bar_chart"
  id="wgt-bar-chart"
  style="width:400px;height:400px;border:1px solid silver;" ><var><?php echo json_encode($data) ?></var></div>