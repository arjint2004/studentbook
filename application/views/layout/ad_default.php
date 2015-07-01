<!DOCTYPE html>
<!--[if lte IE 8]>              <html class="ie8 no-js" lang="en">     <![endif]-->
<!--[if IE 9]>					<html class="ie9 no-js" lang="en">     <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="not-ie no-js" lang="en">  <!--<![endif]-->
<head>
	<!-- Google Web Fonts
  ================================================== -->
	<link href='http://fonts.googleapis.com/css?family=Allura|Oswald:400,700,300' rel='stylesheet' type='text/css'>
	
	<!-- Basic Page Needs
  ================================================== -->
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!--[if ie]><meta http-equiv='X-UA-Compatible' content="IE=edge,IE=9,IE=8,chrome=1" /><![endif]-->
	
	<title>	
	<?php
	if(isset($page_title)) {
			echo $page_title;
		}else {
			echo "studentbook";
		}
	?>
	</title>
	
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="shortcut" href="<?=$this->config->item('images_almera');?>favicon.ico" />
	<script>var base_url='<?=base_url()?>';</script>
	<!-- Mobile Specific Metas
  ================================================== -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	
	<!-- CSS
  ================================================== -->
	<link rel="stylesheet" href="<?=$this->config->item('css_almera');?>style.css" />
	<link rel="stylesheet" href="<?=$this->config->item('css_almera');?>skeleton.css" />
	<link rel="stylesheet" href="<?=$this->config->item('css_almera');?>layout.css" />
	
	<link rel="stylesheet" href="<?=$this->config->item('css_almera');?>font-awesome.css" />
	<link rel="stylesheet" href="<?=$this->config->item('js_almera');?>fancybox/jquery.fancybox.css" />

	<!-- HTML5 Shiv
	================================================== -->
	
	<script src="<?=$this->config->item('js_almera');?>jquery.modernizr.js"></script>
	
</head>
<body>
	
<!-- - - - - - - - - - - - - - Header - - - - - - - - - - - - - - - - -->	
<header id="header">

	<div class="container">

		<div class="sixteen columns">

			<form method="POST" id="searchform" action="<?=base_url?>sos/sekolah/pencari_sekolah">
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
					<input type="text" class="text_input" alt="Search our site" value="Cari Sekolah" onfocus="this.value=(this.value=='Cari Sekolah') ? '' : this.value;" onblur="this.value=(this.value=='') ? 'Cari Sekolah' : this.value;" name="pencarian">
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
					<input type="submit" value="Cari" name="submit">
			</form>
			<div id="logo">
				<h1><a href="<?=base_url()?>" title=""> <img src="<?=site_url()?>asset/default/images/logo.png" alt="" title="" style="height:28px;"></a></h1>
			</div><!--/ #logo-->

			<nav id="navigation" class="navigation">

				<div class="menu">

					<ul>
						
						<!--<li class="current-menu-item"><a href="">Artikel</a></li>-->
						<? if($this->session->userdata('user_authentication')){
								$cek = session_data();
								if(empty($cek)) {
									$cek = '';
								}
								$user = DataUser();
								
									if(empty($user->foto)) {
										$user->foto = 'asset/default/images/no_profile.jpg';
									}
									
									if($cek['otoritas']=='siswa') {
										$url_redirect = site_url('siswa');
									}elseif($cek['otoritas']=='ortu'){
										$url_redirect = site_url('ortu');
									}elseif($cek['otoritas']=='guru'){
										$url_redirect = site_url('sos/pegawai/');
									}elseif($cek['otoritas']=='superadmin'){
										$url_redirect = site_url('superadmin/super/');
									}elseif($cek['otoritas']=='admin sekolah'){
										$url_redirect = site_url('admin/schooladmin');
									}elseif($cek['otoritas']=='admin'){
										$url_redirect = site_url('/adminsb/admin');
									}
									//pr($this->session->userdata['user']);
								?>
								
						<li  class="current-menu-item"><a href="<?=$url_redirect?>">Home</a></li>
						<li class="current-menu-item"><a href="<?php echo base_url();?>admin/login/logout">Keluar</a></li>
						<? }else{ ?>
						<li class="lidaftar"><a class="adaftar" href="<?=site_url('sekolah/daftar_sekolah')?>">DAFTAR</a></li>
						<li class="current-menu-item"><a href="<?=site_url('homedata/artikel/detailmenu/23')?>">TENTANG</a></li>
						<li class="current-menu-item"><a href="<?=site_url('homedata/artikel/detailmenu/24')?>">KEBIJAKAN</a></li>
						<li class="current-menu-item"><a href="<?=site_url('homedata/artikel/detailmenu/25')?>">KETENTUAN</a></li>
						<li class="current-menu-item"><a href="<?=site_url('homedata/artikel/detailmenu/26')?>">STANDART ETIKA</a></li>
						<li class="current-menu-item"><a href="<?=site_url('homepage/hubungi_kami')?>">HUBUNGI KAMI</a></li>
						<? } ?>
						<!--<li><a href="image-gallery.html">Gallery</a>
							<ul>
								<li><a href="image-gallery.html">Image Gallery</a></li>
								<li><a href="thumbnails.html">Thumbnails</a></li>
								<li><a href="gallery-3-columns.html">3 Columns</a></li>
								<li><a href="gallery-4-columns.html">4 Columns</a></li>
							</ul>
						</li>-->
					</ul>

				</div><!--/ .menu-->

			</nav><!--/ #navigation-->	

		</div><!--/ .columns-->

	</div><!--/ .container-->

