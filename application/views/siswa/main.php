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
	<div class="notifak column content content-full-width">
        <h2 class="float-left"> NOTIFIKASI AKADEMIK </h2>   
        <div class="toggle-frame">
            <h5 class="toggle-accordion"><a >Pemberitahuan terahir dari sekolah</a></h5>
            <div style="display: block; max-height:400px;" class="toggle-content">
				<? timelineakademik();?>
			</div>
        </div>                  
    </div>	
	<? aktifitasakademik($this->session->userdata['user_authentication']['id_pengguna'],'siswa',5);?>
	<script>
		$(document).ready(function() {
			$('#contentbelajar').load('<?=base_url('akademik/bahanajar/siswa')?>');
			<?
			if($jenjang[0]['bentuk']=='TK'){
			?>
				$.ajax({
				type: "GET",
				data: '',
				url: '<?=base_url('siswa/penghubungortutk/penghubungortu')?>',
				beforeSend: function() {
					
				},
				success: function(msg) {
					$('#penghubungortu').html(msg);
					$.ajax({
						type: "POST",
						data: 'id_kelas=<?=$this->session->userdata['user_authentication']['id_kelas_siswa_det_jenjang']?>',
						url: '<?=base_url('siswa/penghubungortutk/penghubungortulist/0')?>',
						beforeSend: function() {
						
						},
						success: function(msg) {
							$("#wait").remove();
							$('#listpenghub').html(msg);
						}
					});
				}
				});
			<?
			}else{
			?>
				$('#penghubungortu').load('<?=base_url('siswa/jurnalwalikelas/penghubungortu')?>');
			<? } ?>
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
			<li>
				<? 
							
				$url=array(
					'nis'=>$this->session->userdata['user_authentication']['nis'],
					'nama'=>$user->nama,
					'id_siswa_det_jenjang'=>$this->session->userdata['user_authentication']['id_siswa_det_jenjang'],
					'id'=>$user->id,
					'onlyraport'=>true,
					'id_kelas'=>$this->session->userdata['user_authentication']['id_kelas_siswa_det_jenjang']
				);
				//pr($url);
				//$urlprint=$url;
				//$urlprint['print']='allow';
				?>
				<a onclick="$('#raportsiswa1').load('<?=base_url('akademik/raportktsp/lihat/'.$this->myencrypt->encode(serialize($url)).'');?>');">Raport</a>
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
        