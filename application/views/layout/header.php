<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Studentbook</title>
        <!-- **Favicon** -->
        <link href="favicon.ico" rel="shortcut icon" type="image/x-icon" />
        <!-- **CSS - stylesheets** -->
        <link id="default-css" href="<?=$this->config->item('css').'style.css';?>" rel="stylesheet" type="text/css"
        media="all" />
        <link id="skin-css" href="<?=$this->config->item('skin').'blue.css';?>" rel="stylesheet" type="text/css"
        media="all" />
        <link id="responsive-css" href="<?=$this->config->item('css').'responsive.css';?>" rel="stylesheet" type="text/css"
        media="all" />
        <!-- mobile setting -->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
        <!--[if lt IE 9]>
            <link rel="stylesheet" type="text/css" href="<?=$this->config->item('css').'ie8-and-down.css';?>" />
        <![endif]-->
        <!-- **Google Fonts** -->
        <link href='http://fonts.googleapis.com/css?family=Droid+Sans:400,700'
        rel='stylesheet' type='text/css' />
        <!-- **jQuery** -->
        <script type="text/javascript" src="<?=$this->config->item('js').'jquery.min.js';?>"></script>
        <script type="text/javascript" src="<?=$this->config->item('js').'jquery.tabs.min.js';?>"></script>
        <script type="text/javascript" src="<?=$this->config->item('js').'jquery.jcarousel.min.js';?>"></script>
        <script type="text/javascript" src="<?=$this->config->item('js').'tinynav.min.js';?>"></script>
        <script type="text/javascript" src="<?=$this->config->item('js').'ultimate-custom.js';?>"></script>
        <script type="text/javascript" src="<?=$this->config->item('js').'jquery.tweet.js';?>" charset="utf-8"></script>
        <script type="text/javascript">
            jQuery(function ($) {
                $(".tweets")
                    .tweet({
                    join_text: "auto",
                    username: "iamdesigning",
                    count: 3,
                    loading_text: "loading tweets..."
                });
            });
        </script>
        <link href="<?=$this->config->item('js').'layerslider.css';?>" rel="stylesheet" type="text/css" media="all" />
        <script src="<?=$this->config->item('js').'jquery-easing-1.3.js';?>" type="text/javascript"></script>
        <script src="<?=$this->config->item('js').'layerslider.kreaturamedia.jquery.js';?>" type="text/javascript"></script>
        <script type="text/javascript">
            $(document)
                .ready(function () {
                $('#layerslider')
                    .layerSlider({
                    skinsPath: <?=$this->config->item('images');?>+'layer-skins/',
                    skin: 'fullwidth',
                    thumbnailNavigation: 'hover',
                    hoverPrevNext: false,
                    responsive: false,
                    responsiveUnder: 940,
                    sublayerContainer: 900
                });
            });
        </script>
        <!-- Pretty Photo -->
        <link rel="stylesheet" href="<?=$this->config->item('css').'prettyPhoto.css';?>" type="text/css" media="screen"
        title="prettyPhoto main stylesheet" charset="utf-8" />
        <script src="<?=$this->config->item('js').'jquery.prettyPhoto.js';?>" type="text/javascript" charset="utf-8"></script>
        <script type="text/javascript" charset="utf-8">
            jQuery(document)
                .ready(function ($) {
                $(".gallery a[rel^='prettyPhoto']")
                    .prettyPhoto({
                    animation_speed: 'normal',
                    theme: 'light_square',
                    slideshow: 3000,
                    autoplay_slideshow: false,
                    social_tools: false
                });
            });
        </script>
        <script type="text/javascript" src="<?=$this->config->item('js').'jquery.validate.min.js';?>"></script>
        <script type="text/javascript" src="<?=$this->config->item('js').'sendmail.js';?>"></script>
    </head>
    
    <body class="home">
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
                        <form action="#" id="searchform" method="get">
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                            <fieldset>
                                <input name="Search" type="text" onblur="this.value=(this.value=='') ? 'Enter Keyword' : this.value;"
                                onfocus="this.value=(this.value=='CARI SEKOLAH') ? '' : this.value;" value="CARI SEKOLAH"
                                alt="Search our site" class="text_input" />
                                <input name="submit" type="submit" value="" />
                            </fieldset>
                        </form>
                        <!-- **Searchform - End** -->
                    </div>
                </div>
            </div>
            <!-- **Header - End** -->
            <!-- **Top-Menu** -->
            <div id="top-menu">
                <div class="container">
                    <ul class="menu">
                        <li class="home current_page_item"> <span class="hoverL"> <span class="hoverR"> </span> </span>
                            <a href="index.html"
                            title="">Home</a>
                            <ul>
                                <li>
                                    <a href="index-v2.html" title="">Home - Multi Purpose</a>
                                </li>
                                <li>
                                    <a href="index-v3.html" title="">Home - Portfolio</a>
                                </li>
                                <li>
                                    <a href="index-v4.html" title="">Home - Blog</a>
                                </li>
                                <li>
                                    <a href="index.html" title="">Home - Business</a>
                                </li>
                            </ul>
                        </li>
                        <li>	<span class="hoverL"> <span class="hoverR">				
			</span></span>
                            <a href="slider-nivo.html" title="">
                                <img src="<?=$this->config->item('images').'post-images/portfolio-three-column1.jpg';?>" alt="" title=""
                                width="50" height="50" style="float: left;padding-right: 20px;" />Jefri Sugiarto</a>
                        </li>
                        <li style="float: right;">	<span class="hoverL"> <span class="hoverR">				
			</span></span>
                            <a href="slider-nivo.html" title="" style="color: yellow;font-size: large;">KELUAR</a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- **Top-Menu - End** -->