<script>
	$(document).ready(function(){
		$.ajax({
			type: "GET",
			data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&',
			url: '<?=base_url()?>akademik/comment/index/<?=$id?>/first/berita',
			beforeSend: function() {
				//$("#filterpelajaranpr select#kelas").after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
											
			},
			success: function(msg) {
				//$("#wait").remove();
				$('#komentar<?=$id?>').html(msg);	
			}
		});
		return false;							
	});

</script>
<div class="inner-with-sidebar"></div>
            
                <h1 class="with-subtitle"> berita </h1>
                <h6 class="subtitle">  berita Sebagai sumber informasi dan pengetahuan </h6>
                <? //pr($berita);?>
                <!-- **Blog Post** -->
                <div class="blog-post">
                
                    <div class="post-title">
                        <h3> <a href="blog-single.html" title=""> <?=$berita[0]['judul']?> </a> </h3>
                        <div class="date">
                            <? $tgx=explode("-",substr($berita[0]['tgl_berita'],0,10));?>
							<p> <? echo $tgx[2];?> </p>
                            <span> <? echo date("M", mktime(0, 0, 0, $tgx[1], $tgx[2], $tgx[0]));?> <br /> <? echo $tgx[0];?> </span>
                        </div>
                    </div>
                    
                    <div class="entry-head">
                        <span class="author"> Posted By : <?=$berita[0]['username']?> ( <?=$berita[0]['nama_sekolah']?> )</span>
                        <a href="#" onclick="$('.containcomment').scrollintoview({ speed:'1100'});" class="comments"> <?=$countcommand[0]['cnt']?> comments </a>
                    </div>  
                    
                    <div class="post-thumb"> 
                    	<a href="" title=""> <img src="<?=base_url()?>view.php?image=upload/images/larger/<?=$berita[0]['foto']?>&amp;mode=crop&amp;size=656x259" alt="" title="" width="656" height="259" /> </a>
                    </div>
                    
                    <div class="post-details">
                        <!-- <div class="categories"> Categories : <a href="#" title=""> <?//=$berita[0]['nama_kategori']?> </a></div>
                       <div class="tags"> 
                        	<div class="float-right"> Tags : <a href="" title=""> Web, </a>  <a href="" title=""> Design </a> </div> 
                        </div>-->
                    </div>
                    
                    <div class="post-content">
                    	<?=$berita[0]['berita']?>
                        
                    </div>
                     
                </div><!-- **Blog Post - End** -->
                
                <div class="hr"> </div>
                
                
                <div id="komentar<?=$id?>"></div>