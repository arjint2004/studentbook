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
<script>
	function ajax(self,url,load,jenis){
		if($(self).parent('h5').attr('class')=='toggle active'){
			$("#"+load).html('');
		}else{
			$.ajax({
					type: "POST",
					data: 'kepsek=true&jenis='+jenis+'&idload='+load,
					url: url,
					beforeSend: function() {
						$(self).after("<img id='wait' style='margin: 0px; position: relative; right: 260px; bottom: 21px;'  src='<?=$this->config->item('images').'loading.png';?>' />");
					},
					success: function(msg) {
						$("#wait").remove();
						$("#"+load).html(msg);
					}
			});	
		}
	}
	
    $(function(){
		$('ul.tabs-framestatistik li').click( function() {
			var self=$(this);
			$.ajax({
					type: "POST",
					data: 'kepsek=true&jenis='+$(this).attr('id'),
					url: '<?=base_url('akademik/kepsek/statistik')?>',
					beforeSend: function() {
						$(self).children('a').append("<img id='wait' style='position: relative; bottom: 0px; margin: 0px 5px;  top: 2px;'  src='<?=$this->config->item('images').'loading.png';?>' />");
					},
					success: function(msg) {
						$("#wait").remove();
						$("#cnt"+$(self).attr('id')).html(msg);
					}
			});		
		});
		if($('ul.tabs-framestatistik').length > 0) $('ul.tabs-framestatistik').tabs('> .tabs-frame-content6');
		$.ajax({
					type: "POST",
					data: 'kepsek=true&jenis=rpp',
					url: '<?=base_url('akademik/kepsek/statistik')?>',
					beforeSend: function() {
						$('ul.tabs-framestatistik li#rpp').children('a').append("<img id='wait' style='position: relative; bottom: 0px; margin: 0px 5px;  top: 2px;'  src='<?=$this->config->item('images').'loading.png';?>' />");
					},
					success: function(msg) {
						$("#wait").remove();
						$("#cntrpp").html(msg);
					}
			});	
    });
</script>
<div class="one-full">
                    <!-- **Team** -->
                    <div class="team">          
                        <div class="image"> <img title="" alt="" src="<?=base_url($user->foto)?>"> </div>
                        <h5> <?=$user->nama?> (Kepala Sekolah) </h5>
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
                                 
                            </div>
                            <div class="column one-half last"> 
                                <div class="social">
                                   <!-- <a title="" href=""> <img title="" alt="" src="<?=$this->config->item('images');?>team-facebook.png"> </a>
                                    <a title="" href=""> <img title="" alt="" src="<?=$this->config->item('images');?>team-flickr.png"> </a>
                                    <a title="" href=""> <img title="" alt="" src="<?=$this->config->item('images');?>team-skype.png"> </a>
                                    <a title="" href=""> <img title="" alt="" src="images/team-twitter.png"> </a>-->
                                    <a title="" href=""><a href="<?=site_url('sos/siswa/edit_siswa')?>" style="float:right; margin-right:5px;background:none;"> Ubah Biodata </a> <img title="" width="20" height="20" alt="" src="<?=$this->config->item('images');?>edit_icon.gif"> </a>
                                </div>
                            </div>                    
                        </div> <!-- **Share Links - End** -->                 
                    </div> <!-- **Team - End** -->               
</div>

<div class="hr toputsofile"></div>
<div class="column one-half">
    <div class="buttons">
        <a  href="<?=base_url('akademik/mainakademik/index')?>" class="tombol_parent button medium light-grey">AKADEMIK</a>
    </div>
</div>

		
<div class="column one-half last">
    <div class="buttons">
        <a  href="<?=base_url('sos/pegawai/pertemanan')?>" class="button medium tombol_parent light-grey">JEJARING SOSIAL</a>
    </div>
