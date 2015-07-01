<div id="login-box" class="login-popup">
        <a href="#" class="close"><img src="<?=$this->config->item('images').'close_pop.png';?>" class="btn_close" title="Close Window" alt="Close" /></a>
		  <form accept-charset="utf-8" method="post" class="signin" action="<?=site_url('authentication/auth')?>">
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                <fieldset class="textbox">
            	<label class="username">
                <span>Username or email</span>
                <input id="username" name="username" value="Username" type="text" onfocus="this.value=(this.value=='Username') ? '' : this.value;" onblur="this.value=(this.value=='') ? 'Username' : this.value;">
                </label>
                <label class="password">
                <span>Password</span>
                <input id="password" name="password" value="Password" type="password"  onfocus="this.value=(this.value=='Password') ? '' : this.value;" onblur="this.value=(this.value=='') ? 'Password' : this.value;">
                </label>
				<input class="submit button" type="submit" value="Login"/>
                <p>
                <a class="forgot" href="#">Forgot your password?</a>
                </p>        
                </fieldset>
          </form>
</div>