<?=$this->load->view('akademik/mainakademik/topindex')?>		

	<div class="clear"></div>

	<? $guru=$this->auth->array_searchRecursive( 13, $group, $strict=false, $path=array() );
		if(!empty($guru)){
	?>
	<div class="notifak column content content-full-width">
        <h3 class="float-left"> NOTIFIKASI </h3>   
		<div class="hr"></div>
		<br style="clear:both;">
        <div class="toggle-frame">
            <h5 class="toggle-accordion"><a >Pemberitahuan terahir</a></h5>
            <div style="display: block; max-height:400px;" class="toggle-content">
				<? timelineakademik();?>
			</div>
        </div>                  
    </div>	
	<? aktifitasakademik($this->session->userdata['user_authentication']['id_pengguna'],'guru',5);?>
	<h3 id="guru"> Notifikasi SMS hari ini </h3>
	<div class="hr"></div>
	<div class="tabs-container">
		<div class="tabs-frame-content" id="smsnotifikasi" style="display: block;"></div>
	</div>

	
	<h3 id="guru"> Pembelajaran </h3>

	<div class="hr"></div>
	<div class="tabs-container" id="tabpembelajaran">

		<ul class="tabs-frame">
			<!--<li>
				<a  class="current">RPP</a>
			</li>-->
			<li>
				<a >Pembelajaran</a>
			</li>
			<li>
				<a  id="tababsensi" >Presensi</a>
			</li>
			<li>
				<a  id="tabarekapbsensi" >Rekap Presensi</a>
				<!--<a class="modal" href="<?=base_url('akademik/absensi/rekapabsensi')?>" >Rekap Absensi</a>-->
			</li>
			<li>
				<a  id="pembtabtitleujian">Ujian</a>
			</li>
			<li>
				<a id="pembtabtitlenilai">Nilai</a>
			</li>
		</ul>
		

		<!--<div class="tabs-frame-content back_berita" style="display: block;">
            <a class="readmore modalbuatrpp" title="" tab="perencanaan" id="buatrpp" href="<? echo base_url();?>akademik/perencanaan/addpertemuan"> <b>BUAT <br /> RPP</b> </a>
            <a class="readmore" title="" tab="perencanaan" id="pertemuan" href=""> Pertemuan Pembelajaran </a>
            <a class="readmore" title="" tab="perencanaan" id="pembelajaran" href=""> Rencana Pembelajaran </a> 
            <a class="readmore" title="" tab="perencanaan" id="timelinepembelajaran" href=""> Timeline Pembelajaran </a>
		</div>-->
		<div class="tabs-frame-content" style="display: none;">
			<a class="readmore" tab="pembelajaran" id="materi_pelajaran" title="" > Materi </a>
			<!--<a class="readmore" tab="pembelajaran" id="daftar_pr"  title=""> Pekerjaan<br />Rumah</a>-->
			<a class="readmore" tab="pembelajaran"   id="daftar_tugas" title=""  > Tugas </a>
			<br id="brsubject"  tab="pembelajaran"  class="clear" />
            <div id="subject"></div>
		</div>
		<div class="tabs-frame-content" id="absensi" style="display: none; "></div>
		<div class="tabs-frame-content" id="rekapbsensi" style="display: none;"></div>
		<div class="tabs-frame-content" id="tpembelajaranujian" style="display:">
			<a class="readmore" title="" href="" tab="ujian" id="daftar_harian"> Ujian<br /> Harian </a>
            <a class="readmore" title="" href="" tab="ujian" id="daftar_uts"> Ujian<br /> Tengah Semester </a>
            <a class="readmore" title="" href="" tab="ujian" id="daftar_uas"> Ujian<br /> Akhir Semester </a>
		</div>
		<div class="tabs-frame-content" id="tpembelajarannilai" style="display: none;">
				<!--<a class="readmore" title="" tab="nilai" href="" id="<?=base64_encode('nilai pr');?>">Penilaian<br /> PR </a>-->
				<a class="readmore" title="" tab="nilai"  href="" id="<?=base64_encode('nilai tugas');?>">Penilaian<br /> Tugas  </a>
				<a class="readmore" title="" tab="nilai"  href="" id="<?=base64_encode('nilai ulangan harian');?>">Penilaian<br /> UL harian  </a>
				<a class="readmore" title="" tab="nilai"  href="" id="<?=base64_encode('nilai uts');?>">Penilaian<br /> UTS </a>
				<a class="readmore" title="" tab="nilai"  href="" id="<?=base64_encode('nilai uas');?>">Penilaian<br /> UAS </a>
				<a class="readmore" title="" tab="nilai"  href="" id="<?=base64_encode('nilai uan');?>"> Penilaian<br /> UAN </a>
				<a class="readmore" title="" tab="nilai"  href="" id="ekstrakurikulerwalikelas"> Pengembangan<br /> Diri </a>
				<!--<a class="readmore" title="" tab="nilai"  href="" id="<?=base64_encode('nilai praktik');?>">Penilaian<br /> Praktik </a>
				<a class="readmore" title="" tab="nilai"  href="" id="<?=base64_encode('nilai psikomotorik');?>">Penilaian<br /> Psikomotorik </a>
				<a class="readmore" title="" tab="nilai"  href="" id="<?=base64_encode('nilai afektif');?>">Penilaian<br /> Afektif </a>-->
				
				<!--<a class="readmore" title="" tab="nilai"  href="" id="psikomotorik">Penilaian<br /> Psikomotorik telkom </a>
				<a class="readmore" title="" tab="nilai"  href="" id="afektif">Penilaian<br /> Afektif  telkom</a>
				
				<a class="readmore" title="" tab="nilai"  href="" id="<?=base64_encode('nilai praktik');?>">Penilaian<br /> praktik </a>
				<a class="readmore" title="" tab="nilai"  href="" id="<?=base64_encode('nilai kompetensi');?>"> Deskripsi<br /> Kemajuan Belajar </a>-->
				<a class="readmore" title="" tab="nilai" id="rekapitulasinilai" href=""> Rekapitulasi<br /> Nilai </a>
		</div>
	</div>
	

	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
	<!-- text smartphone & computer -->
	<ins class="adsbygoogle"
		 style="display:inline-block;width:236px;height:80px"
		 data-ad-client="ca-pub-5804160032970255"
		 data-ad-slot="3330651926"></ins>
	<script>
	(adsbygoogle = window.adsbygoogle || []).push({});
	</script>
	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
	<!-- text smartphone & computer -->
	<ins class="adsbygoogle"
		 style="display:inline-block;width:236px;height:80px"
		 data-ad-client="ca-pub-5804160032970255"
		 data-ad-slot="3330651926"></ins>
	<script>
	(adsbygoogle = window.adsbygoogle || []).push({});
	</script>
	
	
	<? } ?>
	<!-- iklan batas -->
	<!-- end iklan batas -->	
	<script>
		$(document).ready(function() { 
			<? $ortu=$this->auth->array_searchRecursive( 14, $group, $strict=false, $path=array() );
				if(!empty($ortu)){
			?>
				$('#penghubungortu').load('<?=base_url('siswa/jurnalwalikelas/penghubungortu')?>');
			<?}else{?>
				$('#penghubungortu').load('<?=base_url('akademik/penghubungortutk/penghubungortu')?>');
			<? } ?>
		});
	</script>
	<div id="penghubungortu" style="clear:both;"></div>
	<div class="clear"></div>
	<? $ekstra=$this->auth->array_searchRecursive( 20, $group, $strict=false, $path=array() );
		if(!empty($ekstra)){
	?>
	<script>
		$(document).ready(function() {
			$('#nilaiekstrapembina').load('<?=base_url('akademik/nilaiekstrakurikuler/pembinaextra')?>');
		});
	</script>
	<h3 id="PembinaEkstrakurikuler"> Pengembangan diri </h3>

	<div class="hr"></div>
	<div class="tabs-container">
		<div class="tabs-frame-content"  id="nilaiekstrapembina">
			
		</div>
	</div>
	<? } ?>

	<div class="clear"></div>
	<? if(!empty($kelaswali)){?>
	<? //laporanakademik($this->session->userdata['user_authentication']['id_pengguna'],'guru',5);?>
	<h3 id="WaliKelas"> Prestasi </h3>
	<div class="hr"></div>
	<div class="tabs-container">

		<ul class="tabs-frame">
			<li>
				<a class="current" >Prestasi</a>
			</li>
			<li>
				<a  id="hportutab">Daftar Resident</a>
			</li>
			<!--<li>
				<a  id="jurnaltab">Jurnal</a>
			</li>
			<li>
				<a  id="tababsensi" >Preview</a>
			</li>
			<li>
				<a >Kenaikan & Kelulusan</a>
			</li>-->
		</ul>
		<div class="tabs-frame-content" style="display: none;">
			<!--<a class="readmore" tab="wali_input" id="kepribadian" title="" > Kepribadian </a>-->
			<a class="readmore" tab="wali_input" id="prestasi" title="" >Input Prestasi </a>
			<!--<a class="readmore" title="" tab="nilai" href="" id="<?=base64_encode('nilai lain_lain');?>">Lain-Lain </a>-->
		</div>
		<div class="tabs-frame-content" id="hportu" style="display: block;">
           
		</div>
		<!--<div class="tabs-frame-content" id="jurnal" style="display: block;">
            <a class="readmore" tab="wali_jurnal" id="daftar_jurnal" title="" > Daftar <br /> Jurnal </a>
			<a class="readmore" tab="wali_jurnal" id="buat_jurnal" title="" > Buat <br /> Jurnal </a>
		</div>-->
		<!--<div class="tabs-frame-content" id="absensi" style="display: none;">
			<a class="readmore" tab="wali_preview" id="ekstrakurikuler" title="" > Ekstrakurikuler <br /> Siswa </a>
			<a class="readmore" tab="wali_preview" id="kegiatan_sekolah" title="" > Pengembangan <br /> Diri </a>
		</div>-->
		<div class="tabs-frame-content" style="display: none;">
				<div id="contentpage">
				<table class="tabelfilter">
					<tbody>
						<tr>
							<td>
								Kelas :
								<select class="selectfilter" id="kelaskenaikan" name="id_kelaskenaikan">
									<option value="0">Pilih Kelas</option>
									<? foreach($kelaswali as $datakelas){?>
										<option <? if(@$_POST['kelas']==$datakelas['id']){echo 'selected';}?> value="<?=$datakelas['id']?>"><?=$datakelas['kelas']?><?=$datakelas['nama']?></option>
									<? } ?>
								</select>					
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div  id="kenaikankelulusanload"></div>
		</div>
		
	</div>
	
	<? } ?>
	<div class="clear"></div>

	
    <div class="hr "></div>


	<!-- iklan batas -->
	<!-- end iklan batas -->	
	<div class="clear"></div>
	<?//=jadwal();?>
	
    <div class="hr "></div>

</div>
<!-- END MAIN FRONT END -->
        