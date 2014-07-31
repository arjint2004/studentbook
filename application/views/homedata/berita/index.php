<div class="inner-with-sidebar"></div>
            
                <h1 class="with-subtitle"> Berita </h1>
                <h6 class="subtitle">  Blog subtitle </h6>
				
                <? foreach($data as $datab){//pr($datab);?>
                <!-- **Blog Post** -->
                <div class="blog-post">
                
                    <div class="post-title">
                        <h3> <a href="blog-single.html" title=""> <?=$datab['judul']?> </a> </h3>
                        <div class="date">
                            <? $tgx1=explode(" ",$datab['tgl_berita']);?>
                            <? $tgx=explode("-",$tgx1[0]);?>
							<p> <? echo $tgx[2];?> </p>
                            <span> <? echo date("M", mktime(0, 0, 0, $tgx[1], $tgx[2], $tgx[0]));?> <br /> <? echo $tgx[0];?> </span>
                        </div>
                    </div>
                    
                    <div class="entry-head">
                        <span class="author"> Posted By : <?=$datab['username']?> </span>
                        <a  class="comments"> <?=countcommentberita($datab['id_berita'])?> comments </a>
                    </div>  
                    
                    <div class="post-thumb"> 
                    	<a href="<?=base_url()?>homedata/berita/detail/<?=$datab['id_berita']?>" title=""> <img src="<?=base_url()?>view.php?image=upload/images/larger/<?=$datab['foto']?>&amp;mode=crop&amp;size=656x259" alt="" title="" width="656" height="259" /> </a>
                    </div>
                    
                    <div class="post-details">
                        <div class="categories"> Sekolah : <a title=""> <?=$datab['nama_sekolah']?> </div>
                        <div class="tags"> 
							<? $tag=explode(" ",$datab['tag']);?>
                        	<div class="float-right"> Tags :<? foreach($tag as $dttg){?>  <a  title="<?=$dttg?>"> <?=$dttg?> </a> <? } ?>  </div> 
                        </div>
                    </div>
                    
                    <div class="post-content">
                    	<p> <?=$datab['sub_desc']?>  </p>
                        
                        <a href="<?=base_url()?>homedata/berita/detail/<?=$datab['id_berita']?>" title="" class="readmore"> <span> Read More </span></a>
                    </div>
                     
                </div><!-- **Blog Post - End** -->
                
                <div class="hr"> </div>
                <? } ?>
                
                <div class="hr"> </div>
                <!-- **Pagination** -->
                <div class="pagination">
					<ul>
					<?=$pagination?>
                    </ul>           	
                </div><!-- **Pagination - End** -->