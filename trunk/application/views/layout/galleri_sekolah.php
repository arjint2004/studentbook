<?=$this->load->view('layout/ad_header')?>
<style type="text/css" media="screen">
    .slides_container {
            width:640px;
            display:none;
    }

    .slides_container div.slide {
            width:640px;
            height:170px;
            display:block;
    }
    
    .item {
            float:left;
            width:135px;
            height:135px;
            margin:0 10px;
            background:#efefef;
    }
    
    /*
            Optional:
            Reset list default style
    */
    /*
	Pagination
        */
        
        .pagination {
            margin: 0px auto;
                width:100px;
                right: 35%;
        }
        
        .pagination li {
                float:left;
                margin:0 auto;
                list-style:none;
        }
        
        .pagination li a {
                display:block;
                width:12px;
                height:0;
                padding-top:12px;
                background-image:url('../../../asset/default/images/pagination.png');
                background-position:0 0;
                float:left;
                overflow:hidden;
        }
        
        .pagination li.current a {
                background-position:0 -12px;
        }
</style>

<script src="<?=$this->config->item('js')?>/slides.min.jquery.js"></script>

<script>
    $(function(){
            $('#slides').slides({
                    preload: true,
                    play: 2500
            });
    });
</script>

<!-- **Breadcrumb** -->
<div class="breadcrumb">
    <div class="breadcrumb-bg">
        <div class="container">
        <br>
        </div> 
    </div>
</div> <!-- **Breadcrumb - End** -->
<style>
    dl {
        width: 70%;
        margin-left:0px;
    }
    
    dt {
        width: 20%;
        margin:0px;
        float: left;
    }
    
    dd {
        width: 70%;
        margin: 0px;
    }
    
    .link_profil a{
        width: 25%;
        float: left;
    }
