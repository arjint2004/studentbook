<link href="<?=$this->config->item('css').'style_form.css';?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js"></script>
<!--Slider-in icons-->
<script type="text/javascript">
    $(document)
        .ready(function () {
        $(".username")
            .focus(function () {
            $(".user-icon")
                .css("left", "-48px");
        });
        $(".username")
            .blur(function () {
            $(".user-icon")
                .css("left", "0px");
        });

        $(".password")
            .focus(function () {
            $(".pass-icon")
                .css("left", "-48px");
        });
        $(".password")
            .blur(function () {
            $(".pass-icon")
                .css("left", "0px");
        });
    });
</script>
<!-- **Header** -->
<div id="header">
    <a href="index.html" title=""> <img src="<?=$this->config->item('images').'logo.png';?>" alt="" title="" /> </a>    
</div>

<div id="wrapper">
    <div class="user-icon"></div>
    <div class="pass-icon"></div>
    <form name="login-form" class="login-form" action="<?=site_url('authentication/auth')?>" method="post">
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
        <div class="header">
            <h1>Selamat Datang Di Studentbook</h1>
            <span>Silahkan Masukan Username dan Password</span>
            <span><a href="<?=base_url()?>">Kembali ke beranda</a></span>
        </div>
        <div class="content">
            <input name="username" type="text" class="input username" value="Username"
            onfocus="this.value=''" />
            <input name="password" type="password" class="input password" value="Password"
            onfocus="this.value=''" />
        </div>
        <div class="footer">
            <input type="submit" name="submit" value="Login" class="button" />
            <input type="submit" name="submit" value="Register" class="register" />
        </div>
    </form>
</div>
<div class="gradient"></div>