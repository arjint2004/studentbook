<?=$this->load->view('layout/ad_header')?>
<script type="text/javascript">
    $(function() {
        $("#but_profile").click(function(){
            $("#profile").removeAttr("style", "display:none");
            $("#beranda").attr("style", "display:none");
            $("#gallery").attr("style", "display:none");
        })
         $("#but_beranda").click(function(){
            $("#beranda").removeAttr("style", "display:none");
            $("#profile").attr("style", "display:none");
            $("#gallery").attr("style", "display:none");
        })
        $("#but_gallery").click(function(){
            $("#gallery").removeAttr("style", "display:none");
            $("#beranda").attr("style", "display:none");
            $("#profile").attr("style", "display:none");
        })
    })
</script>
<style type="text/css">
    .button{
        width:27%;
    }
</style>
<!-- ** Main** -->
    <div id="main">
    
        <!-- **Container** -->
        <div class="container">
        
            <!-- **Content** -->
            <div class="content">
            	<div class="inner-with-sidebar"></div>
                <div class="post-thumb" style='width:33%'> 
                    <a href="" title=""> <img src="<?php echo base_url()?>upload/images/medium/sekolah_view.jpg"  class="place-left"/></a>
                </div>
                <h1 class="with-subtitle" style='margin : 0 0 0 35%'> <?php echo $sekolah->nama_sekolah?> </h1>
                <h6 class="subtitle" style='margin : 0 0 0px 35%;border-bottom:opx'> 
                                Alamat 
                                : <?php echo $sekolah->alamat_sekolah?> <br />
                                Telepon   
                                : <?php echo $sekolah->telp_yys?> 
                </h6>
                <div class="post-title">
                        <a id="but_gallery" href="javascript:void(null)"  title="" class="button small light-grey" style='float:right;'><b>GALERI</b> </a>
                        <a id="but_profile" href="javascript:void(null)" title="" class="button small light-grey" style='margin:0 2% 0 10px;'> <b>PROFIL SEKOLAH</b> </a>
                        <a id="but_beranda" href="javascript:void(null)"  title="" class="button small light-grey" style='float:left;'> <b>BERANDA</b> </a>
                    </div>
                    <div class="hr" style="margin-top: 10px;"></div>
                    <div class="content content-full-width" style="color: white;background: #CDCDCD;padding-top:40px;padding-bottom: 40px;">
                        <div class="text_iklan">SPACE IKLAN</div>
                        <p>Mengenang Iklan Sepanjang Masa</p>
                    </div>
                    <div class="hr"></div>
                <!-- **Blog Post** -->
                <div class="blog-post" id='beranda'>
                    
                    <div class="post-title" style='margin:10px 0 5px 0'>
                        <h3> BERANDA</h3>
                    </div>
                    
                    <div class="entry-head">
                    </div> 
                    <div class="post-content">
                    	<p><?php echo $sekolah->deskripsi?></p>
                    </div>
                    <div class="hr" style="margin-top: 10px;"></div>
                    <div class="content content-full-width" style="color: white;background: #CDCDCD;padding-top:40px;padding-bottom: 40px;">
                        <div class="text_iklan">SPACE IKLAN</div>
                        <p>Mengenang Iklan Sepanjang Masa</p>
                    </div>
                    <div class="entry-head">
                    </div> 
                    <div class="tabs-container" style='margin-top:15px'>
                        <ul class="tabs-frame">
                            <li><a href="#">Kalender Akademik</a></li>
                            <li><a href="#">Penerimaan Siswa Baru</a></li>
                            <li><a href="#">Kirim Surat ke Sekolah</a></li>
                        </ul>
                        <div class="tabs-frame-content">
                            <p> Tab #1 Content Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse in tellus sed odio eleifend pretium. Morbi lobortis tempor pretium. Donec pharetra lacus ac lorem ultricies ut lacinia libero blandit. Proin accumsan augue a elit venenatis sit amet dapibus eros commodo. <br /> <br /> </p>
                            <ul class="check-list">
                                <li> Lorem ipsum dolor sit amet, consectetur adipiscing elit. </li>
                                <li> Praesent tristique urna vel dolor rutrum sit amet porttitor ligula aliquam. </li>
                                <li> Quisque pellentesque erat in neque eleifend a molestie nulla blandit. </li>
                            </ul>
                            <p>
                                Suspendisse in tellus sed odio eleifend pretium. Morbi lobortis tempor pretium. Donec pharetra lacus ac lorem ultricies ut lacinia libero blandit. Proin accumsan augue a elit venenatis sit amet dapibus eros commodo.
                            </p>
                        </div>
                        <div class="tabs-frame-content">
                            <a id="but_gallery" href="javascript:void(null)"  title="" class="button medium light-grey" style='float:left;'><b>PENGUMUMAN</b> </a>
                            <a id="but_gallery" href="javascript:void(null)"  title="" class="button medium light-grey" style='float:RIGHT;'><b>PENERIMAAN</b> </a>
                        </div>
                        <div class="tabs-frame-content">
                            <p> Tab #3 Content &ndash; Donec sed tellus eget sapien fringilla nonummy. Mauris a ante. Suspendisse quam sem, consequat at, commodo vitae, feugiat in, nunc. Morbi imperdiet augue quis tellus. Lorem ipsum dolor sit amet. Quisque aliquam. Donec faucibus. </p>
                        </div>
                    </div>
                   <div class="hr" style="margin-top: 10px;"></div>
                    <div class="content content-full-width" style="color: white;background: #CDCDCD;padding-top:40px;padding-bottom: 40px;">
                        <div class="text_iklan">SPACE IKLAN</div>
                        <p>Mengenang Iklan Sepanjang Masa</p>
                    </div>
                    <div class="entry-head">
                    </div>
                    <div class="post-title" style='margin:10px 0 5px 0'>
                        <h3> BERITA SEKOLAH</h3>
                    </div>
                    <div class="tabs-container">
                        <ul class="tabs-frame">
                            <li><a href="#">Terkini</a></li>
                            <li><a href="#">Indeks</a></li>
                        </ul>
                        <div class="tabs-frame-content">
                            <p> Tab #1 Content Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse in tellus sed odio eleifend pretium. Morbi lobortis tempor pretium. Donec pharetra lacus ac lorem ultricies ut lacinia libero blandit. Proin accumsan augue a elit venenatis sit amet dapibus eros commodo. <br /> <br /> </p>
                            <ul class="check-list">
                                <li> Lorem ipsum dolor sit amet, consectetur adipiscing elit. </li>
                                <li> Praesent tristique urna vel dolor rutrum sit amet porttitor ligula aliquam. </li>
                                <li> Quisque pellentesque erat in neque eleifend a molestie nulla blandit. </li>
                            </ul>
                            <p>
                                Suspendisse in tellus sed odio eleifend pretium. Morbi lobortis tempor pretium. Donec pharetra lacus ac lorem ultricies ut lacinia libero blandit. Proin accumsan augue a elit venenatis sit amet dapibus eros commodo.
                            </p>
                        </div>
                        <div class="tabs-frame-content">
                            <p> Tab #3 Content &ndash; Donec sed tellus eget sapien fringilla nonummy. Mauris a ante. Suspendisse quam sem, consequat at, commodo vitae, feugiat in, nunc. Morbi imperdiet augue quis tellus. Lorem ipsum dolor sit amet. Quisque aliquam. Donec faucibus. </p>
                        </div>
                    </div>
                    <div class="entry-head">
                    </div> 
                    <div class="post-title" style='margin:10px 0 5px 0'>
                        <h3> KEGIATAN SEKOLAH</h3>
                    </div>
                    <div class="tabs-container">
                        <ul class="tabs-frame">
                            <li><a href="#">Terkini</a></li>
                            <li><a href="#">Indeks</a></li>
                        </ul>
                        <div class="tabs-frame-content">
                            <p> Tab #1 Content Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse in tellus sed odio eleifend pretium. Morbi lobortis tempor pretium. Donec pharetra lacus ac lorem ultricies ut lacinia libero blandit. Proin accumsan augue a elit venenatis sit amet dapibus eros commodo. <br /> <br /> </p>
                            <ul class="check-list">
                                <li> Lorem ipsum dolor sit amet, consectetur adipiscing elit. </li>
                                <li> Praesent tristique urna vel dolor rutrum sit amet porttitor ligula aliquam. </li>
                                <li> Quisque pellentesque erat in neque eleifend a molestie nulla blandit. </li>
                            </ul>
                            <p>
                                Suspendisse in tellus sed odio eleifend pretium. Morbi lobortis tempor pretium. Donec pharetra lacus ac lorem ultricies ut lacinia libero blandit. Proin accumsan augue a elit venenatis sit amet dapibus eros commodo.
                            </p>
                        </div>
                        <div class="tabs-frame-content">
                            <p> Tab #3 Content &ndash; Donec sed tellus eget sapien fringilla nonummy. Mauris a ante. Suspendisse quam sem, consequat at, commodo vitae, feugiat in, nunc. Morbi imperdiet augue quis tellus. Lorem ipsum dolor sit amet. Quisque aliquam. Donec faucibus. </p>
                        </div>
                    </div>
                    <div class="hr" style="margin-top: 10px;"></div>
                    <div class="content content-full-width" style="color: white;background: #CDCDCD;padding-top:40px;padding-bottom: 40px;">
                        <div class="text_iklan">SPACE IKLAN</div>
                        <p>Mengenang Iklan Sepanjang Masa</p>
                    </div>
                    <div class="hr"> </div>
                </div><!-- **Blog Post - End** -->
                




                <!-- **Blog Post** -->
                <div class="blog-post" id="profile" style="display:none">
                    <div class="post-title" style='margin:10px 0 5px 0'>
                        <h3> PROFIL SEKOLAH</h3>
                    </div> 
                    <div class="entry-head">
                    </div>
                    <div class="toggle-frame">
                        <h5 class="toggle"><a href="#">Visi</a></h5>
                        <div class="toggle-content" style="display: none;">
                            <p> Toggle Content 1# Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus lorem nulla, rutrum sed facilisis nec, mattis eget leo. Integer a rutrum risus. Nullam in tortor vitae sapien consequat sagittis at consequat purus. </p>
                        </div>
                    </div>
                    
                    <div class="toggle-frame">
                        <h5 class="toggle"><a href="#">Misi</a></h5>
                        <div class="toggle-content" style="display: none;">
                            <p> Toggle Content 2# Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus lorem nulla, rutrum sed facilisis nec, mattis eget leo. Integer a rutrum risus. Nullam in tortor vitae sapien consequat sagittis at consequat purus. </p>
                        </div>
                    </div>
                    
                    <div class="toggle-frame">
                        <h5 class="toggle"><a href="#">Tujuan</a></h5>
                        <div class="toggle-content" style="display: none;">
                            <p> Toggle Content 3# Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus lorem nulla, rutrum sed facilisis nec, mattis eget leo. Integer a rutrum risus. Nullam in tortor vitae sapien consequat sagittis at consequat purus. </p>
                        </div>
                    </div>
                    <div class="toggle-frame">
                        <h5 class="toggle"><a href="#">Motto</a></h5>
                        <div class="toggle-content" style="display: none;">
                            <p> Toggle Content 1# Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus lorem nulla, rutrum sed facilisis nec, mattis eget leo. Integer a rutrum risus. Nullam in tortor vitae sapien consequat sagittis at consequat purus. </p>
                        </div>
                    </div>
                    
                    <div class="toggle-frame">
                        <h5 class="toggle"><a href="#">Sejarah</a></h5>
                        <div class="toggle-content" style="display: none;">
                            <p> Toggle Content 2# Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus lorem nulla, rutrum sed facilisis nec, mattis eget leo. Integer a rutrum risus. Nullam in tortor vitae sapien consequat sagittis at consequat purus. </p>
                        </div>
                    </div>
                    
                    <div class="toggle-frame">
                        <h5 class="toggle"><a href="#">Kurikulum</a></h5>
                        <div class="toggle-content" style="display: none;">
                            <p> Toggle Content 3# Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus lorem nulla, rutrum sed facilisis nec, mattis eget leo. Integer a rutrum risus. Nullam in tortor vitae sapien consequat sagittis at consequat purus. </p>
                        </div>
                    </div>
                    <div class="toggle-frame">
                        <h5 class="toggle"><a href="#">Metode</a></h5>
                        <div class="toggle-content" style="display: none;">
                            <p> Toggle Content 1# Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus lorem nulla, rutrum sed facilisis nec, mattis eget leo. Integer a rutrum risus. Nullam in tortor vitae sapien consequat sagittis at consequat purus. </p>
                        </div>
                    </div>
                    
                    <div class="toggle-frame">
                        <h5 class="toggle"><a href="#">Target</a></h5>
                        <div class="toggle-content" style="display: none;">
                            <p> Toggle Content 2# Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus lorem nulla, rutrum sed facilisis nec, mattis eget leo. Integer a rutrum risus. Nullam in tortor vitae sapien consequat sagittis at consequat purus. </p>
                        </div>
                    </div>
                    
                    <div class="toggle-frame">
                        <h5 class="toggle"><a href="#">Program</a></h5>
                        <div class="toggle-content" style="display: none;">
                            <p> Toggle Content 3# Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus lorem nulla, rutrum sed facilisis nec, mattis eget leo. Integer a rutrum risus. Nullam in tortor vitae sapien consequat sagittis at consequat purus. </p>
                        </div>
                    </div>
                    <div class="toggle-frame">
                        <h5 class="toggle"><a href="#">Prestasi</a></h5>
                        <div class="toggle-content" style="display: none;">
                            <p> Toggle Content 1# Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus lorem nulla, rutrum sed facilisis nec, mattis eget leo. Integer a rutrum risus. Nullam in tortor vitae sapien consequat sagittis at consequat purus. </p>
                        </div>
                    </div>
                    
                    <div class="toggle-frame">
                        <h5 class="toggle"><a href="#">Ekstrakurikuler</a></h5>
                        <div class="toggle-content" style="display: none;">
                            <p> Toggle Content 2# Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus lorem nulla, rutrum sed facilisis nec, mattis eget leo. Integer a rutrum risus. Nullam in tortor vitae sapien consequat sagittis at consequat purus. </p>
                        </div>
                    </div>
                    
                    <div class="toggle-frame">
                        <h5 class="toggle"><a href="#">Fasilitas</a></h5>
                        <div class="toggle-content" style="display: none;">
                            <p> Toggle Content 3# Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus lorem nulla, rutrum sed facilisis nec, mattis eget leo. Integer a rutrum risus. Nullam in tortor vitae sapien consequat sagittis at consequat purus. </p>
                        </div>
                    </div>
                    <div class="toggle-frame">
                        <h5 class="toggle"><a href="#">Kepala Sekolah</a></h5>
                        <div class="toggle-content" style="display: none;">
                            <p> Toggle Content 1# Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus lorem nulla, rutrum sed facilisis nec, mattis eget leo. Integer a rutrum risus. Nullam in tortor vitae sapien consequat sagittis at consequat purus. </p>
                        </div>
                    </div>
                    
                    <div class="toggle-frame">
                        <h5 class="toggle"><a href="#">Guru</a></h5>
                        <div class="toggle-content" style="display: none;">
                            <p> Toggle Content 2# Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus lorem nulla, rutrum sed facilisis nec, mattis eget leo. Integer a rutrum risus. Nullam in tortor vitae sapien consequat sagittis at consequat purus. </p>
                        </div>
                    </div>
                    
                    <div class="toggle-frame">
                        <h5 class="toggle"><a href="#">Karyawan</a></h5>
                        <div class="toggle-content" style="display: none;">
                            <p> Toggle Content 3# Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus lorem nulla, rutrum sed facilisis nec, mattis eget leo. Integer a rutrum risus. Nullam in tortor vitae sapien consequat sagittis at consequat purus. </p>
                        </div>
                    </div>
                    <div class="toggle-frame">
                        <h5 class="toggle"><a href="#">Komite Sekolah</a></h5>
                        <div class="toggle-content" style="display: none;">
                            <p> Toggle Content 1# Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus lorem nulla, rutrum sed facilisis nec, mattis eget leo. Integer a rutrum risus. Nullam in tortor vitae sapien consequat sagittis at consequat purus. </p>
                        </div>
                    </div>
                    
                    <div class="toggle-frame">
                        <h5 class="toggle"><a href="#">Lain - lain</a></h5>
                        <div class="toggle-content" style="display: none;">
                            <p> Toggle Content 2# Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus lorem nulla, rutrum sed facilisis nec, mattis eget leo. Integer a rutrum risus. Nullam in tortor vitae sapien consequat sagittis at consequat purus. </p>
                        </div>
                    </div>
                    <div class="hr" style="margin-top: 10px;"></div>
                    <div class="content content-full-width" style="color: white;background: #CDCDCD;padding-top:40px;padding-bottom: 40px;">
                        <div class="text_iklan">SPACE IKLAN</div>
                        <p>Mengenang Iklan Sepanjang Masa</p>
                    </div>
                    
                <div class="hr"> </div>
                </div><!-- **Blog Post - End** -->
                





                <!-- **Blog Post** -->
                <div class="blog-spot" id="gallery" style="display:none">
                    <div class="post-title" style='margin:10px 0 5px 0'>
                        <h3> GALERI FOTO</h3>
                    </div>
                    <!-- **Portfolio** -->
                    <!-- <div class="portfolio column-one-third-with-sidebar">
                        <!-- **Portfolio Container** -->
                        <!-- <div class="gallery">
                            <div class="one-third design-sort">
                                <div class="thumb"> 
                                    <a href="portfolio-single.html" title=""> <img src="<?php echo base_url()?>asset/default/images/post-images/portfolio-three-column1.jpg" alt="" title="" width="201" height="126" /> </a> 
                                    <div class="image-overlay"> 
                                        <a href="images/post-images/portfolio-full-image.jpg" rel="prettyPhoto[gallery]" class="image-overlay-zoom">  </a> 
                                        <a href="http://iamdesigning.com" target="_blank" class="image-overlay-link">  </a> 
                                    </div> 
                                </div>
                                <h5> <a href="portfolio-single.html" title=""> Lorem ipsum dolor sit amet </a> </h5>
                               
                            </div> 
                            <div class="one-third design-sort">
                                <div class="thumb"> 
                                    <a href="portfolio-single.html" title=""> <img src="<?php echo base_url()?>asset/default/images/post-images/portfolio-three-column1.jpg" alt="" title="" width="201" height="126" /> </a> 
                                    <div class="image-overlay"> 
                                        <a href="images/post-images/portfolio-full-image.jpg" rel="prettyPhoto[gallery]" class="image-overlay-zoom">  </a> 
                                        <a href="http://iamdesigning.com" target="_blank" class="image-overlay-link">  </a> 
                                    </div> 
                                </div>
                                <h5> <a href="portfolio-single.html" title=""> Lorem ipsum dolor sit amet </a> </h5>
                               
                            </div> 
                            <div class="one-third design-sort">
                                <div class="thumb"> 
                                    <a href="portfolio-single.html" title=""> <img src="<?php echo base_url()?>asset/default/images/post-images/portfolio-three-column1.jpg" alt="" title="" width="201" height="126" /> </a> 
                                    <div class="image-overlay"> 
                                        <a href="images/post-images/portfolio-full-image.jpg" rel="prettyPhoto[gallery]" class="image-overlay-zoom">  </a> 
                                        <a href="http://iamdesigning.com" target="_blank" class="image-overlay-link">  </a> 
                                    </div> 
                                </div>
                                <h5> <a href="portfolio-single.html" title=""> Lorem ipsum dolor sit amet </a> </h5>
                               
                            </div> 
                        </div>
                    </div> --> 
                    <div class="hr" style="margin-top: 10px;"></div>
                    <div class="content content-full-width" style="color: white;background: #CDCDCD;padding-top:40px;padding-bottom: 40px;">
                        <div class="text_iklan">SPACE IKLAN</div>
                        <p>Mengenang Iklan Sepanjang Masa</p>
                    </div>

                <div class="hr"> </div> 
                </div>
                 <!-- **Blog Post - End** -->
                
            </div> <!-- **Content - End** -->   	
            
            <!-- **Sidebar** -->
            <div class="sidebar">
            	<div class="inner-sidebar"> </div>
                
                <div class="widget widget_recent_entries">
                	<h2 class="widgettitle"> Latest Posts </h2>
                	<ul>
                    	<li> 
                        	<a href="blog-single.html" title="" class="thumb"> <img src="<?php echo base_url()?>asset/default/images/post-images/recent-post1.jpg" alt="" title="" /> </a>
                            <h6> <a href="blog-single.html" title=""> Lorem ipsum dolor </a> </h6>
                            <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit... </p>
                        </li>
                        <li> 
                        	<a href="blog-single.html" title="" class="thumb"> <img src="<?php echo base_url()?>asset/default/images/post-images/recent-post2.jpg" alt="" title="" /> </a>
                            <h6> <a href="blog-single.html" title=""> Lorem ipsum dolor </a> </h6>
                            <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit... </p>
                        </li>
                        <li> 
                        	<a href="blog-single.html" title="" class="thumb"> <img src="<?php echo base_url()?>asset/default/images/post-images/recent-post3.jpg" alt="" title="" /> </a>
                            <h6> <a href="blog-single.html" title=""> Lorem ipsum dolor </a> </h6>
                            <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit... </p>
                        </li>
                    </ul>
                </div>
                
                <div class="hr"> </div>
                
                <div class="widget widget_popular_entries">
                	<h2 class="widgettitle"> Popular Posts </h2>
                	<ul>
                    	<li> 
                        	<a href="blog-single.html" title="" class="thumb"> <img src="<?php echo base_url()?>asset/default/images/post-images/popular-post1.jpg" alt="" title="" /> </a>
                            <h6> <a href="blog-single.html" title=""> Lorem ipsum dolor </a> </h6>
                            <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit... </p>
                        </li>
                        <li> 
                        	<a href="blog-single.html" title="" class="thumb"> <img src="<?php echo base_url()?>asset/default/images/post-images/popular-post2.jpg" alt="" title="" /> </a>
                            <h6> <a href="blog-single.html" title=""> Lorem ipsum dolor </a> </h6>
                            <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit... </p>
                        </li>
                    </ul>
                </div>
                
                <div class="hr"> </div>       
                
                <div class="widget widget_categories">
                	<h2 class="widgettitle"> Categories </h2>
                	<ul>                    	
                        <li> <a href="" title=""> Lorem ipsum dolor sit amet </a>                         
                            <ul>                    	
                                <li> <a href="" title=""> Lorem ipsum dolor sit amet </a> </li>
                                <li> <a href="" title=""> Donec tincidunt risus quis nisi </a> </li>
                            </ul> 
                        </li>
                        <li> <a href="" title=""> Donec tincidunt risus quis nisi </a> </li>
                        <li> <a href="" title=""> Aenean lacinia porta leo, sit </a> </li>
                        <li> <a href="" title=""> Donec placerat porttitor erat, </a> </li>
                    </ul>                	
                </div>      
                
                <div class="hr"> </div>       
                
                <div class="widget widget_text">
                	<h2 class="widgettitle"> Sample Text Widget </h2>
                    <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam id massa vitae libero ultricies consequat. Sed pharetra tincidunt lorem, at laoreet arcu congue vitae.  </p>
                </div>                     
                
            </div><!-- **Sidebar - End** -->   
            
        </div><!-- **Container - End** -->
    </div><!-- **Main - End**-->

<?=$this->load->view('layout/ad_footer')?>