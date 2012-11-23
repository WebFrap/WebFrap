<fieldset class="wgt-space" >
  <legend>Activ User</legend>

  <form
    id="wgt-form-daidalos-username"
    method="post"
    action="maintab.php?c=daidalos.system.changeUser"
  ></form>

  <div class="left third wgt-border-right" >
    <div id="wgt_box_wgt-input-daidalos-username" class="wgt_box_input">
      <label for="wgt-input-daidalos-username" class="wgt-label">User </label>
      <div class="wgt-input medium" >

        <input
          type="text"
          id="wgt-input-statusedit-username-tostring"
          name="username-tostring"
          class="medium wcm wcm_ui_autocomplete wgt-ignore"  />
        <var class="wgt_settings" >
          {
            "url":"ajax.php?c=daidalos.system.autocompleteUsers&amp;key=",
            "type":"entity"
          }
        </var>
        <input
          type="text"
          id="wgt-input-statusedit-username"
          name="username"
          class="meta asgd-wgt-form-daidalos-username"  />
        <button
          id="wgt-button-project_project-acl-advanced_search"
          class="wgt-button append"
          onclick="$R.get('subwindow.php?c=Wbfsys.RoleUser.selection&input=wgt-input-statusedit-username');return false;"    >
          <img src="<?php echo View::$iconsWeb ?>xsmall/control/search.png" alt="search" />
        </button>

      </div>
    </div>
    <div>
      <button
        class="wgt-button"
        onclick="$R.form('wgt-form-daidalos-username');" ><?php echo $I18N->l('Change User','daidalos.text'); ?></button>
    </div>
  </div>

  <div class="inline third" >
    <table>
      <tr>
        <td>Name:</td>
        <td><?php echo $USER->getLoginName() ?></td>
      </tr>
      <tr>
        <td>Full Name:</td>
        <td><?php echo $USER->getFullName() ?></td>
      </tr>
      <tr>
        <td>Level:</td>
        <td><?php echo $USER->getLevel() ?></td>
      </tr>
      <tr>
        <td>Profile:</td>
        <td><?php echo $USER->getProfileName() ?></td>
      </tr>
    </table>
  </div>



</fieldset>