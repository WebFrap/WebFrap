<?php 

?>
<table class="wgt-grid simple wgt-space" >
  <thead>
    <tr>
      <th style="width:40px;" class="col" >Pos</th>
      <th style="width:120px;" >Title</th>
      <th style="width:120px;" >Series</th>
      <th style="width:250px;" >Start</th>
      <th style="width:170px;" >End</th>
      <th style="width:170px;" >Actions</th>
      <th style="width:170px;" >Description</th>
      <th style="width:100px;" >Menu</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach( $this->plans as $pos => $plan ){ ?>
      <tr>
        <td class="pos" ><?php echo $pos ?></td>
        <td><?php echo $plan['title'] ?></td>
        <td><?php echo $plan['flag_series'] ?></td>
        <td><?php echo $plan['timestamp_start'] ?></td>
        <td><?php echo $plan['timestamp_end'] ?></td>
        <td><?php echo $plan['actions'] ?></td>
        <td><?php echo $plan['description'] ?></td>
        <td><?php echo $this->renderActions( $cDir ) ?></td>
      </tr>
    <?php } ?>
  </tbody>
</table>

