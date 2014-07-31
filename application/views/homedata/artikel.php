<?=$this->load->view('layout/ad_header')?>
    <!-- ** Main** -->
    <div id="main">
    
        <!-- **Container** -->
        <div class="container">
        
            <!-- **Content** -->
            <div class="content">
                <div class="inner-with-sidebar"></div>
                <div class="content content-full-width" style="color: white;background: #CDCDCD;padding-top:40px;padding-bottom: 40px;">
                    <div class="text_iklan">SPACE IKLAN</div>
                    <p>Mengenang Iklan Sepanjang Masa</p>
                </div>
                <div class="hr"></div>
                <h1 class="with-subtitle"> SERIAL ARTIKEL PENGETAHUAN </h1>
                <!-- <h6 class="subtitle">  Blog subtitle </h6> -->
                
                <!-- **Blog Post** -->
                <div class="blog-post">
                    <!-- <div class="entry-head">
                        <span class="author"> Posted By : Lorem Ipsum </span>
                        <a href="" class="comments"> 15 comments </a>
                    </div> -->  
                    
                    <div class="post-thumb"> 
                        <a href="" title=""> <img src="<?php echo base_url()?>asset/default/images/post-images/blog1.jpg" alt="" title="" width="656" height="259" /> </a>
                    </div>

                    <div class="post-title">
                        <h3> <a href="blog-single.html" title=""> <?php echo $artikel->judul?> </a> </h3>
                        <!-- <div class="date">
                            <p> 28 </p>
                            <span> Nov <br /> 2012 </span>
                        </div> -->
                    </div>
                    
                    <div class="post-details">
                        <div class="categories"> Categories : <a href="" title=""> <?php echo $artikel->nama_kategori?> </a>  </div>
                        <!-- <div class="tags"> 
                            <div class="float-right"> Tags : <a href="" title=""> Web, </a>  <a href="" title=""> Design </a> </div> 
                        </div> -->
                    </div>
                    
                    <div class="post-content">
                        <p class='text'><i><?php echo $artikel->tagline?></i></p>
                        <?php echo $artikel->content?>
                    </div>
                     

                <div class="hr"></div>
                <div class="content content-full-width" style="color: white;background: #CDCDCD;padding-top:40px;padding-bottom: 40px;">
                    <div class="text_iklan">SPACE IKLAN</div>
                    <p>Mengenang Iklan Sepanjang Masa</p>
                </div>
                <div class="hr"> </div>
                <div class="post-details">
                    <div class="categories"><b>Artikel Terkait</b></div>
                    <div class="tags"> 
                        <div class="float-right"> <a href="<?php echo base_url()?>artikel/indeks">Indeks Semua Artikel</a></div> 
                    </div>
                    
                </div><div class="post-content">
                    <?php 
                        foreach ($art_kat as $rows) { 
                            if($rows->id_artikel != $artikel->id_artikel){
                    ?>
                        <a href="<?php base_url()?>artikel/view/<?php echo $rows->id_artikel?>"><?php echo $rows->judul?></a><br /><br />
                    <?php }} ?>
                </div>
                <div class="hr"></div>
                <div class="content content-full-width" style="color: white;background: #CDCDCD;padding-top:40px;padding-bottom: 40px;">
                    <div class="text_iklan">SPACE IKLAN</div>
                    <p>Mengenang Iklan Sepanjang Masa</p>
                </div>
                </div><!-- **Blog Post - End** -->
                <div class="hr"> </div>
                <!-- **Comment Entries** -->    
                <!-- <div class="commententries"> 
                    <h4> 3 Responses to <span> "<?php echo $artikel->judul?>" </span> </h4>
                    
                    <ul class="commentlist">
                        <li> 
                            <div class="comment-author">
                                <img src="<?php echo base_url()?>asset/default/images/avatar.jpg" alt="" title="" />
                                <a href="" title=""> Master </a>
                            </div>
                            <div class="comment-body">
                                <p> Morbi eu libero justo. Nulla eros dui, eleifend vitae elementum sed, scelerisque eu neque. Cras ac ullamcorper arcu. Proin nisl urna, pellentesque et lobortis id, ornare sit amet magna. Morbi auctor placerat pulvinar. Aenean at diam eget libero faucibus vestibulum. </p>
                            </div>
                            <div class="comment-meta">
                                <div class="commentmetadata"> <a href="" title=""> Wed Feb 02, 2011 at 12 pm </a>  </div>
                                <div class="reply"> <a href="" title=""> [Reply] </a> </div>
                            </div>
                            
                            
                            <ul class="children">
                                <li> 
                                    <div class="comment-author">
                                <img src="<?php echo base_url()?>asset/default/images/avatar.jpg" alt="" title="" />
                                        <a href="" title=""> Master </a>
                                    </div>
                                    <div class="comment-body">
                                        <p> Morbi eu libero justo. </p>
                                    </div>
                                    <div class="comment-meta">
                                        <div class="commentmetadata"> <a href="" title=""> Wed Feb 02, 2011 at 12 pm </a>  </div>
                                        <div class="reply"> <a href="" title=""> [Reply] </a> </div>
                                    </div>
                                    
                                    <ul class="children">
                                        <li> 
                                            <div class="comment-author">
                                                <img src="<?php echo base_url()?>asset/default/images/avatar.jpg" alt="" title="" />
                                                <a href="" title=""> Master </a>
                                            </div>
                                            <div class="comment-body">
                                                <p> Morbi eu libero justo. </p>
                                            </div>
                                            <div class="comment-meta">
                                                <div class="commentmetadata"> <a href="" title=""> Wed Feb 02, 2011 at 12 pm </a>  </div>
                                                <div class="reply"> <a href="" title=""> [Reply] </a> </div>
                                            </div>
                                        </li> 
                                        
                                        <li> 
                                            <div class="comment-author">
                                                <img src="<?php echo base_url()?>asset/default/images/avatar.jpg" alt="" title="" />
                                                <a href="" title=""> Master </a>
                                            </div>
                                            <div class="comment-body">
                                                <p> Morbi eu libero justo. Nulla eros dui, eleifend vitae elementum sed, scelerisque eu neque. Cras ac ullamcorper arcu. </p>
                                            </div>
                                            <div class="comment-meta">
                                                <div class="commentmetadata"> <a href="" title=""> Wed Feb 02, 2011 at 12 pm </a>  </div>
                                                <div class="reply"> <a href="" title=""> [Reply] </a> </div>
                                            </div>
                                        </li>
                                        
                                    </ul>
                                    
                                </li> 
                                
                                <li> 
                                    <div class="comment-author">
                                    <img src="<?php echo base_url()?>asset/default/images/avatar.jpg" alt="" title="" />
                                        <a href="" title=""> Master </a>
                                    </div>
                                    <div class="comment-body">
                                        <p> Morbi eu libero justo. Nulla eros dui, eleifend vitae elementum sed, scelerisque eu neque. Cras ac ullamcorper arcu. </p>
                                    </div>
                                    <div class="comment-meta">
                                        <div class="commentmetadata"> <a href="" title=""> Wed Feb 02, 2011 at 12 pm </a>  </div>
                                        <div class="reply"> <a href="" title=""> [Reply] </a> </div>
                                    </div>
                                </li>
                            </ul>
                            
                        </li> 
                        
                        <li> 
                            <div class="comment-author">
                                <img src="<?php echo base_url()?>asset/default/images/avatar.jpg" alt="" title="" />
                                <a href="" title=""> Master </a>
                            </div>
                            <div class="comment-body">
                                <p> Morbi eu libero justo. Nulla eros dui, eleifend vitae elementum sed, scelerisque eu neque. Cras ac ullamcorper arcu. Proin nisl urna, pellentesque et lobortis id, ornare sit amet magna. Morbi auctor placerat pulvinar. Aenean at diam eget libero faucibus vestibulum. </p>
                            </div>
                            <div class="comment-meta">
                                <div class="commentmetadata"> <a href="" title=""> Wed Feb 02, 2011 at 12 pm </a>  </div>
                                <div class="reply"> <a href="" title=""> [Reply] </a> </div>
                            </div>
                        </li>
                    </ul>
                
                </div> --><!-- **Comment Entries - End** -->  
                      
                <!-- **Respond Form** -->                      
                <div class="respond"> 
                    <h3> Tinggalkan komentar Anda tentang artikel ini </h3>
                    
                    <form action="#" method="get">
                        <p>
                            <input name="name" type="text" class="textbox" />
                            <label> Your Name <span> * </span> </label>
                        </p>
                        
                        <p>
                            <input name="name" type="text" class="textbox" />
                            <label> Email <span> * </span> </label>
                        </p>
                        
                        <!-- <p>
                            <input name="name" type="text" class="textbox" />
                            <label> Website </label>
                        </p> -->
                        
                        <p>
                            <textarea name="comment" cols="" rows=""></textarea>
                        </p>
                        
                        <p>
                            <input name="submit" type="button" value="Submit Comment" class="button small grey" />
                        </p>
                    
                    </form>
                </div><!-- **Respond Form - End** -->  
                <div class="hr"></div>
                <div class="content content-full-width" style="color: white;background: #CDCDCD;padding-top:40px;padding-bottom: 40px;">
                    <div class="text_iklan">SPACE IKLAN</div>
                    <p>Mengenang Iklan Sepanjang Masa</p>
                </div>
                <div class="hr"> </div>
                </div>   

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