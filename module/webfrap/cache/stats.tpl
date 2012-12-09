
<table class="wgt-grid simple wgt-space" >
  <thead>
    <tr>
      <th style="width:40px;" class="col" >Pos</th>
      <th style="width:120px;" >Name</th>
      <th style="width:250px;" >Description</th>
      <th style="width:170px;" >Stats</th>
      <th style="width:100px;" >Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach( $this->cacheDirs as $pos => $cDir ){ ?>
      <tr>
        <td class="pos" ><?php echo $pos ?></td>
        <td><?php echo $cDir->label ?></td>
        <td><?php echo $cDir->description ?></td>
        <td><?php echo $this->renderDisplay( $cDir ) ?></td>
        <td><?php echo $this->renderActions( $cDir ) ?></td>
      </tr>
    <?php } ?>
  </tbody>
</table>