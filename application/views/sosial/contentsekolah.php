			<?=$this->load->view('layout/sekolahhead')?>
			<div class="inner-with-sidebar"></div>
            
                <h1 class="with-subtitle"> <?=$content[0]['title']?> </h1>
                <?// pr($this->session->userdata['user_authentication']);?>
                <!-- **Blog Post** -->
                <div class="blog-post">
                    <div class="post-details">
                        
                    </div>
                    
                    <div class="post-content">
                    	<?=$content[0]['content']?>
                        
                    </div>
                     
                </div><!-- **Blog Post - End** -->
                
                <div class="hr"> </div>
                
                
                <div id="komentar<?=$id?>"></div>