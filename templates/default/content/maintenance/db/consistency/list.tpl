<h2>List Database Consistency</h2>

<table class="wgt-table" style="width:400px;" >
  <thead>
    <th style="width:20px;" >&nbsp;</th>
    <th style="width:330px;" >Extension</th>
    <th style="width:50px;" >Nav:</th>
  </thead>
  <tbody>
  <?php 
  $exts = $VAR->extensions;
  foreach( $exts as $extension )
  {
    ?> 
    <tr>
      <td></td>
      <td><?php echo $extension ?></td>
      <td></td>
    </tr>
    <?php 
  }
  ?>
  </tbody>
</table>