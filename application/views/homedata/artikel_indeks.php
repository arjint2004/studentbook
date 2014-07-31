<?=$this->load->view('layout/ad_header')?>
     <!-- ** Main** -->
    <div id="main">
    
        <!-- **Container** -->
        <div class="container">
        
            <!-- **Content** -->
            <div class="content">
                <div class="inner-with-sidebar"></div>
            
                <h1 class="with-subtitle"> INDEKS ARTIKEL PENGETAHUAN </h1>
                <div class="hr"> </div>
                <!-- <h6 class="subtitle">  Blog subtitle </h6> -->
                <?php 
                    foreach ($artikel as $rows) {
                ?>
                <!-- **Blog Post** -->
                <div class="blog-post">
                
                    <div class="post-title">
                        <h3> <a href="<?php echo base_url()?>artikel/view/<?php echo $rows->id_artikel?>" title=""> <?php echo $rows->judul?> </a> </h3>
                        <!-- <div class="date">
                            <p> 28 </p>
                            <span> Nov <br /> 2012 </span>
                        </div> -->
                    </div>
                    
                    <!-- <div class="entry-head">
                        <span class="author"> Posted By : Lorem Ipsum </span>
                        <a href="blog-single.html" class="comments"> 15 comments </a>
                    </div>  
                    
                    <div class="post-thumb"> 
                        <a href="blog-single.html" title=""> <img src="images/post-images/blog1.jpg" alt="" title="" width="656" height="259" /> </a>
                    </div> -->
                    
                    <div class="post-details">
                        <div class="categories"> Categories : <a href="" title=""> <?php echo $rows->nama_kategori?></a> </div>
                        <!-- <div class="tags"> 
                            <div class="float-right"> Tags : <a href="" title=""> Web, </a>  <a href="" title=""> Design </a> </div> 
                        </div> -->
                    </div>
                    
                    <div class="post-content">
                        <p> <?php echo $rows->tagline?> </p>
                        
                        <a href="<?php echo base_url()?>artikel/view/<?php echo $rows->id_artikel?>" title="" class="readmore"> <span> Read More </span></a>
                    </div>
                     
                </div><!-- **Blog Post - End** -->
                
                <div class="hr"> </div>
                <?php } ?>

                
                <!-- **Pagination** -->
                <div class="pagination">
                    <a href="" class="prev-post" title=""> </a>
                    <ul>
                        <li class="active-page"> 1 </li>
                        <li> <a href="" title=""> 2 </a> </li>
                        <li> <a href="" title=""> 3 </a> </li>
                        <li> <a href="" title=""> 4 </a> </li>
                    </ul>   
                    <a href="" class="next-post" title=""> </a>                     
                </div><!-- **Pagination - End** -->
                
                
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