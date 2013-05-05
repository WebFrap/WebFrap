<div style="width:100%;height:420px;" >

  <div class="wgt_box_login" style="width:350px;padding-top:50px;margin: 0 auto;">

    <fieldset style="width:350px;" >
      <legend><?php echo $I18N->l('Forgot Password','wbf.label'); ?></legend>
      <form method="post" action="index.php?c=Webfrap.Auth.forgotPasswd" >

        <?php if( $VAR->error ) { ?>
          <div class="wgt-box error" ><?php echo $VAR->error ?></div>
        <?php } ?>

        <p>
          <?php echo $I18N->l('Insert Username or E-Mail','wbf.label'); ?>
        </p>

        <div>
          <label class="wgt-label" >
            <?php echo $I18N->l( 'Username', 'wbf.label' ); ?>
          </label>
          <div class="wgt-input"  ><input type="text" class="medium" name="username" /></div>
        </div>

        <div>
          <label class="wgt-label"  >
            <?php echo $I18N->l('E-Mail','wbf.label'); ?>
          </label>
          <div class="wgt-input"  ><input type="text" class="medium" name="e_mail" /></div>
        </div>

        <div class="wgt-clear small" ></div>

        <div class="full" >
          <label class="wgt-label"  ></label>
          <div class="wgt-input"  >
            <input type="submit" class="wgt-button" value="<?php echo $I18N->l('Request Change','wbf.base.label'); ?>" />
          </div>
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