</header><!--/ #header-->

<!-- - - - - - - - - - - - - - end Header - - - - - - - - - - - - - - - - -->	


<!-- - - - - - - - - - - - - - - - Content - - - - - - - - - - - - - - - - -->	

<div id="wrapper" class="sbr">
	
	<div id="content">
		<ul class="scroll-box-nav"style="position: relative; top: -11px;">
			
			<? foreach($rubrik as $ky=>$dtrubrik){?>
			<li ><a href="<?=base_url('/homepage/index/'.$dtrubrik['id_kategori'].'')?>"><?=$dtrubrik['nama_kategori']?></a></li>
			<? } ?>
			<li class='log searchz'>
				<form  method="POST" action="<?=base_url()?>sos/sekolah/pencari_sekolah" id="loginhomez">
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
						<input type="text"  value="Cari Sekolah" onfocus="this.value=(this.value=='Cari Sekolah') ? '' : this.value;" onblur="this.value=(this.value=='') ? 'Cari Sekolah' : this.value;"  class="login_user" name="pencarian">
						<input type="submit" value="Cari" id="" name="submit">
				</form>
			</li>
			<?if(!$this->session->userdata('user_authentication')){?>
				<li class='log'>
				<form action="<?=base_url()?>authentication/auth"  method="POST" id="loginhome">
						<input type="text" placeholder="Username"  class="login_user" name="username">
						<input type="password" placeholder="Password"  class="login_user" name="password">	
						<input type="submit" value="Masuk" id="" name="submit">
				</form>
				</li>		
			<? } ?>	
		</ul><!--/ .scroll-box-nav-->
		<?php
			if(isset($main)) {
				$this->load->view($main);     
			}
		?>
	</div><!--/ #content-->
	
</div><!--/ #wrapper-->

<!-- - - - - - - - - - - - - - - - Content - - - - - - - - - - - - - - - - -->	


<!-- - - - - - - - - - - - - - - Footer - - - - - - - - - - - - - - - - -->	

<footer id="footer">

	<div class="container">

		<div class="sixteen columns">

			<div class="eight columns alpha">

				<div class="copyright">
					Copyright &copy; 2013. StudentBook. All rights reserved
				</div><!--/ .copyright-->

				<div class="developed">
					Developed by <a href="#" style="color:#eee;">Arjint</a>
				</div><!--/ .developed-->

			</div><!--/ .columns-->

			<div class="eight columns omega">

				<ul class="social-icons">
					<li class="twitter"><a target="_blank" href="https://twitter.com/ThemeMakers"><span>Twitter</span></a></li>
					<li class="facebook"><a target="_blank" href="http://www.facebook.com/wpThemeMakers"><span>Facebook</span></a></li>
					<li class="dribble"><a target="_blank" href="http://dribbble.com/"><span>Dribbble</span></a></li>
					<li class="vimeo"><a target="_blank" href="https://vimeo.com/"><span>Vimeo</span></a></li>
					<li class="youtube"><a target="_blank" href="http://www.youtube.com/"><span>Youtube</span></a></li>
					<li class="instagram"><a target="_blank" href="http://www.instagram.com/"><span>Instagram</span></a></li>
					<li class="rss"><a target="_blank" href="#"><span>Rss</span></a></li>
				</ul><!--/ .social-icons-->	

			</div><!--/ .columns-->

		</div><!--/ .columns-->

	</div><!--/ .container-->

</footer><!--/ #footer-->

<!-- - - - - - - - - - - - - - end Footer - - - - - - - - - - - - - - - -->			

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="<?=$this->config->item('js_almera');?>jquery.min.js"><\/script>')</script>
<script src="<?=$this->config->item('js_almera');?>jquery.easing.1.3.min.js"></script>
<script src="<?=$this->config->item('js_almera');?>jquery.cycle.all.min.js"></script>
<script src="<?=$this->config->item('js_almera');?>jquery.mousewheel.js"></script>
<script src="<?=$this->config->item('js_almera');?>jquery.nicescroll.js"></script>
<!--For Touch Devices-->
<script src="<?=$this->config->item('js_almera');?>jquery.touchswipe.min.js"></script>
<script src="<?=$this->config->item('js_almera');?>jquery.mobile-touch-swipe-1.0.js"></script>
<!--end Touch Devices-->
<script src="<?=$this->config->item('js_almera');?>fancybox/jquery.fancybox.pack.js"></script>
<script src="<?=$this->config->item('js_almera');?>jquery.resizegrid.js"></script>
<script src="<?=$this->config->item('js_almera');?>config.js"></script>
<script src="<?=$this->config->item('js_almera');?>custom.js"></script>
</body>
</html>
