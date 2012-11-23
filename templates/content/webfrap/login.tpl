<div style="width:100%;height:320px;" >

  <div class="wgt_box_login" style="width:300px;padding-top:50px;margin: 0 auto;">

    <fieldset style="width:300px;" >
      <legend>Login</legend>
      <form method="post" action="index.php?c=Webfrap.Auth.login" >

        <div>
          <label class="wgt-label" style="color:white;" >Login</label>
          <div class="wgt-input"  ><input type="text" class="medium" name="name" /></div>
        </div>

        <div>
          <label class="wgt-label" style="color:white;" >Passwort</label>
          <div class="wgt-input"  ><input type="password" class="medium" name="passwd" /></div>
        </div>

        <div>
          <label class="wgt-label"  ></label>
          <div class="wgt-input"  ><input type="submit" class="wgt-button" value="login" /></div>
        </div>
        
        <?php if( $CONF->getStatus('login.forgot_pwd') ){ ?>
          <div>
            <a href="index.php?c=Webfrap.Auth.formForgotPasswd" >Forgot password?</a>
          </div>
        <?php } ?>
        


      </form>
    </fieldset>

  </div>

</div>