<div class="contentArea" >


  <div  class="wgt-clear medium">&nbsp;</div>

  <form id="wgt-form-radomid">

    <div class="left full" >


      <div class="wgt_box" >
        <label class="wgt-label" >title</label>
        <div class="wgt-input big" ><input type="text" class="huge" /></div>
      </div>

      <div class="wgt_box" >
        <label class="wgt-label" >browser</label>
        <div class="wgt-input big" >
          <select class="big" >
            <option>All</option>
            <option>Internet Explorer &gt; 7</option>
            <option>Internet Explorer 7</option>
            <option>Internet Explorer 8</option>
            <option>Firefox</option>
            <option>Opera</option>
            <option>Safari</option>
            <option>Chromium</option>
          </select>
        </div>
      </div>

      <div class="wgt_box" >
        <label class="wgt-label" >priority</label>
        <div class="wgt-input big" >
          <select class="big" >
            <option>low</option>
            <option>medium</option>
            <option>high</option>
            <option>move your ass damn!!!</option>
          </select>
        </div>
      </div>

      <div class="wgt_box" >
        <label class="wgt-label" >severity</label>
        <div class="wgt-input big" >
          <select class="big" >
            <option>low</option>
            <option>medium</option>
            <option>high</option>
            <option>security</option>
            <option>blocking</option>
          </select>
        </div>
      </div>

    </div>

    <div class="wgt-clear small">&nbsp;</div>

    <div class="full" >
      <label class="wgt-label" >issue description</label>
    </div>
    <div class="full"  >
      <textarea id="needed_id" class="full wcm wcm_inp_wysiwyg" style="height:300px;" ></textarea>
    </div>

    <div class="wgt-clear small">&nbsp;</div>

    <div class="full" >
      <label class="wgt-label" >error message</label>
    </div>
    <div class="full"  >
      <textarea id="needed_id2" class="full" style="height:250px;" ></textarea>
    </div>

  </form>

</div>

<div class="wgt-clear medium">&nbsp;</div>

<script type="text/javascript">
<?php foreach( $this->jsItems as $jsItem ){ ?>
  <?php echo $ITEM->$jsItem->jsCode?>
<?php } ?>
</script>