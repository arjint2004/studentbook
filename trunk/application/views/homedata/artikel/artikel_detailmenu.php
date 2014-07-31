
<div class="inner-with-sidebar"></div>
            
                <h1 class="with-subtitle"> <?=$artikel[0]['judul']?> </h1>
                <h6 class="subtitle">   </h6>
                <!-- **Blog Post** -->
                <div class="blog-post">
                    <? if($artikel[0]['foto']!=''){?>
                    <div class="post-thumb"> 
                    	<a href="" title=""> <img src="<?=base_url()?>view.php?image=upload/images/artikel/<?=$artikel[0]['foto']?>&amp;mode=crop&amp;size=656x259" alt="" title="" width="656" height="259" /> </a>
                    </div>
                    <? } ?>
                    <div class="post-details">

                    </div>
                    
                    <div class="post-content">
                    	<?=$artikel[0]['content']?>
                        
                    </div>
                     
                </div><!-- **Blog Post - End** -->
