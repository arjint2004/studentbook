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
<link id="bootstrap-css" href="<?=$this->config->item('css').'fat_bootstrap.min.css';?>" rel="stylesheet" type="text/css" media="all" />
<link id="metro-css" href="<?=$this->config->item('css').'fat_metro.css';?>" rel="stylesheet" type="text/css" media="all" />
<link id="skin-css" href="<?=$this->config->item('skin').'blue.css';?>" rel="stylesheet" type="text/css" media="all" />
<link id="default-css" href="<?=$this->config->item('css').'fmslideshow.min.css';?>" rel="stylesheet" type="text/css" media="all" />
<link id="responsive-css" href="<?=$this->config->item('css').'responsive.css';?>" rel="stylesheet" type="text/css" media="all" />

<!-- mobile setting -->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

<!--[if lt IE 9]>
	<link rel="stylesheet" type="text/css" href="css/ie8-and-down.css" />
<![endif]-->

<!-- **jQuery** -->
<script type="text/javascript" src="<?=$this->config->item('js').'jquery.min.js';?>"></script>
<script type="text/javascript" src="<?=$this->config->item('js').'jquery.cycle.all.js';?>"></script>
<script type="text/javascript" src="<?=$this->config->item('js').'fmslideshow.min.js';?>"></script>
<script type="text/javascript" src="<?=$this->config->item('js').'jwSlider-packed.js';?>"></script>

<script type="text/javascript" src="<?=$this->config->item('js').'jquery.tabs.min.js';?>"></script>
<script type="text/javascript" src="<?=$this->config->item('js').'jquery.jcarousel.min.js';?>"></script>
<script type="text/javascript" src="<?=$this->config->item('js').'tinynav.min.js';?>"></script>
<script type="text/javascript" src="<?=$this->config->item('js').'ultimate-custom.js';?>"></script>

<script type="text/javascript" src="<?=$this->config->item('js').'jquery.tweet.js';?>" charset="utf-8"></script>
<script type="text/javascript">
var base_url='<?=base_url()?>';
var config_images='<?=$this->config->item('images');?>';
</script>
<?
	$this->load->view('akademik/comment/js');
?>
<!-- Pretty Photo -->
<link rel="stylesheet" href="<?=$this->config->item('css').'prettyPhoto.css';?>" type="text/css" media="screen" title="prettyPhoto main stylesheet" charset="utf-8" />
<script src="<?=$this->config->item('js').'jquery.prettyPhoto.js';?>" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" charset="utf-8">
	jQuery(document).ready(function($){			
		$(".gallery a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'normal',theme:'light_square',slideshow:3000, autoplay_slideshow: false,social_tools: false});				
	});
	
	$(document).ready(function(){
		$("#notification").live('click',function(){
			$(this).remove();	
		});
	});
</script>

<script type="text/javascript" src="<?=$this->config->item('js').'jquery.validate.min.js';?>"></script>
<script type="text/javascript" src="<?=$this->config->item('js').'sendmail.js';?>"></script>
<script type="text/javascript" src="<?=$this->config->item('js').'ad_js.js';?>"></script>
<link id="default-css" href="<?=$this->config->item('css').'ad_style.css';?>" rel="stylesheet" type="text/css" media="all" />

</head>

<body class="home">

<?=print_notification()?>
<? $this->load->view('layout/login-box')?>
<!-- **Wrapper** -->
<div id="wrapper">
    <!-- **Header** -->
    <div id="header">
        <div class="container">
        
             <!-- **Logo** -->
            <div id="logo">
                <a  href="<?=base_url()?>" title="">
					<? 
					if(isset($this->session->userdata['ak_setting']['logo_sekolah']) && $this->session->userdata['ak_setting']['logo_sekolah']!=''){
						if(!file_exists('upload/akademik/sekolah/'.$this->session->userdata['ak_setting']['logo_sekolah'])){
							$logo=$this->config->item('akademik_sekolah').'school.png';
						}else{
							$logo=$this->config->item('akademik_sekolah').$this->session->userdata['ak_setting']['logo_sekolah'];
						}
						$h1="<h1 >".$this->session->userdata['ak_setting']['nama_sekolah']."</h1>";
						$h2="<h6 >".$this->session->userdata['ak_setting']['alamat_sekolah']."</h6>";
						$cls='class="lgn"';
					}else{
						$logo=$this->config->item('images').'logo.png';
					}
					?>
					<img  src="<?=$logo?>" alt="" <?=$cls?> title="" />
					<?=$h1?>
					<?=$h2?>
				</a>
				<??>
            </div><!-- **Logo - End** -->    
            <div class="float-right">
                <!-- **Searchform** -->
                <form action="<?=site_url('sos/sekolah/pencari_sekolah')?>" id="searchform" method="POST">
                    <fieldset>
                        <input name="pencarian" type="text" onblur="this.value=(this.value=='') ? 'Cari Sekolah' : this.value;" onfocus="this.value=(this.value=='Cari Sekolah') ? '' : this.value;" value="Cari Sekolah" alt="Search our site" class="text_input" />
                        <input name="submit" type="submit" value="" />
                    </fieldset>
               </form><!-- **Searchform - End** -->    	
            </div>
            
        </div>
    </div><!-- **Header - End** -->
	
    <?

	if($this->router->class.$this->router->method=='sekolahdetail_sekolah' || $this->router->class.$this->router->method=='sekolahcontent'){
		$this->load->view('layout/menusekolah');
	}else{
		$this->load->view('layout/menufront');
	}
	?>    <!-- ** Main** -->
    <div id="main" class="profile">
    
        <!-- **Container** -->
        <div class="container">
