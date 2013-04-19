<div style="width:100%;" >
	<div class="wgt_box_login_logo">Hier ist das Logo</div>
	<div class="wgt_box_login_message"></div>
	<div class="wgt_box_login" >
		<form method="post" action="index.php?location=start" >
			<input type="hidden" name="c" value="Webfrap.Auth.login" />
			<div>
				<label for="wgt-label-username" class="wgt-label" ><?php echo $this->i18n->l( 'Username', 'wbf.label' ); ?></label>
				<div class="wgt-input"  ><input type="text" id="wgt-label-username" class="wgt-input" name="name" /></div>
			</div>
			<div>
				<label for="wgt-label-password" class="wgt-label" ><?php echo $this->i18n->l( 'Password', 'wbf.label' ); ?></label>
				<div class="wgt-input"  ><input type="password" id="wgt-label-password" class="wgt-input" name="passwd" /></div>
			</div>
			<div>
				<label class="wgt-label"  ></label>
				<div class="wgt-input"  ><input type="submit" class="wgt-button" value="<?php echo $this->i18n->l( 'Login', 'wbf.label' ); ?>" /></div>
			</div>      
			<div class="wgt-clear" > </div>        
			<?php if( $CONF->getStatus('login.forgot_pwd') ){ ?>
				<div class="full text_center" >
					<a href="index.php?c=Webfrap.Auth.formForgotPasswd" ><?php echo $this->i18n->l( 'Forgot password?', 'wbf.label' ); ?></a>
				</div>
				<div class="wgt-clear" > </div>
			<?php } ?>
		</form>
	</div>
</div>