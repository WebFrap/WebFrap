<table class="wgt-grid simple wgt-space" >
  <thead>
    <tr>
      <th style="width:40px;" class="col" >Pos</th>
      <th style="width:120px;" >Table</th>
      <th style="width:120px;" >Deleted</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach( $this->model->cleanLog as $pos => $log ){ ?>
      <tr>
        <td class="pos" ><?php echo $pos ?></td>
        <td><?php echo $log['table'] ?></td>
        <td><?php echo $log['num_del'] ?></td>
      </tr>
    <?php } ?>
  </tbody>
</table>