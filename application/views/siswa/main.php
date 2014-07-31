<?=$this->load->view('siswa/js')?>		
<?php
$cek = session_data();
if(empty($cek)) {
	$cek = '';
}
$user = DataUser();
                    
if(empty($user->foto)) {
    $user->foto = 'asset/default/images/no_profile.jpg';
}
                        
if($cek['otoritas']=='siswa') {
     $url_redirect = site_url('sos/siswa/');
}else{
	$url_redirect = site_url('sos/pegawai/');
}
						
?>
<div class="one-full">
                    <!-- **Team** -->
                    <div class="team">          
                        <div class="image"> <img title="" alt="" src="<?=base_url($user->foto)?>" > </div>
                        <h5> <?=$user->nama?> </h5>
                        <h6 class="role"> <?=$user->nama_sekolah?> </h6>
                        <p><?php
							$status = status_akhir_user();
							if(!empty($status)) {
							echo $status;	
							}
						?>
						</p>
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
                                    <a title="" href=""><a href="<?=site_url('sos/siswa/edit_siswa')?>" style="float:right; margin-right:5px;background:none;">Edit Profile </a> <img title="" width="20" height="20" alt="" src="<?=$this->config->item('images');?>edit_icon.gif"> </a>
                                </div>
                            </div>                    
                        </div> <!-- **Share Links - End** -->                 
                    </div> <!-- **Team - End** -->               
</div>

<div class="hr toputsofile"></div>
<div class="column one-half">
    <div class="buttons">
        <a  href="<?=base_url('siswa/mainsiswa')?>" class="button medium tombol_parent light-grey">AKADEMIK</a>
    </div>
</div>

		
<div class="column one-half last">
    <div class="buttons">
        <a  href="<?=base_url('sos/siswa/pertemanan')?>" class="button medium tombol_parent light-grey">JEJARING SOSIAL</a>
    </div>
</div>

<div class="portfolio column-one-half-with-sidebar">

    <div class="hr bottomutsofile"></div>
    <div class="content content-full-width" style="color: white;background: #CDCDCD;padding-top:40px;padding-bottom: 40px;">
        <div class="text_iklan">SPACE IKLAN</div>
         <p>Mengenang Iklan Sepanjang Masa</p>
    </div>
	
	<!-- iklan batas -->
	<!-- end iklan batas -->	
	
	<div class="clear"></div>
	<h3 id="<?=$cek['otoritas']?>"> <?=$cek['otoritas']?> </h3>
	<div class="hr"></div>
	<div class="tabs-container">

		<ul class="tabs-frame">
			<li>
				<a >Pembelajaran</a>
			</li>
			<li>
				<a >Ujian</a>
			</li>
			<li>
				<a >Evaluasi</a>
			</li>
		</ul>
		<div class="tabs-frame-content" style="display: none;">
			<a class="readmore" tab="pembelajaran" id="materi_pelajaran" title="" > Materi<br />Pelajaran </a>
			<a class="readmore" tab="pembelajaran" id="daftar_pr"  title=""> Daftar<br />PR</a>
			<a class="readmore" tab="pembelajaran"   id="daftar_tugas" title=""  > Daftar<br />Tugas </a>
			<br id="brsubject"  tab="pembelajaran"  class="clear" />
            <div id="subject"></div>
		</div>
		<div class="tabs-frame-content" style="display: none;">
			<a class="readmore" title="" href="" tab="ujian" id="daftar_harian"> Ulangan Harian </a>
            <a class="readmore" title="" href="" tab="ujian" id="daftar_uts"> Ujiang Tengah Semester </a>
            <a class="readmore" title="" href="" tab="ujian" id="daftar_uas"> Ujiang Akhir Semester </a>
            <!--<a class="readmore" title="" href="" tab="ujian" id="daftar_praktek"> Ujiang Praktek </a>-->
		</div>
		<div class="tabs-frame-content" style="display: none;">
            <a class="readmore" tab="evaluasi" id="rekapabsensi" title="" href=""> Rekap Absensi </a>
            <a class="readmore" tab="evaluasi" id="jurnalwalikelas" title="" href=""> Jurnal Wali Kelas </a>
            <a class="readmore" tab="evaluasi" id="catatanguru" title="" href=""> Catatan Guru </a>
            <a class="readmore" tab="evaluasi" id="rekapnilai" title="" href=""> Rekap Nilai Akademik </a>
		</div>
	</div>

    <div class="hr "></div>
    <div class="content content-full-width" style="color: white;background: #CDCDCD;padding-top:40px;padding-bottom: 40px;">
        <div class="text_iklan">SPACE IKLAN</div>
         <p>Mengenang Iklan Sepanjang Masa</p>
    </div>
<!-- iklan batas -->
	<!-- end iklan batas -->	
	
	<script>
		$(document).ready(function() {
			$('#penghubungortu').load('<?=base_url('siswa/jurnalwalikelas/penghubungortu')?>');
		});
	</script>
	<div id="penghubungortu"></div>
	
	<div class="clear"></div>
	<h3> Raport </h3>
	<div class="hr"></div>
	<input type="hidden" value="<?=$datasiswa[0]['id_kelas']?>" name="id_kelas" id="kelasraport" class="selectfilter"/>
	<input type="hidden" value="<?=$datasiswa[0]['id_siswa_det_jenjang']?>" name="id_siswa_det_jenjang" id="siswaraport" class="selectfilter"/>
	<div class="tabs-container">

		<ul class="tabs-frame">
			<li>
				<a style="padding:0 3px;" id="raporttab">Raport</a>
			</li>
			<li>
				<a style="padding:0 3px;"  id="raporekstrattab">Ekstrakurikuler</a>
			</li>
			<li>
				<a style="padding:0 3px;"  id="raportkegiatantab" >Kegiatan</a>
			</li>
			<li>
				<a style="padding:0 3px;" id="raportkepribadiantab">Kepribadian</a>
			</li>
			<li>
				<a style="padding:0 3px;" id="raportprestasitab">Prestasi</a>
			</li>
			<li>
				<a style="padding:0 3px;" id="raportabsensitab">Absensi</a>
			</li>
			<!--<li>
				<a style="padding:0 3px;" id="raportcatatantab">Catatan</a>
			</li>-->
			<li>
				<a style="padding:0 3px;" id="raportkenaikantab">Keterangan</a>
			</li>
		</ul>
		<div class="tabs-frame-content"  id="raport" style="display: block;">
			
		</div>
		<div class="tabs-frame-content"  id="ekstraload"  style="display: none;">
			
		</div>
		<div class="tabs-frame-content"   id="kegiatanload" style="display: none;">
			
		</div>
		<div class="tabs-frame-content"   id="kepribadianload" style="display: none;">
			
		</div>
		<div class="tabs-frame-content"   id="prestasiload" style="display: none;">
			
		</div>
		<div class="tabs-frame-content"  id="absensiload"  style="display: none;">
			
		</div>
		<!--<div class="tabs-frame-content"  id="catatanload"  style="display: none;">
			
		</div>-->
		<div class="tabs-frame-content"  id="kenaikanload"  style="display: none;">
			
		</div>
		
	</div>
	<!-- iklan batas -->
	<!-- end iklan batas -->	
	<div class="clear"></div>
	<?=jadwal();?>
	
    <div class="hr "></div>
    <div class="content content-full-width" style="color: white;background: #CDCDCD;padding-top:40px;padding-bottom: 40px;">
        <div class="text_iklan">SPACE IKLAN</div>
         <p>Mengenang Iklan Sepanjang Masa</p>
    </div>

	<div class="hr"></div>

</div>


		<!-- END MAIN FRONT END -->
        