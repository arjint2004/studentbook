<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>
        <?php if(isset($page_title)) { echo $page_title; }else { echo
            "studentbook"; } ?>
        </title>
        <!-- **Favicon** -->
        <link href="favicon.ico" rel="shortcut icon" type="image/x-icon" />
        <!-- **CSS - stylesheets** -->
        <link id="default-css" href="<?=$this->config->item('css').'reset.css';?>"
        rel="stylesheet" type="text/css" media="all" />
        <link id="default-css" href="<?=$this->config->item('css').'style.css';?>"
        rel="stylesheet" type="text/css" media="all" />
        <link id="skin-css" href="<?=$this->config->item('skin').'blue.css';?>"
        rel="stylesheet" type="text/css" media="all" />
        <link id="responsive-css" href="<?=$this->config->item('css').'responsive.css';?>"
        rel="stylesheet" type="text/css" media="all" />
        <link href="<?=$this->config->item('css').'sosial.css';?>" rel="stylesheet"
        type="text/css" media="all" />
        <!-- mobile setting -->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"
        />
        <!--[if lt IE 9]>
            <link rel="stylesheet" type="text/css" href="css/ie8-and-down.css" />
            <![endif]-->

            <!-- **jQuery** -->
            <script type="text/javascript" src="<?=$this->config->item('js').'jquery.validate.min.js';?>"></script>
            <script type="text/javascript" src="<?=$this->config->item('js').'sendmail.js';?>"></script>
            <script src="<?=$this->config->item('js')?>/jquery-1.8.3.js"></script>
            <script src="<?=$this->config->item('js')?>/jquery-ui.js"></script>
            <link rel="stylesheet" href="<?=$this->config->item('css')?>/jquery-ui.css" />
            <script type="text/javascript">
            $(function(){
                $(document).ajaxStop(function() {
                    $( ".tooltip" ).tooltip({
                       position:{
                          my: "center top",
                          at: "center top-30"
                      },
                      hide: {
                         effect: "explode",
                         delay: 250
                     }
                    });
                });
            });
            </script>
            
            <script type="text/javascript" src="<?=$this->config->item('js').'jquery.min.js';?>"></script>
            <script type="text/javascript" src="<?=$this->config->item('js').'jquery.tabs.min.js';?>"></script>
            <script type="text/javascript" src="<?=$this->config->item('js').'jquery.jcarousel.min.js';?>"></script>
            <script type="text/javascript" src="<?=$this->config->item('js').'tinynav.min.js';?>"></script>
            <script type="text/javascript" src="<?=$this->config->item('js').'ultimate-custom.js';?>"></script>
            <script type="text/javascript" src="<?=$this->config->item('js').'jquery.tweet.js';?>"
            charset="utf-8"></script>
            
            <script type="text/javascript">
            jQuery(function ($) {
                $(".tweets")
                .tweet({
                    join_text: "auto",
                    username: "tvone",
                    count: 3,
                    loading_text: "loading tweets..."
                });
            });
            </script>
            <link href="<?=$this->config->item('css').'layerslider.css';?>"
            rel="stylesheet" type="text/css" media="all" />
            <script src="<?=$this->config->item('js').'jquery-easing-1.3.js';?>" type="text/javascript"></script>
            <script src="<?=$this->config->item('js').'layerslider.kreaturamedia.jquery.js';?>"
            type="text/javascript"></script>
            <script type="text/javascript">
            $(document).ready(function () {
                $('#layerslider').layerSlider({
                    skinsPath: '<?php echo base_url(); ?>asset/default/images/layer-skins/',
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
            <link rel="stylesheet" href="<?=$this->config->item('css').'prettyPhoto.css';?>"
            type="text/css" media="screen" title="prettyPhoto main stylesheet" charset="utf-8"
            />
            <script src="<?=$this->config->item('js').'jquery.prettyPhoto.js';?>"
            type="text/javascript" charset="utf-8"></script>
            <script type="text/javascript" charset="utf-8">
            jQuery(document).ready(function ($) {
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
           
            <script type="text/javascript" src="<?=$this->config->item('js')?>/ajaxfileupload.js"></script>
            <!--<script type="text/javascript" src="<?=$this->config->item('js')?>/slides.min.jquery.js"></script>-->
            <script>
            $(function(){
            // $('#slides').slides({
            //   preload: true,
            //   play: 4500,
            //   pause: 1500,
            //   hoverPause: true,
            //   generatePagination: false
            //});
            // 
            //$('#slides_berita').slides({
            //   preload: true,
            //   play: 4500,
            //   pause: 1500,
            //   hoverPause: true,
            //   generatePagination: false
            //});
            // 
            //$('#slides_kegiatan').slides({
            //   preload: true,
            //   play: 4500,
            //   pause: 1500,
            //   hoverPause: true,
            //   generatePagination: false
            //});
            //
            //$("#slides_ultah").slides({
            //   preload: true,
            //   play: 4500,
            //   pause: 1500,
            //   hoverPause: true,
            //   generatePagination: false
            //});
            
         });
            </script>
            <script type="text/javascript" src="<?=$this->config->item('fc')?>/jquery.mousewheel-3.0.4.pack.js"></script>
            <script type="text/javascript" src="<?=$this->config->item('fc')?>/jquery.fancybox-1.3.4.pack.js"></script>
            <link rel="stylesheet" type="text/css" href="<?=$this->config->item('fc')?>/jquery.fancybox-1.3.4.css" media="screen" />
            <script>
            $(function(){
                $("a[rel=group_image]").fancybox({
                    'transitionIn'   : 'none',
                    'transitionOut'  : 'none',
                    'titlePosition'  : 'over',
                    'titleFormat'    : function(title, currentArray, currentIndex, currentOpts) {
                     return '<span id="fancybox-title-over">Image ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
                     }
                 });
                
                $("a.album_image").fancybox({
                    'transitionIn'   : 'none',
                    'transitionOut'  : 'none',
                    'titlePosition'  : 'over',
                    'titleFormat'    : function(title, currentArray, currentIndex, currentOpts) {
                        return '<span id="fancybox-title-over">Image ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
                    }
                });
            
                 $(document).ajaxStop(function() { 
                    $("a.prev_image").fancybox({
                        'opacity'	: true,
                        'overlayShow'	: false,
                        'transitionIn'	: 'elastic',
                        'transitionOut'	: 'none'
                    });
     
                     $("a[rel=group_image]").fancybox({
                        'transitionIn'   : 'none',
                        'transitionOut'  : 'none',
                        'titlePosition'  : 'over',
                        'titleFormat'    : function(title, currentArray, currentIndex, currentOpts) {
                         return '<span id="fancybox-title-over">Image ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
                         }
                     });
                     
                     //$("a.album_image").fancybox({
                     //   'transitionIn'   : 'none',
                     //   'transitionOut'  : 'none',
                     //   'titlePosition'  : 'over',
                     //   'titleFormat'    : function(title, currentArray, currentIndex, currentOpts) {
                     //    return '<span id="fancybox-title-over">Image ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
                     //  }
                     //});     
                });
                
                $("a.prev_image").fancybox({
                    'opacity'	: true,
                    'overlayShow'	: false,
                    'transitionIn'	: 'elastic',
                    'transitionOut'	: 'none'
                });
 
                //
                //$("a.album_image").fancybox({
                //   'transitionIn'   : 'none',
                //   'transitionOut'  : 'none',
                //   'titlePosition'  : 'over',
                //   'titleFormat'    : function(title, currentArray, currentIndex, currentOpts) {
                //    return '<span id="fancybox-title-over">Image ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
                //  }
                //});
                //
            
                $("a[rel=group_image]").fancybox({
                        'transitionIn'   : 'none',
                        'transitionOut'  : 'none',
                        'titlePosition'  : 'over',
                        'titleFormat'    : function(title, currentArray, currentIndex, currentOpts) {
                         return '<span id="fancybox-title-over">Image ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
                         }
                     });
                 
                $(".modal_dialog").fancybox();
            });
            </script>
            
            <!-- notification -->
            <script>
            $(function(){
                $("#notification").live('click',function(){
                    $(this).fadeOut(500,function(){
                        $(this).remove();
                    })
                })
            });
            </script>
            
            <!-- tagl input -->
            <link rel="stylesheet" type="text/css" href="<?=$this->config->item('css')?>jquery.tagsinput.css" />
            <script type="text/javascript" src="<?=$this->config->item('js')?>jquery.tagsinput.js"></script>
            
            <!-- datepicker -->
            <link rel="stylesheet" type="text/css" href="<?=$this->config->item('css')?>glDatePicker.default.css" />
            <script type="text/javascript" src="<?=$this->config->item('js')?>glDatePicker.js"></script>
            <script type="text/javascript">
                $(function(){
                    $('.datepicker').live('focus',function(){
                        $(this).glDatePicker({
                            onClick: function(target, cell, date, data) {
                                target.val(date.getFullYear() + '-' +
                                            parseInt(date.getMonth()+1) + '-' +
                                            date.getDate());
                        
                                if(data != null) {
                                    alert(data.message + '\n' + date);
                                }
                            }
                        });    
                    })
                });
            </script>

            <!-- jquery upload multiple -->
            <script type="text/javascript" src="<?=$this->config->item('js')?>dropzone.js"></script>
            <link type="text/css" rel="stylesheet" media="all" href="<?=$this->config->item('css')?>dropzone.css"/>
            <link type="text/css" rel="stylesheet" media="all" href="<?=$this->config->item('css')?>basic.css"/>
            
            <!-- chat -->
            <link type="text/css" rel="stylesheet" media="all" href="<?=$this->config->item('css')?>chat.css" />
            <script type="text/javascript" src="<?=$this->config->item('js')?>chat.js"></script>
            <script type='text/javascript'>
            $(function(){
                jQuery(document).ready(function(){
                jQuery("#studentbook_right").hover(function(){ jQuery(this).stop(true,false).animate({right:  0}, 500); },function(){ jQuery("#studentbook_right").stop(true,false).animate({right: -240}, 500); });     jQuery("#google_plus_right").hover(function(){ jQuery(this).stop(true,false).animate({right:  0}, 500); },function(){ jQuery("#google_plus_right").stop(true,false).animate({right: -154}, 500); });    jQuery("#feedburner_right").hover(function(){ jQuery(this).stop(true,false).animate({right:  0}, 500); },function(){ jQuery("#feedburner_right").stop(true,false).animate({right: -303}, 500); });});   
            })
            </script>
            <style>
                #studentbook_div {width:234px;height: 256px;overflow: hidden;}
                #studentbook_right {z-index: 999999999;border:2px solid #6CC5FF;background-color: #6CC5FF;width:234px;height: 256px;position: fixed;right: -240px;}
                #studentbook_right_img {position: absolute;top: -2px;left: -35px;border: 0;}
            </style>
            <!-- end chat-->
            
            <!-- scroll halaman-->
            <script>
                $(function(){
                   $("html, body").animate({ scrollTop: $('#awal_group').offset().top }, 1000); 
                });
            </script>
            <!-- endscroll-->
            
           
</head>


<body class="home">
    <div id="login-box" class="login-popup">
        <a href="#" class="close">
            <img src="<?=$this->config->item('images').'close_pop.png';?>" class="btn_close"
            title="Close Window" alt="Close" />
        </a>
        <form accept-charset="utf-8" method="post" class="signin" action="<?php echo base_url(); ?>index.php/verifylogin">
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
            <fieldset class="textbox">
                <label class="username"> <span>Username or email</span>

                    <input id="username" name="username" value="Username"
                    type="text" onfocus="this.value=(this.value=='Username') ? '' : this.value;"
                    onblur="this.value=(this.value=='') ? 'Username' : this.value;">
                </label>
                <label class="password"> <span>Password</span>

                    <input id="password" name="password" value="Password"
                    type="password" onfocus="this.value=(this.value=='Password') ? '' : this.value;"
                    onblur="this.value=(this.value=='') ? 'Password' : this.value;">
                </label>
                <input class="submit button" type="submit" value="Login" />
                <p>
                    <a class="forgot" href="#">Forgot your password?</a>
                </p>
            </fieldset>
        </form>
    </div>
    
    <!-- **Wrapper** -->
    <div id="wrapper">
        <!-- **Header** -->
        <div id="header">
            <div class="container">
              <!-- **Logo** -->
              <div id="logo">
                <a href="#" title="">
                    <img src="<?=$this->config->item('images').'logo.png';?>" alt="" title=""/>
                    <br>
                    <p id="title_logo">towards integrated digital school</p>
                </a>
            </div>
            <!-- **Logo - End** -->
            <div class="float-right ">
                <!-- **Searchform** -->
                <form action="#" id="searchform" method="get">
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                    <fieldset>
                        <input name="Search" type="text" onblur="this.value=(this.value=='') ? 'Cari Sekolah' : this.value;"
                        onfocus="this.value=(this.value=='Cari Sekolah') ? '' : this.value;" value="Cari Sekolah"
                        alt="Search our site" class="text_input" />
                        <input name="submit" type="submit" value="" />
                    </fieldset>
                </form>
                <!-- **Searchform - End** -->
            </div>
        </div>
    </div>
    <?php
    $cek = session_data();
    if(empty($cek)) {
        $cek = '';
    }
    ?>
    <!-- **Header - End** -->
    <!-- **Top-Menu** -->
        <?=print_notification();?>
    <!-- **Top-Menu** -->
    <div id="top-menu">
        <div class="container">
            <div class="row-fluid">
                <?php
                    $user = DataUser();
                    if(!empty($user))
                    {
                        if(empty($user->foto)) {
                            $user->foto = 'asset/default/images/no_profile.jpg';
                        }
                        
                        if($cek['otoritas']=='siswa') {
                            $url_redirect = site_url('sos/siswa/');
                        }else{
                            $url_redirect = site_url('sos/pegawai/');
                        }
                    ?>
                        <div class="span10 float-left">
                            <a href="<?=site_url('')?>" id="home_menu">
                                <img src="<?=$this->config->item('images').'home-ico.png'?>" id="image_home_menu"/>
                            </a>
                            <a href="<?=$url_redirect?>" title="">
                             <img src="<?=base_url($user->foto)?>"
                             alt="" title="" width="50" height="50" id="user_thumb" />
                             <a href="<?=$url_redirect?>" title="">
                                 <p id="user_name"><a href="<?=$url_redirect?>" title=""><?=$user->nama?></a></p>
                             </div>
                             <div class="span2" id="tag_logout">
                                <a class="float-right button small grey" id="logout_link" href="<?=site_url('authentication/logout')?>">Keluar</a>
                            </div>
                        </div>
                    <?php
                    }
                ?>
            </div>
        </div>

        <!-- **Top-Menu - End** -->
        <!-- **Main** -->
        <div id="main">
            <!-- **Container** -->
            <div class="container">
                <!-- **Content** -->
                <div class="content">
                    <?php
                        if(!empty($data_group)) {
                        ?>
                            <div class="column one-fourth">
                                <div class="thumb">
                                    <a href="<?=base_url($data_group->logo)?>">
                                        <img src="<?=base_url($data_group->logo)?>" alt="" title="" width="142" height="155" />
                                    </a>
                                </div>
                            </div>
                            <div class="column three-fourth last left" style="min-height: 190px;">
                                <a href="#">
                                    <h2><?=$data_group->nama_group?></h2>
                                </a>
                                <div class="row-fluid">
                                    <div class="span12">
                                        <?=$data_group->deskripsi?>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                    ?>