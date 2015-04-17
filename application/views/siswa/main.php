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
			$('#contentbelajar').load('<?=base_url('akademik/bahanajar/siswa')?>');
			$('#penghubungortu').load('<?=base_url('siswa/jurnalwalikelas/penghubungortu')?>');
		});
	</script>
	<? aktifitasakademik($this->session->userdata['user_authentication']['id_pengguna'],'siswa',5);?>
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
			<li>
				<? 
							
				//$url=array('nis'=>$datasiswa['nis'],'nama'=>$datasiswa['nama'],'id_siswa_det_jenjang'=>$datasiswa['id_siswa_det_jenjang'],'id'=>$datasiswa['id'],'id_kelas'=>$datasiswa['id_kelas']);
				//$urlprint=$url;
				//$urlprint['print']='allow';
				?>
				<a onclick="$('#raportsiswa1').load('<?//=?>');">Raport</a>
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
		<div class="tabs-frame-content" style="display: none;" id="raportsiswa1">
		</div>
	</div>

	<div class="clear"></div>
	<h3 id="guru"> Content Belajar </h3>
	<div class="hr"></div>
	<div class="tabs-container">
		<ul class="tabs-frame">
			<li>
				<a>Kelas <?=$this->session->userdata('user_authentication')['kelas']?></a>
			</li>
		</ul>
		<div class="tabs-frame-content" id="contentbelajar" style="display: block;"></div>
	</div>
	
	<div class="clear"></div>
	
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
        