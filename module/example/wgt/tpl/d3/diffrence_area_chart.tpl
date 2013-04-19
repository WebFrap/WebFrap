<h2>Shiw Reel</h2>

<?php 

$data = array(
"lx"=>"",
"ly"=>"",
"values"=>"date,New York,San Francisco
2011-10-01,63.4,62.7
2011-10-02,58.0,59.9
2011-10-03,53.3,59.1
2011-10-04,55.7,58.8
2011-10-05,64.2,58.7
2011-10-06,58.8,57.0
2011-10-07,57.9,56.7
2011-10-08,61.8,56.8
2011-10-09,69.3,56.7
2011-10-10,71.2,60.1"
);

?>

<style>

.axis path,
.axis line {
  fill: none;
  stroke: #000;
  shape-rendering: crispEdges;
}

.x.axis path {
  display: none;
}

.area.above {
  fill: rgb(252,141,89);
}

.area.below {
  fill: rgb(145,207,96);
}

.line {
  fill: none;
  stroke: #000;
  stroke-width: 1.5px;
}

</style>

<div
  class="wcm wcm_diffrence_area"
  id="wgt-diffrence-area-chart"
  style="width:800px;height:500px;border:1px solid silver;" ><var><?php echo json_encode($data) ?></var></div>