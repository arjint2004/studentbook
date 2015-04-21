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
					data: 'bk=true&jenis='+jenis+'&idload='+load,
					url: url,
					beforeSend: function() {
						$(self).after("<img id='wait' style='margin: 0px; position: relative; right: 324px; bottom: 21px;'  src='<?=$this->config->item('images').'loading.png';?>' />");
					},
					success: function(msg) {
						$("#wait").remove();
						$("#"+load).html(msg);
					}
			});	
		}
	}
	
    $(function(){
		$("select#id_kelaslain2").change(function(e){
						$.ajax({
							type: "POST",
							data: 'id_kelas='+$(this).val()+'&jenis=nilai+lain_lain&ajax=1&pelajaran=0',
							url: '<?=base_url()?>akademik/nilai/getsubject/'+$(this).val(),
							beforeSend: function() {
								$("#filterpelajaran select#kelas").after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
								$("#subjectlist table.tabelkelas tbody").html("");
							},
							success: function(msg) {
								$("#wait").remove();
								$("#lainlainloadx").html(msg);	
								$("div#lainlainloadx div.tabs-vertical-container div.tabs-vertical-frame-content div.actedit").remove();
								$("div#lainlainloadx div.tabs-vertical-container div.tabs-vertical-frame-content div.actdell").remove();
							}
						});
						return false;
					});//Submit End
    });
</script>
<style>
div#subjectlistbysiswabk form table#point tr td div span.arrow-n{
	bottom: 17px;
	left: 39px;
}
div#subjectlistbysiswabk form table#point tr td div span.arrow-s{
	left: 39px;
	top: 17px;
}
</style>
<div class="one-full">
                    <!-- **Team** -->
                    <div class="team">          
                        <div class="image"> <img title="" alt="" src="<?=base_url($user->foto)?>"> </div>
                        <h5> <?=$user->nama?> (Guru BK)</h5>
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
    <div class="hr "></div>
    <div class="content content-full-width" style="color: white;background: #CDCDCD;padding-top:40px;padding-bottom: 40px;">
        <div class="text_iklan">SPACE IKLAN</div>
         <p>Mengenang Iklan Sepanjang Masa</p>
    </div>

	<div class="clear"></div>
	<h3></h3>
	<div class="hr"></div>
	<div id="buttonasbin" class="buttonasbin tabs-frame-content back_berita fixed">
			<div style="width:158px;" class="readmorenoplus" title="" onclick="window.location='<?=base_url('akademik/mainakademik/index')?>'">Akademik</div>
			<div style="width:158px;" class="readmorenoplus" title="" onclick="window.location='<?=base_url('sos/pegawai/pertemanan')?>'">Jejaring Sosial</div>
			<div style="width:158px;" class="readmorenoplus" title="" onclick="$('#absensi').scrollintoview({ speed:'1100'});">Absensi</div>
			<div style="width:158px;" class="readmorenoplus" title="" onclick="$('#nilai').scrollintoview({ speed:'1100'});">Nilai</div>
			<div style="width:158px;" class="readmorenoplus" title="" onclick="$('#catatan').scrollintoview({ speed:'1100'});">Catatan Guru</div>
			<div style="width:158px;" class="readmorenoplus" title="" onclick="$('#kepribadian').scrollintoview({ speed:'1100'});">Kepribadian Siswa</div>
			<div style="width:158px;" class="readmorenoplus" title="" onclick="$('#raportx').scrollintoview({ speed:'1100'});">Raport</div>
			<div style="width:158px;" class="readmorenoplus" title="" onclick="$('#naiklulus').scrollintoview({ speed:'1100'});">Kenaikan/Kelulusan</div>
			<div style="width:158px;" class="readmorenoplus" title="" onclick="$('#lainlain').scrollintoview({ speed:'1100'});">Lain-Lain</div>
	</div>
	<!-- iklan batas -->
	<!-- end iklan batas -->	
	<div class="clear"></div>
	<h3 id="absensi"> ABSENSI </h3>
	<div class="hr"></div>
	<div class="toggle-frame">
        <h5 class="toggle"><a onclick="ajax(this,'<?=base_url()?>akademik/bk/absensifilter','absensiloadx','<?=base64_encode('akademik/absensi/add')?>');" href="#">Absensi Siswa</a></h5>
        <div style="display: none;" class="toggle-content" id="absensiloadx">
        </div>
    </div>
	
	<!-- iklan batas -->
	<!-- end iklan batas -->	
	<div class="clear"></div>
	<h3 id="nilai"> DATA NILAI </h3>
	<div class="hr"></div>
	<div class="toggle-frame">
        <h5 class="toggle"><a href="#" onclick="ajax(this,'<?=base_url()?>akademik/bk/filter','nilailist','<?=base64_encode('akademik/rekapnilai/rekapnilailist')?>');">Nilai Siswa</a></h5>
        <div style="display: none;" class="toggle-content" id="nilailist">
        <p>  </p>
        </div>
    </div>
	<div class="toggle-frame" id="raportx">
		<?=$this->load->view('akademik/bk/js')?>
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
	<h3 id="naiklulus"> DATA KENAIKAN / KELULUSAN </h3>
	<div class="hr"></div>
	<div class="toggle-frame">
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
	<h3 > DATA EVALUASI </h3>
	<div class="hr"></div>
	<div class="toggle-frame" id="catatan">
        <h5 class="toggle"><a href="#"  onclick="ajax(this,'<?=base_url()?>akademik/bk/catatangurufilter','catatanguru','<?=base64_encode('akademik/catatanguru/catatangurulist')?>');">Catatan Guru</a></h5>
        <div style="display: none;" class="toggle-content" id="catatanguru">
        </div>
    </div>
	<div class="toggle-frame" id="kepribadian">
        <h5 class="toggle"><a href="#" onclick="ajax(this,'<?=base_url()?>akademik/bk/filterbysiswa','kepribadianloadx','<?=base64_encode('akademik/kepribadian/kepribadianlist')?>');">Kepribadian Siswa</a></h5>
        <div style="display: none;" class="toggle-content" id="kepribadianloadx">
        <p>  </p>
        </div>
    </div>
	<div class="toggle-frame" id="lainlain">
        <h5 class="toggle"><a href="#" >Lain-Lain</a></h5>
        <div style="display: none;" class="toggle-content" >
        <table class="tabelfilter">
			<tbody>
				<tr>
					<td>
						Kelas :
						<select id="id_kelaslain2" class="selectfilter" name="id_kelas">
							<option value="">Pilih Kelas</option>
							<? foreach($kelas as $datakelas){?>
								<option <? if(@$_POST['kelas']==$datakelas['id']){echo 'selected';}?> value="<?=$datakelas['id']?>"><?=$datakelas['kelas']?><?=$datakelas['nama']?></option>
							<? } ?>
						</select>		
					</td>
				</tr>
			</tbody>
			</table>
			<div  id="lainlainloadx"></div>
        </div>
    </div>



</div>
        