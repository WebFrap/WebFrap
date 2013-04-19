<h2>Stacked Area Chart</h2>

<?php 

$data = array(
"lx"=>"",
"ly"=>"",
"values"=>"date,IE,Chrome,Firefox,Safari,Opera
2011-10-13,41.62,22.36,25.58,9.13,1.22
2011-10-14,41.95,22.15,25.78,3.79,6.25
2011-10-15,37.64,24.77,25.96,10.16,1.39
2011-10-16,37.27,24.65,25.98,10.59,1.44
2011-10-17,42.74,21.87,25.01,9.12,1.17
2011-10-18,42.14,22.22,25.26,9.1,1.19
2011-10-19,41.92,22.42,25.3, 9.07,1.21
2011-10-20,42.41,22.08,25.28,8.94,1.18
2011-10-21,42.74,22.23,25.19,8.5,1.25
2011-10-22,36.95,25.45,26.03,10.06,1.42
2011-10-23,37.52,24.73,25.79,10.46,1.43"
);

?>

<style>

.axis path,
.axis line {
  fill: none;
  stroke: #000;
  shape-rendering: crispEdges;
}

.vrange text {
  text-anchor: end;
}

#wgt-multi-line-chart svg
{
  font: 10px sans-serif;
}

</style>

<div
  class="wcm wcm_stacked_area_chart"
  id="wgt-stacked-area-chart"
  style="width:600px;height:400px;border:1px solid silver;" ><var><?php echo json_encode($data) ?></var></div>
  