</div>
<div class="portfolio column-one-half-with-sidebar">	
    <!--<div class="hr "></div>
    <div class="content content-full-width" style="color: white;background: #CDCDCD;padding-top:40px;padding-bottom: 40px;">
        <div class="text_iklan">SPACE IKLAN</div>
         <p>Mengenang Iklan Sepanjang Masa</p>
    </div>
	-->
	<div class="clear"></div>
	<h3></h3>
	<div class="hr"></div>
	<div id="buttonasbin" class="buttonasbin tabs-frame-content back_berita fixed">
			<div style="width:158px;" class="readmorenoplus" title="" onclick="window.location='<?=base_url('akademik/mainakademik/index')?>'">Akademik</div>
			<div style="width:158px;" class="readmorenoplus" title="" onclick="window.location='<?=base_url('sos/pegawai/pertemanan')?>'">Jejaring Sosial</div>
			<div style="width:158px;" class="readmorenoplus" title="" onclick="$('#absensikepsek').scrollintoview({ speed:'1100'});">Absensi</div>
			<div style="width:158px;" class="readmorenoplus" title="" onclick="$('#materikepsek').scrollintoview({ speed:'1100'});">Materi</div>
			<div style="width:158px;" class="readmorenoplus" title="" onclick="$('#prkepsek').scrollintoview({ speed:'1100'});">PR</div>
			<div style="width:158px;" class="readmorenoplus" title="" onclick="$('#tugaskepsek').scrollintoview({ speed:'1100'});">Tugas</div>
			<div style="width:158px;" class="readmorenoplus" title="" onclick="$('#uhkepsek').scrollintoview({ speed:'1100'});">Ulangan Harian</div>
			<div style="width:158px;" class="readmorenoplus" title="" onclick="$('#utskepsek').scrollintoview({ speed:'1100'});">UTS</div>
			<div style="width:158px;" class="readmorenoplus" title="" onclick="$('#uaskepsek').scrollintoview({ speed:'1100'});">UAS</div>
			<div style="width:158px;" class="readmorenoplus" title="" onclick="$('#nilaikepsek').scrollintoview({ speed:'1100'});">Nilai</div>
			<div style="width:158px;" class="readmorenoplus" title="" onclick="$('#raportkepsek').scrollintoview({ speed:'1100'});">Raport</div>
			<div style="width:158px;" class="readmorenoplus" title="" onclick="$('#naiklllskepsek').scrollintoview({ speed:'1100'});">Kenaikan/Kelulusan</div>
			<div style="width:158px;" class="readmorenoplus" title="" onclick="$('#catatankepsek').scrollintoview({ speed:'1100'});">Catatan Guru</div>
			<div style="width:158px;" class="readmorenoplus" title="" onclick="$('#pribadikepsek').scrollintoview({ speed:'1100'});">Kepribadian Siswa</div>
			<div style="width:158px;" class="readmorenoplus" title="" onclick="$('#pengembangankepsek').scrollintoview({ speed:'1100'});">Pengembangan Diri Siswa</div>
			<div style="width:158px;" class="readmorenoplus" title="" onclick="$('#ekstrakepsek').scrollintoview({ speed:'1100'});">Ekstrakurikuler</div>
			<div style="width:158px;" class="readmorenoplus" title="" onclick="$('#lainkepsek').scrollintoview({ speed:'1100'});">Lain-Lain</div>
	</div>

	<!-- iklan batas -->
	<!-- end iklan batas -->	
	
	<div class="clear"></div>
	<h3> Statistik Guru </h3>
	<div class="hr"></div>
	<div class="tabs-container">
		<ul class="tabs-frame tabs-framestatistik">
			<li id="rpp"><a href="#">RPP</a></li>
			<li id="materi"><a href="#">Materi</a></li>
			<li id="pr"><a href="#">PR</a></li>
			<li id="tugas"><a href="#">Tugas</a></li>
			<li id="harian"><a href="#">UL Harian</a></li>
			<li id="uts"><a href="#">UTS</a></li>
			<li id="uas"><a href="#">UAS</a></li>
			<li id="catatan"><a href="#">Catatan</a></li>
		</ul>
		<div id="cntrpp" class="tabs-frame-content tabs-frame-content6">
			
		</div>
		<div id="cntmateri" class="tabs-frame-content tabs-frame-content6">
			
		</div>
		<div id="cntpr" class="tabs-frame-content tabs-frame-content6">
			
		</div>
		<div id="cnttugas" class="tabs-frame-content tabs-frame-content6">
			
		</div>
		<div id="cntharian" class="tabs-frame-content tabs-frame-content6">
			
		</div>
		<div id="cntuts" class="tabs-frame-content tabs-frame-content6">
			
		</div>
		<div id="cntuas" class="tabs-frame-content tabs-frame-content6">
			
		</div>
		<div id="cntcatatan" class="tabs-frame-content tabs-frame-content6">
			
		</div>
	</div>	
					
	
	<div class="clear"></div>
	<h3> RENCARA PEMBELAJARAN  (RPP) </h3>
	<div class="hr"></div>
	<div class="toggle-frame">
        <h5 class="toggle"><a href="#" onclick="ajax(this,'<?=base_url()?>akademik/kepsek/filterrpp','rencanapembelajaran','<?=base64_encode('akademik/perencanaan/pembelajaranlist')?>');">Rencana Pembelajaran</a></h5>
        <div style="display: none;" class="toggle-content" id="rencanapembelajaran">
        
        </div>
    </div>
	<!--<div class="toggle-frame">
        <h5 class="toggle"><a href="#" onclick="ajax(this,'<?=base_url()?>akademik/kepsek/filter','timelinepembelajaran','<?=base64_encode('akademik/perencanaan/timelinepembelajaranlist')?>');">Timeline Pembelajaran</a></h5>
        <div style="display: none;" class="toggle-content" id="timelinepembelajaran">
        <p>  </p>
        </div>
    </div>
	<div class="toggle-frame">
        <h5 class="toggle"><a href="#">Mata Pelajaran Tahun Ini</a></h5>
        <div style="display: none;" class="toggle-content">
        <p>  </p>
        </div>
    </div>	-->


	<!-- iklan batas -->
	<!-- end iklan batas -->	
	<div class="clear"></div>
	<h3 id="absensikepsek"> ABSENSI </h3>
	<div class="hr"></div>
	<div class="toggle-frame">
        <h5 class="toggle"><a onclick="ajax(this,'<?=base_url()?>akademik/kepsek/absensifilter','absensi','<?=base64_encode('akademik/absensi/add')?>');" href="#">Absensi Siswa</a></h5>
        <div style="display: none;" class="toggle-content" id="absensi">
        </div>
    </div>
	<!--<div class="toggle-frame">
        <h5 class="toggle"><a href="#">Absensi Guru</a></h5>
        <div style="display: none;" class="toggle-content">
        <p>  </p>
        </div>
    </div>
	<div class="toggle-frame">
        <h5 class="toggle"><a href="#">Absensi karyawan</a></h5>
        <div style="display: none;" class="toggle-content">
        <p>  </p>
        </div>
    </div>	-->


	<!-- iklan batas -->
	<!-- end iklan batas -->	
	<div class="clear"></div>
	<h3> DATA PEMBELAJARAN</h3>
	<div class="hr"></div>
	<div class="toggle-frame" id="materikepsek">
        <h5 class="toggle"><a href="#"  onclick="ajax(this,'<?=base_url()?>akademik/kepsek/filter','materilist','<?=base64_encode('akademik/materi/daftarmaterilist')?>');">Materi Pelajaran yang Dikirimkan Guru</a></h5>
        <div style="display: none;" class="toggle-content" id="materilist">
        <p>  </p>
        </div>
    </div>
	<div class="toggle-frame" id="prkepsek">
        <h5 class="toggle"><a href="#" onclick="ajax(this,'<?=base_url()?>akademik/kepsek/filter','prlist','<?=base64_encode('akademik/kirimpr/daftarprlist')?>');">Pekerjaan Rumah (PR) yang Dikirimkan Guru</a></h5>
        <div style="display: none;" class="toggle-content" id="prlist">
        <p>  </p>
        </div>
    </div>
	<div class="toggle-frame" id="tugaskepsek">
        <h5 class="toggle"><a href="#" onclick="ajax(this,'<?=base_url()?>akademik/kepsek/filter','tugaslist','<?=base64_encode('akademik/kirimtugas/daftartugaslist')?>');">Tugas yang Dikirimkan Guru</a></h5>
        <div style="display: none;" class="toggle-content" id="tugaslist">
        <p>  </p>
        </div>
    </div>	


	<!-- iklan batas -->
	<!-- end iklan batas -->	
	<div class="clear"></div>
	<h3> DATA UJIAN </h3>
	<div class="hr"></div>
	<div class="toggle-frame" id="uhkepsek">
        <h5 class="toggle"><a href="#" onclick="ajax(this,'<?=base_url()?>akademik/kepsek/filter','harianlist','<?=base64_encode('akademik/kirimharian/daftarharianlist')?>');">Ulangan Harian yang Dikirimkan Guru</a></h5>
        <div style="display: none;" class="toggle-content" id="harianlist">
        <p>  </p>
        </div>
    </div>
	<div class="toggle-frame" id="utskepsek">
        <h5 class="toggle"><a href="#" onclick="ajax(this,'<?=base_url()?>akademik/kepsek/filter','utslist','<?=base64_encode('akademik/kirimuts/daftarutslist')?>');">Ujian Tengah Semester (UTS) yang Dikirimkan Guru</a></h5>
        <div style="display: none;" class="toggle-content" id="utslist">
        <p>  </p>
        </div>
    </div>
	<!--<div class="toggle-frame">
        <h5 class="toggle"><a href="#">Ujian Praktek yang Dikirimkan Guru</a></h5>
        <div style="display: none;" class="toggle-content">
        <p>  </p>
        </div>
    </div>-->
	<div class="toggle-frame" id="uaskepsek">
        <h5 class="toggle"><a href="#" onclick="ajax(this,'<?=base_url()?>akademik/kepsek/filter','uaslist','<?=base64_encode('akademik/kirimuas/daftaruaslist')?>');">Ujian Akhir Semester (UAS) yang Dikirimkan Guru</a></h5>
        <div style="display: none;" class="toggle-content" id="uaslist">
        <p>  </p>
        </div>
    </div>	


	<!-- iklan batas -->
	<!-- end iklan batas -->	
	<div class="clear"></div>
	<h3> DATA NILAI </h3>
	<div class="hr"></div>
	<div class="toggle-frame" id="nilaikepsek">
        <h5 class="toggle"><a href="#" onclick="ajax(this,'<?=base_url()?>akademik/kepsek/filter','nilailist','<?=base64_encode('akademik/rekapnilai/rekapnilailist')?>');">Nilai Siswa</a></h5>
        <div style="display: none;" class="toggle-content" id="nilailist">
        <p>  </p>
        </div>
    </div>
	<div class="toggle-frame" id="raportkepsek">
		<?=$this->load->view('akademik/kepsek/js')?>
        <h5 class="toggle"><a href="#">Raport</a></h5>
        <div style="display: none;" class="toggle-content">
		<div id="contentpage">
		<table class="tabelfilter">
			<tbody>
				<tr>
					<td>
						Kelas :
						<select class="selectfilter" id="kelasraport" name="id_kelas">
							<option value="">Pilih Kelas</option>
							<? foreach($kelas as $datakelas){?>
								<option <? if(@$_POST['kelas']==$datakelas['id']){echo 'selected';}?> value="<?=$datakelas['id']?>"><?=$datakelas['kelas']?><?=$datakelas['nama']?></option>
							<? } ?>
						</select>
									
						Siswa :
						<select class="selectfilter" id="siswaraport" name="id_siswa_det_jenjang">
							<option value="">Pilih Siswa</option>
						</select>					
					</td>
				</tr>
			</tbody>
		</table>
	</div>
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
        </div>
    </div>


	<!-- iklan batas -->
	<!-- end iklan batas -->	
	<div class="clear"></div>
	<h3> DATA KENAIKAN / KELULUSAN </h3>
	<div class="hr"></div>
	<div class="toggle-frame" id="naiklllskepsek">
        <h5 class="toggle"><a href="#">Kenaikan / Kelulusan Tahun Ini</a></h5>
        <div style="display: none;" class="toggle-content">
			
			<table class="tabelfilter">
			<tbody>
				<tr>
					<td>
						Kelas :
						<select id="kelaskenaikan" class="selectfilter" name="id_kelaskenaikan">
							<option value="">Pilih Kelas</option>
							<? foreach($kelas as $datakelas){?>
								<option <? if(@$_POST['kelas']==$datakelas['id']){echo 'selected';}?> value="<?=$datakelas['id']?>"><?=$datakelas['kelas']?><?=$datakelas['nama']?></option>
							<? } ?>
						</select>		
					</td>
				</tr>
			</tbody>
			</table>
			<div  id="kenaikankelulusanload"></div>
        </div>
    </div>

	<!-- iklan batas -->
	<!-- end iklan batas -->	
	<div class="clear"></div>
	<h3> DATA EVALUASI </h3>
	<div class="hr"></div>
	<div class="toggle-frame" id="catatankepsek">
        <h5 class="toggle"><a href="#"  onclick="ajax(this,'<?=base_url()?>akademik/kepsek/catatangurufilter','catatanguru','<?=base64_encode('akademik/catatanguru/catatangurulist')?>');">Catatan Guru</a></h5>
        <div style="display: none;" class="toggle-content" id="catatanguru">
        </div>
    </div>
	<div class="toggle-frame" id="pribadikepsek">
        <h5 class="toggle"><a href="#" onclick="ajax(this,'<?=base_url()?>akademik/kepsek/filterbysiswa','kepribadian','<?=base64_encode('akademik/kepribadian/kepribadianlist')?>');">Kepribadian Siswa</a></h5>
        <div style="display: none;" class="toggle-content" id="kepribadian">
        <p>  </p>
        </div>
    </div>
	<div class="toggle-frame" id="lainkepsek">
        <h5 class="toggle"><a href="#" onclick="ajax(this,'<?=base_url()?>akademik/kepsek/filterbykelas','lainlain','<?=base64_encode('akademik/nilai/getsubject/'.base64_encode('nilai lain_lain').'')?>');">Lain-Lain</a></h5>
        <div style="display: none;" class="toggle-content" id="lainlain">
        <p>  </p>
        </div>
    </div>

	<!-- iklan batas -->
	<!-- end iklan batas -->	
	<!--<div class="clear"></div>
	<h3> DATA PROFIL WARGA SEKOLAH </h3>
	<div class="hr"></div>
	<div class="toggle-frame">
        <h5 class="toggle"><a href="#">Profil Guru</a></h5>
        <div style="display: none;" class="toggle-content">
        <p>  </p>
        </div>
    </div>
	<div class="toggle-frame">
        <h5 class="toggle"><a href="#">Profil Siswa</a></h5>
        <div style="display: none;" class="toggle-content">
        <p>  </p>
        </div>
    </div>
	<div class="toggle-frame">
        <h5 class="toggle"><a href="#">Profil Karyawan</a></h5>
        <div style="display: none;" class="toggle-content">
        <p>  </p>
        </div>
    </div>-->

	<!-- iklan batas -->
	<!-- end iklan batas -->	
	<!--<div class="clear"></div>
	<h3> DATA KEUANGAN SEKOLAH </h3>
	<div class="hr"></div>
	<div class="toggle-frame">
        <h5 class="toggle"><a href="#">Keuangan Sekolah</a></h5>
        <div style="display: none;" class="toggle-content">
        <p>  </p>
        </div>
    </div>
	<div class="toggle-frame">
        <h5 class="toggle"><a href="#">Inventaris</a></h5>
        <div style="display: none;" class="toggle-content">
        <p>  </p>
        </div>
    </div>
	<div class="toggle-frame">
        <h5 class="toggle"><a href="#">SPP</a></h5>
        <div style="display: none;" class="toggle-content">
        <p>  </p>
        </div>
    </div>
	<div class="toggle-frame">
        <h5 class="toggle"><a href="#">Iuran</a></h5>
        <div style="display: none;" class="toggle-content">
        <p>  </p>
        </div>
    </div>-->

	<!-- iklan batas -->
	<!-- end iklan batas -->	
	<div class="clear"></div>
	<h3> DATA KEGIATAN / ORGANISASI SEKOLAH </h3>
	<div class="hr"></div>
	<div class="toggle-frame" id="pengembangankepsek">
        <h5 class="toggle"><a href="#" onclick="ajax(this,'<?=base_url()?>akademik/kepsek/filterbykelaskegiatan','kegiatanx','<?=base64_encode('akademik/nilaikegiatansekolah/nilaiekstralist')?>');">Pengembangan Diri Siswa</a></h5>
        <div style="display: none;" class="toggle-content" id="kegiatanx">
        <p>  </p>
        </div>
    </div>
	<div class="toggle-frame" id="ekstrakepsek">
        <h5 class="toggle"><a href="#" onclick="ajax(this,'<?=base_url()?>akademik/kepsek/filterbyekstrakurikuler','kegiatanextrak','<?=base64_encode('akademik/nilaiekstrakurikuler/nilaiekstralist')?>');">Kegiatan Ekstrakurikuler</a></h5>
        <div style="display: none;" class="toggle-content" id="kegiatanextrak" >
        <p>  </p>
        </div>
    </div>

	<!-- iklan batas -->
	<!-- end iklan batas -->	
	<!--<div class="clear"></div>
	<h3> GRAFIK </h3>
	<div class="hr"></div>
	<div class="toggle-frame">
        <h5 class="toggle"><a href="#">Grafik Mingguan</a></h5>
        <div style="display: none;" class="toggle-content">
        <p>  </p>
        </div>
    </div>
	<div class="toggle-frame">
        <h5 class="toggle"><a href="#">Grafik Bulanan</a></h5>
        <div style="display: none;" class="toggle-content">
        <p>  </p>
        </div>
    </div>
	<div class="toggle-frame">
        <h5 class="toggle"><a href="#">Grafik Semesteran</a></h5>
        <div style="display: none;" class="toggle-content">
        <p>  </p>
        </div>
    </div>
	<div class="toggle-frame">
        <h5 class="toggle"><a href="#">Grafik Tahunan</a></h5>
        <div style="display: none;" class="toggle-content">
        <p>  </p>
        </div>
    </div>-->

	<!-- iklan batas -->
	<!-- end iklan batas -->	
	<!--<div class="clear"></div>
	<h3> AGENDA KEPALA SEKOLAH</h3>
	<div class="hr"></div>
	<div class="toggle-frame">
        <h5 class="toggle"><a href="#">Agenda Kepala Sekolah</a></h5>
        <div style="display: none;" class="toggle-content">
        <p>  </p>
        </div>
    </div>-->


</div>
        