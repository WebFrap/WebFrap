<fieldset>
  <legend>Project </legend>

  <form class="wcm wcm_req_ajax" action="ajax.php?c=Daidalos.Projects.upload" method="post" >

    <div class="half left" >

      <div>
        <label class="wgt-label" >Project File</label>
        <div class="wgt-input" >
          <input type="file" class="medium" name="project_file" />
        </div>
      </div>

    </div>



     <div class="wgt-clear small" ></div>

     <div class="full" ><input type="submit" class="wgt-button" value="upload" /></div>


    <div class="wgt-clear xxsmall" ></div>

  </form>

</fieldset>

<div class="wgt-clear small" ></div>

<fieldset>
  <legend>Projects</legend>
  <?php echo $ITEM->tableCompilation ?>
</fieldset>




