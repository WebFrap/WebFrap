<div class="contentArea" >


    <!-- Tab Details -->
    <div class="window_tab" id="wgt_window_tab_wbfprofile_data" title="data"  >


      <fieldset class="nearly_full" >
        <legend>Personal Data</legend>

        <div class="left half" >

         <?php  for( $nam = 0; $nam < 5; ++$nam  ){ ?>
         <div id="wgt_box_id<?php echo $nam?>" >
            <label class="wgt-label" for="id<?php echo $nam?>" >name <?php echo $nam?></label>
            <div class="wgt-input" ><input type="text"  /></div>
          </div>
         <?php  } ?>


        </div>

        <div class="inline half" >

         <?php  for( $nam = 0; $nam < 5; ++$nam  ){ ?>
          <div id="wgt_box_id2<?php echo $nam?>" >
            <label class="wgt-label" for="id2<?php echo $nam?>" >name <?php echo $nam?></label>
            <div class="wgt-input" ><input type="text"  /></div>
          </div>
         <?php  } ?>

        </div>

        <div class="wgt-clear small">&nbsp;</div><!-- wtf -->
      </fieldset>

      <fieldset class="nearly_full" >
        <legend>Other Data</legend>

        <div class="left half" >

         <?php  for( $nam = 0; $nam < 5; ++$nam  ){ ?>
         <div id="wgt_box_id3<?php echo $nam?>" >
            <label class="wgt-label" for="id3<?php echo $nam?>" >name <?php echo $nam?></label>
            <div class="wgt-input" ><input type="text"  /></div>
          </div>
         <?php  } ?>


        </div>

        <div class="inline half" >

         <?php  for( $nam = 0; $nam < 5; ++$nam  ){ ?>
          <div id="wgt_box_id4<?php echo $nam?>" >
            <label class="wgt-label" for="id4<?php echo $nam?>" >name <?php echo $nam?></label>
            <div class="wgt-input" ><input type="text"  /></div>
          </div>
         <?php  } ?>

        </div>

        <div class="wgt-clear small">&nbsp;</div><!-- wtf -->
      </fieldset>

    </div>


    <div class="window_tab" id="wgt_window_tab_wbfprofile_projectstory" title="some table"  >

      <table class="wgt-table" >
        <thead>
          <tr>
            <th>Col 1</th>
            <th>Col 2</th>
            <th>Col 3</th>
            <th>Col 4</th>
          </tr>
        </thead>
        <tbody>

        <?php  for( $pos = 0; $pos < 20; ++$pos ){ ?>
          <tr class="row<?php echo (($pos%2)+1)?>" >
            <td>Col 1</td>
            <td>Col 2</td>
            <td>Col 3</td>
            <td>Col 4</td>
          </tr>
         <?php  } ?>

        </tbody>

      </table>

    </div>s


    <div class="wgt-clear medium">&nbsp;</div>

</div>

<div class="wgt-clear medium">&nbsp;</div>

<script type="text/javascript">
<?php  foreach( $this->jsItems as $jsItem ){ ?>
  <?php echo $ITEM->$jsItem->jsCode?>
<?php  } ?>
</script>