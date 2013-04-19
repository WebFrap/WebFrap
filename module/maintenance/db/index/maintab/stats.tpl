
<div class="wgt-space bw7" >

  <table class="wgt-table bw6" >
    <label>Data Index</label>

    <thead>
      <tr>
        <th style="width:30px;" class="pos" >Pos.</th>
        <th>Name</th>
        <th>Stats</th>
        <th style="width:40px;" >Menu</th>
      </tr>
    </thead>

    <tbody>
    <?php $pos = 1; foreach( $VAR->modules as $modKey => $modName ){ ?>
      <tr>
        <td class="pos" >
          <?php echo $pos ?>
        </td>
        <td>
          <?php echo $modName ?>
        </td>
        <td>
          <?php echo isset( $VAR->stats[$modKey] )? $VAR->stats[$modKey]:0; ?>
        </td>
        <td>
          <button
            class="wgt-button"
            onclick="$R.put('ajax.php?c=Maintenance.Db_Index.recalcEntity&key=<?php echo $modName ?>');"
          ><i class="icon-refresh" ></i> Recalc</button>
        </td>
      </tr>
    <?php ++$pos; } ?>
    </tbody>

  </table>

</div>

