<?=$this->load->view('layout/ad_header')?>
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
            <div class="image"><img style="min-width: 130px;max-height:150px;" src="<?=(!empty($data->foto_profil) ? site_url($data->foto_profil) : site_url('asset/default/images/post-images/team-image1.jpg'))?>" alt="" title=""> </div>
            <h5><?=$data->nama_sekolah?></h5>
            <h6 class="role"> <?=$data->kota?> </h6>
            <dl style="padding:0px;" class="float-left">
                <dt class="left">Alamat</dt><dd>: <?=$data->alamat_sekolah?></dd>
                <dt class="left">Telepon</dt><dd>: <?=$data->telepon?></dd>
                <dt class="left">Akreditasi</dt><dd>: <?=$data->terakreditasi?></dd>
                <dt class="left">Kota</dt><dd>: <?=$data->kota?></dd>
            </dl>
            
            <!-- **Share Links** -->                   
            <div class="share-links"> 
                <div class="column one-half"> 
                    Email: <a href="" title=""> <?=$data->email_pendaftar?> </a> 
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
        <h2> PROFIL SEKOLAH</h2>
        <div class="toggle-frame-set" style="margin: 0px;">
            <div class="toggle-frame">
                <h5 class="toggle-accordion"><a href="#">Visi</a></h5>
                <div class="toggle-content" style="display: block;">
                    <p>
                    <?php
                        if(!empty($content)) {
                            foreach($content as $ct) {
                                if(preg_match('/visi/',strtolower($ct->title))) {
                                    echo $ct->content;   
                                }else{
                                    echo 'Belum Ada Data Visi';
                                    break;
                                }
                            }
                        }else{
                            echo 'Data Tidak Ditemukan';
                        }
                    ?>
                    </p>
                </div>
            </div>
            
            <div class="toggle-frame">
                <h5 class="toggle-accordion"><a href="#">Misi</a></h5>
                <div class="toggle-content" style="display: none;">
                    <p>
                        <?php
                            if(!empty($content)) {
                                foreach($content as $ct) {
                                    if(preg_match('/misi/',strtolower($ct->title))) {
                                        echo $ct->content;   
                                    }else{
                                        echo 'Belum Ada Data Misi';
                                        break;
                                    }
                                }
                            }else{
                                echo 'Data Tidak Ditemukan';
                            }
                        ?>
                    </p>
                </div>
            </div>
            
            <div class="toggle-frame">
                <h5 class="toggle-accordion"><a href="#">Tujuan</a></h5>
                <div class="toggle-content" style="display: none;">
                    <p>
                        <?php
                        if(!empty($content)) {
                            foreach($content as $ct) {
                                if(preg_match('/tujuan/',strtolower($ct->title))) {
                                    echo $ct->content;   
                                }else{
                                    echo 'Belum Ada Data Tujuan';
                                    break;
                                }
                            }
                        }else{
                            echo 'Data Tidak Ditemukan';
                        }
                    ?>
                    </p>
                </div>
            </div>
            <div class="toggle-frame">
                <h5 class="toggle-accordion"><a href="#">Moto</a></h5>
                <div class="toggle-content" style="display: none;">
                    <p>
                        <?php
                            if(!empty($content)) {
                                foreach($content as $ct) {
                                    if(preg_match('/moto/',strtolower($ct->title))) {
                                        echo $ct->content;   
                                    }else{
                                        echo 'Belum Ada Data Moto';
                                        break;
                                    }
                                }
                            }else{
                                echo 'Data Tidak Ditemukan';
                            }
                        ?>
                    </p>
                </div>
            </div>
            <div class="toggle-frame">
                <h5 class="toggle-accordion"><a href="#">Sejarah</a></h5>
                <div class="toggle-content" style="display: none;">
                    <p>
                        <?php
                        if(!empty($content)) {
                            foreach($content as $ct) {
                                if(preg_match('/sejarah/',strtolower($ct->title))) {
                                    echo $ct->content;   
                                }else{
                                    echo 'Belum Ada Data Sejarah';
                                    break;
                                }
                            }
                        }else{
                            echo 'Data Tidak Ditemukan';
                        }
                    ?>
                    </p>
                </div>
            </div>
            <div class="toggle-frame">
                <h5 class="toggle-accordion"><a href="#">Kurikulum</a></h5>
                <div class="toggle-content" style="display: none;">
                    <p>
                        <?php
                            if(!empty($content)) {
                                foreach($content as $ct) {
                                    if(preg_match('/kurikulum/',strtolower($ct->title))) {
                                        echo $ct->content;   
                                    }else{
                                        echo 'Belum Ada data kurikulum';
                                        break;
                                    }
                                }
                            }else{
                                echo 'Data Tidak Ditemukan';
                            }
                        ?>
                    </p>
                </div>
            </div>
            <div class="toggle-frame">
                <h5 class="toggle-accordion"><a href="#">Metode</a></h5>
                <div class="toggle-content" style="display: none;">
                    <p>
                    <?php
                        if(!empty($content)) {
                            foreach($content as $ct) {
                                if(preg_match('/metode/',strtolower($ct->title))) {
                                    echo $ct->content;   
                                }else{
                                    echo 'Belum Ada Data Metode';
                                    break;
                                }
                            }
                        }else{
                            echo 'Data Tidak Ditemukan';
                        }
                    ?>
                    </p>
                </div>
            </div>
            <div class="toggle-frame">
                <h5 class="toggle-accordion"><a href="#">Target</a></h5>
                <div class="toggle-content" style="display: none;">
                    <p>
                    <?php
                        if(!empty($content)) {
                            foreach($content as $ct) {
                                if(preg_match('/target/',strtolower($ct->title))) {
                                    echo $ct->content;   
                                }else{
                                    echo 'Belum Ada Data Target';
                                    break;
                                }
                            }
                        }else{
                            echo 'Data Tidak Ditemukan';
                        }
                    ?>    
                    </p>
                </div>
            </div>
            <div class="toggle-frame">
                <h5 class="toggle-accordion"><a href="#">Program</a></h5>
                <div class="toggle-content" style="display: none;">
                    <p>
                        <?php
                            if(!empty($content)) {
                                foreach($content as $ct) {
                                    if(preg_match('/program/',strtolower($ct->title))) {
                                        echo $ct->content;   
                                    }else{
                                        echo 'Belum Ada Data Program';
                                        break;
                                    }
                                }
                            }else{
                                echo 'Data Tidak Ditemukan';
                            }
                        ?>
                    </p>
                </div>
            </div>
            <div class="toggle-frame">
                <h5 class="toggle-accordion"><a href="#">Prestasi</a></h5>
                <div class="toggle-content" style="display: none;">
                    <p>
                        <?php
                            if(!empty($content)) {
                                foreach($content as $ct) {
                                    if(preg_match('/prestasi/',strtolower($ct->title))) {
                                        echo $ct->content;   
                                    }else{
                                        echo 'Belum Ada Prestasi';
                                        break;
                                    }
                                }
                            }else{
                                echo 'Data Tidak Ditemukan';
                            }
                        ?>
                    </p>
                </div>
            </div>
            <div class="toggle-frame">
                <h5 class="toggle-accordion"><a href="#">Kegiatan Ekstrakurikuler</a></h5>
                <div class="toggle-content" style="display: none;">
                    <?php
                        if(!empty($content)) {
                            foreach($content as $ct) {
                                if(preg_match('/ekstrakurikuler/',strtolower($ct->title))) {
                                    echo $ct->content;   
                                }else{
                                    echo 'Belum Ada Kegiatan Ekstrakurikuler';
                                    break;
                                }
                            }
                        }else{
                            echo 'Data Tidak Ditemukan';
                        }
                    ?>
                </div>
            </div>
            <div class="toggle-frame">
                <h5 class="toggle-accordion"><a href="#">Fasilitas</a></h5>
                <div class="toggle-content" style="display: none;">
                    <p>
                        <?php
                        if(!empty($content)) {
                            foreach($content as $ct) {
                                if(preg_match('/fasilitas/',strtolower($ct->title))) {
                                    echo $ct->content;   
                                }else{
                                    echo 'Belum Ada Data Fasilitas';
                                    break;
                                }
                            }
                        }else{
                            echo 'Data Tidak Ditemukan';
                        }
                    ?>
                    </p>
                </div>
            </div>
            <div class="toggle-frame">
                <h5 class="toggle-accordion"><a href="#">Kepala Sekolah</a></h5>
                <div class="toggle-content" style="display: none;">
                    <p> Accordion Content 3# Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus lorem nulla, rutrum sed facilisis nec, mattis eget leo. Integer a rutrum risus. Nullam in tortor vitae sapien consequat sagittis at consequat purus. </p>
                </div>
            </div>
            <div class="toggle-frame">
                <h5 class="toggle-accordion"><a href="#">Guru</a></h5>
                <div class="toggle-content" style="display: none;">
                    <p> Accordion Content 3# Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus lorem nulla, rutrum sed facilisis nec, mattis eget leo. Integer a rutrum risus. Nullam in tortor vitae sapien consequat sagittis at consequat purus. </p>
                </div>
            </div>
            <div class="toggle-frame">
                <h5 class="toggle-accordion"><a href="#">Karyawan</a></h5>
                <div class="toggle-content" style="display: none;">
                    <p> Accordion Content 3# Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus lorem nulla, rutrum sed facilisis nec, mattis eget leo. Integer a rutrum risus. Nullam in tortor vitae sapien consequat sagittis at consequat purus. </p>
                </div>
            </div>
            <div class="toggle-frame">
                <h5 class="toggle-accordion"><a href="#">Komite Sekolah</a></h5>
                <div class="toggle-content" style="display: none;">
                    <p> Accordion Content 3# Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus lorem nulla, rutrum sed facilisis nec, mattis eget leo. Integer a rutrum risus. Nullam in tortor vitae sapien consequat sagittis at consequat purus. </p>
                </div>
            </div>
            <div class="toggle-frame">
                <h5 class="toggle-accordion"><a href="#">Lain-lain</a></h5>
                <div class="toggle-content" style="display: none;">
                    <p> Accordion Content 3# Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus lorem nulla, rutrum sed facilisis nec, mattis eget leo. Integer a rutrum risus. Nullam in tortor vitae sapien consequat sagittis at consequat purus. </p>
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