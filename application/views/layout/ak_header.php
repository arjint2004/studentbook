<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title> Studentbook </title>

<!-- **Favicon** -->
<link href="favicon.ico" rel="shortcut icon" type="image/x-icon" />

<!-- **CSS - stylesheets** -->
<link id="default-css" href="<?=$this->config->item('css');?>style.css" rel="stylesheet" type="text/css" media="all" />
<link id="skin-css" href="<?=$this->config->item('skin');?>blue.css" rel="stylesheet" type="text/css" media="all" />
<link id="responsive-css" href="<?=$this->config->item('css');?>responsive.css" rel="stylesheet" type="text/css" media="all" />
<link id="responsive-css" href="<?=$this->config->item('css');?>ad_style_front.css" rel="stylesheet" type="text/css" media="all" />

<!-- mobile setting -->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

<!--[if lt IE 9]>
	<link rel="stylesheet" type="text/css" href="css/ie8-and-down.css" />
<![endif]-->



<!-- **jQuery** -->
<script type="text/javascript" src="<?=$this->config->item('js');?>jquery.min.js"></script>


<script type="text/javascript" src="<?=$this->config->item('js');?>jquery.jcarousel.min.js"></script>
<script type="text/javascript" src="<?=$this->config->item('js');?>tinynav.min.js"></script>
<script type="text/javascript" src="<?=$this->config->item('js');?>ultimate-custom.js"></script>
<script type="text/javascript" src="<?=$this->config->item('js').'jquery.tabs.min.js';?>"></script>
<script type="text/javascript" src="<?=$this->config->item('js');?>jquery.tweet.js" charset="utf-8"></script>
<script type="text/javascript">
var base_url='<?=base_url()?>';
jQuery(function($){
	$(".tweets").tweet({
	  join_text: "auto",
	  username: "iamdesigning",
	  count: 3,
	  loading_text: "loading tweets..."
	});
  });
</script>

<script type="text/javascript" src="<?=$this->config->item('js');?>jquery.validate.min.js"></script>
<script type="text/javascript" src="<?=$this->config->item('js');?>sendmail.js"></script>
<script type="text/javascript" src="<?=$this->config->item('fc')?>/jquery.mousewheel-3.0.4.pack.js"></script>
            <script type="text/javascript" src="<?=$this->config->item('fc')?>/jquery.fancybox-1.3.4.js"></script>
            <link rel="stylesheet" type="text/css" href="<?=$this->config->item('fc')?>/jquery.fancybox-1.3.4.css" media="screen" />
            
<?
	$this->load->view('akademik/comment/js');
?>
</head>

<body>

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
							$logo=base_url().'view.php?image=upload/akademik/sekolah/school.png&amp;mode=crop&amp;size=100x100';
						}else{
							$logo=base_url().'view.php?image=upload/akademik/sekolah/'.$this->session->userdata['ak_setting']['logo_sekolah'].'&amp;mode=crop&amp;size=100x100';
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
            </div><!-- **Logo - End** -->        
            
            <div class="float-right">
                <!-- **Searchform** 
                <form action="#" id="searchform" method="get">
                    <fieldset>
                        <input name="Search" type="text" onblur="this.value=(this.value=='') ? 'Enter Keyword' : this.value;" onfocus="this.value=(this.value=='Enter Keyword') ? '' : this.value;" value="Enter Keyword" alt="Search our site" class="text_input" />
                        <input name="submit" type="submit" value="" />
                    </fieldset>
                </form><!**Searchform - End** -->    	
            </div>
            
        </div>
    </div><!-- **Header - End** -->
    
    <?=$this->load->view('layout/menufront');?>
    
    <!-- **Breadcrumb** -->
     <!-- <div class="breadcrumb">
    	<div class="breadcrumb-bg">
            <div class="container">
                <a href="" title=""> Home </a>
                <span class="arrow"> </span>
                <a href="" title=""> Blog </a>
                <span class="arrow"> </span>
                <span class="current-crumb"> Blog With Right Sidebar </span>
            </div> 
        </div>
    </div>**Breadcrumb - End** -->
    
    <!-- ** Main** -->
    <div id="main" class="profile">
    
        <!-- **Container** -->
        <div class="container">
		<?=akademiknotif(1);?>