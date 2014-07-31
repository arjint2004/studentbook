
<?=$this->load->view('akademik/mainakademik/js')?>		
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
                        <div class="image"> <img title="" alt="" src="<?=base_url($user->foto)?>"> </div>
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
                                    <? if($cek['otoritas']=='siswa' || $cek['otoritas']=='ortu') { ?>
										<a title="" href=""><a href="<?=site_url('sos/siswa/edit_siswa')?>" style="float:right; margin-right:5px;background:none;"> Ubah Biodata </a> <img title="" width="20" height="20" alt="" src="<?=$this->config->item('images');?>edit_icon.gif"> </a>
									<? }else{ ?>
										<a title="" href=""><a href="<?=site_url('sos/pegawai/edit_pegawai')?>" style="float:right; margin-right:5px;background:none;"> Ubah Biodata </a> <img title="" width="20" height="20" alt="" src="<?=$this->config->item('images');?>edit_icon.gif"> </a>
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
   <!-- <div class="content content-full-width" style="color: white;background: #CDCDCD;padding-top:40px;padding-bottom: 40px;">
        <div class="text_iklan">SPACE IKLAN</div>
         <p>Mengenang Iklan Sepanjang Masa</p>
    </div>	-->
	<!-- iklan batas -->
	<!-- end iklan batas -->