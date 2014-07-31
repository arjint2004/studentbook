<?php
    if(isset($error))
        echo $error['error'];
?>
<div class="row-fluid">
    <div class="span12 tooltip" style="width: 101%;">
        <a href="#" class="tooltip-top" id="pertemanan2">DAFTAR SEKOLAH</a>
    </div>
    <div class="hr"></div>
    <?=form_open_multipart(site_url('daftar/sekolah'))?>
        Nama sekolah : <input type="text" name="nama"/>
        Alamat : <input type="text" name="alamat"/>
        Telp : <input type="text" name="telp"/>
        Email : <input type="text" name="email"/>
        Website : <input type="text" name="website"/>
        Deskripsi : <input type="text" name="deskripsi"/>
        logo : <input type="file" name="logo"/>
        <input type="submit" value="Daftar" name="daftar">
    <?=form_close()?>
</div>
</div>

<!-- **Sidebar** -->
<div class="sidebar">
<div class="inner-sidebar"></div>
<div class="row-fluid" id="logout">
    <div class="span8" style="padding: 5px;font-weight: bolder;">Jefri Sugiarto
        <br>Logout</div>
    <div class="span4" style="padding: 5px;background: white;">
        <a href="#">
            <img src="<?=$this->config->item('images').'/layer-gallery/l36.png'?>"
            width="50px" height="50px">
        </a>
    </div>
</div>
<div class="hr"></div>
<div class="widget widget_recent_entries">
        <h2 class="widgettitle"> SPONSOR </h2>

    <ul>
        <li>
            <a href="blog-single.html" title="" class="thumb">
                <img src="<?=$this->config->item('images').'/post-images/recent-post1.jpg';?>"
                alt="" title="" />
            </a>
                <h6><a href="#" title=""> Lorem ipsum dolor </a> </h6>

            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit...</p>
        </li>
        <li>
            <a href="blog-single.html" title="" class="thumb">
                <img src="<?=$this->config->item('images').'/post-images/recent-post2.jpg'?>"
                alt="" title="" />
            </a>
             <h6> <a href="#" title=""> Lorem ipsum dolor </a> </h6>

            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit...</p>
        </li>
        <li>
            <a href="blog-single.html" title="" class="thumb">
                <img src="<?=$this->config->item('images').'/post-images/recent-post3.jpg';?>"
                alt="" title="" />
            </a>
             <h6> <a href="#" title=""> Lorem ipsum dolor </a> </h6>

            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit...</p>
        </li>
    </ul>
</div>
<div class="hr"></div>
<div class="widget widget_popular_entries">
        <h2 class="widgettitle"> BERITA STUDENTBOOK </h2>

    <ul>
        <li>
            <a href="blog-single.html" title="" class="thumb">
                <img src="<?=$this->config->item('images').'/post-images/popular-post1.jpg';?>"
                alt="" title="" />
            </a>
             <h6> <a href="#" title=""> Lorem ipsum dolor </a> </h6>

            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit...</p>
        </li>
        <li>
            <a href="blog-single.html" title="" class="thumb">
                <img src="<?=$this->config->item('images').'/post-images/popular-post2.jpg';?>"
                alt="" title="" />
            </a>
             <h6> <a href="#" title=""> Lorem ipsum dolor </a> </h6>

            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit...</p>
                        </li>
                    </ul>
                </div>
                <div class="hr"></div>