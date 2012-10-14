<div class="wgt-space" >

  <table class="wcm wcm_ui_gridselector wgt-table bw6">
    <thead>
      <tr>
        <th class="pos" style="width:30px;" >Pos:</th>
        <th>Name</th>
        <th>Folder</th>
        <th>Description</th>
        <th>Nav:</th>
      </tr>
    </thead>
    <tbody>
      <?php $pos = 1; foreach( $VAR->caches as $cache ){ ?>
      <tr wgt_select_key="<?php echo $cache->folder ?>" >
        <td class="pos" ><?php echo $pos; ?></td>
        <td><?php echo $cache->label ?></td>
        <td><?php echo $cache->folder ?></td>
        <td><?php echo $cache->description ?></td>
        <td></td>
      </tr>
      <?php ++$pos; } ?>
    </tbody>
  </table>
  
</div>