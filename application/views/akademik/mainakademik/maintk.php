<?=$this->load->view('akademik/mainakademik/topindex')?>		

	<div class="clear"></div>

	<? $guru=$this->auth->array_searchRecursive( 13, $group, $strict=false, $path=array() );
		if(!empty($guru)){
	?>
	
	<h3 id="guru"> Notifikasi SMS hari ini </h3>
	<div class="hr"></div>
	<div class="tabs-container">
		<div class="tabs-frame-content" id="smsnotifikasi" style="display: block;"></div>
	</div>

	
	<h3 id="guru"> Absensi </h3>

	<div class="hr"></div>
	<div class="tabs-container" id="tabpembelajaran">

	<script>
		$(document).ready(function() { 
				$.ajax({
					type: "GET",
					data: '',
					url: '<?=base_url('akademik/absensi')?>',
					beforeSend: function() {
						$('#tababsensi').append("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
					},
					success: function(msg) {
						$("#wait").remove();			
						$("#absensi").html(msg);
					}
				});
		});
	</script>
		<ul class="tabs-frame">
			<li>
				<a  id="tababsensi" >Absensi</a>
			</li>
			<li>
				<a  id="tabarekapbsensi" >Rekap Absensi</a>
				<!--<a class="modal" href="<?=base_url('akademik/absensi/rekapabsensi')?>" >Rekap Absensi</a>-->
			</li>
			<!--<li id="tabpertlist" tab="evaluasi">
				<a >Evaluasi Otentik</a>
			</li>
			<li>
				<a >Penilaian Deskriptif</a>
			</li>-->
		</ul>


		<div class="tabs-frame-content" id="absensi" style="display: none; "></div>
		<div class="tabs-frame-content" id="rekapbsensi" style="display: none;"></div>
		<!--<div class="tabs-frame-content" id="tabpertlistcnt" style="display: none;">
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
		</div>-->
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
				$('#penghubungortu').load('<?=base_url('akademik/penghubungortutk/penghubungortu')?>');
			<? } ?>
		});
	</script>
	<div id="penghubungortu" style="clear:both;"></div>


	<div class="clear"></div>
	<? if(!empty($kelaswali)){?>
	<? //laporanakademik($this->session->userdata['user_authentication']['id_pengguna'],'guru',5);?>
	<h3 id="WaliKelas"> WALI KELAS </h3>
	<div class="hr"></div>
	<div class="tabs-container">

		<ul class="tabs-frame">
			<li>
				<a class="current" >Prestasi</a>
			</li>
			<li>
				<a  id="hportutab">Biodata Siswa</a>
			</li>
			<li>
				<a >Kenaikan Kelas & Kelulusan</a>
			</li>
		</ul>
		<div class="tabs-frame-content" style="display: none;">
			<!--<a class="readmore" tab="wali_input" id="kepribadian" title="" > Kepribadian </a>-->
			<a class="readmore" tab="wali_input" id="prestasi" title="" >Input Prestasi </a>
			<!--<a class="readmore" title="" tab="nilai" href="" id="<?=base64_encode('nilai lain_lain');?>">Lain-Lain </a>-->
		</div>
		<div class="tabs-frame-content" id="hportu" style="display: block;">
           
		</div>

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
	
	<div class="clear"></div>
	<h3> Raport </h3>
	<div class="hr"></div>

	<div id="contentpage">
		<table class="tabelfilter">
			<tbody>
				<tr>
					<td>
						Kelas :
						<select class="selectfilter" id="kelasraport2013" name="id_kelas">
							<option value="">Pilih Kelas</option>
							<? foreach($kelaswali as $datakelas){?>
								<option <? if(@$_POST['kelas']==$datakelas['id']){echo 'selected';}?> value="<?=$datakelas['id']?>"><?=$datakelas['kelas']?><?=$datakelas['nama']?></option>
							<? } ?>
						</select>		
						<div id="raport2013"></div>
					</td>
				</tr>
			</tbody>
		</table>
	</div>	
	
	<? } ?>


</div>