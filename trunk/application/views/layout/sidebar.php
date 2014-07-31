<?
$artikelpopuler=artikel_populer(2);
$artikelsponsorr=artikel_sponsor(2);
$berita=berita(2);
?>

 <!-- **Sidebar** -->
            <div class="sidebar">
            	<div class="inner-sidebar"> </div>
				<? if(!empty($artikelpopuler)){?>
				<div class="widget widget_recent_entries">
					<h2 class="widgettitle"> Artikel Populer </h2>
					<ul>
						<? foreach($artikelpopuler as $id=>$datapop){?>
						<li> 
							<a href="blog-single.html" title="" class="thumb"> <img src="<?=base_url()?>view.php?image=upload/images/artikel/<?=$datapop['foto']?>&amp;mode=crop&amp;size=71x62" alt="" title="" /> </a>
							<h6> <a href="<?=base_url()?>homedata/artikel/detail/<?=$datapop['id_artikel']?>" title=""> <?=$datapop['judul']?> </a> </h6>
							<p><?=substr($datapop['sub_desc'],0,58)?>...</p>
						</li>
						<? } ?>
					</ul>
				</div>
                <div class="hr"> </div>
                <? } ?>
				
				<? if(!empty($artikelsponsorr)){?>
                <div class="widget widget_popular_entries">
                	<h2 class="widgettitle"> Sponsor </h2>
                	<ul>
						<? foreach($artikelsponsorr as $id=>$datapop){?>
						<li> 
							<a href="blog-single.html" title="" class="thumb"> <img src="<?=base_url()?>view.php?image=upload/images/artikel/<?=$datapop['foto']?>&amp;mode=crop&amp;size=71x62" alt="" title="" /> </a>
							<h6> <a href="<?=base_url()?>homedata/artikel/detail/<?=$datapop['id_artikel']?>" title=""> <?=$datapop['judul']?> </a> </h6>
							<p><?=substr($datapop['sub_desc'],0,58)?>...</p>
						</li>
						<? } ?>
                    </ul>
                </div>
                <div class="hr"> </div> 
                <? } ?>
				
				<? if(!empty($berita)){?>
                <div class="widget widget_popular_entries">
                	<h2 class="widgettitle"> Berita Terkini </h2>
                	<ul>
						<? foreach($berita as $id=>$datapop){?>
						<li> 
							<a href="blog-single.html" title="" class="thumb"> <img src="<?=base_url()?>view.php?image=upload/images/thumb/<?=$datapop['foto']?>&amp;mode=crop&amp;size=71x62" alt="" title="" /> </a>
							<h6> <a href="<?=base_url()?>homedata/berita/detail/<?=$datapop['id_berita']?>" title=""> <?=$datapop['judul']?> </a> </h6>
							<p><?=substr($datapop['berita'],0,58)?>...</p>
						</li>
						<? } ?>
                    </ul>
                </div>
                <div class="hr"> </div> 
                <? } ?>      
                
                <!--<div class="widget widget_categories">
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
                
                <div class="hr"> </div>-->       
                
                <!--<div class="widget widget_text">
                	<h2 class="widgettitle"> Sample Text Widget </h2>
                    <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam id massa vitae libero ultricies consequat. Sed pharetra tincidunt lorem, at laoreet arcu congue vitae.  </p>
                </div> -->                    
                
            </div><!-- **Sidebar - End** --> 