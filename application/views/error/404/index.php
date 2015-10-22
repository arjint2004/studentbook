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

<script type="text/javascript" src="<?=$this->config->item('js');?>ultimate-custom.js"></script>

</head>

<body class="error404">

<!-- **Wrapper** -->
<div id="wrapper">
    <!-- ** Main** -->
    <div id="main">
    
        <!-- **Container** -->
        <div class="container">
        
            <!-- **Content Full Width** -->
            <div class="content content-full-width">
            
                <h1 class="with-subtitle">  404 Not Found </h1>
                <h6 class="subtitle">  <?=base_url()?> </h6>
                
                <div class="errorpage-info">
                    <h2> 404 </h2>
                    <h3> Halaman tidak ditrmukan </h3>
                    <h4> Pastikan URL benar </h4>
                    <a href="<?=base_url()?>" title="" class="button medium grey"> Kembali ke Beranda </a>
                </div>
            
            </div> <!-- **Content Full Width - End** -->   	
            
        </div><!-- **Container - End** -->
    </div><!-- **Main - End**-->
</div><!-- **Wrapper - End** -->


</body>
</html>
