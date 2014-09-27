<?=$this->load->view('akademik/mainakademik/topindex')?>		

	<div class="clear"></div>

	<? $guru=$this->auth->array_searchRecursive( 13, $group, $strict=false, $path=array() );
		if(!empty($guru)){
	?>
	
	<h3 id="guru"> Notifikasi SMS hari ini</h3>
	<div class="hr"></div>
	<div class="tabs-container">
		<div class="tabs-frame-content" id="smsnotifikasi" style="display: block;"></div>
	</div>

	
	<h3 id="guru"> Pembelajaran </h3>

	<div class="hr"></div>
	<div class="tabs-container">

		<ul class="tabs-frame">
			<!--<li>
				<a  class="current">RPP</a>
			</li>-->
			<li>
				<a >Pembelajaran</a>
			</li>
			<li>
				<a  id="tababsensi" >Absensi</a>
			</li>
			<li>
				<a  id="tabarekapbsensi" >Rekap Absensi</a>
			</li>
			<li>
				<a >Ujian</a>
			</li>
			<li id="tabpertlist" tab="evaluasi">
				<a >Evaluasi Otentik</a>
			</li>
			<li>
				<a >Penilaian Deskriptif</a>
			</li>
			<li>
				<a >Nilai</a>
			</li>
		</ul>
		

		<!--<div class="tabs-frame-content back_berita" style="display: block;">
            <a class="readmore modalbuatrpp" title="" tab="perencanaan" id="buatrpp" href="<? echo base_url();?>akademik/perencanaan/addpertemuan"> <b>BUAT <br /> RPP</b> </a>
            <a class="readmore" title="" tab="perencanaan" id="pertemuan" href=""> Pertemuan Pembelajaran </a>
            <a class="readmore" title="" tab="perencanaan" id="pembelajaran" href=""> Rencana Pembelajaran </a> 
            <a class="readmore" title="" tab="perencanaan" id="timelinepembelajaran" href=""> Timeline Pembelajaran </a>
		</div>-->
		<div class="tabs-frame-content" style="display: none;">
			<a class="readmore" tab="pembelajaran" id="materi_pelajaran" title="" > Materi<br />Pelajaran </a>
			<a class="readmore" tab="pembelajaran" id="daftar_pr"  title=""> Pekerjaan<br />Rumah</a>
			<a class="readmore" tab="pembelajaran"   id="daftar_tugas" title=""  > Tugas<br />Sekolah </a>
			<br id="brsubject"  tab="pembelajaran"  class="clear" />
            <div id="subject"></div>
		</div>
		<div class="tabs-frame-content" id="absensi" style="display: none;"></div>
		<div class="tabs-frame-content" id="rekapbsensi" style="display: none;"></div>
		<div class="tabs-frame-content" style="display: none;">
			<a class="readmore" title="" href="" tab="ujian" id="daftar_harian"> Ulangan<br /> Harian </a>
            <a class="readmore" title="" href="" tab="ujian" id="daftar_uts"> Ujian<br /> Tengah Semester </a>
            <a class="readmore" title="" href="" tab="ujian" id="daftar_uas"> Ujian<br /> Akhir Semester </a>
		</div>
		<div class="tabs-frame-content" id="tabpertlistcnt" style="display: none;">
			<h3>Evaluasi Otentik</h3>
			<div class="hr"></div>
			<a class="readmore" title="" tab="evaluasi" id="addpertemuan"> Buat <br> Evaluasi </a>
			<a class="readmore" title="" tab="evaluasi" id="datapertemuan"> Scoring <br> Evaluasi </a>
		</div>
		<div class="tabs-frame-content"  style="display: none;">
				<a class="readmore" title="" tab="otentik" href="" id="<?=base64_encode('kognitif');?>" >Nilai<br /> Kognitif </a>
				<a class="readmore" title="" tab="otentik" href="" id="<?=base64_encode('afektif');?>" >Nilai<br /> Afektif </a>
				<a class="readmore" title="" tab="otentik" href="" id="<?=base64_encode('portofolio');?>" >Record<br /> Portofolio </a>
				<a class="readmore" title="" tab="otentik" href="" id="<?=base64_encode('psikomotorik');?>">Nilai<br /> Psikomotorik</a>
		</div>
		<div class="tabs-frame-content"  style="display: none;">
				<a class="readmore" title="" tab="nilai" href="" id="<?=base64_encode('nilai pr');?>">Penilaian<br /> PR </a>
				<a class="readmore" title="" tab="nilai"  href="" id="<?=base64_encode('nilai tugas');?>">Penilaian<br /> Tugas  </a>
				<a class="readmore" title="" tab="nilai"  href="" id="<?=base64_encode('nilai ulangan harian');?>">Penilaian<br /> UL harian  </a>
				<a class="readmore" title="" tab="nilai"  href="" id="<?=base64_encode('nilai uts');?>">Penilaian<br /> UTS </a>
				<a class="readmore" title="" tab="nilai"  href="" id="<?=base64_encode('nilai uas');?>">Penilaian<br /> UAS </a>
				<a class="readmore" title="" tab="nilai"  href="" id="<?=base64_encode('nilai uan');?>"> Penilaian<br />UAN </a>
				<a class="readmore" title="" tab="nilai"  href="" id="<?=base64_encode('nilai praktik');?>">Penilaian<br /> Psikomotorik </a>
				<a class="readmore" title="" tab="nilai"  href="" id="<?=base64_encode('nilai afektif');?>">Penilaian<br /> Afektif </a>
				
				<!--<a class="readmore" title="" tab="nilai"  href="" id="psikomotorik">Penilaian<br /> Psikomotorik telkom </a>
				<a class="readmore" title="" tab="nilai"  href="" id="afektif">Penilaian<br /> Afektif  telkom</a>
				
				<a class="readmore" title="" tab="nilai"  href="" id="<?=base64_encode('nilai kompetensi');?>"> Penilaian<br /> Kompetensi </a>
				<a class="readmore" title="" tab="nilai"  href="" id="<?=base64_encode('nilai praktik');?>">Penilaian<br /> praktik </a>
				<a class="readmore" title="" tab="nilai" id="rekapitulasinilai" href=""> Rekapitulasi<br /> Nilai </a>-->
		</div>
	</div>
	
	
	<h3 id="guru"> Administrasi </h3>

	<div class="hr"></div>
	<div class="tabs-container">
		<ul class="tabs-frame">
			<li>
				<a >Preview</a>
			</li>
			<li>
				<a >Program Pengajaran</a>
			</li>
			<li>
				<a >Analisis</a>
			</li>
			<li>
				<a >Catatan</a>
			</li>
			<li>
				<a >Informasi</a>
			</li>
		</ul>
		<div class="tabs-frame-content" style="display: none;">
			<a class="readmore" tab="administrasi" id="kalender_pendidikan" title="" >Kalender<br />pendidikan</a>
			<a class="readmore" tab="administrasi" id="daftar_nilai" title="" >Daftar<br />nilai</a>
			<a class="readmore" tab="administrasi" id="daftar_hadir" title="" >Daftar<br /> hadir </a>
			<a class="readmore" tab="administrasi" id="soal_ulangan" title="" >Soal-soal ulangan</a>
			<a class="readmore" tab="administrasi" id="laporan_penilaian" title="" >Penilaian<br />akhlak</a>
			<a class="readmore" tab="administrasi" id="tugas_mandir" title="" >Tugas<br />mandiri</a>
			<a class="readmore" tab="administrasi" id="Jadwal_pelajaran" title="" >Jadwal pelajaran</a>
			<a class="readmore" tab="administrasi" id="program_pelaksanaan_perbaikan" title="" >Program<br />Perbaikan</a>
			<a class="readmore" tab="administrasi" id="program_pelaksanaan_pengayaan" title="" >Program<br />Pengayaan</a>
			<a class="readmore" tab="administrasi" id="tugas_terstruktur" title="" >Tugas <br />Terstruktur</a>
		</div>
		<div class="tabs-frame-content" style="display: none;">
			<a class="readmore" tab="administrasi" id="rpp" title="" >Rencana<br />Pembelajaran</a>
			<a class="readmore" tab="administrasi" id="rph"  title="">Rencana Pelaksanaan<br />Harian</a>
			<a class="readmore" tab="administrasi" id="silabus"  title="">Silabus</a>
			<a class="readmore" tab="administrasi" id="program_tahunan"  title="">Program<br />Tahunan</a>
			<a class="readmore" tab="administrasi" id="program_semester"  title="">Program<br />Semester</a>
			<a class="readmore" tab="administrasi" id="buku_pelaksanaan_harian"  title="">Buku Pelaksanaan<br />Harian</a>
			<a class="readmore" tab="administrasi" id="buku_pegangan"  title="">Buku<br />Pegangan</a>
		</div>
		<div class="tabs-frame-content" style="display: none;">
			<a class="readmore" tab="administrasi" id="kkm" title="" >Analisis<br />KKM</a>
			<a class="readmore" tab="administrasi" id="kisi_kisi_soal"  title="">Kisi-Kisi<br />Soal</a>
			<a class="readmore" tab="administrasi" id="analisis_butir_soal"  title="">Analisis Butir<br />Soal</a>
			<a class="readmore" tab="administrasi" id="analisis_hasil_ulangan"  title="">Analisis Hasil<br />Ulangan</a>
		</div>
		<div class="tabs-frame-content" style="display: none;">
			<a class="readmore" tab="administrasi" id="catatatan_hambatan_belajar" title="" >Catatan Hambatan<br />Belajar</a>
			<a class="readmore" tab="administrasi" id="buku_kemajuan_kelas"  title="">Buku Kemajuan<br />Kelas</a>
		</div>
		<div class="tabs-frame-content" style="display: none;">
			<a class="readmore" tab="administrasi" id="buku_informasi_penilaian" title="" >Buku Informasi<br />Penilaian</a>
			<a class="readmore" tab="administrasi" id="daftar_pengembalian_hasil_ulangan"  title="">Daftar Pengembalian<br />Hasil Ulangan</a>
		</div>
	</div>
	
	
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
				$('#penghubungortu').load('<?=base_url('akademik/jurnalwali/penghubungortu')?>');
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
			$('#nilaiekstra').load('<?=base_url('akademik/nilaiekstrakurikuler/index')?>');
		});
	</script>
	<h3 id="PembinaEkstrakurikuler"> Ekstrakurikuler </h3>

	<div class="hr"></div>
	<div class="tabs-container">
		<div class="tabs-frame-content"  id="nilaiekstra">
			
		</div>
	</div>
	<? } ?>
	<!-- iklan batas -->
	<!-- end iklan batas -->
	
	<div class="clear"></div>
	<? $ekstra=$this->auth->array_searchRecursive( 21, $group, $strict=false, $path=array() );
		if(!empty($ekstra)){
	?>
	<script>
		$(document).ready(function() {
			$('#nilaikegiatan').load('<?=base_url('akademik/nilaikegiatansekolah/kesiswaanindex')?>');
		});
	</script>
	<h3 id="PembinaKesiswaan"> Pembinaan Kesiswaan </h3>

	<div class="hr"></div>
	<div class="tabs-container">

		<ul class="tabs-frame">
			<li>
				<a>Nilai Kegiatan / Pengembangan Diri</a>
			</li>
		</ul>
		
		<div class="tabs-frame-content" style="display: none;" id="nilaikegiatan">
			
		</div>
	</div>
	<? } ?>
	<!-- iklan batas -->
	<!-- end iklan batas -->	
	<?// pr($kelaswali);?>

	<div class="clear"></div>
	<? if(!empty($kelaswali)){?>
	<? //laporanakademik($this->session->userdata['user_authentication']['id_pengguna'],'guru',5);?>
	<h3 id="WaliKelas"> WALI KELAS </h3>
	<div class="hr"></div>
	<div class="tabs-container">

		<ul class="tabs-frame">
			<li>
				<a class="current" >Input</a>
			</li>
			<li>
				<a  id="hportutab">Hp Ortu</a>
			</li>
			<li>
				<a  id="jurnaltab">Jurnal</a>
			</li>
			<!--<li>
				<a  id="tababsensi" >Preview</a>
			</li>-->
			<li>
				<a >Kenaikan Kelas & Kelulusan</a>
			</li>
		</ul>
		<div class="tabs-frame-content" style="display: none;">
			<a class="readmore" tab="wali_input" id="kepribadian" title="" > Kepribadian </a>
			<a class="readmore" tab="wali_input" id="prestasi" title="" > Prestasi </a>
			<a class="readmore" title="" tab="nilai" href="" id="<?=base64_encode('nilai lain_lain');?>">Lain-Lain </a>
		</div>
		<div class="tabs-frame-content" id="hportu" style="display: block;">
           
		</div>
		<div class="tabs-frame-content" id="jurnal" style="display: block;">
            <!--<a class="readmore" tab="wali_jurnal" id="daftar_jurnal" title="" > Daftar <br /> Jurnal </a>
			<a class="readmore" tab="wali_jurnal" id="buat_jurnal" title="" > Buat <br /> Jurnal </a>-->
		</div>
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
	
	<!-- iklan batas -->
	<!-- end iklan batas -->	
	
	<div class="clear"></div>
	<h3> Raport </h3>
	<div class="hr"></div>

	<div id="contentpage">
		<table class="tabelfilter">
			<tbody>
				<tr>
					<td>
						Kelas :
						<select class="selectfilter" id="kelasraport" name="id_kelas">
							<option value="">Pilih Kelas</option>
							<? foreach($kelaswali as $datakelas){?>
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
	<? } ?>
	<div class="clear"></div>

	
    <div class="hr "></div>
    <div class="content content-full-width" style="color: white;background: #CDCDCD;padding-top:40px;padding-bottom: 40px;">
        <div class="text_iklan">SPACE IKLAN</div>
         <p>Mengenang Iklan Sepanjang Masa</p>
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

</div><!-- portfolio column-one-half-with-sidebar -->


		<!-- END MAIN FRONT END -->
        