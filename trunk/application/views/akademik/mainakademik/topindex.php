<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-44433807-1', 'auto');
  ga('send', 'pageview');

</script>
<script>
            $(function(){
                $(document).ajaxStop(function() { 
                    $("a.prev_image").fancybox({
                        'opacity'		: true,
                        'overlayShow'	: false,
                        'transitionIn'	: 'elastic',
                        'transitionOut'	: 'none'
                    });
     
                     $("a[rel=group_image]").fancybox({
                        'transitionIn'   : 'none',
                        'transitionOut'  : 'none',
                        'titlePosition'  : 'over',
                        'titleFormat'    : function(title, currentArray, currentIndex, currentOpts) {
                         return '<span id="fancybox-title-over">Image ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
                         }
                     });
                     
                     $("a.album_image").fancybox({
                        'transitionIn'   : 'none',
                        'transitionOut'  : 'none',
                        'titlePosition'  : 'over',
                        'titleFormat'    : function(title, currentArray, currentIndex, currentOpts) {
                         return '<span id="fancybox-title-over">Image ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
                       }
                     });
                     
                     $(".modal_dialog").fancybox();
                     $(".modal").fancybox({
                        'showCloseButton'  : true,
                        'autoScale'  : true,
                        'height'  : 768,
                        'onComplete'  : function() {
						 var offset=$('.modal').offset();
						 $('#fancybox-wrap').css('top',offset.top+'px !important');
                        
                       }
                     });
                     $(".administrasifancy").fancybox({
                        'showCloseButton'  : true,
                        'autoScale'  : true,
                        'height'  : 768,
                        'width'  : 600,
                        'onComplete'  : function() {
						$('div#'+$(this).attr('href')).css("display:block;");
                       },
                        'onClosed'  : function() {
						 //var elmn=$('div#'+$(this).attr('href')).parent().html();
                         //$('div#'+$(this).attr('href')).parent('div').before($('div#'+$(this).attr('href')).parent().html());
                         
						 $('div#'+$(this).attr('href')).unwrap();

                       }
                     });
					 $(".fancyboxIframe").fancybox({
						fitToView	: false,
						width		: '90%',
						height		: '90%',
						autoSize	: false,
						closeClick	: false,
						openEffect	: 'none',
						type		: 'iframe',
						closeEffect	: 'none',
						iframe: {
							scrolling : 'auto',
							preload   : true
						}
					});
                });
            });
            </script>
<?
if($this->session->userdata['user_authentication']['otoritas']!='siswa' && $this->session->userdata['user_authentication']['otoritas']!='ortu'){
echo $this->load->view('akademik/mainakademik/js');
}
?>		
<?php
$cek = session_data();
if(empty($cek)) {
	$cek = '';
}
$user = DataUser();   
if(!file_exists($user->foto)) {
    $user->foto = 'asset/default/images/no_profile.jpg';
}
                        
if($cek['otoritas']=='siswa' || $cek['otoritas']=='ortu') {
     $url_redirect = site_url('sos/siswa/');
     $url_akademik = site_url('siswa/mainsiswa/');
     $url_sos = site_url('sos/siswa/pertemanan');
}else{
	$url_redirect = site_url('sos/pegawai/');
	$url_akademik = site_url('akademik/mainakademik/index');
	$url_sos = site_url('sos/pegawai/pertemanan');
}
					
?>
<div class="one-full">
                    <!-- **Team** -->
                    <div class="team">
                        <div class="image"> <img title="" alt="" src="<?=base_url()?>view.php?image=<?=$user->foto?>&amp;mode=crop&amp;size=100x100"> </div>
                        <h5> <?=$user->nama?> </h5>
                        <h6 class="role"> <?=$user->nama_sekolah?> </h6>
                       <?php
							$status = status_akhir_user();
							if(!empty($status)) {
							echo $status;	
							}
						?>
						<!-- **Share Links** -->                   
                        <div class="share-links"> 
                            <div class="column one-half"> 
                                <!--Email: <a title="" href=""> j.doe@domain.com </a> -->
                                <?=download_panduan()?>
                            </div>
                            <div class="column one-half last"> 
                                <div class="social">
                                   <!-- <a title="" href=""> <img title="" alt="" src="<?=$this->config->item('images');?>team-facebook.png"> </a>
                                    <a title="" href=""> <img title="" alt="" src="<?=$this->config->item('images');?>team-flickr.png"> </a>
                                    <a title="" href=""> <img title="" alt="" src="<?=$this->config->item('images');?>team-skype.png"> </a>
                                    <a title="" href=""> <img title="" alt="" src="images/team-twitter.png"> </a>-->
                                    <? if($cek['otoritas']=='siswa') { ?>
										<a href="<?=site_url('editakunsiswa')?>" style="float:right; margin-right:5px;background:none;"> Ubah Biodata <img title="" width="20" height="20" alt="" src="<?=$this->config->item('images');?>edit_icon.gif"> </a>
										&nbsp;&nbsp;&nbsp;
										<!--<a class="modal" href="<?=base_url('akademik/biodatasiswa/edit/'.$this->myencrypt->encode(serialize(array('nama'=>$user->nama,'id'=>$user->id))).'')?>" style="float:right; margin-right:5px;background:none;"> Ubah Biodata  <img title="" width="20" height="20" alt="" src="<?=$this->config->item('images');?>edit_icon.gif"></a>-->
									<? }else{ ?>
										<a title="" href=""><a href="<?=site_url('editakun')?>" style="float:right; margin-right:5px;background:none;"> Ubah Biodata </a> <img title="" width="20" height="20" alt="" src="<?=$this->config->item('images');?>edit_icon.gif">
									<? } ?>
								</div>
                            </div>                    
                        </div> <!-- **Share Links - End** -->                 
                    </div> <!-- **Team - End** -->               
</div>

<div class="hr toputsofile"></div>
<div class="column one-half">
    <div class="buttons">
        <a  href="<?=$url_akademik?>" class="tombol_parent button medium light-grey">AKADEMIK</a>
    </div>
</div>

		
<div class="column one-half last">
    <div class="buttons">
        <a  href="<?=$url_sos?>" class="button medium tombol_parent light-grey">JEJARING SOSIAL</a>
    </div>
</div>
<div class="portfolio column-one-half-with-sidebar">
    <div class="hr bottomutsofile"></div>
	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
	<!-- smartphone dan computer -->
	<ins class="adsbygoogle"
		 style="display:block"
		 data-ad-client="ca-pub-5804160032970255"
		 data-ad-slot="3223233922"
		 data-ad-format="auto"></ins>
	<script>
	(adsbygoogle = window.adsbygoogle || []).push({});
	</script>
   <!-- <div class="content content-full-width" style="color: white;background: #CDCDCD;padding-top:40px;padding-bottom: 40px;">
        <div class="text_iklan">SPACE IKLAN</div>
         <p>Mengenang Iklan Sepanjang Masa</p>
    </div>	-->
	<!-- iklan batas -->
	<!-- end iklan batas -->