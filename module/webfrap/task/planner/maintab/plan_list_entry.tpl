<tr id="wgt-table-taskplanner-<?php echo $this->plan['rowid'] ?>" >
  <td class="pos" ><?php echo 0 ?></td>
  <td><?php echo $this->plan['title'] ?></td>
  <td><?php echo $this->plan['flag_series'] ?></td>
  <td><?php echo $this->plan['timestamp_start'] ?></td>
  <td><?php echo $this->plan['timestamp_end'] ?></td>
  <td><?php echo $this->plan['actions'] ?></td>
  <td><?php echo $this->plan['description'] ?></td>
  <td><?php echo $this->listMenu->renderActions( $this->listActions, $this->plan ) ?></td>
</tr>

