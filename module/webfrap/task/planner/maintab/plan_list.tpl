<?php 

?>

<form 
  id="wgt-form-taskplanner-search"
  method="get"
  target="ajax.php?c=Webfrap.TaskPlanner.search" ></form>

<div id="wgt-grid-taskplanner" class="wgt-grid" >

  <var id="wgt-grid-taskplanner-cfg-grid" >{
  "height":"large",
  "search_form":"wgt-form-taskplanner-search",
  "search_able":"true"}</var>

  <table 
    id="wgt-grid-taskplanner-table" 
    class="wgt-grid wcm wcm_widget_grid hide-head" >
    <thead>
      <tr>
        <th style="width:40px;" class="col" >Pos</th>
        <th 
          style="width:120px;"
          wgt_sort_name="plan[title]" 
          wgt_sort="desc" 
          wgt_search="input:plan[title]" >Title</th>
        <th style="width:130px;" >Type</th>
        <th 
          style="width:120px;"
          wgt_sort_name="plan[timestamp_start]" 
          wgt_sort="desc" >Start</th>
        <th style="width:120px;" >End</th>
        <th style="width:170px;" >Actions</th>
        <th style="width:170px;" >Description</th>
        <th style="width:100px;" >Menu</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach( $this->plans as $pos => $plan ){ ?>
        <?php $schedule = json_decode($plan['series_rule'])  ?>
        <tr 
          id="wgt-table-taskplanner-<?php echo $plan['id'] ?>"
          class="wcm wcm_control_access_dataset"
          wgt_url="modal.php?c=Webfrap.TaskPlanner.editPlan&objid=<?php echo $plan['id'] ?>" >
          <td class="pos" ><?php echo $pos ?></td>
          <td><?php echo $plan['title'] ?></td>
          <td><?php echo ETaskType::label($schedule->type)  ?></td>
          <td><?php echo $plan['timestamp_start'] ?></td>
          <td><?php echo $plan['timestamp_end'] ?></td>
          <td><?php echo $plan['actions'] ?></td>
          <td><?php echo $plan['description'] ?></td>
          <td><?php echo $this->listMenu->renderActions( $this->listMenu->listActions, $plan ) ?></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>

