<h2>Multi Line Chart</h2>

<?php 

$data = array(
"lx"=>"",
"ly"=>"Temperature",
"values"=>"date,New York,San Francisco,Austin
2011-10-01,63.4,62.7,72.2
2011-10-02,58.0,59.9,67.7
2011-10-03,53.3,59.1,69.4
2011-10-04,55.7,58.8,68.0
2011-10-05,64.2,58.7,72.4
2011-10-06,58.8,57.0,77.0
2011-10-07,57.9,56.7,82.3
2011-10-08,61.8,56.8,78.9
2011-10-09,69.3,56.7,68.8
2011-10-10,71.2,60.1,68.7"
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

.line {
  fill: none;
  stroke: steelblue;
  stroke-width: 1.5px;
}

#wgt-multi-line-chart svg
{
  font: 10px sans-serif;
}

</style>

<div
  class="wcm wcm_line_chart"
  id="wgt-multi-line-chart"
  style="width:600px;height:400px;border:1px solid silver;" ><var><?php echo json_encode($data) ?></var></div>