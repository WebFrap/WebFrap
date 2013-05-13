<table class="wgt-grid simple wgt-space" >
  <thead>
    <tr>
      <th style="width:40px;" class="col" >Pos</th>
      <th style="width:120px;" >Name</th>
      <th style="width:120px;" >Key</th>
      <th style="width:40px;" >Num</th>
      <th style="width:75px;" >Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach( $this->model->tableList as $pos => $table ){ ?>
      <tr>
        <td class="pos" ><?php echo $pos ?></td>
        <td><?php echo $table['name'] ?></td>
        <td><?php echo $table['access_key'] ?></td>
        <td><?php echo $table['description']  ?></td>
        <td><?php echo $this->listMenu->renderActions( $this->listMenu->listActions, $table ) ?></td>
      </tr>
    <?php } ?>
  </tbody>
</table>