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
<?=$this->load->view('akademik/mainakademik/topindex')?>	

<div class="portfolio column-one-half-with-sidebar">

	<script>
		$(document).ready(function() {
			$('#penghubungortu').load('<?=base_url('siswa/jurnalwalikelas/penghubungortu')?>');
		});
	</script>
	<div id="penghubungortu"></div>	
	<div class="clear"></div>
	<h3 id="<?=$cek['otoritas']?>"> Menu <?=$cek['otoritas']?> </h3>
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
        