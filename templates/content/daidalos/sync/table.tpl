
<form id="wgt-form-daidalos_sync" action="ajax.php?c=Daidalos.Sync.sync" method="post" >
<fieldset>
  <legend>options</legend>

    <div class="left half" >
      <div>
        <label class="wgt-label" >username:</label>
        <div class="wgt-input" ><input type="text" class="medium wgt-no-save" name="username"  /></div>
      </div>
      <div>
        <label class="wgt-label" >password:</label>
        <div class="wgt-input" ><input type="password" class="medium wgt-no-save" name="password"  /></div>
      </div>
    </div>

    <div class="inline half" >
      <label class="wgt-label" >Galaxy</label>
      <div class="wgt-input" ><?php
        echo WgtRndForm::selectbox
        (
          $this->model->getSelectGalaxies(),
          array
          (
            'name'  => 'galaxy',
            'class' => 'medium wgt-no-save'
          )
        ); ?></div>
    </div>

    <div class="wgt-clear small" ></div>

    <div class="full" >
      <button class="wgt-button" onclick="$R.form('wgt-form-daidalos_sync');return false;" >sync</button>
    </div>

</fieldset>

<fieldset>
  <legend>Projects</legend>

  <table class="wgt-table" >
    <thead>
      <tr>
        <th style="width:30px;" >check</th>
        <th style="width:*" >Project Name</th>
        <th style="width:60px;">Menu</th>
      </tr>
    </thead>
    <tbody>
    <?php

    $projects = $this->model->getRepoProjects();

    foreach( $projects as $project )
    {
      ?>
      <tr>
        <td><input type="checkbox" name="repos[]" value="<?php echo $project ?>" class="wgt-no-save" /></td>
        <td><?php echo $project ?></td>
        <td></td>
      </tr>
      <?php
    }

    ?>
    </tbody>
  </table>

</fieldset>

</form>




