<table class="wgt-grid simple wgt-space" >
  <thead>
    <tr>
      <th style="width:40px;" class="col" >Pos</th>
      <th style="width:120px;" >Name</th>
      <th style="width:120px;" >Key</th>
      <th style="width:250px;" >Description</th>
      <th style="width:100px;" >Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach( $this->processes as $pos => $process ){ ?>
      <tr>
        <td class="pos" ><?php echo $pos ?></td>
        <td><?php echo $process['name'] ?></td>
        <td><?php echo $process['access_key'] ?></td>
        <td><?php echo $process['description']  ?></td>
        <td><?php echo $this->renderActions( $this->listActions,  $process ) ?></td>
      </tr>
    <?php } ?>
  </tbody>
</table>