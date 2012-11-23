<fieldset>
  <legend>search</legend>

  <form method="post" id="wgt-form-search_in_file" class="wcm wcm_req_ajax" action="ajax.php?c=Daidalos.Search.search" >

    <div class="left third" >
      <div>
        <label class="wgt-label" >Keyword</label>
        <div class="wgt-input" ><input type="text" class="medium wgt-no-save" name="keyword" /></div>
      </div>
    </div>

    <div class="inline third" >

      <div>
        <label class="wgt-label" >Endings</label>
        <div class="wgt-input" >
          <select name="endings[]" multiple="multiple" size="6" class="medium wgt-no-save" >
            <option value=".php" >*.php</option>
            <option value=".tpl" >*.tpl</option>
            <option value=".js" >*.js</option>
            <option value=".css" >*.css</option>
            <option value=".bdl" >*.bdl</option>
            <option value=".html" >*.html</option>
          </select>
        </div>
      </div>

    </div>

    <div class="inline third" >

      <div>
        <label class="wgt-label" >Projects</label>
        <div class="wgt-input" >
          <select name="projects[]" multiple="multiple" size="6" class="medium wgt-no-save" >
            <?php
              $projects = $this->model->getProjects();
              foreach( $projects as $project )
              {
                echo '<option value="'.$project.'" >'.$project.'</option>';
              }
            ?>
          </select>
        </div>
      </div>

    </div>

  </form>

  <div class="full" >
    <button class="wgt-button"  onclick="$R.form('wgt-form-search_in_file');return false;" >search</button> &nbsp;
    <button class="wgt-button"  onclick="$S('#search_results').html('<fieldset><legend>results</legend><p>any result</p></fieldset>');" >reset</button>
  </div>

</fieldset>

<div class="wgt-clear small" ></div>

<div id="search_results" >
<fieldset>
  <legend>results</legend>
  <p>any result</p>
</fieldset>
</div>
