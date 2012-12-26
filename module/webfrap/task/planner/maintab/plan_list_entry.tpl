<?php $schedule = json_decode($this->plan['series_rule'])  ?>

<tr 
  id="wgt-table-taskplanner-<?php echo $this->plan['id'] ?>"
  class="wcm wcm_control_access_dataset"
  wgt_url="modal.php?c=Webfrap.TaskPlanner.editPlan&objid=<?php echo $this->plan['id'] ?>" >
  <td class="pos" ><?php echo 0 ?></td>
  <td><?php echo $this->plan['title'] ?></td>
  <td><?php echo ETaskType::label($schedule->type)  ?></td>
  <td><?php echo $this->plan['timestamp_start'] ?></td>
  <td><?php echo $this->plan['timestamp_end'] ?></td>
  <td><?php echo $this->plan['actions'] ?></td>
  <td><?php echo $this->plan['description'] ?></td>
  <td><?php echo $this->listMenu->renderActions( $this->listMenu->listActions, $this->plan ) ?></td>
</tr>

