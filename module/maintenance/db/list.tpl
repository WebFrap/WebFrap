<h2>List Database Consistency</h2>

<p>Several Consistency checks for the database.</p>
<p>Checks will fix inconsistent states automatically if possible</p>

<table class="wgt-table" style="width:400px;" >
  <thead>
    <th style="width:20px;" >&nbsp;</th>
    <th style="width:330px;" >Extension</th>
    <th style="width:50px;" >Nav:</th>
  </thead>
  <tbody>
  <?php
  $exts = $VAR->extensions;
  foreach( $exts as $pos => $extension )
  {
    ?>
    <tr>
      <td><?php echo (1+$pos) ?></td>
      <td><?php echo $extension ?></td>
      <td></td>
    </tr>
    <?php
  }
  ?>
  </tbody>
</table>