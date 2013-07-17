<?php
/*
 *  @var $I18N
 */
?>
<div style="width:100%;height:320px;" >

  <div class="wgt_box_login" style="width:300px;padding-top:50px;margin: 0 auto;">

    <fieldset style="width:300px;" >
      <legend><?php echo $I18N->l('change password','wbf.base.label.change_password'); ?></legend>
      <form method="post" action="index.php?c=Webfrap.Auth.changePasswd" >

        <div>
          <label class="wgt-label" style="color:white;" ><?php echo $I18N->l('old password','wbf.base.label.old_passwd'); ?></label>
          <div class="wgt-input"  ><input type="password" class="medium" name="old_passwd" /></div>
        </div>

        <div class="wgt-clear small" ></div>

        <hr />

        <div class="wgt-clear small" ></div>

        <div>
          <label class="wgt-label" style="color:white;" ><?php echo $I18N->l('new password','wbf.base.label.new_password'); ?></label>
          <div class="wgt-input"  ><input type="password" class="medium" name="new_password" /></div>
        </div>

        <div>
          <label class="wgt-label" style="color:white;" ><?php echo $I18N->l('confirm password','wbf.base.label.confirm_password'); ?></label>
          <div class="wgt-input"  ><input type="password" class="medium" name="confirm_password" /></div>
        </div>

        <div>
          <label class="wgt-label"  ></label>
          <div class="wgt-input"  ><input type="submit" class="wgt-button" value="<?php echo $I18N->l('change password','wbf.base.label.change_password'); ?>" /></div>
        </div>

        <div class="wgt-clear small" ></div>

        <div class="full text_center" >
          <a href="index.php?c=Webfrap.Auth.form" >Zurück zum Login</a>
        </div>


        <div class="wgt-clear small" ></div>

      </form>
    </fieldset>

    <div class="wgt-clear small" ></div>

  </div>

</div>