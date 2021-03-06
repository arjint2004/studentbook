<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>
<?php
	if(isset($page_title)) {
		echo $page_title;
	}else {
		echo "studentbook";
	}
?>
</title>

<!-- **Favicon** -->
<link href="favicon.ico" rel="shortcut icon" type="image/x-icon" />

<!-- **CSS - stylesheets** -->
<link id="default-css" href="<?=$this->config->item('css').'reset.css';?>" rel="stylesheet" type="text/css" media="all" />
<link id="default-css" href="<?=$this->config->item('css').'style.css';?>" rel="stylesheet" type="text/css" media="all" />
<link id="skin-css" href="<?=$this->config->item('skin').'blue.css';?>" rel="stylesheet" type="text/css" media="all" />
<link id="responsive-css" href="<?=$this->config->item('css').'responsive.css';?>" rel="stylesheet" type="text/css" media="all" />

<!-- mobile setting -->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

<!--[if lt IE 9]>
	<link rel="stylesheet" type="text/css" href="css/ie8-and-down.css" />
<![endif]-->


<!-- **jQuery** -->
<script type="text/javascript" src="<?=$this->config->item('js').'jquery.min.js';?>"></script>
<script type="text/javascript" src="<?=$this->config->item('js').'jquery.validate.min.js';?>"></script>
<link id="responsive-css" href="<?=$this->config->item('css').'logindcs.css';?>" rel="stylesheet" type="text/css" media="all" />
</head>
<body class="home">
	<div class="container">
		<div class="content content-full-width loginfront">
			<div class="column two-third">
				<h1>SELAMAT DATANG UNIRES UMY</h1>
                <p class="desc">
				Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
				</p>
				<div id="expand-toggle">   
                    <img  title="" width="100" alt="" src="<?=site_url()?>asset/default/images/logofooter.png">
                    <!--<img  title="" alt="" src="<?=site_url()?>asset/default/images/Umy-logo.gif">
                    <img  title="" alt="" src="<?=site_url()?>asset/default/images/logo-telkom-yayasan.png">-->
                </div>
				<div class="divdesc">
					<!--<a href="<?=site_url('homepage/index/1')?>">Beranda</a> | <a href="<?=site_url('homedata/artikel/detailmenu/23')?>">Tentang</a> | <a href="<?=site_url('homedata/artikel/detailmenu/24')?>">Kebijakan</a> | <a href="<?=site_url('homedata/artikel/detailmenu/25')?>">Ketentuan</a> | <a href="<?=site_url('homedata/artikel/detailmenu/26')?>">Standart Etika</a> -->
				</div>
            </div>
			<div class="column one-third last loginright">
                <form id="formlg" method="post" action="<?=base_url()?>authentication/auth">
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                    <!--<h3>Login DCS</h3>-->
                    <input type="text" placeholder="Username" class="textbox" name="username">
                    <input type="password" placeholder="Password" class="textbox" name="password">
                    <div class="forgot" >Forgot Password ?</div>
					<input class="daftarsekolah" type="submit"  class="button small grey" value="Login" name="submit">
					<!--<div class="daftarsekolah" onclick="return submit();">LOG IN</div>-->
                </form>
            </div>			
		</div>
	</div>
</body>
</html>