</style>
<!-- **Container** -->
<div class="container">
    <!-- **Content** -->
    <div class="content">
        <div class="team" style="margin:0px;">          
            <div class="image"> <img src="<?=site_url('asset/default/images/post-images/team-image1.jpg')?>" alt="" title=""> </div>
            <h5> John Doe </h5>
            <h6 class="role"> Chief Executive Officer </h6>
            <dl style="padding:0px;" class="float-left">
                <dt class="left">Alamat</dt><dd>: Jln.Kenari No 345 Yogyakarta</dd>
                <dt class="left">Telepon</dt><dd>: (0238) 234255</dd>
                <dt class="left">Akreditasi</dt><dd>: A</dd>
                <dt class="left">Kota</dt><dd>: Yogyakarta</dd>
            </dl>
            
            <!-- **Share Links** -->                   
            <div class="share-links"> 
                <div class="column one-half"> 
                    Email: <a href="" title=""> j.doe@domain.com </a> 
                </div>
                <div class="column one-half last"> 
                  
                </div>                    
            </div> <!-- **Share Links - End** -->                 
        <div class="row-fluid span12 link_profil">
            <br>
            <a href="<?=site_url('sos/sekolah/galleri_sekolah/'.$data->id);?>" title="" class="button medium light-grey" style="margin-right:10px;"> Galleri Foto </a>
            <a href="<?=site_url('sos/sekolah/profil_sekolah/'.$data->id);?>" title="" class="button medium light-grey" style="margin-right:10px;"> Profil Sekolah </a>
            <a href="<?=site_url('sos/sekolah/detail_sekolah/'.$data->id);?>" title="" class="button medium light-grey" style="margin-right:10px;"> Beranda </a>    
        </div>
        <div class="hr"></div>
        
        </div>
            <div class="share-links" style="height: 100px;border: 1px solid #C9C1C1;"> 
            <div class="span12">
                <br><br>
                <span style="font-size: 80px;padding: 10px;color: #CECCCC;">
                    SPACE IKLAN
                </span>
            </div>
        </div>
        <div class="hr"></div>
        <h2> GALLERY FOTO</h2>
        <div class="tabs-frame-content" style="display: block;">
            <?php
                if(!empty($galleri_foto)) {
                    echo '<div id="slides">
                            <div class="slides_container">';
                            $no             = 0;
                            $master_gale    = '';
                            $data_gale      = '';
                            foreach($galleri_foto as $gale) {
                                $data_gale .= '<div class="item">
                                                    <img src="'.$gale->thumb.'">
                                                </div>';
                                $no++;
                                if($no==3) {
                                    $data_gale = '<div class="slide">'.$data_gale.'</div>';
                                    $master_gale .= $data_gale;
                                    $data_gale = '';
                                    $no=0;
                                }
                            }
                            if($no==1 or $no==2) {
                                echo $master_gale;
                                echo '<div class="slide">'.$data_gale.'</div>';
                            }
                    echo '</div>
                            </div>';
                }
            ?>
                    <div id="slides">
                            <div class="slides_container">
                    <div class="slide">
                            <div class="item">
                                    Item One
                            </div>
                            <div class="item">
                                    Item Two
                            </div>
                            <div class="item">
                                    Item Three
                            </div>
                            <div class="item">
                                    Item Four
                            </div>
                    </div>
                    
                    <div class="slide">
                            <div class="item">
                                    Item Four
                            </div>
                            <div class="item">
                                    Item Five
                            </div>
                            <div class="item">
                                    Item Six
                            </div>
                             <div class="item">
                                    Item Six
                            </div>
                    </div>
                    
                    <div class="slide">
                            <div class="item">
                                    Item Seven
                            </div>
                            <div class="item">
                                    Item Eight
                            </div>
                             <div class="item">
                                    Item Six
                            </div>
                              <div class="item">
                                    Item Six
                            </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="hr"></div>
        <div class="share-links" style="height: 100px;border: 1px solid #C9C1C1;"> 
            <div class="span12">
                <br><br>
                <span style="font-size: 80px;padding: 10px;color: #CECCCC;">
                    SPACE IKLAN
                </span>
            </div>
        </div>
    </div> <!-- **Content - End** -->   	
    
    <!-- **Sidebar** -->
    <div class="sidebar">
        
        <div class="widget widget_popular_entries">
            <div style="min-height:272px;">
                
            </div>       
        </div>
        
        <div class="hr"> </div>
        
        <div class="widget widget_popular_entries">
        <h2 class="widgettitle"> Popular Posts </h2>
        <ul>
            <li> 
                    <a href="blog-single.html" title="" class="thumb"> <img src="<?=base_url('asset/default/images/post-images/popular-post1.jpg')?>" alt="" title=""> </a>
                <h6> <a href="blog-single.html" title=""> Lorem ipsum dolor </a> </h6>
                <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit... </p>
            </li>
            <li> 
                    <a href="blog-single.html" title="" class="thumb"> <img src="<?=base_url('asset/default/images/post-images/popular-post1.jpg')?>" alt="" title=""> </a>
                <h6> <a href="blog-single.html" title=""> Lorem ipsum dolor </a> </h6>
                <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit... </p>
            </li>
            <li> 
                    <a href="blog-single.html" title="" class="thumb"> <img src="<?=base_url('asset/default/images/post-images/popular-post2.jpg')?>" alt="" title=""> </a>
                <h6> <a href="blog-single.html" title=""> Lorem ipsum dolor </a> </h6>
                <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit... </p>
            </li><li> 
                    <a href="blog-single.html" title="" class="thumb"> <img src="<?=base_url('asset/default/images/post-images/popular-post1.jpg')?>" alt="" title=""> </a>
                <h6> <a href="blog-single.html" title=""> Lorem ipsum dolor </a> </h6>
                <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit... </p>
            </li>
            <li> 
                    <a href="blog-single.html" title="" class="thumb"> <img src="<?=base_url('asset/default/images/post-images/popular-post2.jpg')?>" alt="" title=""> </a>
                <h6> <a href="blog-single.html" title=""> Lorem ipsum dolor </a> </h6>
                <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit... </p>
            </li><li> 
                    <a href="blog-single.html" title="" class="thumb"> <img src="<?=base_url('asset/default/images/post-images/popular-post1.jpg')?>" alt="" title=""> </a>
                <h6> <a href="blog-single.html" title=""> Lorem ipsum dolor </a> </h6>
                <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit... </p>
            </li>
            <li> 
                    <a href="blog-single.html" title="" class="thumb"> <img src="<?=base_url('asset/default/images/post-images/popular-post2.jpg')?>" alt="" title=""> </a>
                <h6> <a href="blog-single.html" title=""> Lorem ipsum dolor </a> </h6>
                <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit... </p>
            </li><li> 
                    <a href="blog-single.html" title="" class="thumb"> <img src="<?=base_url('asset/default/images/post-images/popular-post1.jpg')?>" alt="" title=""> </a>
                <h6> <a href="blog-single.html" title=""> Lorem ipsum dolor </a> </h6>
                <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit... </p>
            </li>
            <li> 
                    <a href="blog-single.html" title="" class="thumb"> <img src="<?=base_url('asset/default/images/post-images/popular-post2.jpg')?>" alt="" title=""> </a>
                <h6> <a href="blog-single.html" title=""> Lorem ipsum dolor </a> </h6>
                <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit... </p>
            </li><li> 
                    <a href="blog-single.html" title="" class="thumb"> <img src="<?=base_url('asset/default/images/post-images/popular-post1.jpg')?>" alt="" title=""> </a>
                <h6> <a href="blog-single.html" title=""> Lorem ipsum dolor </a> </h6>
                <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit... </p>
            </li>
            <li> 
                    <a href="blog-single.html" title="" class="thumb"> <img src="<?=base_url('asset/default/images/post-images/popular-post2.jpg')?>" alt="" title=""> </a>
                <h6> <a href="blog-single.html" title=""> Lorem ipsum dolor </a> </h6>
                <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit... </p>
            </li><li> 
                    <a href="blog-single.html" title="" class="thumb"> <img src="<?=base_url('asset/default/images/post-images/popular-post1.jpg')?>" alt="" title=""> </a>
                <h6> <a href="blog-single.html" title=""> Lorem ipsum dolor </a> </h6>
                <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit... </p>
            </li>
            <li> 
                    <a href="blog-single.html" title="" class="thumb"> <img src="<?=base_url('asset/default/images/post-images/popular-post2.jpg')?>" alt="" title=""> </a>
                <h6> <a href="blog-single.html" title=""> Lorem ipsum dolor </a> </h6>
                <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit... </p>
            </li>
        </ul>
        </div>                     
    </div><!-- **Sidebar - End** --> 
</div><!-- **Container - End** -->
    
<?=$this->load->view('layout/ad_footer')?>